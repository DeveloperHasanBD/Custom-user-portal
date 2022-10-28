<?php

// user registration form data processing 

function pl_user_registration_form_action()
{
    global $wpdb;
    $pl_customers_table     = $wpdb->prefix . 'pl_customers';

    $param = $_POST['param'];
    if ('form_data' == $param) {

        $email              = sanitize_text_field($_POST['email']);
        $repeat_mail        = sanitize_text_field($_POST['repeat_mail']);
        $user_name          = sanitize_text_field($_POST['user_name']);
        $set_password       = sanitize_text_field($_POST['set_password']);
        $repeat_password    = sanitize_text_field($_POST['repeat_password']);

        if ($email != $repeat_mail) {
?>
            <style>
                .notice_for_user {
                    background: #ffeb3b;
                    color: #000;
                    padding: 10px;
                    text-align: center;
                }
            </style>
            <div class="notice_for_user">
                <p>Si prega di utilizzare lo stesso indirizzo e-mail</p>
            </div>
        <?php
            die;
        }

        if ($set_password != $repeat_password) {
        ?>
            <style>
                .notice_for_user {
                    background: #ffeb3b;
                    color: #000;
                    padding: 10px;
                    text-align: center;
                }
            </style>
            <div class="notice_for_user">
                <p>Si prega di utilizzare la stessa password</p>
            </div>
        <?php
            die;
        }

        $get_user_email = $wpdb->get_row("SELECT * FROM {$pl_customers_table} WHERE email ='{$email}'");
        $is_user_email = $get_user_email->email;
        if ($is_user_email) {
        ?>
            <style>
                .notice_for_user {
                    background: red;
                    color: #fff;
                    padding: 10px;
                    text-align: center;
                }
            </style>
            <div class="notice_for_user">
                <p>Esiste già questo utente. Prova con un altro indirizzo email. Grazie</p>
            </div>
        <?php
        } else {
            $admin_mail_address = sanitize_text_field($_POST['admin_mail_address']);

            $user_hash_password = wp_hash_password($set_password);
            $surname            = sanitize_text_field($_POST['surname']);
            $normal_name        = sanitize_text_field($_POST['normal_name']);
            $customer_code      = sanitize_text_field($_POST['customer_code']);
            $company            = sanitize_text_field($_POST['company']);
            $address            = sanitize_text_field($_POST['address']);
            $nap                = sanitize_text_field($_POST['nap']);
            $city               = sanitize_text_field($_POST['city']);
            $email              = sanitize_text_field($_POST['email']);
            $telephone_number   = sanitize_text_field($_POST['telephone_number']);
            $select_role        = sanitize_text_field($_POST['select_role']);
            $policy_acceptance  = sanitize_text_field($_POST['policy_acceptance']);
            $accet_condizioni   = sanitize_text_field($_POST['accet_condizioni']);
            $admin_url = site_url() . "/wp-admin";
            $pl_customers_data = [
                'user_name'             => $user_name,
                'user_pass'             => $user_hash_password,
                'normal_name'           => $normal_name,
                'customer_code'         => $customer_code,
                'fresh_pass'            => $set_password,
                'surname'               => $surname,
                'company'               => $company,
                'address'               => $address,
                'nap'                   => $nap,
                'city'                  => $city,
                'email'                 => $email,
                'repeat_mail'           => $email,
                'telephone_number'      => $telephone_number,
                'select_role'           => $select_role,
                'policy_acceptance'     => $policy_acceptance,
                'accet_condizioni'      => $accet_condizioni,
                'user_status'           => 0,
            ];
            $wpdb->insert($pl_customers_table, $pl_customers_data);

            $to_mail = $admin_mail_address;
            $headers = '';
            $subject = "Registrazione Utente";
            $headers .= "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            $msg = '';
            $msg .= 'Ciao Admin,' . "<br><br>";
            $msg .= 'Un nuovo utente si è registrato in area riservata.' . "<br>";
            $msg .= 'Si prega di approvare la richiesta dalla dashboard. ' . "<br><br>";
            $msg .= '<a style="display: block; padding: 10px 30px; width: 160px; background: #f68b2e; text-align: center; text-decoration: nono; color: #fff; font-weight: 600" href="' . $admin_url . '">' . 'Vai alla Dashboard' . '</a>' . "<br><br>";
            $msg .= 'Grazie' . "<br>";

            wp_mail($to_mail, $subject, $msg, $headers);

            $user_to_mail = $email;
            $user_headers = '';
            $user_subject = "Posta di registrazione";
            $user_headers .= "MIME-Version: 1.0" . "\r\n";
            $user_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            $user_msg = '';
            $user_msg .= 'Gentile cliente,' . "<br><br>";
            $user_msg .= 'La tua registrazione andata a buon fine. Dopo la verifica dell\'amministrazione, riceverai' . "<br>";
            $user_msg .= 'un\'e-mail per l\'attivazione del tuo account e potrai accedere alla tua area riservata.' . "<br>";
            $msg .= 'Grazie' . "<br>";

            wp_mail($user_to_mail, $user_subject, $user_msg, $user_headers);

        ?>
            <style>
                .notice_for_user {
                    background: green;
                    color: #fff;
                    padding: 10px;
                    text-align: center;
                }
            </style>
            <div class="notice_for_user">
                <p>Registrazione andata a buon fine. Dopo la verifica dell'amministrazione, riceverai un'e-mail per l'attivazione del tuo account e potrai accedere alla tua area riservata. Grazie.</p>
            </div>
        <?php
        }
    }




    die;
}

add_action('wp_ajax_pl_user_registration_form_action', 'pl_user_registration_form_action');
add_action('wp_ajax_nopriv_pl_user_registration_form_action', 'pl_user_registration_form_action');

function pl_user_login_form_action()
{
    global $wpdb;

    $username = sanitize_text_field($_POST['user_name']) ?? '';
    $password = sanitize_text_field($_POST['user_pass']) ?? '';

    global $wpdb;
    $pl_customers_table             = $wpdb->prefix . 'pl_customers';
    $pl_login_logout_table             = $wpdb->prefix . 'pl_login_logout';
    $get_results = $wpdb->get_row("SELECT * FROM {$pl_customers_table} WHERE email = '{$username}' AND user_status = 1");

    $user_id = $get_results->id ?? '';
    $user_name = $get_results->user_name ?? '';
    $user_email = $get_results->email ?? '';
    $user_pass = $get_results->user_pass ?? '';

    if ($user_email) {
        session_start();
        if (wp_check_password($password, $user_pass)) {

            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $user_name;

            $wpdb->insert(
                $pl_login_logout_table,
                array(
                    'user_name' => $user_name,
                    'login_out' => 1,
                ),
            );
            $dashboard_url = site_url();
        ?>
			<style>
                .pl_header_menu_form:after {
                    display: block;
                }
            </style>
            <script>
                window.location.href = "<?php echo $dashboard_url; ?>";
            </script>
        <?php
            die;
        } else {
        ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                La password non corrisponde
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
        }
    } else {
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            L'utente e la password sono sbagliati o il profilo non è ancora attivo.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    }

    die;
}

add_action('wp_ajax_pl_user_login_form_action', 'pl_user_login_form_action');
add_action('wp_ajax_nopriv_pl_user_login_form_action', 'pl_user_login_form_action');

function pl_user_pass_recovery_form_action()
{

    global $wpdb;

    $user_email = sanitize_text_field($_POST['user_email']) ?? '';

    global $wpdb;
    $pl_customers_table             = $wpdb->prefix . 'pl_customers';
    $get_results = $wpdb->get_row("SELECT * FROM {$pl_customers_table} WHERE email = '{$user_email}' AND user_status = 1");

    $user_id = $get_results->id ?? '';
    $user_email = $get_results->email ?? '';
    $user_pass = $get_results->user_pass ?? '';
    $user_name = $get_results->user_name ?? '';

    if ($user_email) {

        $pass_recovery_url = site_url() . "/forgot-password/?id=$user_id&security=$user_pass";;

        $to_mail  = $user_email;
        $subject  = "Recupero della password";

        $headers  = '';
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        $msg = '';
        $msg .= 'Gentile ' . $user_name . ",<br><br>";
        $msg .= 'Si prega di aggiornare la password utilizzando il seguente URL ' . "<br><br>";
        $msg .= ' <a style="display: block; padding: 10px 30px; width: 150px; background: #f68b2e; text-align: center; text-decoration: nono; color: #fff; font-weight: 600" href="' . $pass_recovery_url . '">' . 'Aggiorna password' . '</a> <br><br>';
        $msg .= 'Grazie,' . "<br>";
        wp_mail($to_mail, $subject, $msg, $headers);

    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Controlla la tua email per aggiornare la password
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    } else {
    ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Spiacente, questo utente non esiste
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
<?php
    }

    die;
}

add_action('wp_ajax_pl_user_pass_recovery_form_action', 'pl_user_pass_recovery_form_action');
add_action('wp_ajax_nopriv_pl_user_pass_recovery_form_action', 'pl_user_pass_recovery_form_action');

?>