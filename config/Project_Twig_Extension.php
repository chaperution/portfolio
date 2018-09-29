<?php 

namespace CP\Portfolio\config;

class Project_Twig_Extension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    public function getGlobals()
    {
        return array(
            'session' => $_SESSION,
            'get' => $_GET,
          	'globals' => $GLOBALS,
        );
    }
}