$(document).ready(function() {
    $('.input--password').each(function () {
        toggleIconPassword($(this));
    });

    $('.input--password').keyup(function () {
        $(this).prev().html("");
        toggleIconPassword($(this));
    })

    $('.show__password').click(function () {
        togglePassword($(this), "show");
    })

    $('.hide__password').click(function () {
        togglePassword($(this), "hide");
    })

    function toggleIconPassword(el) {
        if (el.val()) {
            el.next().removeClass('d-none');
        } else {
            el.attr("type", "password");
            el.next().addClass('d-none');
            el.next().next().addClass('d-none');
        }
    }

    function togglePassword(el, type) {
        el.addClass('d-none');

        switch (type) {
            case "show":
                el.prev().attr("type", "text");
                el.next().removeClass('d-none');
                break;
            case "hide":
                el.prev().prev().attr("type", "password");
                el.prev().removeClass('d-none');
                break;
            default:
        }
    }

    $('#submit-form').click(function () {
        if (validateForm()) {
            $("#change-password-form").submit();
        }
    })

    function validateForm() {
        let error = false;
        let newPassword = $(".input--password[name='new_password']").val();

        $('.input--password').each(function () {
            let name = $(this).attr("name")
            let message = "";
            let errorInput = false;

            switch (name) {
                case "old_password":
                    message = "Mật khẩu cũ";
                    break;
                case "new_password":
                    message = "Mật khẩu mới";
                    break;
                case "confirm_password":
                    message = "Mật khẩu xác nhận";
                    break;
                default:
            }

            if (name === "new_password") {
                if ($(this).val().length < 6) {
                    errorInput = true;
                    error = true;
                    $(this).prev().html(`${message} tối thiểu 6 ký tự`);
                }
            }

            if (name === "confirm_password") {
                if ($(this).val() !== newPassword) {
                    errorInput = true;
                    error = true;
                    $(this).prev().html(`${message} không khớp với mật khẩu mới`);
                }
            }

            if (!$(this).val()) {
                errorInput = true;
                error = true;
                $(this).prev().html(`${message} không được để trống`);
            }

            if (!errorInput) {
                $(this).prev().html("");
            }
        });

        return !error;
    }
})