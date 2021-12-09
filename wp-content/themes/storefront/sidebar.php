<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package storefront
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}

$lav_array_check = explode("/", get_permalink());
if (!(in_array("product", $lav_array_check) && count($lav_array_check) >= 3 && $lav_array_check[3] === "product")) {
    ?>

    <div id="secondary" class="widget-area" role="complementary">
        <?php

        dynamic_sidebar('sidebar-1');

        ?>
    </div><!-- #secondary -->
<?php } ?>