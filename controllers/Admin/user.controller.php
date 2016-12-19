<?php
namespace controllers\admin;

require_once dirname(dirname(__FILE__)).'\base.controller.php';

use controllers\BaseController;

class UserController extends BaseController{

    function Index()
    {

        $this->view();
    }

    function test(){

        $this->json_result('allen');
    }

}