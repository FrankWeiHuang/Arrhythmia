## MIT-BIH  心律不整 公開資料庫 Web 實作範例

#### 資料來源
本資料使用 MIT-BIH 公開資料，並使用 PhysioBank 提供之工具 WFDB
下載 48 個 csv 檔案並匯入至資料庫

WFDB 指令 `rdsamp -r mitdb/table -c -H -f 0 -t 60 -v -pd >table.csv`

#### 系統需求
(必備)
1. WAMP or XAMPP (Windows), Linux (LAMP)
2. Apache 2.4.7 以上版本
3. MySQL 5.7.19 或 MariaDB
4. PHP 5.6.31 以上版本
5. 支援 PDO Driver, 需搭配使用的資料庫不同, 使用不同的驅動，請參考 PHP PDO Driver
6. 若 CDN 有異狀請檢查 `header.php` 內 bootstrap css link 及 `waveforms.php` 內 chart.js script link
![image](https://github.com/FrankWeiHuang/Arrhythmia/blob/master/images/flow.png)

(選用)
圖形化 SQL 介面, 例如: MySQL Workbench
Linux 系統, 支援 Shell script 可以安裝 WFDB 工具

#### 安裝步驟
請先下載 Github 上所有的檔案，並將 arrhythmia 專案放上您的 `www` 目錄內

請先創建一個愈置放資料的資料庫
將 `import` 目錄內的 49 個SQL檔案，手動匯入資料庫
![image](https://github.com/FrankWeiHuang/Arrhythmia/blob/master/images/import.png)
![image](https://github.com/FrankWeiHuang/Arrhythmia/blob/master/images/dbinfo.png)
![image](https://github.com/FrankWeiHuang/Arrhythmia/blob/master/images/tableinfo.png)



請進入 `arrhythmia/server/connect.php` 內 17 行處，更改您的資料庫主機、帳號、密碼、資料庫名稱

完成後請開啟您的瀏覽器 (chrome、firefox)，輸入`localhost:prot/arrhythmia`
即可開始登入。

![image](https://github.com/FrankWeiHuang/Arrhythmia/blob/master/images/login.png)

可以使用預設 Username: peter Password: 123 進行登入測試
或點擊註冊紐新建一個 User

![image](https://github.com/FrankWeiHuang/Arrhythmia/blob/master/images/register.png)

登入系統後，請您按住 Control 紐，進行下拉式紀錄選單多選

並且請依照規定時間格式輸入，起始時間與終止時間。

如: 0:00.000 到 30:00.000，請不要輸入範圍太廣的數字

由於記憶體有限，搜尋將導致緩慢

![image](https://github.com/FrankWeiHuang/Arrhythmia/blob/master/images/search.png)

搜尋完成後，畫面將個別顯示每個所選的紀錄之心電波形圖

包含 v1 與 MLII 兩種輸入源

![image](https://github.com/FrankWeiHuang/Arrhythmia/blob/master/images/result_1.png)
![image](https://github.com/FrankWeiHuang/Arrhythmia/blob/master/images/result_2.png)

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

#### 心得
本次製作，使用了 php、mySQL、bootstrap、chart.js、wfdb、apache 技術，
此作品兩大困難點 - 網頁版本提供的資料，並非完整版本，所以須而外安裝
一套可以安裝 wfdb 的系統，由於 wfdb 只支援 linux，起初我使用 Cygwin
安裝，但發現編譯成功後，卻無法呼叫 mitdb 的資料，因此我改使用 ubuntu
安裝，並使用 shell script 撰寫指令下載，之後再將每個66萬筆的csv資料匯入
mysql內，由於圖形化的介面匯入，速度非常緩慢，因此可參考`ex-import.sql`
檔案內，匯入的方式，先建立 table，在手動下指令匯入。

第二大困難處在於 waveforms 資料該如何繪製呈現，我找尋許多套 js lib
都並非很適合，最後採用 chart.js 這套 lib 使用