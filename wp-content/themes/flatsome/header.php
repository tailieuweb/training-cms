<!DOCTYPE html>
<!--[if IE 9 ]> <html <?php language_attributes(); ?> class="ie9 <?php flatsome_html_classes(); ?>"> <![endif]-->
<!--[if IE 8 ]> <html <?php language_attributes(); ?> class="ie8 <?php flatsome_html_classes(); ?>"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?> class="<?php flatsome_html_classes(); ?>"> <!--<![endif]-->

<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/tam.css" type="text/css" media="screen" />						

<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/module-7.css" type="text/css" media="screen" />							

<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />


	<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/assets/css/top-rating.css" type="text/css" media="screen" />

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.0/css/all.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/assets/css/trang.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/module-7.css" type="text/css" media="screen" />

	<!-- Link css footer -->
	<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/assets/css/footer.css" type="text/css" media="screen" />


	<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/assets/css/module-5.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/assets/css/module-6.css" type="text/css" media="screen" />

	<?php wp_head(); ?>
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/duotone.css" integrity="sha384-R3QzTxyukP03CMqKFe0ssp5wUvBPEyy9ZspCB+Y01fEjhMwcXixTyeot+S40+AjZ" crossorigin="anonymous"/>
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/fontawesome.css" integrity="sha384-eHoocPgXsiuZh+Yy6+7DsKAerLXyJmu2Hadh4QYyt+8v86geixVYwFqUvMU8X90l" crossorigin="anonymous"/>
	<script src="https://use.fontawesome.com/1ad2a7dd98.js"></script>

</head>

<body <?php body_class(); ?>>
<?php do_action( 'flatsome_after_body_open' ); ?>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'flatsome' ); ?></a>

<div id="wrapper">

	<?php do_action( 'flatsome_before_header' ); ?>

	<header id="header" class="header <?php flatsome_header_classes(); ?>">
		<div class="header-wrapper">
			<?php get_template_part( 'template-parts/header/header', 'wrapper' ); ?>
		</div>
	</header>

	<?php do_action( 'flatsome_after_header' ); ?>

	<main id="main" class="<?php flatsome_main_classes(); ?>">
