<?php
require_once get_theme_file_path('/inc/users/common/common-work.php');
function update_role()
{
    global $wpdb;
    $user_id = $_SESSION['user_id'] ?? '';
    $pl_customers_table             = $wpdb->prefix . 'pl_customers';
    $get_results = $wpdb->get_row("SELECT * FROM {$pl_customers_table} WHERE id = $user_id ");
    $select_role = $get_results->select_role;

    $user_roles = ['Titolare', 'Dirigente', 'Quadro', 'Responsabile acquisti', 'Responsabile commerciale', 'Libero professionista', 'Operatore specializzato'];

    $html = '';
    foreach ($user_roles as $single_role) {
        $seleced = '';
        if ($select_role == $single_role) {
            $seleced = 'selected';
        }
        $html .= '<option ' . $seleced . ' value"' . $single_role . '">' . $single_role . '</option>';
    }
    echo $html;
}

/**
 * Template name: Customer portal
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
                            <div class="user_dashboard">
                                <div class="user_section_title">
                                    <h2>Aggiorna i dati del profilo</h2>
                                </div>
                            </div>
                            <div class="user_dashboard">
                                <?php
                                if (isset($_POST['update_dbtn'])) {
                                    $surname            = $_POST['surname'] ?? '';
                                    $company            = $_POST['company'] ?? '';
                                    $normal_name        = $_POST['normal_name'] ?? '';
                                    $customer_code      = $_POST['customer_code'] ?? '';
                                    $address            = $_POST['address'] ?? '';
                                    $nap                = $_POST['nap'] ?? '';
                                    $city               = $_POST['city'] ?? '';
                                    $email              = $_POST['email'] ?? '';
                                    $telephone_number   = $_POST['telephone_number'] ?? '';
                                    $select_role        = $_POST['select_role'] ?? '';

                                    $wpdb->update(
                                        $pl_customers_table,
                                        array(
                                            'surname'           => $surname,
                                            'company'           => $company,
                                            'normal_name'       => $normal_name,
                                            'customer_code'     => $customer_code,
                                            'address'           => $address,
                                            'nap'               => $nap,
                                            'city'              => $city,
                                            'email'             => $email,
                                            'telephone_number'  => $telephone_number,
                                            'select_role'       => $select_role,
                                        ),
                                        array('id' => $user_id),
                                    );

                                ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        I dati sono stati aggiornati correttamente.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>

                                <?php
                                }


                                ?>
                                <form action="" method="POST">
                                    <div class="user_data_input_main_box">
                                        <div class="user_data_input_box">
                                            <label for="">Nome utente</label>
                                            <input class="form-control" type="text" readonly value="<?php echo $get_results->user_name; ?>">
                                            <label for="">Cognome</label>
                                            <input name="surname" value="<?php echo $get_results->surname; ?>" class="form-control" type="text">
                                            <label for="">Nome</label>
                                            <input name="normal_name" value="<?php echo $get_results->normal_name; ?>" class="form-control" type="text">
                                            <label for="">Codice CLIENTE</label>
                                            <input name="customer_code" value="<?php echo $get_results->customer_code; ?>" class="form-control" type="text">
                                            <label for="">Azienda</label>
                                            <input name="company" value="<?php echo $get_results->company; ?>" class="form-control" type="text">
                                            <label for="">Indirizzo</label>
                                            <input name="address" value="<?php echo $get_results->address; ?>" class="form-control" type="text">
                                            <label for="">Nap</label>
                                            <input name="nap" value="<?php echo $get_results->nap; ?>" class="form-control" type="text">
                                            <label for="">Città</label>
                                            <input name="city" value="<?php echo $get_results->city; ?>" class="form-control" type="text">
                                            <label for="">Email</label>
                                            <input name="email" value="<?php echo $get_results->email; ?>" class="form-control" type="text">
                                            <label for="">Telefono</label>
                                            <input name="telephone_number" value="<?php echo $get_results->telephone_number; ?>" class="form-control" type="text">
                                            <label for="">Ruolo in azienda</label>
                                            <select name="select_role" class="form-select form-control" aria-label="Default select example">
                                                <?php update_role(); ?>
                                            </select>
                                        </div>
                                        <input type="submit" value="Aggiorna i dati" name="update_dbtn">
                                    </div>
                                </form>
                            </div>
                            <!-- end pass update  -->
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