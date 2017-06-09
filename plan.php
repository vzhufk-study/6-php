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
?>
<html>
<head>
    <title>Plan</title>
    <link rel="stylesheet" href="style/table.css">
    <link rel="stylesheet" href="style/select-style.css">
    <link rel="stylesheet" href="style/form-style.css">
    <script src="scripts/jquery-3.2.1.min.js"></script>
    <script src="scripts/request.js"></script>
    <script>
        function lector_select(select) {
            var location = 'plan.php';
            if (select.value != 'none'){
                location += '?lector='+select.value;
            }
            window.location.href = (location);
            to_id('loads');
        };

        function to_id(id) {
            $('html, body').animate({scrollTop: $("#"+id).offset().top}, 2000);
        }

        /**
         * Add a URL parameter (or changing it if it already exists)
         * @param {search} string  this is typically document.location.search
         * @param {key}    string  the key to set
         * @param {val}    string  value
         * http://stackoverflow.com/questions/486896/adding-a-parameter-to-the-url-with-javascript
         */
        var addUrlParam = function(search, key, val){
            var newParam = key + '=' + val,
                params = '?' + newParam;

            // If the "search" string exists, then build params from it
            if (search) {
                // Try to replace an existance instance
                params = search.replace(new RegExp('([?&])' + key + '[^&]*'), '$1' + newParam);

                // If nothing was replaced, then add the new param to the end
                if (params === search) {
                    params += '&' + newParam;
                }
            }

            return params;
        };

        function append_url(property, value){
            document.location.href = document.location.pathname + addUrlParam(document.location.search, property, value);
        }

    </script>
</head>
<body onload="to_id('loads')">
<div class="form_holder" style="padding:0;">
    <div class="form" style="margin: 0 auto 15px; padding: 25px 25px 50px;">
    <form>
        <select onchange="lector_select(this)">
            <option value="none"></option>
            <?php
            if (isset($_GET["lector"])){
                $selected_lector = $_GET["lector"];
            }
            foreach ($university->getLectors() as $lector){
                echo "<option value=".$lector->getId();
                if (isset($selected_lector)) {
                    if ($lector->getId() == $selected_lector) {
                        echo " selected ";
                    }
                }
                echo ">";
                echo $lector->getLastName()." ".$lector->getFirstName()." ".$lector->getMiddleName();
                echo "</option>";
            }

            if(isset($selected_lector)) {
                foreach ($loads as $key => $load) {
                    if ($load->getLector()->getId() != $selected_lector) {
                        unset($loads[$key]);
                    }else{
                    }
                }
            }
            ?>
        </select>
    </form>
    </div>
</div>
<table class="table-style" id="loads">
    <thead>
    <tr>
        <th class="table-header" onclick="append_url('sort','id')">ID</th>
        <th class="table-header" onclick="append_url('sort','name')">Name</th>
        <th class="table-header" onclick="append_url('sort','subject')">Subject</th>
        <th class="table-header" onclick="append_url('sort','group')">Group</th>
        <th class="table-header" onclick="append_url('sort','salary')">Salary</th>
        <th class="table-header" onclick="append_url('sort','semester')">Semester</th>
        <th class="table-header" onclick="append_url('sort','auditory')">Auditory</th>
    </tr>
    </thead>
    <?php
    //Sorting
    if (isset($_GET["sort"])){
        global $sort_property;
        $sort_property = $_GET["sort"];
        $sort_property = ($sort_property=='name')?('Lector'):($sort_property);
        ucfirst($sort_property);
        $sort_property = "get" . $sort_property;
        usort($loads, function($a, $b){
            global $sort_property;
            $a = $a->$sort_property();
            $b = $b->$sort_property();
            if ($a instanceof Subject && $b instanceof Subject){
                return strcmp($a->getName(), $b->getName());
            }else if($a instanceof Lector && $b instanceof Lector){
                return strcmp($a->getLastName().$a->getFirstName().$a->getMiddleName(), $b->getLastName().$b->getFirstName().$b->getMiddleName());
            }else{
                return $a > $b;
            }
        });
    }
    ?>
    <tbody>
    <?php
    if (count($loads) == 0){
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
        <td>+</td>
        <td colspan="7"><a href="plan_add.php">Add new plan</a></td>
    </tr>
    </tbody>
</table>
</body>
</html>
<?php } ?>