<?php

session_start();

if (isset($_SESSION['user_id'])) {
    $dashboard_url = site_url() . '/gestione-dei-file';
    header("Location: $dashboard_url");
    die;
}

if (isset($_POST['btn'])) {
    $username = sanitize_text_field($_POST['username']) ?? '';
    $password = sanitize_text_field($_POST['password']) ?? '';

    global $wpdb;
    $pl_customers_table             = $wpdb->prefix . 'pl_customers';
    $pl_login_logout_table             = $wpdb->prefix . 'pl_login_logout';
    $get_results = $wpdb->get_row("SELECT * FROM {$pl_customers_table} WHERE user_name = '{$username}' AND user_status = 1");

    $user_id = $get_results->id ?? '';
    $user_name = $get_results->user_name ?? '';
    $user_pass = $get_results->user_pass ?? '';

    if ($user_name) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $user_name;
        if (wp_check_password($password, $user_pass)) {

            $wpdb->insert(
                $pl_login_logout_table,
                array(
                    'user_name' => $user_name,
                    'login_out' => 1,
                ),
            );
            $dashboard_url = site_url() . '/gestione-dei-file';
            header("Location: $dashboard_url");
            die;
        } else {
            $_SESSION['pass_not_match'] = 'La password non corrisponde';
        }
    } else {
        $_SESSION['not_exist_user'] = 'L\'utente e la password sono sbagliati o il profilo non è ancora attivo.';
    }
}

/**
 * Template name: Login
 */
get_header();
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600&display=swap" rel="stylesheet">

<style>
    /* start login form design  */
    body {
        padding: 0;
        margin: 0;
        background: #fff;
    }

    .form_submit_box_inner {
        width: 500px;
        background: #fff;
        border-radius: 25px;
        padding: 50px;
        box-shadow: 0px 0px 50px #d7d7d7;
    }

    .logo_box {
        text-align: center;
        margin-bottom: 45px;
    }

    .form_submit_main_box {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input_box input {
        width: 100%;
        height: 40px;
        border: 1px solid #ddd;
        margin-bottom: 20px;
        border-radius: 5px;
    }

    .submit_box_left {
        width: 60%;
    }

    .submit_box_right {
        width: 40%;
        text-align: right;
    }

    .submit_box {
        display: flex;
        align-items: center;
    }

    .submit_box_left a {
        border: none;
        color: #000;
        font-size: 18px;
        border-radius: 5px;
        text-decoration: none;
        font-family: 'Rajdhani', sans-serif;
        font-weight: 500;
    }

    .input_box input {
        width: 100%;
        height: 40px;
        border: 1px solid #ddd;
        margin-bottom: 20px;
        border-radius: 5px;
        font-family: 'Rajdhani', sans-serif;
        font-weight: 500;
    }

    .submit_box {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }


    .submit_box_right input[type="submit"] {
        background: #f68b2e;
        border: none;
        padding: 10px 20px;
        font-size: 20px;
        color: #fff;
        border-radius: 7px;
        cursor: pointer;
        font-family: 'Rajdhani', sans-serif;
        font-weight: 600;
    }

    .submit_box_left a {
        padding-right: 10px;
        text-decoration: underline;
    }

    .form_submit_box_inner span {
        font-size: 16px;
        text-align: center;
        margin-bottom: 10px;
        padding: 10px;
        background: red;
        display: block;
        color: #fff;
    }

    @media all and (max-width: 1000px) {
        .form_submit_box_inner span {
            font-size: 40px;
        }

        .form_submit_box_inner {
            width: 80%;
        }

        .submit_box_left a {
            font-size: 40px;
            display: block;
        }

        .submit_box_right input[type="submit"] {
            font-size: 60px;
        }

        .input_box input {
            height: 80px;
            font-size: 60px;
        }
    }

    /* start login form design  */
</style>
<!-- <p>Login form</p> -->

<div class="form_submit_main_box">
    <div class="form_submit_box_inner">
        <div class="logo_box">
            <?php
            $userc_logo_setup = get_field('userc_logo_setup', 'option');
            ?>
            <a href="<?php echo site_url(); ?>"><img src="<?php echo $userc_logo_setup; ?>" alt=""></a>
        </div>
        <?php
        if (isset($_SESSION['not_exist_user'])) {
        ?>
            <span><?php echo $_SESSION['not_exist_user']; ?></span>
        <?php
            unset($_SESSION['not_exist_user']);
            session_destroy();
        }
        if (isset($_SESSION['pass_not_match'])) {
        ?>
            <span><?php echo $_SESSION['pass_not_match']; ?></span>
        <?php
            unset($_SESSION['pass_not_match']);
            session_destroy();
        }
        if (isset($_SESSION['pass_updated'])) {
        ?>
            <span style="background-color: green;"><?php echo $_SESSION['pass_updated']; ?></span>
        <?php
            unset($_SESSION['pass_updated']);
            session_destroy();
        }
        ?>

        <form id="form_submit" action="" method="POST">
            <div class="input_box">
                <input type="text" name="username" placeholder="Nome utente">
                <input type="password" name="password" placeholder="Password">
            </div>
            <div class="submit_box">
                <div class="submit_box_left">
                    <a href="<?php echo site_url() . '/registrazione' ?>">Registrati</a>
                    <a href="<?php echo site_url() . '/forgot-password' ?>">Password dimenticata?</a>
                </div>
                <div class="submit_box_right">
                    <input type="submit" name="btn" value="Accedi">
                </div>
            </div>
        </form>
    </div>
</div>

<?php
get_footer();
?>