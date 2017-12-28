## MIT-BIH  心律不整 公開資料庫 Web 實作範例

#### 系統需求
(必備)
1. WAMP or XAMPP (Windows), Linux (LAMP)
2. Apache 2.4.7 以上版本
3. MySQL 5.7.19 或 MariaDB
4. PHP 5.6.31 以上版本
5. 支援 PDO Driver, 需搭配使用的資料庫不同, 使用不同的驅動，請參考 PHP PDO Driver

(選用)
圖形化 SQL 介面, 例如: MySQL Workbench
Linux 系統, 支援 Shell script 可以安裝 WFDB 工具

#### 安裝步驟
請先下載 Github 上所有的檔案，並將 arrhythmia 專案放上您的 `www` 目錄內

並下載 49 個SQL檔案，並且依序執行，使用圖形化介面，手動匯入資料庫

請進入 `arrhythmia/server/connect.php` 內 17 行處，更改您的資料庫帳號、密碼及主機

完成後請開啟您的瀏覽器 (chrome、firefox)，輸入`localhost:prot/arrhythmia`
即可開始登入。

![image](https://github.com/FrankWeiHuang/Arrhythmia/blob/master/image/login.png)

可以使用預設 Username: peter Password: 123 進行登入測試
或點擊註冊紐新建一個 User

![image](https://github.com/FrankWeiHuang/Arrhythmia/blob/master/image/register.png)

登入系統後，請您按住 Control 紐，進行下拉式紀錄選單多選

並且請依照規定時間格式輸入，起始時間與終止時間。

如: 0:00.000 到 30:00.000，請不要輸入範圍太廣的數字

由於記憶體有限，搜尋將導致緩慢

![image](https://github.com/FrankWeiHuang/Arrhythmia/blob/master/image/search.png)

搜尋完成後，畫面將個別顯示每個所選的紀錄之心電波形圖

包含 v1 與 MLII 兩種輸入源

![image](https://github.com/FrankWeiHuang/Arrhythmia/blob/master/image/result.png)
![image](https://github.com/FrankWeiHuang/Arrhythmia/blob/master/image/result_1.png)

#### 資料庫內容

資料庫僅一個 database，為 memberdb

內含 49 個 table

1  個 member 負責記錄帳號資訊
48 個 csv 編號負責儲存心電圖數據

memeber 表內
欄位有 user，pass，id，id 為自動編號及主鍵
全部欄位均不得設空值

csv 表
欄位有 time，mlii，v5，id
分別記錄時間與兩種輸入源
id 為自動編號及主鍵

 time 為 text 型態
 mlii、v5 為 float 型態

