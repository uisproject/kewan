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
    <link rel="stylesheet" href="<?= base_url('/css/mewarnai-hewan-detail.css') ?>">
    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <div class="super__container">
        <div class="modal-validation">
            <div class="modal-validation__wrapper">
                <div class="arrow-back__wrapper">
                    <button class="btn-arrow-back">Kembali</button>
                </div>
                <div class="storedImage__wrapper">
                    <?= $master_table['svg'] ?>
                </div>
                <div class="ref-image__wrapper">
                    <img src="<?= base_url($master_table['foto_referensi'])  ?>" alt="">
                </div>
                <span class="score__wrapper">Nilai : <span class="score">XX</span></span>
                <a href="<?= base_url('koleksi-detil') . '/' . $master_table['list_binatang_id'] ?>" class="btn btn-completed"><b>Yuk Pelajari Lebih Lanjut!</b></a>
            </div>
        </div>

        <div class="content__wrapper" style="position: relative;">
            <!-- Header -->
            <?= $this->include('component/header'); ?>

            <div class="content">
                <div class="drawing">
                    <?= $master_table['svg'] ?>
                    <div class="btn-validasi__wrapper">
                        <button class="btn btn-validasi">Selesai</button>
                    </div>
                </div>
                <div class="color-pallete">
                    <div class="color-circle__wrapper">
                        <div class="color-circle clear" data-color="white">Hapus</div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <?= $this->include('component/footer'); ?>
        </div>
    </div>
</body>

</html>

<script>
    let getBinatangId = <?= $master_table['list_binatang_id'] ?>

    let currentColor = ''

    // pass color to js array
    let colorDivContainer = ''
    <?php for ($i = 0; $i < count($warna_table); $i++) { ?>
        colorDivContainer += `<div class="color-circle" data-color="<?= $warna_table[$i]['warna'] ?>"></div>`;
    <?php } ?>

    $('.color-circle__wrapper').append(colorDivContainer)

    // set color function and set bg on each pallete color
    colorDivContainer = document.querySelectorAll('.color-circle')
    for (let i = 0; i < colorDivContainer.length; i++) {
        colorDivContainer[i].style.backgroundColor = colorDivContainer[i].getAttribute('data-color')
        colorDivContainer[i].addEventListener('click', getColor)
    }

    // get color code from pallete
    function getColor() {
        currentColor = this.getAttribute('data-color')
        console.log(currentColor)
    }

    // document.querySelector('.btn-completed').href = `<?= base_url('koleksi-detil/') ?>/${getBinatangId}`

    // assign area fill
    let counter = 1
    while (document.querySelector(`.drawing #d${counter}`) != null) {
        document.querySelector(`.drawing #d${counter}`).addEventListener('click', areaClicked)
        counter++
    }

    function areaClicked() {
        this.style.fill = currentColor
    }

    document.querySelector('.btn-validasi').addEventListener('click', () => {
        // set function when clicking selesai

        // fill color to storedSvg div
        fillStoredImage()

        // popup modal
        popupModal()
    })

    function findNumber(text) {
        let r = /\d+/;
        let s = text;
        let foundNumber = parseInt(s.match(r))

        return (foundNumber.toString(16)).toUpperCase()
    }

    function convertRGB2HEX(rgb) {
        let x = rgb.replace(' ', '').split(',')
        2
        return '#' + findNumber(x[0]) + findNumber(String(x[1])) + findNumber(String(x[2]).trim())
    }

    // fill svg color in storedsvg
    function fillStoredImage() {
        let counter = 1

        while (document.querySelector(`.storedImage__wrapper #d${counter}`) != null) {
            // get color from main svg
            let mainSvgColor = document.querySelector(`.drawing #d${counter}`).style.fill

            document.querySelector(`.storedImage__wrapper #d${counter}`).style.fill = convertRGB2HEX(mainSvgColor)
            counter++
        }
    }

    // appear when click selesai
    function popupModal() {
        document.querySelector('.modal-validation').style.display = 'block'

        // pass data to js object
        let validation_data = []

        <?php for ($i = 0; $i < count($validasi_table); $i++) { ?>
            validation_data[<?php echo $i ?>] = {
                nama_area: '<?php echo $validasi_table[$i]['nama_area'] ?>',
                warna: '<?php echo $validasi_table[$i]['warna'] ?>',
                poin: <?php echo $validasi_table[$i]['poin'] ?>
            }
        <?php } ?>

        let score = 0
        let counter = 1

        console.log(validation_data)

        // check every area
        while (document.querySelector(`.drawing #d${counter}`) != null) {
            let color = document.querySelector(`.drawing #d${counter}`).style.fill
            // console.log(counter)
            // console.log('1st = ' + convertRGB2HEX(color))
            // console.log('2nd = ' + validation_data[counter - 1].warna)
            // console.log('poin ' + validation_data[counter - 1].poin)

            if (convertRGB2HEX(color) == validation_data[counter - 1].warna) {
                score += validation_data[counter - 1].poin
                // console.log('score increment= ' + score)

                if (score >= 100) {
                    score = 100
                }
            }
            counter++
        }
        document.querySelector('.score').innerHTML = score

        let fetchURL = '<?= base_url('MewarnaiHewan/insertNilai') ?>'

        $.post(
            fetchURL,
            data = {
                pengguna_id: localStorage.getItem('pengguna_id') || null,
                nilai: score,
                tanggal_mewarnai: new Date().getFullYear() + '-' + new Date().getMonth() + '-' + new Date().getDate(),
                jam_mewarnai: new Date().getHours() + ':' + new Date().getMinutes() + ':' + new Date().getSeconds(),
            },
            function(result, status) {
                console.log(result)
            });

    }

    // remove modal function
    function removeModal() {
        document.querySelector('.modal-validation').style.display = 'none'
    }

    document.querySelector('.btn-arrow-back').addEventListener('click', removeModal)
</script>