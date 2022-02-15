<?php

namespace App\Controllers;

class Quiz extends BaseController
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
        return view('quiz');
    }

    public function quizDetail()
    {
        // get 2 random animals
        $tableListBinatang = $this->db->table('list_binatang');
        $queryListBinatang = $tableListBinatang->select('nama_binatang')->get()->getResultArray();
        $totalBinatangList = count($queryListBinatang);

        // get questions and shuffle them
        $tableQuestion = $this->db->table('list_pertanyaan');
        $queryQuestion = $tableQuestion->get()->getResultArray();

        // random 10 questions
        // $shuffleQuestionList = array_rand($queryQuestion, 10);
        shuffle($queryQuestion);

        function generateAnswerList($trueAnswer, $queryListBinatang)
        {
            $tmpListBinatang = $queryListBinatang;
            $stop = false;
            $counter = 0;
            shuffle($tmpListBinatang);

            // echo $trueAnswer;
            // d($tmpListBinatang);

            while ($stop == false) {
                if (strtolower($tmpListBinatang[$counter]['nama_binatang']) != strtolower($trueAnswer)) {
                    // echo strtolower($tmpListBinatang[$counter]['nama_binatang']) . '=/=' . strtolower($trueAnswer) . '<br>';
                    unset($tmpListBinatang[$counter]);
                }

                if (count($tmpListBinatang) == 3) {
                    $stop = true;
                }
                ++$counter;
            }

            return array_values($tmpListBinatang);
        }

        $quizData = array();
        for ($i = 0; $i < 10; $i++) {
            $quizData[$i] = [
                "question_data" => $queryQuestion[$i],
                "answer_list" => generateAnswerList($queryQuestion[$i]['jawaban'], $queryListBinatang)
            ];
        }

        echo json_encode($quizData);
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
            "tanggal" => $_POST['tanggal_kuis'],
            "jam" => $_POST['jam_kuis'],
            'ip_address' => $ipAddr
        ];

        var_dump($data);

        $table = $this->db->table('nilai_kuis');
        $query = $table->insert($data);
    }
}
