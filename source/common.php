<?php

/**
 * get-thumbnail-from-pagepeeker
 * 各種関数部分
 */

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
