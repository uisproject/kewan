<?php

namespace App\Models;

use CodeIgniter\Model;

class TebakHewanModel extends Model
{
    protected $table      = 'tebak_hewan';
    protected $primaryKey = 'binatang_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $useTimestamps = false;
    protected $createdField  = '';
    protected $updatedField  = '';
    protected $deletedField  = '';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
