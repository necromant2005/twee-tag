<?php
namespace Application\Service\DbTable;
use Zend\Db\Table\Table;

class UsernameLocation extends Table
{
    protected $_name = 'username_location';
    protected $_primary = 'username';
}

