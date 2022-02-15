<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Binatang</title>
    <link rel="stylesheet" href="<?= base_url('/css/quiz.css') ?>">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <div class="content__wrapper">
        <!-- Header -->
        <?= $this->include('component/header'); ?>

        <!-- content -->
        <div class="content">
            <h1 class="text-center my-5">Kuis</h1>
            <!-- <div class="countdown__wrapper">Waktu <span class="timer"></span></div> -->
            <div class="question__wrapper">
                <div class="number">Nomor <span></span></div>
                <div class="question"></div>
                <div class="answer-list"></div>
                <div class="message"></div>
            </div>

            <div class="score-board">
                <h1 class="score-message">Nilai mu adalah</h1>
                <div class="score-board__button__wrapper">
                    <button href="" class="btn btn-retry" onclick="location.reload()">Coba lagi</button>
                    <a href="<?= base_url() ?>" class="btn btn-menu">Menu Utama</a>
                </div>
            </div>


        </div>
        <!-- Footer -->
        <?= $this->include('component/footer'); ?>
    </div>
</body>

</html>

<script>
    $('document').ready(function() {
        $.ajax({
            url: `<?= site_url('Quiz/quizDetail') ?>`,
            dataType: 'json',
            success: function(data, status, xhr) {
                console.log(data)

                let currentScore = 0
                let questionCounter = 0

                function setQuestion() {
                    // set nomor
                    $('.number span').html(questionCounter + 1)

                    // set function to display question
                    function displayQuestion() {
                        let questionDiv = `<div>${data[questionCounter].question_data.pertanyaan}</div>`
                        $('.question').append(questionDiv)


                        // set audio 
                        let audioWrapper =
                            `
                            <audio class = "question-audio__wrapper" controls autoplay>
                                <source src = "<?= base_url() ?>/audio/${data[questionCounter].question_data.audio_name}" type = "audio/mpeg" >
                            </audio>
                            `
                        $('.content').append(audioWrapper)
                    }

                    function displayAnswerOption() {
                        let buttonDiv = ''

                        for (let i = 0; i < data[0].answer_list.length; i++) {
                            buttonDiv +=
                                `
                            <button class="btn btn-answer btn-primary" data-answer="${data[questionCounter].answer_list[i].nama_binatang}">${data[questionCounter].answer_list[i].nama_binatang}</button>
                                `
                        }

                        $('.answer-list').append(buttonDiv)
                    }

                    displayQuestion()
                    displayAnswerOption()

                    // get the new button answer
                    let answerOption = document.querySelectorAll('.btn-answer')

                    function buttonEnabling(val) {
                        // to disable or enable button
                        answerOption.forEach(option => {
                            option.setAttribute('disabled', val)
                        })

                        return val
                    }

                    answerOption.forEach(answer => {
                        answer.addEventListener('click', answerValidation)
                    })

                    function answerValidation() {
                        // disable after clicking
                        buttonEnabling(true)

                        if (this.getAttribute('data-answer').toLowerCase() == data[questionCounter].question_data.jawaban.toLowerCase()) {
                            this.style.backgroundColor = 'green'
                            currentScore += 10
                        } else {
                            for (let i = 0; i < answerOption.length; i++) {
                                if (answerOption[i].getAttribute('data-answer').toLowerCase() == data[questionCounter].question_data.jawaban.toLowerCase()) {
                                    answerOption[i].style.backgroundColor = 'green'
                                } else {
                                    answerOption[i].style.backgroundColor = 'red'
                                }
                            }
                        }

                        let countdownNumber = 2

                        // increase question number by 1
                        questionCounter++

                        function startCountdown() {
                            let countdown = setTimeout(() => {
                                console.log(questionCounter)
                                if (questionCounter < data.length) {
                                    $('.message').html('Pertanyaan Selanjutnya dalam ' + countdownNumber)

                                    if (countdownNumber == 0) {
                                        console.log(currentScore)
                                        // remove message
                                        $('.message').html('')

                                        // remove timeout
                                        clearTimeout(countdown)

                                        // remove answer inside wrapper
                                        while (document.querySelector('.question').firstChild) {
                                            document.querySelector('.question').removeChild(document.querySelector('.question').lastChild);
                                        }

                                        // remove question inside wrapper 
                                        while (document.querySelector('.answer-list').firstChild) {
                                            document.querySelector('.answer-list').removeChild(document.querySelector('.answer-list').lastChild);
                                        }

                                        // remove audio wrapper
                                        document.querySelector('.question-audio__wrapper').remove()

                                        // enable button
                                        buttonEnabling(false)

                                        setQuestion()
                                        return
                                    }
                                    countdownNumber--
                                    startCountdown()
                                } else {
                                    console.log(currentScore)
                                    countdownNumber = 0
                                    document.querySelector('.score-board').style.transform = 'translate(-50%, -50%)'

                                    if (currentScore > 60) {
                                        $('.score-message').html('Wah pintar nilai mu ' + currentScore)
                                    } else {
                                        $('.score-message').html('Nilai mu adalah ' + currentScore + ' yuk bisa belajar lebih giat lagi')
                                    }

                                    submitScore()
                                    return
                                }

                            }, 1300);
                        }
                        startCountdown()
                    }

                    function submitScore() {
                        let fetchURL = '<?= base_url('Quiz/insertNilai') ?>'

                        $.post(
                            fetchURL,
                            data = {
                                pengguna_id: localStorage.getItem('pengguna_id') || null,
                                nilai: currentScore,
                                tanggal_kuis: new Date().getFullYear() + '-' + new Date().getMonth() + '-' + new Date().getDate(),
                                jam_kuis: new Date().getHours() + ':' + new Date().getMinutes() + ':' + new Date().getSeconds(),
                            },
                            function(result, status) {
                                console.log(result)
                            });
                    }
                }
                setQuestion()
            }
        })

    })
</script>