<?php

if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title'  => 'Admin Settings',
        'menu_title'  => 'Admin Settings',
        'menu_slug'   => 'admin-general-settings',
        'capability'  => 'edit_posts',
        'redirect'    => false,
        'position'    => '88',
    ));
    // acf_add_options_sub_page(array(
    //     'page_title'  => 'Showroom Footer Settings',
    //     'menu_title'  => 'Showroom Footer',
    //     'parent_slug' => 'theme-general-settings',
    // ));
    // acf_add_options_sub_page(array(
    //     'page_title'  => 'La boutique Footer Settings',
    //     'menu_title'  => 'La boutique Footer',
    //     'parent_slug' => 'theme-general-settings',
    // ));
}

function custom_acf_code_setup()
{

    if (function_exists('acf_add_local_field_group')) :

        acf_add_local_field_group(array(
            'key' => 'group_62d4ee7f4dcf4',
            'title' => 'Logo setting',
            'fields' => array(
                array(
                    'key' => 'field_62d4ef5751a1d',
                    'label' => 'Upload logo',
                    'name' => 'userc_logo_setup',
                    'type' => 'image',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'return_format' => 'url',
                    'preview_size' => 'medium',
                    'library' => 'all',
                    'min_width' => '',
                    'min_height' => '',
                    'min_size' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'max_size' => '',
                    'mime_types' => '',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'admin-general-settings',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'left',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
            'show_in_rest' => 0,
        ));

    endif;
    if (function_exists('acf_add_local_field_group')) :

        acf_add_local_field_group(array(
            'key' => 'group_632d4604df9eb',
            'title' => 'Portal latest communications',
            'fields' => array(
                array(
                    'key' => 'field_632d462e85158',
                    'label' => 'latest communications slug',
                    'name' => 'latest_communications_slug',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'admin-general-settings',
                    ),
                ),
            ),
            'menu_order' => 20,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'left',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
            'show_in_rest' => 0,
        ));

        acf_add_local_field_group(array(
            'key' => 'group_632d46e13b30b',
            'title' => 'Last news',
            'fields' => array(
                array(
                    'key' => 'field_632d46fbb5b40',
                    'label' => 'Last news slug',
                    'name' => 'cportal_last_news_slug',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'admin-general-settings',
                    ),
                ),
            ),
            'menu_order' => 32,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'left',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
            'show_in_rest' => 0,
        ));

        acf_add_local_field_group(array(
            'key' => 'group_632d47e4995da',
            'title' => 'Google map',
            'fields' => array(
                array(
                    'key' => 'field_632d47f3f46b0',
                    'label' => 'Customer portal google map',
                    'name' => 'customer_portal_google_map',
                    'type' => 'textarea',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'maxlength' => '',
                    'rows' => '',
                    'new_lines' => '',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'admin-general-settings',
                    ),
                ),
            ),
            'menu_order' => 40,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'left',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
            'show_in_rest' => 0,
        ));

    endif;
}
add_action('init', 'custom_acf_code_setup');
