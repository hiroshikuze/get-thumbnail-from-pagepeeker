<?php

/**
 * get-thumbnail-from-pagepeeker
 * 各種関数部分
 */

/**
 * file_get_contents用オプション値
 */
$OPTIONS = stream_context_create(
    array('ssl' =>
        array(
            'verify_peer'      => false,
            'verify_peer_name' => false
        )
    )
);

/**
 * 画像サイズ
 */
$PIXEL_SIZE = array(
    't' => array(
        'width' => 90,
        'height' => 68,
        'size' => 3431
    ),
    's' => array(
        'width' => 120,
        'height' => 90,
        'size' => 5008
    ),
    'm' => array(
        'width' => 200,
        'height' => 150,
        'size' => 8030
    ),
    'l' => array(
        'width' => 400,
        'height' => 300,
        'size' => 16216
    ),
    'x' => array(
        'width' => 480,
        'height' => 360,
        'size' => 19773
    )
);

/**
 * PagePeeker:タイムアウトとする
 */
$PAGEPEEKER_TIMEOUT = 30;

/**
 * 自サイトからのアクセスか？
 * @return boolean 自サイトからのアクセスか？(true===自サイトからのアクセス)
 */
function isFromMySite() {
    $host = $_SERVER['HTTP_REFERER'];
    $str = parse_url($host);
    if(empty($host) || stristr($str['host'], $_SERVER['SERVER_NAME'])) {
        return true;
    }
    return false;
}

/**
 * 値を安全なものにする
 * @param string $original オリジナル値
 * @return string 加工後
 */
function h($original)
{
	return htmlspecialchars($original, ENT_QUOTES, 'UTF-8');
}
