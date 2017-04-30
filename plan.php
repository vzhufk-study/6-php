<?php
/**
 * Created by Zhufyak V.V.
 * User: zhufy
 * E-mai: zhufyakvv@gmail.com
 * Git: https://github.com/zhufyakvv
 * Date: 29.04.2017
 * Time: 16:12
 */


include_once "Entities/University.php";
include_once "private/DBPropertyManager.php";

$data_base = new DBPropertyManager();
$data_base->link();
$data_base->select_db("University");
$university = new University($data_base);

$loads = $university->getLoads();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST["id"]);
    $field = $_POST["field"];
    $value = $_POST["value"];

    $loads[$id]->update($field, $value);
}else{
    if(isset($_GET["lector"])){
    foreach ($loads as $load){
        if ($load->getLector()->getId() != $_GET["lector"]){
           unset($load, $loads);
        }
    }
    }
?>
<html>
<head>
    <title>Plan</title>
    <link rel="stylesheet" href="style/table.css">
    <link rel="stylesheet" href="style/select-style.css">
    <link rel="stylesheet" href="style/form-style.css">
    <script src="scripts/jquery-3.2.1.min.js"></script>
    <script src="scripts/request.js"></script>
</head>
<body>
<table class="table-style">
    <thead>
    <tr>
        <th class="table-header">ID</th>
        <th class="table-header">Name</th>
        <th class="table-header">Subject</th>
        <th class="table-header">Group</th>
        <th class="table-header">Salary</th>
        <th class="table-header">Semester</th>
        <th class="table-header">Auditory</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (!isset($loads)){
        echo "<tr class=\"table-row\"><td colspan=\"7\">Nothing to show for this lector</td></tr>";
    }else{
        foreach ($loads as $load) {
            $id = $load->getId();
            ?>
        <tr class="table-row">
            <td><?php echo $id?></td>
            <td>
                <select onchange="update(<?php echo $id ?>, 'lector', this.value);">
                    <?php foreach ($university->getLectors() as $lector){
                        echo "<option value=\"".$lector->getId()."\"";
                        if ($lector->getId() == $load->getLector()->getId()){
                            echo " selected ";
                        }
                        echo ">".$lector->getLastName()." ".$lector->getFirstName()." ".$lector->getMiddleName();
                        echo "</option>";
                    }
                    ?>
                </select>
            </td>
            <td>
                <select onchange="update(<?php echo $id ?>, 'subject', this.value);">
                    <?php foreach ($university->getSubjects() as $subject){
                        echo "<option value=\"".$subject->getId()."\"";
                        if ($subject->getId() == $load->getSubject()->getId()){
                            echo " selected ";
                        }
                        echo ">".$subject->getName();
                        echo "</option>";
                    }
                    ?>
                </select>
            </td>
            <td>
            <select onchange="update(<?php echo $id ?>, 'group', this.value);">
                    <?php foreach ($university->getGroups() as $group){
                        echo "<option value=\"".$group->getId()."\"";
                        if ($group->getId() == $load->getGroup()->getId()){
                            echo " selected ";
                        }
                        echo ">".$group->getNumber();
                        echo "</option>";
                    }
                    ?>
                </select></td>
            <td><input type="number" min="0" max="3000" value="<?php echo $load->getSalary();?>" onchange="update(<?php echo $id ?>, 'salary', this.value)"></td>
            <td><input type="number" min="1" max="11" value="<?php echo $load->getSemester();?>" onchange="update(<?php echo $id ?>, 'semester', this.value)"></td>
            <td><input type="number" min="1" max="47" value="<?php echo $load->getAuditory();?>" onchange="update(<?php echo $id ?>, 'auditory', this.value)"></td>
        </tr>
    <?php }
    }?>
    <tr>
        <td>0</td>
        <td colspan="7"><a href="plan_add.php">Add new plan</a></td>
    </tr>
    </tbody>
</table>
</body>
</html>
<?php } ?>