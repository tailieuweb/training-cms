<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/header.css">
    <?php wp_head(); ?>
   
</head>

<body id="blog" <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div class="page-wrap">
        <?php do_action('envo_shopper_before_topnav'); ?>
        <?php get_template_part('template-parts/template-part', 'topnav'); ?>
        <div id="site-content" class="container main-container" role="main">
            <div class="page-area">
                <?php do_action('envo_shopper_page_area'); ?>