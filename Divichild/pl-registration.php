<?php

/**
 * Template name: Registration
 */
get_header();
?>

<form id="pl_user_registration_form" action="">
    <div class="pl_registration_form">
        <div class="container">
            <div class="row">
                <div class="col-12">

                    <div id="pl_user_registration_form_message"></div>
                    <div class="pl_reg_form_innr">
                        <div class="registration_top_logo">
                            <div class="logo_box">
                                <input type="hidden" name="admin_mail_address" value="<?php echo get_field('admn_admin_email', 'option') ?>">
                                <?php
                                $userc_logo_setup = get_field('userc_logo_setup', 'option');
                                ?>
                                <a href="<?php echo  site_url(); ?>"><img src="<?php echo $userc_logo_setup; ?>" alt=""></a>
                            </div>
                        </div>
                        <!-- start new form design  -->
                        <div class="row input_field_two_col">
                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <div class="pl_reg_form_main_input_leff">
                                    <div class="pl_reg_form_input_left">
                                        <input type="text" name="user_name" placeholder="Nome utente">
                                    </div>
                                    <div class="pl_reg_form_input_left">
                                        <input type="text" name="normal_name" placeholder="Nome">
                                    </div>
                                    <div class="pl_reg_form_input_left">
                                        <input id="email_one" type="text" name="email" placeholder="Email">
                                    </div>
                                    <div class="pl_reg_form_input_left">
                                        <input id="email_two" type="text" name="repeat_mail" placeholder="Ripeti mail">
                                    </div>
                                    <div class="pl_reg_form_input_left">
                                        <input id="password_one" type="password" name="set_password" placeholder="Imposta password">

                                    </div>
                                    <div class="pl_reg_form_input_left">
                                        <input id="password_two" type="password" name="repeat_password" placeholder="Ripeti password">
                                    </div>
                                    <div class="pl_reg_form_input_left">
                                        <input type="text" name="telephone_number" placeholder="Telefono">
                                    </div>
                                    <div class="pl_reg_form_input_left hide_for_mobile_vw">
                                        <div class="pl_reg_form_input_left_innr">
                                            <input id="policy_acceptance" type="checkbox" name="policy_acceptance" value="Sì">
                                            <label for="policy_acceptance">Ho letto e accetto la <a target="_blank" href="<?php echo site_url(); ?>/privacy-policy/">privacy policy</a></label>
                                        </div>
                                    </div>
                                    <div class="pl_reg_form_input_left hide_for_mobile_vw">
                                        <p>
                                            <span>Sei già cliente ?</span> <a href="<?php echo site_url() . '/login' ?>">Accedi</a>
                                        </p>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <div class="pl_reg_form_main_input_right">
                                    <div class="pl_reg_form_input_right">
                                        <input type="text" name="surname" placeholder="Cognome">
                                    </div>
                                    <div class="pl_reg_form_input_right_innr">
                                        <div class="pl_input_right_innr_tp">
                                            <select name="already_client" id="already_client" class="form-select" aria-label="Default select example">
                                                <option selected disable value="">Se già cliente Polielectra?</option>
                                                <option value="Sì">Sì</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                        <div class="pl_input_right_innr_btm">
                                            <div class="eye_info">
                                                <span>i</span>
                                                <div class="eye_info_innr">
                                                    <p>Puoi trovare il tuo codice cliente nelle fatture di Polielectra o puoi richiederlo contattandoci per e-mail o telefonicamente</p>
                                                </div>
                                            </div>
                                            <input type="text" name="customer_code" placeholder="Codice CLIENTE">
                                        </div>
                                    </div>
                                    <div class="pl_reg_form_input_right">
                                        <input type="text" name="company" placeholder="Azienda">
                                    </div>
                                    <div class="pl_reg_form_input_right">
                                        <input type="text" name="address" placeholder="Indirizzo">
                                    </div>
                                    <div class="pl_reg_form_input_right">
                                        <input type="text" name="nap" placeholder="NAP">
                                    </div>
                                    <div class="pl_reg_form_input_right">
                                        <input type="text" name="city" placeholder="Città">
                                    </div>
                                    <div class="pl_reg_form_input_right">
                                        <select name="select_role" class="form-select" aria-label="Default select example">
                                            <option selected value="">Ruolo in azienda</option>
                                            <option value="Titolare">Titolare </option>
                                            <option value="Dirigente">Dirigente</option>
                                            <option value="Quadro">Quadro</option>
                                            <option value="Responsabile acquisti">Responsabile acquisti</option>
                                            <option value="Responsabile commerciale">Responsabile commerciale</option>
                                            <option value="Libero professionista">Libero professionista</option>
                                            <option value="Operatore specializzato">Operatore specializzato</option>
                                        </select>

                                    </div>
                                    <div class="pl_reg_form_input_right input_check_box">
                                        <input id="accet_condizioni" type="checkbox" name="accet_condizioni" value="Sì">
                                        <label for="accet_condizioni">Accetto le condizioni <a target="_blank" href="<?php echo site_url(); ?>/condizioni-generali/">generali di fornitura</a></label>
                                    </div>

                                    <div class="pl_reg_form_input_left show_for_mobile_vw">
                                        <div class="pl_reg_form_input_left_innr">
                                            <input id="policy_acceptance" type="checkbox" name="policy_acceptance" value="Sì">
                                            <label for="policy_acceptance">Ho letto e accetto la <a target="_blank" href="<?php echo site_url(); ?>/privacy-policy/">privacy policy</a></label>
                                        </div>
                                    </div>
                                    <div class="pl_reg_form_input_left show_for_mobile_vw">
                                        <p>
                                            <span>Sei già cliente ?</span> <a href="<?php echo site_url() . '/login' ?>">Accedi</a>
                                        </p>
                                    </div>

                                    <div class="pl_reg_form_input_right">
                                        <input type="submit" value="Invia" name="submit_btn">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- start new form design  -->





                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php
get_footer();
