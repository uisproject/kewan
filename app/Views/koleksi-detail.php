<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?= base_url('../css/koleksi.css') ?>">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>

<style>
    .btn {
        font-size: 24px;
    }
</style>

<body>
    <div class="content__wrapper">
        <!-- Header -->
        <?= $this->include('component/header'); ?>
        <!-- content here -->
        <div class="content row">
            <div class="left-content col-md-6">
                <div class="scene "></div>
                <div class="animal-photo row">
                    <div class="box col-md-3"></div>
                    <div class="box col-md-3"></div>
                    <div class="box col-md-3"></div>
                    <div class="box col-md-3"></div>
                </div>
            </div>
            <div class="right-content col-md-6">
                <div class="youtube__wrapper">
                    <iframe width="560" height="315" src="<?= $dataHewan['youtube_link'] ?>autoplay=1&&controls=0&&mute=1&&loop=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="animal-description">
                    <div class="animal-description--header">
                        <h1><?= $dataHewan['nama_binatang'] ?></h1>
                        <button class="btn btn-light animal-sound-start">Suara Hewan</button>
                        <audio class="audio__wrapper" controls autoplay>
                            <source src="<?= base_url() ?>/audio/<?= $dataHewan['audio_name'] ?>" type="audio/mpeg">
                        </audio>
                    </div>
                    <table class="table" style="font-size: 24px;">
                        <tr>
                            <th>Makanan</th>
                            <td><?= $dataHewan['makanan'] ?></td>
                        </tr>
                        <tr>
                            <th>Tempat Tinggal</th>
                            <td><?= $dataHewan['habitat'] ?></td>
                        </tr>
                        <tr>
                            <th>Jenis Hewan</th>
                            <td><?= $dataHewan['jenis_pemakan'] ?></td>
                        </tr>
                        <tr>
                            <th>Berkembang Biak dengan</th>
                            <td><?= $dataHewan['cara_berkembang_biak'] ?></td>
                        </tr>
                    </table>
                    <div class="fun-fact">
                        <h2><strong>Fakta tentang <?= $dataHewan['nama_binatang'] ?>!</strong></h2>
                        <p class="fact-desc" style="font-size: 24px;"></p>
                        <button class="btn btn-light btn-next">Selanjutnya</button>
                    </div>
                </div>

                <audio class="animal-sound__wrapper">
                    <source src="<?= base_url() ?>/audio/<?= $dataHewan['suara_binatang'] ?>" type="audio/mpeg">
                </audio>
            </div>

        </div>

        <!-- Footer -->
        <?= $this->include('component/footer'); ?>
    </div>

    <script src="<?= $dataHewan['script_src'] ?>" type="module"></script>
</body>

</html>

<script>
    document.querySelector('.animal-sound-start').addEventListener('click', () => {
        document.querySelector('.animal-sound__wrapper').play()
        document.querySelector('.audio__wrapper').pause()
    })

    let binatangId = <?= $dataHewan['list_binatang_id'] ?>

    // get data with AJAX
    $.get("<?= base_url('/Koleksi/koleksiDetailTable') ?>" + '/' + binatangId, function(data, status) {

        let parsedJSON = JSON.parse(data)
        console.log(parsedJSON)

        let counter = 0

        $('.fact-desc').html(parsedJSON.fun_fact_list[counter].fun_fact)

        $('.btn-next').click(function() {
            counter += 1

            if (counter == parsedJSON.fun_fact_list.length - 1) {
                counter = 0
            }

            $('.fact-desc').html(parsedJSON.fun_fact_list[counter].fun_fact)
        })

        let box = document.querySelectorAll('.box')
        box.forEach((box, idx) => {
            box.style.backgroundImage = `url(../image/foto-hewan/${parsedJSON.foto_hewan_list[idx].nama_foto})`
        })
    });
</script>