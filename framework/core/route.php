<?php
require_once dirname(dirname(__DIR__))."/config/app.php";
require_once dirname(__DIR__)."/Utility/route-helper.php";
?>
<?php
use \framework\utility\RouteHelper;

//当前请求的URI，不包含参数
$requesturi = $_REQUEST['requesturi'];
//根据斜杠截取uri
$uriarray = explode("/", $requesturi);
//过滤空值
$uriarray = array_filter($uriarray);

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
        $actionphp = $uriarray[count($uriarray)-1];
        //校验必须以.php结尾
        if(!preg_match('/.*.php$/',$actionphp))
        {
            @header("http/1.1 500 Server Error");
            @header("status: 500 Server Error");
            $GLOBALS['error_500'] ='URL错误';
            include "500.php";//跳转到某一个页面，推荐使用这种方法
        }
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

