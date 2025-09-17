<?php
/**
 * Plugin Name: Submittal
 * Version: 0.01
 * Author: Vitaliy A.
 */

if (!defined('ABSPATH')) exit;

class Submittal {
    public const DEFAULT_SUBMITTAL_NAME = 'Default';
    public const PAGE_SLUG = 'submittals';
    public const PAGE_SPECIFICATION_SLUG = 'submittal-specification';
    public const USER_COOKIE_KEY = 'submittal_user_key';
    public const DAYS_COOKIE_LIVES = 400; // maximum allowed by browsers

    private $charset;
    private $prefix;

    private $table_submittal_users;
    private $table_submittals;
    private $table_submittal_products;
    private $table_submittal_details;

    function __construct()
    {
        // @TODO add global checking of pages that plugin is running on
        global $wpdb;
        $this->charset = $wpdb->get_charset_collate();
        $this->prefix = $wpdb->prefix;

        $this->table_submittal_users = $this->prefix . 'submittal_users';
        $this->table_submittals = $this->prefix . 'submittals';
        $this->table_submittal_products = $this->prefix . 'submittal_products';
        $this->table_submittal_details = $this->prefix . 'submittal_details';

        add_action('activate_submittal/submittal.php', [$this, 'onActivate']);
        add_filter('template_include', [$this, 'loadTemplate'], 99);
        add_action('wp', [$this, 'addSubmittalButton'], 15);

        // ajax action on product page
        add_action('wp_ajax_nopriv_add_to_submittal', [$this, 'handleAddButton']);
        add_action('wp_ajax_nopriv_remove_from_submittal', [$this, 'handleRemoveButton']);

        add_action('wp_ajax_nopriv_is_in_submittal', [$this, 'handleIsProductInSubmittal']);
        add_action('wp_ajax_is_in_submittal', [$this, 'handleIsProductInSubmittal']);

        add_action('wp_ajax_add_to_submittal', [$this, 'handleAddButton']);
        add_action('wp_ajax_remove_from_submittal', [$this, 'handleRemoveButton']);
        add_action('wp_ajax_remove_from_submittal_page', [$this, 'handleRemoveButton']);
        add_action('wp_ajax_send_submittal_email', [$this, 'handleSendEmail']);
        add_action('wp_ajax_nopriv_send_submittal_email', [$this, 'handleSendEmail']);

        add_action('wp_ajax_create_submittal', [$this, 'handleCreateSubmittal']);
        add_action('wp_ajax_nopriv_create_submittal', [$this, 'handleCreateSubmittal']);

        add_action('wp_ajax_set_submittal', [$this, 'handleSetSubmittal']);
        add_action('wp_ajax_nopriv_set_submittal', [$this, 'handleSetSubmittal']);

        add_action('wp_ajax_remove_submittal', [$this, 'handleRemoveSubmittal']);
        add_action('wp_ajax_nopriv_remove_submittal', [$this, 'handleRemoveSubmittal']);

        add_action('wp_enqueue_scripts', [$this, 'enqueueSubmittalScripts']);
        add_action('wp_login', [$this, 'onLogin'], 10, 2);
        add_action('wp_logout', [$this, 'onLogout']);

        add_action('admin_menu', [$this, 'adminSettingsPage']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdminScripts']);
    }

    public function onActivate() {
        add_option('submittal_pdf_store_path', '/opt/bitnami/pdfstorage/');
        add_option('submittal_pdf_view_path', 'https://nsi-submittal-pdf-hotfix.s3.amazonaws.com/');

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $create_submittal_users_table = "CREATE TABLE {$this->table_submittal_users} (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            user_id bigint(20) unsigned DEFAULT NULL,
            cookie_id varchar(25) DEFAULT NULL UNIQUE,
            current_submittal_id bigint(20) unsigned DEFAULT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id),
            FOREIGN KEY (user_id) REFERENCES {$this->prefix}users(id) ON DELETE SET NULL
        ) {$this->charset};";

        $create_submittals_table = "CREATE TABLE {$this->table_submittals} (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            user_id bigint(20) unsigned NOT NULL,
            title varchar(255) NOT NULL DEFAULT '" . self::DEFAULT_SUBMITTAL_NAME . "',
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            deleted_at datetime DEFAULT NULL,
            deleted_by bigint(20) unsigned DEFAULT NULL,
            PRIMARY KEY  (id),
            FOREIGN KEY (user_id) REFERENCES {$this->table_submittal_users}(id) ON DELETE CASCADE
        ) {$this->charset};";

        $create_submittal_products_table = "CREATE TABLE {$this->table_submittal_products} (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            submittal_id bigint(20) unsigned NOT NULL,
            product_id bigint(20) unsigned NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id),
            FOREIGN KEY (submittal_id) REFERENCES {$this->table_submittals}(id) ON DELETE CASCADE
        ) {$this->charset};";

        $create_submittal_details_table = "CREATE TABLE {$this->table_submittal_details} (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            submittal_id bigint(20) unsigned NOT NULL,
            emails text NOT NULL,
            pdf text NOT NULL,
            cover_letter text DEFAULT NULL,
            success tinyint unsigned DEFAULT 0 NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id),
            FOREIGN KEY (submittal_id) REFERENCES {$this->table_submittals}(id) ON DELETE CASCADE
        ) {$this->charset};";

        dbDelta($create_submittal_users_table);
        dbDelta($create_submittals_table);
        dbDelta($create_submittal_products_table);
        dbDelta($create_submittal_details_table);

        if (!get_page_by_path(self::PAGE_SLUG)) {
            wp_insert_post([
                'post_title' => ucfirst(self::PAGE_SLUG),
                'post_status' => 'publish',
                'post_type' =>'page',
            ]);
        }

        if (!get_page_by_path(self::PAGE_SPECIFICATION_SLUG)) {
            wp_insert_post([
                'post_title' => ucwords(str_replace('-', ' ', self::PAGE_SPECIFICATION_SLUG)),
                'post_status' => 'publish',
                'post_type' =>'page',
            ]);
        }
    }

    public function onLogin($name, $user) {
        global $wpdb;

        $user_cookie_id = $wpdb->get_var($wpdb->prepare("
            SELECT `cookie_id`
            FROM {$this->table_submittal_users}
            WHERE `user_id` = %d",
            [$user->ID]
        ));

        if ($user_cookie_id) {
            setcookie(
                self::USER_COOKIE_KEY,
                $user_cookie_id,
                time() + self::DAYS_COOKIE_LIVES * DAY_IN_SECONDS,
                COOKIEPATH,
                COOKIE_DOMAIN
            );
        } elseif (isset($_COOKIE[self::USER_COOKIE_KEY])) {
            $wpdb->update(
                $this->table_submittal_users,
                ['user_id' => $user->ID],
                ['cookie_id' => $_COOKIE[self::USER_COOKIE_KEY]]
            );
        }
    }

    public function onLogout() {
        setcookie(
            self::USER_COOKIE_KEY,
            '',
            time() - DAY_IN_SECONDS,
            COOKIEPATH,
            COOKIE_DOMAIN
        );
    }

    private function getCurrentSubmittalId($user_cookie_id) {
        global $wpdb;

        return $wpdb->get_var($wpdb->prepare("
            SELECT `current_submittal_id`
            FROM {$this->table_submittal_users}
            WHERE `cookie_id` = %s",
            [$user_cookie_id]
        ));
    }

    public function addSubmittalButton(): void
    {
        global $post;

        if ( ! isset( $post ) || empty( $post->ID ) ) {
            return;
        }

        $post_id = $post->ID;
        $product = wc_get_product( $post_id );

        if ( empty( $product ) ) {
            return;
        }

        $is_purchasable = !empty($product) && $product->is_purchasable();

        add_action(
            is_user_logged_in() && $is_purchasable?
                'woocommerce_after_add_to_cart_button' :
                'woocommerce_single_product_summary',
            [$this, 'addSubmittalButtonElement'],
            40
        );
    }

    public function addSubmittalButtonElement() {
        global $product;
        
        echo '<button id="submittal-button" data-product-id="' . $product->get_id() .
            '"data-action="add" class="button alt">Add to submittal</button>';
    }

    public function createSubmittal($title = self::DEFAULT_SUBMITTAL_NAME) {
        global $wpdb;
 
        $wpdb->insert(
            $this->table_submittals,
            [
                'user_id' => get_current_user_id(),
                'title' => $title,
            ]
        );
    }

    public function loadTemplate($template) {
        if (is_page(self::PAGE_SLUG)) {
            return isset($_COOKIE[self::USER_COOKIE_KEY]) ?
                plugin_dir_path(__FILE__) . 'inc/template-products.php' :
                plugin_dir_path(__FILE__) . 'inc/template-empty.php';
        }

        if (is_page(self::PAGE_SPECIFICATION_SLUG)) {
            if (!isset($_COOKIE[self::USER_COOKIE_KEY])) {
                wp_redirect(home_url());
                exit;
            }

            return plugin_dir_path(__FILE__) . 'inc/template-specification.php';
        }

        return $template;
    }

    private function createDefaultSubmittal($title = self::DEFAULT_SUBMITTAL_NAME) {
        global $wpdb;

        $user_cookie_id = uniqid();

        setcookie(
            self::USER_COOKIE_KEY,
            $user_cookie_id,
            time() + self::DAYS_COOKIE_LIVES * DAY_IN_SECONDS,
            COOKIEPATH,
            COOKIE_DOMAIN
        );

        $wpdb->insert(
            $this->table_submittal_users,
            [
                'user_id' => get_current_user_id() ?: NULL,
                'cookie_id' => $user_cookie_id,
            ]
        );

        $submittal_user_id = $wpdb->insert_id;

        $wpdb->insert(
            $this->table_submittals,
            [
                'user_id' => $submittal_user_id,
                'title' => $title,
            ]
        );

        $submittal_id = $wpdb->insert_id;

        $wpdb->update(
            $this->table_submittal_users,
            ['current_submittal_id' => $submittal_id],
            ['id' => $submittal_user_id]
        );

        return $submittal_id;
    }

    public function handleAddButton() {
        global $wpdb;

        if (isset($_COOKIE[self::USER_COOKIE_KEY])) {
            $current_submittal_id = $this->getCurrentSubmittalId($_COOKIE[self::USER_COOKIE_KEY]);

            // check if product is already in submittal
            $id = $wpdb->get_var($wpdb->prepare("
                SELECT `id`
                FROM {$this->table_submittal_products}
                WHERE
                    `submittal_id` = %d AND
                    `product_id` = %d",
                [$current_submittal_id, $_POST['product_id']]
            ));

            if ($id) {
                wp_send_json_error('Product is already in submittal', 409);
                return;
            }
        } else {
            $current_submittal_id = $this->createDefaultSubmittal();
        }

        $wpdb->insert(
            $this->table_submittal_products,
            [
                'submittal_id' => $current_submittal_id,
                'product_id' => $_POST['product_id'],
            ]
        );

        wp_send_json([]);
        return;
    }

    public function handleRemoveButton() {
        if (!isset($_COOKIE[self::USER_COOKIE_KEY])) {
            wp_send_json_error('Cookie is missed', 403);
            return;
        }

        global $wpdb;

        $wpdb->delete(
            $this->table_submittal_products,
            [
                'submittal_id' => $this->getCurrentSubmittalId($_COOKIE[self::USER_COOKIE_KEY]),
                'product_id' => $_POST['product_id'],
            ]
        );

        wp_send_json([]);
        return;
    }

    public function handleCreateSubmittal() {
        if (!isset($_POST['title'])) {
            wp_send_json_error('Title is required', 400);
            return;
        }

        $title = trim($_POST['title']);
        
        if (mb_strlen($title) === 0 || mb_strlen($title) > 255 ) {
            wp_send_json_error('Title length is invalid', 400);
            return;
        }
        
        global $wpdb;

        if (!isset($_COOKIE[self::USER_COOKIE_KEY])) {
            $this->createDefaultSubmittal($title);
        } else {
            $submittal_user_id = $wpdb->get_var($wpdb->prepare("
                SELECT `id`
                FROM {$this->table_submittal_users}
                WHERE `cookie_id` = %s",
                [$_COOKIE[self::USER_COOKIE_KEY]]
            ));

            $submittal_exists = $wpdb->get_var($wpdb->prepare("
                SELECT `id`
                FROM {$this->table_submittals}
                WHERE
                    `title` = %s AND
                    `user_id` = %d AND
                    `deleted_at` IS NULL",
                [
                    $title,
                    $submittal_user_id,
                ]
            ));

            if ($submittal_exists) {
                wp_send_json_error('Submittal with entered name already exists. Submittal name shall be unique', 400);
                return;
            }

            $wpdb->insert(
                $this->table_submittals,
                [
                    'title' => $title,
                    'user_id' => $submittal_user_id,
                ]
            );

            $submittal_id = $wpdb->insert_id;

            $wpdb->update(
                $this->table_submittal_users,
                ['current_submittal_id' => $submittal_id],
                ['id' => $submittal_user_id]
            );
        }

        wp_send_json([]);
        return;
    }

    public function handleSetSubmittal() {
        if (!isset($_COOKIE[self::USER_COOKIE_KEY])) {
            wp_send_json_error('Cookie is missed', 403);
            return;
        }

        if (!isset($_POST['id'])) {
            wp_send_json_error('Id is required', 400);
            return;
        }

        global $wpdb;

        $submittal_user_id = $wpdb->get_var($wpdb->prepare("
            SELECT `id`
            FROM {$this->table_submittal_users}
            WHERE `cookie_id` = %s",
            [$_COOKIE[self::USER_COOKIE_KEY]]
        ));

        $submittal_id = $wpdb->get_var($wpdb->prepare("
            SELECT `id`
            FROM {$this->table_submittals}
            WHERE
                `id` = %d AND 
                `user_id` = %d AND
                `deleted_at` IS NULL",
            [$_POST['id'], $submittal_user_id]
        ));

        if (!$submittal_id) {
            wp_send_json_error('Id is invalid', 400);
            return;
        }

        $wpdb->update(
            $this->table_submittal_users,
            ['current_submittal_id' => $submittal_id],
            ['id' => $submittal_user_id]
        );

        wp_send_json([]);
        return;
    }

    public function handleRemoveSubmittal() {
        if (!isset($_COOKIE[self::USER_COOKIE_KEY])) {
            wp_send_json_error('Cookie is missed', 403);
            return;
        }

        global $wpdb;

        $submittalUser = $wpdb->get_row($wpdb->prepare("
            SELECT *
            FROM {$this->table_submittal_users}
            WHERE `cookie_id` = %s",
            [$_COOKIE[self::USER_COOKIE_KEY]]
        ));

        $submittalsCount = $wpdb->get_var($wpdb->prepare("
            SELECT COUNT(*)
            FROM {$this->table_submittals}
            WHERE
                `user_id` = %d AND
                `deleted_at` IS NULL",
            [$submittalUser->id]
        ));
        
        if ($submittalsCount < 2) {
            wp_send_json_error('Last submittal can not be removed', 400);
            return;
        }

        $wpdb->query($wpdb->prepare("
            UPDATE {$this->table_submittals}
            SET
                `deleted_at` = CURRENT_TIMESTAMP
            WHERE
                `id` = %d",
            [$submittalUser->current_submittal_id]
        ));

        $submittal_id = $wpdb->get_var($wpdb->prepare("
            SELECT `id`
            FROM {$this->table_submittals}
            WHERE
                `user_id` = %d AND
                `deleted_at` IS NULL
            ORDER BY `id` DESC",
            [$submittalUser->id]
        ));

        $wpdb->update(
            $this->table_submittal_users,
            ['current_submittal_id' => $submittal_id],
            ['id' => $submittalUser->id]
        );

        wp_send_json([]);
        return;
    }

    public function handleIsProductInSubmittal() {
        if (!isset($_COOKIE[self::USER_COOKIE_KEY])) {
            wp_send_json_error('Cookie is missed', 403);
            return;
        }

        global $wpdb;

        $id = $wpdb->get_var($wpdb->prepare("
            SELECT su.`id`
            FROM {$this->table_submittal_users} su
            INNER JOIN {$this->table_submittal_products} sp
                ON su.`current_submittal_id` = sp.`submittal_id` AND
                sp.`product_id` = %d
            WHERE
                su.`cookie_id` = %s",
            [
                $_POST['product_id'],
                $_COOKIE[self::USER_COOKIE_KEY],
            ]
        ));

        wp_send_json(['in_submittal' => (bool)$id]);
        return;
    }

    public function handleSendEmail() {
        if (!isset($_COOKIE[self::USER_COOKIE_KEY])) {
            wp_send_json_error('Cookie is missed', 403);
            return;
        }

        $current_submittal_id = $this->getCurrentSubmittalId($_COOKIE[self::USER_COOKIE_KEY]);
        
        if (!$current_submittal_id) {
            wp_send_json_error('Submittal is not set', 403);
            return;
        }

        $emails = explode(',', $_POST['emails']);

        if (count($emails) < 1 || count($emails) > 5) {
            wp_send_json_error('Max allowed number of recipients is 5', 400);
            return;
        }

        $emails = array_map('trim', $emails);
        foreach ($emails as $email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                wp_send_json_error('Invalid email: ' . $email, 400);
                return;
            }
        }

        $coverLetter = [];
        $coverLetterColumn = [];

        if ($_POST['coverLetter']['include'] === 'true') {
            $coverLetterFields = [
                'date' => 'Date',
                'projectName' => 'Project Name',
                'generalContractor' => 'General Contractor',
                'electricalContractor' => 'Electrical Contractor',
                'engineer' => 'Engineer/Architect',
                'salesContact' => 'Sales Representative Contact',
            ];

            foreach ($coverLetterFields as $field => $label) {
                if (
                    isset($_POST['coverLetter'][$field]) &&
                    $_POST['coverLetter'][$field]
                ) {
                    $value = trim($_POST['coverLetter'][$field]);
                    
                    if (mb_strlen($value) > 255) {
                        wp_send_json_error('Invalid cover letter field: ' . $label, 400);
                        return;
                    }

                    $coverLetter[] = [
                        'label' => $label,
                        'value' => $value,
                    ];

                    $coverLetterColumn[$field] = $value;
                }
            }
        }

        $filePath = get_option('submittal_pdf_store_path');
        $fileName = generate_pdf($coverLetter);

        global $wpdb;

        $wpdb->insert(
            $this->table_submittal_details,
            [
                'submittal_id' => $current_submittal_id,
                'emails' => implode(',', $emails),
                'pdf' => $fileName,
                'cover_letter' => $coverLetterColumn ? json_encode($coverLetterColumn) : NULL,
            ]
        );

        $submittal_details_id = $wpdb->insert_id;

        $title = $wpdb->get_var($wpdb->prepare("
            SELECT `title`
            FROM {$this->table_submittals}
            WHERE `id` = %d",
            [$current_submittal_id]
        ));

        $logo = '<a href="' . home_url('/') . '"><img alt="NSI Logo" src="' . 
            wp_get_attachment_image_url(
                get_option('theme_config_site_logo_color'),
                'large'
            ) . '" /></a>';

        foreach($emails as $email) {
            wp_mail(
                $email, 
                "Your {$title} Project Submittal",
                'Thank you for creating a project submittal with NSI! If you need any additional information, please don’t hesitate to reach out to your sales rep or our <a href="mailto:techteam@nsiindustries.com">technical support team</a>. We look forward to assisting you with your project needs.<br /><br />Best regards,<br />The NSI Team<br /><a href="https://www.nsiindustries.com">nsiindustries.com</a><br />' . $logo, 
                [
                    'Content-Type: text/html; charset=UTF-8',
                // 'From: ' . get_bloginfo('name') . ' <' . get_bloginfo('admin_email') . '>',
                // 'Bcc: ' . get_bloginfo('admin_email'),
                // 'Reply-To: ' . get_bloginfo('admin_email'),
                ], 
                $filePath . $fileName
            );
        }
       
        $wpdb->update(
            $this->table_submittal_details,
            ['success' => 1],
            ['id' => $submittal_details_id]
        );

        wp_send_json([]);
        return;
    }

    public function enqueueSubmittalScripts() {

        wp_enqueue_script('Google-reCaptcha-explicit-v2',
            '//www.google.com/recaptcha/api.js?render=explicit',
            array( 'jquery' ), '1.0.0', array ('strategy' => 'defer'));

        if (is_product()) {
            wp_register_script(
                'submittalProductPage', 
                plugins_url('js/submittal-product-page.js', __FILE__),
                ['jquery']
            );
    
            wp_localize_script(
                'submittalProductPage',
                'SubmittalData', 
                [
                    'ajaxUrl' => admin_url('admin-ajax.php'),
                ]
            );
            
            wp_enqueue_script('submittalProductPage');
        }

        wp_register_script(
            'submittalScript', 
            plugins_url('js/submittal.js', __FILE__),
            ['jquery']
        );

        wp_localize_script(
            'submittalScript',
            'SubmittalData', 
            [
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'specificationPageUrl' => get_permalink(get_page_by_path(self::PAGE_SPECIFICATION_SLUG)),
            ]
        );
        
        wp_enqueue_script('submittalScript');

        wp_enqueue_style(
            'submittal-css',
            plugins_url('css/submittal.css', __FILE__)
        );

    }

    public function adminSettingsPage() {
        add_menu_page(
            'Submittals',
            'Submittals',
            'manage_options',
            'submittals',
            [$this, 'adminSettingsPageHtml'],
            'dashicons-media-text',
            58 // position
        );

        add_submenu_page(
            null,
            'View Submittal Details',
            'View Submittal Details', 
            'manage_options',
            'submittal-details',
            [$this, 'adminSubmittalDetailsPageHtml']
        );
    }
    
    public function adminSettingsPageHtml() { 
        require_once plugin_dir_path(__FILE__) . 'inc/SubmittalListTable.php'; 
    ?>
        <div class="wrap">
            <h2>Submittals</h2>
            <form method="POST">
                <?php
                    $list = new SubmittalListTable();
                    $list->prepare_items();
                    $list->search_box('Search', 'submittal-search');
                    $list->display();
                ?>
            </form>
        </div>
    <?php }

    public function adminSubmittalDetailsPageHtml() { 
        $nonce = $_GET['_wpnonce'];
    
        if (!wp_verify_nonce($nonce, 'view_submittal')) {
            wp_die('Security error');
        }

        require_once plugin_dir_path(__FILE__) . 'inc/admin-submittal-details.php';

    ?>
    <?php }

    public function enqueueAdminScripts() {
        wp_enqueue_style(
            'submittal-admin-css',
            plugins_url('css/submittal-admin.css', __FILE__)
        );
        wp_enqueue_script(
            'submittal-admin-js',
            plugins_url('js/submittal-admin.js', __FILE__),
            ['jquery']
        );
    }
}

$submittal = new Submittal();

require_once plugin_dir_path(__FILE__) . 'inc/pdf.php';