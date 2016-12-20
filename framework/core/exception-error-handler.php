<?php
/**
 * Created by PhpStorm.
 * User: Allen
 * Date: 2016/12/20
 * Time: 9:36
 */
namespace framework\core;

class exception_error_handler{

    function init_exception_handler()
    {
        set_exception_handler(array($this,'exception_handler'));
    }

    function init_error_handler()
    {
        set_error_handler(array($this, 'error_handler'),E_USER_ERROR);
    }

   function error_handler($error_level,$error_message,$error_file,$error_line,$error_context)
    {
        @header("http/1.1 500 Internal server error");
        @header("status: 500 Internal server error");
        //记录错误消息到日志
        error_log("Error: [$error_level] $error_message \n\r line:$error_line $error_file \n\r",0);

        include dirname(dirname(__DIR__))."/resources/500.html";//跳转到错误页面
        die();
    }

    function exception_handler($exception)
    {
        @header("http/1.1 500 Internal server error");
        @header("status: 500 Internal server error");
        //记录错误消息到日志
        error_log("Exception:".$exception->getMessage()."\n\r line:".$exception->getLine()."   ".$exception->getFile()." \n\r",0);

        include dirname(dirname(__DIR__))."/resources/500.html";//跳转到错误页面
        die();
    }
}
//定义全局错误处理
$error = new exception_error_handler();
$error->init_error_handler();
$error->init_exception_handler();


