<?php

/**
 * @Project TAN DUNG RASPBERRY TV
 * @Author PHAN TAN DUNG <phantandung92@gmail.com>
 * @Copyright (C) 2018 PHAN TAN DUNG. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sunday, August 5, 2018 9:53:00 AM GMT+07:00
 */

if (!defined('NV_IS_MOD_RTV')) {
    die('Stop!!!');
}

/*
 * Xử lý khi ấn các nút điều khiển
 */
if ($nv_Request->isset_request('sendcontrolcmd', 'post')) {
    $cmd = $nv_Request->get_title('cmd', 'post', '');

    // Ấn nút STOP thì dừng
    if ($cmd == 'stop') {
        $global_array_config['tivi_state'] = 'stopped';
        $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_config SET config_value='stopped' WHERE config_name='tivi_state'");
    }

    controlRaspberry($cmd);
    nv_jsonOutput(getAppTVData());
}

/*
 * Tiến trình thực hiện điều khiển player
 */
if ($nv_Request->isset_request('cronex', 'get')) {
    // Kiểm tra trạng thái tivi đang chạy hay đang dừng trước mỗi truy vấn
    $checkTVPlayStatus = controlRaspberry('status');
    $currentTVPlayStatus = $global_array_config['player_state'];
    if (isset($checkTVPlayStatus['status']) and $checkTVPlayStatus['status'] == 'OK') {
        $liveStatus = strtolower(trim($checkTVPlayStatus['message']));
        if ($liveStatus == 'stopped') {
            // Nếu TIVI đang dừng thì là dùng
            $currentTVPlayStatus = 'stopped';
        } elseif ($currentTVPlayStatus == 'stopped') {
            /*
             * Nếu tivi đang phát và trong trình điều khiển là dừng thì
             * Cập nhật là đang chạy
             */
            $currentTVPlayStatus = 'playing';
        }
    }
    if ($currentTVPlayStatus != $global_array_config['player_state']) {
        $global_array_config['player_state'] = $currentTVPlayStatus;
        $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_config SET config_value=" . $db->quote($global_array_config['player_state']) . " WHERE config_name='player_state'");
    }

    if ($global_array_config['tivi_state'] == 'playing') {
        // Trạng thái khi TIVI được cho phép chạy
        $respon = 'TV is play video';

        if ($global_array_config['player_state'] == 'stopped') {
            // Phát video do người dùng chỉ định
            if (!empty($global_array_config['next_video_code'])) {
                $controlRespon = controlRaspberry('play', $global_array_config['next_video_code']);
                if (isset($controlRespon['status']) and $controlRespon['status'] == 'OK') {
                    // Sau khi phát video trực tiếp thì cập nhật code về rỗng, next playlist về 0
                    $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_config SET config_value='0' WHERE config_name='next_video_plid'");
                    $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_config SET config_value='' WHERE config_name='next_video_code'");

                    // Cập nhật tên video đang phát để hiển thị cho trình duyệt
                    $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_config SET config_value=" . $db->quote($global_array_config['next_video_title']) . " WHERE config_name='current_video_title'");
                }
                if (isset($controlRespon['status'])) {
                    $respon = "Play direct video " . $global_array_config['next_video_code'] . " => " . $controlRespon['status'] . " (" . nv_EncString($controlRespon['message']) . ")";
                } else {
                    $respon = "Play direct video => TV not respon";
                }
            } else {
                // Tìm video tiếp theo sẽ phát trong playlist
                $video = [];
                if (!empty($global_array_config['next_video_plid'])) {
                    // Tìm video tiếp theo do người dùng chỉ định
                    $video = $db->query("SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_playlists WHERE id=" . $global_array_config['next_video_plid'])->fetch();
                }

                // Nếu không có video thì tìm video có thứ tự cao hơn cái video đang có ID
                if (empty($video) and !empty($global_array_config['current_video_plid'])) {
                    $videoCrr = $db->query("SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_playlists WHERE id=" . $global_array_config['current_video_plid'])->fetch();
                    if (!empty($videoCrr)) {
                        $nextWeight = $videoCrr['weight'] + 1;
                        $video = $db->query("SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_playlists WHERE weight=" . $nextWeight)->fetch();
                    }
                }

                // Nếu không có video thì tìm tiếp video có weight lớn hơn
                if (empty($video) and !empty($global_array_config['current_video_plweight'])) {
                    $nextWeight = $global_array_config['current_video_plweight'] + 1;
                    $video = $db->query("SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_playlists WHERE weight=" . $nextWeight)->fetch();
                }

                // Cuối cùng không có thì lấy video đầu tiên
                if (empty($video)) {
                    $video = $db->query("SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_playlists ORDER BY weight ASC LIMIT 1")->fetch();
                }

                // Khi có video thì điều khiển phát
                if (!empty($video)) {
                    $controlRespon = controlRaspberry('play', $video['code']);
                    if (isset($controlRespon['status']) and $controlRespon['status'] == 'OK') {
                        // Khi phát thành công thì cập nhật:
                        // ID video đang phát
                        $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_config SET config_value=" . $db->quote($video['id']) . " WHERE config_name='current_video_plid'");
                        // Thứ tự video đang phát
                        $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_config SET config_value=" . $db->quote($video['weight']) . " WHERE config_name='current_video_plweight'");
                        // Đưa video tiếp theo sẽ phát về rỗng
                        $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_config SET config_value='0' WHERE config_name='next_video_plid'");
                        $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_config SET config_value='' WHERE config_name='next_video_code'");
                        $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_config SET config_value='' WHERE config_name='next_video_title'");
                        // Đưa trạng thái player về đang phát
                        $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_config SET config_value='playing' WHERE config_name='player_state'");
                        // Cập nhật tên video đang phát để hiển thị cho trình duyệt
                        $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_config SET config_value=" . $db->quote($video['title']) . " WHERE config_name='current_video_title'");
                    }
                    if (isset($controlRespon['status'])) {
                        $respon = "Play video in playlists " . $video['code'] . " => " . $controlRespon['status'] . " (" . nv_EncString($controlRespon['message']) . ")";
                    } else {
                        $respon = "Play video in playlists => TV not respon";
                    }
                }
            }
        } elseif (
            (!empty($global_array_config['next_video_plid']) and $global_array_config['next_video_plid'] != $global_array_config['current_video_plid']) or
            !empty($global_array_config['next_video_code'])
        ) {
            // Nếu đang phát và người dùng bắt đổi bài khác
            $controlRespon = controlRaspberry('stop');
            if (isset($controlRespon['status'])) {
                $respon = "Set TV stop play => " . $controlRespon['status'] . " (" . nv_EncString($controlRespon['message']) . ")";
            } else {
                $respon = "Set TV stop play => TV not respon";
            }
        }
    } else {
        // Xử lý cho tivi dừng
        if ($global_array_config['player_state'] == 'playing' or $global_array_config['player_state'] == 'pause') {
            // Nếu đang phát hoặc đang tạm dừng thì buộc dừng phát
            $controlRespon = controlRaspberry('stop');
            if (isset($controlRespon['status'])) {
                $respon = "Set TV stop play => " . $controlRespon['status'] . " (" . nv_EncString($controlRespon['message']) . ")";
            } else {
                $respon = "Set TV stop play => TV not respon";
            }
        } else {
            $respon = "TV is Idle";
        }

        // Khi tivi đang dừng cập nhật bài đang phát về rỗng
        if ($global_array_config['tivi_state'] == 'stopped') {
            $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_config SET config_value='0' WHERE config_name='current_video_plid'");
            $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_config SET config_value='0' WHERE config_name='current_video_plweight'");
            $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_config SET config_value='' WHERE config_name='current_video_title'");
        }
    }

    die($respon);
}

/*
 * Lấy toàn bộ data bao gồm:
 * - Playlist
 * - Trạng thái player
 */
if ($nv_Request->isset_request('loadsysdata', 'post')) {
    nv_jsonOutput(getAppTVData());
}


/*
 * Phát một video bằng code
 */
if ($nv_Request->isset_request('playvideobycode', 'post')) {
    $array = [];
    $array['vid'] = $nv_Request->get_title('vid', 'post', '');
    $array['vtitle'] = $nv_Request->get_title('vtitle', 'post', '');

    $respon = [
        'status' => 'error',
        'message' => 'Lỗi không xác định',
        'data' => []
    ];

    if (empty($array['vid']) or empty($array['vtitle'])) {
        $respon['message'] = "Lỗi mã Video hoặc tiêu đề trống";
    } else {
        // Set TV là play
        $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_config SET config_value='playing' WHERE config_name='tivi_state'");
        // Cập nhật bài cần phát
        $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_config SET config_value=" . $db->quote($array['vid']) . " WHERE config_name='next_video_code'");
        $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_config SET config_value=" . $db->quote($array['vtitle']) . " WHERE config_name='next_video_title'");

        $respon['status'] = 'ok';
        $respon['data'] = getAppTVData();
    }

    nv_jsonOutput($respon);
}

/*
 * Thêm Video vào playlist
 */
if ($nv_Request->isset_request('addvideotolist', 'post')) {
    $array = [];
    $array['vid'] = $nv_Request->get_title('vid', 'post', '');
    $array['vimage'] = $nv_Request->get_title('vimage', 'post', '');
    $array['vtitle'] = $nv_Request->get_title('vtitle', 'post', '');
    $array['ctitle'] = $nv_Request->get_title('ctitle', 'post', '');
    $array['position'] = $nv_Request->get_title('position', 'post', '');

    $respon = [
        'status' => 'error',
        'message' => 'Lỗi không xác định',
        'data' => []
    ];

    if (!empty($array['vid']) and !empty($array['vid']) and !empty($array['vid']) and ($array['position'] == 'top' or $array['position'] == 'bottom')) {
        // Kiểm tra vid có chưa
        $sql = "SELECT COUNT(*) FROM " . NV_PREFIXLANG . "_" . $module_data . "_playlists WHERE code=" . $db->quote($array['vid']);
        $isExists = $db->query($sql)->fetchColumn();
        if ($isExists) {
            $respon['message'] = 'Bài này đã có trong danh sách';
        } else {
            if ($array['position'] == 'bottom') {
                $weight = $db->query("SELECT MAX(weight) FROM " . NV_PREFIXLANG . "_" . $module_data . "_playlists")->fetchColumn();
                $weight++;
            } else {
                $weight = 0;
            }

            $sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_playlists (
                code, title, channeltitle, image, weight, add_time, edit_time
            ) VALUES (
                " . $db->quote($array['vid']) . ", " . $db->quote($array['vtitle']) . ", " . $db->quote($array['ctitle']) . ",
                " . $db->quote($array['vimage']) . ", " . $weight . ", " . NV_CURRENTTIME . ", 0
            )";
            $newID = $db->insert_id($sql);
            if (!$newID) {
                $respon['message'] = 'Lỗi trong quá trình thêm vào playlist';
            } else {
                $respon['status'] = 'ok';

                // Cập nhật tăng weight nếu thêm lên đầu
                if ($array['position'] == 'top') {
                    $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_playlists SET weight=weight+1");
                }

                $respon['data'] = getAppTVData();
            }
        }
    } else {
        $respon['message'] = 'Dữ liệu truy vấn không được chấp nhận';
    }

    nv_jsonOutput($respon);
}

/*
 * Thay đổi thứ tự video trong playlist
 */
if ($nv_Request->isset_request('changeplaylistweight', 'post')) {
    $array = [];
    $array['vid'] = $nv_Request->get_title('vid', 'post', '');
    $array['position'] = $nv_Request->get_title('position', 'post', '');

    $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_playlists WHERE code=" . $db->quote($array['vid']);
    $video = $db->query($sql)->fetch();

    if (!empty($video)) {
        $sql = "SELECT id, weight FROM " . NV_PREFIXLANG . "_" . $module_data . "_playlists WHERE id!=" . $video['id'] . " ORDER BY weight ASC";
        $result = $db->query($sql);
        $weight = (($array['position'] == 'top') ? 2 : 1);
        while ($row = $result->fetch()) {
            $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_playlists SET weight=" . $weight . " WHERE id=" . $row['id']);
            $weight++;
        }

        if ($array['position'] == 'top') {
            // Đưa video lên đầu
            $weight = 1;
        } elseif ($array['position'] == 'bottom') {
            // Đưa video xuống dưới
            $weight = $db->query("SELECT MAX(weight) FROM " . NV_PREFIXLANG . "_" . $module_data . "_playlists")->fetchColumn();
            $weight++;
        }
        $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_playlists SET weight=" . $weight . " WHERE id=" . $video['id']);
    }

    nv_jsonOutput(getAppTVData());
}

/*
 * Xóa video khỏi playlist
 */
if ($nv_Request->isset_request('deletevideofromplaylist', 'post')) {
    $array = [];
    $array['vid'] = $nv_Request->get_title('vid', 'post', '');

    $sql = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_playlists WHERE code=" . $db->quote($array['vid']);
    if ($db->exec($sql)) {
        // Cập nhật lại thứ tự
        $sql = "SELECT id FROM " . NV_PREFIXLANG . "_" . $module_data . "_playlists ORDER BY weight ASC";
        $result = $db->query($sql);
        $weight = 1;
        while ($row = $result->fetch()) {
            $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_playlists SET weight=" . $weight . " WHERE id=" . $row['id']);
            $weight++;
        }
    }

    nv_jsonOutput(getAppTVData());
}

$page_title = $module_info['site_title'];
$key_words = $module_info['keywords'];
$mod_title = $module_info['custom_title'];

$xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
