<?php

/**
 * Template name: Forgot password
 */


global $wpdb;

$user_id = $_GET['id'] ?? '';
$user_pass = $_GET['security'] ?? '';
$pl_customers_table             = $wpdb->prefix . 'pl_customers';

$get_results = $wpdb->get_row("SELECT * FROM {$pl_customers_table} WHERE id='{$user_id}' AND user_pass = '{$user_pass}' AND user_status = 1");
$is_user = $get_results->user_name ?? '';


if ($is_user) {
    if (isset($_POST['updt_btn'])) {

        $user_pass       = sanitize_text_field($_POST['user_pass']);
        $user_hash_password = wp_hash_password($user_pass);

        $wpdb->update(
            $pl_customers_table,
            array(
                'user_pass' => $user_hash_password,   // string
            ),
            array('id' => $user_id),
        );
        session_start();
        $_SESSION['pass_updated'] = 1;
    }
}


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
        font-family: 'Rajdhani', sans-serif;
        font-weight: 500;
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
        font-size: 20px;
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
    }

    .submit_box {
        display: flex;
        justify-content: center;
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
        font-weight: 600;
        font-family: 'Rajdhani', sans-serif;

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

    .password_updated_msg span {
        background: green;
        color: #fff;
    }

    .wrong_msg span {
        background: red;
        color: #fff;
    }

    .submit_box a {
        font-family: 'Rajdhani', Helvetica, Arial, Lucida, sans-serif;
        font-size: 20px;
        font-weight: 600;
        color: #000;
        text-decoration: none;
    }

    .password_updated_msg span {
        font-family: 'Rajdhani', Helvetica, Arial, Lucida, sans-serif;
        text-transform: capitalize;
        font-weight: 500;
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
        $pass_updated = $_SESSION['pass_updated'] ?? '';
        if ($pass_updated) {
        ?>
            <div class="password_updated_msg">
                <center><span>password aggiornata</span></center>
            </div>
            <div class="submit_box">
                <a href="<?php echo site_url(); ?>">Accedi</a>
            </div>
            <?php
        } else {
            if ($is_user) {
            ?>
                <form id="form_submit" action="" method="POST">
                    <div class="input_box">
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <input required type="password" name="user_pass" placeholder="Digita la tua nuova password">
                    </div>
                    <div class="submit_box">
                        <div class="submit_box_left">

                        </div>
                        <div class="submit_box_right">
                            <input type="submit" name="updt_btn" value="Aggiorna password">
                        </div>
                    </div>
                </form>
            <?php
            } else {
            ?>
                <div class="wrong_msg">
                    <center><span>Qualcosa è sbagliato</span></center>
                </div>
        <?php
            }
        }
        ?>


    </div>
</div>