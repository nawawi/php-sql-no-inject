<?php
/**
 * SQL no inject: possible to remove sql injection
 *
 * Copyright (C) 2014 nawawi jamili <nawawi@rutweb.com>
 *
 * This file is distributed under the terms of the GNU General Public
 * License (GPL). Copies of the GPL can be obtained from:
 * http://www.gnu.org/licenses/gpl.html
 * 
 */

/*
    Usage:
    1) include this file at the top of your PHP scripts
    2) set auto_prepend to this file
    3) use your imagination
*/

if ( !function_exists('array_map_recursive') ) {
    function array_map_recursive($func, $arr) {
	    $new = array();
	    foreach($arr as $key => $value) {
		    $new[$key] = (is_array($value) ? array_map_recursive($func, $value) : ( is_array($func) ? call_user_func_array($func, $value) : $func($value) ) );
	    }
	    return $new;
    }
}

function _remove_sql_inject($str) {
    $str = urldecode($str);
    $pat[] = "/'\s+AND\s+extractvalue.*/i";
    $pat[] = "/'\s+and\(.*/i";
    $pat[] = "/select\s+.*?\s+from.*/i";
    $pat[] = "/(rand|user|version|database)\(.*/i";
    $pat[] = "/union\(.*/i";
    $pat[] = "/CONCAT\(.*/i";
    $pat[] = "/CONCAT_WS\(.*/i";
    $pat[] = "/ORDER\s+BY.*/i";
    $pat[] = "/UNION\s+SELECT.*/i";
    $pat[] = "/'\s+union\s+select\+.*/i";
    $pat[] = "/GROUP_CONCAT.*/i";
    $pat[] = "/delete\s+from.*/i";
    $pat[] = "/update\s+.*?\s+set=.*/i";
    $pat[] = "/'\s+and\s+\S+\(.*/i";
    $pat[] = "/'\s+and\s+\S+\s+\(.*/i";
    return preg_replace($pat,"", $str);
}

if ( !empty($_GET) ) $_GET = array_map_recursive('_remove_sql_inject', $_GET);
if ( !empty($_POST) ) $_POST = array_map_recursive('_remove_sql_inject', $_POST);
if ( !empty($_REQUEST) ) $_REQUEST = array_map_recursive('_remove_sql_inject', $_REQUEST);
if ( !empty($_COOKIE) ) $_COOKIE = array_map_recursive('_remove_sql_inject', $_COOKIE);


