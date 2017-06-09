<html>
<head>
    <title>Add Plan</title>
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
$loads = $university->getLoads();

if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
    $id = $_POST["id"];
    if (isset($loads[$id])) {
        die("ID already exists.");
    } else {
        PostInsertDB($data_base, $_POST, 'Load');
    }
    ?>      <form method="get">
                <label for="submit">Plan added successfully.</label>
                <input name="submit" type="submit" value="Add more">
            </form>
    <?php
}else{
?>
        <form method="post">
            <br>
            <label for="id">ID:</label>
            <input readonly name="id" type="number" value="<?php
                $free = 1;

                while (isset($loads[$free])){
                    $free += 1;
                }
                echo $free;
            ?>">
            <br>
            <label for="lector">Lector:</label>
            <select name="lector">
                <?php foreach ($university->getLectors() as $lector){
                    echo "<option value=\"".$lector->getId()."\"";
                    echo ">".$lector->getLastName()." ".$lector->getFirstName()." ".$lector->getMiddleName();
                    echo "</option>";
                }
                ?>
            </select>
            <br>
            <label for="subject">Subject:</label>
            <select name="subject">
                    <?php foreach ($university->getSubjects() as $subject){
                        echo "<option value=\"".$subject->getId()."\"";
                        echo ">".$subject->getName();
                        echo "</option>";
                    }
                    ?>
            </select>
            <br>
            <label for="group">Group:</label>
            <select name="group">
                    <?php foreach ($university->getGroups() as $group){
                        echo "<option value=\"".$group->getId()."\"";
                        echo ">".$group->getNumber();
                        echo "</option>";
                    }
                    ?>
            </select>
            <br>
            <label for="salary">Salary:</label>
            <input name="salary" type="number" min="0" max="3000">
            <br>
            <label for="semester">Semester:</label>
            <input name="semester" type="number" min="1" max="11">
            <br>
            <label for="auditory">Auditory:</label>
            <input name="auditory" type="number" min="1" max="47">
            <input type="submit">
        </form>
<?php } ?>
</div>
</div>
</body>


</html>