<?php
use Application\Model;
use Application\Service\Repository as Repository;
use Application\Service\Collection\Collection;

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
        $form = $this->view->form;
        $form->isValid($this->_getAllParams());

        $collection = new Collection(array('KievAllAdv', 'donnerusse'));

        $repository = new Repository\Tweet;
        $tweets = $repository
            ->search($form->text->getValue())
            ->filter(new Model\Tweet\Specification\NoAdv($collection));

        $this->view->tweets = $tweets;
        $this->view->map    = new Model\Map($tweets);
    }

    public function spamAction()
    {
        $this->view->name = $this->_getParam('name');
        $repository = new Repository\Spam;
        $repository->add($this->_getParam('name'));
    }
}

