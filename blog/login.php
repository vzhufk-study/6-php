<!DOCTYPE html>
<?php
include_once "../private/DBPropertyManager.php";
include_once "../Entities/User.php";

session_start();

function login($login, $password, $link)
{
    // Using prepared statements means that SQL injection is not possible.
    $q = 'SELECT * FROM `user` WHERE `login`="'.$login .'" LIMIT 1';
    if ($stmt = $link->query($q)) {

        // get variables from result.
        $user = new User($stmt->fetch_object());
        $salt = $user->getSalt();
        // hash the password with the unique salt.
        $password = hash('sha512', $password . $salt);
        if ($user->getPassword() == $password) {

            echo "here";
            // Password is correct!
            // Get the user-agent string of the user.
            $user_browser = $_SERVER['HTTP_USER_AGENT'];
            // XSS protection as we might print this value
            $_SESSION['user'] = $user;
            // Login successful.
            return true;
        } else {
            return false;
        }
    }
}

$db = new DBPropertyManager();
$db->link();
$db->select_db("blog");
$link = $db->getLink();


if ($_SERVER["REQUEST_METHOD"]=="POST") {
    if (login($_POST["login"], $_POST["password"], $link)){
        header('Location: index.php');
    }
}
?>
<html>
<?php
$page_title = "Orel.com";
include "parts/head.php";
?>
<body>
<?php
$page_thumbnail = "Залогінся, якщо рідний.";
include "parts/navigation.php";
?>
<div class="content">
    <div class="container">
        <div class="post">
            <form method="post">
                <table>
                    <tr>
                        <th>Логін: </th><td><input name="login" type="text"></td>
                    </tr>
                    <tr>
                        <th>Пароль: </th><td><input name="password" type="password"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;"><button type="submit" class="btn btn-black"><i class="fa fa-home"></i>Постукати в двері</button></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;"><button type="reset" onclick="location.href = 'signup.php';" class="btn btn-grey"><i class="fa fa-check-square-o"></i>Представити себе вперше</button></td>
                    </tr>
                </table>
            </form>
        </div>
        <?php
        include "parts/footer.php";
        ?>
        <!-- Javascript -->
        <script src="js/jquery.min.js"></script>
        <script src="js/kube.min.js"></script>
</body>
</html>