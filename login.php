<?php
require_once "common.php";
if (is_login()) {
    header("Location: index.php");
    exit;
}
$error = "";
if (isset($_POST['login'])) {
    if (isset($_REQUEST['user']) && isset($_REQUEST['password']) && login($_REQUEST['user'], $_REQUEST['password'])) {
        header("Location: index.php");
        exit;
    } else {
        $error = "密码错误";
    }
}
header("Content-Type: text/html; charset=utf-8");
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>登录</title>
    <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <form action="login.php" method="post">
                    <h3>用户登录</h3>
                    <?php if ($error): ?>
                        <p class="text-danger"><?php echo $error ?></p>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="exampleInputEmail1">用户名</label>
                        <input type="text" class="form-control" name="user" id="exampleInputEmail1"
                               placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">密码</label>
                        <input type="password" class="form-control" name="password" id="exampleInputPassword1"
                               placeholder="Password">
                    </div>
                    <input type="hidden" name="login">
                    <button type="submit" class="btn btn-default">登录</button>
                </form>
            </div>
    </div>
</div>
</body>
</html>
