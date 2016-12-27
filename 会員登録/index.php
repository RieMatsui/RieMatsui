<?php
session_start();
require('dbconnect.php');

if(isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    //ログインしている
    $_SESSION['time'] = time();

    $sql = sprintf('SELECT * FROM members WHERE id=%d',
        mysqli_real_escape_string($db,$_SESSION['id']));
        $record = mysqli_query($db, $sql) or die(mysqli_error($db));
        $member = mysqli_fetch_assoc($record);
    }

    else{
         //ログインしていない
        header('Location:login.php');
        exit();
    }


//投稿を記録する
if(!empty($_POST)){
    if($_POST['message'] !=''){
        $sql = sprintf('INSERT INTO posts SET member_id=%d,message="%s",created=NOW()',
        mysqli_real_escape_string($db,$member['id']),
        mysqli_real_escape_string($db,$_POST['message'])
        );
        mysqli_query($db,$sql) or die(mysqli_error($db));

        header('Location:index.php');
        exit();
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<title>ひとこと掲示板</title>
</head>

<body>
<div id="wrap">
<div id="head">
<h1>ひとこと掲示板</h1>
</div>

<div id="content">
   <form action="" method="post">
     <dl>
        <dt><?php echo htmlspecialchars($member['name']); ?>さん、メッセージをどうぞ</dt>
        <dd>
        <textarea name = "message" cols="50" rows="5"></textarea>
        </dd>
     </dl>
     <div>
         <input type="submit" value="投稿する"/>
     </div>
    </form>
</div>
<div id="foot">
<p><img src="images/txt_copyright.png" width="136" height="15" alt="(C) H2O Space. MYCOM" /></p>
</div>

</div>
</body>
</html>
