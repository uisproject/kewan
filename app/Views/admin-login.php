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
    <link rel="stylesheet" href="<?= base_url('css/admin-login.css') ?>">
</head>

<body>
    <div class="content__wrapper">
        <div class="container">
            <table class="m-auto login-table">
                <tr>
                    <td><strong>Login Kewan Admin</strong></td>
                </tr>
                <tr>
                    <td><input type="text" class="form-control" placeholder="Masukan ID sekolah" id="sekolah_id"></td>
                </tr>
                <tr>
                    <td><input type="password" class="form-control" placeholder="Masukan password" id="password"></td>
                </tr>
                <tr>
                    <td><a href="">Lupa password?</a></td>
                </tr>
                <tr>
                    <td><button class="btn btn-light btn-login">Login</button></td>
                </tr>
            </table>
        </div>
    </div>

</body>

</html>

<script>
    document.querySelector('.btn-login').addEventListener('click', () => {
        const dataResult = {
            sekolah_id: $('#sekolah_id').val(),
            password: $('#password').val()
        }

        let fetchURL = '<?= base_url('Admin/loginValidation') ?>'

        $.post(
            fetchURL,
            data = dataResult,
            function(result, status) {
                let response = JSON.parse(result)

                alert(response.validation.msg)
                if (response.validation.valid === true) {
                    window.location.href = "<?= base_url('dashboard') ?>";
                }
            });
    })
</script>