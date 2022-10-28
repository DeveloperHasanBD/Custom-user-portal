<?php

/**
 * Start admin menu creation
 */
function divi_custom_admin_menu()

{
    add_menu_page(
        __('Private Area', 'divi'),
        __('Private Area', 'divi'),
        'manage_options',
        'admin-options',
        'divi_admin_dashboard_options',
        'dashicons-admin-generic',
        90,
    );
    add_submenu_page(
        'admin-options',
        __('Invio File', 'divi'),
        __('Invio File', 'divi'),
        'manage_options',
        'file-process',
        'divi_admin_file_process',
    );

    add_submenu_page(
        'admin-options',
        __('File history', 'divi'),
        __('File history', 'divi'),
        'manage_options',
        'file-history',
        'divi_admin_file_history',
    );

    add_submenu_page(
        '',
        __('Invio File', 'divi'),
        __('Invio File', 'divi'),
        'manage_options',
        'user-details',
        'divi_user_details',
    );
}

add_action('admin_menu', 'divi_custom_admin_menu');

/**
 * Start db table
 */


function rda_db_table_generation()
{

    global $wpdb;
    $pl_customers            = $wpdb->prefix . 'pl_customers';
    $pl_customers_table_query = "CREATE TABLE {$pl_customers} (
    id INT (11) NOT NULL AUTO_INCREMENT,
    user_name VARCHAR (255),
    user_pass VARCHAR (255),
	normal_name VARCHAR (255),
	customer_code VARCHAR (255),
	fresh_pass VARCHAR (255),
    surname VARCHAR (255),
    company VARCHAR (255),
    address VARCHAR (255),
    nap VARCHAR (255),
    city VARCHAR (255),
    email VARCHAR (255),
    repeat_mail VARCHAR (255),
    telephone_number VARCHAR (255),
    select_role VARCHAR (255),
    policy_acceptance VARCHAR (255),
    accet_condizioni VARCHAR (255),
    user_status INTEGER DEFAULT 0,
    approve INTEGER DEFAULT 0,
    created_at timestamp NOT NULL DEFAULT current_timestamp(),
    updated_at datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (id)
    )";

    // newsletter db table 
    $pl_newsletter            = $wpdb->prefix . 'pl_newsletter';
    $pl_newsletter_table_query = "CREATE TABLE {$pl_newsletter} (
    id INT (11) NOT NULL AUTO_INCREMENT,
    user_id INT (11),
    ready_to_subs VARCHAR (255),
    select_item VARCHAR (255),
    newsletter_mail VARCHAR (255),
    created_at timestamp NOT NULL DEFAULT current_timestamp(),
    updated_at datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (id)
    )";

    // pdf file db table 
    $pl_pdf_files            = $wpdb->prefix . 'pl_pdf_files';
    $pl_pdf_files_table_query = "CREATE TABLE {$pl_pdf_files} (
    id INT (11) NOT NULL AUTO_INCREMENT,
    sender_id INT (11),
    user_id INT (11),
    pdf_group VARCHAR (255),
    pdf_url VARCHAR (255),
    created_at timestamp NOT NULL DEFAULT current_timestamp(),
    updated_at datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (id)
    )";

    // pdf file db table 
    $pl_login_logout            = $wpdb->prefix . 'pl_login_logout';
    $pl_login_logout_table_query = "CREATE TABLE {$pl_login_logout} (
    id INT (11) NOT NULL AUTO_INCREMENT,
    user_name VARCHAR (255),
    login_out INT (11),
    created_at timestamp NOT NULL DEFAULT current_timestamp(),
    updated_at datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (id)
    )";

    // pdf file db table 
    $pl_user_files            = $wpdb->prefix . 'pl_user_files';
    $pl_user_files_table_query = "CREATE TABLE {$pl_user_files} (
    id INT (11) NOT NULL AUTO_INCREMENT,
    user_id INT (11),
    user_name VARCHAR (255),
    file_url VARCHAR (255),
    created_at timestamp NOT NULL DEFAULT current_timestamp(),
    updated_at datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (id)
    )";

    // group table 
    $pl_guoup            = $wpdb->prefix . 'pl_guoup';
    $pl_guoup_table_query = "CREATE TABLE {$pl_guoup} (
    id INT (11) NOT NULL AUTO_INCREMENT,
    group_name VARCHAR (255),
    created_at timestamp NOT NULL DEFAULT current_timestamp(),
    updated_at datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (id)
    )";

    // user group table 
    $pl_user_guoup            = $wpdb->prefix . 'pl_user_guoup';
    $pl_user_guoup_table_query = "CREATE TABLE {$pl_user_guoup} (
    id INT (11) NOT NULL AUTO_INCREMENT,
    user_id INT (11),
    group_name VARCHAR (255),
    user_email VARCHAR (255),
    created_at timestamp NOT NULL DEFAULT current_timestamp(),
    updated_at datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (id)
    )";

    // user group file table 
    $pl_user_file_guoup            = $wpdb->prefix . 'pl_user_file_guoup';
    $pl_user_file_guoup_table_query = "CREATE TABLE {$pl_user_file_guoup} (
    id INT (11) NOT NULL AUTO_INCREMENT,
    sender_id INT (11),
    user_id INT (11),
    file_name VARCHAR (255),
    created_at timestamp NOT NULL DEFAULT current_timestamp(),
    updated_at datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (id)
    )";

    require_once(ABSPATH . "wp-admin/includes/upgrade.php");
    dbDelta($pl_user_file_guoup_table_query);
    dbDelta($pl_user_guoup_table_query);
    dbDelta($pl_guoup_table_query);
    dbDelta($pl_user_files_table_query);
    dbDelta($pl_login_logout_table_query);
    dbDelta($pl_pdf_files_table_query);
    dbDelta($pl_newsletter_table_query);
    dbDelta($pl_customers_table_query);
}
add_action('after_switch_theme', 'rda_db_table_generation');


/**
 * Start menu
 */
register_nav_menus(
    array(
        'user_dashboard_emnu' => __('User dashboard', 'Divichild'),
    )
);

/**
 * Start enqueue
 */
function css_js_file_enqueue()
{

    wp_enqueue_style('dvchld-parent-style', get_parent_theme_file_uri("/style.css"));
   
    wp_enqueue_style('enq-h-bootstrap', get_theme_file_uri() . '/inc/users/assets/css/bootstrap.min.css', array(), null);
    wp_enqueue_style('enq-h-datatables', get_theme_file_uri() . '/inc/users/assets/css/datatables.min.css', array(), null);
    wp_enqueue_style('enq-h-style', get_theme_file_uri() . '/inc/users/assets/css/h-style.css', array(), null);
    wp_enqueue_style('enq-h-custom-style', get_theme_file_uri() . '/inc/users/assets/css/h-custom-style.css', array(), null);

    wp_enqueue_script('jquery');
    wp_enqueue_script('enq-bootstrap', get_theme_file_uri() . '/inc/users/assets/js/bootstrap.min.js', array(), null, true);
    wp_enqueue_script('enq-validate', get_theme_file_uri() . '/inc/users/assets/js/jquery.validate.min.js', array(), null, true);
    wp_enqueue_script('enq-h-datatables', get_theme_file_uri() . '/inc/users/assets/js/datatables.min.js', array(), null, true);



    wp_enqueue_script('enq-h-main', get_theme_file_uri() . '/inc/users/assets/js/h-main.js', array(), null, true);
    wp_localize_script('enq-h-main', 'action_url_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
    ]);
}
add_action('wp_enqueue_scripts', 'css_js_file_enqueue');



/**
 * Start admin enque
 */

function admin_enqueue()

{



    $slug = '';

    $css_loaded_page = ['admin-options', 'file-process', 'user-details', 'file-history'];

    $css_page = $_REQUEST['page'] ?? '';

    if (in_array($css_page, $css_loaded_page)) {
        wp_enqueue_style('enq-bootstrap', get_theme_file_uri() . '/inc/admin/assets/css/bootstrap.min.css', array(), null);
        wp_enqueue_style('enq-datatables', get_theme_file_uri() . '/inc/admin/assets/css/datatables.min.css', array(), null);
        wp_enqueue_style('enq-all', get_theme_file_uri() . '/inc/admin/assets/css/all.min.css', array(), null);
        wp_enqueue_style('enq-style', get_theme_file_uri() . '/inc/admin/assets/css/style.css', array(), null);
    }



    // jss loaded
    $js_loaded_page = ['admin-options', 'file-process', 'user-details', 'file-history'];
    $js_page = $_REQUEST['page'] ?? '';
    if (in_array($js_page, $js_loaded_page)) {

        wp_enqueue_script('jquery');
        wp_enqueue_script('enq-admin-bootstrap', get_theme_file_uri() . '/inc/admin/assets/js/bootstrap.min.js', array(), null, true);
        wp_enqueue_script('enq-admin-all', get_theme_file_uri() . '/inc/admin/assets/js/all.min.js', array(), null, true);
        wp_enqueue_script('enq-admin-validate', get_theme_file_uri() . '/inc/admin/assets/js/jquery.validate.min.js', array(), null, true);
        wp_enqueue_script('enq-admin-datatables', get_theme_file_uri() . '/inc/admin/assets/js/datatables.min.js', array(), null, true);
        wp_enqueue_script('enq-main', get_theme_file_uri() . '/inc/admin/assets/js/main.js', array(), null, true);

        wp_localize_script('enq-main', 'action_url_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
        ]);
    }
}



add_action('admin_enqueue_scripts', 'admin_enqueue');



/**
 * Start page creation
 */
$post_table = $wpdb->prefix . 'posts';

$is_customer_portal_page = $wpdb->get_row("SELECT * FROM $post_table WHERE post_type = 'page' AND post_status='publish' AND post_name='customer-portal'");

if ($is_customer_portal_page) {
} else {
    $page_creation = [];
    $page_creation['post_title']    = 'Customer portal';
    $page_creation['post_status']   = 'publish';
    $page_creation['post_name']     = 'customer-portal';
    $page_creation['post_type']     = 'page';
    wp_insert_post($page_creation);
}

$is_login_page = $wpdb->get_row("SELECT * FROM $post_table WHERE post_type = 'page' AND post_status='publish' AND post_name='login'");
if ($is_login_page) {
} else {
    $page_creation = [];
    $page_creation['post_title']    = 'Login';
    $page_creation['post_status']   = 'publish';
    $page_creation['post_name']     = 'login';
    $page_creation['post_type']     = 'page';
    wp_insert_post($page_creation);
}

$is_logout_page = $wpdb->get_row("SELECT * FROM $post_table WHERE post_type = 'page' AND post_status='publish' AND post_name='logout'");
if ($is_logout_page) {
} else {
    $page_creation = [];
    $page_creation['post_title']    = 'Logout';
    $page_creation['post_status']   = 'publish';
    $page_creation['post_name']     = 'logout';
    $page_creation['post_type']     = 'page';
    wp_insert_post($page_creation);
}

$is_registration_page = $wpdb->get_row("SELECT * FROM $post_table WHERE post_type = 'page' AND post_status='publish' AND post_name='registration'");
if ($is_registration_page) {
} else {
    $page_creation = [];
    $page_creation['post_title']    = 'Registration';
    $page_creation['post_status']   = 'publish';
    $page_creation['post_name']     = 'registration';
    $page_creation['post_type']     = 'page';
    wp_insert_post($page_creation);
}

$is_user_activation_page = $wpdb->get_row("SELECT * FROM $post_table WHERE post_type = 'page' AND post_status='publish' AND post_name='user-activation'");
if ($is_user_activation_page) {
} else {
    $page_creation = [];
    $page_creation['post_title']    = 'User activation';
    $page_creation['post_status']   = 'publish';
    $page_creation['post_name']     = 'user-activation';
    $page_creation['post_type']     = 'page';
    wp_insert_post($page_creation);
}

$is_forgot_password_page = $wpdb->get_row("SELECT * FROM $post_table WHERE post_type = 'page' AND post_status='publish' AND post_name='forgot-password'");
if ($is_forgot_password_page) {
} else {
    $page_creation = [];
    $page_creation['post_title']    = 'Forgot password';
    $page_creation['post_status']   = 'publish';
    $page_creation['post_name']     = 'forgot-password';
    $page_creation['post_type']     = 'page';
    wp_insert_post($page_creation);
}
