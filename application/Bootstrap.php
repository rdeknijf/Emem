<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initConfig() {

        $oConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', 'general');

        Zend_Registry::set('config', $oConfig);


    }

//    protected function _initRoutes() {
//
//        $fc = Zend_Controller_Front::getInstance();
//
//        $router = $fc->getRouter();
//
//        $router->addRoute(
//                'index',
//                new Zend_Controller_Router_Route(
//                        '/:action',
//                        array(
//                            'controller' => 'index'
//                            )
//                        )
//                );
//
//    }

    public function _initBase() {

        $config = Zend_Registry::get('config');

        ///// LAYOUT /////

        $view = $this->bootstrap('view')->getResource('view');


        //. CSS
        $view->headLink()->appendStylesheet('/assets/css/emem.css');


        //. JS
        $view->headScript()->appendFile('/assets/js/emem.js');

        // META
        $view->headTitle()->setSeparator(' - ')
             ->headTitle($config->sitetitle);
        //$view->headMeta()->setHttpEquiv('X-UA-Compatible', 'IE=edge,chrome=1'); // in htaccess
        $view->headMeta('description', $config->site->description);
        $view->headMeta('keywords', $config->site->keywords);
        $view->headMeta('author', $config->site->author);






//        /* @var $layout Zend_Layout */
//        $layout = $this->getResource('layout');
//
//        ///// VIEW /////
//
//        /* @var $view Zend_View */
//        $view = $layout->getView();
//
//        //. fix view helper loading
//        $view->addHelperPath(APPLICATION_PATH . '/views/helpers/', 'Zend_View_Helper'); //for some reason this link is not active yet at bootstrap




//        if ($this->getEnvironment() != 'production') {
//
//            $debugstr = 'Env: ' . $this->getEnvironment();
//            $debugstr .= ' | AppName: Emem';
//
//            $view->footerdebug = "<p id=\"footerdebug\">$debugstr</p>";
//
//        }
        //. headscript







//        //navigation
//        $config = new Zend_Config_Xml(APPLICATION_PATH . '/configs/nav.xml', 'nav');
//        $container = new Zend_Navigation($config);
//        $view->navigation($container);
    }


}

