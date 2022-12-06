<?php
namespace MHorwood\Dashboard\Model;
use PhpOrm\DB;

DB::config('../config/database.php');

class application extends DB
{
    protected $table = 'apps';

    protected $attributes = ['id', 'name', 'url', 'icon', 'isPinned', 'createdAt', 'updatedAt', 'orderId', 'isPublic', 'description'];

    // protected $connection = 'backup';

    public static function factory()
    {
        return new self();
    }
}
