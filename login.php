<?php
// 用 __DIR__ 确保 100% 找到 config.php
require __DIR__ . '/config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 获取表单数据
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // 准备 SQL 查询
    $sql = "SELECT id, password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $user_id, $hashed_password);
    mysqli_stmt_fetch($stmt);

    // 验证账号密码
    if (mysqli_stmt_num_rows($stmt) > 0 && password_verify($password, $hashed_password)) {
        // 登录成功，设置 session
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        // 跳转到首页
        header("Location: index.html");
        exit();
    } else {
        // 登录失败
        echo "<script>alert('Wrong username or password');history.back();</script>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>