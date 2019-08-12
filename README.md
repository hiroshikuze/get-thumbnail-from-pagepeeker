Get thumbnail from pagepeeker
====

This API by PHP that get the thumbnail images of the specified URL from [pagepeeker](https://pagepeeker.com/) and, tunnel or convert to it base64.  

## Description

August 2019, free.pagepeeker.com cannot obtain thumbnail images via SSL.  
This API by PHP is get the thumbnail images from free.pagepeeker.com and, tunnel or converts them to base64.  

## Example of use

[![Paste Title / ジグソーTools ～ 指定したWebページのURLを&lt;a&gt;タグで囲むWebサービス](image/sample.jpg)](https://kuje.kousakusyo.info/tools/PasteTitle/)  
Thumbnail acquisition part in [Paste Title](https://kuje.kousakusyo.info/tools/PasteTitle/) (HTML or Markdown).  

## Requirement

This program has been tested with PHP7.  

## Usage

```
get_thumbnail.php?size=[size]&base64=[base64]&url=[url]
```

|No|Item|Type|Must|Comment|Example|
|--:|:--|:--|:--|:--|:--|
|1|size|string|yes|Thumbnail size.<br>Select t,s,m,l,x.<br>See [pagepeeker API document](https://pagepeeker.com/website-thumbnails-api/).|t|
|2|base64|boolean|yes|Is the return value acquired in base64?|true|
|3|url|string|no|Thumbnail acquisition source.|[http://bit.ly/2ZVDTyD](http://bit.ly/2ZVDTyD)|

## Install

Put common.php and thumbnail.php in the same folder.

## Licence

[MIT](https://github.com/hiroshikuze/get-thumbnail-from-pagepeeker/blob/master/LICENSE)

## Author

[hiroshikuze](https://github.com/hiroshikuze)

## Donation

[Author's wish list by Amazon(Japanese)](https://www.amazon.jp/hz/wishlist/ls/5BAWD0LZ89V9?ref_=wl_share)
