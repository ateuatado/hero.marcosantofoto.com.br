<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientProjectModel extends Model
{
    protected $table            = 'client_projects';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'package_id', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'user_id'    => 'required|is_natural_no_zero',
        'package_id' => 'required|is_natural_no_zero',
        'status'     => 'required|in_list[open,selecting,paid,completed]',
    ];
}
