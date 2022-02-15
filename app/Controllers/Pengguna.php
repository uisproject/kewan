<?php

namespace App\Controllers;

use Exception;

class Pengguna extends BaseController
{
    protected $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function registrasi()
    {
        return view('masuk-akun.php');
    }

    public function editData()
    {
        d($_POST);
        $table = $this->db->table('pengguna');
        $query = $table->where('pengguna_id = ' . $_POST['pengguna_id'])->update($_POST);

        echo '<script>alert("Data telah diperbaharui")</script>';
        echo '<script>window.location.href = "' . base_url() . '";</script>';
    }

    public function myAccount($penggunaId)
    {
        $table = $this->db->table('pengguna');
        $query = $table->where('pengguna_id = ' . $penggunaId)->get();

        $data = [
            'my_data' => $query->getResultArray()[0]
        ];

        return view('akun-saya', $data);
    }

    public function listSekolah()
    {
        $table = $this->db->table('sekolah');
        $query = $table->get();

        echo json_encode($query->getResultArray());
    }

    public function insertNewAcc()
    {
        $table = $this->db->table('sekolah');
        $query = $table->select('nama_sekolah, sekolah_id')->get();

        $nama_sekolah = $_POST['r-sekolah'];
        $sekolahExist = false;
        $sekolahId = 0;

        for ($i = 0; $i < count($query->getResultArray()); $i++) {
            if ($nama_sekolah == $query->getResultArray()[$i]['nama_sekolah']) {
                $sekolahExist = true;
                $sekolahId = $query->getResultArray()[$i]['sekolah_id'];
            }
        }

        $postedData = [
            'nama' => $_POST['r-nama'] ?? 'test',
            'email' => $_POST['r-email'] ?? 'test',
            'tanggal_lahir' => $_POST['r-bod'] ?? 'test',
            'sekolah_id' => $sekolahId,
            'kelas' => $_POST['r-kelas'] ?? 'test',
            'jenis_kelamin' =>  $_POST['r-gender'] ?? 'test',
            'password' => $_POST['r-password'] ?? 'test'
        ];

        $table = $this->db->table('pengguna');
        $query = $table->select('email')->get();
        $session = \Config\Services::session();

        // check if email alrady exist
        for ($i = 0; $i < count($query->getResultArray()); $i++) {
            if ($postedData['email'] == $query->getResultArray()[$i]['email']) {
                $tmp_msg = "Email tersebut sudah terdaftar coba email yang lain";
                $session->setFlashdata('register_msg', $tmp_msg);
                return redirect()->to(base_url());
            }
        }

        $tmp_msg = '';

        d($postedData);

        if ($sekolahExist == true) {
            if ($table->insert($postedData)) {
                $tmp_msg = "Akun telah berhasil dibuat";

                $session->setFlashdata('email', $postedData['email']);
            } else {
                $tmp_msg = "Akun gagal terbuat";
            }
        } else {
            $tmp_msg = "Sekolah Tidak ada dalam list";
        }

        $session->setFlashdata('register_msg', $tmp_msg);
        return redirect()->to(base_url());
    }

    public function login()
    {

        function message($status, $msg, $pengguna_id)
        {
            return json_encode(['status' => $status, 'msg' => $msg, 'pengguna_id' => $pengguna_id]);
        }

        $table = $this->db->table('pengguna');

        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            parse_str(file_get_contents("php://input"), $post_vars);
            $data = [
                'email' => $post_vars['email'],
                'password' => $post_vars['password']
            ];

            $query = $table->where('email = "' . $data['email'] . '"')->get();

            if ($query->getRow('email') == null) {
                return message(false, 'Email tidak tepat', -1);
            }

            if ($query->getRow('password') !=  $post_vars['password']) {
                return message(false, 'Password tidak tepat', -1);
            }

            return message(true, 'Login telah berhasil', $query->getRow('pengguna_id'));
        }
    }

    public function forgetPassword()
    {
        return view('forget-password');
    }

    public function sendPassword()
    {
        function msg($status, $msg)
        {
            return json_encode(['status' => $status, 'msg' => $msg]);
        }

        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            parse_str(file_get_contents("php://input"), $post_vars);
            $postEmail = $post_vars['email'];

            // check email if exist
            $key = 'ACA2DF3EB7C24406A338F2F8F707A156';
            $ch = curl_init('https://api.verimail.io/v3/verify?email=' . $postEmail . '&key=' . $key);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $json = curl_exec($ch);
            curl_close($ch);
            $validationResult = json_decode($json, true);

            if ($validationResult['deliverable'] == false) {
                return msg(false, 'Email Tidak ada');
            }

            // check email if exist in db
            $table = $this->db->table('pengguna');
            try {
                $query = $table->select('email, password')->where('email = "' . $postEmail . '"')->get();
                $result = $query->getResultArray()[0];
            } catch (Exception $e) {
                return msg(false, 'Maaf email tersebut tidak terdaftar');
            }

            $email = \Config\Services::email();
            $email->setTo($postEmail);
            $email->setFrom('louis.leonardo@uisproject.xyz', 'info');
            $email->setSubject('Verifikasi Akun Kewan');
            $email->setMessage('Password Kewan mu adalah ' . $result['password']);

            if (!$email->send()) {
                $data = $email->printDebugger(['headers']);
                // print_r($data);
                return  msg(false, 'Gagal mengirimkan ke email');
            }

            return  msg(true, 'Password telah dikirimkan ke email mu');
        }
    }
}
