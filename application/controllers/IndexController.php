<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {

        $projectsTable = new Emem_Model_Project_Table;

        $this->view->projects = $projectsTable->fetchAll($projectsTable->select()->order('priority DESC'));




    }


}