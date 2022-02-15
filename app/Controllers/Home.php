<?php

namespace App\Controllers;

class Home extends BaseController
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
        $data = [
            'msg' => null
        ];
        // if login
        if ($this->session->getFlashdata('pengguna_id') != null) {
            $data = [
                'msg' => $this->session->getFlashdata('login_msg'),
                'pengguna_id' => $this->session->getFlashdata('pengguna_id')
            ];
        } else {
            $table = $this->db->table('pengguna');

            $getEmailSession = $this->session->getFlashdata('email');
            $result = null;
            if ($getEmailSession != null) {
                $query = $table->select('pengguna_id')->where("email = '" . $getEmailSession  . "'")->get();
                $result = $query->getResultArray()[0]['pengguna_id'];
            }


            $data = [
                'msg' => $this->session->getFlashdata('register_msg'),
                'pengguna_id' => $result ?? null
            ];
        }
        d($data);

        return view('homepage', $data);
    }
}
