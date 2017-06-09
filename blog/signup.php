
<!DOCTYPE html>
<html>
<?php
$page_thumbnail = "Розкажи про себе.";
$page_title = "Orel.com";
include "parts/head.php";
include_once "../private/DBPropertyManager.php";
include_once "../Entities/User.php";

$error_msg = "";
$valid = false;

if (isset($_POST['login'], $_POST['email'], $_POST['password'])) {
    // Sanitize and validate the data passed in
    $db = new DBPropertyManager();
    $db->link();
    $db->select_db("blog");
    $link = $db->getLink();

    $username = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
        $error_msg .= '<p class="error">The email address you entered is not valid</p>';
    }

    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    // Username validity and password validity have been checked client side.
    // This should should be adequate as nobody gains any advantage from
    // breaking these rules.
    //

    $prep_stmt = "SELECT id FROM members WHERE email = ? LIMIT 1";
    $stmt = $db->getLink()->prepare($prep_stmt);
    echo $error_msg;
    if (empty($error_msg)) {
        // Create a random salt
        $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));

        // Create salted password
        $password = hash('sha512', $password . $random_salt);
        // Insert the new user into the database
        $admin = 0;
        if (isset($_POST["admin"])) {
            $admin = ($_POST["admin"]) ? (1) : (0);
        }
        $user = new User((object)["login"=>$_POST["login"], "email"=>$_POST["email"], "password"=>$password, "admin"=>$admin, "salt"=>$random_salt]);
        $user->relate($db);
        $user->insert();

        $page_thumbnail = "Красиво то як!";
        $valid = true;
    }
}

?>
        <body>
        <?php
        include "parts/navigation.php";
        if (!$valid) {
            ?>
        <div class="content">
            <div class="container">
            <div class="post">
                <form method="post" style="margin-left, margin-right: auto;">
                    <table>
                        <tr>
                        <th>Логін:</th><td><input name="login" type="text"></td>
                        </tr>
                        <tr>
                            <th>Пароль:</th><td><input name="password" type="password"></td>
                        </tr>
                        <tr>
                            <th>Пошта:</th><td><input name="email" type="email"></td>
                        </tr>
                        <tr>
                            <th>Адміністратор:</th><td><input type="checkbox" disabled name="admin"></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;"><button type="submit" class="btn btn-black"><i class="fa fa-check-square-o"></i>Сказти своє ім'я</button></td>
                        </tr>
                    </table>
                </form>
            </div>
            </div>
        </div>
            <?php
        }
        include "parts/footer.php";
        ?>
        <!-- Javascript -->
        <script src="js/jquery.min.js"></script>
        <script src="js/kube.min.js"></script>
</body>
</html>
