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
    <link rel="stylesheet" href="<?= base_url('css/lupa-password.css') ?>">
</head>

<body>
    <div class="content__wrapper">
        <!-- Header -->
        <?= $this->include('component/header'); ?>

        <!-- content -->
        <div class="content">
            <div class="col-md-4 m-auto" style="height: 100%;">
                <p class="text-center">Password mu akan dikirimkan ke emailmu</p>
                <table class="">
                    <tr>
                        <td><input type="text" class="form-control email-input" placeholder="Masukan Email mu" width="100%"></td>
                    </tr>

                    <tr>
                        <td>
                            <input type="submit" id="btn-submit" value="Kirim Password" class="btn btn-light">
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Footer -->
        <?= $this->include('component/footer'); ?>
    </div>
</body>

</html>
<script>
    $('#btn-submit').on('click', function() {
        document.getElementById('btn-submit').setAttribute('disabled', true)

        let fetchURL = '<?= base_url('Pengguna/sendPassword') ?>'
        $.ajax({
            url: fetchURL,
            data: {
                email: $('.email-input').val()
            },
            type: 'PUT',
            success: function(result, status) {
                console.log(result)
                let getResult = JSON.parse(result)
                alert(getResult.msg)
                console.log(getResult)
                document.getElementById('btn-submit').removeAttribute('disabled')
            }
        })
    })
</script>