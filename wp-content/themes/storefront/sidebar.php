<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package storefront
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}

$array_check = explode("/",  $_SERVER['REQUEST_URI']);

if ((in_array("shop", $array_check) && $array_check[1] === "shop")) {
    ?>

    <div id="secondary" class="widget-area Hung-custom-sidebar" role="complementary">
        <?php

        dynamic_sidebar('sidebar-1');

//        Ho Si Hung
//        Add Tags sidebar
        dynamic_sidebar('tags');
        ?>
    </div><!-- #secondary -->
<?php } else {
    ?>
    <?php
} ?>