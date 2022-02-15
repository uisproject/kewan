<?php

namespace App\Controllers;

class Koleksi extends BaseController
{
    protected $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function listBinatang()
    {
        return view('koleksi');
    }

    public function koleksiDetil($id)
    {
        $table = $this->db->table('list_binatang');
        $query = $table->select('*')->where('list_binatang_id = ' . $id)->get();

        $result = [
            "dataHewan" => $query->getResultArray()[0]
        ];

        d($result);

        return view('koleksi-detail', $result);
    }

    public function koleksiDetailTable($id)
    {
        // table fun fact
        $table_funFact = $this->db->table('fun_fact');
        $query_funFact = $table_funFact->select('fun_fact_id, fun_fact')->where('list_binatang_id = ' . $id)->get();

        // table foto_hewan
        $table_fotoHewan = $this->db->table('foto_hewan');
        $query_fotoHewan = $table_fotoHewan->select('foto_hewan_id, nama_foto')->where('list_binatang_id = ' . $id)->get();

        echo json_encode([
            'fun_fact_list' => $query_funFact->getResultArray(),
            'foto_hewan_list' => $query_fotoHewan->getResultArray()
        ]);
    }
}
