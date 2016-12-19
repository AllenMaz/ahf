<?php
/**
 * Created by PhpStorm.
 * User: Allen
 * Date: 2016/12/16
 * Time: 14:01
 */
namespace controllers;

require_once "base.controller.php";

class HomeController extends BaseController
{
    function Index()
    {
        $this->view();
    }
}