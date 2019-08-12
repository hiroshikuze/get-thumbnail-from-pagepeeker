<?php

/**
 * get-thumbnail-from-pagepeeker
 * サイトのサムネイル画像を取得
 */

include('./common.php');

if(! isFromMySite()) {
	echo json_encode(array('From' => $_SERVER['HTTP_REFERER']));
	exit();
}

if(empty($_GET['url'])) {
    echo json_encode(array('url' => 'No set'));
    exit();
}
if(empty($_GET['size'])) {
    echo json_encode(array('size' => 'No set'));
    exit();
}
$base64 = false;
if(! empty($_GET['base64']) && $_GET['base64']) {
    $base64 = true;
}

$URLoriginal = h($_GET['url']);
$size = h($_GET['size']);
$URLpagepeeker = 'http://free.pagepeeker.com/v2/thumbs.php?size='.$size.'&url='.$URLoriginal;

if(! $base64) {
    //通常出力
    header('Content-Type: image/png');
    readfile($URLpagepeeker);
} else {
    //base64出力
    file_get_contents($URLpagepeeker);
    sleep(1);
    header('Content-Type: application/json');
    $result = array(
        'base64' => base64_encode(file_get_contents($URLpagepeeker))
    );
    echo json_encode($result);
}

exit();