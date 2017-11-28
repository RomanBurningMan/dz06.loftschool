<?php

namespace App;

use Twig_Loader_Filesystem;
use Twig_Environment;

class View
{
//    public function render(String $filename, array $data)
//    {
//        require_once __DIR__ . "/../views/" .$filename.".php";
//    }

    public function renderTwig(String $filename, array $data) {
        $loader = new Twig_Loader_Filesystem(__DIR__.'/../templates/');
//        $twig = new Twig_Environment($loader, array(
//            'cache' => __DIR__.'/../templates_c/',
//        ));
        $twig = new Twig_Environment($loader);

        echo $twig->render($filename.".html", $data);
    }
}

