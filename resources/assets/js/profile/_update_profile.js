$(document).ready(function () {
    $('.btn-save-information').on('click', function () {
        if (validateForm()) {
            $("#form-info").submit();
        }
    })

    $('.input__info').keyup(function () {
        $(this).prev().html("");
    })

    function validateForm() {
        let error = false;

        $('.input__info').each(function () {
            let name = $(this).attr("name")
            let message = "";
            let errorInput = false;

            switch (name) {
                case "name":
                    message = "Họ và tên";
                    break;
                case "phone":
                    message = "Số điện thoại";
                    break;
                case "aliases":
                    message = "Bí danh";
                    break;
                default:
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
});
