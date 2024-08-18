$(document).ready(function () {
    $.ajax({
        type: "post",
        url: "/resources/backend/loadrecord.php",
        data: {
            gettable : 1
        },
        success: function (response) {
            $("table").html(response);
        }
    });
});