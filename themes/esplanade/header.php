<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title(); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/scripts/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
<link rel='stylesheet' href="http://pa.program.j43.ca/wp-content/themes/esplanade/additional.css" type="text/css"/>
</head>

<body <?php body_class() ?>>
	<div id="wrapper">
		<header id="header">
			<<?php esplanade_title_tag( 'site' ); ?> id="site-title"><a href="<?php echo home_url( '/' ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></<?php esplanade_title_tag( 'site' ); ?>>
			<?php if( ! is_active_sidebar( 1 ) ) : ?>
				<<?php esplanade_title_tag( 'desc' ); ?> id="site-description"><?php bloginfo( 'description' ); ?></<?php esplanade_title_tag( 'desc' ); ?>>
			<?php endif; ?>
			<?php get_sidebar( 'header' ); ?>
			<div class="clear"></div>
			<?php if ( ( '' != get_header_image() ) ||  ( false != get_header_image() ) ) : ?>
				<a href="<?php echo home_url( '/' ); ?>" rel="home">
					<img id="header-image" src="<?php header_image(); ?>" alt="<?php bloginfo( 'name' ); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" />
				</a>
			<?php endif; ?>
			<nav id="access">
				<a class="nav-toggle" href="#">Navigation</a>
				<?php wp_nav_menu( array( 'theme_location' => 'primary_nav' ) ); ?>
				<div class="clear"></div>
			</nav><!-- #access -->
		</header><!-- #header -->