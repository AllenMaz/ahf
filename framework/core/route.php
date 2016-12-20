<?php
namespace framework\core;

require_once dirname(__DIR__) . "/core/route-helper.php";

use \framework\core\RouteHelper;

//当前请求的URI，不包含参数
$requesturi = isset($_REQUEST['requesturi'])?$_REQUEST['requesturi']:'';
//根据斜杠截取uri
$uriarray = explode("/", $requesturi);
//过滤空值
$uriarray = array_filter($uriarray);

//只有满足条件的uri才进行路由分发，否则返回404
if(CanDeliverRoute())
{
    //默认路由配置
    $routeconfig = array(
        'namespace'=>'\controllers',
        'controller' => 'home',
        'action' => 'index',
        'parms' => array()
    );
    $namespace = GetNamespace($uriarray);
    $controller = GetController($uriarray);
    $action = GetAction($uriarray);
    $routeconfig['namespace'] = empty($namespace) ? $routeconfig['namespace'] :$routeconfig['namespace'].$namespace;
    $routeconfig['controller'] = empty($controller) ? $routeconfig['controller'] :$controller;
    $routeconfig['action'] = empty($action) ? $routeconfig['action'] :$action;

//将命名空间转换为
    $controller_floader = RouteHelper::ConverNamespaceToFloder($routeconfig['namespace']);

    $controller_file = CONTROLLER_DIR;
    if(isset($controller_floader) && !empty($controller_floader)) $controller_file .= $controller_floader.'/';
    $controller_file .= $routeconfig['controller'].'.controller.php';

//判断controller文件是否存在
    if(file_exists($controller_file))
    {
        //添加controller文件的引用
        require $controller_file;

        //初始化controller类的实例
        $controller_with_namespace = $routeconfig['namespace'].'\\'.$routeconfig['controller'].'controller';
        //根据命名空间初始化类
        $obj_controller = new $controller_with_namespace;

        //校验controller中是否存在要调用的action
        if(!method_exists($obj_controller,$routeconfig['action']))
        {
            trigger_error('在'.$controller_with_namespace.'中不存在方法'.$routeconfig['action'],E_ERROR);
        }else{
            //将当期路由信息存入全局变量
            $GLOBALS['route_config'] = $routeconfig;
            //调用action
            $obj_controller->$routeconfig['action']();
        }

    }else{

        trigger_error('找不到controller文件，'.$controller_file,E_ERROR);
    }
}else{
    //找不到文件404
    @header("http/1.1 404 Not Found");
    @header("status: 404 Not Found");
}

//检验uri是否进入路由分发
function CanDeliverRoute()
{
    global $requesturi;
    $canDeliverRoute = true;
    //去除uri两边的斜杠
    $requesturi = strtolower(trim($requesturi,'/\/'));
    //校验必须以.php结尾
    if(!empty($requesturi) && !preg_match('/.*.php$/',$requesturi))
    {
        $canDeliverRoute = false;
    }
    return $canDeliverRoute;
}

function GetController($uriarray)
{
    $controllername = "";
    if(count($uriarray) >=2)
    {
        $controllername = $uriarray[count($uriarray)-2];
    }
    return $controllername;
}

function GetAction($uriarray)
{
    $actionname = "";
    if(count($uriarray) >=1)
    {
        $actionphp = $uriarray[count($uriarray)-1];
        $actionnamearr = explode('.',$actionphp);
        $actionname = $actionnamearr[0];
    }
    return $actionname;
}

function GetNamespace($uriarray)
{
    $namespace = "";
    if(count($uriarray) >2)
    {
        for($i=0;$i<count($uriarray)-2;$i++)
        {
           $namespace .= '\\'.$uriarray[$i];

        }
    }
    return $namespace;
}
?>

