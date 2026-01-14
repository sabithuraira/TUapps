<!doctype html>
<html lang="en">

<head>
<title>Dinding Bercerita - {{ env('APP_NAME', 'TUapps') }}</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="Dinding Berbicara">
<meta name="author" content="WrapTheme, design by: ThemeMakker.com">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="icon" href="{!! asset('lucid/assets/images/logo-icon.svg') !!}" type="image/x-icon">
<!-- VENDOR CSS -->
<link rel="stylesheet" href="{!! asset('lucid/assets/vendor/bootstrap/css/bootstrap.min.css') !!}">
<link rel="stylesheet" href="{!! asset('lucid/assets/vendor/font-awesome/css/font-awesome.min.css') !!}">
<link rel="stylesheet" href="{!! asset('lucid/assets/vendor/animate-css/animate.min.css') !!}">
<link rel="stylesheet" href="{!! asset('lucid/assets/vendor/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') !!}">
<link rel="stylesheet" href="{!! asset('lucid/assets/vendor/chartist/css/chartist.min.css') !!}">
<link rel="stylesheet" href="{!! asset('lucid/assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css') !!}">
<link rel="stylesheet" href="{!! asset('lucid/assets/vendor/toastr/toastr.min.css') !!}">

<!-- MAIN CSS -->
<link rel="stylesheet" href="{!! asset('assets/css/main.css') !!}">
<link rel="stylesheet" href="{!! asset('assets/css/color_skins.css') !!}">
<style>
    #wrapper {
        margin-left: 0 !important;
        padding-left: 0 !important;
    }
    #main-content {
        width: 100% !important;
        margin-left: 0 !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }
    .container-fluid {
        padding-left: 15px !important;
        padding-right: 15px !important;
    }
    /* Chat Format Styles */
    .chat-history {
        height: 500px;
        overflow-y: auto;
        padding: 20px;
        background-color: #f5f5f5;
    }
    .chat-history ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .chat-history li {
        margin-bottom: 20px;
    }
    .message-data {
        margin-bottom: 5px;
        font-size: 12px;
        color: #999;
    }
    .message-data-time {
        color: #999;
    }
    .message {
        padding: 12px 15px;
        border-radius: 10px;
        max-width: 75%;
        word-wrap: break-word;
        line-height: 1.5;
        clear: both;
    }
    .message.my-message {
        background-color: #007bff;
        color: #fff;
        float: right;
        text-align: left;
    }
    .message.other-message {
        background-color: #fff;
        color: #333;
        border: 1px solid #e0e0e0;
        float: left;
    }
    .message-data {
        clear: both;
    }
    .message-data i {
        font-size: 24px;
        margin-left: 10px;
        vertical-align: middle;
        color: #999;
    }
    .message-data.text-right {
        text-align: right;
    }
    .message-data.text-right i {
        margin-left: 0;
        margin-right: 10px;
    }
</style>
</head>
<body class="theme-blush">

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img src="{!! asset('lucid/assets/images/logo-icon.svg') !!}" width="48" height="48" alt="Lucid"></div>
        <p>Please wait...</p>        
    </div>
</div>
<!-- Overlay For Sidebars -->

<div id="wrapper">

    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header" style="width: 100%;">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-center">                        
                        <h2>Dinding Bercerita</h2>
                    </div>   
                </div>
            </div>

            <!-- Birthday Section - Loaded from API -->
            <div class="row clearfix" id="birthday-section">
                <!-- Birthday cards will be loaded dynamically via API -->
            </div>

            <!-- Dynamic Content Area - Curhat Disetujui -->
            <div class="row clearfix" id="dynamic-content">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>Curhat Pegawai</h2>
                            <ul class="header-dropdown">
                                <li>
                                    <small class="text-muted" id="last-update">Memuat data...</small>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div id="curhat-content">
                                <div class="text-center">
                                    <i class="fa fa-spinner fa-spin"></i> Memuat data...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

<!-- Javascript -->
<script src="{!! asset('assets/bundles/libscripts.bundle.js') !!}"></script>    
<script src="{!! asset('assets/bundles/vendorscripts.bundle.js') !!}"></script>
<script src="{!! asset('assets/bundles/chartist.bundle.js') !!}"></script>
<script src="{!! asset('lucid/assets/vendor/toastr/toastr.js') !!}"></script>
<script src="{!! asset('assets/bundles/mainscripts.bundle.js') !!}"></script>
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>

<script>
// Load Birthday Data from API
function loadBirthday() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $.ajax({
        url: "{{ url('/dashboard/api/birthday') }}",
        method: 'get',
        dataType: 'json',
    }).done(function (response) {
        if (response.success == '1' && response.data.length > 0) {
            var html = '';
            response.data.forEach(function(val) {
                html += '<div class="col-lg-4 col-md-12">';
                html += '    <div class="card member-card">';
                html += '        <div class="header bg-success">';
                html += '            <h5 class="m-t-10 text-light">Selamat Ulang Tahun</h5>';
                html += '        </div>';
                html += '        <div class="member-img">';
                html += '            <a href="javascript:void(0);"><img src="' + val.fotoUrl + '" class="rounded-circle" alt="profile-image"></a>';
                html += '        </div>';
                html += '        <div class="body">';
                html += '            <div class="col-12">';
                html += '                <p class="text-muted"><b>' + val.name + '</b><br> ' + val.nip_baru + '</p>';
                html += '            </div>';
                html += '        </div>';
                html += '    </div>';
                html += '</div>';
            });
            $('#birthday-section').html(html);
        } else {
            $('#birthday-section').html('<div class="col-lg-12"><div class="alert alert-info">Tidak ada ulang tahun hari ini.</div></div>');
        }
    }).fail(function (msg) {
        console.log(JSON.stringify(msg));
        $('#birthday-section').html('<div class="col-lg-12"><div class="alert alert-danger">Gagal memuat data ulang tahun.</div></div>');
    });
}

// Load Approved Curhats from API
function loadApprovedCurhats() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $.ajax({
        url: "{{ url('/curhat_anon/api/approved') }}",
        method: 'get',
        dataType: 'json',
        data: {
            limit: 10
        }
    }).done(function (response) {
        if (response.success == '1' && response.datas.length > 0) {
            var html = '<div class="chat-history">';
            html += '<ul class="m-b-0">';
            
            response.datas.forEach(function(item, index) {
                // Alternate between left and right for visual variety
                var isRight = index % 2 === 0;
                
                html += '<li class="clearfix">';
                
                if (isRight) {
                    html += '<div class="message-data text-right">';
                    html += '<span class="message-data-time">' + formatChatTime(item.created_at) + '</span>';
                    html += '<i class="icon-user"></i>';
                    html += '</div>';
                    html += '<div class="message my-message">' + escapeHtml(item.content) + '</div>';
                } else {
                    html += '<div class="message-data">';
                    html += '<span class="message-data-time">' + formatChatTime(item.created_at) + '</span>';
                    html += '<i class="icon-user"></i>';
                    html += '</div>';
                    html += '<div class="message other-message">' + escapeHtml(item.content) + '</div>';
                }
                
                html += '</li>';
            });
            
            html += '</ul>';
            html += '</div>';
            
            $('#curhat-content').html(html);
            
            // Scroll to bottom to show latest messages
            var chatHistory = $('.chat-history');
            chatHistory.scrollTop(chatHistory[0].scrollHeight);
            
            // Update last update time
            var now = new Date();
            var timeStr = now.getHours().toString().padStart(2, '0') + ':' + 
                         now.getMinutes().toString().padStart(2, '0') + ':' + 
                         now.getSeconds().toString().padStart(2, '0');
            $('#last-update').text('Terakhir diperbarui: ' + timeStr);
        } else {
            $('#curhat-content').html('<div class="alert alert-info text-center">Belum ada curhat yang disetujui.</div>');
            $('#last-update').text('Terakhir diperbarui: ' + new Date().toLocaleTimeString());
        }
    }).fail(function (msg) {
        console.log(JSON.stringify(msg));
        $('#curhat-content').html('<div class="alert alert-danger text-center">Gagal memuat data curhat.</div>');
    });
}

// Helper function to escape HTML
function escapeHtml(text) {
    var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

// Helper function to format date
function formatDate(dateString) {
    if (!dateString) return '';
    var date = new Date(dateString);
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();
    var hours = date.getHours();
    var minutes = date.getMinutes();
    return day + '/' + month + '/' + year + ' ' + 
           hours.toString().padStart(2, '0') + ':' + 
           minutes.toString().padStart(2, '0');
}

// Helper function to format time for chat display
function formatChatTime(dateString) {
    if (!dateString) return '';
    var date = new Date(dateString);
    var now = new Date();
    var diff = now - date;
    var diffDays = Math.floor(diff / (1000 * 60 * 60 * 24));
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var timeStr = hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0');
    
    if (diffDays === 0) {
        return timeStr + ', Today';
    } else if (diffDays === 1) {
        return timeStr + ', Yesterday';
    } else if (diffDays < 7) {
        return timeStr + ', ' + diffDays + ' days ago';
    } else {
        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();
        return timeStr + ', ' + day + '/' + month + '/' + year;
    }
}

// Load birthday data on page load
$(document).ready(function() {
    loadBirthday();
    loadApprovedCurhats();
    
    // Auto-refresh both birthday and approved curhats every 10 minutes (600000 milliseconds)
    setInterval(function() {
        loadBirthday();
        loadApprovedCurhats();
    }, 600000); // 10 minutes
});
</script>
</body>
</html>
