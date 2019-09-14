<?php

/**
 * get-thumbnail-from-pagepeeker
 * ページのサムネイル画像を取得
 */

include('./common.php');

//外部サイトからのアクセスは拒否
if(! isFromMySite()) {
	echo json_encode(array('From' => $_SERVER['HTTP_REFERER']));
	die();
}

//サムネイル取得元
if(empty($_GET['url'])) {
    echo json_encode(array('url' => 'No set'));
    die();
}
$URLoriginal = h($_GET['url']);
//大きさ（PagePeekerで指定）
if(empty($_GET['size'])) {
    echo json_encode(array('size' => 'No set'));
    die();
}
$size = h($_GET['size']);
if(! isset($PIXEL_SIZE[$size])) {
    echo json_encode(array('size' => 'Do not set this size'));
    die();
}
//base64変換するか？
$base64 = false;
if(! empty($_GET['base64'])
  && ($_GET['base64'] === 'true' || $_GET['base64'] === 'TRUE')) {
    $base64 = true;
}
//OGPを使用使用せず、PagePeeker強制とするか？
$dont_use_ogp = false;
if(! empty($_GET['dont_use_ogp'])
  && ($_GET['dont_use_ogp'] === 'true' || $_GET['dont_use_ogp'] === 'TRUE')) {
    $dont_use_ogp = true;
}

//OGPを取得する
if(! $dont_use_ogp) {
    error_reporting(0);
    $html = file_get_contents($URLoriginal, false, $OPTIONS);
    error_reporting(-1);
    if(empty($html) || $html == '') {
        echo json_encode(array('error' => 'HTTP request failed'));
        die();
    }
    preg_match_all("<meta property=\"og:([^\"]+)\" content=\"([^\"]+)\">", $html, $ogp);
    $image_url = '';
    if(! empty($ogp[1])) {
        $ogp_length = count($ogp[1]);
        for($i = 0; $i < $ogp_length; $i++) {
            if($ogp[1][$i] !== 'image') {
                continue;
            }
            $image_url = $ogp[2][$i];
            break;
        }
    }
    if(! empty($image_url)) {
        $canvas = getImage($image_url, $PIXEL_SIZE[$size]['width'], $PIXEL_SIZE[$size]['height']);
        if(! $base64) {
            //通常出力
            header('Content-Type: image/png');
            imagepng($canvas);
            die();
        } else {
            //base64出力
            sleep(1);
            readfile($URLpagepeeker);
            header('Content-Type: application/json');
            $result = array(
                'base64' => base64_encode($canvas)
            );
            echo json_encode($result);
        }
        imagedestroy($canvas);
        exit();
    }
}

//OGPが取得できないのでPagePeekerから取得
$URLpagepeeker = 'http://free.pagepeeker.com/v2/thumbs.php?size='.$size.'&url='.$URLoriginal;
$ContentLength = 0;

for(
  $i = 0;
  $i < $PAGEPEEKER_TIMEOUT
  && (
    $ContentLength === 0
    || $ContentLength === $PIXEL_SIZE[$size]['size']
  );
  $i++)
{
    if($i > 0) {
        sleep(1);
    }
    $headers = get_headers($URLpagepeeker);  //PagePeekerの生成時間用にわざと指定しています

    $existContentLength = false;
    //Peeking中かどうかを調べるためContent-Lengthを取得する
    foreach($headers as $line) {
        $line_explode = explode(': ', $line);
        if($line_explode[0] === 'Content-Length') {
            $ContentLength = intval($line_explode[1]);
            $existContentLength = true;
            break;
        }
    }

    if(! $existContentLength) {
        //400 Bad requestなどが発生し、Content-Lengthを返さない場合はループは無意味なので即終了する
        echo json_encode(array('error' => $headers[0]));
        die();
    }
}

if(! $base64) {
    //通常出力
    header('Content-Type: image/png');
    readfile($URLpagepeeker);
} else {
    //base64出力
    header('Content-Type: application/json');
    $result = array(
        'base64' => base64_encode(
            file_get_contents($URLpagepeeker)
        )
    );
    echo json_encode($result);
}
exit();

/**
 * 画像を取得してサイズ調整する
 *
 * @param string $image_url 画像取得元
 * @param integer $image_width 画像横幅
 * @param integer $image_height 画像縦幅
 * @return binary サイズ調整した画像
 */
function getImage($image_url, $image_width, $image_height)
{
    // 元画像のファイルサイズを取得
	list($original_image_width, $original_image_height) = getimagesize($image_url);

	//元画像の比率を計算し、高さを設定
	$proportion = $original_image_width / $original_image_height;
	if($original_image_height < $original_image_width) {
		$output_image_width = $image_width;
		$zoom = $image_width / $original_image_width;
		$output_image_height = $original_image_height * $zoom;
	} else {
		$output_image_height = $image_height;
		$zoom = $image_height / $original_image_height;
		$output_image_width = $original_image_width * $zoom;
	}

	// サイズを指定して、背景用画像を生成
	$canvas = imagecreatetruecolor($output_image_width, $output_image_height);

    // ファイル名から、画像インスタンスを生成
    $ext = pathinfo($image_url, PATHINFO_EXTENSION);
    if (
        $ext === 'jpg'
        || $ext === 'JPG'
        || $ext === 'jpeg'
        || $ext === 'JPEG'
    ) {
        $original_image = imagecreatefromjpeg($image_url);
    } elseif (
        $ext === 'gif'
        || $ext === 'GIF'
    ) {
        $original_image = imagecreatefromgif($image_url);
    } else {
        $original_image = imagecreatefrompng($image_url);
    }

	// 背景画像に、画像をコピーする
	imagecopyresampled(
		$canvas,			// 背景画像
		$original_image,	// コピー元画像
		0,		// 背景画像の x 座標
		0,		// 背景画像の y 座標
		0,		// コピー元の x 座標
		0,		// コピー元の y 座標
		$output_image_width,	// 背景画像の幅
		$output_image_height,	// 背景画像の高さ
		$original_image_width,	// コピー元画像ファイルの幅
		$original_image_height	// コピー元画像ファイルの高さ
	);

	return $canvas;
}
