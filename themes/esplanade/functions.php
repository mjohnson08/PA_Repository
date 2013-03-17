<?php

/**
 * Load the theme options page if in admin mode
 */
if ( is_admin() && is_readable( get_template_directory() . '/includes/theme-options.php' ) )
	require_once( get_template_directory() . '/includes/theme-options.php' );

if ( ! function_exists( 'esplanade_theme_setup' ) ) :
/**
 * Set up theme specific settings
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_image_size() To set custom image sizes.
 *
 * @since Esplanade 1.0
 */
function esplanade_theme_setup() {

	// Set default content width based on the theme's layout. This affects the width of post images and embedded media.
	global $content_width;
	if( ! isset( $content_width ) ) $content_width = 700;
	
	// Automatically add feed links to document head
	add_theme_support( 'automatic-feed-links' );
	
	// Register Primary Navigation Menu
	register_nav_menus(
		array(
			'primary_nav' => 'Primary Menu', // You can add more menus here
		)
	);
	
	// Add support for Post Formats
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );
	
	// Add support for post thumbnails and custom image sizes specific to theme locations
	add_theme_support( 'post-thumbnails', array( 'post' ) );
	add_image_size( 'slider-thumb', 640, 395, 1 );
	add_image_size( 'blog-thumb', 268, 200, 1 );
	add_image_size( 'teaser-thumb', 310, 190, 1 );
	add_image_size( 'gallery-thumb', 100, 100, 1 );
	add_image_size( 'video-thumb', 640, 395, 1 );
	add_image_size( 'attachment-thumb', 700, 9999 ); // no crop flag, unlimited height
	
	if( esplanade_is_wp_version( '3.4' ) ) {
		// Allows users to set a custom background
		add_theme_support( 'custom-background' );
		
		// Allows users to set a custom header image
		add_theme_support( 'custom-header', array(
			'width' => 1082,
			'height' => esplanade_get_option( 'header_image_height' ),
			'default-text-color' => '333',
			'flex-height' => true,
			'wp-head-callback' => 'esplanade_header_style',
			'admin-head-callback' => 'esplanade_admin_header_style',
			'admin-preview-callback' => 'esplanade_admin_header_image'
		) );
	} else {
		// Allows users to set a custom background
		add_custom_background();
		
		// Allows users to set a custom header image
		if ( ! defined( 'HEADER_TEXTCOLOR' ) )
			define( 'HEADER_TEXTCOLOR', '333' );
		// The height and width of your custom header.
		if ( ! defined( 'HEADER_IMAGE_WIDTH' ) )
			define( 'HEADER_IMAGE_WIDTH', 1082 );
		if ( ! defined( 'HEADER_IMAGE_HEIGHT' ) )
			define( 'HEADER_IMAGE_HEIGHT', esplanade_get_option( 'header_image_height' ) );
		// Add a way for the custom header to be styled in the admin panel
		add_custom_image_header( 'esplanade_header_style', 'esplanade_admin_header_style', 'esplanade_admin_header_image' );
	}
	
	
	// Styles the post editor
	add_editor_style();
	
	// Makes theme translation ready
	load_theme_textdomain( 'esplanade', get_template_directory() . '/languages' );
	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );
	
}
endif;

add_action( 'after_setup_theme', 'esplanade_theme_setup' );

if ( ! function_exists( 'esplanade_widgets_init' ) ) :
/**
 * Registers theme widget areas
 *
 * @uses register_sidebar()
 *
 * @since Esplanade 1.0
 */
function  esplanade_widgets_init() {
	$title_tag = esplanade_get_option( 'widget_title_tag' );
	
	// The header widget area is intended exclusively for displaying ads.
	register_sidebar(
		array(
			'name' => 'Header',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside><!-- .widget -->',
			'before_title' => '<' . $title_tag . ' class="widget-title">',
			'after_title' => '</' . $title_tag . '>'
		)
	);
	register_sidebar(
		array(
			'name' => 'Sidebar Top',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside><!-- .widget -->',
			'before_title' => '<' . $title_tag . ' class="widget-title">',
			'after_title' => '</' . $title_tag . '>'
		)
	);
	register_sidebar(
		array(
			'name' => 'Sidebar Left',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside><!-- .widget -->',
			'before_title' => '<' . $title_tag . ' class="widget-title">',
			'after_title' => '</' . $title_tag . '>'
		)
	);
	register_sidebar(
		array(
			'name' => 'Sidebar Right',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside><!-- .widget -->',
			'before_title' => '<' . $title_tag . ' class="widget-title">',
			'after_title' => '</' . $title_tag . '>'
		)
	);
	register_sidebar(
		array(
			'name' => 'Sidebar Bottom',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside><!-- .widget -->',
			'before_title' => '<' . $title_tag . ' class="widget-title">',
			'after_title' => '</' . $title_tag . '>'
		)
	);
	register_sidebar(
		array(
			'name' => 'Footer',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside><!-- .widget -->',
			'before_title' => '<' . $title_tag . ' class="widget-title">',
			'after_title' => '</' . $title_tag . '>'
		)
	);
	register_sidebar(
		array(
			'name' => '404 Page',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside><!-- .widget -->',
			'before_title' => '<' . $title_tag . ' class="widget-title">',
			'after_title' => '</' . $title_tag . '>'
		)
	);
}
endif;

add_action( 'widgets_init', 'esplanade_widgets_init' );

if ( ! function_exists( 'esplanade_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @since Esplanade 1.0
 */
function esplanade_header_style() {
	if ( '333' == get_header_textcolor() )
		return; ?>
<style type="text/css">
<?php if ( 'blank' == get_header_textcolor() ) : ?>
	#site-title,
	#site-description {
		position:absolute !important;
		clip:rect(1px 1px 1px 1px); /* IE6, IE7 */
		clip:rect(1px, 1px, 1px, 1px);
	}
	#header-image {
		margin:1.76% 0;
	}
<?php else : ?>
	#site-title a,
	#site-description {
		color:#<?php header_textcolor(); ?>;
	}
<?php endif; ?>
</style>
<?php
}
endif;

if ( ! function_exists( 'esplanade_admin_header_style' ) ) :
/**
 * Shows the header image preview in the admin panel.
 *
 * @since Esplanade 1.0
 */
function esplanade_admin_header_style() {
	$header_image = get_header_image(); ?>
<style type="text/css">
	@import url("http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold|Droid+Serif:regular,italic,bold,bolditalic&subset=latin");
	.appearance_page_custom-header #headimg {
		width:<?php echo get_custom_header()->width; ?>px;
		border:none;
	}
	#headimg {
		padding:<?php echo ( 'blank' == get_header_textcolor() ? '20px' : 0 ) ?> 20px<?php if ( ! empty( $header_image ) ) : ?> 20px<?php endif; ?>;
		background:#e9e9e9;
	}
	#headimg h1,
	#desc {
		font-family:"Droid Sans", sans-serif;
	}
	#headimg h1 {
		float:left;
		margin:0;
	}
	#headimg h1 a {
		font-size:28px;
		font-weight:bold;
		line-height:100px;
		text-decoration:none;
	}
	#desc {
		float:left;
		margin-left:20px;
		font-size:12px;
		font-weight:normal;
		line-height:100px;
	}
	#headimg img {
		display:block;
		clear:both;
		max-width:99.1%;
		padding:0.45%;
		box-shadow:0 0 3px #999;
		background:#fff;
	}
<?php if ( '333' != get_header_textcolor() ) : ?>
	#headimg h1 a,
	#desc {
		color:#<?php header_textcolor() ?>;
	}
<?php endif; ?>
</style>
<?php
}
endif;

if ( ! function_exists( 'esplanade_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @since Esplanade 1.0
 */
function esplanade_admin_header_image() {
	if ( 'blank' == get_theme_mod( 'header_textcolor', '333' ) || '' == get_theme_mod( 'header_textcolor', '333' ) )
		$style = ' style="display:none;"';
	else
		$style = ' style="color:#' . get_theme_mod( 'header_textcolor', '333' ) . ';"';
		$header_image = get_header_image(); ?>
<div id="headimg">
	<h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
	<div id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
	<?php if ( ! empty( $header_image ) ) : ?>
		<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
	<?php endif; ?>
</div>
<?php
}
endif;

if ( ! function_exists( 'esplanade_default_options' ) ) :
/**
 * Returns an array of theme default options.
 *
 * @since Esplanade 1.0
 */
function esplanade_default_options() {
	$options = array(
		'home_page_layout' => 'grid',
		'home_page_excerpts' => 2,
		'slider' => true,
		'location' => true,
		'breadcrumbs' => true,
		'lightbox' => true,
		'esplanade_archive_location' => true,
		'posts_nav_labels' => 'next/prev',
		'fancy_dropdowns' => true,
		'post_nav' => false,
		'facebook' => true,
		'twitter' => true,
		'google' => true,
		'pinterest' => true,
		'author_box' => true,
		'copyright_notice' => '&copy; %year% %blogname%',
		'theme_credit_link' => true,
		'author_credit_link' => false,
		'wordpress_credit_link' => true,
		'layout' => 'content-sidebar',
		'header_height' => 100,
		'sidebar_size' => '"29.48%"',
		'sidebar_right_size' => '"29.48%"',
		'sidebar_left_size' => '"17.4%"',
		'sidebar_right_size' => '"12.75%"',
		'header_image_height' =>280,
		'color_scheme' => 'neutral',
		'user_css' => '',
		'body_font' => 'droid-sans',
		'headings_font' => 'droid-sans',
		'content_font' => 'droid-sans',
		'body_font_size' => '13',
		'body_font_size_unit' => 'px',
		'body_line_height' => '1.62',
		'body_line_height_unit' => 'em',
		'h1_font_size' => '32',
		'h1_font_size_unit' => 'px',
		'h2_font_size' => '24',
		'h2_font_size_unit' => 'px',
		'h3_font_size' => '18',
		'h3_font_size_unit' => 'px',
		'h4_font_size' => '16',
		'h4_font_size_unit' => 'px',
		'headings_line_height' => '1.62',
		'headings_line_height_unit' => 'em',
		'content_font_size' => '15',
		'content_font_size_unit' => 'px',
		'content_line_height' => '1.62',
		'content_line_height_unit' => 'em',
		'mobile_font_size' => '17',
		'mobile_font_size_unit' => 'px',
		'mobile_line_height' => '1.62',
		'mobile_line_height_unit' => 'em',
		'body_color' => '#333',
		'headings_color' => '#333',
		'content_color' => '#333',
		'links_color' => '#21759b',
		'links_hover_color' => '#01D1DB',
		'menu_color' => '#f0f0f0',
		'menu_hover_color' => '#fff',
		'sidebar_color' => '#aaa',
		'sidebar_title_color' => '#aaa',
		'sidebar_links_color' => '#7799aa',
		'footer_color' => '#e0e0e0',
		'footer_title_color' => '#e0e0e0',
		'copyright_color' => '#999',
		'copyright_links_color' => '#7799aa',
		'home_site_title_tag' => 'h1',
		'home_desc_title_tag' => 'div',
		'home_post_title_tag' => 'h2',
		'archive_site_title_tag' => 'div',
		'archive_desc_title_tag' => 'div',
		'archive_location_title_tag' => 'h1',
		'archive_post_title_tag' => 'h2',
		'single_site_title_tag' => 'div',
		'single_desc_title_tag' => 'div',
		'single_post_title_tag' => 'h1',
		'single_comments_title_tag' => 'h2',
		'single_respond_title_tag' => 'h2',
		'widget_title_tag' => 'h3',
	);
	return $options;
}
endif;

if ( ! function_exists( 'esplanade_get_option' ) ) :
/**
 * Used to output theme options is an elegant way
 *
 * @uses get_option() To retrieve the options array
 *
 * @since Esplanade 1.0
 */
function esplanade_get_option( $option ) {
	global $esplanade_options;
	if( ! isset( $esplanade_options ) )
		$esplanade_options = get_option( 'esplanade_theme_options', esplanade_default_options() );
	return $esplanade_options[ $option ];
}
endif;

if ( ! function_exists( 'esplanade_available_fonts' ) ) :
/**
 * Returns an array of fonts available to the theme.
 *
 * @since Esplanade 1.0
 */
function esplanade_available_fonts() {
	return array(
		'helvetica' => '"Helvetica Neue", "Nimbus Sans L", sans-serif',
		'verdana' => 'Geneva, Verdana, "DejaVu Sans", sans-serif',
		'tahoma' => 'Tahoma, "DejaVu Sans", sans-serif',
		'trebuchet' => '"Trebuchet MS", "Bitstream Vera Sans", sans-serif',
		'lucida-grande' => '"Lucida Grande", "Lucida Sans Unicode", "Bitstream Vera Sans", sans-serif',
		'droid-sans' => '"Droid Sans", sans-serif',
		'lato' => '"Lato", sans-serif',
		'pt-sans' => '"PT Sans", sans-serif',
		'cantarell' => '"Cantarell", sans-serif',
		'open-sans' => '"Open Sans", sans-serif',
		'quattrocento-sans' => '"Quattrocento Sans", sans-serif',
		'georgia' => 'Georgia, "URW Bookman L", serif',
		'times' => 'Times, "Times New Roman", "Century Schoolbook L", serif',
		'palatino' => 'Palatino, "Palatino Linotype", "URW Palladio L", serif',
		'droid-serif' => '"Droid Serif", serif',
		'lora' => '"Lora", serif',
		'pt-serif' => '"PT Serif", serif',
		'courier' => 'Courier, "Courier New", "Nimbus Mono L", monospace',
		'monaco' => 'Monaco, Consolas, "Lucida Console", "Bitstream Vera Sans Mono", monospace',
	);
}
endif;

if ( ! function_exists( 'esplanade_ignore_sticky_posts' ) ) :
/**
 * Ignore sticky posts from the main query
 *
 * Sticky posts are displayed as featured posts
 * in the slider on the front page if option
 * is activated in theme options.
 *
 * @since Esplanade 1.0
 */
function esplanade_ignore_sticky_posts( $query ) {
	global $wp_the_query;
	if( ( $wp_the_query === $query ) && $query->is_home() && esplanade_get_option( 'slider' ) )
		$query->set( 'ignore_sticky_posts', 1 );
}
endif;

add_action( 'pre_get_posts', 'esplanade_ignore_sticky_posts' );

if ( ! function_exists( 'esplanade_register_styles' ) ) :
/**
 * Register theme styles
 *
 * Registers stylesheets used by the theme.
 * Also offers integration with Google Web Fonts Directory
 * @uses wp_register_style() To register styles
 *
 * @since Esplanade 1.0.
 */
function esplanade_register_styles() {
	$web_fonts = array(
		'droid-sans' => 'Droid+Sans',
		'lato' => 'Lato',
		'pt-sans' => 'PT+Sans',
		'cantarell' => 'Cantarell',
		'open-sans' => 'Open+Sans',
		'quattrocento-sans' => 'Quattrocento+Sans',
		'droid-serif' => 'Droid+Serif',
		'lora' => 'Lora',
		'pt-serif' => 'PT+Serif'
	);
	if( array_key_exists( esplanade_get_option( 'body_font' ), $web_fonts ) || in_array( esplanade_get_option( 'headings_font' ), $web_fonts )|| in_array( esplanade_get_option( 'content_font' ), $web_fonts ) ) {
		$web_fonts_stylesheet = 'http://fonts.googleapis.com/css?family=';
		if( array_key_exists( esplanade_get_option( 'body_font' ), $web_fonts ) ) {
			$web_fonts_stylesheet .= $web_fonts[esplanade_get_option( 'body_font' )] . ':regular,italic,bold,bolditalic';
		}
		if( ( esplanade_get_option( 'headings_font' ) != esplanade_get_option( 'body_font' ) ) && array_key_exists( esplanade_get_option( 'headings_font' ), $web_fonts ) ) {
			$web_fonts_stylesheet .= '|' . $web_fonts[esplanade_get_option( 'headings_font' )] . ':regular,italic,bold,bolditalic';
		}
		if( ( esplanade_get_option( 'content_font' ) != esplanade_get_option( 'body_font' ) ) && ( esplanade_get_option( 'content_font' ) != esplanade_get_option( 'headings_font' ) ) && array_key_exists( esplanade_get_option( 'content_font' ), $web_fonts ) ) {
			$web_fonts_stylesheet .= '|' . $web_fonts[esplanade_get_option( 'content_font' )] . ':regular,italic,bold,bolditalic';
		}
		$web_fonts_stylesheet .= '&subset=latin';
	} else
		$web_fonts_stylesheet = false;
	if( false !== $web_fonts_stylesheet ) {
		wp_register_style( 'esplanade-web-font', $web_fonts_stylesheet, false, null );
		$esplanade_deps = array( 'esplanade-web-font' );
	} else
		$esplanade_deps = false;
	wp_register_style( 'esplanade', get_bloginfo( 'stylesheet_url' ), $esplanade_deps, null );
	wp_register_style( 'sand', get_template_directory_uri() . '/styles/sand.css', array( 'esplanade' ), null );
	wp_register_style( 'nature', get_template_directory_uri() . '/styles/nature.css', array( 'esplanade' ), null );
	wp_register_style( 'earth', get_template_directory_uri() . '/styles/earth.css', array( 'esplanade' ), null );
	wp_register_style( 'colorbox', get_template_directory_uri() . '/styles/colorbox.css', false, null );
}
endif;

add_action( 'init', 'esplanade_register_styles' );

if ( ! function_exists( 'esplanade_enqueue_styles' ) ) :
/**
 * Enqueue theme styles
 *
 * @uses wp_enqueue_style() To enqueue styles
 *
 * @since Esplanade 1.0
 */
function esplanade_enqueue_styles() {
	//wp_enqueue_style( 'esplanade-web-font' );
	wp_enqueue_style( 'esplanade' );
	if( 'neutral' != esplanade_get_option( 'color_scheme' ) )
		wp_enqueue_style( esplanade_get_option( 'color_scheme' ) );
	if( esplanade_get_option( 'lightbox' ) )
		wp_enqueue_style( 'colorbox' );
}
endif;

add_action( 'wp_enqueue_scripts', 'esplanade_enqueue_styles' );

if ( ! function_exists( 'esplanade_register_scripts' ) ) :
/**
 * Register theme scripts
 *
 * @uses wp_register_scripts() To register scripts
 *
 * @since Esplanade 1.0
 */
function esplanade_register_scripts() {
	wp_register_script( 'flexslider', get_template_directory_uri() . '/scripts/jquery.flexslider-min.js', array( 'jquery' ), null );
	wp_register_script( 'colorbox', get_template_directory_uri() . '/scripts/colorbox.js', array( 'jquery' ), null );
	wp_register_script( 'fitvids', get_template_directory_uri() . '/scripts/fitvids.js', array( 'jquery' ), null );
	wp_register_script( 'audio-player', get_template_directory_uri() . '/scripts/audio-player.js', array( 'swfobject' ), null );
}
endif;

add_action( 'init', 'esplanade_register_scripts' );

if ( ! function_exists( 'esplanade_enqueue_scripts' ) ) :
/**
 * Enqueue theme scripts
 *
 * @uses wp_enqueue_scripts() To enqueue scripts
 *
 * @since Esplanade 1.0
 */
function esplanade_enqueue_scripts() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'flexslider' );
	wp_enqueue_script( 'fitvids' );
	wp_enqueue_script( 'swfobject' );
	wp_enqueue_script( 'audio-player' );
	if( esplanade_get_option( 'lightbox' ) )
		wp_enqueue_script( 'colorbox' );
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
}
endif;

add_action( 'wp_enqueue_scripts', 'esplanade_enqueue_scripts' );

if ( ! function_exists( 'esplanade_call_scripts' ) ) :
/**
 * Call script functions in document head
 *
 * @since Esplanade 1.0
 */
function esplanade_call_scripts() { ?>
<script>
/* <![CDATA[ */
	jQuery(document).ready(function($) {
		$('.nav-toggle').click(function() {
			$('#access div ul:first-child').slideToggle(250);
			return false;
		});
		if( ($(window).width() > 640) || ($(document).width() > 640) ) {
			<?php if( esplanade_get_option( 'fancy_dropdowns' ) ) : ?>
				$('#access li').mouseenter(function() {
					$(this).children('ul').css('display', 'none').stop(true, true).slideToggle(250).css('display', 'block').children('ul').css('display', 'none');
				});
				$('#access li').mouseleave(function() {
					$(this).children('ul').stop(true, true).fadeOut(250).css('display', 'block');
				})
			<?php endif; ?>
		} else {
			$('#access li').each(function() {
				if($(this).children('ul').length)
					$(this).append('<span class="drop-down-toggle"><span class="drop-down-arrow"></span></span>');
			});
			$('.drop-down-toggle').click(function() {
				$(this).parent().children('ul').slideToggle(250);
			});
		}
		<?php if( is_home() && ! is_paged() ) : ?>
			$('#slider').flexslider({
				directionNav: false,
				keyboardNav: false
			});
		<?php endif; ?>
		$(".entry-attachment, .entry-content").fitVids({ customSelector: "iframe, object, embed"});
	});
	jQuery(window).load(function() {
		<?php if( esplanade_get_option( 'lightbox' ) ) : ?>
			jQuery('.entry-content a[href$=".jpg"],.entry-content a[href$=".jpeg"],.entry-content a[href$=".png"],.entry-content a[href$=".gif"],a.colorbox').colorbox();
		<?php endif; ?>
	});
	AudioPlayer.setup("<?php echo get_template_directory_uri(); ?>/audio-player/player.swf", {  
		width: 320  
	});
/* ]]> */
</script>
<?php
}
endif;

add_action( 'wp_head', 'esplanade_call_scripts' );

if ( ! function_exists( 'esplanade_custom_styles' ) ) :
/**
 * Custom style declarations
 *
 * Outputs CSS declarations generated by theme options
 * and custom user defined CSS in the document <head>
 *
 * @since Esplanade 1.0
 */
function esplanade_custom_styles() {
	$default_options = esplanade_default_options();
	$fonts = esplanade_available_fonts(); ?>
<style type="text/css">
	<?php if( $default_options['header_height'] != esplanade_get_option( 'header_height' ) ) : ?>
		#site-title,
		#site-description {
			line-height:<?php echo esplanade_get_option( 'header_height' ); ?>px;
		}
		#sidebar-header {
			margin-top:<?php echo absint( ( esplanade_get_option( 'header_height' ) - 90 ) / 2 ); ?>px;
		}
		@media screen and (max-width: 1152px) {
			#sidebar-header {
				margin-top:<?php echo absint( ( esplanade_get_option( 'header_height' ) - 60 ) / 2 ); ?>px;
			}
		}
		@media screen and (max-width: 640px) {
			#site-title,
			#site-description {
				line-height:1.62em;
			}
			#sidebar-header {
				margin-top:0;
			}
		}
	<?php endif; ?>
	<?php if( 'sidebar-content-sidebar' != esplanade_get_option( 'layout' ) && ( $default_options['sidebar_size'] != esplanade_get_option( 'sidebar_size' ) ) ) : ?>
		<?php if( ( ( 'content-sidebar' == esplanade_get_option( 'layout' ) ) || ( 'sidebar-content' == esplanade_get_option( 'layout' ) ) ) && ( $default_options['sidebar_size'] != esplanade_get_option( 'sidebar_size' ) ) ) : ?>
			<?php $sidebar_width = str_replace( '"', '', esplanade_get_option( 'sidebar_size' ) ); ?>
			<?php $sidebar_width = str_replace( '%', '', $sidebar_width ); ?>
			#content {
				width:<?php echo 100 - 2.77 - $sidebar_width; ?>%;
			}
			#sidebar {
				width:<?php echo $sidebar_width; ?>%;
			}
			@media screen and (max-width: 960px) {
				#content,
				#sidebar {
					width:auto;
				}
			}
		<?php elseif( 'content-sidebar' != esplanade_get_option( 'layout' ) ) : ?>
			#content {
				width:100%;
			}
		<?php endif; ?>
	<?php elseif( 'sidebar-content-sidebar' == esplanade_get_option( 'layout' ) && ( ( $default_options['sidebar_left_size'] != esplanade_get_option( 'sidebar_left_size' ) ) || ( $default_options['sidebar_right_size'] != esplanade_get_option( 'sidebar_right_size' ) ) ) ) : ?>
		<?php $sidebar_left_width = str_replace( '"', '', esplanade_get_option( 'sidebar_left_size' ) ); ?>
		<?php $sidebar_left_width = str_replace( '%', '', $sidebar_left_width ); ?>
		<?php $sidebar_right_width = str_replace( '"', '', esplanade_get_option( 'sidebar_right_size' ) ); ?>
		<?php $sidebar_right_width = str_replace( '%', '', $sidebar_right_width ); ?>
		.content-sidebar-wrap {
			width:<?php echo 100 - 2.1 - $sidebar_right_width; ?>%;
		}
		.page-template-template-sidebar-content-sidebar-php .content-sidebar-wrap #content {
			width:<?php echo 100 - 2.1 - $sidebar_left_width; ?>%;
		}
		.page-template-template-sidebar-content-sidebar-php #sidebar-left {
			width:<?php echo $sidebar_left_width; ?>%;
		}
		.page-template-template-sidebar-content-sidebar-php #sidebar-right {
			width:<?php echo $sidebar_right_width; ?>%;
		}
		@media screen and (max-width: 960px) {
			.content-sidebar-wrap,
			.page-template-template-sidebar-content-sidebar-php .content-sidebar-wrap #content,
			.page-template-template-sidebar-content-sidebar-php #sidebar-left,
			.page-template-template-sidebar-content-sidebar-php #sidebar-right {
				float:none;
				width:auto;
			}
		}
		@media screen and (max-width: 640px) {
			.page-template-template-sidebar-content-sidebar-php #sidebar-left {
				float:left;
				width:49.65%;
			}
			.page-template-template-sidebar-content-sidebar-php #sidebar-right {
				float:right;
				width:43.45%;
			}
		}
	<?php endif; ?>
	<?php if( ( ! esplanade_get_option( 'breadcrumbs' ) && ! esplanade_get_option( 'esplanade_archive_location' ) ) || ( is_home() && ! esplanade_get_option( 'breadcrumbs' ) ) ) : ?>
		#content .post:first-child {
			padding-top:20px;
			border-top:none;
		}
	<?php endif; ?>
	<?php if( ! esplanade_get_option( 'breadcrumbs' ) ) : ?>
		#current-location{
			margin-top:0;
		}
	<?php endif; ?>
	<?php if( is_home() && ! is_paged() && ( 'blog' == esplanade_get_option( 'home_page_layout' ) ) ) : ?>
		.home #content {
			width:64.09%;
			padding:20px;
			margin-bottom:1.76%;
			box-shadow:0 0 3px #999;
			background:#fff;
		}
		.home .post {
			padding:4.28% 0;
			margin:0;
			box-shadow:none;
			background:none;
			border-top:#eee 1px solid;
		}
		.home #content .post:first-child {
			padding-top:0;
			border-top:none;
		}
		.home #posts-nav {
			padding:20px 0 0;
			margin:0;
			box-shadow:none;
			background:none;
			border-top:#eee 1px solid;
		}
	<?php endif; ?>
	<?php if( 'page' == get_option( 'show_on_front' ) ) : ?>
		.blog #content {
			box-shadow:none;
			background:none;
		}
		.blog .post {
			padding:2.7%;
			margin-bottom:2.7%;
			box-shadow:0 0 3px #999;
			background:#fff;
		}
		.blog #posts-nav {
			padding:20px;
			margin-bottom:20px;
			box-shadow:0 0 3px #999;
			background:#fff;
			border-top:none;
		}
		.paged #content {
			margin-bottom:1.76%;
			box-shadow:0 0 3px #999;
			background:#fff;
		}
		.paged .post {
			padding:4.28% 0;
			margin:0 20px;
			box-shadow:none;
			background:none;
			border-top:#eee 1px solid;
		}
		.paged #posts-nav {
			padding:20px 0 0;
			margin:20px;
			margin-top:0;
			box-shadow:none;
			background:none;
			border-top:#eee 1px solid;
		}
	<?php endif; ?>
	<?php if( $default_options['body_font'] != esplanade_get_option( 'body_font' ) ) : ?>
		body {
			font-family:<?php echo $fonts[esplanade_get_option( 'body_font' )]; ?>;
		}
		h1, h2, h3, h4, h5, h6,
		#site-title,
		#site-description,
		.entry-title,
		#comments-title,
		#reply-title,
		.widget-title {
			font-family:<?php echo $fonts[esplanade_get_option( 'headings_font' )]; ?>;
		}
		.entry-content {
			font-family:<?php echo $fonts[esplanade_get_option( 'content_font' )]; ?>;
		}
	<?php else : ?>
		<?php if( $default_options['headings_font'] != esplanade_get_option( 'headings_font' ) ) : ?>
			h1, h2, h3, h4, h5, h6 {
				font-family:<?php echo $fonts[esplanade_get_option( 'headings_font' )]; ?>;
			}
		<?php endif; ?>
		<?php if( $default_options['content_font'] != esplanade_get_option( 'content_font' ) ) : ?>
			.entry-content {
				font-family:<?php echo $fonts[esplanade_get_option( 'content_font' )]; ?>;
			}
		<?php endif; ?>
	<?php endif; ?>
	<?php if( $default_options['body_font_size'] != esplanade_get_option( 'body_font_size' ) ) : ?>
		body {
			font-size:<?php echo esplanade_get_option( 'body_font_size' ) . esplanade_get_option( 'body_font_size_unit' ); ?>;
			line-height:<?php echo esplanade_get_option( 'body_line_height' ) . esplanade_get_option( 'body_line_height_unit' ); ?>;
		}
	<?php elseif( $default_options['body_line_height'] != esplanade_get_option( 'body_line_height' ) ) : ?>
		body {
			line-height:<?php echo esplanade_get_option( 'body_line_height' ) . esplanade_get_option( 'body_line_height_unit' ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['h1_font_size'] != esplanade_get_option( 'h1_font_size' ) ) : ?>
		h1,
		.single .entry-title,
		.page .entry-title,
		.error404 .entry-title {
			font-size:<?php echo esplanade_get_option( 'h1_font_size' ) . esplanade_get_option( 'h1_font_size_unit' ); ?>;
			line-height:<?php echo esplanade_get_option( 'headings_line_height' ) . esplanade_get_option( 'headings_line_height_unit' ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['h2_font_size'] != esplanade_get_option( 'h2_font_size' ) ) : ?>
		h2,
		.entry-title {
			font-size:<?php echo esplanade_get_option( 'h2_font_size' ) . esplanade_get_option( 'h2_font_size_unit' ); ?>;
			line-height:<?php echo esplanade_get_option( 'headings_line_height' ) . esplanade_get_option( 'headings_line_height_unit' ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['h3_font_size'] != esplanade_get_option( 'h3_font_size' ) ) : ?>
		h3,
		.teaser .entry-title {
			font-size:<?php echo esplanade_get_option( 'h3_font_size' ) . esplanade_get_option( 'h3_font_size_unit' ); ?>;
			line-height:<?php echo esplanade_get_option( 'headings_line_height' ) . esplanade_get_option( 'headings_line_height_unit' ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['h4_font_size'] != esplanade_get_option( 'h4_font_size' ) ) : ?>
		h4 {
			font-size:<?php echo esplanade_get_option( 'h4_font_size' ) . esplanade_get_option( 'h4_font_size_unit' ); ?>;
			line-height:<?php echo esplanade_get_option( 'headings_line_height' ) . esplanade_get_option( 'headings_line_height_unit' ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['headings_line_height'] != esplanade_get_option( 'headings_line_height' ) ) : ?>
		h1, h2, h3, h4, h5, h6 {
			line-height:<?php echo esplanade_get_option( 'headings_line_height' ) . esplanade_get_option( 'headings_line_height_unit' ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['content_font_size'] != esplanade_get_option( 'content_font_size' ) ) : ?>
		.entry-content {
			font-size:<?php echo esplanade_get_option( 'content_font_size' ) . esplanade_get_option( 'content_font_size_unit' ); ?>;
			line-height:<?php echo esplanade_get_option( 'content_line_height' ) . esplanade_get_option( 'content_line_height_unit' ); ?>;
		}
		@media screen and (max-width: 640px) {
			.entry-content {
				font-size:<?php echo esplanade_get_option( 'mobile_font_size' ) . esplanade_get_option( 'content_font_size_unit' ); ?>;
				line-height:<?php echo esplanade_get_option( 'mobile_line_height' ) . esplanade_get_option( 'content_line_height_unit' ); ?>;
			}
		}
	<?php elseif( $default_options['content_line_height'] != esplanade_get_option( 'content_line_height' ) ) : ?>
		.entry-content {
			line-height:<?php echo esplanade_get_option( 'content_line_height' ) . esplanade_get_option( 'content_line_height' ); ?>;
		}
		@media screen and (max-width: 640px) {
			.entry-content {
				font-size:<?php echo esplanade_get_option( 'mobile_font_size' ) . esplanade_get_option( 'mobile_font_size_unit' ); ?>;
				line-height:<?php echo esplanade_get_option( 'mobile_line_height' ) . esplanade_get_option( 'mobile_line_height_unit' ); ?>;
			}
		}
	<?php elseif( $default_options['mobile_font_size'] != esplanade_get_option( 'mobile_font_size' ) ) : ?>
		@media screen and (max-width: 640px) {
			.entry-content {
				font-size:<?php echo esplanade_get_option( 'mobile_font_size' ) . esplanade_get_option( 'mobile_font_size_unit' ); ?>;
				line-height:<?php echo esplanade_get_option( 'mobile_line_height' ) . esplanade_get_option( 'mobile_line_height_unit' ); ?>;
			}
		}
	<?php elseif( $default_options['mobile_line_height'] != esplanade_get_option( 'mobile_line_height' ) ) : ?>
		@media screen and (max-width: 640px) {
			.entry-content {
				line-height:<?php echo esplanade_get_option( 'mobile_line_height' ) . esplanade_get_option( 'mobile_line_height_unit' ); ?>;
			}
		}
	<?php endif; ?>
	<?php if( $default_options['body_color'] != esplanade_get_option( 'body_color' ) ) : ?>
		body {
			color:<?php echo esplanade_get_option( 'body_color' ); ?>;
		}
		h1, h2, h3, h4, h5, h6,
		.entry-title,
		.entry-title a {
			color:<?php echo esplanade_get_option( 'headings_color' ); ?>;
		}
		.entry-content {
			color:<?php echo esplanade_get_option( 'content_color' ); ?>;
		}
	<?php else : ?>
		<?php if( $default_options['headings_color'] != esplanade_get_option( 'headings_color' ) ) : ?>
			h1, h2, h3, h4, h5, h6,
			.entry-title,
			.entry-title a {
				color:<?php echo esplanade_get_option( 'headings_color' ); ?>;
			}
		<?php endif; ?>
		<?php if( $default_options['content_color'] != esplanade_get_option( 'content_color' ) ) : ?>
			.entry-content {
				color:<?php echo esplanade_get_option( 'content_color' ); ?>;
			}
		<?php endif; ?>
	<?php endif; ?>
	<?php if( $default_options['links_color'] != esplanade_get_option( 'links_color' ) ) : ?>
		a {
			color:<?php echo esplanade_get_option( 'links_color' ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['links_hover_color'] != esplanade_get_option( 'links_hover_color' ) ) : ?>
		a:hover {
			color:<?php echo esplanade_get_option( 'links_hover_color' ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['menu_color'] != esplanade_get_option( 'menu_color' ) ) : ?>
		#access a {
			color:<?php echo esplanade_get_option( 'menu_color' ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['menu_hover_color'] != esplanade_get_option( 'menu_hover_color' ) ) : ?>
		#access a:hover,
		#access li.current_page_item > a {
			color:<?php echo esplanade_get_option( 'menu_hover_color' ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['sidebar_color'] != esplanade_get_option( 'sidebar_color' ) ) : ?>
		#sidebar,
		#sidebar-left,
		#sidebar-right {
			color:<?php echo esplanade_get_option( 'sidebar_color' ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['sidebar_title_color'] != esplanade_get_option( 'sidebar_title_color' ) ) : ?>
		.widget-title {
			color:<?php echo esplanade_get_option( 'sidebar_title_color' ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['sidebar_links_color'] != esplanade_get_option( 'sidebar_links_color' ) ) : ?>
		.widget-area a {
			color:<?php echo esplanade_get_option( 'sidebar_links_color' ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['footer_color'] != esplanade_get_option( 'footer_color' ) ) : ?>
		#footer-area {
			color:<?php echo esplanade_get_option( 'footer_color' ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['footer_title_color'] != esplanade_get_option( 'footer_title_color' ) ) : ?>
		#footer-area .widget-title {
			color:<?php echo esplanade_get_option( 'footer_title_color' ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['copyright_color'] != esplanade_get_option( 'copyright_color' ) ) : ?>
		#copyright {
			color:<?php echo esplanade_get_option( 'copyright_color' ); ?>;
		}
	<?php endif; ?>
	<?php if( $default_options['copyright_links_color'] != esplanade_get_option( 'copyright_links_color' ) ) : ?>
		#copyright a {
			color:<?php echo esplanade_get_option( 'copyright_links_color' ); ?>;
		}
	<?php endif; ?>
	<?php echo esplanade_get_option( 'user_css' ); ?>
</style>
<?php
}
endif;

add_action( 'wp_head', 'esplanade_custom_styles' );

if ( ! function_exists( 'esplanade_body_class' ) ) :
/**
 * Adds template names to body_class filter
 *
 * The custom layouts are shared with the custom templates
 * and use the same style declarations
 * @since Esplanade 1.0
 */
function esplanade_body_class( $classes ) {
	$default_options = esplanade_default_options();
	if( 'sidebar-content' == esplanade_get_option( 'layout' ) )
		$classes[] = 'page-template-template-sidebar-content-php';
	elseif( 'sidebar-content-sidebar' == esplanade_get_option( 'layout' ) )
		$classes[] = 'page-template-template-sidebar-content-sidebar-php';
	elseif( ( 'no-sidebars' == esplanade_get_option( 'layout' ) ) || ( ! is_active_sidebar( 2 ) && ! is_active_sidebar( 3 ) && ! is_active_sidebar( 4 ) && ! is_active_sidebar( 5 ) ) )
		$classes[] = 'page-template-template-no-sidebars-php';
	elseif( 'full-width' == esplanade_get_option( 'layout' ) )
		$classes[] = 'page-template-template-full-width-php';
	return $classes;
}
endif;

add_filter( 'body_class', 'esplanade_body_class' );

if ( ! function_exists( 'esplanade_doc_title' ) ) :
/**
 * Output the <title> tag
 *
 * @since Esplanade 1.0
 */
function esplanade_doc_title( $doc_title ) {
	global $page, $paged;
	$doc_title = str_replace( '&raquo;', '', $doc_title );
	$site_description = get_bloginfo( 'description', 'display' );
	$separator = '#124';
	if ( is_singular() ) {
		if ( $paged >= 2 || $page >= 2 )
			$doc_title .=  ', ' . __( 'Page', 'esplanade' ) . ' ' . max( $paged, $page );
	} else {
		if( ! is_home() )
			$doc_title .= ' &' . $separator . '; ';
		$doc_title .= get_bloginfo( 'name' );
		if ( $paged >= 2 || $page >= 2 )
			$doc_title .=  ', ' . __( 'Page', 'esplanade' ) . ' ' . max( $paged, $page );
	}
	if ( is_home() && $site_description )
		$doc_title .= ' &' . $separator . '; ' . $site_description;
	return $doc_title;
}
endif;

add_filter( 'wp_title', 'esplanade_doc_title' );

if ( ! function_exists( 'esplanade_breadcrumbs' ) ) :
/**
 * Output the breadcrumb trail
 *
 * @since Esplanade 1.0
 */
function esplanade_breadcrumbs() {
	global $page, $paged;
	$sep = ' &rsaquo; '; ?>
	<div id="breadcrumbs">
	<span class="prefix-text"><?php echo __( '', 'esplanade') . ''; ?></span>
	<a href="<?php echo home_url( '/' ); ?>" rel="home"><?php _e( 'Home', 'esplanade'); ?></a>
	<?php if ( ! is_front_page() ) {
		if ( is_archive() ) {
			if ( is_category() ) {
				$cat_id = get_query_var( 'cat' );
				$cat = get_category( $cat_id );
				$cat_id = $cat->parent;
				$parents = array();
				while ( $cat_id ) {
					$parent = get_category( $cat_id );
					$parents[] = '<a href="' . get_category_link( $parent->cat_ID ) . '">' . $parent->name . '</a>';
					$cat_id = $parent->parent;
				}
				$parents = array_reverse( $parents );
				foreach ( $parents as $parent ) {
					echo $sep;
					echo $parent;
				}
				echo $sep;
				if( is_paged() ) {
					echo '<a href="' . get_category_link( get_query_var( 'cat' ) ) . '">';
					single_cat_title();
					echo '</a>';
				} else
					single_cat_title();
			} elseif ( is_tag() ) {
				echo $sep;
				if( is_paged() ) {
					echo '<a href="' . get_tag_link( get_query_var( 'tag' ) ) . '">';
					echo __( 'Entries tagged with', 'esplanade' ) . ' &quot;' . single_tag_title( '', false) . '&quot;';
					echo '</a>';
				} else
					echo __( 'Entries tagged with', 'esplanade' ) . ' &quot;' . single_tag_title( '', false) . '&quot;';
			} elseif ( is_author() ) {
				$author = get_userdata( get_query_var( 'author' ) );
				echo $sep;
				if( is_paged() ) {
					echo '<a href="' . get_author_posts_url( get_query_var( 'author' ) ) . '">';
					echo __( 'Entries written by', 'esplanade' ) . ' ' . $author->display_name . '';
					echo '</a>';
				} else
					echo __( 'Entries written by', 'esplanade' ) . ' ' . $author->display_name . '';
			} elseif ( is_year() ) {
				echo $sep;
				echo __( 'Archive for', 'esplanade' ) . ' ' . get_query_var( 'year' );
			} elseif ( is_month() ) {
				echo $sep;
				echo __( 'Archive for', 'esplanade' ) . ' ' . get_the_time( 'F Y' );
			} elseif ( is_day() ) {
				echo $sep;
				echo __( 'Archive for', 'esplanade' ) . ' ' . get_the_time( 'F j, Y' );
			}
		} elseif ( is_singular() ) {
			global $post;
			if ( is_home() ) {
				echo $sep;
			} elseif ( is_page() ) {
				$parents = get_post_ancestors( $post->ID );
				$parents = array_reverse( $parents );
				foreach( $parents as $parent ) {
					echo $sep;
					echo '<a href="' . get_permalink( $parent ) . '" rel="bookmark">' . get_the_title( $parent ) . '</a>';
				}
				echo $sep;
			} elseif( is_attachment() ) {
				echo $sep;
				if ( ! empty( $post->post_parent ) ) {
					echo '<a href="' . get_permalink( $post->post_parent ) . '" rel="gallery">' . get_the_title( $post->post_parent ) . '</a>';
					echo $sep;
				}
			} elseif ( is_single() ) {
				echo $sep;
				$categories = get_the_category( $post->ID );
				$category = $categories[0]; ?>
				<a href="<?php echo get_category_link( $category->cat_ID ); ?>" rel="bookmark"><?php echo $category->cat_name; ?></a>
				<?php echo $sep;
			}
			if ( $page >= 2 ) {
				echo '<a href="' . get_permalink( $post->ID ) . '">';
				echo get_the_title( $post->ID );
				echo '</a>';
			} else
				echo get_the_title( $post->ID );
		} elseif( is_404() ) {
			echo $sep;
			echo __( 'Page not found', 'esplanade' );
		} elseif( is_search() ) {
			echo $sep;
			echo __( 'Search results for', 'esplanade' ) . ': &quot;' . get_search_query() . '&quot;';
		}
	}
	if ( $paged >= 2 || $page >= 2 ) {
		echo $sep;
		echo __( 'Page', 'esplanade' ) . ' ' . max( $paged, $page );
	} ?>
	</div>
<?php
}
endif;

if ( ! function_exists( 'esplanade_current_location' ) ) :
/**
 * Highlight current location in the archive
 *
 * @since Esplanade 1.0
 */
function esplanade_current_location() {
	if ( ! is_home() && ! is_singular() ) {
		if( is_author() )
			$archive = 'author';
		elseif( is_category() || is_tag() ) {
			$archive = get_queried_object()->taxonomy;
			$archive = str_replace( 'post_', '', $archive );
		} else
			$archive = ''; ?>
		<hgroup id="current-location">
			<h6 class="prefix-text"><?php _e( 'Currently browsing', 'esplanade' ); ?> <?php echo $archive; ?></h6>
			<<?php esplanade_title_tag( 'location' ); ?> class="page-title">
				<?php if( is_search() ) {
					__( 'Search results for', 'esplanade' ) . ': &quot;' .  get_search_query() . '&quot;';
				} elseif( is_author() ) {
					$author = get_userdata( get_query_var( 'author' ) );
					echo $author->display_name;
				} elseif ( is_year() ) {
					echo get_query_var( 'year' );
				} elseif ( is_month() ) {
					echo get_the_time( 'F Y' );
				} elseif ( is_day() ) {
					echo get_the_time( 'F j, Y' );
				} else {
					single_term_title( '' );
				} ?>
			</<?php esplanade_title_tag( 'location' ); ?>>
		</hgroup>
		<?php
	}
}
endif;

if ( ! function_exists( 'esplanade_title_tag' ) ) :
/**
 * Displays the tag selected in SEO options
 *
 * @param $tag string Title for which to display the tag
 * @since Esplanade 1.0
 */
function esplanade_title_tag( $tag ) {
	if( is_home() && ! is_paged() )
		echo esplanade_get_option( 'home_' . $tag . '_title_tag' );
	elseif( is_singular() )
		echo esplanade_get_option( 'single_' . $tag . '_title_tag' );
	else
		echo esplanade_get_option( 'archive_' . $tag . '_title_tag' );
}
endif;

if ( ! function_exists( 'esplanade_is_teaser' ) ) :
/**
 * Checks whether displayed post is a teaser
 *
 * @since Esplanade 1.0
 */
function esplanade_is_teaser() {
	if( is_home() && ! is_paged() && ( 'grid' == esplanade_get_option( 'home_page_layout' ) ) ) {
		global $esplanade_count;
		if( ! isset( $esplanade_count ) )
			$esplanade_count = 0;
		$count = $esplanade_count;
		if( esplanade_get_option( 'slider' ) ) {
			$sticky = get_option( 'sticky_posts' );
			$count = $count - count( $sticky );
		}
		if ( $count > esplanade_get_option( 'home_page_excerpts' ) )
			return true;
		else
			return false;
	} else
		return false;
}
endif;

if ( ! function_exists( 'esplanade_post_class' ) ) :
/**
 * Add class has-thumbnail to posts that have a thumbnail set
 *
 * @since Esplanade 1.0
 */
function esplanade_post_class( $classes, $class, $post_id ) {
	if( is_home() && ! is_paged() ) {
		global $esplanade_teaser_odd, $esplanade_count;
		if( ! isset( $esplanade_teaser_odd ) )
			$esplanade_teaser_odd = 1;
		if( ! isset( $esplanade_count ) )
			$esplanade_count = 0;
		$esplanade_count++;
		if( esplanade_is_teaser() ) {
			$classes[] = 'teaser';
			if( $esplanade_teaser_odd ) {
				$classes[] = 'teaser-odd';
				$esplanade_teaser_odd = 0;
			} else
				$esplanade_teaser_odd = 1;
		}
	}
	if( ! is_singular() && has_post_thumbnail()&& ! has_post_format( 'gallery' ) && ! has_post_format( 'image' ) && ! has_post_format( 'status' ) && ! has_post_format( 'video' )  )
		$classes[] = 'has-thumbnail';
	return $classes;
}
endif;

add_filter( 'post_class', 'esplanade_post_class', 10, 3 );

if ( ! function_exists( 'esplanade_teaser_clearfix' ) ) :
/**
 * Clears teaser rows to preserve a consistent grid
 *
 * @since Esplanade 1.0
 */
function esplanade_teaser_clearfix() {
	global $esplanade_count;
	$count = $esplanade_count;
	if( esplanade_get_option( 'slider' ) ) {
		$sticky = get_option( 'sticky_posts' );
		$count = $count - count( $sticky );
	}
	$count = $count - esplanade_get_option( 'home_page_excerpts' );
	if( 0 == $count % 2 ) : ?>
		<div class="clear"></div>
	<?php endif;
}
endif;

if ( ! function_exists( 'esplanade_excerpt_length' ) ) :
/**
 * Change the number of words shown in excerps
 *
 * @since Esplanade 1.0
 */
function esplanade_excerpt_length( $length ) {
	if( esplanade_is_teaser() ) {
		if( has_post_format( 'aside' ) )
			return 36;
		else
			return 22;
	} else
		return 50;
}
endif;

add_filter( 'excerpt_length', 'esplanade_excerpt_length' );

if ( ! function_exists( 'esplanade_excerpt_more' ) ) :
/**
 * Changes the default excerpt trailing content
 *
 * Replaces the default [...] trailing text from excerpts
 * to a more pleasant ...
 *
 * @since Esplanade 1.0
 */
function esplanade_excerpt_more($more) {
	return ' &#8230;';
}
endif;

add_filter( 'excerpt_more', 'esplanade_excerpt_more' );

if ( ! function_exists( 'esplanade_password_form' ) ) :
/**
 * Add password form on protected posts
 *
 * @since Esplanade 1.0.1
 */
function esplanade_password_form( $excerpt ) {
	if( post_password_required() )
		$excerpt = apply_filters( 'the_content', get_the_content() );
	return $excerpt;
}
endif;

add_filter( 'the_excerpt', 'esplanade_password_form' );

if ( ! function_exists( 'esplanade_excerpt_permalink' ) ) :
/**
 * Add a permalink to post formats that display with no title
 *
 * @since Esplanade 1.0.1
 */
function esplanade_excerpt_permalink( $excerpt ) {
	if( esplanade_is_teaser() && ( has_post_format( 'aside' ) || has_post_format( 'quote' ) || has_post_format( 'status' ) ) )
		$excerpt = str_replace( '</p>', ' <a href="' . get_permalink() . '" rel="bookmark">&rarr; ' . get_the_time( get_option( 'date_format' ) ) . '</a></p>', $excerpt );
	return $excerpt;
}
endif;

add_filter( 'the_excerpt', 'esplanade_excerpt_permalink' );

if ( ! function_exists( 'esplanade_title_permalink' ) ) :
/**
 * Add a permalink to teasers with no title
 *
 * @since Esplanade 1.0.1
 */
function esplanade_title_permalink( $title ) {
	if( esplanade_is_teaser() && ( '' == $title ) )
		$title = '&rarr; ' . get_the_time( get_option( 'date_format' ) );
	return $title;
}
endif;

add_filter( 'the_title', 'esplanade_title_permalink' );

if ( ! function_exists( 'esplanade_gallery_shortcode' ) ) :
/**
 * The Gallery shortcode.
 *
 * This implements the functionality of the Gallery Shortcode for displaying
 * WordPress images on a post. Replaced the default gallery style with HTML 5 markup.
 * Also disables inline styling by default.
 *
 * @since Esplanade 1.0
 *
 * @param string $output Empty string passed by core function.
 * @param array $attr Attributes attributed to the shortcode.
 * @return string HTML content to display gallery.
 */
function esplanade_gallery_shortcode( $output, $attr ) {
	global $post, $wp_locale;
	static $instance = 0;
	$instance++;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract( shortcode_atts( array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'figure',
		'icontag'    => 'span',
		'captiontag' => 'figcaption',
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => ''
	), $attr ) );

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array( 'include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( ! empty( $exclude ) ) {
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty( $attachments ) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	$itemtag = tag_escape( $itemtag );
	$captiontag = tag_escape( $captiontag );
	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(90/$columns) : 90;
	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	$gallery_style = $gallery_div = '';
	if ( apply_filters( 'use_default_gallery_style', false ) )
		$gallery_style = "
		<style type='text/css'>
			#{$selector} {
				margin: auto;
			}
			#{$selector} .gallery-item {
				float: {$float};
				width: {$itemwidth}%;
				margin:0 1.5% 3%;
				text-align: center;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
		</style>
		<!-- see gallery_shortcode() in wp-includes/media.php -->";
	$size_class = sanitize_html_class( $size );
	$link = isset($attr['link']) && 'file' == $attr['link'] ? 'file' : 'attachment';
	$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class} gallery-link-{$link}'>";
	$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);

		$output .= "<{$itemtag} class='gallery-item'>";
		$output .= "
			<{$icontag} class='gallery-icon'>
				$link
			</{$icontag}>";
		if ( $captiontag && trim($attachment->post_excerpt) ) {
			$output .= "
				<{$captiontag} class='wp-caption-text gallery-caption'>
				" . wptexturize($attachment->post_excerpt) . "
				</{$captiontag}>";
		}
		$output .= "</{$itemtag}>";
		if ( $columns > 0 && ++$i % $columns == 0 )
			$output .= '<br style="clear: both" />';
	}

	$output .= "
			<div class='clear'></div>
		</div>\n";

	return $output;
}
endif;

add_filter( 'post_gallery', 'esplanade_gallery_shortcode', 10, 2 );

if ( ! function_exists( 'esplanade_rel_attachment' ) ) :
function esplanade_rel_attachment( $link ) {
	return str_replace( "<a ", "<a rel='attachment' ", $link );
}
endif;

add_filter( 'wp_get_attachment_link', 'esplanade_rel_attachment' );

if ( ! function_exists( 'esplanade_get_first_image' ) ) :
/**
 * Show the first image inserted in the current postimage
 *
 * @since Esplanade 1.0.4
 */
function esplanade_get_first_image() {
	$document = new DOMDocument();
	// Silencing warnings as DOMDocument does not understand HTML5 tags (yet)
	libxml_use_internal_errors( true );
	$document->loadHTML( apply_filters( 'the_content', get_the_content( '', true ) ) );
	libxml_clear_errors();
	$images = $document->getElementsByTagName( 'img' );
	$document = new DOMDocument();
	if( $images->length ) {
		$image= $images->item( $images->length - 1 );
		$src = $image->getAttribute( 'src' );
		$width = ( $image->hasAttribute( 'width' ) ? $image->getAttribute( 'width' ) : false );
		$height = ( $image->hasAttribute( 'height' ) ? $image->getAttribute( 'height' ) : false );
		return array( $src, $width, $height );
	}
	return false;
}
endif;

if ( ! function_exists( 'esplanade_post_image' ) ) :
/**
 * Show the last image attached to the current post
 *
 * Used in image post formats
 * Images attached to image posts should not appear in the post's content
 * to avoid duplicate display of the same content
 *
 * @uses get_posts() To retrieve attached image
 *
 * @since Esplanade 1.0
 */
function esplanade_post_image() {
	// Retrieve the last image attached to the post
	$args = array(
		'numberposts' => 1,
		'post_type' => 'attachment',
		'post_mime_type' => 'image',
		'post_parent' => get_the_ID()
	);
	$attachments = get_posts( $args );
	if( has_post_thumbnail() ) :
		$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ); ?>
		<figure class="wp-caption" style="margin:0 auto; width:<?php echo $image[1] + 10; ?>px">
			<a href="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ); echo $image[0] ?>" title="<?php the_title_attribute(); ?>" rel="attachment">
				<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'attachment-thumb' ); ?>
			</a>
			<?php $attachment = get_post( get_post_thumbnail_id() ); ?>
			<?php if ( ! empty( $attachment->post_excerpt ) ) : ?>
				<figcaption class="wp-caption-text">
					<?php echo apply_filters( 'the_excerpt', $attachment->post_excerpt ); ?>
				</figcaption><!-- .entry-caption -->
			<?php endif; ?>
		</figure><!-- .wp-caption -->
	<?php elseif( count( $attachments ) ) :
		$attachment = $attachments[0];
		if( isset( $attachment ) && ! post_password_required() ) :
			$image = wp_get_attachment_image_src( $attachment->ID, 'full' ); ?>
			<figure class="wp-caption" style="margin:0 auto; width:<?php echo $image[1] + 10; ?>px">
				<a href="<?php echo $image[0]; ?>" title="<?php the_title_attribute(); ?>" rel="attachment">
					<?php echo wp_get_attachment_image( $attachment->ID, 'attachment-thumb' ); ?>
				</a>
				<?php if ( ! empty( $attachment->post_excerpt ) ) : ?>
					<figcaption class="wp-caption-text">
						<?php echo apply_filters( 'the_excerpt', $attachment->post_excerpt ); ?>
					</figcaption><!-- .wp-caption-text -->
				<?php endif; ?>
			</figure><!-- .wp-caption -->
		<?php endif;
	elseif( false !== esplanade_get_first_image() ) :
		if( ! post_password_required() ) :
			$image = esplanade_get_first_image();
			if( false === $image[1] )
				$image[1] = 640;
			if( false === $image[2] )
				$image[2] = 395;
			$attachment = get_post( get_the_ID() ); ?>
			<figure class="wp-caption" style="margin:0 auto; width:<?php echo $image[1] + 10; ?>px">
				<a href="<?php echo $image[0]; ?>" title="<?php the_title_attribute(); ?>" rel="attachment">
					<img src="<?php echo $image[0]; ?>" alt="<?php the_title_attribute(); ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" />
				</a><?php the_excerpt(); ?>
				<?php if ( ! empty( $attachment->post_excerpt ) ) : ?>
					<figcaption class="wp-caption-text">
						<?php echo apply_filters( 'the_excerpt', $attachment->post_excerpt ); ?>
					</figcaption><!-- .wp-caption-text -->
				<?php endif; ?>
			</figure><!-- .wp-caption -->
		<?php endif;
	else :
		the_content();
	endif;
}
endif;

if ( ! function_exists( 'esplanade_post_gallery' ) ) :
/**
 * Show a gallery of images attached to the current post
 *
 * Used in gallery post formats
 * Galery post formats shou;d not use the [gallery] shortcode
 * to avoid duplicate display of the same content
 * to avoid duplicate of the same content
 *
 * @uses get_posts() To retrieve attached images
 *
 * @since Esplanade 1.0
 */
function esplanade_post_gallery() {
	// Retrieve images attached to post
	$args = array(
		'numberposts' => 6,
		'post_type' => 'attachment',
		'post_mime_type' => 'image',
		'post_parent' => get_the_ID()
	);
	$attachments = get_posts( $args );
	// Reverse array to display them in chronological form instead of reverse chronological
	$attachments = array_reverse( $attachments );
	$link = '<a href="' . get_permalink() . '" title="' . esc_attr( strip_tags( get_the_title() ) ) . '" rel="bookmark">' . get_the_title() . '</a>';
	$count = count( get_posts( array( 'numberposts' => -1, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'post_parent' => get_the_ID() ) ) );
	if( count( $attachments ) && ! post_password_required() ) : ?>
		<div class="gallery gallery-columns-6 gallery-link-file">
			<?php foreach( $attachments as $attachment ) : ?>
				<figure class="gallery-item">
					<a href="<?php $image = wp_get_attachment_image_src( $attachment->ID, 'full' ); echo $image[0]; ?>" class="colorbox" title="<?php echo esc_attr( get_the_title( $attachment->ID ) ); ?>" rel="attachment">
						<?php echo wp_get_attachment_image( $attachment->ID, 'gallery-thumb' ); ?>
					</a>
				</figure><!-- .gallery-item -->
			<?php endforeach; ?>
			<div class="clear"></div>
		</div><!-- .gallery -->
		<p><?php echo sprintf( __( 'This is a gallery about %1$s and contains %2$d images.', 'esplanade' ), $link, $count ); ?></p>
	<?php endif;
}
endif;

if ( ! function_exists( 'esplanade_first_embed' ) ) :
function esplanade_first_embed() {
	$document = new DOMDocument();
	$document->loadHTML( apply_filters( 'the_content', get_the_content( '', true ) ) );
	$iframes = $document->getElementsByTagName( 'iframe' );
	$objects = $document->getElementsByTagName( 'object' );
	$embeds = $document->getElementsByTagName( 'embed' );
	$document = new DOMDocument();
	if( $iframes->length ) {
			$iframe= $iframes->item( $iframes->length - 1 );
			$document->appendChild( $document->importNode( $iframe, true ) );
	} elseif( $objects->length ) {
			$object= $objects->item( $objects->length - 1 );
			$document->appendChild( $document->importNode( $object, true ) );
	} elseif( $embeds->length ) {
			$embed= $embeds->item( $embeds->length - 1 );
			$document->appendChild( $document->importNode( $embed, true ) );
	}
	echo '<div class="entry-attachment"><p>' . $document->saveHTML() . '</p></div><!-- .entry-attachment -->';
}
endif;

if ( ! function_exists( 'esplanade_post_audio' ) ) :
/**
 * Audio playback support for post with the audio format
 *
 * Displays the attached audio files in a HTML5 <audio> tag with flash fallback
 * If more then one attached audio file is found, they are used as fallback to the first one
 * Should work in most if not all browsers :)
 *
 * @uses get_posts() To retrieve attached audio files
 *
 * @since Esplanade 1.0
 */
function esplanade_post_audio() {
	if( ! post_password_required() ) :
		// Get attached audio files
		$args = array(
			'numberposts' => -1,
			'post_type' => 'attachment',
			'post_mime_type' => 'audio',
			'post_parent' => get_the_ID()
		);
		$attachments = get_posts( $args );
		// Reverse array to display them in chronological form instead of reverse chronological
		$attachments = array_reverse( $attachments );
		if( count( $attachments ) ) :
			// Detect MP3 file to use it as flash fallback
			$mime_types = array();
			foreach( $attachments as $attachment ) :
				if( $attachment->post_mime_type == 'audio/mpeg' )
					$flash_audio = $attachment;
			endforeach; ?>
			<div class="entry-attachment">
				<audio controls id="audio-player-<?php the_ID(); ?>">
					<?php foreach( $attachments as $attachment ) : ?>
						<source src="<?php echo wp_get_attachment_url( $attachment->ID ); ?>">
					<?php endforeach; ?>
				</audio>
				<?php if( isset( $flash_audio ) ) :
					// Display flash fallback ?>
					<div id="flash-audio-player-<?php the_ID(); ?>"></div>
					<script>
						var audioTag = document.createElement('audio');
							if( !( !!( audioTag.canPlayType ) && ( <?php foreach( $attachments as $attachment ) : ?>( ( "no" != audioTag.canPlayType( "<?php echo $attachment->post_mime_type; ?>" ) ) && ( "" != audioTag.canPlayType( "<?php echo $attachment->post_mime_type; ?>" ) ) )<?php if( $attachment != end( $attachments ) ) : ?> || <?php endif; ?><?php endforeach; ?> ) ) ) {
							document.getElementById("audio-player-<?php the_ID(); ?>").style.display="none";
							AudioPlayer.embed("flash-audio-player-<?php the_ID(); ?>", {soundFile: "<?php echo wp_get_attachment_url( $flash_audio->ID ); ?>"});
						}
					</script>
				<?php endif; ?>
			</div><!-- .entry-attachment -->
		<?php elseif( ! is_singular() ) :
			esplanade_first_embed();
		endif;
	endif;
}
endif;

if ( ! function_exists( 'esplanade_file_types' ) ) :
/**
 * Allows uploading of .webm video files
 *
 * @since Esplanade 1.0
 */
function esplanade_file_types( $types ) {
	$types['video'][] = 'webm';
	return $types;
}
endif;

add_filter( 'ext2type', 'esplanade_file_types' );

if ( ! function_exists( 'esplanade_mime_types' ) ) :
/**
 * Registers the webm mime type
 *
 * @since Esplanade 1.0
 */
function esplanade_mime_types( $types ) {
	$types['webm'] = 'video/webm';
	return $types;
}
endif;

add_filter( 'upload_mimes', 'esplanade_mime_types' );

if ( ! function_exists( 'esplanade_post_video' ) ) :
/**
 * Video playback support for post with the video format
 *
 * Displays the attached video in a HTML5 <video> tag with flash fallback
 * If more then one attached video is found, they are used as fallback to the first one
 * Should work in most if not all browsers :)
 *
 * @uses get_posts() To retrieve attached videos
 *
 * @since Esplanade 1.0
 */
function esplanade_post_video() {
	if( ! post_password_required() ) :
		// Get attached videos
		$args = array(
			'numberposts' => -1,
			'post_type' => 'attachment',
			'post_mime_type' => 'video',
			'post_parent' => get_the_ID()
		);
		$attachments = get_posts( $args );
		// Reverse array to display them in chronological order instead of reverse chronological
		$attachments = array_reverse( $attachments );
		if( count( $attachments ) ) :
			// Detect flash video format to use it as fallback
			$mime_types = array();
			foreach( $attachments as $attachment )
				if( $attachment->post_mime_type == 'video/x-flv' )
					$flash_video = $attachment; ?>
			<div class="entry-attachment">
				<video controls width="700" height="444"<?php if( has_post_thumbnail() ) : ?> poster="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'video-thumb' ); echo $image[0]; ?>"<?php endif; ?> id="video-player-<?php the_ID(); ?>">
					<?php foreach( $attachments as $attachment ) :
						// Show each video file as a fallback source ?>
						<source src="<?php echo wp_get_attachment_url( $attachment->ID ); ?>" type='<?php echo $attachment->post_mime_type; if( $attachment->post_mime_type == 'video/mp4' ) echo '; codecs="avc1.42E01E, mp4a.40.2"'; elseif( $attachment->post_mime_type == 'video/webm' ) echo '; codecs="vp8, vorbis"'; elseif( $attachment->post_mime_type == 'video/ogg' ) echo '; codecs="theora, vorbis"'; ?>'>
					<?php endforeach; ?>
				</video>
				<?php if( isset( $flash_video ) ) :
					// Display flash fallback ?>
					<?php if( count( $attachments ) ) : ?>
						<div id="flash-video-player-<?php the_ID(); ?>"></div>
						<script type="text/javascript">
						/* <![CDATA[ */
							var videoTag = document.createElement('video');
							if( !( !!( videoTag.canPlayType ) && ( <?php foreach( $attachments as $attachment ) : ?>( ( "no" != videoTag.canPlayType( "<?php echo $attachment->post_mime_type; ?>" ) ) && ( "" != videoTag.canPlayType( "<?php echo $attachment->post_mime_type; ?>" ) ) )<?php if( $attachment != end( $attachments ) ) : ?> || <?php endif; ?><?php endforeach; ?> ) ) ) {
								document.getElementById("video-player-<?php the_ID(); ?>").style.display="none";
								var flashvars = {
									skin: "<?php echo get_template_directory_uri(); ?>/video-player/skin.swf",
									video: "<?php echo wp_get_attachment_url( $flash_video->ID ); ?>",
									thumbnail: "<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'video-thumb' ); echo $image[0] ?>"
								};
								var params = {
									quality: "high",
									menu: "false",
									allowFullScreen: "true",
									scale: "noscale",
									allowScriptAccess: "always",
									swLiveConnect: "true"
								};
								var attributes = {
									id: "f4-player"
								};
								swfobject.embedSWF("<?php echo get_template_directory_uri(); ?>/video-player/player.swf", "flash-video-player-<?php the_ID(); ?>", "700", "444", "9.0.0","expressInstall.swf", flashvars, params, attributes);
							} else {
								document.getElementById("video-player").style.display="none";
							}
						/* ]]> */
						</script>
					<?php endif; ?>
				<?php endif; ?>
			</div><!-- .entry-attachment -->
		<?php elseif( ! is_singular() ) :
			esplanade_first_embed();
		endif;
	endif;
}
endif;

if ( ! function_exists( 'esplanade_post_link' ) ) :
function esplanade_post_link( $src ) {
	if( has_post_format( 'link' ) ) {
		$document = new DOMDocument();
		$document->loadHTML( apply_filters( 'the_content', get_the_content( '', true ) ) );
		$links = $document->getElementsByTagName( 'a' );
		for( $i = 0; $i < $links->length; $i++ ) {
			$link = $links->item($i);
			$document = new DOMDocument();
			$document->appendChild( $document->importNode( $link, true ) );
			$src = $link->getAttribute('href');
		}
	}
	return $src;
}
endif;

add_filter( 'the_permalink', 'esplanade_post_link' );

if ( ! function_exists( 'esplanade_first_blockquote' ) ) :
function esplanade_first_blockquote() {
	$document = new DOMDocument();
	$document->loadHTML( apply_filters( 'the_content', get_the_content( '', true ) ) );
	$blockquotes = $document->getElementsByTagName( 'blockquote' );
	for( $i = 0; $i < $blockquotes->length; $i++ ) {
		$blockquote = $blockquotes->item($i);
		$document = new DOMDocument();
		$document->appendChild( $document->importNode( $blockquote, true ) );
		echo $document->saveHTML();
	}
}
endif;

if ( ! function_exists( 'esplanade_attachment_nav' ) ) :
/**
 * Display social networks share icons
 *
 * @since Esplanade 1.0
 */
function esplanade_attachment_nav() {
	global $post;
	if( ! empty( $post->post_parent ) ) {
		$attachments = array_values( get_children( array(
			'post_parent' => $post->post_parent,
			'post_status' => 'inherit',
			'post_type' => 'attachment',
			'post_mime_type' => 'image'
		) ) );
		if( count( $attachments ) > 1 ) : ?>
		<div id="attachment-nav">
			<div class="nav-next"><?php next_image_link(); ?></div>
			<div class="nav-previous"><?php previous_image_link(); ?></div>
			<div class="clear"></div>
		</div><!-- #attachment-nav -->
		<?php endif;
	}
}
endif;

if ( ! function_exists( 'esplanade_social_bookmarks' ) ) :
/**
 * Display social networks share icons
 *
 * @since Esplanade 1.0
 */
function esplanade_social_bookmarks() {
	if( esplanade_get_option( 'facebook' ) || esplanade_get_option( 'twitter' ) || esplanade_get_option( 'google' ) || esplanade_get_option( 'pinterest' ) ) : ?>
		<div class="social-bookmarks">
			<p><?php _e( 'Did you like this article? Share it with your friends!', 'esplanade' ); ?></p>
			<?php if( esplanade_get_option( 'facebook' ) ) : ?>
				<div class="facebook-like">
					<div id="fb-root"></div>
					<script>
						(function(d, s, id) {
							var js, fjs = d.getElementsByTagName(s)[0];
							if (d.getElementById(id)) return;
							js = d.createElement(s); js.id = id;
							js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
							fjs.parentNode.insertBefore(js, fjs);
						}(document, 'script', 'facebook-jssdk'));
					</script>
					<div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="110" data-show-faces="false" data-font="arial"></div>
				</div><!-- .facebook-like -->
			<?php endif; ?>
			<?php if( esplanade_get_option( 'twitter' ) ) : ?>
				<div class="twitter-button">
					<a href="<?php echo esc_url( 'https://twitter.com/share' ); ?>" class="twitter-share-button" data-url="<?php the_permalink(); ?>">Tweet</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				</div><!-- .twitter-button -->
			<?php endif; ?>
			<?php if( esplanade_get_option( 'google' ) ) : ?>
				<div class="google-plus">
					<div class="g-plusone" data-size="medium" data-href="<?php the_permalink(); ?>"></div>
					<script type="text/javascript">
						(function() {
							var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
							po.src = 'https://apis.google.com/js/plusone.js';
							var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
						})();
					</script>
				</div><!-- .google-plus -->
			<?php endif; ?>
			<?php if( esplanade_get_option( 'pinterest' ) ) :
				if( wp_attachment_is_image( get_the_ID() ) || has_post_thumbnail() )
					$thumb = wp_get_attachment_image_src( ( is_attachment() ? get_the_ID() : get_post_thumbnail_id() ), 'full' );
				else
					$thumb = esplanade_get_first_image(); ?>
				<div class="pinterest-button">
					<a href="<?php echo esc_url( 'http://pinterest.com/pin/create/button/?url=' . urlencode( get_permalink() ) . ( false !== $thumb ? '&media=' . urlencode( $thumb[0] ) : '' ) . '&description=' . urlencode( apply_filters('the_excerpt', get_the_excerpt() ) ) ); ?>" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
					<script>
						(function(d, s, id) {
							var js, pjs = d.getElementsByTagName(s)[0];
							if (d.getElementById(id)) return;
							js = d.createElement(s); js.id = id;
							js.src = "//assets.pinterest.com/js/pinit.js";
							pjs.parentNode.insertBefore(js, pjs);
						}(document, 'script', 'pinterest-js'));
					</script>
				</div>
			<?php endif; ?>
			<div class="clear"></div>
		</div><!-- .social-bookmarks -->
	<?php endif;
}
endif;

if ( ! function_exists( 'esplanade_post_author' ) ) :
/**
 * Display notification no posts were found
 *
 * @since Esplanade 1.0
 */
function esplanade_post_author() {
	if( esplanade_get_option( 'author_box' ) ) : ?>
		<div class="entry-author">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), 96 ); ?>
			<h3 class="author vcard"><?php _e( 'Written by', 'esplanade' ) ?> <span class="fn"><?php the_author_posts_link(); ?></span></h3>
			<p class="author-bio"><?php the_author_meta( 'description' ); ?></p>
			<div class="author-meta">
				<?php if( '' != get_the_author_meta( 'user_url' ) ) : ?>
					<span class="author-website"><a class="url" href="<?php the_author_meta( 'user_url' ); ?>"><?php _e( 'Visit my Website', 'esplanade' ) ?></a></span>
				<?php endif; ?>
				<?php if( '' != get_the_author_meta( 'twitter' ) ) : ?>
					<span class="author-twitter"><a class="url" href="http://twitter.com/<?php the_author_meta( 'twitter' ); ?>"><?php _e( 'Follow me on Twitter', 'esplanade' ) ?></a></span>
				<?php endif; ?>
			</div><!-- .author-meta -->
			<div class="clear"></div>
		</div><!-- .entry-author -->
	<?php endif;
}
endif;

if ( ! function_exists( 'esplanade_post_nav' ) ) :
/**
 * Display notification no posts were found
 *
 * @since Esplanade 1.0
 */
function esplanade_post_nav() {
	if( esplanade_get_option( 'post_nav' ) ) : ?>
		<div id="post-nav" class="navigation">
			<div class="nav-prev"><?php previous_post_link( '%link', '&larr; %title' ); ?></div>
			<div class="nav-next"><?php next_post_link( '%link', '%title &rarr;' ); ?></div>
			<div class="clear"></div>
		</div><!-- #post-nav -->
	<?php endif;
}
endif;

if ( ! function_exists( 'esplanade_posts_nav' ) ) :
/**
 * Display notification no posts were found
 *
 * @since Esplanade 1.0
 */
function esplanade_posts_nav() {
	global $wp_query;
	if ( $wp_query->max_num_pages > 1 ) {
		switch( esplanade_get_option( 'posts_nav_labels' ) ) {
			case 'next/prev' :
				$prev_label = __( 'Previous Page', 'esplanade' );
				$next_label = __( 'Next Page', 'esplanade' );
				break;
			case 'older/newer' :
				$prev_label = __( 'Newer Posts', 'esplanade' );
				$next_label = __( 'Older Posts', 'esplanade' );
				break;
			case 'earlier/later' :
				$prev_label = __( 'Later Posts', 'esplanade' );
				$next_label = __( 'Earlier Posts', 'esplanade' );
				break;
			case 'numbered' :
				$big = 999999999; // need an unlikely integer
				$args = array(
					'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $wp_query->max_num_pages,
					'prev_text' => '&larr; <span class="text">' . __( 'Previous Page', 'esplanade' ) . '</span>',
					'next_text' => '<span class="text">' . __( 'Next Page', 'esplanade' ) . '</span> &rarr;'
				);
				break;
		}
		if( 'numbered' == esplanade_get_option( 'posts_nav_labels' ) ) : ?>
			<div id="posts-nav" class="navigation">
				<?php if( function_exists( 'wp_pagenavi' ) ) : ?>
					<?php wp_pagenavi(); ?> 
				<?php else : ?>
					<?php echo paginate_links( $args ); ?>
				<?php endif; ?>
			</div><!-- #posts-nav -->
		<?php else : ?>
			<div id="posts-nav" class="navigation">
				<div class="nav-prev"><?php previous_posts_link( '&larr; ' . $prev_label ); ?></div>
				<?php if( is_home() && ! is_paged() && ( 'grid' == esplanade_get_option( 'home_page_layout' ) ) ) : ?>
					<div class="nav-all"><?php next_posts_link( __( 'Read all Articles', 'esplanade' ) . ' &rarr;' ); ?></div>
				<?php else : ?>
					<div class="nav-next"><?php next_posts_link( $next_label . ' &rarr;' ); ?></div>
				<?php endif; ?>
				<div class="clear"></div>
			</div><!-- #posts-nav -->
		<?php endif;
	}
}
endif;

if ( ! function_exists( 'esplanade_404' ) ) :
/**
 * Display notification no posts were found
 *
 * @since Esplanade 1.0
 */
function esplanade_404() { ?>
	<article class="post hentry" id="post-0">
		<h2 class="entry-title"><?php _e( 'Content not found', 'esplanade' ) ?></h2>
		<div class="entry-content">
			<?php _e( 'The content you are looking for could not be found.', 'esplanade' ); ?></p>
			<?php if( is_active_sidebar( 7 ) ) : ?>
				<?php _e( 'Use the information below or try to seach to find what you\'re looking for:', 'esplanade' ); ?></p>
			<?php endif; ?>
			<?php dynamic_sidebar(7); ?>
		</div><!-- .entry-content -->
	</article><!-- .post -->
<?php
}
endif;

if ( ! function_exists( 'esplanade_copyright_notice' ) ) :
/**
 * Display notification no posts were found
 *
 * @since Esplanade 1.0
 */
function esplanade_copyright_notice() {
	$copyright = esplanade_get_option( 'copyright_notice' );
	$copyright = str_replace( '%year%', date( 'Y' ), $copyright );
	$copyright = str_replace( '%blogname%', get_bloginfo( 'name' ), $copyright );
	echo $copyright;
}
endif;

if ( ! function_exists( 'esplanade_show_extra_profile_fields' ) ) :
/**
 * Add profile field for Twitter account
 *
 * @since Esplanade 1.0
 */
function esplanade_show_extra_profile_fields( $user ) { ?>
	<h3><?php _e( 'Extra profile information', 'esplanade' ); ?></h3>
	<table class="form-table">
		<tr>
			<th><label for="twitter">Twitter</label></th>
			<td>
				<input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e( 'Twitter Username.', 'esplanade' ); ?></span>
			</td>
		</tr>
	</table>
<?php
}
endif;

add_action( 'show_user_profile', 'esplanade_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'esplanade_show_extra_profile_fields' );

if ( ! function_exists( 'esplanade_save_extra_profile_fields' ) ) :
/**
 * Save profile field for Twitter account
 *
 * @since Esplanade 1.0
 */
function esplanade_save_extra_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;
	update_user_meta( $user_id, 'twitter', $_POST['twitter'] );
}
endif;

add_action( 'personal_options_update', 'esplanade_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'esplanade_save_extra_profile_fields' );

// checks is WP is at least a certain version (makes sure it has sufficient comparison decimals
function esplanade_is_wp_version( $is_ver ) {
	$wp_ver = explode( '.', get_bloginfo( 'version' ) );
	$is_ver = explode( '.', $is_ver );
	for( $i=0; $i<=count( $is_ver ); $i++ )
		if( !isset( $wp_ver[$i] ) ) array_push( $wp_ver, 0 );
	foreach( $is_ver as $i => $is_val )
		if( $wp_ver[$i] < $is_val ) return false;
	return true;
}