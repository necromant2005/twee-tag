<?php
namespace Application\Model\DbTable;
use Zend\Db\Table\Table;

class UsernameLocation extends Table
{
    protected $_name = 'username_location';
    protected $_primary = 'username';
}

