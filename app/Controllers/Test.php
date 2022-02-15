<?php

namespace App\Controllers;

class Test extends BaseController
{
    protected $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $ip = file_get_contents('https://api64.ipify.org');
        echo "My public IP address is: " . $ip;
    }
}
