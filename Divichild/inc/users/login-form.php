<?php

function display_login_form()
{
    $user_id = $_SESSION['user_id'] ?? '';
    ob_start();
?>
    <div class="pl_header_menu_form">
        <?php
        if ($user_id) {
        } else {
        ?>
            <div class="pl_login_form_section">
                <div id="pl_user_login_form_message"></div>
                <h2>Accesso</h2>
                <form id="pl_user_login_form" action="">
                    <div class="login_input_box">
                        <label for="user_name">Email</label>
                        <input id="user_name" type="email" name="user_name">
                    </div>
                    <div class="login_input_box">
                        <label for="user_pass">Password</label>
                        <input id="user_pass" type="password" name="user_pass">
                        <p><span data-bs-toggle="modal" data-bs-target="#staticBackdrop">Password dimenticata</span></p>
                    </div>
                    <div class="login_input_box">
                        <button> Accedi </button>
                    </div>
                </form>
                <div class="reg_input_box">
                    <div class="sep_line"></div>
                    <button> <a href="<?php echo site_url() . '/registrazione'; ?>">Registrazione</a> </button>
                </div>
            </div>
        <?php
        }
        ?>

        <?php
        if ($user_id) {
        ?>
            <div class="pl_user_dashboard_menu">
                <a href="<?php echo site_url() . '/gestione-dei-file' ?>">Area Cliente</a>
                <div class="pl_user_dashboard_innr">
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
                </div>
                <p><a href="<?php echo site_url(); ?>/logout/?logout=<?php echo $_SESSION['user_id']; ?>">Disconnettersi</a></p>
            </div>
        <?php
        }
        ?>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('pl_login_form', 'display_login_form');
