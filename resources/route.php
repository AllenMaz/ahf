<?php
require_once "../config/app.php";
require_once "../framework/Utility/route-helper.php";
?>
<?php
use \framework\utility\RouteHelper;

$_DocumentPath = $_SERVER['DOCUMENT_ROOT'];
//当前请求的URI，不包含参数
$requesturi = $_REQUEST['requesturi'];
//根据斜杠截取uri
$uriarray = explode("/", $requesturi);

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
        die('在'.$controller_with_namespace.'中不存在方法'.$routeconfig['action']);
    }else{
        //将当期路由信息存入全局变量
        $GLOBALS['route_config'] = $routeconfig;
        //调用action
        $obj_controller->$routeconfig['action']();
    }

}else{

    die('URL错误');
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
        $actionnamearr = explode('.',$uriarray[count($uriarray)-1]);
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

