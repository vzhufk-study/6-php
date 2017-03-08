<html>
<head>
    <title>Form add</title>
    <link rel="stylesheet" href="style/form-style.css">
    <link rel="stylesheet" href="style/table.css">
</head>

<body>

<form class="form-style" method = "post" action="add_form.php/" enctype="multipart/form-data">
    <ul>
        <li>
            <label for="name">Subject name</label>
            <input type="text" name="name" maxlength="100">
            <span>Enter your subject name here</span>
        </li>
        <li>
            <label for="semester">Semester</label>
            <input type="number" name="semester" min="1" max="11">
            <span>Enter semester</span>
        </li>
        <li>
            <label for="hours">Hours:</label>
            <input type="number" name="hours" min="7" max="60">
            <span>Hours for subject</span>
        </li>
        <li>
            <label for="control">Control</label>
            <select name="control">
                <option value="0">Credit</option>
                <option value="1">Exam</option>
            </select>
            <span>Kind of control</span>
        </li>
        <li>
            <label for="lector">Lector name</label>
            <input type="text" name="lector" maxlength="100">
            <span>Enter your lector</span>
        </li>
        <li>
            <input type="submit" value="Send This" >
        </li>
</ul>
</form>

<?php 

include "Subject.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current = new Subject($_POST["name"], intval($_POST["semester"]), intval($_POST["hours"]), intval($_POST["control"]), $_POST["lector"]);
    $a = load($filename);
    if ($a == null){
        $a = [];
    }
    array_push($a, $current);
    save($filename, $a);
    redirect("/Labs/table.php");
}
?>    
    
</body>
</html>