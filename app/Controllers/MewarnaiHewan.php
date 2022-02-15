<?php

namespace App\Controllers;

class MewarnaiHewan extends BaseController
{

    protected $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        return view('mewarnai-hewan');
    }

    public function mewarnaiHewanGetData()
    {
        $table = $this->db->table('list_binatang lb');
        $query = $table
            ->select('lb.list_binatang_id, nama_binatang, foto_referensi')
            ->join('svg_hewan', 'lb.list_binatang_id = svg_hewan.list_binatang_id')
            ->get();

        $data = $query->getResultArray();

        echo json_encode($data);
    }

    public function mewarnaiHewanListBinatang($id)
    {
        $table = $this->db->table('list_binatang lb');
        $query = $table
            ->select('lb.list_binatang_id, nama_binatang, foto_referensi')
            ->from('svg_hewan')
            ->where('lb.list_binatang_id = ' . $id . ' AND lb.list_binatang_id = svg_hewan.list_binatang_id')
            ->get();

        $data = [
            "data" => $query->getResultArray()
        ];

        return view('mewarnai-hewan-list-svg', $data);
    }

    public function mewarnaiHewanDetail($id)
    {
        // get Master Table
        $tableMaster = $this->db->table('list_binatang lb');
        $queryMaster = $tableMaster
            ->select('lb.list_binatang_id, nama_binatang, svg, foto_referensi')
            ->join('svg_hewan', 'lb.list_binatang_id = svg_hewan.svg_hewan_id', 'inner')
            ->where('lb.list_binatang_id = ' . $id)
            ->get();

        // d($queryMaster->getResultArray()[0]);

        // get Detail validasi
        $tableValidasi = $this->db->table('svg_hewan');
        $queryValidasi = $tableValidasi
            ->select('nama_area, warna, poin')
            ->join('validasi_svg_hewan', 'validasi_svg_hewan.svg_hewan_id = svg_hewan.svg_hewan_id', 'inner')
            ->where('list_binatang_id = ' . $id)
            ->get();

        // get Detail warna
        $tableWarna = $this->db->table('svg_hewan');
        $queryWarna = $tableWarna
            ->select('warna_id,warna')
            ->join('warna ', 'warna.svg_hewan_id = svg_hewan.svg_hewan_id', 'inner')
            ->where('list_binatang_id = ' . $id)
            ->get();

        $data = [
            'master_table' => $queryMaster->getResultArray()[0],
            'validasi_table' => $queryValidasi->getResultArray(),
            'warna_table' => $queryWarna->getResultArray()
        ];

        d($data);

        return view('mewarnai-hewan-detail', $data);
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
            "tanggal" => $_POST['tanggal_mewarnai'],
            "jam" => $_POST['jam_mewarnai'],
            'ip_address' => $ipAddr
        ];

        var_dump($data);

        $table = $this->db->table('nilai_mewarnai');
        $query = $table->insert($data);
    }
}
