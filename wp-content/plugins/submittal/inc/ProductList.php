<?php 

class ProductList {
    private $table_submittals;
    private $table_submittal_products;
    private $table_submittal_users;
    private $table_submittal_details;
    private $table_posts;

    private $submittal_id;
    private $products;
    private $details;
    private $title;

    public function __construct() {
        global $wpdb;
        $this->table_submittals = $wpdb->prefix . 'submittals';
        $this->table_submittal_products = $wpdb->prefix . 'submittal_products';
        $this->table_submittal_users = $wpdb->prefix . 'submittal_users';
        $this->table_submittal_details = $wpdb->prefix . 'submittal_details';
        $this->table_posts = $wpdb->prefix . 'posts';
        
        $this->submittal_id = $wpdb->get_var($wpdb->prepare("
            SELECT `current_submittal_id`
            FROM {$this->table_submittal_users}
            WHERE `cookie_id` = %s",
            [$_COOKIE['submittal_user_key']]
        ));

        $this->products = $wpdb->get_results($wpdb->prepare("
            SELECT *
            FROM {$this->table_submittal_products} AS sp
            LEFT JOIN {$this->table_posts} AS p
                ON sp.product_id = p.id
            WHERE sp.submittal_id = %d",
            [$this->submittal_id]
        ));

        $this->details = $wpdb->get_row($wpdb->prepare("
            SELECT *
            FROM {$this->table_submittal_details}
            WHERE `submittal_id` = %d
            ORDER BY `id` DESC",
            [$this->submittal_id]
        ));

        $this->title = $wpdb->get_var($wpdb->prepare("
            SELECT `title`
            FROM {$this->table_submittals}
            WHERE `id` = %d
            ORDER BY `id` DESC",
            [$this->submittal_id]
        ));
    }
    
    public function getProducts() {
        return $this->products;
    }

    public function getCoverLetter() {
        $coverLetter = json_decode($this->details->cover_letter, true);

        if (!is_array($coverLetter)) {
            return [];
        }

        $coverLetterFields = [
            'title' => 'Title',
            'date' => 'Date',
            'projectName' => 'Project Name',
            'generalContractor' => 'General Contractor',
            'electricalContractor' => 'Electrical Contractor',
            'engineer' => 'Engineer/Architect',
            'salesContact' => 'Sales Representative Contact',
        ];

        $result = [];

        foreach ($coverLetterFields as $field => $label) {
            if (isset($coverLetter[$field])) {
                $result[] = [
                    'label' => $label,
                    'value' => $coverLetter[$field],
                ];
            }
        }

        return $result;
    }

    public function getPdf() {
        return get_option('submittal_pdf_view_path') . $this->details->pdf;
    }

    public function getTitle() {
        return $this->title;
    }
}