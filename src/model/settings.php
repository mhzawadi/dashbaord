<?php
namespace MHorwood\Dashboard\Model;
use PhpOrm\DB;

DB::config('../config/database.php');

class settings extends DB
{
    protected $table = 'settings';

    protected $attributes = ['setting'];

    // protected $connection = 'backup';

    public static function factory()
    {
        return new self();
    }
}
