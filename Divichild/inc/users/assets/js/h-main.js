(function ($) {
    $(document).ready(function () {

        // start pl_user_registration_form

        $("#pl_user_registration_form").validate({
            rules: {
                user_name: {
                    required: true
                },
                already_client: {
                    required: true,
                },
                company: {
                    required: true,
                },
                normal_name: {
                    required: true,
                },
                customer_code: {
                    required: true,
                    number: true,
                    rangelength: [5, 5]
                },
                address: {
                    required: true,
                },
                telephone_number: {
                    required: true,
                    number: true
                },
                email: {
                    required: true,
                    email: true,
                },
                repeat_mail: {
                    required: true,
                    email: true,
                },
                set_password: {
                    required: true,
                },
                repeat_password: {
                    required: true,
                },
                select_role: {
                    required: true,
                },
                policy_acceptance: {
                    required: true,
                },
                accet_condizioni: {
                    required: true,
                },
            },
            submitHandler: function () {
                var url = action_url_ajax.ajax_url;
                var form = $("#pl_user_registration_form");
                $.ajax({
                    url: url,
                    data: form.serialize() + '&action=' + 'pl_user_registration_form_action' + '&param=' + 'form_data',
                    type: 'post',
                    success: function (data) {
                        $("#pl_user_registration_form_message").html(data);
                    }
                });
                document.getElementById('pl_user_registration_form').reset();
            }

        });

        // start pl_user_login_form

        $("#pl_user_login_form").validate({
            rules: {
                user_name: {
                    required: true,
					email: true,
                },
                user_pass: {
                    required: true,
                },
            },
            submitHandler: function () {
                var url = action_url_ajax.ajax_url;
                var form = $("#pl_user_login_form");
                $.ajax({
                    url: url,
                    data: form.serialize() + '&action=' + 'pl_user_login_form_action' + '&param=' + 'form_data',
                    type: 'post',
                    success: function (data) {
                        $("#pl_user_login_form_message").html(data);
                    }
                });
                document.getElementById('pl_user_login_form').reset();
            }

        });

        // start slider 

        $("#pl_user_pass_recovery_form").validate({
            rules: {
                user_email: {
                    required: true,
					email: true,
                },
            },
            submitHandler: function () {
                var url = action_url_ajax.ajax_url;
                var form = $("#pl_user_pass_recovery_form");
                $.ajax({
                    url: url,
                    data: form.serialize() + '&action=' + 'pl_user_pass_recovery_form_action' + '&param=' + 'form_data',
                    type: 'post',
                    success: function (data) {
                        $("#pl_user_pass_recovery_form_message").html(data);
                    }
                });
                document.getElementById('pl_user_pass_recovery_form').reset();
            }

        });

        // start slider 

        $("#already_client").on('change', function () {
            var get_val = $(this).val();
            if (get_val == 'Sì') {
                $(".pl_input_right_innr_btm").css({ 'display': 'block' });
            } else {
                $(".pl_input_right_innr_btm").css({ 'display': 'none' });
            }
        });



        var receive_file_table = $('#receive_file_table').DataTable();

        $("#receive_file_table_filter.dataTables_filter").append($("#group_filter"));
        var categoryIndex = 0;
        $("#receive_file_table th").each(function (i) {
            if ($($(this)).html() == "Gruppo") {
                categoryIndex = i; return false;
            }
        });

        //Use the built in datatables API to filter the existing rows by the Category column
        $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex) {
                var selectedItem = $('#group_filter').val()
                var category = data[categoryIndex];
                if (selectedItem === "" || category.includes(selectedItem)) {
                    return true;
                }
                return false;
            }
        );

        $("#group_filter").change(function (e) {
            receive_file_table.draw();
        });
        receive_file_table.draw();
        // end group filter for admin 


        $('#send_file_table').DataTable();

        $("a#send_file_table_previous").html('Precedente');
        $("a#send_file_table_next").html('Avanti');


        $("a#receive_file_table_previous").html('Precedente');
        $("a#receive_file_table_next").html('Avanti');
        $("td.dataTables_empty").html('Nessun dato disponibile nella tabella');

        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        $(".pl_login_icon").on('click', function () {
            $(".pl_header_menu_form").slideToggle();
        });

        var logged_in_user_name = localStorage.getItem('user_name');
        if (logged_in_user_name) {
            $(".pl_login_icon span").html(logged_in_user_name);
        }

    });
})(jQuery)


