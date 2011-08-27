<?php

/** @namespace */
namespace Application\Service\Repository;
use Application\Service\DbTable;
use Application\Service\Collection\Collection;

class Spam
{
    private $_dbTable = null;

    public function __construct()
    {
        $this->_dbTable = new DbTable\Spam;
    }

    public function add($username)
    {
        try {
            $this->_dbTable->insert(array('username'=>$username));
        } catch (\Zend\Db\Statement\Exception $e) { }
    }

    public function getItems()
    {
        $collection = new Collection;
        foreach ($this->_dbTable->fetchAll() as $item) {
            $collection->append($item->username);
        }
        return $collection;
    }
}

