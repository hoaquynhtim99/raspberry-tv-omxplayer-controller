<?php

/**
 * @Project TAN DUNG RASPBERRY TV
 * @Author PHAN TAN DUNG <phantandung92@gmail.com>
 * @Copyright (C) 2018 PHAN TAN DUNG. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sunday, August 5, 2018 9:53:00 AM GMT+07:00
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE')) {
    die('Stop!!!');
}

$module_version = array(
    'name' => 'Trình điều khiển Tivi',
    'modfuncs' => 'main',
    'is_sysmod' => 0,
    'virtual' => 0,
    'version' => '5.0.00',
    'date' => 'Sunday, August 5, 2018 9:53:00 AM GMT+07:00',
    'author' => 'VINADES <contact@vinades.vn>',
    'note' => '',
    'uploads_dir' => array(
        $module_upload
    )
);
