<?php

/** @namespace */
namespace Application\Service\Repository;
use Application\Service\DbTable;

class Spam
{
    private $_dbTable = null;

    public function __construct()
    {
        $this->_dbTable = new DbTable\Spam;
    }

    public function add($username)
    {
        $this->_dbTable->insert(array('username'=>$username));
    }
}

