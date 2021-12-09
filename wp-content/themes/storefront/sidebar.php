<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package storefront
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}

$lav_array_check = explode("/",  $_SERVER['REQUEST_URI']);

if ((in_array("shop", $lav_array_check) && $lav_array_check[1] === "shop")) {
    ?>

    <div id="secondary" class="widget-area" role="complementary">
        <?php

        dynamic_sidebar('sidebar-1');

        ?>
    </div><!-- #secondary -->
<?php } else {
    ?>
    <?php
} ?>