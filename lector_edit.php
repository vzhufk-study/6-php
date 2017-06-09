<html>
<head>
    <title>Lector Edit</title>
    <link rel="stylesheet" href="style/form-style.css">
</head>
<body>
<div class="form_holder">
    <div class="form">
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
$lectors = $university->getLectors();
$free = 1;

while (isset($lectors[$free])){
    $free += 1;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    # Date parsing
    $post = $_POST;
    $post["birth_date"] = date('Y-m-d', strtotime($_POST["birth_date"]));
    $post["hire_date"] = date('Y-m-d', strtotime($_POST["hire_date"]));
    if ($free == $_POST["id"]){
        $lector = PostInsertDB($data_base, $post, 'Lector');
    }else{
        $lector = $lectors[$_POST["id"]];
        $lector = PostUpdateDB($data_base, $post, $lector);
    }
    ?>

            <form method="get">
                <?php if ($free == $lector->getId()){ ?>
                <label for="submit">Added successfully.</label>
                <?php }else{ ?>
                <label for="submit">Changed successfully.</label>
                <?php } ?>
                <input name="submit" type="submit" value="Continue">
            </form>
    <?php
}else{
    if(isset($_GET["id"]) && $_GET["id"]!=$free){
        $id = $_GET["id"];
        $lector = $lectors[$id];
    }else{
        $id = $free;
        $lector = new Lector((object)[
            "id"=>$free,
            "last_name"=>"Last Name",
            "first_name"=>"First Name",
            "middle_name"=>"Middle Name",
            "post"=>"Post",
            "birth_date"=>"2000-01-01",
            "department"=>"1",
            "hire_date"=>"2000-01-01"]);
    }

?>

        <form method="post">
            <br>
            <label for="id">ID:</label>
            <select name="id" onchange="window.location.href = 'lector_edit.php?id='+this.value;">
                <?php
                $was = false;
                foreach ($lectors as $current_lector){
                    echo "<option value=\"".$current_lector->getId()."\"";
                    if ($current_lector->getId() == $id){
                        $was = true;
                        echo " selected ";
                    }
                    echo ">".$current_lector->getId()."(".$current_lector->getLastName()." ".$current_lector->getFirstName()." ".$current_lector->getMiddleName().")";
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
            <label for="last_name">Last Name:</label>
            <input name="last_name" type="text" placeholder="<?php echo $lector->getLastName(); ?>">
            <br>
            <label for="first_name">First Name:</label>
            <input name="first_name" type="text" placeholder="<?php echo $lector->getFirstName(); ?>">
            <br>
            <label for="middle_name">First Name:</label>
            <input name="middle_name" type="text" placeholder="<?php echo $lector->getMiddleName(); ?>">
            <br>
            <br>
            <label for="birth_date">Birth Date:</label>
            <input name="birth_date" type="date" value="<?php echo $lector->getBirthDate(); ?>">
            <br>
            <label for="department">Department:</label>
            <select name="department">
                <?php foreach ($university->getDepartments() as $department){
                    echo "<option value=\"".$department->getId()."\"";
                    if ($department->getId() == strval($lector->getDepartment())){
                        echo " selected ";
                    }
                    echo ">".$department->getName();
                    echo "</option>";
                }?>
            </select>
            <br>
            <label for="post">Post:</label>
            <input name="post" type="text" placeholder="<?php echo $lector->getPost(); ?>">
            <br>
            <label for="hire_date">Hire Date:</label>
            <input name="hire_date" type="date" value="<?php echo $lector->getHireDate(); ?>">
            <input type="submit">
        </form>

<?php } ?>
    </div>
</div>
</body>
</html>
