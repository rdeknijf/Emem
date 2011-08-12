<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Galleria
 *
 * @author Rutger de Knijf
 */
class Emem_View_Helper_Galleria extends Zend_View_Helper_Abstract {
    
    public function galleria(Emem_Model_Project $project) {

        $config = Zend_Registry::get('config');
        
        $html = '';
        
        $html .= '<div id="gallery">';
        
        foreach ($project->getImages() as $image) {
            
            $html .= sprintf('<img src="%s">', $image);
            
        }
        
        $html .= '</div">';        
        
        $html .= sprintf('<script>var galWidth = %s; var galHeight = %s;</script>', $config->galleria_width, $config->galleria_height);
        
        $this->loadJs();
        
        return $html;

    }
    
    private function loadJs() {
        
        if (APPLICATION_ENV == 'development') {    
            
            $this->view->headScript()->appendFile('//ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.js');      
            $this->view->headScript()->appendFile('/master/lib/galleria/galleria-1.2.3.js');     
            
        } else {
            
            $this->view->headScript()->appendFile('//ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js');    
            $this->view->headScript()->appendFile('/master/lib/galleria/galleria-1.2.3.min.js');              
        }    
        
        $this->view->headScript()->appendScript("window.jQuery || document.write(\"<script src='/master/js/lib/jquery-1.5.2.min.js'>\x3C/script>\")");    
        
        
        
        $this->view->headScript()->appendFile('/master/js/script.js');   
        
    }
    
}

?>
