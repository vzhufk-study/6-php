<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["date"]) {
        $date = date('Y-m-d', strtotime($_POST["date"]. ' + 2 week'));
    }
}
?>
<html>
<head>
    <title>Date++</title>
    <link rel="stylesheet" href="style/form-style.css">
</head>

<body>
<div class="form_holder">
    <div class="form">
        <form method="post">
            <input id="date" name="date" type="date" value="<?php if(isset($date)) echo $date; ?>">
            <input type="submit" value="Update Date">
        </form>
    </div>
</div>
</body>
