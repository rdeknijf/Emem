<?php

/**
 * Description of Table
 *
 * @author Rutger de Knijf
 */
class Emem_Model_Project_Table extends Zend_Db_Table_Abstract {

    protected $_name = 'projects';
    protected $_primary = array('id');
    protected $_rowClass = 'Emem_Model_Project';
    
}