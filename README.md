Get thumbnail from PagePeeker
====

The PHP by API to get the thumbnail of the specified page.  

## Description

August 2019, free.pagepeeker.com cannot obtain thumbnail images via SSL.  
The API, If OGP is not specified, a page thumbnail is generated with [PagePeeker](https://pagepeeker.com/), processed to the specified size, converted to base64 and output.  

## Example of use

[![Paste Title / ジグソーTools ～ 指定したWebページのURLを&lt;a&gt;タグで囲むWebサービス](image/sample.jpg)](https://kuje.kousakusyo.info/tools/PasteTitle/)  
Thumbnail acquisition part in [Paste Title](https://kuje.kousakusyo.info/tools/PasteTitle/) (HTML or Markdown).  

## Requirement

This program has been tested with PHP7.  

## Usage

```shell
get_thumbnail.php?size=[size]&base64=[base64]&dont_use_ogp=[dont_use_ogp]&url=[url]
```

|No|Item|Type|Must|Comment|Example|
|--:|:--|:--|:--|:--|:--|
|1|size|string|yes|Thumbnail size.<br>Select t,s,m,l,x.<br>See [PagePeeker API document](https://pagepeeker.com/website-thumbnails-api/).|t|
|2|base64|boolean|yes|Is the return value acquired in base64?|true|
|3|dont_use_ogp|boolean|no|Force PagePeeker to generate thumbnails without using OGP.|false(default)|
|4|url|string|yes|Thumbnail acquisition source.|[http://bit.ly/2ZVDTyD](http://bit.ly/2ZVDTyD)|

## Install

Put common.php and thumbnail.php in the same folder.

## Test

Use [postman](https://www.getpostman.com/), and import ["test/GitHub.postman_collection.json"](test/GitHub.postman_collection.json).

## Licence

[MIT](https://github.com/hiroshikuze/get-thumbnail-from-pagepeeker/blob/master/LICENSE)

## Author

[hiroshikuze](https://github.com/hiroshikuze)

## Donation

[Author's wish list by Amazon(Japanese)](https://www.amazon.jp/hz/wishlist/ls/5BAWD0LZ89V9?ref_=wl_share)
