<?php

namespace App\Controllers;

use Exception;

class Admin extends BaseController
{
    protected $db;
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        helper('url');

        $getSession = $this->session->get('sekolah_id');
        if (!isset($getSession)) {
            return redirect()->to(base_url('admin'));
        }
        return view('admin-dashboard');
    }

    public function login()
    {
        return view('admin-login');
    }

    public function loginValidation()
    {
        $sekolah_id = $_POST['sekolah_id'];
        $password = $_POST['password'];

        $table = $this->db->table('sekolah');

        try {
            $query = $table->select('sekolah_id, password')->where('sekolah_id = ' . $sekolah_id)->get()->getResultArray()[0];
        } catch (Exception $e) {
            return json_encode([
                "validation" =>
                ["valid" => false, "msg" => "sekolah_id salah"]
            ]);
        }

        if ($password != $query['password']) {
            return json_encode([
                "validation" =>
                ["valid" => false, "msg" => "Password salah"]
            ]);
        }

        $this->session->set(['sekolah_id' => $_POST['sekolah_id']]);

        return json_encode([
            "validation" =>
            ["valid" => true, "msg" => "Login Berhasil"]
        ]);
    }

    public function dashboardData()
    {
        $table = $this->db->table('pengguna');
        $query = $table->where('sekolah_id =' . $_SESSION['sekolah_id'])->get();

        echo json_encode($query->getResultArray());
    }

    public function featureData()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            parse_str(file_get_contents("php://input"), $post_vars);
            $penggunaId = $post_vars['pengguna_id'];

            $tableMewarnai = $this->db->table('nilai_mewarnai');
            $tableTebakGambar = $this->db->table('nilai_tebak_gambar');
            $tableKuis = $this->db->table('nilai_kuis');

            $queryMewarnai = $tableMewarnai->where('pengguna_id = ' . $penggunaId)->orderBy('nilai_mewarnai_id', 'DESC')->limit(10)->get()->getResultArray();

            $queryTebak = $tableTebakGambar->where('pengguna_id = ' . $penggunaId)->orderBy('nilai_tebak_gambar_id', 'DESC')->limit(10)->get()->getResultArray();

            $queryKuis = $tableKuis->where('pengguna_id = ' . $penggunaId)->orderBy('nilai_kuis_id', 'DESC')->limit(10)->get()->getResultArray();


            $data = [
                'nilai_mewarnai' => $queryMewarnai,
                'nilai_tebak_gambar' => $queryTebak,
                'nilai_kuis' => $queryKuis
            ];

            echo json_encode($data);
        }
    }

    public function logOut()
    {
        $this->session->remove('sekolah_id');
    }
}
