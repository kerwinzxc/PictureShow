<?php
/**
 * User: loveyu
 * Date: 2015/12/8
 * Time: 23:18
 */
error_reporting(E_ALL);
session_start();


define("G_USER_NAME", "admin");
define("G_PASSWORD", "123456");
define("G_DEFAULT_PATH", __DIR__ . "/");
define("G_SYSTEM_ENCODING", "GBK");
define("G_PRO_ENCODING", "UTF-8");
define("G_PICTURE_EXT_LIST", "jpg,png,gif,jpeg,bmp");


function check_login()
{
    if (!is_login()) {
        header("Location: login.php");
        exit;
    }
}

function is_login()
{
    return isset($_SESSION['is_login']) && $_SESSION['is_login'] == true;
}

function login($user, $pwd)
{
    if ($user === G_USER_NAME && $pwd === G_PASSWORD) {
        $_SESSION['is_login'] = true;
        $status = true;
    } else {
        $status = false;
    }
    return $status;
}

function get_utf8_path($sys_path)
{
    if (G_SYSTEM_ENCODING == G_PRO_ENCODING) {
        return $sys_path;
    } else {
        return mb_convert_encoding($sys_path, G_PRO_ENCODING, G_SYSTEM_ENCODING);
    }
}

function get_sys_path($path)
{
    if (G_SYSTEM_ENCODING == G_PRO_ENCODING) {
        return $path;
    } else {
        return mb_convert_encoding($path, G_SYSTEM_ENCODING, G_PRO_ENCODING);
    }
}

function get_default_path()
{
    return get_utf8_path(G_DEFAULT_PATH);
}

function get_path_list($path)
{
    $rt = array(
        'dir' => array(
            array(
                'name' => "..",
                'path' => dirname($path) . "/"
            )
        ),
        'file' => array()
    );
    $path = get_sys_path($path);
    $handle = opendir($path);
    if (!$handle) {
        return $rt;
    }
    while ($file = readdir($handle)) {
        if (($file == ".") || ($file == "..")) {
            continue;
        }
        if (is_file($path . "/" . $file)) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            if (in_ext_list($ext)) {
                $rt['file'][] = array(
                    'name' => get_utf8_path($file),
                    'path' => get_utf8_path(realpath($path . "/" . $file)),
                    'size' => format_size(filesize($path . "/" . $file))
                );
            }
        } elseif (is_dir($path . "/" . $file)) {
            $rt['dir'][] = array(
                'name' => get_utf8_path($file),
                'path' => get_utf8_path(realpath($path . "/" . $file) . "/"),
            );
        }
    }
    closedir($handle);
    return $rt;
}

function in_ext_list($ext)
{
    $list = array_map("strtolower", array_map("trim", explode(",", G_PICTURE_EXT_LIST)));
    return in_array(strtolower($ext), $list);
}

/**
 * 格式化文件大小
 * @param $arg
 * @return string
 */
function format_size($arg)
{
    if ($arg > 0) {
        $j = 0;
        $ext = array(
            " bytes", " KB", " MB", " GB", " TB"
        );
        while ($arg >= pow(1024, $j)) {
            ++$j;
        }
        return round($arg / pow(1024, $j - 1) * 100) / 100 . $ext[$j - 1];
    } else {
        return "0 bytes";
    }
}


function show_403($msg)
{
    header('HTTP/1.0 403 Forbidden');
    echo $msg ? $msg : "Deny";
    exit;
}