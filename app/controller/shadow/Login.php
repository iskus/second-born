<?php

namespace app\controller\shadow;


use app\model\Bro;
use core\sources\UsefulData;

class Login extends Shadow
{
    public function __construct()
    {

        parent::__construct();
    }

    public function index()
    {
        $login = base64_decode(UsefulData::getRequest('emailsh', 'POST'));
        $pass = base64_decode(UsefulData::getRequest('passsh', 'POST'));

        //var_dump(base64_decode($login), base64_decode($pass));
        if ($login && $pass) {
            $prov = getenv('HTTP_REFERER');//определяем страницу с который пришел запрос
            $prov = str_replace(["www.", "http://"], "", $prov);//удаляем www если есть

            if ($prov == SITE_URL . '/shadow/login') {
                $pass = sha1($pass);
                $bro = (new Bro())->getEntitys(['email' => $login, 'pass' => $pass])[1];

                var_dump($_SESSION, $bro);
                if ($bro->role == 'admin') {
                    session_start();//стартуем сессию
                    $_SESSION['logSESS'] = $bro->login;//создаем глобальную переменную
                    header("location: shadow");//переносим пользователя на главную страницу
                    exit;
                } else {
                    header("location: shadow/login");//переносим на форму авторизации
                    exit;
                }
            } else//если запрос был послан с другого адреса
            {
                header("location: shadow/login");//переносим на форму авторизации
                exit;
            }


        } else {
            $this->view->createContent();
        }

        //var_dump($this->view);
    }

}