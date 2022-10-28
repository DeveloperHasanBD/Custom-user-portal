(function ($) {
    $(document).ready(function () {

        // start octgn_common_form form  
        $("#form_submit").validate({
            rules: {
                username: {
                    required: true
                },
                // telefono: {
                //     required: true,
                //     number: true
                // },
                // email: {
                //     required: true,
                //     email: true,
                // },
            },
            submitHandler: function () {
                var url = action_url_ajax.ajax_url;
                var form = $("#form_submit");
                $.ajax({
                    url: url,
                    data: form.serialize() + '&action=' + 'form_submit_form_action' + '&param=' + 'mail_form_data',
                    type: 'post',
                    success: function (data) {
                        $("#form_submit_form_message").html(data);
                    }
                });
            }

        });


    });
})(jQuery)


