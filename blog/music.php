<!DOCTYPE html>
<html>
<?php
include_once "../private/DBPropertyManager.php";
include_once "../Entities/Song.php";
include_once "../Entities/User.php";

$db = new DBPropertyManager();
$db->link();
$db->select_db("blog");
$link = $db->getLink();

session_start();
if (isset($_SESSION["user"])) {
    $user_login = $_SESSION["user"]->getLogin();
    $edit = $_SESSION["user"]->getAdmin();
}

if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $uploaddir = 'audio////';
    $path = $uploaddir . basename($_FILES['file']['name']);
    move_uploaded_file($_FILES['file']['tmp_name'], $path);

    $date = new DateTime();
    $song = new Song((object)["author"=>$_SESSION["user"]->getId(), "name"=>$_POST["title"], "date"=>$date->format("Y-m-d"), "file"=>$path, "lyrics"=>$_POST["lyrics"]]);
    $song->relate($db);
    $song->insert();
}

$q = "SELECT * FROM  `Song` ORDER BY `date`";
$result = $db->link->query($q) or die("Error while executing:<br>".$q."<br>".mysqli_error($db->link));
$songs = [];
while ($current = $result->fetch_object()){
    $value = new Song($current);
    $value->relate($db);
    $songs[$current->id] = $value;
}


$page_thumbnail = "Гарні композиції від гарної людини.";
$page_title = "Orel.com";
include "parts/head.php";




?>
<body>
<?php
include "parts/navigation.php";
if (isset($user_login)) {
    ?>
    <div class="content">
        <?php if (isset($edit) && $edit == "1") { ?>
            <div class="container">
                <form method="post" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <th>Назва:</th>
                            <td><input type="text" name="title"></td>
                        </tr>
                        <tr>
                            <th>Слова:</th>
                            <td><textarea name="lyrics"></textarea></td>
                        </tr>
                        <tr>
                            <th>Файл:</th>
                            <td><input type="file" name="file"></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button type="submit" class="btn btn-black"><i class="fa fa-arrow-down"></i>Хай музика
                                    грає.
                                </button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <?php
        }
        foreach ($songs as $song) {
            ?>
            <div class="container">
                <div class="post" style="text-indent: 25px;">
                    <details>
                        <summary><h1><?php echo $song->getName(); ?></h1></summary>
                        <textarea rows="30"><?php echo $song->getLyrics(); ?></textarea>
                    </details>
                    <audio controls>
                        <source src="<?php echo $song->getFile(); ?>">
                    </audio>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php
}else{ ?>
    <div class="content">
        <div class="container">
            <p>Вибач, але свою музку я даю послухати тільки тим кого я знаю. Познайомимось?</p>
            <table>
                <tr>
                <td style="text-align: center;"><button type="submit" onclick="location.href = 'login.php';" class="btn btn-black"><i class="fa fa-home"></i>Постукати в двері</button></td>
                <td style="text-align: center;"><button type="reset" onclick="location.href = 'signup.php';" class="btn btn-grey"><i class="fa fa-check-square-o"></i>Представити себе вперше</button></td>
                </tr>
            </table>
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