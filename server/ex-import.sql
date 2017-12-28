-- path example D:\\wamp64\\www\\arrhythmia\\MIT-BIH\\111.csv
-- 導入 csv 參考方式，或可使用 shell script 撰寫導入

-- csv 導入語法，忽略前兩行，並且使用單引號當作讀取資料的分隔
LOAD DATA LOCAL INFILE  'path'
INTO TABLE `table name`
CHARACTER SET UTF8
FIELDS TERMINATED BY ','
ENCLOSED BY "'"
LINES TERMINATED BY '\n'
IGNORE 2 LINES;

-- 建立資料表，包含 time、mlii、v5、id 欄位，其中 id 為主鍵
CREATE TABLE `memberdb`.`table name` (
  `time` TEXT NOT NULL,
  `mlii` FLOAT NOT NULL,
  `v5` FLOAT NOT NULL,
  `id` INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`));