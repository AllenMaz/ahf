<?php
/**
 * Created by PhpStorm.
 * User: Allen
 * Date: 2016/12/19
 * Time: 14:20
 */
namespace framework\core;
class RouteHelper
{
    //将命名空间转换为对应的文件夹目录
    static function ConverNamespaceToFloder($namespace)
    {
        if(!isset($namespace)) return $namespace;

        $floder = str_ireplace(CONTROLLER_NAMESPACE,'',$namespace); //去除基础命名空间
        $floder = trim($floder,'/\/');    //去除字符串两边的反斜杠
        $floder = str_ireplace('/\/','/',$floder); //将反斜杠替换为斜杠

        return $floder;
    }
}