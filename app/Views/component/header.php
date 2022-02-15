<div class="header">
    <div class="home__wrapper">

    </div>
    <div class="right__wrapper">
        <button class="button btn btn-light btn--menu">Menu</button>
    </div>
</div>

<div class="full-menu__wrapper">
    <h1>Menu</h1>
    <ul>
        <li class="menu--item"><a href="<?= base_url() ?>">Menuju menu Utama</a></li>
        <li class="menu--item my-account" style="display: none;"><a href="#">Akun saya</a></li>
        <li class="menu--item list-masuk-akun"><a href="<?= base_url() ?>/masuk-akun" class="btn-masuk-akun">Masuk/Daftar Akun</a></li>
        <!-- <li class="menu--item">Matikan Lagu</li> -->
        <li class="menu--item close-menu">Tutup Menu</li>
    </ul>
</div>

<script>
    if (localStorage.getItem('pengguna_id') != null) {
        document.querySelector('.my-account').style.display = 'grid'
        // set href to myaccount
        document.querySelector('.my-account a').href = `<?= base_url('/akun-saya') ?>/${localStorage.getItem('pengguna_id')}`
    }

    document.querySelector('.btn--menu').addEventListener('click', () => {
        document.querySelector('.full-menu__wrapper').style.transform = 'translateY(0)'
    })

    document.querySelector('.close-menu').addEventListener('click', () => {
        document.querySelector('.full-menu__wrapper').style.transform = 'translateY(-100vh)'
    })

    if (localStorage.getItem('pengguna_id') != null) {
        document.querySelector('.list-masuk-akun').firstChild.remove();

        let logOutBtn = '<a href="#" class="btn-log-out">Keluar Akun</a>'

        document.querySelector('.list-masuk-akun').innerHTML += logOutBtn
    }

    document.querySelector('.btn-log-out').addEventListener('click', () => {
        localStorage.removeItem('pengguna_id')
        alert('Kamu telah keluar dari akun mu')
        window.location.replace('/')
    })
</script>