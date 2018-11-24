// $(function() {
//     $('body').on('click', '.pagination a', function(e) {
//         e.preventDefault();

//         $('#load a').css('color', '#dfecf6');
//         $('#load').append('<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="../public/images/loading.gif" />');

//         var url = $(this).attr('href');  
//         getDatas(url);
//         window.history.pushState("", "", url);
//     });

//     function getDatas(url) {
//         $.ajax({
//             url : url  
//         }).done(function (data) {
//             $('.datas').html(data);  
//         }).fail(function () {
//             alert('Data could not be loaded.');
//         });
//     }
// });

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
        getDatas($(this).attr('href').split('page=')[1]);
        e.preventDefault();
    });
});
function getDatas(page) {
    $.ajax({
        url : '?page=' + page,
        type: "get",
        dataType: 'json',
    }).done(function (data) {
        $('.datas').html(data);
        location.hash = page;
    }).fail(function (msg) {
        alert('Datas could not be loaded.');
        console.log(msg);
    });
}