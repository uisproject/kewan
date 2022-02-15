<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="<?= base_url('css/admin-detail.css') ?>">
    <!-- chartjs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="content__wrapper">
        <div class="container">
            <div class="header">
                <div class="header__wrapper">
                    <div class="log-out__wrapper">
                        <button class="btn btn-light btn-log-out">Keluar Akun</button>
                    </div>
                </div>
            </div>
            <div class="list-murid__wrapper pt-5">
                <h2>List Murid Kewan</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th width="100px">Nomor</th>
                            <!-- <th width="100px">Id Murid</th> -->
                            <th width="100px">Nama</th>
                            <th width="100px">Kelas</th>
                            <th width="100px">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="list-murid"></tbody>
                </table>
                <table>
                    <tr class="page-item__wrapper">
                        <td>Halaman</td>
                    </tr>
                </table>
            </div>
            <div class="detail-murid" style="padding-top: 50px;">
                <h2>Detail Murid</h2>
                <table class="table">
                    <tr>
                        <td>No</td>
                        <td id="nomor"></td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td id="nama"></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td id="email"></td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td id="dob"></td>
                    </tr>
                    <tr>
                        <td>Kelas</td>
                        <td id="kelas"></td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td id="gender"></td>
                    </tr>
                </table>
            </div>
            <div class="score-development">
                <h2 class="title">Perkembangan Nilai</h2>
                <div class="score-development__wrapper row">
                    <div class="mewarnai-feature__wrapper col-md-12">
                        <h4>Fitur Mewarnai</h4>
                        <div class="chart__wrapper">
                            <canvas class="chart"></canvas>
                        </div>
                    </div>
                    <div class="tebak-hewan-feature__wrapper col-md-12">
                        <h4>Fitur Tebak Hewan</h4>
                        <div class="chart__wrapper">
                            <canvas class="chart"></canvas>
                        </div>
                    </div>
                    <div class="quiz-feature__wrapper col-md-12">
                        <h4>Fitur Quiz</h4>
                        <div class="chart__wrapper">
                            <canvas class="chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>
<script>
    function generateChart(cLabels, cData, cTitle, bgColor) {
        // initial chart
        const data = {
            labels: cLabels || null,
            datasets: [{
                label: cTitle || 'No Data',
                backgroundColor: bgColor || 'rgb(255, 99, 132)',
                borderColor: '#FFDE59',
                data: cData || null,
            }]
        };

        return config = {
            type: 'bar',
            data: data,
            options: {}
        };
    }


    // initial mewarnai hewan chart
    new Chart(document.querySelectorAll('.chart')[0], generateChart(null, null, null))

    // initial tebak hewan chart
    new Chart(document.querySelectorAll('.chart')[1], generateChart(null, null, null))

    // initial quiz chart
    new Chart(document.querySelectorAll('.chart')[2], generateChart(null, null, null))

    $.get("<?= base_url('Admin/dashboardData') ?>", function(result, status) {
        let data = JSON.parse(result)
        console.log(data)

        let limitRow = 10
        let tbodyWrapper = ''

        for (let i = limitRow - 10; i < limitRow; i++) {
            if (data[i] != null) {
                tbodyWrapper +=
                    `
                <tr>
                    <td>${i+1}</td>
                    <td>${data[i].nama}</td>
                    <td>${data[i].kelas}</td>
                    <td><button class="btn btn-light btn-detail" data-pengguna_id=${data[i].pengguna_id}>Detail</button></td>
                </tr>
                `
            }
        }

        $('.list-murid').append(tbodyWrapper)

        // generate list page
        function generatePage(page) {
            return `<td><button class="btn btn-primary page-item" data-value=${page*10}>${page}</button></td>`
        }

        let totalPage = Math.ceil(data.length / 10)
        let pageWrapper = ''
        for (let i = 0; i < totalPage; i++) {
            pageWrapper += generatePage(i + 1)
        }

        $('.page-item__wrapper').append(pageWrapper)

        // detail function
        let btnDetail = document.querySelectorAll('.btn-detail')

        for (let i = 0; i < btnDetail.length; i++) {
            btnDetail[i].addEventListener('click', () => {

                $('#nomor').html(i + 1)
                $('#nama').html(data[i].nama)
                $('#email').html(data[i].email)
                $('#dob').html(data[i].tanggal_lahir)
                $('#kelas').html(data[i].kelas)
                $('#gender').html(data[i].jenis_kelamin)

                // remove old canvas
                let charts = document.querySelectorAll('.chart__wrapper')

                charts.forEach(chart => chart.firstElementChild.remove())

                let penggunaId = btnDetail[i].getAttribute('data-pengguna_id')

                let fetchURL = '<?= base_url('Admin/featureData/') ?>'

                $.ajax({
                    url: fetchURL,
                    data: {
                        pengguna_id: penggunaId
                    },
                    type: 'PUT',
                    success: function(result, status) {
                        // Do something with the result
                        scoreData = JSON.parse(result)

                        console.log(scoreData)

                        function getRandomRgb() {
                            var num = Math.round(0xffffff * Math.random());
                            var r = num >> 16;
                            var g = num >> 8 & 255;
                            var b = num & 255;
                            return 'rgb(' + r + ', ' + g + ', ' + b + ')';
                        }

                        function separateData(data, title) {
                            let labels = []
                            let dataValue = []
                            let backgroundColor = []

                            // push tanggal
                            for (let i = 0; i < data.length; i++) {
                                labels.push(data[i].tanggal)
                                dataValue.push(data[i].nilai)
                                backgroundColor.push(getRandomRgb())
                            }

                            return {
                                labels: labels,
                                dataValue: dataValue,
                                title: title,
                                backgroundColor: backgroundColor
                            }
                        }

                        // render to mewarnai
                        let scoringData = [
                            [separateData(scoreData.nilai_mewarnai, 'Perkembangan Nilai Mewarnai')],
                            [separateData(scoreData.nilai_tebak_gambar, 'Perkembangan Nilai Tebak Hewan')],
                            [separateData(scoreData.nilai_kuis, 'Perkembangan Nilai Kuis')]
                        ]

                        console.log(scoringData[0][0])

                        // re-create canvas
                        for (let i = 0; i < charts.length; i++) {
                            let setCanvas = `<canvas class="chart"></canvas>`
                            charts[i].innerHTML = setCanvas

                            new Chart(document.querySelectorAll('.chart')[i], generateChart(scoringData[i][0].labels, scoringData[i][0].dataValue, scoringData[i][0].title, scoringData[i][0].backgroundColor))
                        }


                    }
                });
            })
        }

    });

    // log out function
    $('.btn-log-out').click(function() {
        $.post("<?= base_url('Admin/logOut') ?>", function(result, status) {
            if (status == 'success') {
                alert('Keluar Akun Berhasil')
                window.location.reload()
            }
        });
    })
</script>