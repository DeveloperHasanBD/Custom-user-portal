<?php
session_start();
if ($_SESSION['user_id'] == null) {
    $site_url = site_url();
    header("Location: $site_url");
    die;
}


$user_id = $_SESSION['user_id'] ?? '';
$user_name = $_SESSION['user_name'] ?? '';
$user_company = $_SESSION['user_company'] ?? '';

global $wpdb;


$pl_customers_table = $wpdb->prefix . 'pl_customers';
$pl_newsletter_table = $wpdb->prefix . 'pl_newsletter';
$pl_guoup_table             = $wpdb->prefix . 'pl_guoup';

$pl_guoup_results = $wpdb->get_results("SELECT * FROM {$pl_guoup_table}");
$get_results = $wpdb->get_row("SELECT * FROM {$pl_customers_table} WHERE id = $user_id ");
$surname = $get_results->surname;

$newsletter_results = $wpdb->get_results("SELECT * FROM {$pl_newsletter_table} WHERE user_id = $user_id ");


