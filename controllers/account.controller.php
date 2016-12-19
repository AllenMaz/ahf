<?php
/**
 * Created by PhpStorm.
 * User: Allen
 * Date: 2016/12/19
 * Time: 9:52
 */
namespace controllers;

use models\test;

require_once "base.controller.php";
require_once "../model/test.php";

class AccountController extends BaseController
{
    function login()
    {
        $name = $_POST["name"];
        $this->view();
    }

    function register()
    {
        $test = new test();
        $test->message ="Hello Json";
        $test->status =true;
        $this->json_result($test);
    }
}
