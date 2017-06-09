<!DOCTYPE html>
<?php
include_once "../private/DBPropertyManager.php";
include_once "../Entities/Post.php";
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

//POSTS
$q = "SELECT * FROM  `Post` ORDER BY `id`";
$result = $db->link->query($q) or die("Error while executing:<br>".$q."<br>".mysqli_error($db->link));
$content = [];
while ($current = $result->fetch_object()){
    $value = new Post($current);
    $value->relate($db);
    $content[$current->id] = $value;
}

$free_id = $id = 1;
foreach ($content as $post){
    if ($free_id == $post->getId()){
        $free_id += 1;
    }
}


if (isset($_GET["id"])){
    $id = $_GET["id"];
}


if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $author = 1;
    if ($_POST["delete"] == $_POST["id"]){
        $content[$_POST["id"]]->delete();
    }else {
        if ($_POST["id"] != $free_id) {
            $current = $content[$_POST["id"]];
            $current->setTitle($_POST["title"]);
            $current->setContent($_POST["content"]);
            $current->update("title");
            $current->update("content");
        } else {
            $date = new DateTime();
            $new = new Post((object)["id" => $free_id, "title" => $_POST["title"], "content" => $_POST["content"], "date" => $date->format("Y-m-d"), "author" => $_SESSION['user']->getId()]);
            $new->relate($db);
            $new->insert();
        }
    }
    header("Location: index.php");
}
?>
<html>
<?php
    $page_title = "Posts Editor";
    include "parts/head.php";
?>
<body>
<!-- Navigation -->
<?php
if (!(isset($_SESSION["user"]) && $_SESSION["user"]->getAdmin() == 1)){
    $page_thumbnail = "А ти чого тут? Хитрих тут не люблять.";
    include "parts/navigation.php";
}else{
$page_thumbnail = "Тут ти можеш розказати про мене.";
include "parts/navigation.php";
?>
<!-- Content -->
<div class="content">
    <div class="container">
        <form method="post">
            <select name="id" onchange="window.location.href = 'editor.php?id='+this.value;">
                <?php
                foreach ($content as $post) {
                    echo "<option value='" . $post->getId() . "'";
                    if ($post->getId() == $id) {
                        echo " selected ";
                    }
                    echo ">";
                    echo $post->getTitle() . "</option>";
                }
                echo "<option value=\"" . $free_id . "\"";
                if ($id == $free_id || !isset($id)) {
                    echo " selected ";
                }
                echo ">NEW</option>";
                ?>
            </select>
            <br>
            <input type='text' name='title' value="<?php if ($id != $free_id) {
                echo $content[$id]->getTitle();
            } ?>">
            <textarea name="content"><?php if ($id != $free_id) {
                    echo $content[$id]->getContent();
                } ?></textarea>
            <input type="hidden" name="delete">
            <button type="submit" class="btn btn-black"><i class="fa fa-arrow-left"></i>Зберегти та опублікувати</button>
            <button type="submit" class="btn btn-black"
                    onclick="document.getElementsByName('delete')[0].value = document.getElementsByName('id')[0].value">
                <i class="fa fa-arrow-right"></i>Видалити та стерти
            </button>
        </form>
        <?php
        }
        include "parts/footer.php";
        ?>
        <!-- Javascript -->
        <script src="js/jquery.min.js"></script>
        <script src="js/kube.min.js"></script>
        <!-- Editor -->
        <script src="js/tinymce.min.js"></script>
        <script>tinymce.init({ selector:'textarea' });</script>
</body>
</html>