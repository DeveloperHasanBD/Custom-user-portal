<?php

// custom user functinality process 
require_once get_theme_file_path('/inc/users/necessary-work.php');
require_once get_theme_file_path('/inc/admin/admin-options.php');
require_once get_theme_file_path('/inc/admin/necessary-word.php');
require_once get_theme_file_path('/inc/admin/functionality/ajax-processing.php');


require_once get_theme_file_path('/inc/users/login-form.php');
require_once get_theme_file_path('/inc/users/functionality/ajax-processing/user-ajax-data.php');
// custom user functinality process 


function software_checking_page()
{

    $software_checking = $_SERVER['REQUEST_URI'];
    $get_software = explode('/', $software_checking);

    $final_array = [];

    foreach ($get_software as $key => $single_item) {
        if ($get_software[$key] != '') {
            $final_array[] = $single_item;
        }
    }

?>
    <style>
        .pl_extra_header_menu_item {
            display: none;
        }
    </style>
    <?php
    $array_index = $final_array[0] ?? '';
    if ($array_index == 'software-checking') {
    ?>
        <style>
            .pl_extra_header_menu_item {
                display: block;
            }
        </style>
<?php
    }
}
add_action('wp_head', 'software_checking_page');
