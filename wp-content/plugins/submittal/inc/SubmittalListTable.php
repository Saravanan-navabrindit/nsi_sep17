<?php

if (!defined('ABSPATH')) exit;

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class SubmittalListTable extends WP_List_Table
{
    public const ITEMS_PER_PAGE = 20;

    function get_columns() {
        return [
            'cb' => '<input type="checkbox" />',
            'id' => 'ID',
            'user' => 'User',
            'title' => 'Title',
            'recipients' => 'Recipients',
            'is_current' => 'Is Current',
            'created_at' => 'Created At',
            'deleted_at' => 'Deleted At',
        ];
    }

    private function get_where_query() {
        if (empty($_GET['user'])) {
            return '';
        }

        global $wpdb;
        return $wpdb->prepare(" WHERE s.user_id = %d", $_GET['user']);
    }

    private function get_search_query() {
        global $wpdb;

        $conditions = [];

        if (!empty($_GET['domain'])) {
            $conditions[] = [
                'query' => 'recipients LIKE %s',
                'values' => [
                    '%@' . $wpdb->esc_like($_GET['domain']) . '%',
                ],
            ];
        }

        if (!empty($_POST['s'])) {
            $value = '%' . $wpdb->esc_like($_POST['s']) . '%';
            $conditions[] = [
                'query' => '(title LIKE %s OR recipients LIKE %s)',
                'values' => [
                    $value,
                    $value,
                ],
            ];
        }

        if (!empty($conditions)) {
            $query = ' WHERE ' . implode(' AND ', array_column($conditions, 'query'));
            $values = array_column($conditions, 'values');

            return $wpdb->prepare(
                $query,
                array_merge(...$values)
            );
        }

        return '';
    }

    private function get_limit_offset_query() {
        $currentPage = $this->get_pagenum();
        $limit = self::ITEMS_PER_PAGE;
        $offset = ($currentPage - 1) * $limit;

        global $wpdb;
        return $wpdb->prepare(' LIMIT %d OFFSET %d', $limit, $offset);
    }

    private function get_order_by_query() {
        if (empty($_GET['orderby'])) {
            return '';
        }
        
        $allowedFields = array_column($this->get_sortable_columns(), 0);
        
        if (!in_array($_GET['orderby'], $allowedFields, true)) {
            return '';
        }

        $direction = (empty($_GET['order']) || $_GET['order'] === 'asc') ? 'ASC' : 'DESC';

        global $wpdb;
        return $wpdb->prepare(' ORDER BY %i ' . $direction, $_GET['orderby']);
    }

    private function get_table_data() {
        global $wpdb;
        return $wpdb->get_results("
            SELECT * FROM (
                SELECT
                    s.id,
                    COALESCE(u.user_login, su.id) AS user,
                    s.title,
                    GROUP_CONCAT(sd.emails) AS recipients,
                    IF(s.id = su.current_submittal_id, 'yes', 'no') AS is_current,
                    s.created_at,
                    s.deleted_at
                FROM {$wpdb->prefix}submittals s
                LEFT JOIN {$wpdb->prefix}submittal_users su 
                    ON su.id = s.user_id
                LEFT JOIN {$wpdb->prefix}users u 
                    ON u.id = su.user_id
                LEFT JOIN {$wpdb->prefix}submittal_details sd
                    ON s.id = sd.submittal_id" .
                $this->get_where_query() .
                " GROUP by s.id
            ) AS subquery" . 
            $this->get_search_query() .
            $this->get_order_by_query() .
            $this->get_limit_offset_query(),
            ARRAY_A
        );
    }

    private function get_total_items() {
        global $wpdb;
        return $wpdb->get_var("
            SELECT COUNT(*) FROM (
                SELECT
                    s.title,
                    GROUP_CONCAT(sd.emails) AS recipients
                FROM {$wpdb->prefix}submittals s
                LEFT JOIN {$wpdb->prefix}submittal_details sd
                    ON s.id = sd.submittal_id" .
                $this->get_where_query() .
                " GROUP by s.id
            ) AS subquery" . 
            $this->get_search_query()
        );
    }

    function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'id':
            case 'user':
            case 'title':
            case 'recipients':
            case 'is_current':
            case 'created_at':
            case 'deleted_at':
            default:
                return $item[$column_name];
        }
    }

    function prepare_items()
    {
        $this->process_bulk_action();

        if ($this->current_action() === 'delete') {
            $this->delete_submittal(absint($_GET['submittal_id']), $_GET['_wpnonce']);
        }

        $columns = $this->get_columns();
        $hidden = [];
        $sortable = $this->get_sortable_columns();
        $primary = 'id';
        $this->_column_headers = [$columns, $hidden, $sortable, $primary];

        $totalItems = $this->get_total_items();

        $this->set_pagination_args([
            'total_items' => $totalItems,
            'per_page'    => self::ITEMS_PER_PAGE,
            'total_pages' => ceil($totalItems / self::ITEMS_PER_PAGE)
        ]);
        
        $this->items = $this->get_table_data();
    }

    function column_cb($item)
    {
        return sprintf(
                '<input type="checkbox" name="ids[]" value="%s" />',
                $item['id']
        );
    }

    protected function get_sortable_columns()
    {
        return [
            'title' => ['title', false],
            'user' => ['user', false],
            'created_at' => ['created_at', true],
            'deleted_at' => ['deleted_at', true],
        ];
    }

    function column_title($item)
    {
        $deleteNonce = wp_create_nonce('delete_submittal');
        $viewNonce = wp_create_nonce('view_submittal');

        $actions = [
            'view' => sprintf(
                '<a href="?page=submittal-details&action=%s&submittal_id=%d&_wpnonce=%s">View</a>',
                'view',
                absint($item['id']),
                $viewNonce
            ),
        ];

        if ($item['is_current'] === 'no' && $item['deleted_at'] === null) {
            $queryFields = ['user', 'orderby', 'order', 'paged'];
            $qeuryData = array_intersect_key($_GET, array_flip($queryFields));

            $actions['delete'] = sprintf(
                '<a href="?page=%s&action=%s&submittal_id=%d&_wpnonce=%s&%s">Delete</a>',
                esc_attr($_REQUEST['page']),
                'delete', 
                absint($item['id']),
                $deleteNonce,
                http_build_query($qeuryData)
            );
        }

        return sprintf(
            '%1$s %2$s',
            $item['title'],
            $this->row_actions($actions)
        );
    }

    function column_recipients($item)
    {
        $emails = explode(',', $item['recipients']);
        return implode(', ', array_unique($emails));
    }

    function get_bulk_actions()
    {
        return [
            'bulk_delete' => 'Delete',
        ];
    }

    function extra_tablenav($which) {
        if ($which !== 'top') {
            return;
        } 
        
        global $wpdb;
        $users = $wpdb->get_results("
            SELECT
                su.id,
                COALESCE(u.user_login, su.id) as user
            FROM {$wpdb->prefix}submittal_users su
            LEFT JOIN {$wpdb->prefix}users u 
                ON u.id = su.user_id",
            ARRAY_A
        ); 
        
        $emails = $wpdb->get_var("
            SELECT
                GROUP_CONCAT(DISTINCT emails)
            FROM {$wpdb->prefix}submittal_details"
        );

        $domains = array_map(function($email) {
            return explode('@', $email)[1];
        }, explode(',', $emails));
        $uniqueDomains = array_unique($domains);
        sort($uniqueDomains); ?>
        <div class="alignleft actions">
            <label for="filter-by-user">
                <select name="user" id="filter-by-user">
                    <option value="">All users</option>
                    <?php foreach ($users as $user) {
                        printf(
                            '<option value="%s" %s>%s</option>',
                            $user['id'],
                            isset($_GET['user']) && $_GET['user'] == $user['id'] ? 'selected' : '',
                            $user['user']
                        );
                    } ?>
                </select>
            </label>
            <label for="filter-by-domain">
                <select name="domain" id="filter-by-domain">
                    <option value="">All domains</option>
                    <?php foreach ($uniqueDomains as $domain) {
                        printf(
                            '<option value="%s" %s>%s</option>',
                            $domain,
                            isset($_GET['domain']) && $_GET['domain'] == $domain ? 'selected' : '',
                            $domain
                        );
                    } ?>
                </select>
            </label>
            <button 
                id="submittal-list-filter"
                class="button"
                type="submit"
            >
                Filter
            </button>
        </div>
    <?php }

    function delete_submittal($submittal_id, $nonce) {
        if (!wp_verify_nonce($nonce, 'delete_submittal')) {
            wp_die('Security error');
        }

        global $wpdb;

        $wpdb->query($wpdb->prepare("
            UPDATE {$wpdb->prefix}submittals s
            LEFT JOIN {$wpdb->prefix}submittal_users su 
                ON su.`id` = s.`user_id`
            SET
                s.`deleted_at` = CURRENT_TIMESTAMP,
                s.`deleted_by` = %d
            WHERE
                s.`deleted_at` IS NULL AND
                s.`id` != su.`current_submittal_id` AND
                s.`id` = %d",
            [get_current_user_id(), $submittal_id]
        ));
    }

    function process_bulk_action() {
        if($this->current_action() === 'bulk_delete') {
            global $wpdb;
            
            $ids = esc_sql($_POST['ids']);

            if (!is_array($ids) || !count($ids)) {
                return;
            }

            $wpdb->query($wpdb->prepare("
                UPDATE {$wpdb->prefix}submittals s
                LEFT JOIN {$wpdb->prefix}submittal_users su 
                    ON su.`id` = s.`user_id`
                SET 
                    s.`deleted_at` = CURRENT_TIMESTAMP,
                    s.`deleted_by` = %d
                WHERE
                    s.`deleted_at` IS NULL AND
                    s.`id` != su.`current_submittal_id` AND
                    s.`id` IN (" . implode(',', array_fill(0, count($ids), '%d')) . ")",
                array_merge([get_current_user_id()], $ids)
            ));
        }
    }
}