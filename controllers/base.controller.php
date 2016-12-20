<?php
/**
 * Created by PhpStorm.
 * User: Allen
 * Date: 2016/12/19
 * Time: 11:22
 */
namespace controllers;

require_once dirname(__DIR__).'/framework/core/mvc-result.php';
use framework\core\MVCResult;

class BaseController
{
    use MVCResult;
}