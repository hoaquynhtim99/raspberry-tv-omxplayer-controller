<!-- BEGIN: main -->
{FILE "header_only.tpl"}
{FILE "header_extended.tpl"}
<div id="tv-main-page">
    <div class="tab-container">
        <ul role="tablist" class="nav nav-tabs tv-main-tabs">
            <li class="nav-item"><a id="tv-link-tab-playlist" href="#tv-tab-playlist" data-toggle="tab" role="tab" class="nav-link active" aria-selected="true"><i class="material-icons">queue_music</i></a></li>
            <!--li class="nav-item"><a href="#home4" data-toggle="tab" role="tab" class="nav-link" aria-selected="true"><i class="material-icons">person</i></a></li-->
            <!--li class="nav-item"><a href="#home4" data-toggle="tab" role="tab" class="nav-link" aria-selected="true"><i class="material-icons">album</i></a></li-->
            <li class="nav-item"><a id="tv-link-tab-directplay" href="#tv-tab-directplay" data-toggle="tab" role="tab" class="nav-link" aria-selected="true"><i class="material-icons">visibility</i></a></li>
        </ul>
        <div class="tab-content">
            <div id="tv-tab-playlist" role="tabpanel" class="tab-pane active tv-playlist"></div>
            <div id="tv-tab-directplay" role="tabpanel" class="tab-pane">
                <p>Nhập trực tiếp url của video vào để phát url có dạng <code>https://www.youtube.com/watch?v=SNVE42IIY_s</code></p>
                <div class="form-group">
                    <input type="text" class="form-control" value="" id="tv-direct-play-input" placeholder="Url của video">
                </div>
                <div class="direct-play-btns">
                    <a href="#" id="tv-direct-addvideo-to-pl" class="btn btn-success btn-lg"><i class="micon material-icons">add</i>Thêm vào playlist</a>
                    <a href="#" id="tv-direct-playvideo" class="btn btn-secondary btn-lg"><i class="micon material-icons">play_arrow</i>Phát trực tiếp</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="tv-search-page">
    <div class="tv-body">
        <div class="tv-body-content">
            <div id="tv-search-page-load" class="text-center">
                <i class="fas fa-circle-notch fa-spin fa-2x"></i>
            </div>
            <div id="tv-search-page-close">
                <a href="#">Đóng trang tìm kiếm</a>
                <hr>
            </div>
            <div id="tv-search-page-result" class="tv-playlist"></div>
        </div>
    </div>
</div>

{FILE "footer_extended.tpl"}
{FILE "footer_only.tpl"}
<!-- END: main -->