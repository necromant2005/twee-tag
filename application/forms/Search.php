<?php

/** @namespace */
namespace Application\Form;

class Search extends \Zend\Form\Form
{
    public function init()
    {
        $this->setAction('/index/search')->setMethod('get');
        $this->addElement('text', 'text');
        $this->addElement('submit', 'search');
    }
}

