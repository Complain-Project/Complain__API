$(document).ready(function(){
    getData()
    function getData() {
        $.ajax({
            url: "/all-district",
            method: "GET",
            dataType: "JSON",
            success: function (response) {
                let listDistrict = response.data
                let select = $('#district_id')
                let code = select.data('code')
                select.empty()
                select.append(' <option>Chọn cơ quan tiếp nhận</option>')
                listDistrict.forEach(function (item) {
                    $('#district_id').append('<option value="' + item.code + '"' + (item.code == code ? 'selected' : '') +'>' + item.name + '</option>')
                });
            }
        })
    }
});