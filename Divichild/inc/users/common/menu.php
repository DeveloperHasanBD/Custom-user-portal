<?php
if (has_nav_menu('user_dashboard_emnu')) {
    wp_nav_menu(
        array(
            'theme_location'  => 'user_dashboard_emnu',
            'container_class'  => 'pl_customer_portal_menu',
        )
    );
} else {
?>
    <p>There is not active menu for this location. Please setup from the menu option</p>
<?php
}
?>