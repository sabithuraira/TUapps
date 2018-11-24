$(window).on('hashchange', function() {
    if (window.location.hash) {
        var page = window.location.hash.replace('#', '');
        if (page == Number.NaN || page <= 0) {
            return false;
        } else {
            getDatas(page);
        }
    }
});

$(document).ready(function() {
    $(document).on('click', '.pagination a', function (e) {
        $('.datas').append('<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="../public/images/loading.gif" />');
        var url = $(this).attr('href'); 
        getDatas($(this).attr('href').split('page=')[1]);
        e.preventDefault();
    });
});

function getDatas(page) {
    $.ajax({
        url : '?page=' + page,
        type : "get",
        dataType: 'json',
        data:{
            search: $('#search').val()
        },
    }).done(function (data) {
        $('.datas').html(data);
        location.hash = page;
    }).fail(function (msg) {
        alert('Gagal menampilkan data, silahkan refresh halaman.');
    });
}