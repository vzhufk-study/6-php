<html>
<head>
    <title>Lector Edit</title>
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
$groups = $university->getGroups();
$free = 1;

while (isset($groups[$free])){
    $free += 1;
}

$post = $_POST;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($free == $_POST["id"]){
        $group = PostInsertDB($data_base, $post, 'Group');
    }else{
        $group = $groups[$_POST["id"]];
        $group = PostUpdateDB($data_base, $post, $group);
    }
    ?>
    <body>
    <div class="login-page">
        <div class="form">
            <form class="register-form" method="get">
                <?php if ($free == $group->getId()){ ?>
                    <label for="submit">Added successfully.</label>
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
    $group = $groups[$id];
}else{
    $id = $free;
    $group = new Group((object)[
        "id"=>$free,
        "number"=>"Number",
        "specialty"=>"Specialty",
        "department"=>"1",
        "amount"=>"1"]);
}

?>

<body>
<div class="login-page">
    <div class="form">
        <form class="register-form" method="post">
            <br>
            <label for="id">ID:</label>
            <select name="id" onchange="window.location.href = 'group_edit.php?id='+this.value;">
                <?php
                $was = false;
                foreach ($groups as $current_group){
                    echo "<option value=\"".$current_group->getId()."\"";
                    if ($current_group->getId() == $id){
                        $was = true;
                        echo " selected ";
                    }
                    echo ">".$current_group->getId()."(".$current_group->getNumber().")";
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
            <label for="number">Last Name:</label>
            <input name="number" type="text" placeholder="<?php echo $group->getNumber(); ?>">
            <br>
            <label for="specialty">Specialty:</label>
            <input name="specialty" type="text" placeholder="<?php echo $group->getSpecialty(); ?>">
            <br>
            <label for="department">Department:</label>
            <select name="department">
                <?php foreach ($university->getDepartments() as $department){
                    echo "<option value=\"".$department->getId()."\"";
                    if ($department->getId() == strval($group->getDepartment())){
                        echo " selected ";
                    }
                    echo ">".$department->getName();
                    echo "</option>";
                }?>
            </select>
            <br>
            <label for="amount">Amount:</label>
            <input name="amount" type="number" min="1" max="322" placeholder="<?php echo $group->getAmount(); ?>">
            <br>
            <input type="submit">
        </form>
    </div>
</div>
</body>
</html>
<?php } ?>