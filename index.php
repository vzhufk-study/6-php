<!DOCTYPE html>
  <html>
    <head>
      <meta charset="UTF-8">
      <link rel="stylesheet" href="style/table.css">
      <title>Zhufyak Vadym</title>
    </head>
    <body>
            <table class="table-style">
                <tr><th>Lab 1</th></tr>
            <?php
            for ($i = 2; $i<10; ++$i){
                echo "<tr><td><a href='/lab$i.php'>Lab $i</a><tr></td>";
            }
            ?>
            </table>
        <hr>        
    </body>
</html>      