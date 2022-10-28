<?php

function visible_activation_form_action()
{
    global $wpdb;
    $pl_customers_table             = $wpdb->prefix . 'pl_customers';
    $user_id = sanitize_key($_POST['user_id']);
    $approve_results = $wpdb->get_row("SELECT * FROM {$pl_customers_table} WHERE id = $user_id");
    $user_name = $approve_results->user_name;
    $email = $approve_results->email;
    $activation_url = site_url() . "/user-activation/?activate-user=$user_id";
    $wpdb->update(
        $pl_customers_table,
        array(
            'approve' => 1,
        ),
        array('id' => $user_id),
    );

    $to_mail  = $email;
    $subject  = "Attivazione profilo area riservata";

    $headers  = '';
    //     $headers .= "From: Attivazione del profilo <noreply@polielectra.ch> \r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    $msg = '';
    $msg .= 'Gentile ' . $user_name . ",<br><br>";
    $msg .= 'Il tuo profilo è pronto, clicca sul pulsante qui in sovraimpressione per attivarlo.' . "<br><br>";
    $msg .= '<a style="display: block; padding: 10px 30px; width: 120px; background: #f68b2e; text-align: center; text-decoration: nono; color: #fff; font-weight: 600" href="' . $activation_url . '">' . 'Attivalo ora' . '</a>' . "<br>";
    $msg .= 'Grazie,' . "<br>";
    $msg .= 'La direzione' . "<br>";

    wp_mail($to_mail, $subject, $msg, $headers);
    // 	 mail($to_mail, $subject, $msg, $headers, 'polielectra.ch');
?>
    <p class="btn btn-info" style="min-width: 200px; margin-left: 5px">In attesa di attivazione</p>
    <?php

    die;
}


add_action('wp_ajax_visible_activation_form_action', 'visible_activation_form_action');
add_action('wp_ajax_nopriv_visible_activation_form_action', 'visible_activation_form_action');


function admin_send_file_action()
{

    global $wpdb;
    $pl_pdf_files_table             = $wpdb->prefix . 'pl_pdf_files';
    $pl_customers_table             = $wpdb->prefix . 'pl_customers';

    $get_user_id = sanitize_key($_POST['get_user_id']);
    $get_results = $wpdb->get_row("SELECT * FROM {$pl_customers_table} WHERE id = $get_user_id");
    $get_user = $get_results->user_name;
    $get_admin_id = sanitize_key($_POST['get_admin_id']);

    $set_pdf_url = $_POST['set_pdf_url'];
    $make_array = explode(".", $set_pdf_url);
    $get_last_name = end($make_array);

    $wpdb->insert(
        $pl_pdf_files_table,
        array(
            'sender_id' => $get_admin_id,
            'user_id'   => $get_user_id,
            'pdf_url'   => $set_pdf_url,
        ),
    );

    // if ('pdf' == $get_last_name) {

    // } 
    die;
}


add_action('wp_ajax_admin_send_file_action', 'admin_send_file_action');
add_action('wp_ajax_nopriv_admin_send_file_action', 'admin_send_file_action');




function confirm_delete_user_action()
{
    global $wpdb;
    $pl_customers_table             = $wpdb->prefix . 'pl_customers';
    $pl_newsletter_table             = $wpdb->prefix . 'pl_newsletter';
    $pl_pdf_files_table             = $wpdb->prefix . 'pl_pdf_files';
    $pl_user_files_table             = $wpdb->prefix . 'pl_user_files';
    $pl_user_guoup_table             = $wpdb->prefix . 'pl_user_guoup';

    $user_id = sanitize_key($_POST['user_id']);

    $wpdb->delete($pl_customers_table, array('id' => $user_id));
    $wpdb->delete($pl_user_guoup_table, array('user_id' => $user_id));

    $file_results = $wpdb->get_results("SELECT * FROM {$pl_pdf_files_table} WHERE user_id = $user_id ");

    $total_files = count($file_results);
    for ($i = 0; $i < $total_files; $i++) {
        $wpdb->delete($pl_pdf_files_table, array('user_id' => $file_results[$i]->user_id));
    }


    $newsletter_results = $wpdb->get_results("SELECT * FROM {$pl_newsletter_table} WHERE user_id = $user_id ");

    $total_newsletter = count($newsletter_results);
    for ($i = 0; $i < $total_newsletter; $i++) {
        $wpdb->delete($pl_newsletter_table, array('user_id' => $newsletter_results[$i]->user_id));
    }

    $user_file_results = $wpdb->get_results("SELECT * FROM {$pl_user_files_table} WHERE user_id = $user_id ");
    $total_user_files = count($user_file_results);
    for ($i = 0; $i < $total_user_files; $i++) {
        $wpdb->delete($pl_user_files_table, array('user_id' => $user_file_results[$i]->user_id));
    }


    die;
}



add_action('wp_ajax_confirm_delete_user_action', 'confirm_delete_user_action');
add_action('wp_ajax_nopriv_confirm_delete_user_action', 'confirm_delete_user_action');

function bulk_file_send_form_action()
{



    global $wpdb;
    $admin_user_id = get_current_user_id();
    $pl_pdf_files_table     = $wpdb->prefix . 'pl_pdf_files';
    $pl_customers_table     = $wpdb->prefix . 'pl_customers';

    $blk_get_user_ids = $_POST['blk_get_user_ids'];
    $upload_pdf_file = $_POST['upload_pdf_file'];

    if ($upload_pdf_file) {
        $total_user_ids = count($blk_get_user_ids);
        if ($total_user_ids > 0) {
            for ($i = 0; $i < $total_user_ids; $i++) {
                $customers_results = $wpdb->get_row("SELECT * FROM {$pl_customers_table} WHERE id = $blk_get_user_ids[$i]");
                $user_name = $customers_results->user_name;
                $email = $customers_results->email;


                $wpdb->insert(
                    $pl_pdf_files_table,
                    array(
                        'sender_id' => $admin_user_id,
                        'user_id' => $blk_get_user_ids[$i],
                        'pdf_url' => $upload_pdf_file,
                    ),
                );
                // send mail to users 
                $to_mail  = $email;

                $subject  = "File ricevuto";

                $headers  = '';
                //             $headers .= "From: File ricevuto <noreply@polielectra.ch> \r\n";
                $headers .= "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                $msg = '';
                $msg .= 'Gentile ' . $user_name . ",<br><br>";
                $msg .= 'Hai ricevuto un file da parte dell’amministrazione nella tua area privata.' . "<br><br>";
                $msg .= '<a style="display: block; padding: 10px 30px; width: 100px; background: #f68b2e; text-align: center; text-decoration: nono; color: #fff; font-weight: 600" href="' . $upload_pdf_file . '">' . 'Controlla il file' . '</a>' . "<br><br>";
                $msg .= 'Grazie,' . "<br>";
                $msg .= 'La direzione.';
                wp_mail($to_mail, $subject, $msg, $headers);
            }
    ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>File inviato correttamente</strong>
            </div>
        <?php
        } else {
        ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>File non ancora inviato</strong>
            </div>
        <?php
        }
    } else {
        ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>Si prega di caricare il file</strong>
        </div>
    <?php
    }


    die;
}


add_action('wp_ajax_bulk_file_send_form_action', 'bulk_file_send_form_action');
add_action('wp_ajax_nopriv_bulk_file_send_form_action', 'bulk_file_send_form_action');

function group_creation_form_action()
{



    global $wpdb;
    $pl_guoup_table     = $wpdb->prefix . 'pl_guoup';
    $group_name = $_POST['group_name'];
    $param = $_POST['param'];

    $group_results = $wpdb->get_row("SELECT * FROM {$pl_guoup_table} WHERE group_name = '{$group_name}'");
    $is_group_name = $group_results->group_name;
    if ($is_group_name) {
    ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>This group name already exist</strong>
        </div>
        <?php
    } else {
        if ('form_data' == $param) {
            $wpdb->insert(
                $pl_guoup_table,
                array(
                    'group_name' => $group_name,
                ),
            );
        ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Group created successfully</strong>
            </div>
        <?php
        }
    }


    die;
}


add_action('wp_ajax_group_creation_form_action', 'group_creation_form_action');
add_action('wp_ajax_nopriv_group_creation_form_action', 'group_creation_form_action');

function add_user_to_group_action()
{



    global $wpdb;
    $pl_user_guoup_table     = $wpdb->prefix . 'pl_user_guoup';

    $user_id = $_POST['user_id'];
    $group_name = $_POST['group_name'];
    $user_email = $_POST['user_email'];
    $param = $_POST['param'];

    $get_results = $wpdb->get_row("SELECT * FROM {$pl_user_guoup_table} WHERE user_id=$user_id AND group_name='{$group_name}'");

    $is_user_id = $get_results->user_id;
    if ($is_user_id) {
        ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>Prova con un altro gruppo</strong>
        </div>
    <?php
    } else {
        $wpdb->insert(
            $pl_user_guoup_table,
            array(
                'user_id' => $user_id,
                'group_name' => $group_name,
                'user_email' => $user_email,
            ),
        );
    ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>Utente aggiunto al gruppo</strong>
        </div>
        <?php
    }


    die;
}


add_action('wp_ajax_add_user_to_group_action', 'add_user_to_group_action');
add_action('wp_ajax_nopriv_add_user_to_group_action', 'add_user_to_group_action');

function user_group_file_process_form_action()
{

    global $wpdb;
    $admin_user_id          = get_current_user_id();
    $pl_user_guoup_table    = $wpdb->prefix . 'pl_user_guoup';
    $pl_pdf_files_table     = $wpdb->prefix . 'pl_pdf_files';
    $pl_customers_table     = $wpdb->prefix . 'pl_customers';



    $upload_pdf_file = $_POST['upload_pdf_file'];
    if ($upload_pdf_file) {

        $setup_group_name = $_POST['setup_group_name'];
        if ($setup_group_name) {
            foreach ($setup_group_name as $single_group) {
                $get_results = $wpdb->get_results("SELECT * FROM {$pl_user_guoup_table} WHERE group_name = '{$single_group}'");

                foreach ($get_results as $single_item) {
                    $user_mail_to = $single_item->user_email;
                    $user_group_name = $single_item->group_name;
                    $user_id = $single_item->user_id;

                    $get_user_results = $wpdb->get_row("SELECT * FROM {$pl_customers_table} WHERE id = $user_id");
                    $get_user_name = $get_user_results->user_name;

                    $wpdb->insert(
                        $pl_pdf_files_table,
                        array(
                            'sender_id' => $admin_user_id,
                            'user_id'   => $user_id,
                            'pdf_group' => $user_group_name,
                            'pdf_url'   => $upload_pdf_file,
                        ),
                    );

                    // send mail to users 
                    $to_mail  = $user_mail_to;

                    $subject  = "File ricevuto";

                    $headers  = '';
                    //             $headers .= "From: File ricevuto <noreply@polielectra.ch> \r\n";
                    $headers .= "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                    $msg = '';
                    $msg .= 'Gentile ' . $get_user_name . ",<br><br>";
                    $msg .= 'Hai ricevuto un file da parte dell’amministrazione nella tua area privata.' . "<br><br>";
                    $msg .= '<a style="display: block; padding: 10px 30px; width: 100px; background: #f68b2e; text-align: center; text-decoration: nono; color: #fff; font-weight: 600" href="' . $upload_pdf_file . '">' . 'Controlla il file' . '</a>' . "<br><br>";
                    $msg .= 'Grazie,' . "<br>";
                    $msg .= 'La direzione.';
                    wp_mail($to_mail, $subject, $msg, $headers);
                }
            }
        ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>File inviato correttamente</strong>
            </div>
        <?php
        } else {
        ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Si prega di controllare qualsiasi gruppo</strong>
            </div>
        <?php
        }
    } else {
        ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>Si prega di caricare il file</strong>
        </div>
        <?php
    }

    die;
}


add_action('wp_ajax_user_group_file_process_form_action', 'user_group_file_process_form_action');
add_action('wp_ajax_nopriv_user_group_file_process_form_action', 'user_group_file_process_form_action');

function confirm_delete_user_from_group_action()
{

    global $wpdb;
    $pl_user_guoup_table    = $wpdb->prefix . 'pl_user_guoup';
    $g_user_id = $_POST['g_user_id'];
    $wpdb->delete($pl_user_guoup_table, array('id' => $g_user_id));
    die;
}


add_action('wp_ajax_confirm_delete_user_from_group_action', 'confirm_delete_user_from_group_action');
add_action('wp_ajax_nopriv_confirm_delete_user_from_group_action', 'confirm_delete_user_from_group_action');

function confirm_delete_group_action()
{

    global $wpdb;
    $pl_guoup_table    = $wpdb->prefix . 'pl_guoup';
    $pl_user_guoup_table    = $wpdb->prefix . 'pl_user_guoup';
    $group_id = $_POST['group_id'];


    $group_results = $wpdb->get_row("SELECT * FROM {$pl_guoup_table} WHERE id = $group_id ");
    $group_name = $group_results->group_name;

    $user_group_results = $wpdb->get_results("SELECT * FROM {$pl_user_guoup_table} WHERE group_name = '{$group_name}' ");

    $total_groups = count($user_group_results);
    for ($i = 0; $i < $total_groups; $i++) {
        $wpdb->delete($pl_user_guoup_table, array('group_name' => $user_group_results[$i]->group_name));
    }

    $wpdb->delete($pl_guoup_table, array('id' => $group_id));


    die;
}


add_action('wp_ajax_confirm_delete_group_action', 'confirm_delete_group_action');
add_action('wp_ajax_nopriv_confirm_delete_group_action', 'confirm_delete_group_action');

function send_file_ind_all_form_action()
{

    global $wpdb;
    $admin_user_id          = get_current_user_id();
    $pl_guoup_table         = $wpdb->prefix . 'pl_guoup';
    $pl_user_guoup_table    = $wpdb->prefix . 'pl_user_guoup';
    $pl_pdf_files_table     = $wpdb->prefix . 'pl_pdf_files';
    $pl_customers_table     = $wpdb->prefix . 'pl_customers';

    $customers_results = $wpdb->get_results("SELECT * FROM {$pl_customers_table} WHERE user_status = 1 AND approve = 1");


    $send_file_to = $_POST['send_file_to'];

    $ind_upload_pdf_file = $_POST['ind_upload_pdf_file'];
    $select_u_group = $_POST['select_u_group'] ?? '';

    if ($ind_upload_pdf_file) {
        if ('send_to_individual' == $send_file_to) {
            $ind_set_emails = $_POST['ind_set_email'];
            $get_selected_uids = $_POST['get_selected_uid'];
            if ($ind_set_emails) {
                $final_ids = [];
                foreach ($get_selected_uids as $key => $single_ind_id) {
                    if ($get_selected_uids[$key] != '') {
                        $final_ids[] = $get_selected_uids[$key];
                    }
                }
                foreach ($ind_set_emails as $ind_key => $single_ind_eml) {

                    $user_mail_to = $single_ind_eml;
                    $user_id = $final_ids[$ind_key];

                    $get_user_results = $wpdb->get_row("SELECT * FROM {$pl_customers_table} WHERE id = $user_id");
                    $get_user_name = $get_user_results->user_name;

                    $wpdb->insert(
                        $pl_pdf_files_table,
                        array(
                            'sender_id' => $admin_user_id,
                            'user_id' => $user_id,
                            'pdf_group' => $select_u_group,
                            'pdf_url' => $ind_upload_pdf_file,
                        ),
                    );
                    // send mail to users 
                    $to_mail  = $user_mail_to;

                    $subject  = "File ricevuto";

                    $headers  = '';
                    //             $headers .= "From: File ricevuto <noreply@polielectra.ch> \r\n";
                    $headers .= "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                    $msg = '';
                    $msg .= 'Gentile ' . $get_user_name . ",<br><br>";
                    $msg .= 'Hai ricevuto un file da parte dell’amministrazione nella tua area privata.' . "<br><br>";
                    $msg .= '<a style="display: block; padding: 10px 30px; width: 100px; background: #f68b2e; text-align: center; text-decoration: nono; color: #fff; font-weight: 600" href="' . $ind_upload_pdf_file . '">' . 'Controlla il file' . '</a>' . "<br><br>";
                    $msg .= 'Grazie,' . "<br>";
                    $msg .= 'La direzione.';
                    wp_mail($to_mail, $subject, $msg, $headers);
                }
        ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong>File inviato con successo</strong>
                </div>
            <?php
            } else {
            ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong>Si prega di controllare qualsiasi utente</strong>
                </div>
            <?php
            }
        } else {

            foreach ($customers_results as $send_to_all) {
                $user_id = $send_to_all->id;
                $get_user_name = $send_to_all->user_name;
                $user_mail_to = $send_to_all->email;

                $wpdb->insert(
                    $pl_pdf_files_table,
                    array(
                        'sender_id' => $admin_user_id,
                        'user_id' => $user_id,
                        'pdf_group' => $select_u_group,
                        'pdf_url' => $ind_upload_pdf_file,
                    ),
                );
                // send mail to users 
                $to_mail  = $user_mail_to;

                $subject  = "File ricevuto";

                $headers  = '';
                //             $headers .= "From: File ricevuto <noreply@polielectra.ch> \r\n";
                $headers .= "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                $msg = '';
                $msg .= 'Gentile ' . $get_user_name . ",<br><br>";
                $msg .= 'Hai ricevuto un file da parte dell’amministrazione nella tua area privata.' . "<br><br>";
                $msg .= '<a style="display: block; padding: 10px 30px; width: 100px; background: #f68b2e; text-align: center; text-decoration: nono; color: #fff; font-weight: 600" href="' . $ind_upload_pdf_file . '">' . 'Controlla il file' . '</a>' . "<br><br>";
                $msg .= 'Grazie,' . "<br>";
                $msg .= 'La direzione.';
                wp_mail($to_mail, $subject, $msg, $headers);
            }
            ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>File inviato con successo</strong>
            </div>
        <?php
        }
    } else {
        ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>Si prega di caricare il file</strong>
        </div>
<?php
    }

    die;
}


add_action('wp_ajax_send_file_ind_all_form_action', 'send_file_ind_all_form_action');
add_action('wp_ajax_nopriv_send_file_ind_all_form_action', 'send_file_ind_all_form_action');
