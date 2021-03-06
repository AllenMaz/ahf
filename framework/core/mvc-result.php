<?php
/**
 * Created by PhpStorm.
 * User: Allen
 * Date: 2016/12/19
 * Time: 16:51
 */
namespace framework\core;

require_once dirname(__DIR__) . '/core/route-helper.php';
use \framework\core\RouteHelper;

trait MVCResult
{
    function view($action =null,$controller=null,$params = array())
    {
        $view_extra_floder = null;
        if (!isset($action) && !isset($controller)) {
            //如果未设置action及controller则从配置文件中获取
            //获取当前路由信息
            $route_config = $GLOBALS['route_config'];
            $namespace = $route_config['namespace'];
            $controller = $route_config['controller'];
            $action = $route_config['action'];

            $view_extra_floder = RouteHelper::ConverNamespaceToFloder($namespace);


        } else if (isset($action) && !isset($controller)) {
            //如果只设置action，未设置controller则
            $controller = isset($controller) ? $controller : get_called_class();
        }

        $view_file = VIEW_DIR;
        if(isset($view_extra_floder)) $view_file .=$view_extra_floder.'/';
        $view_file .= $controller.'/'.$action.'.php';

        //判断view文件是否存在
        if(file_exists($view_file)) {

            $templete = dirname(dirname(__DIR__)).'/resources/views/Shared/_Layout.php';
            if(file_exists($templete))
            {
                //加载模板文件
                setViewBody($view_file);
                require_once dirname(dirname(__DIR__)).'/resources/views/Shared/_Layout.php';
            }else{
                //加载当前文件
                require_once $view_file;
            }
            //require_once $view_file;
            die();
        }else{
            die('视图不存在');
        }
    }

    function json_result($result)
    {
        echo json_encode($result);
    }
}