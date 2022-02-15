<?php

namespace App\Controllers;

class ListBinatang extends BaseController
{
    protected $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $table = $this->db->table('list_binatang');
        $query = $table->get();

        echo json_encode($query->getResultArray());
    }
}
