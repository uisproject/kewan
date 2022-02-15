<?php

namespace App\Controllers;

class TebakHewan extends BaseController
{
    protected $db;
    protected $tebakHewan;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        // get total binatang
        $builder = $this->db->table('list_binatang');
        $query = $builder->select('count(list_binatang_id) AS jumlah_binatang')->get();

        $totalBinatang = $query->getRowArray()['jumlah_binatang'];
        $randomId = rand(1, $totalBinatang);

        $builder = $this->db->table('foto_hewan');
        $query = $builder
            ->select('foto_hewan.*,lb.nama_binatang')
            ->from('list_binatang lb')
            ->where('lb.list_binatang_id = foto_hewan.list_binatang_id AND lb.list_binatang_id = ' . $randomId)
            ->get();

        $randomImage = rand(0, count($query->getResultArray()) - 1);

        $data = [
            'data' => $query->getResultArray()[$randomImage]
        ];

        d($data);

        return view('tebak-hewan', $data);
    }

    public function insertNilai()
    {
        $ipAddr = null;

        if ($_POST['pengguna_id'] == null) {
            $_POST['pengguna_id'] = 0;

            // get IP Address
            $ip = file_get_contents('https://api64.ipify.org');
        }

        $data = [
            "pengguna_id" => $_POST['pengguna_id'],
            "nilai" => $_POST['nilai'],
            "tanggal" => $_POST['tanggal_tebak_gambar'],
            "jam" => $_POST['jam_tebak_gambar'],
            'ip_address' => $ipAddr
        ];

        var_dump($data);

        $table = $this->db->table('nilai_tebak_gambar');
        $query = $table->insert($data);
    }
}
