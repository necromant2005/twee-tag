<?php
use Application\Model as Model;
use Application\Service\Repository as Repository;
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

        $specification = new Model\Tweet\Specification\NoAdv;
        $specification->addFrom('@KievAllAdv');
        $repository = new Repository\Tweet;
        $tweets = $repository
            ->search($this->view->form->text->getValue())
            ->filter($specification);

        $map = new Application\Model\Map;
        $this->view->mapCenter = $map->findCenter($tweets);
        $this->view->mapZoom   = $map->findZoom($tweets);
        $this->view->tweets    = $tweets;
    }
}

