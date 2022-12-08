<?php
namespace MHorwood\Dashboard\Model;
use PhpOrm\DB;

DB::config('../config/database.php');

class bookmark extends DB
{
    protected $table = 'bookmarks';

    protected $attributes = ['id', 'name', 'url', 'categoryId', 'icon', 'createdAt', 'updatedAt', 'isPublic', 'orderId'];

    // protected $connection = 'backup';

    public static function factory()
    {
        return new self();
    }
}
