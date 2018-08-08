    <div class="tv-player-control">
        <div class="ct-buttons">
            <a href="#" class="tv-player-control-btn disabled" data-tvcmd="stop"><i class="material-icons">stop</i></a>
            <a href="#" class="tv-player-control-btn disabled" data-tvcmd="pause"><i class="material-icons">play_arrow</i></a>
            <a href="#" class="tv-player-control-btn disabled" data-tvcmd="seek-600"><i class="material-icons">skip_previous</i></a>
            <a href="#" class="tv-player-control-btn disabled" data-tvcmd="seek-30"><i class="material-icons">fast_rewind</i></a>
            <a href="#" class="tv-player-control-btn disabled" data-tvcmd="seek30"><i class="material-icons">fast_forward</i></a>
            <a href="#" class="tv-player-control-btn disabled" data-tvcmd="seek600"><i class="material-icons">skip_next</i></a>
            <a href="#" class="tv-player-control-btn disabled" data-tvcmd="voldown"><i class="material-icons">volume_down</i></a>
            <a href="#" class="tv-player-control-btn disabled" data-tvcmd="volup"><i class="material-icons">volume_up</i></a>
        </div>
        <div class="current-video-name" id="tv-player-current-video-name"></div>
    </div>
</div>
<div class="tv-search-wrapper">
    <div class="search-form" id="tv-search-form-wrapper">
        <div class="logo">
            <a href="{THEME_SITE_HREF}"><img src="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/logo-iv.svg" alt="{NV_SITE_NAME}"></a>
        </div>
        <div class="form">
            <form method="get" action="{NV_BASE_SITEURL}" id="tv-search-form">
                <input id="tv-search-input" type="text" class="form-control" name="q" value="" placeholder="Tìm kiếm video">
            </form>
        </div>
        <div class="menu">
            <ul>
                <li><a id="tv-search-clear" href="#"><i class="material-icons">close</i></a></li>
                <li><a id="tv-search-submit" href="#"><i class="material-icons">search</i></a></li>
            </ul>
        </div>
    </div>
</div>

<div class="tv-menu-item-search" id="tv-search-item-menu">
    <div class="ctn">
        <a href="#" id="tv-search-item-menu-addtop">Thêm lên đầu danh sách</a>
        <a href="#" id="tv-search-item-menu-addbot">Thêm vào cuối danh sách</a>
        <a href="#" id="tv-search-item-menu-playnow">Phát ngay</a>
        <a href="#" id="tv-cancel-search-item-menu">Hủy</a>
    </div>
    <div class="overlay"></div>
</div>

<div class="tv-menu-item-search" id="tv-playlist-item-menu">
    <div class="ctn">
        <a href="#" id="tv-playlist-item-menu-settop">Đưa lên đầu danh sách</a>
        <a href="#" id="tv-playlist-item-menu-setbot">Đưa xuống cuối danh sách</a>
        <a href="#" id="tv-playlist-item-menu-playnow">Phát ngay</a>
        <a href="#" id="tv-playlist-item-menu-del">Xóa khỏi danh sách</a>
        <a href="#" id="tv-cancel-playlist-item-menu">Hủy</a>
    </div>
    <div class="overlay"></div>
</div>

{ADMINTOOLBAR}
<!-- SiteModal Required!!! -->
<div id="sitemodal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <em class="fa fa-spinner fa-spin">&nbsp;</em>
            </div>
            <button type="button" class="close" data-dismiss="modal"><span class="fa fa-times"></span></button>
        </div>
    </div>
</div>
<div class="tv-loading">
    <div class="ctn"><i class="fas fa-circle-notch fa-spin"></i></div>
</div>
<div class="yt-login">
    <div class="ctn">
        <a href="#" id="yt-login-btn"><i class="material-icons">people</i><br>Nhấp vào đây để đăng nhập</a>
    </div>
</div>