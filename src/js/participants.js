$(document).ready(function () {
    $('#refresh-btn').click(function () {
        $.ajax({
            url: '?c=participant&m=ajaxReload',
            type: 'GET',
            success: function (response) {
                $('#participants-table tbody').html(response);
            },
            error: function () {
                alert("Gagal memuat ulang data peserta.");
            }
        });
    });
});
