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
    <link rel="stylesheet" href="<?= base_url('./css/tebak-hewan.css') ?>">
</head>

<body>
    <div class="content__wrapper">
        <!-- Header -->
        <?= $this->include('component/header'); ?>

        <!-- content -->
        <div class="content">
            <h1 class="text-center">Hewan apakah ini?</h1>
            <div class="image__container ">
                <div class="image__wrapper">
                    <div class="box__wrapper">
                        <div class="box" style="background-color: black;"></div>
                        <div class="box" style="background-color: black;"></div>
                        <div class="box" style="background-color: black;"></div>
                        <div class="box" style="background-color: black;"></div>
                        <div class="box" style="background-color: black;"></div>
                        <div class="box" style="background-color: black;"></div>
                        <div class="box" style="background-color: black;"></div>
                        <div class="box" style="background-color: black;"></div>
                        <div class="box" style="background-color: black;"></div>
                    </div>
                </div>
            </div>

            <div class="answer__wrapper">
                <h2 class="text-center">Pilihan Jawaban</h2>
                <div class="answer row">
                    <div class="answer-item" class="col-md-2">
                        <button id="ans1" class="btn-answer">Singa</button>
                        <!-- <span>Suara</span> -->
                    </div>
                    <div class="answer-item" class="col-md-2">
                        <button id="ans2" class="btn-answer">Beruang</button>
                        <!-- <span>Suara</span> -->
                    </div>
                    <div class="answer-item" class="col-md-2">
                        <button id="ans3" class="btn-answer">Rusa</button>
                        <!-- <span>Suara</span> -->
                    </div>
                    <div class="answer-item" class="col-md-2">
                        <button id="ans4" class="btn-answer">Kuda</button>
                        <!-- <span>Suara</span> -->
                    </div>
                    <div class="answer-item" class="col-md-2">
                        <button id="ans5" class="btn-answer">Gajah</button>
                        <!-- <span>Suara</span> -->
                    </div>
                </div>
            </div>

            <div class="hint__wrapper row">
                <button class="btn btn--reload col-md-6">Coba Lagi</button>
                <button class="btn btn--hint col-md-6">Petunjuk Selanjutnya</button>
            </div>
        </div>

        <div class="modal-check__wrapper">
            <div class="modal-check">
                <div class="msg-panel">
                    <h1 class="check-msg text-center"></h1>
                    <h2>Nilai : <span class="nilai"></span></h2>
                    <div class="btn__wrapper">
                        <button class="btn--reload">Coba lagi</button>
                        <a href="<?= base_url('koleksi-detil') . '/' . $data['list_binatang_id'] ?>" class="btn--pelajari">Pelajari lebih lanjut</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?= $this->include('component/footer'); ?>
    </div>
</body>

</html>

<script>
    let score = 100
    let imgContainer = ` <img src="<?= base_url() . '/image/foto-hewan/' . $data['nama_foto'] ?>" alt="" class="image">`

    $('.image__wrapper').append(imgContainer)

    let imageWrapper = document.querySelector('.image__wrapper')
    let image = document.querySelector('.image')
    let boxWrapper = document.querySelector('.box__wrapper')
    let box = document.querySelectorAll('.box')

    let boxSize = imageWrapper.clientWidth / 3

    box.forEach(box => {
        box.style.width = `${boxSize}px`
        box.style.height = `${boxSize}px`
    })

    // revealed array box
    let revealedBox = []

    function checkNumber(number) {
        if (revealedBox.includes(number)) return true

        revealedBox.push(number)

        // sort array
        revealedBox.sort(function(a, b) {
            return a - b
        })

        // remove box
        box[number].style.backgroundColor = 'transparent'
        return false
    }

    function generateRandomNumber() {
        let tmpNum

        if (revealedBox.length == 9) return;

        do {
            tmpNum = Math.floor(Math.random() * 9)
        } while (checkNumber(tmpNum))
    }

    function generateTimes(times) {
        for (let i = 0; i < times; i++) {
            generateRandomNumber()
        }
    }

    let btnHint = document.querySelector('.btn--hint')
    let petunjukCount = 1
    document.querySelector('.hint__wrapper').addEventListener('click', () => {
        score -= 10
        if (score <= 50) {
            score = 60
        }

        generateTimes(2)
        document.querySelector('.petunjuk').innerHTML = `Kalimat Petunjuk ${++petunjukCount}`
    })

    generateTimes(2)

    let btnAnswer = document.querySelectorAll('.answer .btn-answer')

    for (let i = 0; i < btnAnswer.length; i++) {
        btnAnswer[i].addEventListener('click', () => {
            document.querySelector('.modal-check').style.transform = 'translate(-50%, -50%)'
            document.querySelector('.modal-check').style.transition = 'all 1s'

            let correctAnswer = '<?= $data['nama_binatang'] ?>'

            if (btnAnswer[i].innerHTML == correctAnswer) {
                $('.check-msg').html(`Horee kamu benar jawabannya adalah <b style="color:red">${btnAnswer[i].innerHTML}</b>`)
                $('.nilai').html(score)
            } else {
                score = 0

                $('.check-msg').html(`Yah kamu kurang beruntung jawabannya adalah <b style="color:red">${correctAnswer}</b>, Yuk coba lagi`)

                $('.nilai').html(score)
            }

            let fetchURL = '<?= base_url('TebakHewan/insertNilai') ?>'

            $.post(
                fetchURL,
                data = {
                    pengguna_id: localStorage.getItem('pengguna_id') || null,
                    nilai: score,
                    tanggal_tebak_gambar: new Date().getFullYear() + '-' + new Date().getMonth() + '-' + new Date().getDate(),
                    jam_tebak_gambar: new Date().getHours() + ':' + new Date().getMinutes() + ':' + new Date().getSeconds(),
                },
                function(result, status) {
                    console.log(result)
                });
        })
    }

    function btnReload() {
        $('.btn--reload').on('click', function() {
            location.reload()
        })
    }

    btnReload()
</script>