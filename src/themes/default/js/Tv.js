/**
 * @Project TAN DUNG RASPBERRY TV
 * @Author PHAN TAN DUNG <phantandung92@gmail.com>
 * @Copyright (C) 2018 PHAN TAN DUNG. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sunday, August 5, 2018 9:53:00 AM GMT+07:00
 */

var systemIsBusy = false;
var timerQueryData;
var OAUTH2_CLIENT_ID = '674477090747-o8du1m9brvkmuk3cbab7c1k27a8gqjpl.apps.googleusercontent.com';
var OAUTH2_SCOPES = [
	'https://www.googleapis.com/auth/youtube'
];

/*
 * Hàm thực thi ngay khi Google API được tải xong
 */
googleApiClientReady = function() {
	gapi.auth.init(function() {
		window.setTimeout(googleApiCheckAuth, 1);
	});
}

/*
 * Kiểm tra xác thực
 */
function googleApiCheckAuth() {
	gapi.auth.authorize({
	    client_id: OAUTH2_CLIENT_ID,
	    scope: OAUTH2_SCOPES,
	    immediate: true
	}, handleAuthResult);
}

/*
 * Xử lý thông tin xác thực từ cuộc gọi gapi.auth.authorize()
 */
function handleAuthResult(authResult) {
	if (authResult && !authResult.error) {
		loadAPIClientInterfaces();
	} else {
		// Xử lý nếu chưa đăng nhập
		$('body').removeClass('loading');
		$('body').addClass('mustlogin');
		$('#yt-login-btn').click(function(e) {
			e.preventDefault();
		    gapi.auth.authorize({
		        client_id: OAUTH2_CLIENT_ID,
		        scope: OAUTH2_SCOPES,
		        immediate: false
		    }, handleAuthResult);
		});
	}
}

/*
 * Load API của Youtube
 */
function loadAPIClientInterfaces() {
    gapi.client.load('youtube', 'v3', function() {
        handleAPILoaded();
    });
}

/*
 * Sau khi các API load xong thì đánh dấu hệ thống sẵn sàng
 */
function handleAPILoaded() {
	$('body').removeClass('mustlogin');
	$('body').removeClass('loading');
}

/*
 * Xuất playlist
 */
function buildPlaylist(data) {
	var html = '';
	$.each(data, function(k, item) {
		html += '<li>';
		html += '<div class="img">';
		html += '<div class="thb">';
		html += '<img src="' + item.image + '" alt="' + item.title + '">';
		html += '<!--div class="time"><time><span>1:45:49</span></time></div-->';
		html += '</div>';
		html += '</div>';
		html += '<div class="metadata">';
		html += '<div class="render">';
		html += '<h4>' + item.title + '</h4>';
		html += '<div class="subhead">';
		html += '<div class="small">' + item.channeltitle + '</div>';
		html += '</div>';
		html += '</div>';
		html += '<div class="menu"><a class="tv-item-playlist" href="#" data-vid="' + item.code +'" data-vtitle="' + item.title +'" data-vimage="' + item.image +'"><i class="material-icons">more_vert</i></a></div>';
		html += '</div>';
		html += '</li>';
	});

	$('#tv-tab-playlist').html('<ul>' + html + '</ul>');

}

/*
 * Điều khiển các nút
 */
function controlPlayerButton(data) {
	if (data.player_state != 'stopped' && data.tv_state == 'playing') {
		// Không dừng phát thì cho phép nút tăng âm lượng
		$('[data-tvcmd="voldown"]').removeClass('disabled');
		$('[data-tvcmd="volup"]').removeClass('disabled');
	}

	if (data.player_state == 'playing') {
		// Đang phát thì cho phép các nút tua
		$('[data-tvcmd="seek-600"]').removeClass('disabled');
		$('[data-tvcmd="seek-30"]').removeClass('disabled');
		$('[data-tvcmd="seek30"]').removeClass('disabled');
		$('[data-tvcmd="seek600"]').removeClass('disabled');

		// Đang phát thì nút play là nút dừng
		$('[data-tvcmd="pause"]').find('i').html('pause');
	} else {
		$('[data-tvcmd="pause"]').find('i').html('play_arrow');
	}

	if (data.player_state != 'stopped') {
		// Đang phát hoặc tạm dừng thì cho phép nút play
		$('[data-tvcmd="pause"]').removeClass('disabled');
	} else {
		$('[data-tvcmd="pause"]').addClass('disabled');
	}

	if (data.tv_state == 'playing') {
		$('[data-tvcmd="stop"]').removeClass('disabled');
	} else {
		// Tivi bị dừng thì cấm hết các nút
		$('.tv-player-control-btn').addClass('disabled');
		// Nút play là hình play video
		$('[data-tvcmd="pause"]').find('i').html('play_arrow');
	}

	if (data.vtitle == '') {
		data.vtitle = 'Mời chọn video';
	}
	$('#tv-player-current-video-name').html(data.vtitle);
}

/*
 * Xử lý toàn bộ dữ liệu
 */
function handleAppData(data) {
	// Build lại playlist
	buildPlaylist(data.playlists);

	// Cập nhật control player
	controlPlayerButton(data.player);
}

/*
 * Xóa video khỏi playlist
 */
function removeVideoFromPlaylist(data) {
	$('#tv-playlist-item-menu').css({display: 'none'});
	showLoader();
	$.ajax({
		cache: false,
		data: {
			vid: data.vid,
			deletevideofromplaylist: 1
		},
		dataType: 'json',
		method: 'POST',
		url: nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&nocache=' + new Date().getTime()
	}).done(function(e) {
		hideLoader();
		handleAppData(e);
	}).fail(function() {
		hideLoader();
	});
}

/*
 * Điều khiển thêm video tìm kiếm vào playlist
 */
function setVideoToPlaylist(data, position, activeTab) {
	$('#tv-search-item-menu').css({display: 'none'});
	showLoader();
	$.ajax({
		cache: false,
		data: {
			vid: data.vid,
			vimage: data.vimage,
			vtitle: data.vtitle,
			ctitle: data.ctitle,
			addvideotolist: 1,
			position: position
		},
		dataType: 'json',
		method: 'POST',
		url: nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&nocache=' + new Date().getTime()
	}).done(function(e) {
		hideLoader();
		if (e.status != 'ok') {
			alert(e.message);
			return;
		}
		handleAppData(e.data);
		if (activeTab) {
			$('#tv-link-tab-playlist').tab('show');
		}
	}).fail(function() {
		alert("Có lỗi");
		hideLoader();
	});
}

/*
 * Đưa video lên đầu playlist
 */
function setVideoToTopPlaylist(data) {
	setVideoToPlaylist(data, 'top', false);
}

/*
 * Đưa video xuống cuối playlist
 */
function setVideoToBottomPlaylist(data) {
	setVideoToPlaylist(data, 'bottom', false);
}

/*
 * Phát video vừa tìm được ngay
 * Phát cái này là phát bằng code video chứ không phải phát bằng ID playlist
 * Áp dụng cho kết quả tìm kiếm và phần nhập URL trực tiếp
 */
function playThisVideoNow(data, activeTab) {
	$('#tv-search-item-menu').css({display: 'none'});
	showLoader();
	$.ajax({
		cache: false,
		data: {
			vid: data.vid,
			vtitle: data.vtitle,
			playvideobycode: 1
		},
		dataType: 'json',
		method: 'POST',
		url: nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&nocache=' + new Date().getTime()
	}).done(function(e) {
		hideLoader();
		if (e.status != 'ok') {
			alert(e.message);
			return;
		}
		handleAppData(e.data);
		if (activeTab) {
			$('#tv-link-tab-playlist').tab('show');
		}
	}).fail(function() {
		alert("Có lỗi");
		hideLoader();
	});
}

/*
 * Hiển thị menu của item tại trang tìm kiếm
 */
function showSearchItemMenu(target) {
	$('#tv-search-item-menu').data($(target).data());
	$('#tv-search-item-menu').css({display: 'flex'});
}

/*
 * Hiển thị menu của item tại trang playlist
 */
function showPlaylistItemMenu(target) {
	$('#tv-playlist-item-menu').data($(target).data());
	$('#tv-playlist-item-menu').css({display: 'flex'});
	systemIsBusy = true;
}


/*
 * Điều khiển thứ tự video trong playlist
 */
function changePlayListVideoWeight(data, position) {
	$('#tv-playlist-item-menu').css({display: 'none'});
	showLoader();
	$.ajax({
		cache: false,
		data: {
			vid: data.vid,
			changeplaylistweight: 1,
			position: position
		},
		dataType: 'json',
		method: 'POST',
		url: nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&nocache=' + new Date().getTime()
	}).done(function(e) {
		hideLoader();
		handleAppData(e);
	}).fail(function() {
		hideLoader();
	});
}

/*
 * Đưa video trong playlist lên trên
 */
function setPlaylistItemTop(data) {
	changePlayListVideoWeight(data, 'top');
}

/*
 * Đưa video trong playlist xuống cuối
 */
function setPlaylistItemBot(data) {
	changePlayListVideoWeight(data, 'bottom');
}

function showLoader() {
	$('body').addClass('loading');
	systemIsBusy = true;
}

function hideLoader() {
	$('body').removeClass('loading');
	systemIsBusy = false;
}

/*
 * Lấy hết dữ liệu của Tivi
 */
function queryTVData() {
	if (!systemIsBusy) {
		systemIsBusy = true;
		$.ajax({
			cache: false,
			data: {
				loadsysdata: 1
			},
			dataType: 'json',
			method: 'POST',
			url: nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&nocache=' + new Date().getTime()
		}).done(function(e) {
			handleAppData(e);
			systemIsBusy = false;
		}).fail(function() {
			systemIsBusy = false;
		});
	}
}

$(document).ready(function() {
	// Xử lý khi ấn vào tùy chọn ở một video tìm kiếm được
	$(document).delegate('.tv-item-yt-search', 'click', function(e) {
		e.preventDefault();
		showSearchItemMenu(this);
	});

	// Xử lý khi ấn vào tùy chọn ở một video trong playlist
	$(document).delegate('.tv-item-playlist', 'click', function(e) {
		e.preventDefault();
		showPlaylistItemMenu(this);
	});

	// Xử lý khi ấn tìm kiếm
	$('#tv-search-form').submit(function(e) {
		e.preventDefault();
		var q = trim($('#tv-search-input').val());
		if (q == '') {
			return;
		}

		var request = gapi.client.youtube.search.list({
		    q: q,
		    part: 'snippet',
		    maxResults: 20,
		    type: 'video'
		});

		// Ẩn trang chính
		$('#tv-main-page').hide();
		// Hiện trang tìm kiếm
		$('#tv-search-page').show();
		// Làm rỗng trang kết quả
		$('#tv-search-page-result').hide();
		$('#tv-search-page-result').html();
		// Hiển thị màn hình bận
		$('#tv-search-page-load').show();
		// Ẩn form tìm kiếm
		$('body').removeClass('open-search');
		// Đổi tên tiêu đề site
		$('#tv-page-title').html(q);
		// Ẩn nút đóng trang tìm kiếm
		$('#tv-search-page-close').hide();

		request.execute(function(response) {
			// Ẩn thanh load
			$('#tv-search-page-load').hide();
			// Hiển thị kết quả
			$('#tv-search-page-result').show();
			// Hiển thị nút đóng trang tìm kiếm
			$('#tv-search-page-close').show();

			if (response.pageInfo.totalResults < 1) {
				$('#tv-search-page-result').html('<div role="alert" class="alert alert-primary alert-icon alert-icon-colored alert-dismissible">' +
				    '<div class="icon"><i class="fas fa-info-circle"></i></div>' +
				    '<div class="message">' +
				        '<button type="button" data-dismiss="alert" aria-label="Đóng" class="close"><i class="fas fa-times"></i></button>' +
				        'Không có video nào phù hợp với yêu cầu tìm kiếm.' +
				    '</div>' +
				'</div>');
				return;
			}

			var html = '';
			$.each(response.items, function(k, item) {
				html += '<li>';
				html += '<div class="img">';
				html += '<div class="thb">';
				html += '<img src="' + item.snippet.thumbnails.medium.url + '" alt="' + item.snippet.title + '">';
				html += '<!--div class="time"><time><span>1:45:49</span></time></div-->';
				html += '</div>';
				html += '</div>';
				html += '<div class="metadata">';
				html += '<div class="render">';
				html += '<h4>' + item.snippet.title + '</h4>';
				html += '<div class="subhead">';
				html += '<div class="small">' + item.snippet.channelTitle + '</div>';
				html += '</div>';
				html += '</div>';
				html += '<div class="menu"><a class="tv-item-yt-search" href="#" data-vid="' + item.id.videoId +'" data-vtitle="' + item.snippet.title +'" data-vimage="' + item.snippet.thumbnails.medium.url +'" data-ctitle="' + item.snippet.channelTitle + '"><i class="material-icons">more_vert</i></a></div>';
				html += '</div>';
				html += '</li>';
			});

			$('#tv-search-page-result').html('<ul>' + html + '</ul>');
		});
	});

	// Đóng trang tìm kiếm
	$('#tv-search-page-close a').on('click', function(e) {
		e.preventDefault();
		// Hiện trang chính
		$('#tv-main-page').show();
		// Ẩn trang tìm kiếm
		$('#tv-search-page').hide();
		// Đổi tên tiêu đề site
		$('#tv-page-title').html($('#tv-page-title').data('title'));
	});

	/*
	 * Đóng menu tìm kiếm Video
	 */
	$('#tv-cancel-search-item-menu').on('click', function(e) {
		e.preventDefault();
		$('#tv-search-item-menu').css({display: 'none'});
	});

	/*
	 * Thêm video tìm lên đầu danh sách
	 */
	$('#tv-search-item-menu-addtop').on('click', function(e) {
		e.preventDefault();
		setVideoToTopPlaylist($(this).parent().parent().data());
	});

	/*
	 * Thêm video tìm xuống cuối danh sách
	 */
	$('#tv-search-item-menu-addbot').on('click', function(e) {
		e.preventDefault();
		setVideoToBottomPlaylist($(this).parent().parent().data());
	});

	/*
	 * Phát video được tìm kiếm ngay
	 */
	$('#tv-search-item-menu-playnow').on('click', function(e) {
		e.preventDefault();
		playThisVideoNow($(this).parent().parent().data(), false);
	});

	/*
	 * Đóng menu playlist
	 */
	$('#tv-cancel-playlist-item-menu').on('click', function(e) {
		e.preventDefault();
		$('#tv-playlist-item-menu').css({display: 'none'});
		systemIsBusy = false;
	});

	/*
	 * Đưa video trong playlist lên đầu
	 */
	$('#tv-playlist-item-menu-settop').on('click', function(e) {
		e.preventDefault();
		setPlaylistItemTop($(this).parent().parent().data());
	});

	/*
	 * Đưa video trong playlist xuống cuối
	 */
	$('#tv-playlist-item-menu-setbot').on('click', function(e) {
		e.preventDefault();
		setPlaylistItemBot($(this).parent().parent().data());
	});

	/*
	 * Xóa video khỏi danh sách
	 */
	$('#tv-playlist-item-menu-del').on('click', function(e) {
		e.preventDefault();
		removeVideoFromPlaylist($(this).parent().parent().data());
	});

	/*
	 * Xử lý khi ấn nút thêm video nhập từ URL
	 */
	$('#tv-direct-addvideo-to-pl').on('click', function(e) {
		e.preventDefault();
		var videourl = trim($('#tv-direct-play-input').val());
		if (videourl == '') {
			$('#tv-direct-play-input').focus();
			return;
		}
		var matches = videourl.match(/v\=([a-zA-Z0-9\-\_]+)/);
		if (matches.length != 2) {
			$('#tv-direct-play-input').focus();
			return;
		}
		var request = gapi.client.youtube.videos.list({
		    id: matches[1],
		    part: 'snippet'
		});
		$('#tv-direct-addvideo-to-pl').prop('disabled', true);
		request.execute(function(response) {
			$('#tv-direct-addvideo-to-pl').prop('disabled', false);
			if (response.pageInfo.totalResults != 1) {
				$('#tv-direct-play-input').select().focus();
				return;
			}
			var data = {
				vid: response.items[0].id,
				vtitle: response.items[0].snippet.title,
				ctitle: response.items[0].snippet.channelTitle,
				vimage: response.items[0].snippet.thumbnails.medium.url
			};
			setVideoToPlaylist(data, 'bottom', true);
		});
	});

	/*
	 * Xử lý khi ấn nút điều khiển
	 */
	$('.tv-player-control-btn').on('click', function(e) {
		e.preventDefault();
		if ($(this).is('.disabled')) {
			return false;
		}
		showLoader();
		$.ajax({
			cache: false,
			data: {
				sendcontrolcmd: 1,
				cmd: $(this).data('tvcmd')
			},
			dataType: 'json',
			method: 'POST',
			url: nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&nocache=' + new Date().getTime()
		}).done(function(e) {
			handleAppData(e);
			hideLoader();
		}).fail(function() {
			hideLoader();
		});
	});

	/*
	 * Xử lý khi ấn qua Tab nhập URL
	 */
	$('#tv-link-tab-directplay').on('shown.bs.tab', function(e) {
		$('#tv-direct-play-input').select().focus();
	});

	/*
	 * Xử lý trình cập nhật dữ liệu
	 */
	queryTVData();
	timerQueryData = setInterval(function() {
		queryTVData();
	}, 2000);
});
