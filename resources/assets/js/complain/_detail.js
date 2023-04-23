$(document).ready(function(){
    $('#attachment').click(function(event){
        event.preventDefault();

        const url = $(this).attr('href');
        const fileName = "Tai_Lieu_dinh_kem" + url.substring(url.lastIndexOf("."));

        const link = document.createElement("a");
        link.download = fileName;
        link.href = url;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    })

})