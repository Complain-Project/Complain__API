$(document).ready(function(){
    $("#loginForm").validate({
        rules: {
            username: {
                required: true
            },
            password: {
                required: true,
                minlength: 6
            }
        },
        messages: {
            username: {
                required: "Vui lòng nhập số CMT/CCCD"
            },
            password: {
                required: "Vui lòng nhập mật khẩu",
                minlength: "Mật khẩu phải dài hơn 6 ký tự"
            }
        }
    });


    $("#registerForm").validate({
        rules: {
            username: {
                required: true
            },
            password: {
                required: true,
                minlength: 6
            },
            name: {
                required: true
            },
            aliases: {
                required: true
            },
            phone: {
                required: true,
                minlength: 10,
                maxlength: 10,
                digits: true
            },
            email: {
                email: true
            },
            birthday: {
                date: true
            },
        },
        messages: {
            username: {
                required: "Vui lòng nhập số CMT/CCCD"
            },
            password: {
                required: "Vui lòng nhập mật khẩu",
                minlength: "Mật khẩu phải dài hơn 6 ký tự"
            },
            name: {
                required: "Vui lòng nhập họ tên"
            },
            aliases: {
                required: "Vui lòng nhập bí danh"
            },
            phone: {
                required: "Vui lòng nhập số điện thoại",
                minlength: "Số điện thoại phải có 10 ký tự",
                maxlength: "Số điện thoại phải có 10 ký tự",
                digits: "Số điện thoại nhập vào sai"
            },
            email: {
                email: "Email sai định dạng"
            },
            birthday: {
                date: "Ngày sinh sai định dạng"
            },
        }
    });
});