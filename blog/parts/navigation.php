<?php
/**
 * Created by Zhufyak V.V.
 * User: zhufy
 * E-mai: zhufyakvv@gmail.com
 * Git: https://github.com/zhufyakvv
 * Date: 07.06.2017
 * Time: 8:39
 */
if (isset($user_login)){
    $page_thumbnail = "Мої вітаннячка ".$user_login."! Як ся маєш?";
}
?>
<div class="main-nav">
    <div class="container">
        <header class="group top-nav">
            <nav class="navbar logo-w navbar-left" >
                <a class="logo" href="index.php"><?php echo $page_title; ?></a>
            </nav>
            <div class="navigation-toggle" data-tools="navigation-toggle" data-target="#navbar-1">
                <span class="logo">Saturn</span>
            </div>
            <nav id="navbar-1" class="navbar item-nav navbar-right">
                <ul>
                    <li class="active"><a href="index.php">Додому</a></li>
                    <li><a href="about.php">Про</a></li>
                    <li><a href="music.php">Музика</a></li>
                    <?php if (isset($user_login)){
                        if (isset($edit) && $edit == '1') {
                            echo "<li><a href=\"editor.php\">Додати згадку</a></li>";
                        }
                        echo "<li><a href=\"logout.php\">Вийти з хати, як ".$user_login."</a></li>";
                    }else{?>
                    <li><a href="login.php">Війти на поріг</a></li>
                    <?php } ?>
                </ul>
            </nav>
        </header>
    </div>
</div>

<!-- Introduction -->
<div class="intro">
    <div class="container">
        <div class="units-row">
            <div class="unit-10">
                <img class="img-intro" src="img/avatar.jpg" alt="">
            </div>
            <div class="unit-90">
                <p class="p-intro"><?php echo $page_thumbnail; ?></p>
            </div>
        </div>
    </div>
</div>
