<!DOCTYPE html>
<?php
    include_once "../private/DBPropertyManager.php";
    include_once "../Entities/Post.php";
    include_once "../Entities/User.php";

    session_start();

    $db = new DBPropertyManager();
    $db->link();
    $db->select_db("blog");
    $link = $db->getLink();

if (isset($_SESSION["user"])) {
    $user_login = $_SESSION["user"]->getLogin();
    $edit = $_SESSION["user"]->getAdmin();
}
?>
<html>
    <?php
    $page_title = "Orel.com";
    include "parts/head.php";
    ?>
<body>
<?php
    $page_thumbnail = "Привіт. Юний Орел. Вітаю на моєму сайті.";

    include "parts/navigation.php";
    ?>
	<div class="content">
		<div class="container">
			<!-- Post -->
            <?php
            //POSTS
            $q = "SELECT * FROM  `Post` ORDER BY `date`, `id` DESC";
            $result = $db->link->query($q) or die("Error while executing:<br>".$q."<br>".mysqli_error($db->link));
            $content = [];
            while ($current = $result->fetch_object()){
                $value = new Post($current);
                $value->relate($db);
                array_push($content, $value);
            }
            //AUTHORS
            $q = "SELECT * FROM  `User`";
            $result = $db->link->query($q) or die("Error while executing:<br>".$q."<br>".mysqli_error($db->link));
            $users = [];
            while ($current = $result->fetch_object()){
                $value = new User($current);
                $value->relate($db);
                $users[$current->id] = $value;
            }


            foreach ($content as $post){
                $post_id = $post->getId();
                $post_title = $post->getTitle();
                $post_content = $post->getContent();
                $post_date = $post->getDate();
                $user = $users[$post->getAuthor()]->getLogin();
                include "parts/post.php";
            }
            ?>
			<!-- /post -->
            <?php
            include "parts/footer.php";
            ?>

	<!-- Javascript -->
	<script src="js/jquery.min.js"></script>
    <script src="js/kube.min.js"></script>
</body>
</html>