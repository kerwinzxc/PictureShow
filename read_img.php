<?php
/**
 * User: loveyu
 * Date: 2015/12/9
 * Time: 0:17
 */
require_once "common.php";
if (!is_login()) {
    show_403("Please login.");
}
$path = isset($_GET['path']) ? $_GET['path'] : "";
$ext = pathinfo($path, PATHINFO_EXTENSION);
if (empty($path)) {
    show_403("No empty.");
}
if (!in_ext_list($ext)) {
    show_403("No support.");
}
$path = get_sys_path($path);
if (!is_file($path)) {
    show_403("No found.");
}
$size = filesize($path);
header("Content-Type: image/{$ext}");
header("Content-Length: $size");
header("Content-Disposition:filename=" . basename($path));
flush();
$fp = fopen($path, "r");
while (!feof($fp)) {
    echo fread($fp, 65536);
    flush();
}
fclose($fp);