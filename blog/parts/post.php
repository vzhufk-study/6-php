<?php
/**
 * Created by Zhufyak V.V.
 * User: zhufy
 * E-mai: zhufyakvv@gmail.com
 * Git: https://github.com/zhufyakvv
 * Date: 07.06.2017
 * Time: 8:55
 */ ?>

<div class="post">
    <!-- Heading -->
    <a href="#"><h1><?php echo $post_title;?></h1></a>
    <hr>
    <div class="in-content">
        <p>
            <?php echo $post_content; ?>
        </p>
        <?php if (isset($edit)){
            if ($edit == 1 or $edit == true){ ?>
                <a class="read-more" href="<?php echo "editor.php?id=".$post_id; ?>">Змінити щось</a>
            <?php }
        } ?>
    </div>
    <div class="foot-post">
        <div class="units-row">
            <div class="unit-100">
                <strong>Date:</strong> <?php echo $post_date;?>
            </div>
            <div class="unit-100">
                <strong>BY:</strong>
                <a href="#"><?php echo $user; ?></a>
            </div>
        </div>
    </div>
</div>
