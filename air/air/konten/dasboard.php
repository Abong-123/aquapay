<?php
if($level == "admin") {
?>
<div class="row mb-3" id="pilih_waktu">
<div class="col-xl-3 cok-md-10">
    <label for="sel1" class="form-label">Pilih Waktu:</label>
    <select class="form-select" id="sel1" name="pilih_waktu">
    <option>Bulan</option>
    <?php
    for ($i = 1; $i <= 12; $i++) {
        if ($i < 10) $i = '0' . $i;
        echo "<option value=" . date("Y") . "-" . $i . ">" . $air->bln($i) . " ". date("Y") . "</option>";
    }
    ?>
    </select>
</div>

</div>
<div class="row" id="summary">
<div class="col-xl-3 col-md-6">
    <div class="card bg-primary text-white mb-4">
        <div class="card-body d-flex justify-content-center">
            <h1></h1>
            <div class="ms-3">orang</div>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-center">
            <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
            <div class="small text-white">Pelanggan</div>
        </div>
    </div>
</div>
<div class="col-xl-3 col-md-6">
    <div class="card bg-warning text-white mb-4">
        <div class="card-body d-flex justify-content-center">
                <h1></h1>
                <div class="ms-3">m<sup>3</sup></div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-center">
                <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
                <div class="small text-white">Pemakaian air</div>
        </div>
    </div>
</div>
<div class="col-xl-3 col-md-6">
    <div class="card bg-success text-white mb-4">
        <div class="card-body d-flex justify-content-center">
                <h1></h1>
                <div class="ms-3">warga</div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-center">
                <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
            <div class="small text-white">Sudah dicatat</div>
        </div>
    </div>
</div>
<div class="col-xl-3 col-md-6">
    <div class="card bg-danger text-white mb-4">
        <div class="card-body d-flex justify-content-center">
            <h1></h1>
            <div class="ms-3">warga</div>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-center">
            <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
        <div class="small text-white">Belum dicatat</div>
    </div>
</div>
</div>
<div class="row" id="chartt">
<div class="col-xl-6">
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-area me-1"></i>
            Total Pemkaian Air <span id="total_pemakaian_air"> </span>
        </div>
        <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
    </div>
</div>
<div class="col-xl-6">
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-bar me-1"></i>
            Jumlah Rumah Kost dan Rumah Tinggal 
        </div>
        <div class="card-body"><canvas id="myPieChart" width="100%" height="40"></canvas></div>
    </div>
</div>
<div class="col-xl-6">
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-area me-1"></i>
            Total Tagihan Air <span id="total_tagihan_air"> </span>
        </div>
        <div class="card-body"><canvas id="myAreaChart2" width="100%" height="40"></canvas></div>
    </div>
</div>
<div class="col-xl-6">
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-area me-1"></i>
            Total Pemasukan <span id="total_pemasukan"> </span>
        </div>
        <div class="card-body"><canvas id="myAreaChart3" width="100%" height="40"></canvas></div>
    </div>
</div>
<div class="col-xl-6">
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-area me-1"></i>
            Jumlah Warga Tercatat
        </div>
        <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
    </div>
</div>
<div class="col-xl-6">
    <div class="card mb-4">
        <div class="card-header text-danger">
            <i class="fas fa-chart-area me-1"></i>
            Jumlah Warga Belum Tercatat
        </div>
        <div class="card-body"><canvas id="myBarChart2" width="100%" height="40"></canvas></div>
    </div>
</div>
<div class="col-xl-6">
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-area me-1"></i>
            Jumlah Warga Sudah Lunas
        </div>
        <div class="card-body"><canvas id="myBarChart3" width="100%" height="40"></canvas></div>
    </div>
</div>
<div class="col-xl-6">
    <div class="card mb-4">
        <div class="card-header text-danger">
            <i class="fas fa-chart-area me-1"></i>
            Jumlah Warga Belum Lunas
        </div>
        <div class="card-body"><canvas id="myBarChart4" width="100%" height="40"></canvas></div>
    </div>
</div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const select = document.getElementById("sel1");
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const currentValue = `${year}-${month}`;

    // Cek dan set value jika cocok
    for (let i = 0; i < select.options.length; i++) {
        if (select.options[i].value === currentValue) {
            select.selectedIndex = i;
            break;
        }
    }
    $("#sel1").trigger("change");
});
    $(document).ready(function () {
    uri=window.location.href;
    e=uri.split("=");
    console.log("URI: "+uri+"e[1]:"+e[1]);
    const select = $("#sel1");
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const currentValue = `${year}-${month}`;

    // Set value default ke bulan sekarang
    select.val(currentValue);

    $("#pilih_waktu select[name='pilih_waktu']").on("change", function () {
        let bln = $(this).val(); // ambil nilai yang dipilih
        let formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            });
            console.log("Dipilih: " + bln);
            $.ajax({
                type: "post",
                url: "../konten/ajax.php",
                data: {p:"summary",t:bln},
                dataType: "json",
            })
            .done(function(response){
                console.log("data: " +response[0].jml_pelanggan); // untuk cek hasilnya
                blm_dicatat=response[0].jml_pelanggan-response[2].tercatat;
                $("#summary .bg-primary h1").text(response[0].jml_pelanggan);
                $("#summary .bg-warning h1").text(response[1].pemakaian);
                $("#summary .bg-success h1").text(response[2].tercatat);
                $("#summary .bg-danger h1").text(blm_dicatat);
                $("#total_pemakaian_air").text(response[3].total_pemakaian + " m³");
                $("#total_tagihan_air").text(formatter.format(response[4].total_tagihan));
                $("#total_pemasukan").text(formatter.format(response[5].sdh_lunass));
            })
            .fail(function(xhr, status, error){
                console.log("ada error nich", xhr.responseText); // biar tahu kenapa error
            });
    });
    // Trigger change biar AJAX jalan otomatis
        select.trigger("change");
        var user = "<?= $_SESSION['user'] ?? 'guest' ?>";
        $.ajax({
            type: "POST",
            url: "../konten/ajax.php",
            data: { p: "chart_line1", y:user},
            dataType: "json",
            cache: false
        })
        .done(function(respon) {
            console.log("respon",+ respon);

            sumbuX=respon.filter((num,index)=>index % 2 == 0);
            sumbuY=respon.filter((num,index)=>index % 2 !=0);
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#292b2c';

            // Area Chart Example
            var ctx = document.getElementById("myAreaChart");
            var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: sumbuX,
                datasets: [{
                label: "Pemakaian",
                lineTension: 0.3,
                backgroundColor: "rgba(2,117,216,0.2)",
                borderColor: "rgba(2,117,216,1)",
                pointRadius: 5,
                pointBackgroundColor: "rgba(2,117,216,1)",
                pointBorderColor: "rgba(255,255,255,0.8)",
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(2,117,216,1)",
                pointHitRadius: 50,
                pointBorderWidth: 2,
                data: sumbuY,
                }],
            },
            options: {
                scales: {
                xAxes: [{
                    time: {
                    unit: 'date'
                    },
                    gridLines: {
                    display: false
                    },
                    ticks: {
                    maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                    min: 0,
                    max: 600,
                    maxTicksLimit: 5
                    },
                    gridLines: {
                    color: "rgba(0, 0, 0, .125)",
                    }
                }],
                },
                legend: {
                display: false
                }
            }
            });
        })
        .fail(function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response text:", xhr.responseText);
        }); 
        $.ajax({
        type: "POST",
        url: "../konten/ajax.php",
        data: { p: "chart_pie" },
        dataType: "json"
        }).done(function (res) {
            let labels = [];
            let data = [];

            res.forEach(item => {
                labels.push(item.tipe);     // "RT" atau "kost"
                data.push(item.jumlah);     // jumlah masing-masing
            });
            var ctx = document.getElementById("myPieChart");
            new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: [
                        "#FF0000", "#0000FF"
                    ],
                }],
            },
            options: {
                responsive: true,
                legend: {
                    position: 'bottom'
                }
            }
        });
        });
        $.ajax({
            type: "POST",
            url: "../konten/ajax.php",
            data: { p: "chart_line2", y:user},
            dataType: "json",
            cache: false
        })
        .done(function(respon) {
            console.log("respon",+ respon);

            sumbuX=respon.filter((num,index)=>index % 2 == 0);
            sumbuY=respon.filter((num,index)=>index % 2 !=0);
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#292b2c';

            // Area Chart Example
            var ctx = document.getElementById("myAreaChart2");
            var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: sumbuX,
                datasets: [{
                label: "Tagihan",
                lineTension: 0.3,
                backgroundColor: "rgba(2,117,216,0.2)",
                borderColor: "rgba(2,117,216,1)",
                pointRadius: 5,
                pointBackgroundColor: "rgba(2,117,216,1)",
                pointBorderColor: "rgba(255,255,255,0.8)",
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(2,117,216,1)",
                pointHitRadius: 50,
                pointBorderWidth: 2,
                data: sumbuY,
                }],
            },
            options: {
                scales: {
                xAxes: [{
                    time: {
                    unit: 'date'
                    },
                    gridLines: {
                    display: false
                    },
                    ticks: {
                    maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                    min: 0,
                    max: 1000000,
                    maxTicksLimit: 5
                    },
                    gridLines: {
                    color: "rgba(0, 0, 0, .125)",
                    }
                }],
                },
                legend: {
                display: false
                }
            }
            });
        })
        .fail(function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response text:", xhr.responseText);
        });

        $.ajax({
            type: "POST",
            url: "../konten/ajax.php",
            data: { p: "chart_line3", y:user},
            dataType: "json",
            cache: false
        })
        .done(function(respon) {
            console.log("respon",+ respon);

            sumbuX=respon.filter((num,index)=>index % 2 == 0);
            sumbuY=respon.filter((num,index)=>index % 2 !=0);
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#292b2c';

            // Area Chart Example
            var ctx = document.getElementById("myAreaChart3");
            var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: sumbuX,
                datasets: [{
                label: "LUNAS",
                lineTension: 0.3,
                backgroundColor: "rgba(2,117,216,0.2)",
                borderColor: "rgba(2,117,216,1)",
                pointRadius: 5,
                pointBackgroundColor: "rgba(2,117,216,1)",
                pointBorderColor: "rgba(255,255,255,0.8)",
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(2,117,216,1)",
                pointHitRadius: 50,
                pointBorderWidth: 2,
                data: sumbuY,
                }],
            },
            options: {
                scales: {
                xAxes: [{
                    time: {
                    unit: 'date'
                    },
                    gridLines: {
                    display: false
                    },
                    ticks: {
                    maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                    min: 0,
                    max: 800000,
                    maxTicksLimit: 5
                    },
                    gridLines: {
                    color: "rgba(0, 0, 0, .125)",
                    }
                }],
                },
                legend: {
                display: false
                }
            }
            });
        })
        .fail(function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response text:", xhr.responseText);
        });

        $.ajax({
            type: "POST",
            url: "../konten/ajax.php",
            data: { p: "chart_bar", y:user},
            dataType: "json",
            cache: false
        })
        .done(function(respon) {
            console.log("respon",+ respon);
            sumbuX=respon.filter((num,index)=>index % 2 == 0);
            sumbuY=respon.filter((num,index)=>index % 2 !=0);
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#292b2c';

            // Bar Chart Example
            var ctx = document.getElementById("myBarChart");
            var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: sumbuX,
                datasets: [{
                label: "Bulan",
                backgroundColor: "rgba(2,117,216,1)",
                borderColor: "rgba(2,117,216,1)",
                data: sumbuY,
                }],
            },
            options: {
                scales: {
                xAxes: [{
                    time: {
                    unit: 'month'
                    },
                    gridLines: {
                    display: false
                    },
                    ticks: {
                    maxTicksLimit: 6
                    }
                }],
                yAxes: [{
                    ticks: {
                    min: 0,
                    max: 60,
                    maxTicksLimit: 5
                    },
                    gridLines: {
                    display: true
                    }
                }],
                },
                legend: {
                display: false
                }
            }
            });
        })
        .fail(function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response text:", xhr.responseText);
        });

        $.ajax({
            type: "POST",
            url: "../konten/ajax.php",
            data: { p: "chart_bar2", y:user},
            dataType: "json",
            cache: false
        })
        .done(function(respon) {
            console.log("respon",+ respon);
            sumbuX=respon.filter((num,index)=>index % 2 == 0);
            sumbuY=respon.filter((num,index)=>index % 2 !=0);
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#292b2c';

            // Bar Chart Example
            var ctx = document.getElementById("myBarChart2");
            var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: sumbuX,
                datasets: [{
                label: "Bulan",
                backgroundColor: "rgba(2,117,216,1)",
                borderColor: "rgba(2,117,216,1)",
                data: sumbuY,
                }],
            },
            options: {
                scales: {
                xAxes: [{
                    time: {
                    unit: 'month'
                    },
                    gridLines: {
                    display: false
                    },
                    ticks: {
                    maxTicksLimit: 6
                    }
                }],
                yAxes: [{
                    ticks: {
                    min: 0,
                    max: 60,
                    maxTicksLimit: 5
                    },
                    gridLines: {
                    display: true
                    }
                }],
                },
                legend: {
                display: false
                }
            }
            });
        })
        .fail(function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response text:", xhr.responseText);
        });

        $.ajax({
            type: "POST",
            url: "../konten/ajax.php",
            data: { p: "chart_bar3", y:user},
            dataType: "json",
            cache: false
        })
        .done(function(respon) {
            console.log("respon",+ respon);
            sumbuX=respon.filter((num,index)=>index % 2 == 0);
            sumbuY=respon.filter((num,index)=>index % 2 !=0);
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#292b2c';

            // Bar Chart Example
            var ctx = document.getElementById("myBarChart3");
            var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: sumbuX,
                datasets: [{
                label: "Bulan",
                backgroundColor: "rgba(2,117,216,1)",
                borderColor: "rgba(2,117,216,1)",
                data: sumbuY,
                }],
            },
            options: {
                scales: {
                xAxes: [{
                    time: {
                    unit: 'month'
                    },
                    gridLines: {
                    display: false
                    },
                    ticks: {
                    maxTicksLimit: 6
                    }
                }],
                yAxes: [{
                    ticks: {
                    min: 0,
                    max: 60,
                    maxTicksLimit: 5
                    },
                    gridLines: {
                    display: true
                    }
                }],
                },
                legend: {
                display: false
                }
            }
            });
        })
        .fail(function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response text:", xhr.responseText);
        });

        $.ajax({
            type: "POST",
            url: "../konten/ajax.php",
            data: { p: "chart_bar4", y:user},
            dataType: "json",
            cache: false
        })
        .done(function(respon) {
            console.log("respon",+ respon);
            sumbuX=respon.filter((num,index)=>index % 2 == 0);
            sumbuY=respon.filter((num,index)=>index % 2 !=0);
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#292b2c';

            // Bar Chart Example
            var ctx = document.getElementById("myBarChart4");
            var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: sumbuX,
                datasets: [{
                label: "Bulan",
                backgroundColor: "rgba(2,117,216,1)",
                borderColor: "rgba(2,117,216,1)",
                data: sumbuY,
                }],
            },
            options: {
                scales: {
                xAxes: [{
                    time: {
                    unit: 'month'
                    },
                    gridLines: {
                    display: false
                    },
                    ticks: {
                    maxTicksLimit: 6
                    }
                }],
                yAxes: [{
                    ticks: {
                    min: 0,
                    max: 60,
                    maxTicksLimit: 5
                    },
                    gridLines: {
                    display: true
                    }
                }],
                },
                legend: {
                display: false
                }
            }
            });
        })
        .fail(function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response text:", xhr.responseText);
        });

});
</script>

<?php
} elseif($level == "petugas")  {
?>
<div class="row mb-3" id="pilih_waktu">
<div class="col-xl-3 cok-md-10">
    <label for="sel1" class="form-label">Pilih Waktu:</label>
    <select class="form-select" id="sel1" name="pilih_waktu">
    <option>Bulan</option>
    <?php
    for ($i = 1; $i <= 12; $i++) {
        if ($i < 10) $i = '0' . $i;
        echo "<option value=" . date("Y") . "-" . $i . ">" . $air->bln($i) . " ". date("Y") . "</option>";
    }
    ?>
    </select>
</div>
</div>
<div class="row" id="summary">
<div class="col-xl-3 col-md-6">
    <div class="card bg-primary text-white mb-4">
        <div class="card-body d-flex justify-content-center">
            <h1></h1>
            <div class="ms-3">orang</div>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-center">
            <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
            <div class="small text-white">Pelanggan</div>
        </div>
    </div>
</div>
<div class="col-xl-3 col-md-6">
    <div class="card bg-warning text-white mb-4">
        <div class="card-body d-flex justify-content-center">
                <h1></h1>
                <div class="ms-3">m<sup>3</sup></div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-center">
                <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
                <div class="small text-white">Pemakaian air</div>
        </div>
    </div>
</div>
<div class="col-xl-3 col-md-6">
    <div class="card bg-success text-white mb-4">
        <div class="card-body d-flex justify-content-center">
                <h1></h1>
                <div class="ms-3">warga</div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-center">
                <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
            <div class="small text-white">Sudah dicatat</div>
        </div>
    </div>
</div>
<div class="col-xl-3 col-md-6">
    <div class="card bg-danger text-white mb-4">
        <div class="card-body d-flex justify-content-center">
            <h1></h1>
            <div class="ms-3">warga</div>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-center">
            <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
        <div class="small text-white">Belum dicatat</div>
    </div>
</div>
</div>
<div class="row" id="chartt">
<div class="col-xl-6">
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-area me-1"></i>
            Total Pemkaian Air <span id="total_pemakaian_air"> </span>
        </div>
        <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
    </div>
</div>
<div class="col-xl-6">
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-bar me-1"></i>
            Jumlah Rumah Kost dan Rumah Tinggal 
        </div>
        <div class="card-body"><canvas id="myPieChart" width="100%" height="40"></canvas></div>
    </div>
</div>
<div class="col-xl-6">
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-area me-1"></i>
            Jumlah Warga Tercatat
        </div>
        <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
    </div>
</div>
<div class="col-xl-6">
    <div class="card mb-4">
        <div class="card-header text-danger">
            <i class="fas fa-chart-area me-1"></i>
            Jumlah Warga Belum Tercatat
        </div>
        <div class="card-body"><canvas id="myBarChart2" width="100%" height="40"></canvas></div>
    </div>
</div>
</div>

<script>
   document.addEventListener("DOMContentLoaded", function() {
    const select = document.getElementById("sel1");
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const currentValue = `${year}-${month}`;

    // Cek dan set value jika cocok
    for (let i = 0; i < select.options.length; i++) {
        if (select.options[i].value === currentValue) {
            select.selectedIndex = i;
            break;
        }
    }
    $("#sel1").trigger("change");
});
    $(document).ready(function () {
    uri=window.location.href;
    e=uri.split("=");
    console.log("URI: "+uri+"e[1]:"+e[1]);
    const select = $("#sel1");
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const currentValue = `${year}-${month}`;

    // Set value default ke bulan sekarang
    select.val(currentValue);
$("#pilih_waktu select[name='pilih_waktu']").on("change", function () {
    let bln = $(this).val(); // ambil nilai yang dipilih
        console.log("Dipilih: " + bln);
        $.ajax({
            type: "post",
            url: "../konten/ajax.php",
            data: {p:"summary",t:bln},
            dataType: "json",
        })
        .done(function(response){
            console.log("data: " +response[0].jml_pelanggan); // untuk cek hasilnya
            blm_dicatat=response[0].jml_pelanggan-response[2].tercatat;
            $("#summary .bg-primary h1").text(response[0].jml_pelanggan);
            $("#summary .bg-warning h1").text(response[1].pemakaian);
            $("#summary .bg-success h1").text(response[2].tercatat);
            $("#summary .bg-danger h1").text(blm_dicatat);
            $("#total_pemakaian_air").text(response[3].total_pemakaian + " m³");
        })
        .fail(function(xhr, status, error){
            console.log("ada error nich", xhr.responseText); // biar tahu kenapa error
        });
});
select.trigger("change");
var user = "<?= $_SESSION['user'] ?? 'guest' ?>";
        $.ajax({
            type: "POST",
            url: "../konten/ajax.php",
            data: { p: "chart_line1", y:user},
            dataType: "json",
            cache: false
        })
        .done(function(respon) {
            console.log("respon",+ respon);

            sumbuX=respon.filter((num,index)=>index % 2 == 0);
            sumbuY=respon.filter((num,index)=>index % 2 !=0);
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#292b2c';

            // Area Chart Example
            var ctx = document.getElementById("myAreaChart");
            var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: sumbuX,
                datasets: [{
                label: "Pemakaian",
                lineTension: 0.3,
                backgroundColor: "rgba(2,117,216,0.2)",
                borderColor: "rgba(2,117,216,1)",
                pointRadius: 5,
                pointBackgroundColor: "rgba(2,117,216,1)",
                pointBorderColor: "rgba(255,255,255,0.8)",
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(2,117,216,1)",
                pointHitRadius: 50,
                pointBorderWidth: 2,
                data: sumbuY,
                }],
            },
            options: {
                scales: {
                xAxes: [{
                    time: {
                    unit: 'date'
                    },
                    gridLines: {
                    display: false
                    },
                    ticks: {
                    maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                    min: 0,
                    max: 600,
                    maxTicksLimit: 5
                    },
                    gridLines: {
                    color: "rgba(0, 0, 0, .125)",
                    }
                }],
                },
                legend: {
                display: false
                }
            }
            });
        })
        .fail(function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response text:", xhr.responseText);
        }); 

        $.ajax({
        type: "POST",
        url: "../konten/ajax.php",
        data: { p: "chart_pie" },
        dataType: "json"
        }).done(function (res) {
            let labels = [];
            let data = [];

            res.forEach(item => {
                labels.push(item.tipe);     // "RT" atau "kost"
                data.push(item.jumlah);     // jumlah masing-masing
            });
            var ctx = document.getElementById("myPieChart");
            new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: [
                        "#FF0000", "#0000FF"
                    ],
                }],
            },
            options: {
                responsive: true,
                legend: {
                    position: 'bottom'
                }
            }
        });
        });

        $.ajax({
            type: "POST",
            url: "../konten/ajax.php",
            data: { p: "chart_bar", y:user},
            dataType: "json",
            cache: false
        })
        .done(function(respon) {
            console.log("respon",+ respon);
            sumbuX=respon.filter((num,index)=>index % 2 == 0);
            sumbuY=respon.filter((num,index)=>index % 2 !=0);
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#292b2c';

            // Bar Chart Example
            var ctx = document.getElementById("myBarChart");
            var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: sumbuX,
                datasets: [{
                label: "Bulan",
                backgroundColor: "rgba(2,117,216,1)",
                borderColor: "rgba(2,117,216,1)",
                data: sumbuY,
                }],
            },
            options: {
                scales: {
                xAxes: [{
                    time: {
                    unit: 'month'
                    },
                    gridLines: {
                    display: false
                    },
                    ticks: {
                    maxTicksLimit: 6
                    }
                }],
                yAxes: [{
                    ticks: {
                    min: 0,
                    max: 60,
                    maxTicksLimit: 5
                    },
                    gridLines: {
                    display: true
                    }
                }],
                },
                legend: {
                display: false
                }
            }
            });
        })
        .fail(function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response text:", xhr.responseText);
        });

        $.ajax({
            type: "POST",
            url: "../konten/ajax.php",
            data: { p: "chart_bar2", y:user},
            dataType: "json",
            cache: false
        })
        .done(function(respon) {
            console.log("respon",+ respon);
            sumbuX=respon.filter((num,index)=>index % 2 == 0);
            sumbuY=respon.filter((num,index)=>index % 2 !=0);
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#292b2c';

            // Bar Chart Example
            var ctx = document.getElementById("myBarChart2");
            var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: sumbuX,
                datasets: [{
                label: "Bulan",
                backgroundColor: "rgba(2,117,216,1)",
                borderColor: "rgba(2,117,216,1)",
                data: sumbuY,
                }],
            },
            options: {
                scales: {
                xAxes: [{
                    time: {
                    unit: 'month'
                    },
                    gridLines: {
                    display: false
                    },
                    ticks: {
                    maxTicksLimit: 6
                    }
                }],
                yAxes: [{
                    ticks: {
                    min: 0,
                    max: 60,
                    maxTicksLimit: 5
                    },
                    gridLines: {
                    display: true
                    }
                }],
                },
                legend: {
                display: false
                }
            }
            });
        })
        .fail(function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response text:", xhr.responseText);
        });
});
</script>
<?php
} elseif($level == "bendahara")  {
?>

<div class="row mb-3" id="pilih_waktu">
    <div class="col-xl-3 cok-md-10">
        <label for="sel1" class="form-label">Pilih Waktu:</label>
        <select class="form-select" id="sel1" name="pilih_waktu">
        <option>Bulan</option>
        <?php
        for ($i = 1; $i <= 12; $i++) {
            if ($i < 10) $i = '0' . $i;
            echo "<option value=" . date("Y") . "-" . $i . ">" . $air->bln($i) . " ". date("Y") . "</option>";
        }
        ?>
        </select>
    </div>

</div>
<div class="row" id="summary">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body d-flex justify-content-center">
                <h1></h1>
                <div class="ms-3"></div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-center">
                <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
                <div class="small text-white">Pelanggan</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body d-flex justify-content-center">
                    <h1></h1>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-center">
                    <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
                    <div class="small text-white">Pemasukan</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body d-flex justify-content-center">
                    <h1></h1>
                    <div class="ms-3"></div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-center">
                    <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
                <div class="small text-white">Sudah Lunas</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body d-flex justify-content-center">
                <h1></h1>
                <div class="ms-3"></div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-center">
                <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
            <div class="small text-white">Belum Lunas</div>
        </div>
    </div>
</div>
<div class="row" id="chartt">
<div class="col-xl-6">
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-area me-1"></i>
            Total Pemkaian Air <span id="total_pemakaian_air"> </span>
        </div>
        <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
    </div>
</div>
<div class="col-xl-6">
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-bar me-1"></i>
            Jumlah Rumah Kost dan Rumah Tinggal 
        </div>
        <div class="card-body"><canvas id="myPieChart" width="100%" height="40"></canvas></div>
    </div>
</div>
<div class="col-xl-6">
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-area me-1"></i>
            Total Tagihan Air <span id="total_tagihan_air"> </span>
        </div>
        <div class="card-body"><canvas id="myAreaChart2" width="100%" height="40"></canvas></div>
    </div>
</div>
<div class="col-xl-6">
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-area me-1"></i>
            Total Pemasukan <span id="total_pemasukan"> </span>
        </div>
        <div class="card-body"><canvas id="myAreaChart3" width="100%" height="40"></canvas></div>
    </div>
</div>
<div class="col-xl-6">
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-area me-1"></i>
            Jumlah Warga Tercatat
        </div>
        <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
    </div>
</div>
<div class="col-xl-6">
    <div class="card mb-4">
        <div class="card-header text-danger">
            <i class="fas fa-chart-area me-1"></i>
            Jumlah Warga Belum Tercatat
        </div>
        <div class="card-body"><canvas id="myBarChart2" width="100%" height="40"></canvas></div>
    </div>
</div>
<div class="col-xl-6">
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-area me-1"></i>
            Jumlah Warga Sudah Lunas
        </div>
        <div class="card-body"><canvas id="myBarChart3" width="100%" height="40"></canvas></div>
    </div>
</div>
<div class="col-xl-6">
    <div class="card mb-4">
        <div class="card-header text-danger">
            <i class="fas fa-chart-area me-1"></i>
            Jumlah Warga Belum Lunas
        </div>
        <div class="card-body"><canvas id="myBarChart4" width="100%" height="40"></canvas></div>
    </div>
</div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const select = document.getElementById("sel1");
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const currentValue = `${year}-${month}`;

    // Cek dan set value jika cocok
    for (let i = 0; i < select.options.length; i++) {
        if (select.options[i].value === currentValue) {
            select.selectedIndex = i;
            break;
        }
    }
    $("#sel1").trigger("change");
});
    $(document).ready(function () {
    uri=window.location.href;
    e=uri.split("=");
    console.log("URI: "+uri+"e[1]:"+e[1]);
    const select = $("#sel1");
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const currentValue = `${year}-${month}`;

    // Set value default ke bulan sekarang
    select.val(currentValue);
    $("#pilih_waktu select[name='pilih_waktu']").on("change", function () {
        let bln = $(this).val(); // ambil nilai yang dipilih
        let formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        });
            console.log("Dipilih: " + bln);
            $.ajax({
                type: "post",
                url: "../konten/ajax.php",
                data: {p:"summary",t:bln},
                dataType: "json",
            })
            .done(function(response){
                console.log("data: " +response[0].jml_pelanggan); // untuk cek hasilnya
                blm_dicatat=response[0].jml_pelanggan-response[2].sdh_lunas;
                $("#summary .bg-primary h1").text(response[0].jml_pelanggan);
                $("#summary .bg-primary .ms-3").html("orang");
                $("#summary .bg-warning h1").text(formatter.format(response[1].tagihan));
                $("#summary .bg-success h1").text(response[2].sdh_lunas);
                $("#summary .bg-success .ms-3").html("warga");
                $("#summary .bg-danger h1").text(blm_dicatat);
                $("#summary .bg-danger .ms-3").html("warga");
                $("#total_pemakaian_air").text(response[3].total_pemakaian + " m³");
                $("#total_tagihan_air").text(formatter.format(response[4].total_tagihan));
                $("#total_pemasukan").text(formatter.format(response[5].sdh_lunass));
            })
            .fail(function(xhr, status, error){
                console.log("ada error nich", xhr.responseText); // biar tahu kenapa error
            });
    });
    select.trigger("change");
    var user = "<?= $_SESSION['user'] ?? 'guest' ?>";
        $.ajax({
            type: "POST",
            url: "../konten/ajax.php",
            data: { p: "chart_line1", y:user},
            dataType: "json",
            cache: false
        })
        .done(function(respon) {
            console.log("respon",+ respon);

            sumbuX=respon.filter((num,index)=>index % 2 == 0);
            sumbuY=respon.filter((num,index)=>index % 2 !=0);
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#292b2c';

            // Area Chart Example
            var ctx = document.getElementById("myAreaChart");
            var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: sumbuX,
                datasets: [{
                label: "Pemakaian",
                lineTension: 0.3,
                backgroundColor: "rgba(2,117,216,0.2)",
                borderColor: "rgba(2,117,216,1)",
                pointRadius: 5,
                pointBackgroundColor: "rgba(2,117,216,1)",
                pointBorderColor: "rgba(255,255,255,0.8)",
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(2,117,216,1)",
                pointHitRadius: 50,
                pointBorderWidth: 2,
                data: sumbuY,
                }],
            },
            options: {
                scales: {
                xAxes: [{
                    time: {
                    unit: 'date'
                    },
                    gridLines: {
                    display: false
                    },
                    ticks: {
                    maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                    min: 0,
                    max: 600,
                    maxTicksLimit: 5
                    },
                    gridLines: {
                    color: "rgba(0, 0, 0, .125)",
                    }
                }],
                },
                legend: {
                display: false
                }
            }
            });
        })
        .fail(function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response text:", xhr.responseText);
        }); 

        $.ajax({
        type: "POST",
        url: "../konten/ajax.php",
        data: { p: "chart_pie" },
        dataType: "json"
        }).done(function (res) {
            let labels = [];
            let data = [];

            res.forEach(item => {
                labels.push(item.tipe);     // "RT" atau "kost"
                data.push(item.jumlah);     // jumlah masing-masing
            });
            var ctx = document.getElementById("myPieChart");
            new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: [
                        "#FF0000", "#0000FF"
                    ],
                }],
            },
            options: {
                responsive: true,
                legend: {
                    position: 'bottom'
                }
            }
        });
        });
        $.ajax({
            type: "POST",
            url: "../konten/ajax.php",
            data: { p: "chart_line2", y:user},
            dataType: "json",
            cache: false
        })
        .done(function(respon) {
            console.log("respon",+ respon);

            sumbuX=respon.filter((num,index)=>index % 2 == 0);
            sumbuY=respon.filter((num,index)=>index % 2 !=0);
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#292b2c';

            // Area Chart Example
            var ctx = document.getElementById("myAreaChart2");
            var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: sumbuX,
                datasets: [{
                label: "Tagihan",
                lineTension: 0.3,
                backgroundColor: "rgba(2,117,216,0.2)",
                borderColor: "rgba(2,117,216,1)",
                pointRadius: 5,
                pointBackgroundColor: "rgba(2,117,216,1)",
                pointBorderColor: "rgba(255,255,255,0.8)",
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(2,117,216,1)",
                pointHitRadius: 50,
                pointBorderWidth: 2,
                data: sumbuY,
                }],
            },
            options: {
                scales: {
                xAxes: [{
                    time: {
                    unit: 'date'
                    },
                    gridLines: {
                    display: false
                    },
                    ticks: {
                    maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                    min: 0,
                    max: 1000000,
                    maxTicksLimit: 5
                    },
                    gridLines: {
                    color: "rgba(0, 0, 0, .125)",
                    }
                }],
                },
                legend: {
                display: false
                }
            }
            });
        })
        .fail(function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response text:", xhr.responseText);
        });

        $.ajax({
            type: "POST",
            url: "../konten/ajax.php",
            data: { p: "chart_line3", y:user},
            dataType: "json",
            cache: false
        })
        .done(function(respon) {
            console.log("respon",+ respon);

            sumbuX=respon.filter((num,index)=>index % 2 == 0);
            sumbuY=respon.filter((num,index)=>index % 2 !=0);
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#292b2c';

            // Area Chart Example
            var ctx = document.getElementById("myAreaChart3");
            var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: sumbuX,
                datasets: [{
                label: "LUNAS",
                lineTension: 0.3,
                backgroundColor: "rgba(2,117,216,0.2)",
                borderColor: "rgba(2,117,216,1)",
                pointRadius: 5,
                pointBackgroundColor: "rgba(2,117,216,1)",
                pointBorderColor: "rgba(255,255,255,0.8)",
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(2,117,216,1)",
                pointHitRadius: 50,
                pointBorderWidth: 2,
                data: sumbuY,
                }],
            },
            options: {
                scales: {
                xAxes: [{
                    time: {
                    unit: 'date'
                    },
                    gridLines: {
                    display: false
                    },
                    ticks: {
                    maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                    min: 0,
                    max: 800000,
                    maxTicksLimit: 5
                    },
                    gridLines: {
                    color: "rgba(0, 0, 0, .125)",
                    }
                }],
                },
                legend: {
                display: false
                }
            }
            });
        })
        .fail(function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response text:", xhr.responseText);
        });

        $.ajax({
            type: "POST",
            url: "../konten/ajax.php",
            data: { p: "chart_bar", y:user},
            dataType: "json",
            cache: false
        })
        .done(function(respon) {
            console.log("respon",+ respon);
            sumbuX=respon.filter((num,index)=>index % 2 == 0);
            sumbuY=respon.filter((num,index)=>index % 2 !=0);
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#292b2c';

            // Bar Chart Example
            var ctx = document.getElementById("myBarChart");
            var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: sumbuX,
                datasets: [{
                label: "Bulan",
                backgroundColor: "rgba(2,117,216,1)",
                borderColor: "rgba(2,117,216,1)",
                data: sumbuY,
                }],
            },
            options: {
                scales: {
                xAxes: [{
                    time: {
                    unit: 'month'
                    },
                    gridLines: {
                    display: false
                    },
                    ticks: {
                    maxTicksLimit: 6
                    }
                }],
                yAxes: [{
                    ticks: {
                    min: 0,
                    max: 60,
                    maxTicksLimit: 5
                    },
                    gridLines: {
                    display: true
                    }
                }],
                },
                legend: {
                display: false
                }
            }
            });
        })
        .fail(function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response text:", xhr.responseText);
        });

        $.ajax({
            type: "POST",
            url: "../konten/ajax.php",
            data: { p: "chart_bar2", y:user},
            dataType: "json",
            cache: false
        })
        .done(function(respon) {
            console.log("respon",+ respon);
            sumbuX=respon.filter((num,index)=>index % 2 == 0);
            sumbuY=respon.filter((num,index)=>index % 2 !=0);
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#292b2c';

            // Bar Chart Example
            var ctx = document.getElementById("myBarChart2");
            var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: sumbuX,
                datasets: [{
                label: "Bulan",
                backgroundColor: "rgba(2,117,216,1)",
                borderColor: "rgba(2,117,216,1)",
                data: sumbuY,
                }],
            },
            options: {
                scales: {
                xAxes: [{
                    time: {
                    unit: 'month'
                    },
                    gridLines: {
                    display: false
                    },
                    ticks: {
                    maxTicksLimit: 6
                    }
                }],
                yAxes: [{
                    ticks: {
                    min: 0,
                    max: 60,
                    maxTicksLimit: 5
                    },
                    gridLines: {
                    display: true
                    }
                }],
                },
                legend: {
                display: false
                }
            }
            });
        })
        .fail(function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response text:", xhr.responseText);
        });

        $.ajax({
            type: "POST",
            url: "../konten/ajax.php",
            data: { p: "chart_bar3", y:user},
            dataType: "json",
            cache: false
        })
        .done(function(respon) {
            console.log("respon",+ respon);
            sumbuX=respon.filter((num,index)=>index % 2 == 0);
            sumbuY=respon.filter((num,index)=>index % 2 !=0);
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#292b2c';

            // Bar Chart Example
            var ctx = document.getElementById("myBarChart3");
            var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: sumbuX,
                datasets: [{
                label: "Bulan",
                backgroundColor: "rgba(2,117,216,1)",
                borderColor: "rgba(2,117,216,1)",
                data: sumbuY,
                }],
            },
            options: {
                scales: {
                xAxes: [{
                    time: {
                    unit: 'month'
                    },
                    gridLines: {
                    display: false
                    },
                    ticks: {
                    maxTicksLimit: 6
                    }
                }],
                yAxes: [{
                    ticks: {
                    min: 0,
                    max: 60,
                    maxTicksLimit: 5
                    },
                    gridLines: {
                    display: true
                    }
                }],
                },
                legend: {
                display: false
                }
            }
            });
        })
        .fail(function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response text:", xhr.responseText);
        });

        $.ajax({
            type: "POST",
            url: "../konten/ajax.php",
            data: { p: "chart_bar4", y:user},
            dataType: "json",
            cache: false
        })
        .done(function(respon) {
            console.log("respon",+ respon);
            sumbuX=respon.filter((num,index)=>index % 2 == 0);
            sumbuY=respon.filter((num,index)=>index % 2 !=0);
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#292b2c';

            // Bar Chart Example
            var ctx = document.getElementById("myBarChart4");
            var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: sumbuX,
                datasets: [{
                label: "Bulan",
                backgroundColor: "rgba(2,117,216,1)",
                borderColor: "rgba(2,117,216,1)",
                data: sumbuY,
                }],
            },
            options: {
                scales: {
                xAxes: [{
                    time: {
                    unit: 'month'
                    },
                    gridLines: {
                    display: false
                    },
                    ticks: {
                    maxTicksLimit: 6
                    }
                }],
                yAxes: [{
                    ticks: {
                    min: 0,
                    max: 60,
                    maxTicksLimit: 5
                    },
                    gridLines: {
                    display: true
                    }
                }],
                },
                legend: {
                display: false
                }
            }
            });
        })
        .fail(function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response text:", xhr.responseText);
        });
});
</script>
<?php
} elseif($level == "warga")  {
?>

<div class="row mb-3" id="pilih_waktu">
    <div class="col-xl-3 cok-md-10">
        <label for="sel1" class="form-label">Pilih Waktu:</label>
        <select class="form-select" id="sel1" name="pilih_waktu">
        <option>Bulan</option>
        <?php
        for ($i = 1; $i <= 12; $i++) {
            if ($i < 10) $i = '0' . $i;
            echo "<option value=" . date("Y") . "-" . $i . ">" . $air->bln($i) . " ". date("Y") . "</option>";
        }
        ?>
        </select>
    </div>

</div>
<div class="row" id="summary">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body d-flex justify-content-center">
                <h2></h2>
                <div class="ms-3"></div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-center">
                <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
                <div class="small text-white">Waktu Pencatatan</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body d-flex justify-content-center">
                    <h2></h2>
                    <div class="ms-3"></div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-center">
                    <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
                    <div class="small text-white">Air digunakan</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body d-flex justify-content-center">
                    <h2></h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-center">
                    <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
                <div class="small text-white">Tagihan</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body d-flex justify-content-center">
                <h2></h2>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-center">
                <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
            <div class="small text-white">Status tagihan</div>
        </div>
    </div>
</div>
<div class="row" id="chartt">
<div class="col-xl-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-bar me-1"></i>
                Total Pemakaian Air <span id="total_air"></span>
            </div>
            <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-area me-1"></i>
                Total Tagihan <span id="total_tagihan"></span> <span> | Total Belum Lunas</span> <span id="yng_belum"></span>
            </div>
            <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const select = document.getElementById("sel1");
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const currentValue = `${year}-${month}`;

    // Cek dan set value jika cocok
    for (let i = 0; i < select.options.length; i++) {
        if (select.options[i].value === currentValue) {
            select.selectedIndex = i;
            break;
        }
    }
    $("#sel1").trigger("change");
});
$(document).ready(function () {
    uri=window.location.href;
    e=uri.split("=");
    console.log("URI: "+uri+"e[1]:"+e[1]);
    const select = $("#sel1");
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const currentValue = `${year}-${month}`;

    // Set value default ke bulan sekarang
    select.val(currentValue);
    $("#pilih_waktu select[name='pilih_waktu']").on("change", function () {
            let bln = $(this).val(); // ambil nilai yang dipilih
            let formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            });
            console.log("Dipilih: " + bln);
            $.ajax({
                type: "post",
                url: "../konten/ajax.php",
                data: {p:"summary",t:bln},
                dataType: "json",
            })
            .done(function(response){
                $("#summary .bg-primary .ms-3").text(response[0].waktu);
                $("#summary .bg-warning .ms-3").html("m<sup>3</sup>");
                $("#summary .bg-warning h2").text(response[1].pemakaian);
                $("#summary .bg-success h2").text(formatter.format(response[2].bayar));
                $("#summary .bg-danger h2").text(response[3].status);
                $("#summary .bg-primary h2").text(response[4].tgl);
                $("#total_air").text(response[5].total + " m³");
                $("#total_tagihan").text(formatter.format(response[6].totalan));
                $("#yng_belum").text(formatter.format(response[7].total_blm_lunas));
            })
            .fail(function(xhr, status, error){
                console.log("ada error nich", xhr.responseText); // biar tahu kenapa error
            })
        });
        select.trigger("change");
        
        console.log("Document ready triggered");
        var user = "<?= $_SESSION['user'] ?? 'guest' ?>";
        $.ajax({
            type: "POST",
            url: "../konten/ajax.php",
            data: { p: "chart_bar", y:user},
            dataType: "json",
            cache: false
        })
        .done(function(respon) {
            console.log("respon",+ respon);
            sumbuX=respon.filter((num,index)=>index % 2 == 0);
            sumbuY=respon.filter((num,index)=>index % 2 !=0);
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#292b2c';

            // Bar Chart Example
            var ctx = document.getElementById("myBarChart");
            var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: sumbuX,
                datasets: [{
                label: "Bulan",
                backgroundColor: "rgba(2,117,216,1)",
                borderColor: "rgba(2,117,216,1)",
                data: sumbuY,
                }],
            },
            options: {
                scales: {
                xAxes: [{
                    time: {
                    unit: 'month'
                    },
                    gridLines: {
                    display: false
                    },
                    ticks: {
                    maxTicksLimit: 6
                    }
                }],
                yAxes: [{
                    ticks: {
                    min: 0,
                    max: 60,
                    maxTicksLimit: 5
                    },
                    gridLines: {
                    display: true
                    }
                }],
                },
                legend: {
                display: false
                }
            }
            });

        })
        .fail(function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response text:", xhr.responseText);
        });
        $.ajax({
            type: "POST",
            url: "../konten/ajax.php",
            data: { p: "chart_line", y:user},
            dataType: "json",
            cache: false
        })
        .done(function(respon) {
            console.log("respon",+ respon);

            sumbuX=respon.filter((num,index)=>index % 2 == 0);
            sumbuY=respon.filter((num,index)=>index % 2 !=0);
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#292b2c';

            // Area Chart Example
            var ctx = document.getElementById("myAreaChart");
            var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: sumbuX,
                datasets: [{
                label: "Tagihan",
                lineTension: 0.3,
                backgroundColor: "rgba(2,117,216,0.2)",
                borderColor: "rgba(2,117,216,1)",
                pointRadius: 5,
                pointBackgroundColor: "rgba(2,117,216,1)",
                pointBorderColor: "rgba(255,255,255,0.8)",
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(2,117,216,1)",
                pointHitRadius: 50,
                pointBorderWidth: 2,
                data: sumbuY,
                }],
            },
            options: {
                scales: {
                xAxes: [{
                    time: {
                    unit: 'date'
                    },
                    gridLines: {
                    display: false
                    },
                    ticks: {
                    maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                    min: 0,
                    max: 200000,
                    maxTicksLimit: 5
                    },
                    gridLines: {
                    color: "rgba(0, 0, 0, .125)",
                    }
                }],
                },
                legend: {
                display: false
                }
            }
            });
        })
        .fail(function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response text:", xhr.responseText);
        });
});
</script>
<?php
} else {
    echo"halo";
}
?>
