# 作品簡介

# 使用技術

後端：

- PHP with Laravel 8
- [Telegram bot PHP SDK](https://github.com/php-telegram-bot/core/wiki)

前端：

- Vue 2 (Axios), 從Vue CLI產生專案
- [版型來源](https://www.free-css.com/assets/files/free-css-templates/preview/page239/fluid-gallery/)，將該版型改寫成Vue的component，及整合原本舊的js檔案

伺服器、資料庫：

- AWS EC2
- AWS S3 (放照片圖檔)
- MySQL ( on AWS RDS)
- Redis (on AWS ElastiCache)

其他：

- [Github](https://github.com/i29686112/gallery)
- Unit test with mockery及Laravel [HTTP Tests](https://laravel.com/docs/8.x/http-tests)
- Development stacks : PHP Storm + Homestead ( LNMP ) + ngrok

# 專案架構

大部份都是Laraval的專案架構，以下列幾個比較重要的

### 前端位置

ux/*

### 前端主要vue檔

ux/src/views/Gallery.vue

### 版型原始的html+js檔(未改寫成Vue前)

ux-origin/

### Laravel http test 路徑

tests/Feature/*

### Unit test路徑

tests/Unit/*

比較詳細的unit test檔tests/Unit/App/Classes/CustomCommands/DeletePhotoTest.php

# 專案說明

因為我本來就有底片攝影的興趣，所以建立了一個網站可以把底片拍出來的成果，根據底片進行分類

![前台樣式](../master/docs/frontendStyle.png)
前台樣式

點擊某個底片後，就會顯示出該底片下的成果照

![Gallery樣式](../master/docs/galleryUploaded.png)
Gallery樣式

後台方面，使用telegram進行上傳照片的功能，把想傳的照片，加入底片名稱後，傳送給bot，它就會自動存入及顯示在前端的gallery中

![上傳照片，Cpation填入底片名稱](../master/docs/uploadImage.png)
上傳照片，Cpation填入底片名稱

![就能從前台，看到該照片出現在對應的底片Gallery下](../master/docs/galleryUploaded.png)

就能從前台，看到該照片出現在對應的底片Gallery下

也可以透過bot得到當前某個底片下，有什麼照片

![顯示底片下的照片清單](../master/docs/imageList.png)
顯示底片下的照片清單

如果要刪除照片，也可以透過指令直接刪除

![透過指令刪除照片，及確認底片已被刪除](../master/docs/deleteImage.png)
透過指令刪除照片，及確認底片已被刪除
