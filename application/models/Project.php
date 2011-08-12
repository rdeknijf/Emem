<?php

/**
 * Description of Table
 *
 * @author Rutger de Knijf
 */
class Emem_Model_Project extends Zend_Db_Table_Row_Abstract {
    
    /********** GETTERS ***********/
    
    public function getId() {
        
        return (int) $this->id;
        
    }
    
    public function getName() {
        
        return $this->name;
        
    }
    
    public function getTitle() {
        
        if (!is_null($this->title)) return $this->title;
        else return ucfirst ($this->name);
        
    }


    public function getDate() {
        
        return new Zend_Date($this->date, Zend_Date::TIMESTAMP);        
        
    }
    
    /**
     * Detects whether the description has it's own html
     * If not it wraps it in p-tags
     * 
     * @param string $forceRaw Force raw input
     * @return string 
     */
    public function getDescription($forceRaw = false) {
        
        if (strlen($this->descr) > 1) {

            if ($forceRaw) return $this->descr;

            $descr = trim($this->descr);

            if ($descr[0] != '<') $descr = '<p>' . $descr . '</p>';                   

            return $descr;
            
        } 
        
        return false;
    }


    /**
     * Returns the list of paths to the .jpg files that are accociated with this project
     */
    public function getImages() {        
        
        $config = Zend_Registry::get('config');
        
        $project_img_path = $config->srv_projects_img_path . '/' . $this->getName(); 
        
        if (is_dir($project_img_path)) {

            $dir = opendir($project_img_path);

            $iter = 0;

            while ($file = readdir($dir)) {

                $ext = @substr($file, -4);

                if ($ext == '.jpg') {                    

                    $files[] = $config->www_projects_img_path . '/' . $this->getName() . '/' . $file;
                    $iter++;
                    if($iter >= 25) break; //max 25 imgs

                }

            }
            
            if (@$files) {

                return $files;
                
            }
            
            return false;
        
        }   
    
    }
}