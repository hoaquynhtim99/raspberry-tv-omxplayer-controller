<?php

/**
 * @Project TAN DUNG RASPBERRY TV
 * @Author PHAN TAN DUNG <phantandung92@gmail.com>
 * @Copyright (C) 2018 PHAN TAN DUNG. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sunday, August 5, 2018 9:53:00 AM GMT+07:00
 */

if (!defined('NV_SYSTEM')) {
    die('Stop!!!');
}

define('NV_IS_MOD_RTV', true);

// Cấu hình module
$global_array_config = [];
$sql = 'SELECT config_name, config_value FROM ' . NV_PREFIXLANG . '_' . $module_data . '_config';
$result = $db->query($sql);
while ($row = $result->fetch()) {
    $global_array_config[$row['config_name']] = $row['config_value'];
}

/**
 * @param string $data
 * @return string
 */
function encrypt($data)
{
    global $global_array_config;

    $data = openssl_encrypt($data, 'aes-256-cbc', $global_array_config['private_key'], 0, $global_array_config['private_key']);
    return strtr($data, '+/=', '-_,');
}

/**
 * @return array[]
 */
function getAppTVData()
{
    global $global_array_config, $module_data, $db;

    $data = [
        'playlists' => [],
        'player' => []
    ];

    // Lấy playlist
    $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_playlists ORDER BY weight ASC";
    $result = $db->query($sql);

    while ($row = $result->fetch()) {
        $data['playlists'][$row['weight']] = [
            'id' => $row['id'],
            'code' => $row['code'],
            'title' => $row['title'],
            'channeltitle' => $row['channeltitle'],
            'image' => $row['image']
        ];
    }

    $data['player']['tv_state'] = $global_array_config['tivi_state'];
    $data['player']['player_state'] = $global_array_config['player_state'];
    $data['player']['playlistitems'] = sizeof($data['playlists']);
    $data['player']['vtitle'] = $global_array_config['current_video_title'];

    return $data;
}

/**
 * @param string $cmd
 * @param string $videocode
 * @return array|mixed|boolean
 */
function controlRaspberry($cmd, $videocode = '')
{
    global $global_array_config, $global_config;

    $post_value = '';
    if ($cmd == 'play' and !empty($videocode)) {
        $post_value = trim(shell_exec('youtube-dl -f 22 -g ' . escapeshellarg('https://www.youtube.com/watch?v=' . trim($videocode))));
    }

    $post_data = [
        'cmd' => $cmd,
        'value' => $post_value
    ];
    $post_data = encrypt(serialize($post_data));

    $NV_Http = new NukeViet\Http\Http($global_config, NV_TEMP_DIR);
    $args = array(
        'body' => [
            'data' => $post_data
        ]
    );
    $respon = $NV_Http->post($global_array_config['remote_url'], $args);
    if (!empty($respon['body'])) {
        $respon = nv_object2array(json_decode($respon['body']));
    } else {
        $respon = [];
    }

    return $respon;
}
