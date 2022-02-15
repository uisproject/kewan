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

    <link rel="stylesheet" href="<?= base_url('/css/akun-saya.css') ?>">
</head>

<body>
    <div class="content__wrapper">
        <!-- Header -->
        <?= $this->include('component/header'); ?>

        <!-- content -->
        <div class="content">
            <div class="my-profile container">
                <h2 class="py-3">Profil Saya</h2>
                <hr>
                <form action="<?= base_url('/Pengguna/editData') ?>" method="POST">
                    <table>
                        <input type="text" name="pengguna_id" id="penggunaId" hidden>
                        <tr>
                            <td>Nama</td>
                            <td><input type="text" name="nama" class="form-control" width="100%" value="<?= $my_data['nama'] ?>"></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><input type="text" name="email" class="form-control" value="<?= $my_data['email'] ?>"></td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir</td>
                            <td><input type="date" name="tanggal_lahir" class="form-control" value="<?= $my_data['tanggal_lahir'] ?>"></td>
                        </tr>
                        <tr>
                            <td>Kelas</td>
                            <td><input type="text" name="kelas" class="form-control" value="<?= $my_data['kelas'] ?>"></td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td><input type="text" name="jenis_kelamin" class="form-control" value="<?= $my_data['jenis_kelamin'] ?>"></td>
                        </tr>

                        <tr>
                            <td>Password</td>
                            <td><input type="text" name="password" class="form-control" value="<?= $my_data['password'] ?>"></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td><input type="submit" value="Ubah" class="btn btn-light" style="font-size: 32px;"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <?= $this->include('component/footer'); ?>
    </div>
</body>


</html>

<script>
    document.getElementById('penggunaId').value = localStorage.getItem('pengguna_id')
</script>