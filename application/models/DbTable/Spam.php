<?php
namespace Application\Model\DbTable;
use Zend\Db\Table\Table;

class Spam extends Table
{
    protected $_name = 'spam';
    protected $_primary = 'username';
}

