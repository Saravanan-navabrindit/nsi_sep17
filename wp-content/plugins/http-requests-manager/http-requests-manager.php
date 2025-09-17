<?php

/*
  Plugin Name: HTTP Requests Manager
  Plugin URI:   https://veppa.com/http-requests-manager/
  Description: Limit, Debug, Optimize WP_HTTP requests. Limit by request count, page load time, reduce timeout for each request. Speed up login and admin pages.
  Version: 1.3.8
  Author: veppa
  Author URI: https://veppa.com/
  Text Domain:	http-requests-manager
  Domain Path: /languages
  Requires at least: 4.7
  License:      GPL2

  Copyright 2023 veppa

  This program is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License
  as published by the Free Software Foundation; either version 2
  of the License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, see <http://www.gnu.org/licenses/>.
 */

/**
 *  
 * TODO:
  - add blocking by theme
  - add blocking by core function
  - safe-mode: show instruction about safe mode and operation mode on beginning. after dismissed move note to bottom.
  - [maybe] group prevent enclosure checks and pingbacks. write 1 log instead of 50+
  - optimization: define hooks only for selected mode and logging combination. define hooks granularly.

 * 
 * NOT POSSIBLE: 
  -- disable all enclosure checks and rely only on file extension. (not possible, detection using ext done after getting positive response using WP_HTTP )
  -------------------------------------------
 * conflict test. 
 * 1) always monitor and log passively: 
  - add debug log:
  - on shutdown check if pre_http hook and capturing hook removed. add to debug log.
  - check if block_external constants predefined.
  - keep last 20 records
  - use passive logging. clear log after 5 days. if issue happens and log is cleared then record.
  if issue happens and already in log then do not log until log cleared. 1 day, 3 day or 5 day period is good.
  - do this because conflict may happen on any page any time. it is not once and for all conflict.
 * 2) pretest before switching operation mode. try 5 pages admin and frontend then show report passed and failed. 
 * 		- can be separate button to test before switching. 
 * 3) add safemode URL parameter to disable logging so user can switch to log only mode in case plugin conflict shows white screen of death. (otherwise user have to manually change plugin folder in order to disable blocking.)
  --------------------------------------------

  - [maybe] show noticifation if constants (WP_HTTP_BLOCK_EXTERNAL, WP_ACCESSIBLE_HOSTS) defined in config (not me) and conflicting with current operation mode.

  - when ajax called by plugin then do not block wp_HTTP by that plugin in smart block mode. example, cludflare plugin calls API 5+ times inside ajax call. updraft takes long to complete update via ajax call.
  - youtube video embed url when saved shows as empty url. why? it is reported as not secure on localhost.
  - when block all set and user navigates to plugins page show notification that operation mode prevents external requests.

  - show 47% requests blocked in dashboard at a glance. with option to remove from there.
  - delay and bulk write logs to speed up.
  -		- write first log to be safe
  -		- write after 2 second time
  -		- collected 10 logs
  -		- when log size reaches some big size
  -		- on shutdown

 */
defined('ABSPATH') or exit;

class HTTP_Requests_Manager
{

    const VERSION = '1.3.8';
    const ID = 'http-requests-manager';
    const TIMEOUT = 2;
    const DATA_TRUNCATE_LIMIT = 5000; // truncate response data if bigger than 6kb.  should always be (limit>=value)
    const DATA_TRUNCATE_VALUE = 3000; // truncate to 5kb. we do not need to see or store full (large) reponse. 

    public static $instance;
    public $start_time;
    private $pager_args;
    private static $init_done = false;

    /**
     * Holds the values to be used in the fields callbacks
     */
    private static $options;
    private static $modes;
    private static $request_time;
    private static $timer_before;
    private static $request_action;
    private static $request_action_info;
    private static $custom_rules_limit = 30;
    private static $page_id;
    private static $mu_plugin_file_name = '/a-http-requests-manager.php';
    private static $requests = array();
    private static $cron_status;
    private static $parsed_urls = array();
    private static $cp_arr = array();
    private static $page_info = array();
    public static $page_types = array(
        'frontend',
        'admin',
        'login',
        'cron',
        'ajax',
        'rest_api',
        'xmlrpc'
    );

    function __construct()
    {
        self::timer_float_start();

        // cp ony if logging is not disabled 
        if (!self::get_option('disable_logging'))
        {
            self::cp_init();
            add_action('shutdown', [$this, 'db_update_page']);
        }

        // setup variables
        // vrwhrm
        define('VPHRM_DIR', dirname(__FILE__));
        define('VPHRM_URL', plugins_url('', __FILE__));

        add_action('init', [$this, 'init']);
        add_filter('http_request_args', [$this, 'log_start_timer'], 10, 2);
        add_filter('pre_http_request', [$this, 'log_pre_http_request'], PHP_INT_MAX, 3);
        add_action('http_api_debug', [$this, 'db_capture_request'], 10, 5);
        add_action('vphrm_cleanup_cron', [$this, 'db_cleanup']);
        add_action('pre_get_ready_cron_jobs', [$this, 'cron_prevent_in_my_ajax']);

        // admin page actions only. for optimisation purpose these are used only on admin pages 
        if (is_admin())
        {
            add_action('admin_menu', [$this, 'admin_menu']);
            add_action('admin_enqueue_scripts', [$this, 'admin_scripts']);
            add_action('admin_notices', [$this, 'admin_notice_show']);
            add_filter('plugin_action_links', [$this, 'plugin_action_links'], 10, 2);
        }



        /* ajax actions add only in ajax page */
        if (self::current_page_is_my_ajax())
        {
            add_action('wp_ajax_vphrm_query', [$this, 'vphrm_query']);
            add_action('wp_ajax_vphrm_clear', [$this, 'vphrm_clear']);
            add_action('wp_ajax_vphrm_mode_change', [$this, 'vphrm_mode_change']);
            add_action('wp_ajax_vphrm_disable_logging', [$this, 'vphrm_disable_logging']);
            add_action('wp_ajax_vphrm_load_must_use', [$this, 'vphrm_load_must_use']);
            add_action('wp_ajax_vphrm_save_view', [$this, 'vphrm_save_view']);
            add_action('wp_ajax_vphrm_custom_rule_save', [$this, 'vphrm_custom_rule_save']);
            add_action('wp_ajax_vphrm_custom_rule_delete', [$this, 'vphrm_custom_rule_delete']);
        }



        // plugin uninstallation. ALWAYS USE STATIC METHOD
        register_uninstall_hook(__FILE__, ['HTTP_Requests_Manager', 'db_uninstall']);
        register_activation_hook(__FILE__, ['HTTP_Requests_Manager', 'plugin_activate']);
        register_deactivation_hook(__FILE__, ['HTTP_Requests_Manager', 'plugin_deactivate']);

        $this->manage();

        self::cp('HTTP_Requests_Manager->__construct');
    }

    public static function instance()
    {
        if (!isset(self::$instance))
        {
            self::$instance = new self;
        }
        return self::$instance;
    }

    function init()
    {
        self::$init_done = true;

        $this->db_upgrade();

        // single schedule is better and safe when plugin deactivated/uninstalled. 
        if (!wp_next_scheduled('vphrm_cleanup_cron'))
        {
            wp_schedule_single_event(time() + 86400, 'vphrm_cleanup_cron');
        }
    }

    /**
     * Prevent slowing down my ajax data loading. 
     * Works with wp > 5.1
     * 
     * @param type $return
     * @return type
     */
    function cron_prevent_in_my_ajax($return)
    {
        if (self::current_page_is_my_ajax())
        {
            // empty cron array 
            return array();
        }

        return $return;
    }

    /**
     * Check if current page is ajax request from my plugin
     * 
     * @return bool
     */
    static public function current_page_is_my_ajax()
    {
        $arr_my_ajax_actions = array(
            'vphrm_query'              => true,
            'vphrm_clear'              => true,
            'vphrm_disable_logging'    => true,
            'vphrm_load_must_use'      => true,
            'vphrm_save_view'          => true,
            'vphrm_custom_rule_save'   => true,
            'vphrm_custom_rule_delete' => true,
            'vphrm_mode'               => true,
            'vphrm_mode_change'        => true
        );

        $action = empty($_POST['action']) ? '' : sanitize_text_field($_POST['action']);

        if (wp_doing_ajax() && !empty($action) && !empty($arr_my_ajax_actions[$action]))
        {
            // ajax page with my own requet 
            return true;
        }

        return false;
    }

    /**
     * Prevent running cron before main page does other important actions. 
     * Take a note that cron tried to run.
     * 
     * @param array $return
     * @return array
     */
    function cron_prevent_early($return)
    {
        if (!is_null(self::$cron_status))
        {
            // we are managing cron (delay or prevent on slow pages)
            // should cron run now
            if (self::$cron_status !== 'safe_to_run')
            {
                // register cron to run on shutdown
                self::$cron_status = 'run_on_shutdown';

                // it is not shutdown (safe_to_run). prevent cron from running.
                return array();
            }


            // check page timer if it is safe to run by timer
            if (self::timer_float() > 3)
            {
                // this is slow page. prevent any cron from running.
                return array();
            }
        }

        return $return;
    }

    /**
     * Allow previously prevented cron to run in shutdown. 
     * also check if page time permits to run. page timer < 3 seconds.
     */
    function cron_prevent_early_shutdown()
    {
        // run if previously tried to run cron and page time permits to run 
        if (self::$cron_status === 'run_on_shutdown' && self::timer_float() < 3)
        {
            self::$cron_status = 'safe_to_run';
            wp_cron();
        }

        // now it is safe to run other not previously requested crons as well
        self::$cron_status = 'safe_to_run';
    }

    public static function db_prefix()
    {
        global $wpdb;

        return $wpdb->prefix . 'vphrm_';
    }

    /**
     * keep last 1k records. delete older records
     * 
     * @global type $wpdb
     * @return bool
     */
    function db_cleanup()
    {
        global $wpdb;

        /*
          $now = current_time('timestamp');
          $log_expiration_days = self::get_option('log_expiration_days', 1);
          $expires = date('Y-m-d H:i:s', strtotime('-' . $log_expiration_days . ' days', $now));
         */

        $limit = 1000;

        //get last page_id  after 1k records 
        $min_page_id = $wpdb->get_var("SELECT page_id FROM " . self::db_table_log() . " WHERE 1=1 ORDER BY id DESC LIMIT " . $limit . ",1");

        // make sure it is number
        $min_page_id = $min_page_id * 1;

        if (!empty($min_page_id))
        {
            // delete log table
            $wpdb->query($wpdb->prepare("DELETE FROM " . self::db_table_log() . " WHERE page_id < %d ", $min_page_id));

            // delete log_page table
            $wpdb->query($wpdb->prepare("DELETE FROM " . self::db_table_page() . " WHERE id < %d ", $min_page_id));
        }
    }

    public static function db_uninstall()
    {
        self::db_drop_table();

        // delete plugin options 
        delete_option(self::ID);
    }

    public static function db_drop_table()
    {
        global $wpdb;

        $wpdb->query("DROP TABLE IF EXISTS " . self::db_table_log());
        $wpdb->query("DROP TABLE IF EXISTS " . self::db_table_page());

        return true;
    }

    function admin_menu()
    {
        add_management_page('HTTP Requests Manager', 'HTTP Requests Manager', 'manage_options', HTTP_Requests_Manager::ID, [$this, 'settings_page']);
    }

    function settings_page()
    {
        include( VPHRM_DIR . '/templates/page-settings.php' );
    }

    function admin_notice_show()
    {
        $screen = get_current_screen();

        // show only on plugin page
        //To get the exact your screen ID just do var_dump($screen)
        if ($screen->id === 'tools_page_http-requests-manager')
        {
            // check MU plugin and show notification if needed
            // fix if option and MU file do not match
            $check = self::load_must_use_check();
            if ($check['status'] === 'error')
            {
                // show notification 
                echo '<div class="notice notice-warning is-dismissible">'
                . '<p>' . esc_html($check['message']) . '</p>'
                . '</div>';
            }
        }
    }

    function admin_scripts($hook)
    {
        if ('tools_page_' . HTTP_Requests_Manager::ID == $hook)
        {
            global $wp_version;
            $ver = esc_attr($wp_version . '-' . self::VERSION);
            wp_enqueue_script('vphrm', VPHRM_URL . '/assets/js/admin.js', array('jquery'), $ver);
            wp_enqueue_style('vphrm', VPHRM_URL . '/assets/css/admin.css', array(), $ver);
            wp_enqueue_style('media-views');
        }
    }

    function validate()
    {
        if (!current_user_can('manage_options'))
        {
            wp_die();
        }

        check_ajax_referer('vphrm_nonce');
    }

    function vphrm_query()
    {
        $this->validate();

        $data = empty($_POST['data']) ? array() : map_deep($_POST['data'], 'sanitize_text_field');

        // make sure we have table 
        $this->db_check_create_tables();

        $output = $this->db_get_results($data);
        $output['pager'] = $this->db_paginate();

        //$output = self::json_reduce_slashes($output);

        self::wp_send_json($output);
    }

    function vphrm_clear()
    {
        $this->validate();

        // make sure we have table 
        $this->db_check_create_tables();

        $this->db_truncate_table();
    }

    function vphrm_mode()
    {
        $this->validate();

        $output = [
            'mode'  => self::get_mode(),
            'modes' => self::modes()
        ];

        self::wp_send_json($output);
    }

    function vphrm_mode_change()
    {
        $this->validate();

        $mode = empty($_POST['mode']) ? '' : sanitize_text_field($_POST['mode']);

        $mode = self::validate_option('mode', $mode);

        $output = array();
        if (self::update_option('mode', $mode))
        {
            $output['status'] = 'ok';
            $output['message'] = self::translate('Option saved');
            $output['mode'] = $mode;
        }
        else
        {
            $output['status'] = 'error';
            $output['message'] = self::translate('Error saving option. Please try again.');
        }


        self::wp_send_json($output);
    }

    function vphrm_disable_logging()
    {
        $this->validate();

        $disable_logging = empty($_POST['disable_logging']) ? 0 : 1;

        $output = array();
        if (self::update_option('disable_logging', $disable_logging))
        {
            $output['status'] = 'ok';
            $output['message'] = self::translate('Option saved');
            $output['disable_logging'] = $disable_logging;
        }
        else
        {
            $output['status'] = 'error';
            $output['message'] = self::translate('Error saving option. Please try again.');
        }


        self::wp_send_json($output);
    }

    /**
     * copy MU file to MU plugin folder
     */
    private static function load_must_use_set()
    {
        $src = VPHRM_DIR . self::$mu_plugin_file_name;
        $dest = WPMU_PLUGIN_DIR . self::$mu_plugin_file_name;

        $output = array();

        // create mu dir 
        if (!is_dir(WPMU_PLUGIN_DIR) && !wp_mkdir_p(WPMU_PLUGIN_DIR))
        {
            $output['status'] = 'error';
            $output['message'] = self::translate('Error creating MU plugins directory.');

            return $output;
        }

        // remove old file if exists 
        if (file_exists($dest) && !unlink($dest))
        {
            $output['status'] = 'error';
            $output['message'] = self::translate('Error deleting old MU file');

            return $output;
        }

        // copy new MU file
        if (!file_exists($src) || !copy($src, $dest))
        {
            $output['status'] = 'error';
            $output['message'] = self::translate('Error copying plugin file to MU plugins directory.');

            return $output;
        }


        // file copied 
        $output['status'] = 'ok';
        $output['message'] = self::translate('MU plugin file set.');
        return $output;
    }

    /**
     * remove MU file from MU plugin folder
     */
    private static function load_must_use_remove()
    {
        $dest = WPMU_PLUGIN_DIR . self::$mu_plugin_file_name;

        $output = array();

        // remove old file if exists 
        if (file_exists($dest) && !unlink($dest))
        {
            $output['status'] = 'error';
            $output['message'] = self::translate('Error deleting old MU file');

            return $output;
        }

        // file removed 
        $output['status'] = 'ok';
        $output['message'] = self::translate('MU file deleted.');
        return $output;
    }

    /**
     * check if MU file matches selected loading option 
     */
    private static function load_must_use_check()
    {
        // current status of must use 
        $load_must_use_status = '';
        if (defined('VPHRM_MODE_INIT') && VPHRM_MODE_INIT)
        {
            // set
            $load_must_use_status = 'set';
        }
        if (defined('VPHRM_MODE') && VPHRM_MODE)
        {
            // loaded
            $load_must_use_status = 'loaded';
        }

        // instruction 
        $instruction = self::translate('Please update "Load before other plugins" option in "Settings" tab.');

        $output = array();

        //  check option to priority loading and add MU file 
        if (self::get_option('load_must_use'))
        {
            // option enabled: set must use plugin if not already set and running 
            if ($load_must_use_status === 'loaded')
            {
                // it is set and loaded. no problem
            }
            elseif ($load_must_use_status === 'set')
            {
                // it is set but not loaded probably error loading plugin. just show warning message 
                $output['status'] = 'error';
                $output['message'] = self::translate('"Load before other plugins" option enabled but not loaded.') . ' ' . $instruction;
            }
            else
            {
                // set it and check for error
                $set = self::load_must_use_set();
                if ($set['status'] === 'error')
                {
                    // remove option 
                    self::update_option('load_must_use', 0);

                    $output['status'] = 'error';
                    $output['message'] = self::translate('Error setting "Load before other plugins" option.') . ' ' . $instruction;
                }
            }
        }
        else
        {
            // option diabled: MU should not be used
            if ($load_must_use_status === 'set' || $load_must_use_status === 'loaded')
            {
                // remove MU if it exists
                $removed = self::load_must_use_remove();
                if ($removed['status'] === 'error')
                {
                    $output['status'] = 'error';
                    $output['message'] = self::translate('"Load before other plugins" option is not disabled.') . ' ' . $instruction;
                }
            }
        }


        // no error then ok 
        if (empty($output))
        {
            $output['status'] = 'ok';
            $output['message'] = self::translate('"Load before other plugins" option works as expected');
        }

        return $output;
    }

    /**
     * remove MU file from MU plugin folder
     */
    private static function load_must_use_apply()
    {
        //  check option to priority loading and add MU file 
        if (self::get_option('load_must_use'))
        {
            // set must use plugin
            self::load_must_use_set();
        }
        else
        {
            // remove must use plugin if it exists
            self::load_must_use_remove();
        }
    }

    /**
     * check if MU file has new version. upgrade file when necessary
     */
    private static function load_must_use_upgrade_check()
    {
        $src = VPHRM_DIR . self::$mu_plugin_file_name;
        $dest = WPMU_PLUGIN_DIR . self::$mu_plugin_file_name;

        // is mu active 
        if (file_exists($dest) && file_exists($src))
        {
            // get  versions 			
            $src_info = get_file_data($src, array('Version' => 'Version'));
            $dest_info = get_file_data($dest, array('Version' => 'Version'));

            // update if version different
            if (!empty($src_info['Version']) && !empty($dest_info['Version']) && $src_info['Version'] !== $dest_info['Version'])
            {
                // remove old mu file and set new one 
                self::load_must_use_remove();
                self::load_must_use_set();
            }
        }
    }

    function vphrm_load_must_use()
    {
        $this->validate();

        $load_must_use = empty($_POST['load_must_use']) ? 0 : 1;

        // depending on $load_must_use value add or remove a-http-requests-manager.php file from mu-plugins folder
        if ($load_must_use)
        {
            $file_output = self::load_must_use_set();
        }
        else
        {
            $file_output = self::load_must_use_remove();
        }

        if ($file_output['status'] === 'ok')
        {
            // file operation ok. save option 
            $output = array();
            if (self::update_option('load_must_use', $load_must_use))
            {
                $output['status'] = 'ok';
                $output['message'] = self::translate('Option saved');
                $output['load_must_use'] = $load_must_use;
            }
            else
            {
                $output['status'] = 'error';
                $output['message'] = self::translate('Error saving option. Please try again.');
            }
        }
        else
        {
            // pass error message to json
            $output = $file_output;
        }

        self::wp_send_json($output);
    }

    function vphrm_custom_rule_save()
    {
        $this->validate();
        $output = array();

        if (!empty($_POST['send']))
        {
            // rule_type, rule_plugin, rule_domain, rule_where, rule_action
            parse_str($_POST['send'], $send);

            $send = map_deep($send, 'sanitize_text_field');

            $rule = array();
            switch ($send['rule_type'])
            {
                case 'plugin':
                    $rule['plugin'] = $send['rule_plugin'];
                    break;
                case 'domain':
                    $rule['domain'] = $send['rule_domain'];
                    break;
                case 'all':
                    $rule['all'] = 1;
                    break;
                default:
                    self::wp_send_json(array(
                        'status'  => 'error',
                        'message' => self::translate('Rule type is not valid')
                    ));
                    return false;
            }

            $rule[$send['rule_action']] = $send['rule_where'];

            $rule_hash = self::custom_rule_hash($rule);

            $rule_opposite = $rule;
            if (isset($rule_opposite['allow']))
            {
                $rule_opposite['block'] = $rule_opposite['allow'];
                unset($rule_opposite['allow']);
            }
            elseif (isset($rule_opposite['block']))
            {
                $rule_opposite['allow'] = $rule_opposite['block'];
                unset($rule_opposite['block']);
            }
            $rule_opposite_hash = self::custom_rule_hash($rule_opposite);

            // get existing rules 
            $custom_rules = self::get_option('custom_rules', array());

            // remove opposize rule 
            unset($custom_rules[$rule_opposite_hash]);

            if (!isset($custom_rules[$rule_hash]))
            {

                // check if limit not reached 
                if (count($custom_rules) < self::$custom_rules_limit)
                {
                    // append new rule 
                    $custom_rules[$rule_hash] = $rule;

                    // reorder rules by priority
                    $custom_rules = self::custom_rule_reorder_priority($custom_rules);

                    // save rules 
                    if (self::update_option('custom_rules', $custom_rules))
                    {
                        $output['status'] = 'ok';
                        $output['message'] = self::translate('Option saved');
                        $output['custom_rules'] = $custom_rules;
                    }
                    else
                    {
                        $output['status'] = 'error';
                        $output['message'] = self::translate('Error saving option. Please try again.');
                    }
                }
                else
                {
                    // limit reached 
                    $output['status'] = 'error';
                    $output['message'] = sprintf(
                            self::translate('You have reached custom rule limit of %d. Please contact us if you need more custom rules.'),
                            self::$custom_rules_limit
                    );
                }
            }
            else
            {
                // rule already exists 
                $output['status'] = 'error';
                $output['message'] = self::translate('Custom rule already exists');
            }
        }
        else
        {
            // nothing sent 
            $output['status'] = 'error';
            $output['message'] = self::translate('Nothing to save. Please try again.');
        }

        self::wp_send_json($output);
    }

    function vphrm_custom_rule_delete()
    {
        $this->validate();
        $output = array();

        if (isset($_POST['id']))
        {
            $hash = $_POST['id'];

            // get existing rules 
            $custom_rules = self::get_option('custom_rules', array());

            if (isset($custom_rules[$hash]))
            {
                // record found delete it 
                unset($custom_rules[$hash]);

                // save rules 
                if (self::update_option('custom_rules', $custom_rules))
                {
                    $output['status'] = 'ok';
                    $output['message'] = self::translate('Option saved');
                    $output['custom_rules'] = $custom_rules;
                }
                else
                {
                    $output['status'] = 'error';
                    $output['message'] = self::translate('Error saving option. Please try again.');
                }
            }
            else
            {

                $output['status'] = 'error';
                $output['message'] = self::translate('Custom rule not found');
            }
        }
        else
        {
            // nothing sent 
            $output['status'] = 'error';
            $output['message'] = self::translate('Nothing to save. Please try again.');
        }

        self::wp_send_json($output);
    }

    static public function custom_rule_hash($rule)
    {
        $str = '';

        if (isset($rule['plugin']))
        {
            $str .= 'plugin:' . $rule['plugin'] . ',';
        }
        elseif (isset($rule['domain']))
        {
            $str .= 'domain:' . $rule['domain'] . ',';
        }
        elseif (isset($rule['all']))
        {
            $str .= 'all:' . $rule['all'] . ',';
        }


        if (isset($rule['allow']))
        {
            $str .= 'allow:' . $rule['allow'] . ',';
        }
        elseif (isset($rule['block']))
        {
            $str .= 'block:' . $rule['block'] . ',';
        }

        return md5($str);
    }

    /**
     * check custom rules and decide to block | allow | do_nothing with current request 
     * 
     * @param array $parsed_args
     * @param string $url
     * @return bool
     */
    function custom_rule_apply($parsed_args, $url)
    {
        // check custom rules and decide to block or allow or do nothing with current request 
        $custom_rules = self::get_option('custom_rules', array());

        // run when have custom rules
        // run once an dstore in $request_args['_info']['request_action']
        if (!empty($custom_rules))
        {
            // pre-populate request args [_info] for detecting current plugin|domain
            $this->append_request_info($parsed_args, $url);

            // cron|ajax|rest_api|xmlrpc|login|admin|frontend
            $current_where = self::current_page_type();

            // core|plugin|theme
            $current_what = self::current_request_group($parsed_args);
            if ($current_what === 'plugin')
            {
                // plugin-slug
                $current_what_plugin = self::current_request_group_detail($parsed_args);
            }

            // sub.example.com
            $current_what_domain = self::parse_url_host($url);

            foreach ($custom_rules as $rule)
            {
                // check each rule and find first match 
                $rule_what_match = false;
                $rule_where_match = false;
                $rule_action = false;
                $rule_action_info = '';

                // check what match 
                if (isset($rule['plugin']) && $current_what === 'plugin' && $rule['plugin'] === $current_what_plugin)
                {
                    // plugin match
                    $rule_what_match = true;
                    $rule_action_info .= 'plugin: ' . $rule['plugin'];
                }
                elseif (isset($rule['domain']) && $rule['domain'] === $current_what_domain)
                {
                    // domain match 
                    $rule_what_match = true;
                    $rule_action_info .= 'domain: ' . $rule['domain'];
                }
                elseif (isset($rule['all']))
                {
                    // all match 
                    $rule_what_match = true;
                    $rule_action_info .= 'all';
                }


                // check where match 
                if (isset($rule['allow']))
                {
                    $rule_action = 'allow';
                    $rule_where = $rule['allow'];
                }
                elseif (isset($rule['block']))
                {
                    $rule_action = 'block';
                    $rule_where = $rule['block'];
                }


                if (empty($rule_where))
                {
                    // everywhere match 
                    $rule_where_match = true;
                    $rule_action_info .= ' - ' . $rule_action . ' in: everywhere';
                }
                elseif ($rule_where === $current_where)
                {
                    // where match 
                    $rule_where_match = true;
                    $rule_action_info .= ' - ' . $rule_action . ' in: ' . $rule_where;
                }


                // apply rule if (what and where) match
                if ($rule_what_match && $rule_where_match && !empty($rule_action))
                {
                    self::$request_action = $rule_action;
                    self::$request_action_info = $rule_action_info;

                    return true;
                }
            }

            /*
              self::$request_action = 'block';
              self::$request_action_info = $mode;
             */
        }

        // match not found 
        return false;
    }

    static public function custom_rule_reorder_priority($rules)
    {
        $arr_priority = array();
        $ind = 99;
        foreach ($rules as $k => $v)
        {
            /* what priority */
            $p_what = 0;
            if (isset($v['all']))
            {
                $p_what = 0;
            }
            elseif (isset($v['plugin']))
            {
                $p_what = 1;
            }
            elseif (isset($v['domain']))
            {
                $p_what = 2;
            }

            /* action priority */
            $p_action = 0;
            if (isset($v['allow']))
            {
                $where = $v['allow'];
                // allow higher than block 
                $p_action = 1;
            }
            elseif (isset($v['block']))
            {
                $where = $v['block'];
            }

            $p_where = 0;
            if (!empty($where))
            {
                // not everywhere hight priority 
                // empty true if everywhere
                $p_where = 1;
            }

            $priority = $p_what * 10000 + $p_where * 1000 + $p_action * 100 + $ind;

            $arr_priority[$priority] = $k;

            $ind--;
        }

        krsort($arr_priority);

        $arr_return = array();
        foreach ($arr_priority as $v)
        {
            $arr_return[$v] = $rules[$v];
        }


        return $arr_return;
    }

    function vphrm_save_view()
    {
        $this->validate();

        $view = empty($_POST['view']) ? '' : sanitize_text_field($_POST['view']);

        $view = substr($view, 0, 20);

        $output = array();
        if (self::update_option('view', $view))
        {
            $output['status'] = 'ok';
            $output['message'] = self::translate('Option saved');
        }
        else
        {
            $output['status'] = 'error';
            $output['message'] = self::translate('Error saving option. Please try again.');
        }

        self::wp_send_json($output);
    }

    function log_start_timer($parsed_args = array(), $url = '')
    {
        self::cp('[start] request');

        $this->start_time = microtime(true);

        // store page time without any requests before first request start
        if (is_null(self::$timer_before))
        {
            self::$timer_before = self::timer_float();
        }

        // pre-populate request args [_info] for recording original url before any modification.
        // this will show url for denyed empty requests. 
        $this->append_request_info($parsed_args, $url);

        return $parsed_args;
    }

    /**
     * force logging when pre populated by oyher plugin. (from cache or error)
     * 
     * @param type $pre
     * @param type $parsed_args
     * @param type $url
     * @return \WP_Error
     */
    function log_pre_http_request($pre, $parsed_args, $url)
    {
        if (false !== $pre)
        {
            // request handled by other plugin (cache or error response). 
            // request will not be sent. reponse provided by other plugin. log this to debug window.
            // force add to log 
            self::$request_action = 'other';
            self::$request_action_info = '';
            $this->manage_do_action_http_api_debug($pre, $parsed_args, $url);
        }

        // pass 
        return $pre;
    }

    /**
     * time when script started
     * 
     * @return float
     */
    static private function timer_float_start()
    {
        if (is_null(self::$request_time))
        {
            if (!empty($_SERVER['REQUEST_TIME_FLOAT']))
            {
                self::$request_time = floatval($_SERVER['REQUEST_TIME_FLOAT']);
            }
            else
            {
                self::$request_time = microtime(true);
            }
        }

        return self::$request_time;
    }

    /**
     * Total time since PHP page started.
     * 
     * @return float
     */
    static public function timer_float()
    {
        // make sure timer satrted
        self::timer_float_start();

        // precision 3 is enough
        return round(microtime(true) - self::$request_time, 3);
    }

    static private function request_count()
    {
        return count(self::$requests);
    }

    function request_log($url, $stream = null)
    {
        $row = array(
            'url'        => $url,
            'runtime'    => round(microtime(true) - $this->start_time, 3),
            'total_time' => self::timer_float()
        );

        if ($stream)
        {
            $row['stream'] = $stream;
        }

        if (!empty(self::$request_action))
        {
            $row['request_action'] = self::$request_action;

            if (!empty(self::$request_action_info))
            {
                $row['request_action_info'] = self::$request_action_info;
            }
        }

        if (!is_null(self::$cron_status))
        {
            $row['cron_status'] = self::$cron_status;
        }

        self::$requests[] = $row;

        return self::$requests;
    }

    /**
     * Add id of last request record to local requests array for reference
     * 
     * @param int $id
     * @return type
     */
    function request_log_add_id($id)
    {
        if ($id)
        {
            // store request id in requests
            $last_index = count(self::$requests) - 1;
            if ($last_index >= 0)
            {
                self::$requests[$last_index]['id'] = $id;
            }

            // store request id in cp
            $last_index = count(self::$cp_arr) - 1;
            if ($last_index >= 0)
            {
                self::$cp_arr[$last_index]['request_id'] = $id;
            }
        }

        return self::$requests;
    }

    static public function get_mode()
    {
        $mode = self::get_option('mode');
        return self::validate_option('mode', $mode);
    }

    static private function validate_option($name, $value)
    {
        switch ($name)
        {
            case 'mode':
                $mode_default = 'log';
                $modes = self::modes();
                // check if mode exists
                if (!isset($modes[$value]))
                {
                    $value = $mode_default;
                }
                break;
        }

        return $value;
    }

    static public function is_url_internal($url)
    {
        $host = self::parse_url_host($url);
        if (empty($host))
        {
            // not valid url
            return false;
        }

        $home_host = self::parse_url_host(get_option('siteurl'));

        // Don't block requests back to ourselves by default.
        return ('localhost' === $host || $home_host === $host );
    }

    static public function is_url_internal_cron($url)
    {
        return self::is_url_internal($url) && (false !== strpos($url, 'doing_wp_cron'));
    }

    /**
     * check url containing wp_scrape_key and wp_scrape_nonce. they are used to save changes in theme and plugin files by admin
     * 
     * @param string $url
     * @return bool
     */
    static public function is_url_wp_scrape($url)
    {

        // faster way to check url args 
        if (false !== strpos($url, 'wp_scrape_key=') && false !== strpos($url, 'wp_scrape_nonce='))
        {
            return true;
        }

        /*
          $query_args = self::parse_url_query_args($url);
          // self::is_url_internal($url) &&
          if(isset($query_args['wp_scrape_key']) && isset($query_args['wp_scrape_nonce']))
          {
          return true;
          } */

        return false;
    }

    /**
     * Check if current page is login page
     * 
     * @return boolean
     */
    static public function is_login_page()
    {
        // return (in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php')) || has_action('login_init'));
        // return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
        return (false !== stripos(wp_login_url(), self::var_server_script_name()));
    }

    /**
     * check if 'host' of given $url in $allow_list
     * 
     * @param string $url
     * @param strin $allow_list example.com,*.example.org
     * @return boolean
     */
    static public function is_url_match($url, $allow_list)
    {
        //echo '[is_allow_url]';
        $check_host = self::parse_url_host($url);
        if (empty($check_host))
        {

            //echo '[is_allow_url:empty]';
            // empty: not valid host
            return false;
        }


        $accessible_hosts = null;
        $wildcard_regex = array();
        if (null === $accessible_hosts)
        {
            $accessible_hosts = preg_split('|,\s*|', $allow_list);

            if (false !== strpos($allow_list, '*'))
            {
                $wildcard_regex = array();
                foreach ($accessible_hosts as $host)
                {
                    $wildcard_regex[] = str_replace('\*', '.+', preg_quote($host, '/'));
                }
                $wildcard_regex = '/^(' . implode('|', $wildcard_regex) . ')$/i';
            }
        }

        if (!empty($wildcard_regex))
        {

            //echo '[is_allow_url:wildcard_regex:' . $wildcard_regex . ':'.$check_host.']';
            return preg_match($wildcard_regex, $check_host);
        }
        else
        {
            //echo '[is_allow_url:accessible_hosts:' . implode(',', $accessible_hosts) . ']';
            return in_array($check_host, $accessible_hosts, true); // Inverse logic, if it's in the array, then don't block it.
        }
    }

    static public function modes()
    {
        if (!isset(self::$modes))
        {
            self::$modes = array(
                'log'                  => self::translate('Only log HTTP requests'),
                'log_all'              => self::translate('Only log HTTP requests (+ cron requests)'),
                'block_smart'          => self::translate('Smart block'),
                'block_external'       => self::translate('Block external requests'),
                'block_external_no_wp' => self::translate('Block external requests (allow WordPress.org only)')
            );
        }

        return self::$modes;
    }

    static public function db_truncate_field($value, $max_length)
    {
        return strlen($value) > $max_length ? substr($value, 0, $max_length) : $value;
    }

    function db_capture_page()
    {
        global $wpdb;

        // append extra page info 
        $info = self::append_page_info();

        /*
          id
          url
          page_type
          runtime
          info
          date_added
         */

        // False to ignore current row
        $log_data = apply_filters('vphrm_log_page_data', [
            'url'        => self::page_url(),
            'page_type'  => self::db_truncate_field(self::current_page_type(), 20),
            'runtime'    => self::timer_float(),
            'info'       => self::json_encode($info),
            'date_added' => current_time('mysql')
        ]);

        if (false !== $log_data)
        {

            if (self::$page_id > 0)
            {
                // update 
                $this->db_update_page();
            }
            else
            {
                // add data to DB			
                $wpdb->insert(self::db_table_page(), $log_data);

                // store page id
                self::$page_id = $wpdb->insert_id;
            }
        }
    }

    function db_capture_request($response, $context, $transport, $args, $url)
    {
        global $wpdb;
        $mode = self::get_mode();

        // count current request 
        // capture request to apply request limits even if not logging.
        $this->request_log($url, $args['stream']);

        // show nonempty url for checkpoint. if url empty use original url.
        $url_cp = empty($url) ? '[empty] ' . (!empty($args['_info']['request_url_original']) ? $args['_info']['request_url_original'] : '') : $url;

        // remove request_url_original if it matches $url
        if (!empty($args['_info']['request_url_original']) && $args['_info']['request_url_original'] === $url)
        {
            unset($args['_info']['request_url_original']);
        }


        self::cp('request: ' . $url_cp);

        // do not capture (internal cron requests) + (not log_all) + (not blocked)
        if (self::is_url_internal_cron($url) && $mode !== 'log_all' && empty(self::$request_action))
        {
            // do not log 
            return;
        }

        // do not capture if disable_logging=1
        $disable_logging = self::get_option('disable_logging');
        if ($disable_logging)
        {
            // do not log 
            return;
        }


        // capture page first. use page_id for request capturing
        $this->db_capture_page();

        // append extra request info 
        $this->append_request_info($args, $url);

        /*
          page_id
          request_status (blocked/failed/success)
          request_group (core/plugin/theme)
          request_source (core/plugin with name/theme with name)
         */

        // convert obj to array reponse to work simpler and without any private protected properties.
        $arr_response = self::obj2arr($response);

        // reduce response body 
        self::trim_reponse_body($arr_response);

        // False to ignore current row
        $log_data = apply_filters('vphrm_log_data', [
            'url'            => $url,
            'request_args'   => self::json_encode($args),
            'response'       => self::json_encode($arr_response),
            'runtime'        => ( microtime(true) - $this->start_time ),
            'date_added'     => current_time('mysql'),
            'page_id'        => self::$page_id,
            'request_status' => self::db_truncate_field(self::current_request_status($arr_response), 20),
            'request_group'  => self::db_truncate_field(self::current_request_group($args), 20),
            'request_source' => self::db_truncate_field(self::current_request_source($args), 255),
        ]);

        if (false !== $log_data)
        {
            $wpdb->insert(self::db_table_log(), $log_data);

            // store last request id 
            $this->request_log_add_id($wpdb->insert_id);
        }
    }

    static public function wp_send_json($data)
    {
        if (version_compare(self::wp_version(), '5.6') == -1)
        {
            return wp_send_json($data, null);
        }

        return wp_send_json($data, null, self::json_flags());
    }

    static public function json_encode($data)
    {
        return json_encode($data, self::json_flags());
    }

    static private function wp_version()
    {
        static $wp_version;

        if (!isset($wp_version))
        {
            require ABSPATH . WPINC . '/version.php';
        }

        return $wp_version;
    }

    static public function json_flags()
    {
        static $flags = null;
        if (is_null($flags))
        {
            $flags = 0;
            if (defined('JSON_UNESCAPED_SLASHES'))
            {
                $flags = $flags | JSON_UNESCAPED_SLASHES;
            }
            if (defined('JSON_UNESCAPED_UNICODE '))
            {
                $flags = $flags | JSON_UNESCAPED_UNICODE;
            }
            if (defined('JSON_NUMERIC_CHECK'))
            {
                $flags = $flags | JSON_NUMERIC_CHECK;
            }
        }

        return $flags;
    }

    static public function json_reduce_slashes($data)
    {
        if (!empty($data))
        {
            // check if data json and has multiple slashes
            if (is_string($data) && strpos($data, '\/') !== false)
            {

                // try to decode and encode recursively 
                $dec = json_decode($data, true);
                if (json_last_error() === 0)
                {
                    // decoded 
                    $return = self::json_encode(self::json_reduce_slashes($dec));

                    /*
                     * 
                      static $total_before = 0;
                      static $total_after = 0;

                      $total_before += strlen($data);
                      $total_after += strlen($return);

                      echo '[found:' . substr($data, 0, 20)
                      . '...(' . strlen($data)
                      . ') ~ RESULT'
                      . substr($return, 0, 20)
                      . '...(' . strlen($return)
                      . ')...(before-after:' . $total_before . '-' . $total_after . '='
                      . (round(100 - $total_after * 100 / $total_before)) . ')]'
                      . "\n";
                     */

                    return $return;
                }

                unset($dec);
            }
            elseif (is_array($data))
            {
                //echo '[arr:' . count($data) . ':' . implode(',', array_keys($data)) . ']' . "\n";

                $new_data = array();
                foreach ($data as $key => $val)
                {
                    $new_data[$key] = self::json_reduce_slashes($val);
                }
                unset($data);
                return $new_data;
            }
        }

        // not processed
        // not json (or not processed) return as is
        return $data;
    }

    static public function obj2arr($obj)
    {
        // use this instead of (array) casting. 
        // because (array) converts private and protected properties which we do not need. 
        // json uses only public properties
        return json_decode(self::json_encode($obj), true);
    }

    static public function trim_reponse_body(& $response)
    {

        // reduce response body 
        // convert obj to array 
        if (is_object($response))
        {
            $response = self::obj2arr($response);
        }


        if (!empty($response['body']) && is_string($response['body']) && strlen($response['body']) > self::DATA_TRUNCATE_LIMIT)
        {
            // remove slashes before cutting string 
            $response['body'] = self::json_reduce_slashes($response['body']);

            // reduce response body
            $response['body'] = substr($response['body'], 0, self::DATA_TRUNCATE_VALUE)
                    . " ...[" . self::nice_bytes(strlen($response['body'])) . "]";

            return true;
        }

        return false;
    }

    /**
     * Update page record. called on shutdown and when new request added
     * 
     * @global type $wpdb
     */
    function db_update_page()
    {
        global $wpdb;

        if (self::$page_id > 0)
        {

            $log_data = array(
                'runtime' => self::timer_float(),
                'info'    => self::json_encode(self::append_page_info())
            );

            $wpdb->update(self::db_table_page(), $log_data, array('id' => self::$page_id));
        }
    }

    static public function current_request_status($response)
    {
        // default: no response.  
        $return = '-';
        if (self::$request_action === 'block')
        {
            $return = 'blocked';
        }
        else
        {
            // request not blocked. get respons code.
            // convert obj to array 
            if (is_object($response))
            {
                $response = self::obj2arr($response);
            }

            if (!empty($response['response']['code']))
            {
                // reponse code 200, 404, 503 etc.
                $return = (int) $response['response']['code'];
            }
        }

        return $return;
    }

    static public function current_request_group($args)
    {
        $return = 'core';

        // return first caller 
        if (isset($args['_info']['backtrace_file']['caller']))
        {
            foreach ($args['_info']['backtrace_file']['caller'] as $k => $v)
            {
                if ($v !== 'core')
                {
                    return $v;
                }
            }
        }


        return $return;
    }

    static public function current_request_group_detail($args)
    {
        $return = '';

        // return first caller 
        if (isset($args['_info']['backtrace_file']['caller']))
        {
            foreach ($args['_info']['backtrace_file']['caller'] as $k => $v)
            {
                if ($v !== 'core')
                {
                    return $k;
                }
            }
        }


        return $return;
    }

    static public function current_request_source($args)
    {
        $return = 'core';
        // return first caller 
        if (isset($args['_info']['backtrace_file']['caller']))
        {
            foreach ($args['_info']['backtrace_file']['caller'] as $k => $v)
            {
                if ($v !== 'core')
                {
                    return $v . ': ' . $k . '';
                }
            }
        }

        return $return;
    }

    static public function time_since($time)
    {
        $time = current_time('timestamp') - strtotime($time);
        $time = ( $time < 1 ) ? 1 : $time;
        $tokens = array(
            31536000 => 'year',
            2592000  => 'month',
            604800   => 'week',
            86400    => 'day',
            3600     => 'hour',
            60       => 'minute',
            1        => 'second'
        );

        foreach ($tokens as $unit => $text)
        {
            if ($time < $unit)
                continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits . ' ' . $text . ( ( $numberOfUnits > 1 ) ? 's' : '' );
        }
    }

    static public function cp($title = '')
    {
        if (!self::get_option('disable_logging'))
        {
            $cp_count = count(self::$cp_arr);

            if (!strlen($title))
            {
                $title = 'CP ' . $cp_count;
            }

            // $last = end(self::$cp_arr);

            $return = array('t' => self::timer_float(), 'm' => self::cp_memory());

            $return['name'] = $title;

            self::$cp_arr[] = $return;
        }
    }

    static public function cp_init_hooks()
    {
        // common places for slow down 
        $arr_hooks_before = array(
            'init',
            'wp_loaded',
            'wp_head',
            'wp_footer',
            'shutdown'
        );

        $arr_hooks = array(
            'setup_theme',
            'after_setup_theme',
            'admin_menu',
            'adminmenu'
        );

        foreach ($arr_hooks_before as $hook)
        {
            add_action($hook, ['HTTP_Requests_Manager', 'cp_hook_start'], 0);
            add_action($hook, ['HTTP_Requests_Manager', 'cp_hook'], PHP_INT_MAX);
        }

        foreach ($arr_hooks as $hook)
        {
            add_action($hook, ['HTTP_Requests_Manager', 'cp_hook'], PHP_INT_MAX);
        }

        // do not show rest of the plugins one by one. nut much changed by loading only php files. 
        add_action('plugin_loaded', ['HTTP_Requests_Manager', 'cp_hook_plugin_loaded_significat'], PHP_INT_MAX);

        // show all loaded plugins
        add_action('plugins_loaded', ['HTTP_Requests_Manager', 'cp_hook_start'], 0);
        add_action('plugins_loaded', ['HTTP_Requests_Manager', 'cp_hook_plugins_loaded'], PHP_INT_MAX);
        add_action('muplugins_loaded', ['HTTP_Requests_Manager', 'cp_hook_plugins_loaded'], PHP_INT_MAX);
    }

    /**
     * Record first check point with list of already loaded plugins. 
     * initialize other cp hooks cp_init_hooks();
     * 
     */
    static public function cp_init()
    {
        /* report currently loaded plugins */
        $loaded_plugins = self::get_loaded_plugins();
        $msg = 'plugins until now: (' . count($loaded_plugins) . ')';
        if (!empty($loaded_plugins))
        {
            $msg .= ' ' . implode(', ', $loaded_plugins);
        }
        self::cp($msg);

        // initialize all cp hooks 
        self::cp_init_hooks();
    }

    static public function cp_hook_start()
    {
        $hook_name = current_filter();
        self::cp('[start] ' . $hook_name);
    }

    static public function cp_hook_plugins_loaded()
    {
        $hook_name = current_filter();
        $loaded_plugins = self::get_loaded_plugins();
        $msg = '(' . count($loaded_plugins) . ')';

        if (!empty($loaded_plugins))
        {
            $msg .= ' ' . implode(', ', $loaded_plugins);
        }

        self::cp($hook_name . ': ' . $msg);
    }

    /**
     * Return loaded plugin slugs as array
     * 
     * @return array
     */
    static public function get_loaded_plugins()
    {
        $plugin_slugs = array();

        static $abspath = null;
        if (is_null($abspath))
        {
            $abspath = str_replace('\\', '/', ABSPATH);
        }


        $incs = get_included_files();
        $incs = implode("\n", $incs);
        $incs = str_replace('\\', '/', $incs);
        $incs = str_replace($abspath, '', $incs);

        preg_match_all('(wp-content\/plugins\/([^/]*))', $incs, $matches);

        if (!empty($matches[1]))
        {
            $plugin_slugs = array_unique($matches[1]);
        }

        /* echo "<!-- get_loaded_plugins \n";
          echo " --- \n" . $incs . " --- \n";
          print_r($matches);
          echo " ----  \n";
          print_r($plugin_slugs);
          echo " -->\n";
         */

        return $plugin_slugs;
    }

    static public function cp_hook_plugin_loaded($file)
    {
        $hook_name = current_filter();

        // get plugin slug from long file path /home/dir/wp-includes/plugins/plugin-slug/plugin-file.php  to  plugin-slug
        $file_type = self::get_file_type($file);
        $msg = !empty($file_type['slug']) ? $file_type['slug'] : $file_type['file'];

        self::cp($hook_name . ': ' . $msg);
    }

    static public function cp_hook_plugin_loaded_significat($file)
    {
        $timer_significant = 0.05;
        $hook_name = current_filter();

        static $loaded_plugins;
        if (is_null($loaded_plugins))
        {
            $loaded_plugins = self::get_loaded_plugins();
        }

        $time_diff = self::timer_float() - self::cp_last_time();

        if ($time_diff > $timer_significant)
        {
            // record cp
            $cnt_lp = count($loaded_plugins);
            $current_loaded_plugins = self::get_loaded_plugins();
            $cnt_clp = count($current_loaded_plugins);

            $msg = null;

            if ($cnt_clp === $cnt_lp + 1)
            {
                // report as one plugin loaded
                // get plugin slug from long file path /home/dir/wp-includes/plugins/plugin-slug/plugin-file.php  to  plugin-slug
                $file_type = self::get_file_type($file);
                $msg = !empty($file_type['slug']) ? $file_type['slug'] : $file_type['file'];
            }
            elseif ($cnt_clp > $cnt_lp + 1)
            {
                // multiple plugins loaded
                $plugins_diff = array_diff($current_loaded_plugins, $loaded_plugins);
                $msg = '(' . count($plugins_diff) . ') ' . implode(', ', $plugins_diff);
            }

            if (!is_null($msg))
            {
                // update to latest loaded plugins
                $loaded_plugins = $current_loaded_plugins;

                // record check point 
                self::cp($hook_name . ': ' . $msg);
            }
        }
    }

    static public function cp_hook()
    {
        $hook_name = current_filter();
        self::cp($hook_name);
    }

    static public function cp_memory($real = false)
    {
        $return = @memory_get_peak_usage($real);
        if (!$return)
        {
            $return = @memory_get_usage($real);
        }

        return $return;
    }

    static public function cp_last_time()
    {
        $last = end(self::$cp_arr);

        return (empty($last['t']) ? 0 : $last['t']);
    }

    /**
     * get plugin option by name 
     * 
     * @param type $name
     * @param type $default
     * @return string
     */
    static public function get_option($name, $default = null)
    {
        if (is_null(self::$options))
        {
            self::$options = get_option(self::ID, array());
        }

        if (!isset(self::$options[$name]))
        {
            if (is_null($default))
            {
                return '';
            }
            else
            {
                return $default;
            }
        }

        return self::$options[$name];
    }

    static public function update_option($name, $value = '')
    {
        if (is_null(self::$options))
        {
            self::$options = get_option(self::ID, array());
        }

        self::$options[$name] = $value;

        $return = update_option(self::ID, self::$options, false);
        if (!$return)
        {
            // might be conflict with cached option. delete cache 
            wp_cache_delete(self::ID, 'option');

            // try again saving option
            $return = update_option(self::ID, self::$options, false);
        }

        return $return;
    }

    /**
     * Reduce default timeout for all requests from 5 to 2 seconds. 
     * Default is used when plugins do not provide custom timeout. 
     * This will not force to 2 seconds. it is just default. 
     * Forcing timeout is done inside manage_http_request_args() -> if not skipped by manage_skip_request_timeout_limit()
     */
    function manage_timeout($time, $url = '')
    {
        //echo '<!-- manage_timeout ('.$time.','.$url.') -->';
        return min(self::TIMEOUT, $time);
    }

    function manage_redirection_count($count, $url = '')
    {
        //echo '<!-- manage_redirection_count ('.$count.','.$url.') -->';
        return min(1, $count);
    }

    function manage_http_request_args($parsed_args, $url = '')
    {
        /**
         * IMPORTANT: define action first. this will effect request timeout and blocking for given request only. 
         * resets self::$request_action variable as well.
         * 		- manage_skip_request_timeout_limit() will use self::$request_action==='allow' variable below.
         * 		- manage_pre_http_request() will use it to block or allow request 
         */
        // define self::$request_action = false|allow|block 
        $this->manage_request_action($parsed_args, $url);

        // fix request time and redirection count here as well
        $default_time = self::TIMEOUT;

        // custom timings. add custom timeout per url here. 
        $custom_time = array(
                /* 'api.wordpress.org/plugins/info/' => 2  */
        );

        // set timeout only for not stream requests empty($parsed_args['stream'])		
        if (!$this->manage_skip_request_timeout_limit($parsed_args, $url))
        {
            // check for custom  time per url 
            foreach ($custom_time as $k => $v)
            {
                if (false !== strpos($url, $k))
                {
                    $default_time = $v;
                    break;
                }
            }

            // set timeout only for all not stream requests
            $parsed_args['timeout'] = min($default_time, $parsed_args['timeout']);
        }

        $parsed_args['redirection'] = 1;

        return $parsed_args;
    }

    /**
     * Decide to block request 
     * reset and define self::$request_action = false|allow|block
     * uses blocking mode and custom rules when needed.
     * 
     * 
     * @param type $parsed_args
     * @param type $url
     */
    function manage_request_action($parsed_args, $url)
    {
        // decide to block or allow request 
        self::$request_action = false;
        self::$request_action_info = '';

        $mode = self::get_mode();

        /* Domain related blocks */

        // block depending on mode 
        switch ($mode)
        {
            case 'block_external':
                if (!self::is_url_internal($url))
                {
                    self::$request_action = 'block';
                    self::$request_action_info = $mode;
                }
                break;
            case 'block_external_no_wp':
                if (!self::is_url_internal($url) && !self::is_url_match($url, '*.wordpress.org'))
                {
                    self::$request_action = 'block';
                    self::$request_action_info = $mode;
                }
                break;
            case 'block_smart':
                // check custom rules to block or allow request 
                /**
                 * defines using custom rules 
                 * 
                 * 		self::$request_action = 'block';
                 * 		self::$request_action_info = 'description';
                 */
                $this->custom_rule_apply($parsed_args, $url);
                break;
        }

        // blacklist. add domains to block here 
        // 'api.wordpress.org/core/browse-happy/' /* prevent user browser checking with api */
        $arr_block = array(
            'api.wordpress.org/core/browse-happy/' => 'browse-happy' /* prevent user browser checking with api */,
        );
        if (false === self::$request_action && !empty($arr_block))
        {
            foreach ($arr_block as $_block => $_block_info)
            {
                if (strpos($url, $_block) !== false)
                {
                    self::$request_action = 'block';
                    self::$request_action_info = 'blacklist' . (empty($_block_info) ? '' : ': ' . $_block_info);
                    break;
                }
            }
        }

        /* Domain related blocks END */


        // skip time and req limit if it is stream. Stream used to download zip files for plugins and core. They should be slow by nature.
        if (false === self::$request_action && empty($parsed_args['stream']) && !$this->manage_skip_page_timeout_limit($url))
        {
            // total time limit
            $total_time_limit = 3;
            if (false === self::$request_action && self::timer_float() > $total_time_limit)
            {
                self::$request_action = 'block';
                self::$request_action_info = 'total_time_limit ' . $total_time_limit . 's < ' . number_format(self::timer_float(), 1) . 's';
            }

            // total request limit
            $total_req_limit = 3;
            if (false === self::$request_action && self::request_count() > $total_req_limit)
            {
                self::$request_action = 'block';
                self::$request_action_info = 'total_req_limit ' . $total_req_limit . ' < ' . self::request_count();
            }
        }
    }

    /**
     * Block some requests. 
     * 	- block (by operation mode)
     *  - block (by smart rules time and request count limit)
     *  - block (by useless request like [browse-happy])
     * 	- block (by custom rules) 
     * 	- allow (by custom rules) 
     * 
     * 
     * @param type $pre
     * @param type $parsed_args
     * @param type $url
     * @return \WP_Error
     */
    function manage_pre_http_request($pre, $parsed_args, $url)
    {
        // request not handled (cache or error) by other plugins
        if (false === $pre)
        {
            // return error if block
            if (self::$request_action === 'block')
            {
                // block request and return error
                return $this->manage_perform_request_blocking($parsed_args, $url);
            }
        }

        // pass without blocking
        return $pre;
    }

    function manage_do_action_http_api_debug($pre, $parsed_args, $url)
    {
        /** This action is documented in wp-includes/class-wp-http.php */
        do_action('http_api_debug', $pre, 'response', 'WpOrg\Requests\Requests', $parsed_args, $url);
    }

    /**
     * Create error response for blocked request.
     * Initiate recording to DB by calling action http_api_debug 
     * Return response error WP_Error. 
     * Used to record and response error message. 
     * 
     * Also can be used to prevent pingbacks and enclosure checking calls without even starting any request.  
     * 
     * @param type $parsed_args
     * @param type $url
     * @return \WP_Error
     */
    function manage_perform_request_blocking($parsed_args, $url)
    {
        $response = new WP_Error('http_request_not_executed', self::translate('User has blocked requests through HTTP. (HTTP Requests Manager plugin: ' . self::$request_action_info . ')'));

        // write action inside http_api_debug and return error message 
        $this->manage_do_action_http_api_debug($response, $parsed_args, $url);

        return $response;
    }

    /**
     * Capture prevented requests before initiating any WP_HTTP calls. 
     * 
     * Used in disable_self_ping() and disable_not_obvious_enclosure_links() when removing urls from initiating request.
     * 
     * @param type $url
     * @return type
     */
    function manage_perform_request_blocking_by_url($url, $info = '')
    {
        $this->log_start_timer(array(), $url);

        self::$request_action = 'block';
        self::$request_action_info = 'prevented';

        if (!empty($info))
        {
            self::$request_action_info .= ' ' . $info;
        }

        return $this->manage_perform_request_blocking(array(), $url);
    }

    function append_request_info(&$request_args, $url = '')
    {

        if (empty($request_args['_info']))
        {
            /* these created before request started. 
             * used by custom rules for blocking or allowng by plugin, domain etc. */

            // append current page info 
            $_info = array();

            // add current url 
            $_info['request_host'] = self::parse_url_host($url);
            if ($url)
            {
                $_info['request_url_original'] = $url;
            }
            $_info['timer_before'] = self::$timer_before;

            $_info['backtrace'] = wp_debug_backtrace_summary('HTTP_Requests_Manager', 8, false);
            $_info['backtrace_file'] = self::backtrace_file(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 50));

            $request_args['_info'] = $_info;
        }



        /* these records added after request finished */
        // block|allow request
        $request_args['_info']['request_action'] = self::$request_action;
        // reason for blocking or allowing
        $request_args['_info']['request_action_info'] = self::$request_action_info;
        $request_args['_info']['total_time'] = self::timer_float();

        return $request_args;
    }

    public static function append_page_info()
    {
        if (empty(self::$page_info))
        {
            // append current page info 
            self::$page_info = array();
            if (self::current_page_type() === 'ajax' && !empty(self::var_request_action()))
            {
                self::$page_info['ajax_action'] = self::var_request_action();
            }


            self::$page_info['manager_mode'] = self::get_mode();
            self::$page_info['timer_before'] = self::$timer_before;
        }

        // is_user_logged_in() is pluggable function and will be loaded before init event. use it only if it is already loaded. 
        if (!isset(self::$page_info['is_user_logged_in']) && function_exists('is_user_logged_in'))
        {
            self::$page_info['is_user_logged_in'] = is_user_logged_in();
        }


        // updated data
        self::$page_info['req_num'] = self::request_count();
        self::$page_info['requests'] = self::$requests;
        self::$page_info['cp'] = self::$cp_arr;

        return self::$page_info;
    }

    /**
     * parse_url and return host/domain
     * 
     * @param string $url
     * @return string
     */
    static public function parse_url_host($url)
    {
        $parsed_url = self::parse_url($url);
        return (empty($parsed_url['host']) ? '' : $parsed_url['host']);
    }

    static public function parse_url_path($url)
    {
        $parsed_url = self::parse_url($url);
        return (empty($parsed_url['path']) ? '' : $parsed_url['path']);
    }

    static public function parse_url_query_args($url)
    {
        $return_arr = array();

        $parsed_url = self::parse_url($url);
        $query = (empty($parsed_url['query']) ? '' : $parsed_url['query']);

        if (strlen($query))
        {
            parse_str($query, $return_arr);
        }
        return $return_arr;
    }

    /**
     * parse_url once and store result for future uses
     * 
     * @param string $url
     * @return array
     */
    static public function parse_url($url)
    {
        if (!isset(self::$parsed_urls[$url]))
        {
            self::$parsed_urls[$url] = parse_url(sanitize_text_field($url));
        }

        return self::$parsed_urls[$url];
    }

    static public function backtrace_file($backtrace)
    {
        $return = array();
        $return_short = array();
        $return_caller = array();

        $start_from_class = 'WP_Http';
        $skip_class = 'HTTP_Requests_Manager';
        $start = false;

        foreach ($backtrace as $trace)
        {
            // skip self 
            if (!empty($trace['class']))
            {
                if ($trace['class'] === $skip_class)
                {
                    if ($skip_class === $start_from_class)
                    {
                        // start from next rows 
                        $start = true;
                    }
                    // skip this record		
                    continue;
                }

                // skip trace until WP_Http called
                if ($trace['class'] === $start_from_class)
                {
                    // start from next rows 
                    $start = true;

                    // skip this record
                    continue;
                }
            }

            if (!$start)
            {
                continue;
            }

            // get file info: tile, type, slug
            $row = self::get_file_type(self::get_arr_val($trace, 'file'));
            $file_short = $row['file'];

            if (!empty($trace['class']))
            {
                $row['class'] = $trace['class'];
            }

            if (!empty($trace['function']))
            {
                $row['function'] = $trace['function'];
            }

            $return[] = $row;

            // store only first (latest) referance to file
            if (!isset($return_short[$file_short]))
            {
                $return_short[$file_short] = $row['type'] . (!empty($row['slug']) ? ' [' . $row['slug'] . ']' : '');
            }

            // can have multiple callers 
            if (!empty($row['slug']) && !isset($return_caller[$row['slug']]))
            {
                $return_caller[$row['slug']] = $row['type'];
            }
        }


        $return_all = array();

        $return_alt = self::generate_call_trace($start_from_class, $skip_class);
        if (!empty($return_alt))
        {
            $return_all['alt'] = $return_alt;
        }

        if (!empty($return_caller))
        {
            $return_all['caller'] = $return_caller;
        }

        if (!empty($return_short))
        {
            $return_all['short'] = $return_short;
        }

        // no need to repeat existing records in long form.
        /* if(!empty($return))
          {
          $return_all['long'] = $return;
          } */

        return $return_all;
    }

    static public function get_arr_val($arr, $key, $default = '')
    {
        return isset($arr[$key]) ? $arr[$key] : $default;
    }

    static private function normalize_path_if_needed($file)
    {
        if (strpos($file, '\\'))
        {
            return wp_normalize_path($file);
        }
        return $file;
    }

    /**
     * detect if file related to plugin, theme or core. Return array with wp root relative file name, type and slug of plugin. 
     * 
     * @staticvar string $abspath
     * @param string $file
     * @return array file, type, slug
     */
    static public function get_file_type($file)
    {
        static $abspath = null;
        if (is_null($abspath))
        {
            $abspath = self::normalize_path_if_needed(ABSPATH);
        }

        $theme_dir_prefix = 'wp-content/themes/';
        $plugin_dir_prefix = 'wp-content/plugins/';

        $file = self::normalize_path_if_needed($file);
        $file_short = self::remove_prefix($file, $abspath);

        $row = array(
            'file' => $file_short,
            'type' => 'core'
        );

        // plugin or theme
        if (0 === strpos($file_short, $plugin_dir_prefix))
        {
            // this is plugin 			
            $plugin_basename = self::remove_prefix($file_short, $plugin_dir_prefix);
            $row['slug'] = self::get_dir_root($plugin_basename);
            $row['type'] = 'plugin';
        }
        elseif (0 === strpos($file_short, $theme_dir_prefix))
        {
            // this is theme
            $theme_basename = self::remove_prefix($file_short, $theme_dir_prefix);
            $row['slug'] = self::get_dir_root($theme_basename);
            $row['type'] = 'theme';
        }

        return $row;
    }

    static public function generate_call_trace($start_from_class = '', $skip_class = '')
    {
        $e = new Exception();
        $trace = explode("\n", $e->getTraceAsString());
        // reverse array to make steps line up chronologically
        // $trace = array_reverse($trace);
        array_pop($trace); // remove {main}
        array_shift($trace); // remove call to this method
        //array_shift($trace); // remove call to SlowLog::backtrace_file(Array)
        //array_shift($trace); // remove call to SlowLog->log_add()
        $length = count($trace);
        $result = array();

        $abspath = wp_normalize_path(ABSPATH);

        // skip latest records until 		
        $start = empty($start_from_class);

        for ($i = 0; $i < $length; $i++)
        {
            $trace_line = $trace[$i];

            // skip some rows from beginning 
            if ($start_from_class)
            {
                // skip trace until WP_Http called
                if (false !== strpos($trace_line, $start_from_class . '::') || false !== strpos($trace_line, $start_from_class . '->'))
                {
                    // start from next rows 
                    $start = true;

                    // skip this record
                    continue;
                }
            }

            if ($skip_class)
            {
                // skip trace until WP_Http called
                if (false !== strpos($trace_line, $skip_class . '::') || false !== strpos($trace_line, $skip_class . '->'))
                {
                    // skip this record
                    continue;
                }
            }

            if (!$start)
            {
                continue;
            }


            // replace '#someNum' with '$i)', set the right ordering
            $file = substr($trace[$i], strpos($trace[$i], ' '));

            // normalize file path 
            $file = wp_normalize_path($file);
            $file_short = self::remove_prefix(trim($file), $abspath);

            $result[] = ($i + 1) . ') ' . $file_short;
        }

        //return "\t" . implode("\n\t", $result);
        return $result;
    }

    /**
     * Get first root dir name. used to get plugin or theme slug. 
     * /download-monitor/src/Util/ExtensionLoader.php	-> download-monitor
     * /pretty-link/app/lib/PrliNotifications.php		-> pretty-link
     * 
     * @param string $dir
     * @return string
     */
    static public function get_dir_root($dir)
    {
        $dir_arr = explode('/', trim($dir, '/'));
        return (!empty($dir_arr[0]) ? $dir_arr[0] : '');
    }

    /**
     * remove prefix only from start of the string.
     * Used to strip abspath, plugins dir, themes dir from filename.
     * 
     * @param string $str
     * @param string $prefix
     * @return string
     */
    static public function remove_prefix($str, $prefix)
    {
        //if(substr($str, 0, strlen($prefix)) == $prefix)
        if (strpos($str, $prefix) === 0)
        {
            $str = substr($str, strlen($prefix));
        }

        return $str;
    }

    /**
     * Return current page type.
     * Id adding new page type update self::$page_types array with new page type group
     * 
     * @return string cron|ajax|rest_api|xmlrpc|login|admin|frontend
     */
    static public function current_page_type()
    {
        static $return;

        if (is_null($return))
        {
            if (is_null($return) && ( (function_exists('wp_doing_cron') && wp_doing_cron()) || (defined('DOING_CRON') && DOING_CRON)))
            {
                $return = 'cron';
            }

            if (is_null($return) && wp_doing_ajax())
            {
                $return = 'ajax';
            }

            // is REST API endpoint 
            if (is_null($return) && ((defined('REST_REQUEST') && REST_REQUEST ) || !empty($GLOBALS['wp']->query_vars['rest_route'])))
            {
                $return = 'rest_api';
            }

            if (is_null($return) && (defined('XMLRPC_REQUEST') && XMLRPC_REQUEST ))
            {
                $return = 'xmlrpc';
            }

            if (is_null($return) && self::is_login_page())
            {
                $return = 'login';
            }
        }

        // certain or fallback type 
        return is_null($return) ? (is_admin() ? 'admin' : 'frontend') : $return;
    }

    /**
     * check if one of parent functions is $function_name
     * used to know when transient requested in _maybe_update_plugins, _maybe_update_themes 
     * 
     * @param string $function_name
     * @return boolean
     */
    static public function current_has_parent_function($function_name, $backtrace_array = null)
    {
        if (is_null($backtrace_array))
        {
            $backtrace_array = wp_debug_backtrace_summary('HTTP_Requests_Manager', 1, false);
        }

        return in_array($function_name, $backtrace_array);
    }

    function manage()
    {
        if ($this->manage_skip())
        {
            // do not prevent or limit requests. no managing, just log. 
            return false;
        }

        // set default timeout and redirect count
        add_filter('http_request_timeout', [$this, 'manage_timeout'], 10, 2);
        add_filter('http_request_redirection_count', [$this, 'manage_redirection_count'], 10, 2);

        // reduce timout to max 1 if bigger;  redirection=1;
        add_filter('http_request_args', [$this, 'manage_http_request_args'], 100, 2);

        // block some requests
        add_filter('pre_http_request', [$this, 'manage_pre_http_request'], PHP_INT_MAX, 3);

        // delay cron 
        // $this->manage_delay_cron();
        // disable self ping. disable ping to internal images and urls when publishing post. useless and takes long for page with 20+ internal links/images
        add_action('pre_ping', [$this, 'disable_self_ping']);

        // prevent enclosure requests to non video/music files 
        add_filter('enclosure_links', [$this, 'disable_not_obvious_enclosure_links'], 10, 2);

        // disable maybe update checks in admin 
        add_filter('site_transient_update_plugins', [$this, 'disable_maybe_update_filter'], 10, 2);
        add_filter('site_transient_update_themes', [$this, 'disable_maybe_update_filter'], 10, 2);
        add_filter('site_transient_update_core', [$this, 'disable_maybe_update_filter'], 10, 2);

        // double implementation for block all modes. in case some plugins remove all pre_http_request actions.
        $this->manage_block_using_constants();
    }

    /**
     * Some pages or conditions should skip any blocking limitations
     * 
     * @return bool
     */
    function manage_skip()
    {
        // mode log only 
        $mode = self::get_mode();
        if ($mode == 'log' || $mode == 'log_all')
        {
            // just logging. no need to adjust blocking at all 
            return true;
        }

        // default no skip 
        return false;
    }

    function manage_block_using_constants()
    {
        // current operation mode
        $mode = self::get_mode();

        $block_defined = defined('WP_HTTP_BLOCK_EXTERNAL');
        $block = $block_defined ? WP_HTTP_BLOCK_EXTERNAL : false;

        $host_defined = defined('WP_ACCESSIBLE_HOSTS');
        $host = $host_defined ? WP_ACCESSIBLE_HOSTS : '';

        //block_external
        if ($mode === 'block_external')
        {
            // block all external 
            if (!$block_defined && $host == '')
            {
                // can define our own constant here 
                define('WP_HTTP_BLOCK_EXTERNAL', true);
                return true;
            }
        }

        //block_external_no_wp
        if ($mode === 'block_external_no_wp')
        {
            // block all external 
            if (!$block_defined && (!$host_defined || $host == '*.wordpress.org'))
            {
                // can define our own constant here 
                define('WP_HTTP_BLOCK_EXTERNAL', true);

                if (!$host_defined)
                {
                    define('WP_ACCESSIBLE_HOSTS', '*.wordpress.org');
                }
                return true;
            }
        }

        return false;
    }

    /**
     * Skip page timeout limitation for some pages. Allow requests even if page timeout or request limit reached. 
     * 	- getting plugin info 
     * 	- saving edited plugin files wp_scrape_key, wp_scrape_nonce
     * 
     * @return bool
     */
    function manage_skip_page_timeout_limit($url = '')
    {

        // skip timeout for plugin info requests 
        // /wp-admin/plugin-install.php?tab=plugin-information&plugin=bbp-style-pack&
        if (false !== stripos(self::var_server_script_name(), 'plugin-install.php'))
        {
            return true;
            /* if(isset($_GET['tab']) && isset($_GET['plugin']))
              {
              return true;
              } */
        }

        // skip limitation shile updating core
        // /wp-admin/update-core.php?action=do-core-upgrade
        if (false !== stripos(self::var_server_script_name(), 'update-core.php'))
        {
            return true;
        }



        // skip timeout for all requests in cron job 
        if ('cron' === self::current_page_type())
        {
            return true;
        }

        // skip .zip.sig urls for checking plugin update signitures 
        if (false !== stripos(self::parse_url_path($url), '.zip.sig'))
        {
            return true;
        }


        // skip for urls containing wp_scrape_key and wp_scrape_nonce. they are used to save cahnges in theme and plugin files by admin		
        if (self::is_url_wp_scrape($url))
        {
            return true;
        }


        return false;
    }

    /**
     * Skip page timeout limitation for some pages. Allow requests even if page timeout or request limit reached. 
     * 	- getting plugin info 
     * 
     * @return bool
     */
    function manage_skip_request_timeout_limit($parsed_args = array(), $url = '')
    {
        // skip for stream requests 
        if (!empty($parsed_args['stream']))
        {
            return true;
        }

        // skip request timeout inside cron job 
        if ('cron' === self::current_page_type())
        {
            return true;
        }

        // check custom rules and skip if current rule allow
        if (self::$request_action === 'allow')
        {
            return true;
        }


        // skip for urls containing wp_scrape_key and wp_scrape_nonce. they are used to save cahnges in theme and plugin files by admin
        if (self::is_url_wp_scrape($url))
        {
            return true;
        }

        return false;
    }

    /**
     * Sanitize and return script name. 
     * 
     * @staticvar string $return
     * @return string
     */
    static public function var_server_script_name()
    {
        static $return = null;

        if (is_null($return))
        {

            // store sanitized value 
            if (isset($_SERVER['SCRIPT_NAME']))
            {
                $return = strtolower(sanitize_text_field($_SERVER['SCRIPT_NAME']));
            }
            else
            {
                $return = '';
            }
        }

        return $return;
    }

    /**
     * Sanitize and return script name. 
     * 
     * @staticvar string $return
     * @return string
     */
    static public function var_request_action()
    {
        static $return = null;

        if (is_null($return))
        {
            // store sanitized value 
            $return = strtolower(sanitize_text_field($_REQUEST['action']));
        }

        return $return;
    }

    function manage_delay_cron()
    {
        // set that we are managing cron. use this to change status from null. can be any non null value here. 
        // when status is null then we are not managing it. 
        self::$cron_status = false;

        // prevent early cron actions. execute cron on shutdown.
        add_action('pre_get_ready_cron_jobs', [$this, 'cron_prevent_early']);

        // execute prevented cron in shutdown
        add_action('shutdown', [$this, 'cron_prevent_early_shutdown']);
    }

    /**
     * get current page URL
     * 
     * @return string
     */
    static public function page_url()
    {
        if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['REQUEST_URI']))
        {
            $host = sanitize_text_field($_SERVER['HTTP_HOST']);
            $uri = sanitize_text_field($_SERVER['REQUEST_URI']);
            $current_url = (is_ssl() ? 'https://' : 'http://') . $host . $uri;
        }
        else
        {
            // use wordpress functions
            global $wp;
            $current_url = home_url(add_query_arg(array(), $wp->request));
        }

        return $current_url;
    }

    /**
     * can be used to generate unique id
     * 
     * @param int $length
     * @return string
     */
    static public function generate_random_letters($length = 6)
    {
        $random = '';
        for ($i = 0; $i < $length; $i++)
        {
            $random .= rand(0, 35) < 10 ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
        }
        return $random;
    }

    /**
     * disable non audio/video enclosure links
     * 
     * @param type $post_links
     * @param type $post_id
     * @return type
     */
    function disable_not_obvious_enclosure_links($post_links, $post_id)
    {
        $post_links_new = array();
        // allow only mp3, mp4 urls 
        if ($post_links)
        {
            // enclosures can be audio or video. keep them. 
            // use only: ext -> audio/video mime types 
            $mime_types = wp_get_mime_types();
            $mime_types_allowed = array();
            foreach ($mime_types as $exts => $mime)
            {
                if (strpos($mime, 'audio/') === 0 || strpos($mime, 'video/') === 0)
                {
                    $mime_types_allowed[$exts] = $mime;
                }
            }


            // make unique post links 
            $post_links_unique = array();
            foreach ($post_links as $url)
            {
                $url = strip_fragment_from_url($url);
                $post_links_unique[$url] = true;
            }
            $post_links = array_keys($post_links_unique);
            unset($post_links_unique);

            // check extension of url and keep mp3,mp4 urls only. other types are not enclosed anyway.
            foreach ($post_links as $url)
            {
                // check if it is not already added
                if (!isset($post_links_new[$url]))
                {
                    $url_parts = self::parse_url($url);

                    if (false !== $url_parts && !empty($url_parts['path']))
                    {
                        $extension = pathinfo($url_parts['path'], PATHINFO_EXTENSION);
                        if (!empty($extension))
                        {
                            foreach ($mime_types_allowed as $exts => $mime)
                            {
                                if (preg_match('!^(' . $exts . ')$!i', $extension))
                                {
                                    // allowed extension. can be enclosed 
                                    $post_links_new[$url] = true;
                                    break;
                                }
                            }
                        }
                    }
                }

                // record as prevented request if not enclosable 
                if (!isset($post_links_new[$url]))
                {
                    $this->manage_perform_request_blocking_by_url($url, 'enclosure_links');
                }
            }
        }

        // return unique urls
        return array_keys($post_links_new);
    }

    /**
     *  add settings link to plugin listing
     */
    function plugin_action_links($links, $file)
    {
        //Static so we don't call plugin_basename on every plugin row.
        static $this_plugin = null;
        if (is_null($this_plugin))
        {
            $this_plugin = plugin_basename(__FILE__);
        }
        if ($file == $this_plugin)
        {
            $settings_link = '<a href="' . esc_url(admin_url('tools.php?page=' . self::ID)) . '">' . self::translate('Settings') . '</a>';
            array_unshift($links, $settings_link); // before other links
        }
        return $links;
    }

    /**
     *  remove some features on deactivation
     */
    public static function plugin_deactivate()
    {
        //  remove MU Must-Use plugin file if exists
        self::load_must_use_remove();
    }

    /**
     *  perform on plugin activation
     */
    public static function plugin_activate()
    {
        self::load_must_use_apply();
    }

    function db_get_results($args)
    {
        global $wpdb;

        $defaults = [
            'page'        => 1,
            'per_page'    => 100,
            'orderby'     => 'date_added',
            'order'       => 'DESC',
            'search'      => '',
            'get_domains' => 0,
        ];

        $args = array_merge($defaults, $args);

        $output = array(
            'rows'  => array(),
            'pages' => array()
        );

        // orderby date_added identical to orderby id: so use id instead
        $orderby = in_array($args['orderby'], ['url', 'runtime']) ? $args['orderby'] : 'id';
        $order = in_array($args['order'], ['ASC', 'DESC']) ? $args['order'] : 'DESC';
        $page = intval($args['page']) < 1 ? 1 : intval($args['page']);
        $per_page = intval($args['per_page']) < 5 ? 5 : intval($args['per_page']);
        $limit = ( ( $page - 1 ) * $per_page ) . ',' . $per_page;
        $orderby_extra = $orderby !== 'id' ? ', id DESC' : '';

        /*
          id
          page_id
          url
          runtime
          request_status
          request_group
          request_source
          request_args
          response
          date_added
         */

        $sql = "
            SELECT
                SQL_CALC_FOUND_ROWS
                *
            FROM " . self::db_table_log() . " 
            ORDER BY $orderby $order $orderby_extra
            LIMIT $limit
        ";
        $results = $wpdb->get_results($sql, ARRAY_A);

        $total_rows = (int) $wpdb->get_var("SELECT FOUND_ROWS()");
        $total_pages = ceil($total_rows / $per_page);

        $this->pager_args = array(
            'page'        => $page,
            'per_page'    => $per_page,
            'total_rows'  => $total_rows,
            'total_pages' => $total_pages,
        );

        $arr_page_ids = array();

        foreach ($results as $row)
        {
            $row['page_id'] = intval($row['page_id']);
            $arr_page_ids[$row['page_id']] = $row['page_id'];

            $row['status_code'] = '-';

            $response = json_decode($row['response'], true);
            if (!empty($response['response']['code']))
            {
                $row['status_code'] = (int) $response['response']['code'];
            }

            if (self::trim_reponse_body($response))
            {
                // convert trimmed response back to json. if not trimmed then existing reponse already good to use and encoded.
                $row['response'] = self::json_encode($response);
            }


            $row['runtime'] = round($row['runtime'], 3);
            $row['date_raw'] = $row['date_added'];
            $row['date_added'] = HTTP_Requests_Manager::time_since($row['date_added']);
            $row['url'] = esc_url($row['url']);
            $row['request_source'] = esc_attr($row['request_source']);

            $output['rows'][] = $row;
        }

        // get pages 
        $output['pages'] = $this->db_get_pages_by_id($arr_page_ids);
        if (!empty($args['get_domains']))
        {
            if (!empty($output['rows']))
            {
                // has some logs
                // get domains
                $output['domains'] = $this->db_get_domains();
            }

            // get custom rules
            $output['custom_rules'] = self::get_option('custom_rules', array());
        }

        return $output;
    }

    function db_get_pages_by_id($ids)
    {
        global $wpdb;

        $output = array();

        if (count($ids))
        {
            // escape integers as string because of 2 number values can form range instead of individual ids
            $prepare_id_placeholders = implode(', ', array_fill(0, count($ids), '%s'));
            $prepare_values = array_values($ids);

            $sql = $wpdb->prepare("
					SELECT * 
					FROM " . self::db_table_page() . " 
					WHERE id IN ( $prepare_id_placeholders )					
				", $prepare_values);

            $results = $wpdb->get_results($sql, ARRAY_A);

            /*
              id
              url
              page_type
              runtime
              info
              date_added
             */
            foreach ($results as $k => $row)
            {
                $row['url'] = esc_url($row['url']);
                $row['runtime'] = round($row['runtime'], 3);

                $row['date_raw'] = $row['date_added'];
                $row['date_added'] = HTTP_Requests_Manager::time_since($row['date_added']);

                // remove requetss array from info
                if (!empty($row['info']))
                {
                    $info = json_decode($row['info'], true);
                    if (!empty($info['requests']))
                    {
                        unset($info['requests']);
                        $row['info'] = self::json_encode($info);
                    }
                }


                // add with id for easy navigation inside js
                $output[$row['id']] = $row;
            }
        }

        return $output;
    }

    function db_get_domains()
    {
        global $wpdb;

        $sql = "SELECT DISTINCT SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(url, '/', 3), '://', -1), '/', 1), '?', 1) AS domain FROM " . self::db_table_log() . " LIMIT 100";

        $output = $wpdb->get_results($sql, ARRAY_A);

        if (empty($output))
        {
            $output = array();
        }
        else
        {
            $return = array();
            foreach ($output as $val)
            {
                $domain = trim($val['domain']);
                if (strlen($domain))
                {
                    $return[] = $domain;
                }
            }
            $output = $return;
            sort($output);
        }


        return $output;
    }

    function db_truncate_table()
    {
        /* global $wpdb;

          $db_prefix = self::db_prefix();
          $wpdb->query("TRUNCATE TABLE {$db_prefix}log");
          $wpdb->query("TRUNCATE TABLE {$db_prefix}log_page");
         */

        // better delete and create table for consistency and fixing any table issues 
        self::db_drop_table();
        $this->db_create_table_log();
        $this->db_create_table_log_page();

        return true;
    }

    function db_paginate()
    {
        $params = $this->pager_args;

        $output = '';
        $page = (int) $params['page'];
        $per_page = (int) $params['per_page'];
        $total_rows = (int) $params['total_rows'];
        $total_pages = (int) $params['total_pages'];

        // Only show pagination when > 1 page
        if (1 < $total_pages)
        {

            if (3 < $page)
            {
                $output .= '<a class="vphrm-page first-page" data-page="1">&lt;&lt;</a>';
            }
            if (1 < ( $page - 10 ))
            {
                $output .= '<a class="vphrm-page" data-page="' . ($page - 10) . '">' . ($page - 10) . '</a>';
            }
            for ($i = 2; $i > 0; $i--)
            {
                if (0 < ( $page - $i ))
                {
                    $output .= '<a class="vphrm-page" data-page="' . ($page - $i) . '">' . ($page - $i) . '</a>';
                }
            }

            // Current page
            $output .= '<a class="vphrm-page active" data-page="' . $page . '">' . $page . '</a>';

            for ($i = 1; $i <= 2; $i++)
            {
                if ($total_pages >= ( $page + $i ))
                {
                    $output .= '<a class="vphrm-page" data-page="' . ($page + $i) . '">' . ($page + $i) . '</a>';
                }
            }
            if ($total_pages > ( $page + 10 ))
            {
                $output .= '<a class="vphrm-page" data-page="' . ($page + 10) . '">' . ($page + 10) . '</a>';
            }
            if ($total_pages > ( $page + 2 ))
            {
                $output .= '<a class="vphrm-page last-page" data-page="' . $total_pages . '">&gt;&gt;</a>';
            }
        }

        return $output;
    }

    function db_upgrade()
    {
        $version = HTTP_Requests_Manager::VERSION;

        $db_version = HTTP_Requests_Manager::get_option('version', 0);

        if (version_compare($db_version, $version, '<'))
        {
            if (version_compare($db_version, '1.0.9.2', '<'))
            {
                // remove old table 
                self::db_drop_table();

                require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

                $this->db_upgrade_clean_install();
            }
            else
            {
                $this->db_upgrade_run();
            }

            // perform MU file upgrade 
            self::load_must_use_upgrade_check();

            HTTP_Requests_Manager::update_option('version', $version);
        }
    }

    private function db_upgrade_clean_install()
    {
        $this->db_create_table_log();
        $this->db_create_table_log_page();
    }

    /**
     * 
      id
      page_id
      url
      runtime
      request_status
      request_group
      request_source
      request_args
      response
      date_added
     * 
     * @return type
     */
    static public function db_table_log()
    {
        return self::db_prefix() . 'log';
    }

    /**
     * 
      id
      url
      page_type
      runtime
      info
      date_added
     * 
     * @return type
     */
    static public function db_table_page()
    {
        return self::db_prefix() . 'log_page';
    }

    private function db_create_table_log()
    {
        global $wpdb;

        /* 		  
          request_status (blocked/failed/success)
          request_group (core/plugin/theme)
          request_source (core/plugin with name/theme with name)
         */

        $sql = "
        CREATE TABLE IF NOT EXISTS " . self::db_table_log() . " (
            id BIGINT unsigned not null auto_increment,
            page_id BIGINT unsigned not null,
            url TEXT(2048),
            runtime DECIMAL(10,3),
            request_status VARCHAR(20),
            request_group VARCHAR(20),
            request_source VARCHAR(255),
            request_args MEDIUMTEXT,
            response MEDIUMTEXT,            
            date_added DATETIME,
            PRIMARY KEY (id),
			KEY `page_id` (`page_id`),
			KEY `runtime` (`runtime`)
        ) DEFAULT CHARSET=utf8mb4";
        $wpdb->query($sql);
    }

    private function db_create_table_log_page()
    {
        global $wpdb;

        /*
         * page_type : admin, frontent, cron, ajax, login
         */

        $sql = "
        CREATE TABLE IF NOT EXISTS " . self::db_table_page() . " (
            id BIGINT unsigned not null auto_increment,
            url TEXT(2048),
			page_type VARCHAR(20),
			runtime DECIMAL(10,3),            
            info MEDIUMTEXT,            
            date_added DATETIME,
            PRIMARY KEY (id),
			KEY `runtime` (`runtime`)
        ) DEFAULT CHARSET=utf8mb4";
        $wpdb->query($sql);
    }

    /**
     * Check if main table created 
     * 
     * @global type $wpdb
     */
    private function db_check_create_tables()
    {
        global $wpdb;

        // log
        $table_name = self::db_table_log();
        if ($wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $table_name)) != $table_name)
        {
            // table not found create it 
            $this->db_create_table_log();
        }

        // log_page
        $table_name = self::db_table_page();
        if ($wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $table_name)) != $table_name)
        {
            // table not found create it 
            $this->db_create_table_log_page();
        }
    }

    private function db_upgrade_run()
    {
        global $wpdb;

        $version = HTTP_Requests_Manager::VERSION;
        $db_version = HTTP_Requests_Manager::get_option('version', 0);

        if (version_compare($db_version, '1.3.5', '<'))
        {
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

            // increase request_source varchar length to 255
            // ALTER TABLE `wp_vphrm_log` CHANGE `request_source` `request_source` varchar(255);
            $wpdb->query("ALTER TABLE " . self::db_table_log() . " CHANGE `request_source` `request_source` varchar(255)");
        }
    }

    /**
     * self ping is slow. disable self ping 
     * add_action( 'pre_ping', 'disable_self_ping' );
     * add_action('pre_ping', [$this, 'disable_self_ping']);
     * 
     * @param type $links
     */
    function disable_self_ping(&$links)
    {
        $home = get_option('home');

        // try http and https version
        $home_alt = preg_replace("/^http:/i", "https:", $home);
        if ($home_alt === $home)
        {
            $home_alt = preg_replace("/^https:/i", "http:", $home);
        }

        $arr_unset = array();
        foreach ($links as $l => $link)
        {
            if (0 === strpos($link, $home) || 0 === strpos($link, $home_alt))
            {
                $arr_unset[] = $l;
                // unset later because unsetting here will skip some links as array size changes inside this loop.
                // unset($links[$l]);

                $this->manage_perform_request_blocking_by_url($link, 'pre_ping');
            }
        }

        foreach ($arr_unset as $l)
        {
            unset($links[$l]);
        }
    }

    function disable_maybe_update_filter($value, $filter)
    {
        // has last_checked value defined 
        if (self::current_page_type() === 'admin' && isset($value->last_checked))
        {

            // call backtrace once to prevent calling 4 times for single check.
            $backtrace_array = wp_debug_backtrace_summary('HTTP_Requests_Manager', 1, false);

            $prevent = false;

            switch ($filter)
            {
                case 'update_plugins':
                    // is _maybe_update_plugins
                    $prevent = (self::current_has_parent_function('_maybe_update_plugins', $backtrace_array) && !self::current_has_parent_function('wp_update_plugins', $backtrace_array));
                    break;
                case 'update_themes':
                    // is _maybe_update_themes
                    $prevent = (self::current_has_parent_function('_maybe_update_themes', $backtrace_array) && !self::current_has_parent_function('wp_update_themes', $backtrace_array));
                    break;
                case 'update_core':
                    $prevent = (self::current_has_parent_function('_maybe_update_core', $backtrace_array) && !self::current_has_parent_function('update_core', $backtrace_array));
                    break;
            }

            // preventh update check by setting last check to current time
            if ($prevent)
            {
                $value->last_checked = time();
            }
        }
        return $value;
    }

    static public function nice_bytes($bytes)
    {
        $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
        for ($i = 0; $bytes >= 1024 && $i < ( count($label) - 1 ); $bytes /= 1024, $i++)
            ;
        return( round($bytes, 2) . " " . $label[$i] );
    }

    static public function translate($text)
    {
        return self::$init_done ? __($text, 'http-requests-manager') : $text;
    }
}

function VPHRM()
{
    return HTTP_Requests_Manager::instance();
}

VPHRM();

