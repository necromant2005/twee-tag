<?php

class IndexController extends \Zend\Controller\Action
{
    public function init()
    {
        $this->view->form = new Application\Form\Search;
    }

    public function indexAction()
    {

    }

    public function searchAction()
    {
        $this->view->form->isValid($this->_getAllParams());

        $repository = new Application\Service\Repository\Tweet;
        $this->view->tweets = $repository->search($this->view->form->text->getValue());

        $map = new Application\Model\Map;
        $this->view->mapCenter = $map->findCenter($this->view->tweets);
        $this->view->mapZoom   = $map->findZoom($this->view->tweets);
    }
}

