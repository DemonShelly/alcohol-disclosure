# Alcohol-Disclosure／酒4要公開

## Demo

https://shellywu.000webhostapp.com/alcohol_open/board.php

## Discription  
這是一個酒類資訊公開平台，提供給網友回報各地所販賣的酒款、價錢、內容物、評價等資訊，讓酒類愛好者可以查詢參考、分享彼此的心得。

## Function  

#### 產品展示部分
  * 依不同種類排序商品
  * 搜尋商品
  * 查看產品詳細資訊
  * 查看各地酒專販售資訊
  * 查看評價
#### 會員管理部分
  * 訪客可以查看產品資訊、評價
  * 一般會員登入後可以回報販售資訊、新增評價
  * 管理員登入後可以新增酒款資訊、刪除酒款

## 各支程式用途
- board.php：依據酒種分類，可點擊進入到不同的頁面（viewBoard.php）。
- viewBoard.php：在不同酒種下細分類型並陳列產品，一次預設陳列25個產品。
- product.php：呈現產品的詳細資訊。
- review.php：回報對該產品的評價分數。
- return.php：回報販售該產品的酒專地址、價錢等資訊。
- login.php：登入頁面。
- logout.php：登出頁面。
- register.php：註冊會員頁面。
-  revise.php：修改會員密碼、暱稱等資訊。
- search.php：搜尋產品。
- ajax_loadingmore.php：載入更多產品，一次載入25個。
- ajax_newal_showkind.php：新增產品時，動態出現相應的酒款子分類。
- ajax_ranking.php：改變產品陳列的排序方法。
- ajax_review_ranking.php：改變評價的陳列排序。
- ajax_showreturn.php：呈現網友所回報的資訊，可依照地區查看。
- ajax_showreview.php：呈現網友對產品的評價。
- new_al.php：管理員可以新增產品。
- del.php：管理員可以刪除產品。
