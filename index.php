<?php
/**
 * User: loveyu
 * Date: 2015/12/8
 * Time: 23:14
 */
require_once "common.php";
check_login();
$path = isset($_GET['path']) ? $_GET['path'] : null;
if (empty($path)) {
    header("Location: ?path=" . urlencode(get_default_path()));
    exit;
}
header("Content-Type: text/html; charset=utf-8");
if (!is_dir(get_sys_path($path))) {
    die("路径不存在");
}
$map = get_path_list($path);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>列表</title>
    <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h3>图片列表</h3>

    <div class="well well-sm">当前路径：<code><?php echo $path ?></code></div>
    <div class="panel panel-default">
        <div class="panel-body" style="line-height: 2.1">
            <?php foreach ($map['dir'] as $dir): ?>
                <a href="?path=<?php echo urlencode($dir['path']) ?>"
                    <?php if ($dir['name'] == ".."): ?> title="上级目录"
                    <?php endif ?> class="btn btn-sm btn-success"><?php echo $dir['name'] ?></a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <?php if (empty($map['file'])): ?>
                <p class="text-danger">当前没有任何可以显示的图片。</p>
            <?php else: ?>
                <ul class="list-group">
                    <?php foreach ($map['file'] as $file): ?>
                        <li class="list-group-item">
                            <span class="badge"><?php echo $file['size'] ?></span>
                            <span class="glyphicon glyphicon-picture"></span>
                            <a href="read_img.php?path=<?php echo urlencode($file['path']) ?>" class="btn btn-link"
                               target="_blank"><?php echo $file['name'] ?></a></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>

