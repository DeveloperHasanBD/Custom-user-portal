<?php

function hidden_field_for_logout_user()
{
?>
    <script>
        const user_name = localStorage.getItem('user_name');
        const user_company = localStorage.getItem('user_company');
        if (!user_name) {
            (function($) {
                $(document).ready(function() {
                    $(".hidden_for_logout_user").css({
                        'display': 'none',
                    });
                });
            })(jQuery)
        }
        if (user_name) {
            (function($) {
                $(document).ready(function() {
                    $(".login_username").html('Ciao, ' + user_name);
                    $(".lonin_ucompany_name").html('Azienda: ' + user_company);
                });
            })(jQuery)
        }
    </script>

<?php
}
add_action('wp_footer', 'hidden_field_for_logout_user');



function divi_admin_dashboard_options()
{
    global $wpdb;
    $pl_customers_table             = $wpdb->prefix . 'pl_customers';
    $customers_results = $wpdb->get_results("SELECT * FROM {$pl_customers_table} WHERE user_status = 0 ");
    $active_customers_results = $wpdb->get_results("SELECT * FROM {$pl_customers_table} WHERE user_status = 1 AND approve = 1");
?>

    <div class="mt-3 shadow p-3 mb-3 bg-body rounded user-dashboard widgets-items">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="section-title mt-3 shadow p-3 mb-3 bg-body rounded">
                        <h2>Elenco degli utenti in attesa</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end top  -->
    <!-- paid members  -->

    <div class="mt-3 shadow p-3 mb-3 bg-body rounded widgets-items">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="regione_list mt-3 shadow-lg p-3 mb-3 bg-body rounded">
                        <table id="pending_customers_table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Cognome</th>
                                    <th>Azienda</th>
                                    <th>Indirizzo</th>
                                    <th>Nap</th>
                                    <th>Città</th>
                                    <th>Email</th>
                                    <th>Telefono</th>
                                    <th>Ruolo</th>
                                    <th>Privacy</th>
                                    <th>Termini</th>
                                    <th>Azione</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($customers_results as $single_item) {
                                    $user_id = $single_item->id;
                                    $user_name = $single_item->user_name;
                                    $surname = $single_item->surname;
                                    $company = $single_item->company;
                                    $address = $single_item->address;
                                    $nap = $single_item->nap;
                                    $city = $single_item->city;
                                    $email = $single_item->email;
                                    $telephone_number = $single_item->telephone_number;
                                    $select_role = $single_item->select_role;
                                    $policy_acceptance = $single_item->policy_acceptance;
                                    $accet_condizioni = $single_item->accet_condizioni;
                                ?>
                                    <tr>
                                        <td><?php echo $user_name; ?></td>
                                        <td><?php echo $surname; ?></td>
                                        <td><?php echo $company; ?></td>
                                        <td><?php echo $address; ?></td>
                                        <td><?php echo $nap; ?></td>
                                        <td><?php echo $city; ?></td>
                                        <td><?php echo $email; ?></td>
                                        <td><?php echo $telephone_number; ?></td>
                                        <td><?php echo $select_role; ?></td>
                                        <td><?php echo $policy_acceptance; ?></td>
                                        <td><?php echo $accet_condizioni; ?></td>
                                        <td>
                                            <div class="action_dgn">
                                                <div class="update_dlt">
                                                    <div class="delete_user running_dlt_btn_<?php echo $user_id; ?>" user_id="<?php echo $user_id; ?>">
                                                        <span class="check_delete btn btn-danger ">
                                                            Elimina
                                                        </span>
                                                        <span class="confirm_delete">
                                                            <div class="confirm_delete_user btn btn-danger running_dlt_btn_<?php echo $user_id; ?>" user_id="<?php echo $user_id; ?>">Conferma cancellazione ?</div>
                                                        </span>
                                                    </div>

                                                    <?php
                                                    $approve_results = $wpdb->get_row("SELECT * FROM {$pl_customers_table} WHERE id = $user_id AND user_status = 0 AND approve = 1");

                                                    $approval_user_name = $approve_results->user_name ?? '';
                                                    if ($approval_user_name) {
                                                    ?>
                                                        <p class="btn btn-info">In attesa di attivazione</p>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <div class="visible_activation_form btn btn-warning running_btn_<?php echo $user_id; ?>" user_id="<?php echo $user_id; ?>">Approva ora</div>
                                                        <div class="visible_activation_form_message_<?php echo $user_id ?>"></div>
                                                    <?php
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Active users list  -->
    <div class="mt-3 shadow p-3 mb-3 bg-body rounded user-dashboard widgets-items">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="section-title mt-3 shadow p-3 mb-3 bg-body rounded">
                        <h2>Elenco degli utenti attivi</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end top  -->
    <!-- paid members  -->

    <div class="mt-3 shadow p-3 mb-3 bg-body rounded widgets-items">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="regione_list mt-3 shadow-lg p-3 mb-3 bg-body rounded">
                        <table id="active_customers_table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Cognome</th>
                                    <th>Azienda</th>
                                    <th>Codice cliente</th>
                                    <th>Azione</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($active_customers_results as $single_item) {
                                    $user_id = $single_item->id;
                                    $surname = $single_item->surname;
                                    $company = $single_item->company;
                                    $customer_code = $single_item->customer_code;
                                ?>
                                    <tr>
                                        <td><?php echo ucwords($surname); ?></td>
                                        <td><?php echo $company; ?></td>
                                        <td><?php echo $customer_code; ?></td>
                                        <td>
                                            <div class="action_dgn">
                                                <div class="update_dlt">


                                                    <div class="delete_user running_dlt_btn_<?php echo $user_id; ?>" user_id="<?php echo $user_id; ?>">
                                                        <span class="check_delete btn btn-danger ">
                                                            Cancella
                                                        </span>
                                                        <span class="confirm_delete">
                                                            <div class="confirm_delete_user btn btn-danger running_dlt_btn_<?php echo $user_id; ?>" user_id="<?php echo $user_id; ?>">Confermare l'eliminazione?</div>
                                                        </span>
                                                    </div>

                                                    <a class="btn btn-primary details" href="<?php echo admin_url("admin.php?page=user-details&id=$user_id"); ?>" class="btn btn-warning">Dettagli</a>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}

/**
 * Start admin work
 */
function divi_admin_file_process()

{
    global $wpdb;
    $pl_customers_table             = $wpdb->prefix . 'pl_customers';
    $pl_guoup_table                 = $wpdb->prefix . 'pl_guoup';
    $pl_user_guoup_table                 = $wpdb->prefix . 'pl_user_guoup';
    $pl_newsletter_table                 = $wpdb->prefix . 'pl_newsletter';
    $customers_results = $wpdb->get_results("SELECT * FROM {$pl_customers_table} WHERE user_status = 1 AND approve = 1");
    $guoup_results = $wpdb->get_results("SELECT * FROM {$pl_guoup_table}");

    wp_enqueue_media();

    $get_admin_id = get_current_user_id();
?>
    <style>
        .single_nletter span {
            text-transform: capitalize;
        }

        .single_nletter:last-child span:last-child {
            display: none;
        }

        form#user_group_file_process_form .dataTables_filter {
            display: none;
        }
    </style>
    <div class="mt-3 shadow p-3 mb-3 bg-body rounded user-dashboard">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="section-title mt-3 shadow p-3 mb-3 bg-body rounded">
                        <h2>Area di invio file</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form id="send_file_ind_all_form" action="">
        <div class="mt-3 shadow p-3 mb-3 bg-body rounded">
            <div class="container-fluid">
                <div class="row">
                    <!-- <div class="col-sm-12 col-md-12 col-lg-12 col-xl-2"></div> -->
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="group_form mt-3 shadow-lg p-3 mb-3 bg-body rounded">
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-8">
                                    <!-- <center> -->
                                    <div id="send_file_ind_all_form_message"></div>
                                    <!-- </center> -->
                                    <div class="file_and_send_btn">
                                        <div class="file_input_box">
                                            <div class="file_input_box_left">
                                                <div class="form-group">
                                                    <input type="button" id="upload_file" class="ind_upload_pdf_file" value="Carica file" class="form-control">
                                                </div>
                                            </div>
                                            <div class="file_input_box_right">
                                                <input id="set_file_url_inda" name="ind_upload_pdf_file" type="hidden">
                                                <div id="show_file_url_inda"></div>
                                            </div>
                                        </div>
                                        <div class="bulk_file_btn">
                                            <div id="bulk_file_send_form_message"></div>
                                            <input class="bulk_file_send_dgn" type="submit" value="Invia file">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2"></div>
                            </div>
                        </div>
                        <div class="regione_list mt-3 shadow-lg p-3 mb-3 bg-body rounded">
                            <div class="ind_file_send_to_users">
                                <div class="ind_single_item">
                                    <input name="send_file_to" id="send_to_individual" type="radio" value="send_to_individual">
                                    <label for="send_to_individual">Invio individuale (seleziona destinatari)</label>
                                </div>
                                <div class="ind_single_item">
                                    <input name="send_file_to" id="send_to_all" type="radio" value="send_to_all">
                                    <label for="send_to_all">Invio a tutti gli utenti (selezione non necessaria) </label>
                                </div>
                                <div class="ind_single_item">
                                    <!-- <select name="select_u_group" id="" class="form-control">
                                        <option value="" selected disable>Seleziona Gruppo</option>
                                    </select> -->
                                    <?php
                                    // foreach ($guoup_results as $single_ind_group) {
                                    //     echo $single_ind_group->group_name; //value
                                    //     echo ucwords($single_ind_group->group_name; //option

                                    // }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="regione_list mt-3 shadow-lg p-3 mb-3 bg-body rounded">
                            <table id="ind_send_file_table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>Newsletter</th>
                                        <th>Ruolo in azienda</th>
                                        <th>Seleziona utente</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ind_incr = 1;
                                    foreach ($customers_results as $ind_single_user) {
                                        $finan_ind_incr = $ind_incr++;
                                        $ind_user_name = $ind_single_user->user_name;
                                        $ind_user_id = $ind_single_user->id;
                                        $ind_email = $ind_single_user->email;

                                        $user_id = $ind_single_user->id;
                                        $newsletter_results = $wpdb->get_results("SELECT * FROM {$pl_newsletter_table} WHERE user_id = $user_id");
                                        $customer_rl_results = $wpdb->get_row("SELECT * FROM {$pl_customers_table} WHERE id = $user_id");
                                        $select_role = $customer_rl_results->select_role;


                                    ?>
                                        <tr>
                                            <td class="align-middle"><?php echo $ind_user_name; ?></td>
                                            <td class="align-middle"><?php echo $ind_email; ?></td>
                                            <td class="align-middle">
                                                <?php
                                                foreach ($newsletter_results as $single_nltr) {
                                                ?>
                                                    <div class="single_nletter">
                                                        <span><?php echo $single_nltr->select_item; ?> </span> <span>, <br></span>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td class="align-middle"><?php echo $select_role; ?></td>
                                            <td class="align-middle">
                                                <input class="get_ind_email" type="checkbox" name="ind_set_email[]" get_row_id="<?php echo $finan_ind_incr; ?>">
                                                <input value="<?php echo $ind_email; ?>" type="hidden" id="ind_hidden_email_<?php echo $finan_ind_incr; ?>">


                                                <input type="hidden" id="set_selected_id_<?php echo $finan_ind_incr; ?>" name="get_selected_uid[]">
                                                <input type="hidden" id="get_selected_id_<?php echo $finan_ind_incr; ?>" value="<?php echo $ind_user_id; ?>">
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end col  -->

                </div>
            </div>
        </div>
    </form>
    <!-- end send file to individual / all users  -->

    <div class="mt-3 shadow p-3 mb-3 bg-body rounded user-dashboard">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="section-title mt-3 shadow p-3 mb-3 bg-body rounded">
                        <h2>Gruppi e Utenti</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end top  -->
    <!-- paid members  -->

    <div class="mt-3 shadow p-3 mb-3 bg-body rounded">
        <div class="container-fluid">
            <div class="row">
                <!-- <div class="col-sm-12 col-md-12 col-lg-12 col-xl-2"></div> -->
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="group_form mt-3 shadow-lg p-3 mb-3 bg-body rounded">
                        <div id="group_creation_form_message"></div>
                        <?php
                        $edit_id = $_GET['edit-id'] ?? '';
                        if (isset($_POST['updt_group'])) {
                            $group_name = $_POST['group_name'];
                            $wpdb->update(
                                $pl_guoup_table,
                                array(
                                    'group_name' => $group_name,
                                ),
                                array('id' => $edit_id),
                            );
                        ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                <strong>Data update successfully</strong>
                            </div>
                        <?php
                        }
                        if ($edit_id) {

                            $group_result = $wpdb->get_row("SELECT * FROM {$pl_guoup_table} WHERE id = $edit_id");
                            $get_group_name = $group_result->group_name;
                        ?>
                            <form action="" method="POST">
                                <label for="group_name">Aggiungi Gruppo</label>
                                <input id="group_name" name="group_name" type="text" value="<?php echo $get_group_name; ?>" class="form-control">
                                <input type="submit" value="Update" name="updt_group">
                                <a class="btn btn-primary details" href="<?php echo admin_url("admin.php?page=file-process"); ?>" class="btn btn-warning">Aggiungi nuovo gruppo ?</a>
                            </form>
                        <?php
                        } else {
                        ?>
                            <form id="group_creation_form" action="">
                                <label for="group_name">Aggiungi Gruppo</label>
                                <input id="group_name" name="group_name" type="text" class="form-control">
                                <input type="submit" value="Invia" name="crt_group">
                            </form>
                        <?php
                        }
                        ?>

                    </div>
                    <div class="regione_list mt-3 shadow-lg p-3 mb-3 bg-body rounded">
                        <table id="group_names_table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nome Gruppo</th>
                                    <th>
                                        <!-- Action -->
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($guoup_results as $single_group) {
                                    $group_id = $single_group->id;
                                    $group_name = $single_group->group_name;
                                ?>
                                    <tr class="total_rows">
                                        <td><?php echo $group_name; ?></td>
                                        <td>
                                            <div class="group_action_box">
                                                <div class="delete_user running_dlt_btn_<?php echo $group_id; ?>" user_id="<?php echo $group_id; ?>">
                                                    <span class="check_delete_group btn btn-danger ">
                                                        Elimina
                                                    </span>
                                                    <span class="confirm_delete">
                                                        <div class="confirm_delete_group btn btn-danger running_dlt_btn_<?php echo $group_id; ?>" group_id="<?php echo $group_id; ?>">Conferma cancellazione ?</div>
                                                    </span>
                                                </div>
                                                <div class="edit_box">
                                                    <a class="btn btn-primary details" href="<?php echo admin_url("admin.php?page=file-process&edit-id=$group_id"); ?>" class="btn btn-warning">Modifica</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="regione_list mt-3 shadow-lg p-3 mb-3 bg-body rounded">
                        <table id="pending_customers_table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="d-none">Serial</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Newsletter</th>
                                    <th>Ruolo in azienda</th>
                                    <th>Gruppo</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $i = 1;
                                foreach ($customers_results as $single_user) {
                                    $user_name = $single_user->user_name;
                                    $email = $single_user->email;
                                    $user_id = $single_user->id;
                                    $final_incre = $i++;
                                    $newsletter_results = $wpdb->get_results("SELECT * FROM {$pl_newsletter_table} WHERE user_id = $user_id");
                                    $customer_rl_results = $wpdb->get_row("SELECT * FROM {$pl_customers_table} WHERE id = $user_id");
                                    $select_role = $customer_rl_results->select_role;

                                ?>
                                    <tr class="total_rows">
                                        <td class="align-middle d-none"><?php echo $final_incre; ?></td>
                                        <td class="align-middle username_color"><a href="<?php echo admin_url("admin.php?page=user-details&id=$user_id"); ?>"><?php echo $user_name; ?></a></td>
                                        <td class="align-middle"><?php echo $email; ?></td>
                                        <td class="align-middle">
                                            <?php
                                            foreach ($newsletter_results as $single_nltr) {
                                            ?>
                                                <div class="single_nletter">
                                                    <span><?php echo $single_nltr->select_item; ?> </span> <span>, <br></span>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                        <td class="align-middle"><?php echo $select_role; ?></td>
                                        <td class="align-middle">
                                            <div class="group_main_box_inner">
                                                <div class="message_box">
                                                    <div class="add_user_to_group_action_message_<?php echo $final_incre; ?>"></div>
                                                </div>
                                                <div class="group_main_box_inner">
                                                    <?php
                                                    $group_results = $wpdb->get_results("SELECT * FROM {$pl_guoup_table}");
                                                    ?>
                                                    <select group_row_id="<?php echo $final_incre; ?>" name="" id="" class="form-control add_user_to_group">
                                                        <option value="" selected disabled>Seleziona Gruppo</option>
                                                        <?php
                                                        foreach ($group_results as $single_group_item) {
                                                            $get_single_group_name = $single_group_item->group_name;
                                                        ?>
                                                            <option value="<?php echo $get_single_group_name ?>"><?php echo $get_single_group_name ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <input id="user_id_<?php echo $final_incre; ?>" type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                                    <input id="user_email_<?php echo $final_incre; ?>" type="hidden" name="user_email" value="<?php echo $email; ?>">

                                                </div>

                                            </div>

                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end col  -->

            </div>
        </div>
    </div>
    <?php
    $user_group_results = $wpdb->get_results("SELECT * FROM {$pl_guoup_table}");
    $total_group_count = count($user_group_results);
    if ($total_group_count > 0) {
    ?>
        <div class="mt-3 shadow p-3 mb-3 bg-body rounded user-dashboard">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title mt-3 shadow p-3 mb-3 bg-body rounded">
                            <h2>Invio file di gruppo</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form id="user_group_file_process_form" action="">
            <div class="mt-3 shadow p-3 mb-3 bg-body rounded user-dashboard">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="file_heading_text">
                                <h2>Si accettano file PDF o immagini</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-12">
                            <div class="mt-3 shadow p-3 mb-3 bg-body rounded">
                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col-8">
                                        <!-- <center> -->
                                        <div id="user_group_file_process_form_message"></div>
                                        <!-- </center> -->
                                        <div class="file_and_send_btn">
                                            <div class="file_input_box">
                                                <div class="file_input_box_left">
                                                    <div class="form-group">
                                                        <input type="button" id="upload_file" class="upload_pdf_file" value="Carica file" class="form-control">

                                                    </div>
                                                </div>
                                                <div class="file_input_box_right">
                                                    <input id="set_file_url" name="upload_pdf_file" type="hidden">
                                                    <div id="show_file_url"></div>

                                                </div>
                                            </div>
                                            <div class="bulk_file_btn">
                                                <div id="bulk_file_send_form_message"></div>
                                                <input class="bulk_file_send_dgn" type="submit" value="Invia file">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2"></div>
                                </div>

                            </div>
                            <div class="row">
                                <?php
                                $group_incr = 1;
                                $get_group_results = $wpdb->get_results("SELECT * FROM {$pl_guoup_table} ");
                                foreach ($get_group_results as $single_group_nm) {
                                    $group_name_display = $single_group_nm->group_name;
                                    $final_group_incr = $group_incr++;
                                ?>
                                    <script>
                                        (function($) {
                                            $(document).ready(function() {
                                                $('#user_group_<?php echo $final_group_incr ?>').DataTable();
                                                $('div#user_group_<?php echo $final_group_incr ?>_length').css({
                                                    'display': 'none'
                                                });
                                                $('div#user_group_<?php echo $final_group_incr ?>_info').css({
                                                    'display': 'none'
                                                });
                                            });
                                        })(jQuery)
                                    </script>
                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <div class="regione_list mt-3 shadow-lg p-3 mb-3 bg-body rounded">
                                            <div class="group_name_display">
                                                <div class="group_name_display_left">
                                                    <h2>
                                                        <span>Nome Gruppo:</span>
                                                        <?php echo $group_name_display; ?>
                                                    </h2>
                                                </div>
                                                <div class="group_name_display_right">
                                                    <input id="get_the_group_name_<?php echo $final_group_incr; ?>" type="hidden" name="get_group_nm" value="<?php echo $group_name_display; ?>">
                                                    <input id="selectc_grp_<?php echo $final_group_incr; ?>" class="set_group_name" set_row_id="<?php echo $final_group_incr; ?>" type="checkbox" name="setup_group_name[]">
                                                    <label for="selectc_grp_<?php echo $final_group_incr; ?>">Seleziona Gruppo</label>
                                                </div>
                                            </div>

                                            <table id="user_group_<?php echo $final_group_incr; ?>" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Nome</th>
                                                        <th>Email</th>
                                                        <th>Newsletter</th>
                                                        <th>Ruolo in azienda</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $get_user_group_results = $wpdb->get_results("SELECT * FROM {$pl_user_guoup_table} WHERE group_name ='{$group_name_display}'");
                                                    foreach ($get_user_group_results as $singlr_ugroup) {
                                                        $gtd_user_id = $singlr_ugroup->id;
                                                        $g_user_id = $singlr_ugroup->user_id;
                                                        $g_user_email = $singlr_ugroup->user_email;
                                                        $get_user_name_results = $wpdb->get_row("SELECT * FROM {$pl_customers_table} WHERE id =$g_user_id");
                                                        $g_user_name = $get_user_name_results->user_name;

                                                        $newsletter_grp_results = $wpdb->get_results("SELECT * FROM {$pl_newsletter_table} WHERE user_id = $g_user_id");
                                                        $customer_grp_results = $wpdb->get_row("SELECT * FROM {$pl_customers_table} WHERE id = $g_user_id");
                                                        $select_grp_role = $customer_grp_results->select_role;


                                                    ?>
                                                        <tr class="total_rows">
                                                            <td class="align-middle">
                                                                <a href="<?php echo admin_url("admin.php?page=user-details&id=$user_id"); ?>"><?php echo $g_user_name; ?>
                                                                </a>
                                                            </td>
                                                            <td class="align-middle"><?php echo $g_user_email; ?></td>
                                                            <td class="align-middle">
                                                                <?php
                                                                foreach ($newsletter_grp_results as $single_grp_nltr) {
                                                                ?>
                                                                    <div class="single_nletter">
                                                                        <span><?php echo $single_grp_nltr->select_item; ?> </span> <span>, <br></span>
                                                                    </div>
                                                                <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="align-middle"><?php echo $select_grp_role; ?></td>
                                                            <td class="align-middle">
                                                                <div class="delete_user_from_group running_dlt_btn_<?php echo $group_id; ?>" user_id="<?php echo $group_id; ?>">
                                                                    <span class="check_delete_group_single btn btn-danger ">
                                                                        Elimina
                                                                    </span>
                                                                    <span class="confirm_delete">
                                                                        <div class="confirm_delete_user_from_group btn btn-danger running_dlt_btn_<?php echo $group_id; ?>" g_user_id="<?php echo $gtd_user_id; ?>">Conferma cancellazione ?</div>
                                                                    </span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    <?php
    } else {
    ?>
        <div class="mt-3 shadow p-3 mb-3 bg-body rounded">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="regione_list mt-3 shadow-lg p-3 mb-3 bg-body rounded">
                            <p style="margin: 0px;">No group available yet</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>

    <?php
}

/**
 * Start divi_user_details
 */
function divi_user_details()
{
    $user_id = $_GET['id'] ?? '';
    global $wpdb;
    $pl_customers_table             = $wpdb->prefix . 'pl_customers';
    $customers_results = $wpdb->get_row("SELECT * FROM {$pl_customers_table} WHERE id = $user_id ");

    $user_name = $customers_results->user_name ?? '';
    $normal_name = $customers_results->normal_name ?? '';
    $customer_code = $customers_results->customer_code ?? '';
    $surname = $customers_results->surname ?? '';
    $company = $customers_results->company ?? '';
    $address = $customers_results->address ?? '';
    $nap = $customers_results->nap ?? '';
    $city = $customers_results->city ?? '';
    $email = $customers_results->email ?? '';
    $telephone_number = $customers_results->telephone_number ?? '';
    $select_role = $customers_results->select_role ?? '';
    $policy_acceptance = $customers_results->policy_acceptance ?? '';
    $accet_condizioni = $customers_results->accet_condizioni ?? '';


    $pl_newsletter_table             = $wpdb->prefix . 'pl_newsletter';
    $newsletter_yes_no_results = $wpdb->get_row("SELECT * FROM {$pl_newsletter_table} WHERE user_id = $user_id ");
    $newsletter_results = $wpdb->get_results("SELECT * FROM {$pl_newsletter_table} WHERE user_id = $user_id ");
    $ready_to_subs = $newsletter_yes_no_results->ready_to_subs ?? '';
    // $select_item = $newsletter_results->select_item ?? '';
    // $newsletter_mail = $newsletter_results->newsletter_mail ?? '';


    $pl_pdf_files_table             = $wpdb->prefix . 'pl_pdf_files';
    $file_results = $wpdb->get_results("SELECT * FROM {$pl_pdf_files_table} WHERE user_id = $user_id ");

    $pl_user_files_table             = $wpdb->prefix . 'pl_user_files';
    $received_file_results = $wpdb->get_results("SELECT * FROM {$pl_user_files_table} WHERE user_id = $user_id ");


    function update_user_role()
    {
        $list_rules = [
            'Titolare',
            'Dirigente',
            'Quadro',
            'Responsabile acquisti',
            'Responsabile commerciale',
            'Libero professionista',
            'Operatore specializzato',
        ];
        $user_id = $_GET['id'] ?? '';
        global $wpdb;
        $pl_customers_table             = $wpdb->prefix . 'pl_customers';
        $customers_results = $wpdb->get_row("SELECT * FROM {$pl_customers_table} WHERE id = $user_id ");
        $select_role = $customers_results->select_role ?? '';

        foreach ($list_rules as $single_role) {
            $selected = '';
            if ($select_role == $single_role) {
                $selected = 'selected';
            }
    ?>
            <option <?php echo $selected; ?> value="<?php echo $single_role; ?>"><?php echo $single_role; ?></option>
    <?php
        }
    }
    ?>
    <div class="mt-3 shadow p-3 mb-3 bg-body rounded user-dashboard">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="section-title mt-3 shadow p-3 mb-3 bg-body rounded">
                        <h2>Dettagli utente per ( <?php echo $user_name; ?> )</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end top  -->
    <!-- paid members  -->

    <div class="mt-3 shadow p-3 mb-3 bg-body rounded">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="regione_list mt-3 shadow-lg p-3 mb-3 bg-body rounded">
                        <table class="table table-striped">

                            <tbody>
                                <tr>
                                    <td><b>Nome utente</b></td>
                                    <td><?php echo $user_name; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Cognome</b></td>
                                    <td><?php echo $surname; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Azienda</b></td>
                                    <td><?php echo $company; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Indirizzo</b></td>
                                    <td><?php echo $address; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Nap</b></td>
                                    <td><?php echo $nap; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Città</b></td>
                                    <td><?php echo $city; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Email</b></td>
                                    <td><?php echo $email; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Telefono</b></td>
                                    <td><?php echo $telephone_number; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Ruolo</b></td>
                                    <td><?php echo $select_role; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Privacy</b></td>
                                    <td><?php echo $policy_acceptance; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Termini</b></td>
                                    <td><?php echo $accet_condizioni; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Newsletter</b></td>
                                    <td><?php echo $ready_to_subs; ?></td>
                                </tr>
                                <?php
                                foreach ($newsletter_results as $single_item) {
                                ?>
                                    <?php
                                    if ($single_item->select_item) {
                                    ?>
                                        <tr>
                                            <td><b>Argomenti Newsletter</b></td>
                                            <td><?php echo $single_item->select_item; ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    if ($single_item->newsletter_mail) {
                                    ?>
                                        <tr>
                                            <td><b>Indirizzo aggiuntivo Newsletter</b></td>
                                            <td><?php echo $single_item->newsletter_mail; ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- total file transfer  -->

    <div class="mt-3 shadow p-3 mb-3 bg-body rounded user-dashboard">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="section-title mt-3 shadow p-3 mb-3 bg-body rounded">
                        <h2>Aggiorna informazioni per ( <?php echo $user_name; ?> )</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3 shadow p-3 mb-3 bg-body rounded">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="regione_list mt-3 shadow-lg p-3 mb-3 bg-body rounded">
                        <div class="pl_registration_form">
                            <?php
                            if (isset($_POST['submit_btn'])) {
                                $email = $_POST['email'] ?? '';
                                $repeat_mail = $_POST['repeat_mail'] ?? '';
                                if ($email == $repeat_mail) {

                                    $user_name          = $_POST['user_name'] ?? '';

                                    $get_results = $wpdb->get_results("SELECT * FROM {$pl_customers_table} WHERE email = '{$email}' ");
                                    $is_user_exist = count($get_results);

                                    $another_u_results = $wpdb->get_row("SELECT * FROM {$pl_customers_table} WHERE email = '{$email}' AND id != $user_id");

                                    $already_used_email = $another_u_results->email ?? '';
                                    
                                    $message = '';
                                    if ($email == $already_used_email) {
                                        $message = '( Non è possibile modificare questa email { ' . $email . ' } perché questa email è già stata utilizzata )';
                                    }

                                    $email              = $_POST['email'] ?? '';
                                    $surname            = $_POST['surname'] ?? '';
                                    $normal_name        = $_POST['normal_name'] ?? '';
                                    $customer_code      = $_POST['customer_code'] ?? '';
                                    $company            = $_POST['company'] ?? '';
                                    $address            = $_POST['address'] ?? '';
                                    $nap                = $_POST['nap'] ?? '';
                                    $city               = $_POST['city'] ?? '';
                                    $select_role        = $_POST['select_role'] ?? '';



                                    $updated_user_email = '';
                                    if ($is_user_exist == 0) {
                                        $updated_user_email = $email;
                                        $wpdb->update(
                                            $pl_customers_table,
                                            array(
                                                'user_name'         => $user_name,
                                                'surname'           => $surname,
                                                'company'           => $company,
                                                'address'           => $address,
                                                'nap'               => $nap,
                                                'city'              => $city,
                                                'email'             => $updated_user_email,
                                                'repeat_mail'       => $updated_user_email,
                                                'telephone_number'  => $telephone_number,
                                                'select_role'       => $select_role,
                                                'normal_name'       => $normal_name,
                                                'customer_code'     => $customer_code,
                                            ),
                                            array('id' => $user_id),
                                        );
                                    } else {

                                        $user_results = $wpdb->get_row("SELECT * FROM {$pl_customers_table} WHERE id = $user_id ");
                                        $exist_user = $user_results->email;
                                        $updated_user_email = $exist_user;

                                        $wpdb->update(
                                            $pl_customers_table,
                                            array(
                                                'user_name'         => $user_name,
                                                'surname'           => $surname,
                                                'company'           => $company,
                                                'address'           => $address,
                                                'nap'               => $nap,
                                                'city'              => $city,
                                                'email'             => $updated_user_email,
                                                'repeat_mail'       => $updated_user_email,
                                                'telephone_number'  => $telephone_number,
                                                'select_role'       => $select_role,
                                                'normal_name'       => $normal_name,
                                                'customer_code'     => $customer_code,
                                            ),
                                            array('id' => $user_id),
                                        );
                                    }


                                    $to_mail  = $email;
                                    $subject  = "Informazioni aggiornate";
                                    $headers  = '';
                                    $headers .= "MIME-Version: 1.0" . "\r\n";
                                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                                    $msg = '';
                                    $msg .= 'Ciao, ' . $user_name . "<br><br>";
                                    $msg .= 'Aggiornate le tue informazioni dall\'amministratore' . "<br><br>";
                                    $msg .= 'Nome utente: ' . $user_name . "<br>";
                                    $msg .= 'Cognome: ' . $surname . "<br>";
                                    $msg .= 'Nome: ' . $normal_name . "<br>";
                                    $msg .= 'Codice CLIENTE: ' . $customer_code . "<br>";
                                    $msg .= 'Azienda: ' . $company . "<br>";
                                    $msg .= 'Indirizzo: ' . $address . "<br>";
                                    $msg .= 'NAP: ' . $nap . "<br>";
                                    $msg .= 'Città: ' . $city . "<br>";
                                    $msg .= 'Email: ' . $updated_user_email . "<br>";
                                    $msg .= 'Ripeti mail: ' . $updated_user_email . "<br><br>";
                                    $msg .= 'Grazie' . "<br>";
                                    wp_mail($to_mail, $subject, $msg, $headers);
                            ?>
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        <strong>Info e mail aggiornate correttamente inviate <span style="color: red"> <?php echo $message; ?> </span></strong>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        <strong>Si prega di inserire lo stesso indirizzo email</strong>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                            <form method="POST" action="">


                                <div class="pl_reg_form_input">
                                    <div class="pl_reg_form_input_left">
                                        <label for="user_name">Nome utente</label>
                                        <input id="user_name" placeholder="Nome utente" type="text" name="user_name" value="<?php echo $user_name; ?>">
                                    </div>
                                    <div class="pl_reg_form_input_right">
                                        <label for="surname">Cognome</label>
                                        <input id="surname" placeholder="Cognome" type="text" name="surname" value="<?php echo $surname; ?>">
                                    </div>
                                </div>
                                <!-- end input  -->
                                <div class="pl_reg_form_input">
                                    <div class="pl_reg_form_input_left">
                                        <label for="normal_name">Nome</label>
                                        <input id="normal_name" placeholder="Nome" type="text" name="normal_name" value="<?php echo $normal_name; ?>">
                                    </div>
                                    <div class="pl_reg_form_input_right">
                                        <label for="customer_code">Codice CLIENTE</label>
                                        <input id="customer_code" placeholder="Codice CLIENTE" type="text" name="customer_code" value="<?php echo $customer_code; ?>">
                                    </div>
                                </div>
                                <!-- end input  -->
                                <div class="pl_reg_form_input">
                                    <div class="pl_reg_form_input_left">
                                        <label for="company">Azienda</label>
                                        <input id="company" placeholder="Azienda" type="text" name="company" value="<?php echo $company; ?>">
                                    </div>
                                    <div class="pl_reg_form_input_right">
                                        <label for="address">Indirizzo</label>
                                        <input id="address" placeholder="Indirizzo" type="text" name="address" value="<?php echo $address; ?>">
                                    </div>
                                </div>
                                <!-- end input  -->
                                <div class="pl_reg_form_input">
                                    <div class="pl_reg_form_input_left">
                                        <label for="nap">NAP</label>
                                        <input id="nap" placeholder="NAP" type="text" name="nap" value="<?php echo $nap; ?>">
                                    </div>
                                    <div class="pl_reg_form_input_right">
                                        <label for="city" for="nap">Città</label>
                                        <input id="city" placeholder="Città" type="text" name="city" value="<?php echo $city; ?>">
                                    </div>
                                </div>
                                <!-- end input  -->
                                <div class="pl_reg_form_input">
                                    <div class="pl_reg_form_input_left">
                                        <label for="email_one" for="nap">Email</label>
                                        <input id="email_one" placeholder="Email" id="email_one" type="text" name="email" value="<?php echo $email; ?>">
                                    </div>
                                    <div class="pl_reg_form_input_right">
                                        <label for="email_two" for="nap">Ripeti Email</label>
                                        <input id="email_two" placeholder="Ripeti password" id="email_two" type="text" name="repeat_mail" value="<?php echo $email; ?>">
                                    </div>
                                </div>
                                <!-- end input  -->
                                <div class="pl_reg_form_input">
                                    <div class="pl_reg_form_input_left">
                                        <label for="telephone_number" for="nap">Telefono</label>
                                        <input id="telephone_number" placeholder="Telefono" type="text" name="telephone_number" value="<?php echo $telephone_number; ?>">
                                    </div>
                                    <div class="pl_reg_form_input_right">
                                        <label for="select_role" for="nap">Ruolo in azienda</label>
                                        <select id="select_role" name="select_role" class="form-select" aria-label="Default select example">
                                            <option selected value="">Ruolo in azienda</option>
                                            <?php update_user_role(); ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- end input  -->
                                <div class="pl_reg_form_input">
                                    <input type="submit" value="Invia" name="submit_btn">
                                </div>
                                <!-- end input  -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- total file transfer  -->

<?php
}

function divi_admin_file_history()
{
    global $wpdb;
    $pl_pdf_files_table             = $wpdb->prefix . 'pl_pdf_files';
    $pl_customers_table             = $wpdb->prefix . 'pl_customers';
    $pl_guoup_table             = $wpdb->prefix . 'pl_guoup';
    $pl_user_files_table             = $wpdb->prefix . 'pl_user_files';
    $pl_user_files_results = $wpdb->get_results("SELECT * FROM {$pl_user_files_table}");
    $pl_pdf_files_results = $wpdb->get_results("SELECT * FROM {$pl_pdf_files_table}");
    $pl_guoup_results = $wpdb->get_results("SELECT * FROM {$pl_guoup_table}");
?>


    <script>
        (function($) {
            $(document).ready(function() {

                var history_table = $('#history_of_sent_files_table').DataTable();

                $("#history_of_sent_files_table_filter.dataTables_filter").append($("#group_filter"));
                var categoryIndex = 0;
                $("#history_of_sent_files_table th").each(function(i) {
                    if ($($(this)).html() == "Gruppo") {
                        categoryIndex = i;
                        return false;
                    }
                });

                //Use the built in datatables API to filter the existing rows by the Category column
                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        var selectedItem = $('#group_filter').val()
                        var category = data[categoryIndex];
                        if (selectedItem === "" || category.includes(selectedItem)) {
                            return true;
                        }
                        return false;
                    }
                );

                $("#group_filter").change(function(e) {
                    history_table.draw();
                });
                history_table.draw();
                // end group filter for admin 

            });
        })(jQuery)
    </script>

    <div class="mt-3 shadow p-3 mb-3 bg-body rounded user-dashboard">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="section-title mt-3 shadow p-3 mb-3 bg-body rounded">
                        <h2>Cronologia dei file inviati</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3 shadow p-3 mb-3 bg-body rounded">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="regione_list mt-3 shadow-lg p-3 mb-3 bg-body rounded">
                        <select name="" id="group_filter">
                            <option value="">Mostra tutto</option>
                            <?php
                            foreach ($pl_guoup_results as $single_grp_name) {
                            ?>
                                <option value="<?php echo $single_grp_name->group_name; ?>"><?php echo $single_grp_name->group_name; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <table id="history_of_sent_files_table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nome utente</th>
                                    <th>Nome del file</th>
                                    <th>Download file</th>
                                    <th>Dati</th>
                                    <th>Gruppo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($pl_pdf_files_results as $single_sent_pdf) {
                                    $file_url = $single_sent_pdf->pdf_url ?? '';
                                    $re_file_name = end(explode("/", $file_url));

                                    $user_id = $single_sent_pdf->user_id ?? '';

                                    $user_result = $wpdb->get_row("SELECT * FROM {$pl_customers_table} WHERE id={$user_id}");
                                    $get_user_name = $user_result->user_name;
                                    $pdf_group = $single_sent_pdf->pdf_group ?? '';

                                    $created_at = $single_sent_pdf->created_at;
                                    $time_input = strtotime($created_at);
                                    $date_input = getDate($time_input);

                                    $serial_of_date = $date_input['mday'] . ' ' . $date_input['month'] . ', ' . $date_input['year'];
                                ?>
                                    <tr>
                                        <td><?php echo ucwords($get_user_name); ?></td>
                                        <td><?php echo $re_file_name; ?></td>
                                        <td><a class="btn btn-info" href="<?php echo $file_url; ?>" download>Download file</a></td>
                                        <td><?php echo $serial_of_date; ?></td>
                                        <td><?php echo $pdf_group; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- history of receive files  -->
    <div class="mt-3 shadow p-3 mb-3 bg-body rounded user-dashboard">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="section-title mt-3 shadow p-3 mb-3 bg-body rounded">
                        <h2>Cronologia dei file ricevuti</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3 shadow p-3 mb-3 bg-body rounded">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="regione_list mt-3 shadow-lg p-3 mb-3 bg-body rounded">
                        <table id="history_of_received_files_table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nome utente</th>
                                    <th>Nome del file</th>
                                    <th>Download file</th>
                                    <th>Dati</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($pl_user_files_results as $single_ufile) {


                                    $u_user_name = $single_ufile->user_name;

                                    $u_file_url = $single_ufile->file_url ?? '';
                                    $u_file_name = end(explode("/", $u_file_url));


                                    $ucreated_at = $single_ufile->created_at;
                                    $utime_input = strtotime($ucreated_at);
                                    $udate_input = getDate($utime_input);

                                    $userial_of_date = $udate_input['mday'] . ' ' . $udate_input['month'] . ', ' . $udate_input['year'];

                                ?>
                                    <tr>
                                        <td><?php echo ucwords($u_user_name); ?></td>
                                        <td><?php echo $u_file_name; ?></td>
                                        <td><a class="btn btn-info" href="<?php echo $u_file_url; ?>" download>Download file</a></td>
                                        <td><?php echo $userial_of_date; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
