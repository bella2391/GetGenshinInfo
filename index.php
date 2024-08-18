
<?php
session_start();
require("./function/getGenshinInfo.php");

$access_deny = false;
if(!empty($_POST))
{
    if(isset($_POST["uid-input"])) 
    {
        if(isset($_SESSION["token"]) && $_SESSION["token"] == $_POST["token"])
        {
            $checkOK = true;
            $uid_input = $_POST["uid-input"];
            $_SESSION["tmp-uid"] = $uid_input;
            getApi($uid_input);
        }
        else
        {
            $access_deny = true;
        }
    }
}

$TOKEN_LENGTH = 16;
$tokenByte = openssl_random_pseudo_bytes($TOKEN_LENGTH);
$token = bin2hex($tokenByte);
$_SESSION['token'] = $token;
//echo "<br>".$_SESSION["token"]."<br>";
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./assets/css/base.css">
        <link rel="stylesheet" href="./assets/css/genshin.css">
    </head>
    <body>
        <?php 
        if($access_deny)
        {
            die("<div class='access-deny font3-0'>Access denied.</div>");
        }
        ?>
        <form action="" method="POST" >
            <label class="font2-0">
                Genshin-UID
                <?php if(isset($_SESSION["tmp-uid"])): ?>
                    <input type="text" name="uid-input" value="<?=$_SESSION["tmp-uid"]?>">
                <?php else: ?>
                    <input type="text" name="uid-input">
                <?php endif; ?>
            </label>
            <input type="hidden" name="token" value="<?=$_SESSION["token"]?>">
            <input type="submit">
        </form>
    </body>
</html>
<?php
exit();
?>