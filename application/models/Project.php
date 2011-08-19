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

    public function getSubtitle() {

        return $this->subtitle;

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
    public function getContent($forceRaw = false) {

        if (strlen($this->descr) > 1) {

            if ($forceRaw) return $this->descr;


            $descr = $this->descr;

            if ($descr[0] != '<') $descr = '<p>' . $descr . '</p>';

            return $descr;

        }

        return false;
    }

    public function getPromoImg() {

        $config = Zend_Registry::get('config');

        return $config->www_projects_img_path . '/' . $this->getName() . '.jpg';



    }


    /**
     * Returns the list of paths to the .jpg files that are accociated with this project
     */
    public function getImgs() {

        $config = Zend_Registry::get('config');

        $project_img_path = $config->srv_projects_img_path . '/' . $this->getName();

//        Zend_Debug::dump($project_img_path);
//        Zend_Debug::dump(realpath($project_img_path));
//
//        die();



        if (is_dir($project_img_path)) {

            $loadfiles = scandir($project_img_path);

            $iter = 0;

            foreach($loadfiles as $file) {

                $ext = @substr($file, -4);

                //Zend_Debug::dump($file);


                if ($ext == '.jpg') {

                    $img['thumb'] = $config->www_projects_img_path . '/' . $this->getName() . '/thumbs/' . $file;
                    $img['big'] = $config->www_projects_img_path . '/' . $this->getName() . '/' . $file;

                    $files[] = $img;

                    $iter++;
                    if($iter >= 25) break; //max 25 imgs

                }

            }

            //Zend_Debug::dump($files);



            if (@$files) {

                return $files;

            }

            return false;

        }

    }
}