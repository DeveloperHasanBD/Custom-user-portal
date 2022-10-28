<?php
require_once get_theme_file_path('/inc/users/common/common-work.php');
function update_newsletter()
{
    global $wpdb;
    $user_id = $_SESSION['user_id'] ?? '';
    $pl_newsletter_table             = $wpdb->prefix . 'pl_newsletter';

    $get_nwsl_results = $wpdb->get_results("SELECT * FROM {$pl_newsletter_table} WHERE id = $user_id ");
    $select_role = $get_nwsl_results->select_role;

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

function update_receive_newsletter()
{

    global $wpdb;
    $pl_newsletter_table = $wpdb->prefix . 'pl_newsletter';
    $user_id = $_SESSION['user_id'] ?? '';
    $newsletter_results = $wpdb->get_row("SELECT * FROM {$pl_newsletter_table} WHERE user_id = $user_id ");
    $ready_to_subs = $newsletter_results->ready_to_subs;
    $receive_newsl = ['Sì', 'No'];

    $html = '';
    foreach ($receive_newsl as $single_yes_no) {
        $seleced = '';
        if ($ready_to_subs == $single_yes_no) {
            $seleced = 'selected';
        }
        $html .= '<option ' . $seleced . ' value"' . $single_yes_no . '">' . $single_yes_no . '</option>';
    }
    echo $html;
}


/**
 * Template name: Newsletter
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
                                    <h2>Newsletter info</h2>
                                </div>
                            </div>
                            <div class="user_dashboard">
                                <?php

                                if (isset($_POST['update_nlinfo'])) {
                                    $ready_to_subs = $_POST['ready_to_subs'];
                                    $update_data = $_POST['items'];
                                    $total_update_items = count($_POST['items']);
                                    for ($i = 0; $i < $total_update_items; $i++) {
                                        $wpdb->update(
                                            $pl_newsletter_table,
                                            array(
                                                'ready_to_subs'     => $ready_to_subs,
                                                'select_item'       => $update_data[$i]['select_item'],
                                            ),
                                            array('id' => $update_data[$i]['id']),
                                        );
                                    }
                                ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        I dati sono stati aggiornati correttamente.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php
                                }
                                ?>
                                <form id="update_user_newsletter_info" action="" method="POST">
                                    <div class="user_data_input_main_box">
                                        <div class="user_data_input_box">
                                            <label for="">Ricezione newsletter</label>
                                            <select name="ready_to_subs" class="form-select form-control" aria-label="Default select example">
                                                <?php update_receive_newsletter(); ?>
                                            </select>
                                            <?php
                                            foreach ($newsletter_results as $key => $single_update_val) {
                                            ?>
                                                <label for="">Argomenti Newsletter</label>
                                                <select name="items[<?php echo $key ?>][select_item]" class="form-select form-control" aria-label="Default select example">
                                                    <option value="">Inserisci temi d’interesse </option>
                                                    <option <?php echo ($single_update_val->select_item == 'tutto') ? 'selected' : '' ?> value="tutto">Tutto</option>
                                                    <option <?php echo ($single_update_val->select_item == 'azioni') ? 'selected' : '' ?> value="azioni">Azioni</option>
                                                    <option <?php echo ($single_update_val->select_item == 'novità') ? 'selected' : '' ?> value="novità">Novità </option>
                                                    <option <?php echo ($single_update_val->select_item == 'comunicazioni') ? 'selected' : '' ?> value="comunicazioni">Comunicazioni</option>
                                                    <option <?php echo ($single_update_val->select_item == 'corsi') ? 'selected' : '' ?> value="corsi">Corsi </option>
                                                </select>
                                                <input type="hidden" name="items[<?php echo $key ?>][id]" value="<?php echo $single_update_val->id ?>" />
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <input type="submit" value="Aggiorna i dati" name="update_nlinfo">
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>