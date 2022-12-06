<?php
use PhpOrm\DB;

class category extends DB
{
    protected $table = 'categories';

    protected $attributes = ['id', 'name', 'isPinned', 'createdAt', 'updatedAt', 'orderId', 'isPublic'];

    // protected $connection = 'backup';

    public static function factory()
    {
        return new self();
    }
}
