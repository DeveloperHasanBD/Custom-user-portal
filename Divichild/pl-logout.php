<?php

/**
 * Template name: Logout
 */

session_start();
global $wpdb;
$pl_login_logout_table             = $wpdb->prefix . 'pl_login_logout';
$wpdb->delete($pl_login_logout_table, array('user_name' => $_SESSION['user_name']));

unset($_SESSION['user_id']);
$login_url = site_url();
header("Location: $login_url");
die;
