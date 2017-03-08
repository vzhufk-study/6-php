<html>
<head>
    <title>Form add</title>
    <link rel="stylesheet" href="style/table.css">
</head>

<body>

<table class="table-style">
    <tr>
        <th><a href="table.php?sorting=name&unique=name">Subject name</a></th>
        <th><a href="table.php?sorting=semester&unique=semester">Semester</a></th>
        <th><a href="table.php?sorting=hours&unique=hours">Hours</a></th>
        <th><a href="table.php?sorting=control&unique=control">Control</a></th>
        <th><a href="table.php?sorting=lector&unique=lector">Lector</a></th>
    </tr>
    <?php
        include "Subject.php";
        $array = (load($filename));
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
    <tr><th colspan="5" class="text-center"><a href="/Labs/add_form.php">Add new subject</a></th></tr>
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