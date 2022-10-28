(function ($) {
    $(document).ready(function () {
        $('#history_of_sent_files_table').DataTable();
        $('#history_of_received_files_table').DataTable();
        $('#ind_send_file_table').DataTable();
        $('#pending_customers_table').DataTable();
        $('#active_customers_table').DataTable();
        $('#group_names_table').DataTable();
        $("td.dataTables_empty").html('Nessun dato disponibile nella tabella');
        $("a#pending_customers_table_previous").html('Precedente');
        $("a#pending_customers_table_next").html('Avanti');


        // end group filter for admin 

        // start visible_activation_form
        $(".check_delete").on('click', function (e) {
            $(this).css({ "display": "none" });
            $(this).next().css({ "display": "block" });
        });

        // start visible_activation_form
        $(".confirm_delete_user").on('click', function (e) {
            var user_id = $(this).attr('user_id');
            $(this).parent().parent().parent().parent().parent().parent().css({ "display": "none" });
            var url = action_url_ajax.ajax_url;
            $.ajax({
                url: url,
                data: {
                    action: 'confirm_delete_user_action',
                    user_id: user_id,
                },
                type: 'post',
                success: function (data) {
                    alert('Successfully data deleted');
                },
            });
        });

        // start visible_activation_form
        $(".check_delete_group").on('click', function (e) {
            $(this).css({ "display": "none" });
            $(this).next().css({ "display": "block" });
        });

        // start visible_activation_form
        $(".confirm_delete_group").on('click', function (e) {
            var group_id = $(this).attr('group_id');
            $(this).parent().parent().parent().parent().parent().css({ "display": "none" });
            var url = action_url_ajax.ajax_url;
            $.ajax({
                url: url,
                data: {
                    action: 'confirm_delete_group_action',
                    group_id: group_id,
                },
                type: 'post',
                success: function (data) {
                    alert('Successfully data deleted');
                },
            });
        });

        // start visible_activation_form
        $(".check_delete_group_single").on('click', function (e) {
            $(this).css({ "display": "none" });
            $(this).next().css({ "display": "block" });
        });

        // start visible_activation_form
        $(".confirm_delete_user_from_group").on('click', function (e) {
            var g_user_id = $(this).attr('g_user_id');
            $(this).parent().parent().parent().parent().css({ "display": "none" });
            var url = action_url_ajax.ajax_url;
            $.ajax({
                url: url,
                data: {
                    action: 'confirm_delete_user_from_group_action',
                    g_user_id: g_user_id,
                },
                type: 'post',
                success: function (data) {
                    alert('Successfully data deleted');
                },
            });
        });



        // start visible_activation_form
        $(".visible_activation_form").on('click', function (e) {
            var user_id = $(this).attr('user_id');
            var url = action_url_ajax.ajax_url;
            $.ajax({
                url: url,
                data: {
                    action: 'visible_activation_form_action',
                    user_id: user_id,
                },
                type: 'post',
                success: function (data) {
                    $(".visible_activation_form_message_" + user_id).html(data);
                    $(".running_btn_" + user_id).css({ 'display': 'none' });
                },
            });
        });


        // start mail form  
        $(".visible_activation_form").validate({
            rules: {
                user_id: {
                    required: true,
                },
                activate_url: {
                    required: true
                },
            },
            submitHandler: function () {
                var url = action_url_ajax.ajax_url;
                var form = $(".visible_activation_form");
                $.ajax({
                    url: url,
                    data: form.serialize() + '&action=' + 'visible_activation_form_action' + '&param=' + 'form_data',
                    type: 'post',
                    success: function (data) {
                        $(".visible_activation_form_message").html(data);
                    }
                });
                // document.getElementById('update_user_email_pass_form').reset();
            }
        });

        // start mail form  
        $("#send_file_ind_all_form").validate({
            rules: {
                send_file_to: {
                    required: true,
                },
                // select_u_group: {
                //     required: true,
                // },
            },
            submitHandler: function () {
                var url = action_url_ajax.ajax_url;
                var form = $("#send_file_ind_all_form");
                $.ajax({
                    url: url,
                    data: form.serialize() + '&action=' + 'send_file_ind_all_form_action' + '&param=' + 'form_data',
                    type: 'post',
                    success: function (data) {
                        $("#send_file_ind_all_form_message").html(data);
                    }
                });
                // document.getElementById('send_file_ind_all_form').reset();
            }
        });


        $(".upload_pdf_file").on("click", function () {
            let row_id = $(this).attr('row_id');
            let seteml_address = $(this).attr('seteml_address');
            var ad_image = wp.media({
                title: "Upload file",
                multiple: false,
            }).open().on("select", function () {
                var uploaded_image = ad_image.state().get("selection").first();
                var get_image_url = uploaded_image.toJSON().url;
                $("#show_file_url").html(get_image_url);
                $("#set_file_url").val(get_image_url);
            });
        });

        $(".ind_upload_pdf_file").on("click", function () {
            var ad_image = wp.media({
                title: "Upload file",
                multiple: false,
            }).open().on("select", function () {
                var uploaded_image = ad_image.state().get("selection").first();
                var get_image_url = uploaded_image.toJSON().url;
                $("#show_file_url_inda").html(get_image_url);
                $("#set_file_url_inda").val(get_image_url);
            });
        });


        // start admin_send_file
        // start visible_activation_form
        $(".admin_send_file").on('click', function (e) {
            var get_user_id = $(this).attr('get_user_id');
            var set_pdf_url = $(this).attr('set_pdf_url');
            var get_admin_id = $(this).attr('get_admin_id');

            var url = action_url_ajax.ajax_url;
            $.ajax({
                url: url,
                data: {
                    action: 'admin_send_file_action',
                    get_user_id: get_user_id,
                    set_pdf_url: set_pdf_url,
                    get_admin_id: get_admin_id,
                },
                type: 'post',
                success: function (data) {
                    $(".admin_send_file_action_message_" + get_user_id).html(data);
                },
            });
        });


        // group file processing
        $(".set_group_name").on('click', function (e) {
            var get_user_id = $(this).attr('set_row_id');
            var get_the_group_name = $("#get_the_group_name_" + get_user_id).val();

            if ($(this).prop('checked') != true) {
                $(this).val('');
            } else {
                $(this).val(get_the_group_name);
            }
        });

        $(".get_ind_email").on('click', function (e) {
            var get_row_id = $(this).attr('get_row_id');
            var ind_hidden_email = $("#ind_hidden_email_" + get_row_id).val();
            var get_selected_id = $("#get_selected_id_" + get_row_id).val();
            if ($(this).prop('checked') != true) {
                $(this).val('');
                $("#set_selected_id_" + get_row_id).val('');
            } else {
                $(this).val(ind_hidden_email);
                $("#set_selected_id_" + get_row_id).val(get_selected_id);
            }
        });


        // bulk file send 

        // $(".checkbox_row").on('click', function () {

        //     var check_row_id = $(this).attr('check_row_id');
        //     if ($(this).prop('checked') != true) {
        //         $(this).val('');
        //     } else {
        //         var show_user_id = $("#show_user_id_" + check_row_id).html();
        //         if (show_user_id) {
        //             var set_checked_user_id = $("#set_checked_user_id_" + check_row_id);
        //             set_checked_user_id.val(show_user_id);
        //         } else {
        //             $(this).prop('checked', false);
        //         }

        //     }

        // });
        $(".add_user_to_group").on('change', function () {
            var group_row_id = $(this).attr('group_row_id');
            var group_name = $(this).val();
            var user_id = $("#user_id_" + group_row_id).val();
            var user_email = $("#user_email_" + group_row_id).val();
            var url = action_url_ajax.ajax_url;
            $.ajax({
                url: url,
                data: {
                    action: 'add_user_to_group_action',
                    group_name: group_name,
                    user_id: user_id,
                    user_email: user_email,
                },
                type: 'post',
                success: function (data) {
                    $(".add_user_to_group_action_message_" + group_row_id).html(data);
                },
            });

        });


        // start mail form  
        $("#bulk_file_send_form").validate({
            submitHandler: function () {
                var url = action_url_ajax.ajax_url;
                var form = $("#bulk_file_send_form");
                $.ajax({
                    url: url,
                    data: form.serialize() + '&action=' + 'bulk_file_send_form_action' + '&param=' + 'form_data',
                    type: 'post',
                    success: function (data) {
                        $("#bulk_file_send_form_message").html(data);
                    }
                });
            }

        });
        // start group creation form  
        $("#group_creation_form").validate({
            rules: {
                group_name: {
                    required: true,
                },
            },
            submitHandler: function () {
                var url = action_url_ajax.ajax_url;
                var form = $("#group_creation_form");
                $.ajax({
                    url: url,
                    data: form.serialize() + '&action=' + 'group_creation_form_action' + '&param=' + 'form_data',
                    type: 'post',
                    success: function (data) {
                        $("#group_creation_form_message").html(data);
                    }
                });
                document.getElementById('group_creation_form').reset();

            }

        });

        // user group file processing 

        // start mail form  
        $("#user_group_file_process_form").validate({
            submitHandler: function () {
                var url = action_url_ajax.ajax_url;
                var form = $("#user_group_file_process_form");
                $.ajax({
                    url: url,
                    data: form.serialize() + '&action=' + 'user_group_file_process_form_action' + '&param=' + 'form_data',
                    type: 'post',
                    success: function (data) {
                        $("#user_group_file_process_form_message").html(data);
                    }
                });
                // document.getElementById('update_user_email_pass_form').reset();
            }
        });


    });
})(jQuery)
