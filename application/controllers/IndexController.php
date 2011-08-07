<?php

class IndexController extends \Zend\Controller\Action
{
    public function indexAction()
    {
        $form = new Zend\Form\Form;
        $form->addElement('text', 'text');
        $form->addElement('submit', 'submit');
        $form->text->setValue('kiev');
        $this->view->form = $form;

        $repository = new Application\Service\Repository\Tweet;
        $this->view->tweetsCollection = $repository->search($form->text->getValue());

        $map = new Application\Model\Map;
        $this->view->tweetsCenter = $map->findCenter($this->view->tweetsCollection);
    }
}

