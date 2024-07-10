<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivitiesModel extends Model
{
    protected $table = 'session_history';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = ['username', 'ipaddress', 'os', 'browser', 'mobile', 'activity', 'useragent', 'datetime'];
}
