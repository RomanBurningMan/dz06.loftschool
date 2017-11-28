<?php
/**
 * Created by PhpStorm.
 * User: пользователь
 * Date: 26.11.2017
 * Time: 15:52
 */

namespace App;


class Submit extends MainController
{
    public function index() {
        $recapt = new \ReCaptcha\ReCaptcha('6LfSTzoUAAAAAKlVu-8_Qp-mUPle_HgJykOY08Ng');
        $response = $recapt->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
        if ($response->isSuccess()){
            $db = new dbQuery();
            $data = $db->query();
        } else {
            $recapthcaError = "Вы не подтвердили, что вы не робот.";
            die($recapthcaError);
        };
        $this->view->renderTwig('submit', $data);
    }
}