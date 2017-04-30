<html>
<head>
    <title>Subject Edit</title>
    <link rel="stylesheet" href="style/form-style.css">
</head>
<?php
/**
 * Created by Zhufyak V.V.
 * User: zhufy
 * E-mai: zhufyakvv@gmail.com
 * Git: https://github.com/zhufyakvv
 * Date: 30.04.2017
 * Time: 16:19
 */

include_once "Entities/University.php";
include_once "private/DBPropertyManager.php";
include_once "private/DBPost.php";


$data_base = new DBPropertyManager();
$data_base->link();
$data_base->select_db("University");
$university = new University($data_base);
$subjects = $university->getDepartments();
$free = 1;

while (isset($subjects[$free])){
    $free += 1;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post = $_POST;
    if ($free == $_POST["id"]){
        $subject = PostInsertDB($data_base, $post, 'Subject');
    }else{
        $subject = $subjects[$_POST["id"]];
        $subject = PostUpdateDB($data_base, $post, $subject);
    }
    ?>
    <body>
    <div class="login-page">
        <div class="form">
            <form class="register-form" method="get">
                <?php if ($free == $subject->getId()){ ?>
                    <label for="submit">Subject added successfully.</label>
                <?php }else{ ?>
                    <label for="submit">Changed successfully.</label>
                <?php } ?>
                <input name="submit" type="submit" value="Continue">
            </form>
        </div>
    </div>
    </body>
    <?php
}else{
if(isset($_GET["id"]) && $_GET["id"]!=$free){
    $id = $_GET["id"];
    $subject = $subjects[$id];
}else{
    $id = $free;
    $subject = new Subject((object)[
        "id"=>$free,
        "name"=>"Name"]);
}

?>

<body>
<div class="login-page">
    <div class="form">
        <form class="register-form" method="post">
            <br>
            <label for="id">ID:</label>
            <select name="id" onchange="window.location.href = 'department_edit.php?id='+this.value;">
                <?php
                $was = false;
                foreach ($subjects as $current_subject){
                    echo "<option value=\"".$current_subject->getId()."\"";
                    if ($current_subject->getId() == $id){
                        $was = true;
                        echo " selected ";
                    }
                    echo ">".$current_subject->getId()."(".$current_subject->getName().")";
                    echo "</option>";
                }

                echo "<option value=\"".$free."\"";
                if (!$was){
                    echo " selected ";
                }
                echo "> NEW </option>";
                ?>
            </select>
            <br>
            <label for="name">Name:</label>
            <input name="name" type="text" placeholder="<?php echo $subject->getName(); ?>">
            <br>
            <input type="submit">
        </form>
    </div>
</div>
</body>
</html>
<?php } ?>