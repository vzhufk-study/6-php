<html>
<head>
    <title>Data table</title>
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="stylesheet" href="style/table.css">
    <link rel="stylesheet" href="style/form-style.css">
</head>

<body>
<?php
    include "Subject.php";
    $array = (load($filename));
    if (isset($_POST['search'])) {
        $search = $_POST['search'];
    }elseif (isset($_GET['search'])){
        $search = $_GET['search'];
    }

    if (isset($search) && strlen($search) == 0){
        $search = NULL;
    }

?>

<form class="form-style"  method = "post" enctype="multipart/form-data">
    <ul>
        <li>
            <label for="search">Search subject:</label>
            <input type="text" name="search" value="<?php if (isset($search)){ echo $search; }?>">
            <span>Search form symbols in subject name</span>
        </li>
        <li>
            <input type="submit">
        </li>
    </ul>
</form>
<?php
 if (isset($search)){
     $array = get_subjects_by_messed_string($array, $search);
 }
?>

<table class="table-style">

    <tr>
        <th><a href="table.php?sorting=name&unique=name&search=<?php echo $search; ?>">Subject name</a></th>
        <th><a href="table.php?sorting=semester&unique=semester&search=<?php echo $search; ?>">Semester</a></th>
        <th><a href="table.php?sorting=hours&unique=hours&search=<?php echo $search; ?>">Hours</a></th>
        <th><a href="table.php?sorting=control&unique=control&search=<?php echo $search; ?>">Control</a></th>
        <th><a href="table.php?sorting=lector&unique=lector&search=<?php echo $search; ?>">Lector</a></th>
    </tr>
    <?php
        if (isset($_GET['sorting'])){
            $array = sort_by($array, strval($_GET['sorting']));
        }
        foreach($array as $current){
            echo "<tr>";
            echo "<td>";
            echo $current->get_name();
            echo "</td>";
            echo "<td>";
            echo $current->get_semester();
            echo "</td>";
            echo "<td>";
            echo $current->get_hours();
            echo "</td>";
            if (intval($current->get_control()) == 0){
                echo "<td> Credit </td>";
            }else{
                echo "<td> Exam </td>";
            }
            echo "<td>";
            echo $current->get_lector();
            echo "</td>";
            echo "</tr>";
        }
    ?>
    <tr><th colspan="5" class="text-center"><a href="/add_form.php">Add new subject</a></th></tr>
    <?php
        if (isset($_GET['unique'])) {
            $unique = unique($array, $_GET['unique']);
            echo "<tr><th colspan='5' class='text-center'> Unique " . $_GET['unique'] . ": ";
            echo count($unique);
            echo "</th></tr>";
            foreach ($unique as $value) {
                echo "<tr>";
                echo "<td colspan='5'>";
                echo $value;
                echo "</td>";
                echo "</tr>";
            }
        }
    ?>
    </table>
    
    </body>
</html>