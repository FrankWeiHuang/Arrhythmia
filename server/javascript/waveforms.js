// 使用命名空間將 jQuery 符號變數，設為區域變數
(function($) {

    // 取得 JSON 檔案，並且使用 callback function 得到內部的資料
    $.getJSON('JSON_ARRHYTHMIA.php', function(Arrhythmia) {

        // 列舉所有 Arrhythmia 內 records 的資料，Index 為 records 陣列註標
        $.each(Arrhythmia.records, function(index, record) {

            // 新增一組電壓物件，分別用於儲存 mlii 與 mV5 兩種輸入
            var voltage = {
                mlii: [],
                v5: []
            };

            // 列舉 record 內每筆資料 
            for (var i = 0; i < record.length; ++i) {
                voltage.mlii[i] = [];
                voltage.v5[i] = [];

                // 將取得的數值轉為浮點數，再存入 voltage 物件
                voltage.mlii[i].y = parseFloat(record[i].mlii);
                voltage.v5[i].y = parseFloat(record[i].v5);
            }

            // 於 chart-container 標籤後，加入自訂標籤並且以 table name 編序
            $('#chart-container').append('<div id="waveforms-' + Arrhythmia.numbers[index] +
                '" style="height: 370px; width: 100%;"></div>');

            // 開始建立繪圖物件 chart，並存入資料，參考 chartjs.org
            var chart = new CanvasJS.Chart("waveforms-" + Arrhythmia.numbers[index], {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "Record - " + Arrhythmia.numbers[index]
                },
                axisY: {
                    includeZero: false
                },
                data: [{
                    type: "line",
                    showInLegend: true,
                    name: "MLII",
                    dataPoints: voltage.mlii
                }, {
                    type: "line",
                    showInLegend: true,
                    name: "V1",
                    dataPoints: voltage.v5,
                }],
            });

            // 圖表產生
            chart.render();
        });
    });
})(jQuery);