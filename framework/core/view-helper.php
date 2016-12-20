<?php
/**
 * Created by PhpStorm.
 * User: Allen
 * Date: 2016/12/20
 * Time: 12:03
 */

function setViewTitle($title)
{
    $GLOBALS[VIEW_TITLE] = $title;
}
function getViewTitle()
{
    return $GLOBALS[VIEW_TITLE];
}

function setViewBody($body)
{
    $GLOBALS[VIEW_BODY]=$body;
}
function getViewBody()
{
    return $GLOBALS[VIEW_BODY];
}

