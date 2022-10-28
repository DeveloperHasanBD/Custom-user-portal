<?php
require_once get_theme_file_path('/inc/users/common/common-work.php');

/**
 * Template name: User file management
 */
get_header();
?>
<div class="pl_customer_menu_section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="user_dashboard">
                    <div class="pl_dashboard_menu">
                        <?php
                        require_once get_theme_file_path('/inc/users/common/menu.php');
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pl_customer_file_section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="user-dashboard">
                    
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <?php

                            define('DIVI_USER_FOLDER_PATH', plugin_dir_path(__FILE__));
                            if (isset($_POST['submit_file'])) {

                                $site_url = site_url();

                                $file_name = $_FILES['file_send']['name'];
                                $file_type = $_FILES['file_send']['type'];
                                $tmp_name = $_FILES['file_send']['tmp_name'];


                                $allowed_file_type = ['pdf', 'png', 'jpg'];
                                $file_ex = explode('.', $file_name);
                                $file_format = end($file_ex);

                                if ($file_name) {
                                    if (in_array($file_format, $allowed_file_type)) {
                                        $unique_file_name =  rand(1111,  9999) . time() . '-' . $file_name;

                                        move_uploaded_file($tmp_name, DIVI_USER_FOLDER_PATH . "inc/users/files/" . $unique_file_name);

                                        $file_url = $site_url . '/wp-content/themes/Divichild/inc/users/files/' . $unique_file_name;

                                        global $wpdb;
                                        $pl_user_files_table     = $wpdb->prefix . 'pl_user_files';


                                        $wpdb->insert(
                                            $pl_user_files_table,
                                            array(
                                                'user_id'   => $user_id,
                                                'user_name' => $user_name,
                                                'file_url'  => $file_url,
                                            ),
                                        );

                                        $admin_email_address = get_field('admn_admin_email', 'option');
                                        $to_mail  = $admin_email_address;

                                        $subject  = "File ricevuto";

                                        $headers  = '';
                                        //                                         $headers .= "From: File ricevuto <noreply@polielectra.ch> \r\n";
                                        $headers .= "MIME-Version: 1.0" . "\r\n";
                                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                        $admin_url = site_url() . "/wp-admin";

                                        $msg = '';
                                        $msg .= 'Ciao,' . "<br><br>";
                                        $msg .= 'L\'utente ' . $user_name . ' ' . $surname . " ti ha inviato un file in area riservata. Accedi per visualizzare il documento.<br><br>";
                                        $msg .= '<a style="display: block; padding: 10px 30px; width: 160px; background: #f68b2e; text-align: center; text-decoration: nono; color: #fff; font-weight: 600" href="' . $admin_url . '">' . 'Vai alla Dashboard' . '</a>' . "<br><br>";
                                        $msg .= 'Grazie' . "<br>";
                                        wp_mail($to_mail, $subject, $msg, $headers);
                                    }
                            ?>

                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>File inviato all'amministratore correttamente</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>File obbligatorio</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                            <?php
                                }
                            }


                            ?>
                            <!-- <div class="user_dashboard">
                                <div class="file_heading_text">
                                    <h2>Si accettano file PDF o immagini</h2>
                                </div>
                                <div class="file_send_form">
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="input_box_dgn">
                                            <label for="files" class="btn form-control">Carica file</label>
                                            <input type="submit" name="submit_file" value="Invia file">
                                        </div>
                                        <div class="input_hidden_box_dgn" style="visibility: hidden; height: 0;">
                                            <input required id="files" name="file_send" type="file">
                                        </div>
                                    </form>
                                </div>
                            </div> -->
                            <!-- <div class="user_dashboard">
                                <div class="user_section_title">
                                    <h2>File inviati</h2>
                                </div>
                                <br>
                                <br>
                                <table id="send_file_table" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#NO</th>
                                            <th>File</th>
                                            <th>Nome del file</th>
                                            <th>Data</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $pl_user_files_table             = $wpdb->prefix . 'pl_user_files';
                                        $send_file_results = $wpdb->get_results("SELECT * FROM {$pl_user_files_table} WHERE user_id = $user_id ");

                                        $i = 1;
                                        foreach ($send_file_results as $snd_single_file) {
                                            $final_incr = $i++;
                                            $file_url = $snd_single_file->file_url;
                                            $snd_file_name = end(explode("/", $file_url));
                                            $created_at = $snd_single_file->created_at;
                                            $time_input = strtotime($created_at);
                                            $date_input = getDate($time_input);
                                            $serial_of_date = $date_input['mday'] . ' ' . $date_input['month'] . ', ' . $date_input['year'];



                                        ?>
                                            <tr>
                                                <td><b><?php echo $final_incr; ?></b></td>
                                                <td><a target="_blank" class="btn btn-primary" href="<?php echo $file_url; ?>">Visualizza file</a></td>
                                                <td><?php echo $snd_file_name; ?></td>
                                                <td><?php echo $serial_of_date; ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>

                                    </tbody>
                                </table>

                            </div> -->

                            <div class="user_dashboard">
                                <div class="user_section_title">
                                    <h2>Archivio File</h2>
                                </div>
                                <br>
                                <br>
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
                                <table id="receive_file_table" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#NO</th>
                                            <th>File</th>
                                            <th>Nome del file</th>
                                            <th>Data</th>
                                            <th>Gruppo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $pl_pdf_files_table             = $wpdb->prefix . 'pl_pdf_files';
                                        $file_results = $wpdb->get_results("SELECT * FROM {$pl_pdf_files_table} WHERE user_id = $user_id ");

                                        $i = 1;
                                        foreach ($file_results as $single_file) {
                                            $final_incr = $i++;
                                            $pdf_url = $single_file->pdf_url;
                                            $pdf_group = $single_file->pdf_group;
                                            $rcvd_file_name = end(explode("/", $pdf_url));

                                            $created_at = $single_file->created_at;
                                            $time_input = strtotime($created_at);
                                            $date_input = getDate($time_input);
                                            $serial_of_date = $date_input['mday'] . ' ' . $date_input['month'] . ', ' . $date_input['year'];



                                        ?>
                                            <tr>
                                                <td><b><?php echo $final_incr; ?></b></td>
                                                <td><a target="_blank" class="btn btn-primary" href="<?php echo $pdf_url; ?>">Visualizza file</a></td>
                                                <td><?php echo $rcvd_file_name; ?></td>
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
        </div>
    </div>
</div>

<?php
get_footer();
?>