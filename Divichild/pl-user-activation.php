<?php

/**
 * Template name: User activation
 */

global $wpdb;
$pl_customers_table             = $wpdb->prefix . 'pl_customers';
$pl_newsletter_table             = $wpdb->prefix . 'pl_newsletter';

$user_id = $_GET['activate-user'] ?? '';
$approve_results = $wpdb->get_row("SELECT * FROM {$pl_customers_table} WHERE id = $user_id");
$user_status = $approve_results->user_status ?? '';

$user_email = $approve_results->email ?? '';
$fresh_pass = $approve_results->fresh_pass ?? '';
$user_name = $approve_results->user_name ?? '';

if (1 == $user_status) {
    $login_url = site_url();
    header("Location: $login_url");
    die;
}

if (isset($_POST['submit_btn'])) {


    $ready_to_subs   = sanitize_text_field($_POST['ready_to_subs']);
    $items = $_POST['items'];
    $total_nl_items = count($_POST['items']);
    for ($i = 0; $i < $total_nl_items; $i++) {
        $wpdb->insert(
            $pl_newsletter_table,
            array(
                'user_id'           => $user_id,
                'ready_to_subs'     => $ready_to_subs,
                'select_item'       => $items[$i]['select_item'],
                'newsletter_mail'   => $items[$i]['newsletter_mail'],
            ),
        );
    }

    $wpdb->update(
        $pl_customers_table,
        array(
            'user_status' => 1,
        ),
        array('id' => $user_id),
    );

    $login_url = site_url();
    $admin_url = site_url() . '/' . 'wp-admin';


    $to_mail  = $user_email;
    $subject  = "Polielectra registrazione";

    $headers  = '';
    //     $headers .= "From: Attivazione del profilo <noreply@polielectra.ch> \r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    $msg = '';
    $msg .= 'Gentile ' . $user_name . ",<br><br>";
    $msg .= 'Grazie per aver creato un nuovo profilo sul portale Polielectra. ' . "<br><br>";
    $msg .= 'Da oggi potrai inviare e ricevere files in un’area completamente a te dedicata, accessibile al: <a href="' . $login_url . '">' . $login_url . '</a> <br><br>';
    //     $msg .= '<a href="' . $login_url . '">' . $login_url . '</a>' . "<br><br>";

    // 	    $msg .= '<a style="display: block; padding: 10px 30px; width: 100px; background: #f68b2e; text-align: center; text-decoration: nono; color: #fff; font-weight: 600" href="' . $login_url . '">' . 'Accedi' . '</a>' . "<br>";

    $msg .= 'Ecco i dettagli della tua utenza polielectra:' . "<br><br>";
    $msg .= 'U Email: ' . $user_email . "<br>";
    $msg .= 'P: ' . $fresh_pass . "<br><br>";
    $msg .= 'Grazie,' . "<br>";
    $msg .= 'La direzione' . "<br>";
    wp_mail($to_mail, $subject, $msg, $headers);
    // end user mail 




    $admin_email_address = get_field('admn_admin_email', 'option');
    // $admin_email_address = get_bloginfo('admin_email');
    $admin_to_mail  = $admin_email_address;
    $admin_subject  = "Nuovo utente";

    $admin_headers  = '';
    //     $headers .= "From: Attivazione del profilo <noreply@polielectra.ch> \r\n";
    $admin_headers .= "MIME-Version: 1.0" . "\r\n";
    $admin_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    $admin_msg = '';
    $admin_msg .= 'Ciao Admin,' . "<br><br>";
    $admin_msg .= 'La seguente per notificarti l’iscrizione ad area riservata di un nuovo utente:' . "<br><br>";
    $admin_msg .= 'U: ' . $user_name . "<br>";
    $admin_msg .= 'E: ' . $user_email . "<br><br>";
    $admin_msg .= 'Collegati alla dashboard per vedere tutti i dettagli:' . "<br><br>";
    $admin_msg .= '<a style="display: block; padding: 10px 30px; width: 150px; background: #f68b2e; text-align: center; text-decoration: nono; color: #fff; font-weight: 600" href="' . $admin_url . '">' . 'Vai alla Dashboard' . '</a>' . "<br>";
    $msg .= 'Grazie.' . "<br>";
    wp_mail($admin_to_mail, $admin_subject, $admin_msg, $admin_headers);
    // end user mail 


    header("Location: $login_url");
    die;
}





?>

<style>
    .pl_user_activation_info {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pl_user_activation_info_innr {
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

    body {
        margin: 0;
        background: #fff;
    }

    .pl_user_activation_input_box input {
        width: 100%;
        height: 40px;
        border-radius: 5px;
    }

    .pl_user_activation_input_box {
        margin-bottom: 20px;
    }

    .pl_user_activation_input_box select {
        width: 100%;
        height: 40px;
        border: 1px solid #ddd;
        font-family: 'Rajdhani', sans-serif;
        line-height: 22px;
        font-size: 16px;
        padding: 6px;
    }

    .pl_user_activation_input_box input[type="submit"] {
        background: #f68b2e;
        border: none;
        padding: 10px 20px;
        font-size: 20px;
        color: #fff;
        border-radius: 7px;
        cursor: pointer;
    }

    input#newsletter_mail {
        border: 1px solid #ddd;
    }

    div#user_email_newsletter_id {
        display: none;
    }

    .add_more_email span {
        padding: 10px 20px;
        margin: 0px 10px 20px;
        color: #fff;
        border-radius: 5px;
    }

    .add_more_email {
        display: none;
    }

    .more_btn {
        display: flex;
        justify-content: center;
    }

    span.add_mr_rmail {
        background: #f68b2e;
    }

    span.remove_mr_rmail {
        background: #d00000;
    }

    .more_btn span {
        cursor: pointer;
    }

    @media all and (max-width: 1000px) {
        .pl_user_activation_info {
            width: 90%;
            margin: auto;
        }

        .pl_user_activation_info_innr {
            width: 90%;
            margin: auto;
        }

        .pl_user_activation_input_box select {
            font-size: 32px;
            height: 85px;
        }

        input#newsletter_mail {
            height: 80px;
            font-size: 40px;
        }

        .pl_user_activation_input_box input[type="submit"] {
            height: 85px;
            font-size: 45px;
        }
    }

    .user_notice p {
        font-family: 'Rajdhani', sans-serif;
        line-height: 22px;
        font-size: 17px;
    }
</style>

<form action="" method="POST">

    <div class="pl_user_activation_info">
        <div class="pl_user_activation_info_innr">
            <div class="logo_box">
                <?php
                $userc_logo_setup = get_field('userc_logo_setup', 'option');
                ?>
                <img src="<?php echo $userc_logo_setup; ?>" alt="">
            </div>
            <div class="user_notice">
                <p>Gentile utente, prima di attivare il profilo ti chiediamo di indicare se desideri ricevere la nostra newsletter</p>
            </div>
            <div class="pl_user_activation_input_box">
                <select required name="ready_to_subs" class="ready_to_subs">
                    <option selected value="">Vuoi iscriverti alla nostra newsletter?</option>
                    <option value="Sì">Sì</option>
                    <option value="No">No</option>
                </select>
            </div>
            <div class="user_email_newsletter" id="user_email_newsletter_id">
                <div class="user_single_newsletter">
                    <div class="pl_user_activation_input_box select_option">
                        <select name="items[0][select_item]" id="">
                            <option value="" selected>Inserisci temi d’interesse </option>
                            <option value="tutto">Tutto</option>
                            <option value="azioni">Azioni</option>
                            <option value="novità">Novità </option>
                            <option value="comunicazioni">Comunicazioni</option>
                            <option value="corsi">Corsi </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="pl_user_activation_input_box">
                <input type="submit" name="submit_btn" value="Attiva profilo">
            </div>
        </div>
    </div>
</form>




<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script type="text/javascript">
    (function($) {
        $(document).ready(function() {
            $(".ready_to_subs").on('change', function() {
                var selected_val = $(this).val();
                if ('Sì' == selected_val) {
                    $(".user_single_newsletter").css({
                        'display': 'block'
                    });
                    $("div#user_email_newsletter_id").css({
                        'display': 'block'
                    });
                    $(".add_more_email").css({
                        'display': 'block'
                    });
                }
                if ('No' == selected_val) {
                    $(".user_single_newsletter").css({
                        'display': 'none'
                    });
                    $("div#user_email_newsletter_id").css({
                        'display': 'none'
                    });
                    $(".add_more_email").css({
                        'display': 'none'
                    });
                }
            });


            



        });
    })(jQuery)
</script>