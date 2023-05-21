$(document).ready(function(){
    getData()

    $('#title').val('');
    $('#content').val('');
    $('#content').text('');
    $('#district_id').val('');

    $("#submit_complain").validate({
        rules: {
            title: {
                required: true
            },
            content: {
                required: true
            },
            district_id: {
                required: true
            }
        },
        messages: {
            title: {
                required: "Vui lòng nhập tiêu đề của khiếu nại"
            },
            content: {
                required: "Vui lòng nhập nội dung khiếu nại"
            },
            district_id: {
                required: "Vui lòng chọn đơn vị tiếp nhận",
            }
        }
    });

    $('#btnReset').click(function() {
        $('#title').val('');
        $('#content').val('');
        $('#content').text('');
        $('#district_id').val('');
    })


    function getData() {
        $.ajax({
            url: "/all-district",
            method: "GET",
            dataType: "JSON",
            success: function (response) {
                let listDistrict = response.data
                $('#district_id').empty()
                listDistrict.forEach(function (item, index) {
                    if(index === 0){
                        $('#district_id').append('<option selected value="' + item._id + '">' + item.name + '</option>')
                    }else{
                        $('#district_id').append('<option value="' + item._id + '">' + item.name + '</option>')
                    }
                });
            }
        })
    }
});
