<?php

/**
 * @Project TAN DUNG RASPBERRY TV
 * @Author PHAN TAN DUNG <phantandung92@gmail.com>
 * @Copyright (C) 2018 PHAN TAN DUNG. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sunday, August 5, 2018 9:53:00 AM GMT+07:00
 */

if (!defined('NV_IS_FILE_MODULES')) {
    die('Stop!!!');
}

$sql_drop_module = array();

$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_playlists";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config";

$sql_create_module = $sql_drop_module;

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_playlists (
 id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
 code varchar(250) NOT NULL DEFAULT '' COMMENT 'Mã video',
 title varchar(250) NOT NULL DEFAULT '' COMMENT 'Tên video',
 channeltitle varchar(250) NOT NULL DEFAULT '' COMMENT 'Tên channel',
 image varchar(255) NOT NULL DEFAULT '' COMMENT 'URL ảnh',
 weight smallint(4) NOT NULL DEFAULT '0' COMMENT 'Thứ tự phát',
 add_time int(11) NOT NULL DEFAULT '0',
 edit_time int(11) NOT NULL DEFAULT '0',
 PRIMARY KEY (id)
) ENGINE=InnoDB";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config (
 config_name varchar(30) NOT NULL,
 config_value varchar(255) NOT NULL DEFAULT '',
 config_comment varchar(255) NOT NULL DEFAULT '',
 UNIQUE KEY config_name (config_name)
)ENGINE=InnoDB";

$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config VALUES
('private_key', 'tandung-raspberry-tv', 'Mã bí mật'),
('remote_url', 'http://192.168.0.2/tv/api.php', 'Địa chỉ API của Tivi'),
('player_state', 'stopped', 'Trạng thái phát của Tivi'),
('tivi_state', 'stopped', 'Có đang active playlist hay dừng. Play có nghĩa đang load trang thì chạy.'),
('next_video_plid', '0', 'ID video sẽ phát tiếp theo do trình điều khiển không chế'),
('next_video_code', '', 'Mã video sẽ phát tiếp theo do trình điều khiển không chế'),
('next_video_title', '', 'Tiêu đề video sẽ phát trực tiếp tiếp theo'),
('current_video_title', '', 'Tên video đang phát'),
('current_video_plid', '0', 'ID video đang phát'),
('current_video_plweight', '0', 'Thứ tự video đang phát')
";
