<?php

function esplanade_theme_page() {
	add_theme_page( __( 'Esplanade Theme Options', 'esplanade' ), __( 'Theme Options', 'esplanade' ), 'edit_theme_options', 'esplanade_options', 'esplanade_admin_options_page' );
}

add_action( 'admin_menu', 'esplanade_theme_page' );

function esplanade_register_settings() {
	register_setting( 'esplanade_theme_options', 'esplanade_theme_options', 'esplanade_validate_theme_options' );
}

add_action( 'admin_init', 'esplanade_register_settings' );

function esplanade_admin_scripts( $page_hook ) {
	if( 'appearance_page_esplanade_options' == $page_hook ) {
		wp_enqueue_style( 'esplanade_admin_style', get_template_directory_uri() . '/styles/admin.css' );
		wp_enqueue_style( 'jquery-layout', get_template_directory_uri() . '/styles/jquery.layout.css' );
		wp_enqueue_style( 'farbtastic' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-draggable' );
		wp_enqueue_script( 'jquery-layout', get_template_directory_uri() . '/scripts/jquery.layout.js' );
		wp_enqueue_script( 'jquery-layout-state', get_template_directory_uri() . '/scripts/jquery.layout.state.js' );
		wp_enqueue_script( 'json2' );
		wp_enqueue_script( 'farbtastic' );
	}
}

add_action( 'admin_enqueue_scripts', 'esplanade_admin_scripts' );

function esplanade_admin_options_page() { ?>
	<div class="wrap">
		<?php esplanade_admin_options_page_tabs(); ?>
		<?php if ( isset( $_GET['settings-updated'] ) ) : ?>
			<div class='updated'><p><?php _e( 'Theme settings updated successfully.', 'esplanade' ); ?></p></div>
		<?php endif; ?>
		<form action="options.php" method="post">
			<?php settings_fields( 'esplanade_theme_options' ); ?>
			<?php do_settings_sections('esplanade_options'); ?>
			<p>&nbsp;</p>
			<?php $tab = ( isset( $_GET['tab'] ) ? $_GET['tab'] : 'general' ); ?>
			<input name="esplanade_theme_options[submit-<?php echo $tab; ?>]" type="submit" class="button-primary" value="<?php _e( 'Save Settings', 'esplanade' ); ?>" />
			<input name="esplanade_theme_options[reset-<?php echo $tab; ?>]" type="submit" class="button-secondary" value="<?php _e( 'Reset Defaults', 'esplanade' ); ?>" />
		</form>
	</div>
<?php
}

function esplanade_admin_options_page_tabs( $current = 'general' ) {
	$current = ( isset ( $_GET['tab'] ) ? $_GET['tab'] : 'general' );
	$tabs = array(
		'general' => __( 'General', 'esplanade' ),
		'layout' => __( 'Layout', 'esplanade' ),
		'design' => __( 'Design', 'esplanade' ),
		'typography' => __( 'Typography', 'esplanade' ),
		'seo' => __( 'SEO', 'esplanade' )
	);
	$links = array();
	foreach( $tabs as $tab => $name )
		$links[] = "<a class='nav-tab" . ( $tab == $current ? ' nav-tab-active' : '' ) ."' href='?page=esplanade_options&tab=$tab'>$name</a>";
	echo '<div id="icon-themes" class="icon32"><br /></div>';
	echo '<h2 class="nav-tab-wrapper">';
	foreach ( $links as $link )
		echo $link;
	echo '</h2>';
}

function esplanade_admin_options_init() {
	global $pagenow;
	if( 'themes.php' == $pagenow && isset( $_GET['page'] ) && 'esplanade_options' == $_GET['page'] ) {
		$tab = ( isset ( $_GET['tab'] ) ? $_GET['tab'] : 'general' );
		switch ( $tab ) {
			case 'general' :
				esplanade_general_settings_sections();
				break;
			case 'layout' :
				esplanade_layout_settings_sections();
				break;
			case 'design' :
				esplanade_design_settings_sections();
				break;
			case 'typography' :
				esplanade_typography_settings_sections();
				break;
			case 'seo' :
				esplanade_seo_settings_sections();
				break;
		}
	}
}

add_action( 'admin_init', 'esplanade_admin_options_init' );

function esplanade_general_settings_sections() {
	add_settings_section( 'esplanade_global_options', __( 'Global Options', 'esplanade' ), 'esplanade_global_options', 'esplanade_options' );
	add_settings_section( 'esplanade_home_page_options', __( 'Home Page', 'esplanade' ), 'esplanade_home_page_options', 'esplanade_options' );
	add_settings_section( 'esplanade_archive_page_options', __( 'Archive Pages', 'esplanade' ), 'esplanade_archive_page_options', 'esplanade_options' );
	add_settings_section( 'esplanade_single_options', __( 'Single Posts', 'esplanade' ), 'esplanade_single_options', 'esplanade_options' );
	add_settings_section( 'esplanade_footer_options', __( 'Footer', 'esplanade' ), 'esplanade_footer_options', 'esplanade_options' );
}

function esplanade_global_options() {
	add_settings_field( 'esplanade_fancy_dropdowns', __( 'Fancy Drop-down Menus', 'esplanade' ), 'esplanade_fancy_dropdowns', 'esplanade_options', 'esplanade_global_options' );
	add_settings_field( 'esplanade_show_breadcrumbs', __( 'Breadcrumbs', 'esplanade' ), 'esplanade_show_breadcrumbs', 'esplanade_options', 'esplanade_global_options' );
	add_settings_field( 'esplanade_use_lightbox', __( 'Lightbox', 'esplanade' ), 'esplanade_use_lightbox', 'esplanade_options', 'esplanade_global_options' );
	add_settings_field( 'esplanade_posts_nav_labels', __( 'Posts Navigation Labels', 'esplanade' ), 'esplanade_posts_nav_labels', 'esplanade_options', 'esplanade_global_options' );
}

function esplanade_fancy_dropdowns() { ?>
	<label class="description">
		<input name="esplanade_theme_options[fancy_dropdowns]" type="checkbox" value="1" <?php checked( esplanade_get_option( 'fancy_dropdowns' ) ); ?> />
		<span><?php _e( 'Enable slide and fade effects for drop-down menus', 'esplanade' ); ?></span>
	</label>
<?php
}

function esplanade_show_breadcrumbs() { ?>
	<label class="description">
		<input name="esplanade_theme_options[breadcrumbs]" type="checkbox" value="1" <?php checked( esplanade_get_option( 'breadcrumbs' ) ); ?> />
		<span><?php _e( 'Show breadcrumbs trail', 'esplanade' ); ?></span>
	</label>
<?php
}

function esplanade_use_lightbox() { ?>
	<label class="description">
		<input name="esplanade_theme_options[lightbox]" type="checkbox" value="1" <?php checked( esplanade_get_option( 'lightbox' ) ); ?> />
		<span><?php _e( 'Open links to images in a lightbox', 'esplanade' ); ?></span>
	</label>
<?php
}

function esplanade_posts_nav_labels() { ?>
	<select name="esplanade_theme_options[posts_nav_labels]">
		<option value="next/prev" <?php selected( 'next/prev', esplanade_get_option( 'posts_nav_labels' ) ); ?>><?php _e( 'Next Page', 'esplanade' ); ?> / <?php _e( 'Previous Page', 'esplanade' ); ?></option>
		<option value="older/newer" <?php selected( 'older/newer', esplanade_get_option( 'posts_nav_labels' ) ); ?>><?php _e( 'Older Posts', 'esplanade' ); ?> / <?php _e( 'Newer Posts', 'esplanade' ); ?></option>
		<option value="earlier/later" <?php selected( 'earlier/later', esplanade_get_option( 'posts_nav_labels' ) ); ?>><?php _e( 'Earlier Posts', 'esplanade' ); ?> / <?php _e( 'Later Posts', 'esplanade' ); ?></option>
		<option value="numbered" <?php selected( 'numbered', esplanade_get_option( 'posts_nav_labels' ) ); ?>><?php _e( 'Numbered Pagination', 'esplanade' ); ?></option>
	</select>
<?php
}

function esplanade_home_page_options() {
	add_settings_field( 'esplanade_home_page_layout', __( 'Home Page Layout', 'esplanade' ), 'esplanade_home_page_layout', 'esplanade_options', 'esplanade_home_page_options' );
	add_settings_field( 'esplanade_home_page_excerpts', __( 'Full posts to display', 'esplanade' ), 'esplanade_home_page_excerpts', 'esplanade_options', 'esplanade_home_page_options' );
	add_settings_field( 'esplanade_home_page_slider', __( 'Sticky Posts Slider', 'esplanade' ), 'esplanade_home_page_slider', 'esplanade_options', 'esplanade_home_page_options' );
}

function esplanade_home_page_layout() { ?>
	<label class="description">
		<input name="esplanade_theme_options[home_page_layout]" type="radio" <?php checked( 'grid', esplanade_get_option( 'home_page_layout' ) ); ?> value="grid" />
		<span><?php _e( 'Grid Layout', 'esplanade' ); ?></span>
	</label><br />
	<label class="description">
		<input name="esplanade_theme_options[home_page_layout]" type="radio" <?php checked( 'blog', esplanade_get_option( 'home_page_layout' ) ); ?> value="blog" />
		<span><?php _e( 'Blog Layout', 'esplanade' ); ?></span>
	</label>
<?php
}

function esplanade_home_page_excerpts() { ?>
	<label class="description">
		<input name="esplanade_theme_options[home_page_excerpts]" type="text" value="<?php echo esplanade_get_option( 'home_page_excerpts' ); ?>" size="2" maxlength="2" />
		<span><?php _e( 'Full posts to display before grid (0 = display only teasers)', 'esplanade' ); ?></span>
	</label>
<?php
}

function esplanade_home_page_slider() { ?>
	<label class="description">
		<input name="esplanade_theme_options[slider]" type="checkbox" value="<?php echo esplanade_get_option( 'slider' ); ?>" <?php checked( esplanade_get_option( 'slider' ) ); ?> />
		<span><?php _e( 'Display a slider of sticky posts on the front page', 'esplanade' ); ?></span>
	</label>
<?php
}

function esplanade_archive_page_options() {
	add_settings_field( 'esplanade_archive_location', 'Archive Page Location', 'esplanade_archive_location', 'esplanade_options', 'esplanade_archive_page_options' );
}

function esplanade_archive_location() { ?>
	<label class="description">
		<input name="esplanade_theme_options[location]" type="checkbox" value="<?php echo esplanade_get_option( 'location' ); ?>" <?php checked( esplanade_get_option( 'location' ) ); ?> />
		<span><?php _e( 'Show current location in archive pages', 'esplanade' ); ?></span>
	</label>
<?php
}

function esplanade_single_options() {
	add_settings_field( 'esplanade_show_post_nav', __( 'Inner Post Navigation', 'esplanade' ), 'esplanade_show_post_nav', 'esplanade_options', 'esplanade_single_options' );
	add_settings_field( 'esplanade_show_social_bookmarks', __( 'Social Bookmarks', 'esplanade' ), 'esplanade_show_social_bookmarks', 'esplanade_options', 'esplanade_single_options' );
	add_settings_field( 'esplanade_show_author_box', __( 'Author Box', 'esplanade' ), 'esplanade_show_author_box', 'esplanade_options', 'esplanade_single_options' );
}

function esplanade_show_post_nav() { ?>
	<label class="description">
		<input name="esplanade_theme_options[post_nav]" type="checkbox" value="<?php echo esplanade_get_option( 'post_nav' ); ?>" <?php checked( esplanade_get_option( 'post_nav' ) ); ?> />
		<span><?php _e( 'Show link to next and previous post', 'esplanade' ); ?></span>
	</label>
<?php
}

function esplanade_show_social_bookmarks() { ?>
	<label class="description">
		<input name="esplanade_theme_options[facebook]" type="checkbox" value="<?php echo esplanade_get_option( 'facebook' ); ?>" <?php checked( esplanade_get_option( 'facebook' ) ); ?> />
		<span><?php _e( 'Facebook Like', 'esplanade' ); ?></span>
	</label><br />
	<label class="description">
		<input name="esplanade_theme_options[twitter]" type="checkbox" value="<?php echo esplanade_get_option( 'twitter' ); ?>" <?php checked( esplanade_get_option( 'twitter' ) ); ?> />
		<span><?php _e( 'Twitter Button', 'esplanade' ); ?></span>
	</label><br />
	<label class="description">
		<input name="esplanade_theme_options[google]" type="checkbox" value="<?php echo esplanade_get_option( 'google' ); ?>" <?php checked( esplanade_get_option( 'google' ) ); ?> />
		<span><?php _e( 'Google +1', 'esplanade' ); ?></span>
	</label><br />
	<label class="description">
		<input name="esplanade_theme_options[pinterest]" type="checkbox" value="<?php echo esplanade_get_option( 'pinterest' ); ?>" <?php checked( esplanade_get_option( 'pinterest' ) ); ?> />
		<span><?php _e( 'Pinterest', 'esplanade' ); ?></span>
	</label>
<?php
}

function esplanade_show_author_box() { ?>
	<label class="description">
		<input name="esplanade_theme_options[author_box]" type="checkbox" value="<?php echo esplanade_get_option( 'author_box' ); ?>" <?php checked( esplanade_get_option( 'author_box' ) ); ?> />
		<span><?php _e( 'Display a hcard microformatted box featuring author name, avatar and bio', 'esplanade' ); ?></span>
	</label>
<?php
}

function esplanade_footer_options() {
	add_settings_field( 'esplanade_copyright_notice', __( 'Copyright Notice', 'esplanade' ), 'esplanade_copyright_notice', 'esplanade_options', 'esplanade_footer_options' );
	add_settings_field( 'esplanade_credit_links', __( 'Credit Links', 'esplanade' ), 'esplanade_credit_links', 'esplanade_options', 'esplanade_footer_options' );
}

function esplanade_copyright_notice() { ?>
	<label class="description">
		<input name="esplanade_theme_options[copyright_notice]" type="text" value="<?php echo esplanade_get_option( 'copyright_notice' ); ?>" />
		<span><?php _e( 'Text to display in the footer copyright section (%year% = current year, %blogname% = website name)', 'esplanade' ); ?></span>
	</label>
<?php
}

function esplanade_credit_links() { ?>
	<label class="description">
		<input name="esplanade_theme_options[theme_credit_link]" type="checkbox" value="<?php echo esplanade_get_option( 'theme_credit_link' ); ?>" <?php checked( esplanade_get_option( 'theme_credit_link' ) ); ?> />
		<span><?php _e( 'Show theme credit link', 'esplanade' ); ?></span>
	</label><br />
	<label class="description">
		<input name="esplanade_theme_options[author_credit_link]" type="checkbox" value="<?php echo esplanade_get_option( 'author_credit_link' ); ?>" <?php checked( esplanade_get_option( 'author_credit_link' ) ); ?> />
		<span><?php _e( 'Show author credit link', 'esplanade' ); ?></span>
	</label><br />
	<label class="description">
		<input name="esplanade_theme_options[wordpress_credit_link]" type="checkbox" value="<?php echo esplanade_get_option( 'wordpress_credit_link' ); ?>" <?php checked( esplanade_get_option( 'wordpress_credit_link' ) ); ?> />
		<span><?php _e( 'Show WordPress credit link', 'esplanade' ); ?></span>
	</label>
<?php
}

function esplanade_design_settings_sections() {
	add_settings_section( 'esplanade_theme_colors', __( 'Color Scheme', 'esplanade' ), 'esplanade_theme_colors', 'esplanade_options' );
	add_settings_section( 'esplanade_custom_css', __( 'Custom CSS', 'esplanade' ), 'esplanade_custom_css', 'esplanade_options' );
}

function esplanade_theme_colors() {
	add_settings_field( 'esplanade_color_scheme', __( 'Choose your color scheme', 'esplanade' ), 'esplanade_color_scheme', 'esplanade_options', 'esplanade_theme_colors' );
}

function esplanade_custom_css() {
	add_settings_field( 'esplanade_user_css', __( 'Enter your custom CSS', 'esplanade' ), 'esplanade_user_css', 'esplanade_options', 'esplanade_custom_css' );
}

function esplanade_color_scheme() {
	$current_color_scheme = esplanade_get_option( 'color_scheme' );
	$color_schemes = array(
		'neutral' => array(
			'name' => 'Neutral',
			'image' => 'neutral.png'
		),
		'sand' => array(
			'name' => 'Sand',
			'image' => 'sand.png'
		),
		'nature' => array(
			'name' => 'Nature',
			'image' => 'nature.png'
		),
		'earth' => array(
			'name' => 'Earth',
			'image' => 'earth.png'
		),
	); ?>
	<script>
		jQuery(document).ready(function($) {
			var label_id = '';
			$('.color-scheme').each(function(){
				if($(this).attr('checked')=='checked')
					label_id = '#label-'+$(this).attr('id');
			});
			if('' != label_id)
				$(label_id).addClass('checked');
			$('.color-scheme-label').click(function() {
				$('.color-scheme-label').removeClass('checked');
				$(this).addClass('checked');
			});
		});
	</script>
	<?php foreach( $color_schemes as $color_scheme => $data ) : ?>
		<label for="<?php echo $color_scheme; ?>" class="color-scheme-label" id="label-<?php echo $color_scheme; ?>"><img src="<?php echo get_template_directory_uri() . '/images/' . $data['image']; ?>" alt="<?php echo $data['name']; ?>" title="<?php echo $data['name']; ?>" />
		<input name="esplanade_theme_options[color_scheme]" class="color-scheme" id="<?php echo $color_scheme; ?>" value="<?php echo $color_scheme; ?>" type="radio" <?php checked( $color_scheme, $current_color_scheme ); ?> /></label>
	<?php endforeach;
}

function esplanade_user_css() { ?>
	<textarea name="esplanade_theme_options[user_css]" cols="70" rows="15" style="width:97%;font-family:monospace;background:#f9f9f9"><?php echo esplanade_get_option( 'user_css' ); ?></textarea>
<?php
}

function esplanade_layout_settings_sections() {
	add_settings_section( 'esplanade_layout', __( 'Default Layout Template', 'esplanade' ), 'esplanade_layout', 'esplanade_options' );
	add_settings_section( 'esplanade_layout_dimensions', __( 'Layout Dimensions', 'esplanade' ), 'esplanade_layout_dimensions', 'esplanade_options' );
}

function esplanade_layout() {
	add_settings_field( 'esplanade_layout_template', __( 'Choose your preferred Layout', 'esplanade' ), 'esplanade_layout_template', 'esplanade_options', 'esplanade_layout' );
}

function esplanade_layout_dimensions() {
	add_settings_field( 'esplanade_dimensions', __( 'Select Layout Dimensions', 'esplanade' ), 'esplanade_dimensions', 'esplanade_options', 'esplanade_layout_dimensions' );
	add_settings_field( 'esplanade_header_image_height', __( 'Header Image Height', 'esplanade' ), 'esplanade_header_image_height', 'esplanade_options', 'esplanade_layout_dimensions' );
}

function esplanade_layout_template() {
	$current_layout = esplanade_get_option( 'layout' );
	$layouts = array(
		'content-sidebar' => array(
			'name' => 'Content / Sidebar',
			'image' => 'content-sidebar.png'
		),
		'sidebar-content' => array(
			'name' => 'Sidebar / Content',
			'image' => 'sidebar-content.png'
		),
		'sidebar-content-sidebar' => array(
			'name' => 'Sidebar / Content / Sidebar',
			'image' => 'sidebar-content-sidebar.png'
		),
		'no-sidebars' => array(
			'name' => 'No Sidebars',
			'image' => 'no-sidebars.png'
		),
		'full-width' => array(
			'name' => 'Full Width',
			'image' => 'full-width.png'
		),
	); ?>
	<script>
		jQuery(document).ready(function($) {
			var label_id = '';
			$('.layout').each(function(){
				if($(this).attr('checked')=='checked')
					label_id = '#label-'+$(this).attr('id');
			});
			if('' != label_id)
				$(label_id).addClass('checked');
			$('.layout-label').click(function() {
				$('.layout-label').removeClass('checked');
				$(this).addClass('checked');
			});
		});
	</script>
	<?php foreach( $layouts as $layout => $data ) : ?>
		<label for="<?php echo $layout; ?>" class="layout-label" id="label-<?php echo $layout; ?>"><img src="<?php echo get_template_directory_uri() . '/images/' . $data['image']; ?>" alt="<?php echo $data['name']; ?>" title="<?php echo $data['name']; ?>" />
		<input name="esplanade_theme_options[layout]" class="layout" id="<?php echo $layout; ?>" value="<?php echo $layout; ?>" type="radio" <?php checked( $layout, $current_layout ); ?> /></label>
	<?php endforeach;
}

function esplanade_dimensions() {
	$default_options = esplanade_default_options();
	$current_layout = esplanade_get_option( 'layout' );
	$sidebar_right_size = $sidebar_left_size = esplanade_get_option( 'sidebar_size' );
	if( 'sidebar-content-sidebar' == $current_layout ) {
		$sidebar_right_size = esplanade_get_option( 'sidebar_right_size' );
		$sidebar_left_size = esplanade_get_option( 'sidebar_left_size' );
	}?>
	<script>
		jQuery(document).ready(function ($) {
			var layout = $('#site').layout({
				applyDefaultStyles: true,
				onresize: function() {
					var state = layout.state;
					var northCurrentSize = state.north.size;
					$('.ui-layout-north').html(northCurrentSize+'px');
					$('#header_height').val(northCurrentSize);
					var centerCurrentSize = 100;
					<?php if( ( 'content-sidebar' == $current_layout ) || ( 'sidebar-content-sidebar' == $current_layout ) ) : ?>
						var eastCurrentSize = state.east.size + 5.7;
						centerCurrentSize = centerCurrentSize - 2.77 - ( eastCurrentSize * 100 / 640 ).toFixed(2);
						$('.ui-layout-east').html(( eastCurrentSize * 100 / 640 ).toFixed(2)+'%');
						$('#sidebar_<?php if( 'sidebar-content-sidebar' == $current_layout ) : ?>right_<?php endif; ?>size').val('"'+( eastCurrentSize * 100 / 640 ).toFixed(2)+'%'+'"');
					<?php endif; ?>
					<?php if( ( 'sidebar-content' == $current_layout ) || ( 'sidebar-content-sidebar' == $current_layout ) ) : ?>
						var westCurrentSize = state.west.size + 5.7;
						centerCurrentSize = centerCurrentSize - 2.77 - ( westCurrentSize * 100 / 640 ).toFixed(2);
						$('.ui-layout-west').html(( westCurrentSize * 100 / 640 ).toFixed(2)+'%');
						$('#sidebar_<?php if( 'sidebar-content-sidebar' == $current_layout ) : ?>left_<?php endif; ?>size').val('"'+( westCurrentSize * 100 / 640 ).toFixed(2)+'%'+'"');
					<?php endif; ?>
					$('.ui-layout-center').html(centerCurrentSize.toFixed(2)+'%');
				}
			});
			var state = layout.state;
			layout.sizePane("north", <?php echo esplanade_get_option( 'header_height' ); ?>);
			var northCurrentSize = state.north.size;
			$('.ui-layout-north').html(northCurrentSize+'px');
			var centerCurrentSize = 100;
			<?php if( ( 'content-sidebar' == $current_layout ) || ( 'sidebar-content-sidebar' == $current_layout ) ) : ?>
				layout.sizePane("east", <?php echo $sidebar_right_size; ?>);
				var eastCurrentSize = state.east.size + 5.7;
				var centerCurrentSize = centerCurrentSize - 2.77 - ( eastCurrentSize * 100 / 640 ).toFixed(2);
				$('.ui-layout-east').html(( eastCurrentSize * 100 / 640 ).toFixed(2)+'%');
			<?php endif; ?>
			<?php if( ( 'sidebar-content' == $current_layout ) || ( 'sidebar-content-sidebar' == $current_layout ) ) : ?>
				layout.sizePane("west", <?php echo $sidebar_left_size; ?>);
				var westCurrentSize = state.west.size + 5.7;
				var centerCurrentSize = centerCurrentSize - 2.77 - ( westCurrentSize * 100 / 640 ).toFixed(2);
				$('.ui-layout-west').html(( westCurrentSize * 100 / 640 ).toFixed(2)+'%');
			<?php endif; ?>
			$('.ui-layout-center').html(centerCurrentSize.toFixed(2)+'%');
		});
	</script>
	<div id="site">
		<div class="ui-layout-center">
		</div>
		<div class="ui-layout-north">North</div>
		<?php if( ( 'content-sidebar' == $current_layout ) || ( 'sidebar-content-sidebar' == $current_layout ) ) : ?>
			<div class="ui-layout-east">East</div>
		<?php endif; ?>
		<?php if( ( 'sidebar-content' == $current_layout ) || ( 'sidebar-content-sidebar' == $current_layout ) ) : ?>
			<div class="ui-layout-west">West</div>
		<?php endif; ?>
	</div>
	<input name="esplanade_theme_options[header_height]" id="header_height" value="<?php echo esplanade_get_option( 'header_height' ); ?>" type="hidden" />
	<input name="esplanade_theme_options[sidebar_size]" id="sidebar_size" value='<?php echo esplanade_get_option( 'sidebar_size' ); ?>' type="hidden" />
	<input name="esplanade_theme_options[sidebar_right_size]" id="sidebar_right_size" value='<?php echo esplanade_get_option( 'sidebar_right_size' ); ?>' type="hidden" />
	<input name="esplanade_theme_options[sidebar_left_size]" id="sidebar_left_size" value='<?php echo esplanade_get_option( 'sidebar_left_size' ); ?>' type="hidden" />
<?php
}

function esplanade_header_image_height() { ?>
	<input name="esplanade_theme_options[header_image_height]" type="text" value="<?php echo esplanade_get_option( 'header_image_height' ); ?>" size="4" /> <span class="description">px</span>
	<p class="description">Note that header image height has been deprecated in favor of flexible header images introduced with WordPress 3.4 and may be removed in a future version.</p>
<?php
}

function esplanade_typography_settings_sections() {
	add_settings_section( 'esplanade_fonts', __( 'Font Families', 'esplanade' ), 'esplanade_fonts', 'esplanade_options' );
	add_settings_section( 'esplanade_font_sizes', __( 'Font Sizes', 'esplanade' ), 'esplanade_font_sizes', 'esplanade_options' );
	add_settings_section( 'esplanade_colors', __( 'Colors', 'esplanade' ), 'esplanade_colors', 'esplanade_options' );
}

function esplanade_fonts() {
	add_settings_field( 'esplanade_body_font', __( 'Default Font Family', 'esplanade' ), 'esplanade_body_font', 'esplanade_options', 'esplanade_fonts' );
	add_settings_field( 'esplanade_headings_font', __( 'Headings Font Family', 'esplanade' ), 'esplanade_headings_font', 'esplanade_options', 'esplanade_fonts' );
	add_settings_field( 'esplanade_content_font', __( 'Body Copy Font Family', 'esplanade' ), 'esplanade_content_font', 'esplanade_options', 'esplanade_fonts' );
}

function esplanade_body_font() {
	$fonts = esplanade_available_fonts(); ?>
	<select name="esplanade_theme_options[body_font]">
		<?php foreach( $fonts as $name => $family ) : ?>
			<option value="<?php echo $name; ?>" <?php selected( $name, esplanade_get_option( 'body_font' ) ); ?>><?php echo str_replace( '"', '', $family ); ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function esplanade_headings_font() {
	$fonts = esplanade_available_fonts(); ?>
	<select name="esplanade_theme_options[headings_font]">
		<?php foreach( $fonts as $name => $family ) : ?>
			<option value="<?php echo $name; ?>" <?php selected( $name, esplanade_get_option( 'headings_font' ) ); ?>><?php echo str_replace( '"', '', $family ); ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function esplanade_content_font() {
	$fonts = esplanade_available_fonts(); ?>
	<select name="esplanade_theme_options[content_font]">
		<?php foreach( $fonts as $name => $family ) : ?>
			<option value="<?php echo $name; ?>" <?php selected( $name, esplanade_get_option( 'content_font' ) ); ?>><?php echo str_replace( '"', '', $family ); ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function esplanade_font_sizes() {
	add_settings_field( 'esplanade_body_font_size', __( 'Default Font Size', 'esplanade' ), 'esplanade_body_font_size', 'esplanade_options', 'esplanade_font_sizes' );
	add_settings_field( 'esplanade_body_line_height', __( 'Default Line Height', 'esplanade' ), 'esplanade_body_line_height', 'esplanade_options', 'esplanade_font_sizes' );
	add_settings_field( 'esplanade_h1_font_size', __( 'H1 Font Size', 'esplanade' ), 'esplanade_h1_font_size', 'esplanade_options', 'esplanade_font_sizes' );
	add_settings_field( 'esplanade_h2_font_size', __( 'H2 Font Size', 'esplanade' ), 'esplanade_h2_font_size', 'esplanade_options', 'esplanade_font_sizes' );
	add_settings_field( 'esplanade_h3_font_size', __( 'H3 Font Size', 'esplanade' ), 'esplanade_h3_font_size', 'esplanade_options', 'esplanade_font_sizes' );
	add_settings_field( 'esplanade_h4_font_size', __( 'H4 Font Size', 'esplanade' ), 'esplanade_h4_font_size', 'esplanade_options', 'esplanade_font_sizes' );
	add_settings_field( 'esplanade_headings_line_height', __( 'Headings Line Height', 'esplanade' ), 'esplanade_headings_line_height', 'esplanade_options', 'esplanade_font_sizes' );
	add_settings_field( 'esplanade_content_font_size', __( 'Body Copy Font Size', 'esplanade' ), 'esplanade_content_font_size', 'esplanade_options', 'esplanade_font_sizes' );
	add_settings_field( 'esplanade_content_line_height', __( 'Body Copy Line Height', 'esplanade' ), 'esplanade_content_line_height', 'esplanade_options', 'esplanade_font_sizes' );
	add_settings_field( 'esplanade_mobile_font_size', __( 'Body Copy Font Size on Mobile Devices', 'esplanade' ), 'esplanade_mobile_font_size', 'esplanade_options', 'esplanade_font_sizes' );
	add_settings_field( 'esplanade_mobile_line_height', __( 'Body Copy Line Height on Mobile Devices', 'esplanade' ), 'esplanade_mobile_line_height', 'esplanade_options', 'esplanade_font_sizes' );
}

function esplanade_body_font_size() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="esplanade_theme_options[body_font_size]" type="text" value="<?php echo esplanade_get_option( 'body_font_size' ); ?>" size="4" />
	<select name="esplanade_theme_options[body_font_size_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, esplanade_get_option( 'body_font_size_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function esplanade_body_line_height() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="esplanade_theme_options[body_line_height]" type="text" value="<?php echo esplanade_get_option( 'body_line_height' ); ?>" size="4" />
	<select name="esplanade_theme_options[body_line_height_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, esplanade_get_option( 'body_line_height_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function esplanade_h1_font_size() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="esplanade_theme_options[h1_font_size]" type="text" value="<?php echo esplanade_get_option( 'h1_font_size' ); ?>" size="4" />
	<select name="esplanade_theme_options[h1_font_size_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, esplanade_get_option( 'h1_font_size_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function esplanade_h2_font_size() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="esplanade_theme_options[h2_font_size]" type="text" value="<?php echo esplanade_get_option( 'h2_font_size' ); ?>" size="4" />
	<select name="esplanade_theme_options[h2_font_size_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, esplanade_get_option( 'h2_font_size_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function esplanade_h3_font_size() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="esplanade_theme_options[h3_font_size]" type="text" value="<?php echo esplanade_get_option( 'h3_font_size' ); ?>" size="4" />
	<select name="esplanade_theme_options[h3_font_size_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, esplanade_get_option( 'h3_font_size_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function esplanade_h4_font_size() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="esplanade_theme_options[h4_font_size]" type="text" value="<?php echo esplanade_get_option( 'h4_font_size' ); ?>" size="4" />
	<select name="esplanade_theme_options[h4_font_size_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, esplanade_get_option( 'h4_font_size_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function esplanade_headings_line_height() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="esplanade_theme_options[headings_line_height]" type="text" value="<?php echo esplanade_get_option( 'headings_line_height' ); ?>" size="4" />
	<select name="esplanade_theme_options[headings_line_height_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, esplanade_get_option( 'headings_line_height_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function esplanade_content_font_size() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="esplanade_theme_options[content_font_size]" type="text" value="<?php echo esplanade_get_option( 'content_font_size' ); ?>" size="4" />
	<select name="esplanade_theme_options[content_font_size_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, esplanade_get_option( 'content_font_size_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function esplanade_content_line_height() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="esplanade_theme_options[content_line_height]" type="text" value="<?php echo esplanade_get_option( 'content_line_height' ); ?>" size="4" />
	<select name="esplanade_theme_options[content_line_height_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, esplanade_get_option( 'content_line_height_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function esplanade_mobile_font_size() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="esplanade_theme_options[mobile_font_size]" type="text" value="<?php echo esplanade_get_option( 'mobile_font_size' ); ?>" size="4" />
	<select name="esplanade_theme_options[mobile_font_size_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, esplanade_get_option( 'mobile_font_size_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function esplanade_mobile_line_height() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="esplanade_theme_options[mobile_line_height]" type="text" value="<?php echo esplanade_get_option( 'mobile_line_height' ); ?>" size="4" />
	<select name="esplanade_theme_options[mobile_line_height_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, esplanade_get_option( 'mobile_line_height_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function esplanade_colors() {
	add_settings_field( 'esplanade_body_color', __( 'Default Font Color', 'esplanade' ), 'esplanade_body_color', 'esplanade_options', 'esplanade_colors' );
	add_settings_field( 'esplanade_headings_color', __( 'Headings Font Color', 'esplanade' ), 'esplanade_headings_color', 'esplanade_options', 'esplanade_colors' );
	add_settings_field( 'esplanade_content_color', __( 'Body Copy Font Color', 'esplanade' ), 'esplanade_content_color', 'esplanade_options', 'esplanade_colors' );
	add_settings_field( 'esplanade_links_color', __( 'Links Color', 'esplanade' ), 'esplanade_links_color', 'esplanade_options', 'esplanade_colors' );
	add_settings_field( 'esplanade_links_hover_color', __( 'Links Hover Color', 'esplanade' ), 'esplanade_links_hover_color', 'esplanade_options', 'esplanade_colors' );
	add_settings_field( 'esplanade_menu_color', __( 'Navigation Links Color', 'esplanade' ), 'esplanade_menu_color', 'esplanade_options', 'esplanade_colors' );
	add_settings_field( 'esplanade_menu_hover_color', __( 'Navigation Links Hover Color', 'esplanade' ), 'esplanade_menu_hover_color', 'esplanade_options', 'esplanade_colors' );
	add_settings_field( 'esplanade_sidebar_color', __( 'Sidebar Widgets Color', 'esplanade' ), 'esplanade_sidebar_color', 'esplanade_options', 'esplanade_colors' );
	add_settings_field( 'esplanade_sidebar_title_color', __( 'Sidebar Widgets Title Color', 'esplanade' ), 'esplanade_sidebar_title_color', 'esplanade_options', 'esplanade_colors' );
	add_settings_field( 'esplanade_sidebar_links_color', __( 'Widgets Links Color', 'esplanade' ), 'esplanade_sidebar_links_color', 'esplanade_options', 'esplanade_colors' );
	add_settings_field( 'esplanade_footer_color', __( 'Footer Widgets Color', 'esplanade' ), 'esplanade_footer_color', 'esplanade_options', 'esplanade_colors' );
	add_settings_field( 'esplanade_footer_title_color', __( 'Footer Widgets Title Color', 'esplanade' ), 'esplanade_footer_title_color', 'esplanade_options', 'esplanade_colors' );
	add_settings_field( 'esplanade_copyright_color', __( 'Footer Color', 'esplanade' ), 'esplanade_copyright_color', 'esplanade_options', 'esplanade_colors' );
	add_settings_field( 'esplanade_copyright_links_color', __( 'Footer Links Color', 'esplanade' ), 'esplanade_copyright_links_color', 'esplanade_options', 'esplanade_colors' );
}

function esplanade_body_color() { ?>
	<div style="position:relative;">
		<input name="esplanade_theme_options[body_color]" type="text" id="body_color" value="<?php echo esplanade_get_option( 'body_color' ); ?>" style="color:#fff" />
		<div id="color_picker_body_color" style="display:none; position:absolute; top:-85px; left:172px;"></div>
	</div>
	<script>
		function bodypickerUpdate(color) {
			jQuery('#body_color').css("background-color", color);
			jQuery('#body_color').val(color);
		}
		jQuery(document).ready(function($) {
			$('#body_color').focus(function() {
				$('#color_picker_body_color').show();
			});
			$('#body_color').blur(function() {
				$('#color_picker_body_color').hide();
			});
			var body_color = $.farbtastic('#color_picker_body_color', bodypickerUpdate);	
			body_color.setColor('<?php echo esplanade_get_option( 'body_color' ); ?>');
			body_color.linkTo(bodypickerUpdate);         
		});
	</script>
<?php
}

function esplanade_headings_color() { ?>
	<div style="position:relative;">
		<input name="esplanade_theme_options[headings_color]" type="text" id="headings_color" value="<?php echo esplanade_get_option( 'headings_color' ); ?>" style="color:#fff" />
		<div id="color_picker_headings_color" style="display:none; position:absolute; top:-85px; left:172px;"></div>
	</div>
	<script>
		function headingspickerUpdate(color) {
			jQuery('#headings_color').css("background-color", color);
			jQuery('#headings_color').val(color);
		}
		jQuery(document).ready(function($) {
			$('#headings_color').focus(function() {
				$('#color_picker_headings_color').show();
			});
			$('#headings_color').blur(function() {
				$('#color_picker_headings_color').hide();
			});
			var headings_color = $.farbtastic('#color_picker_headings_color', headingspickerUpdate);	
			headings_color.setColor('<?php echo esplanade_get_option( 'headings_color' ); ?>');
			headings_color.linkTo(headingspickerUpdate);         
		});
	</script>
<?php
}

function esplanade_content_color() { ?>
	<div style="position:relative;">
		<input name="esplanade_theme_options[content_color]" type="text" id="content_color" value="<?php echo esplanade_get_option( 'content_color' ); ?>" style="color:#fff" />
		<div id="color_picker_content_color" style="display:none; position:absolute; top:-85px; left:172px;"></div>
	</div>
	<script>
		function contentpickerUpdate(color) {
			jQuery('#content_color').css("background-color", color);
			jQuery('#content_color').val(color);
		}
		jQuery(document).ready(function($) {
			$('#content_color').focus(function() {
				$('#color_picker_content_color').show();
			});
			$('#content_color').blur(function() {
				$('#color_picker_content_color').hide();
			});
			var content_color = $.farbtastic('#color_picker_content_color', contentpickerUpdate);	
			content_color.setColor('<?php echo esplanade_get_option( 'content_color' ); ?>');
			content_color.linkTo(contentpickerUpdate);         
		});
	</script>
<?php
}

function esplanade_links_color() { ?>
	<div style="position:relative;">
		<input name="esplanade_theme_options[links_color]" type="text" id="links_color" value="<?php echo esplanade_get_option( 'links_color' ); ?>" style="color:#fff" />
		<div id="color_picker_links_color" style="display:none; position:absolute; top:-85px; left:172px;"></div>
	</div>
	<script>
		function linkspickerUpdate(color) {
			jQuery('#links_color').css("background-color", color);
			jQuery('#links_color').val(color);
		}
		jQuery(document).ready(function($) {
			$('#links_color').focus(function() {
				$('#color_picker_links_color').show();
			});
			$('#links_color').blur(function() {
				$('#color_picker_links_color').hide();
			});
			var links_color = $.farbtastic('#color_picker_links_color', linkspickerUpdate);	
			links_color.setColor('<?php echo esplanade_get_option( 'links_color' ); ?>');
			links_color.linkTo(linkspickerUpdate);         
		});
	</script>
<?php
}

function esplanade_links_hover_color() { ?>
	<div style="position:relative;">
		<input name="esplanade_theme_options[links_hover_color]" type="text" id="links_hover_color" value="<?php echo esplanade_get_option( 'links_hover_color' ); ?>" style="color:#fff" />
		<div id="color_picker_links_hover_color" style="display:none; position:absolute; top:-85px; left:172px;"></div>
	</div>
	<script>
		function hoverpickerUpdate(color) {
			jQuery('#links_hover_color').css("background-color", color);
			jQuery('#links_hover_color').val(color);
		}
		jQuery(document).ready(function($) {
			$('#links_hover_color').focus(function() {
				$('#color_picker_links_hover_color').show();
			});
			$('#links_hover_color').blur(function() {
				$('#color_picker_links_hover_color').hide();
			});
			var links_hover_color = $.farbtastic('#color_picker_links_hover_color', hoverpickerUpdate);	
			links_hover_color.setColor('<?php echo esplanade_get_option( 'links_hover_color' ); ?>');
			links_hover_color.linkTo(hoverpickerUpdate);         
		});
	</script>
<?php
}

function esplanade_menu_color() { ?>
	<div style="position:relative;">
		<input name="esplanade_theme_options[menu_color]" type="text" id="menu_color" value="<?php echo esplanade_get_option( 'menu_color' ); ?>" />
		<div id="color_picker_menu_color" style="display:none; position:absolute; top:-85px; left:172px;"></div>
	</div>
	<script>
		function menupickerUpdate(color) {
			jQuery('#menu_color').css("background-color", color);
			jQuery('#menu_color').val(color);
		}
		jQuery(document).ready(function($) {
			$('#menu_color').focus(function() {
				$('#color_picker_menu_color').show();
			});
			$('#menu_color').blur(function() {
				$('#color_picker_menu_color').hide();
			});
			var menu_color = $.farbtastic('#color_picker_menu_color', menupickerUpdate);	
			menu_color.setColor('<?php echo esplanade_get_option( 'menu_color' ); ?>');
			menu_color.linkTo(menupickerUpdate);         
		});
	</script>
<?php
}

function esplanade_menu_hover_color() { ?>
	<div style="position:relative;">
		<input name="esplanade_theme_options[menu_hover_color]" type="text" id="menu_hover_color" value="<?php echo esplanade_get_option( 'menu_hover_color' ); ?>" />
		<div id="color_picker_menu_hover_color" style="display:none; position:absolute; top:-85px; left:172px;"></div>
	</div>
	<script>
		function menuhpickerUpdate(color) {
			jQuery('#menu_hover_color').css("background-color", color);
			jQuery('#menu_hover_color').val(color);
		}
		jQuery(document).ready(function($) {
			$('#menu_hover_color').focus(function() {
				$('#color_picker_menu_hover_color').show();
			});
			$('#menu_hover_color').blur(function() {
				$('#color_picker_menu_hover_color').hide();
			});
			var menu_hover_color = $.farbtastic('#color_picker_menu_hover_color', menuhpickerUpdate);	
			menu_hover_color.setColor('<?php echo esplanade_get_option( 'menu_hover_color' ); ?>');
			menu_hover_color.linkTo(menuhpickerUpdate);         
		});
	</script>
<?php
}

function esplanade_sidebar_color() { ?>
	<div style="position:relative;">
		<input name="esplanade_theme_options[sidebar_color]" type="text" id="sidebar_color" value="<?php echo esplanade_get_option( 'sidebar_color' ); ?>" style="color:#fff" />
		<div id="color_picker_sidebar_color" style="display:none; position:absolute; top:-85px; left:172px;"></div>
	</div>
	<script>
		function sidebarpickerUpdate(color) {
			jQuery('#sidebar_color').css("background-color", color);
			jQuery('#sidebar_color').val(color);
		}
		jQuery(document).ready(function($) {
			$('#sidebar_color').focus(function() {
				$('#color_picker_sidebar_color').show();
			});
			$('#sidebar_color').blur(function() {
				$('#color_picker_sidebar_color').hide();
			});
			var sidebar_color = $.farbtastic('#color_picker_sidebar_color', sidebarpickerUpdate);	
			sidebar_color.setColor('<?php echo esplanade_get_option( 'sidebar_color' ); ?>');
			sidebar_color.linkTo(sidebarpickerUpdate);         
		});
	</script>
<?php
}

function esplanade_sidebar_title_color() { ?>
	<div style="position:relative;">
		<input name="esplanade_theme_options[sidebar_title_color]" type="text" id="sidebar_title_color" value="<?php echo esplanade_get_option( 'sidebar_title_color' ); ?>" style="color:#fff" />
		<div id="color_picker_sidebar_title_color" style="display:none; position:absolute; top:-85px; left:172px;"></div>
	</div>
	<script>
		function sidebartitlepickerUpdate(color) {
			jQuery('#sidebar_title_color').css("background-color", color);
			jQuery('#sidebar_title_color').val(color);
		}
		jQuery(document).ready(function($) {
			$('#sidebar_title_color').focus(function() {
				$('#color_picker_sidebar_title_color').show();
			});
			$('#sidebar_title_color').blur(function() {
				$('#color_picker_sidebar_title_color').hide();
			});
			var sidebar_title_color = $.farbtastic('#color_picker_sidebar_title_color', sidebartitlepickerUpdate);	
			sidebar_title_color.setColor('<?php echo esplanade_get_option( 'sidebar_title_color' ); ?>');
			sidebar_title_color.linkTo(sidebartitlepickerUpdate);         
		});
	</script>
<?php
}

function esplanade_sidebar_links_color() { ?>
	<div style="position:relative;">
		<input name="esplanade_theme_options[sidebar_links_color]" type="text" id="sidebar_links_color" value="<?php echo esplanade_get_option( 'sidebar_links_color' ); ?>" style="color:#fff" />
		<div id="color_picker_sidebar_links_color" style="display:none; position:absolute; top:-85px; left:172px;"></div>
	</div>
	<script>
		function sidebar_linkspickerUpdate(color) {
			jQuery('#sidebar_links_color').css("background-color", color);
			jQuery('#sidebar_links_color').val(color);
		}
		jQuery(document).ready(function($) {
			$('#sidebar_links_color').focus(function() {
				$('#color_picker_sidebar_links_color').show();
			});
			$('#sidebar_links_color').blur(function() {
				$('#color_picker_sidebar_links_color').hide();
			});
			var sidebar_links_color = $.farbtastic('#color_picker_sidebar_links_color', sidebar_linkspickerUpdate);	
			sidebar_links_color.setColor('<?php echo esplanade_get_option( 'sidebar_links_color' ); ?>');
			sidebar_links_color.linkTo(sidebar_linkspickerUpdate);         
		});
	</script>
<?php
}

function esplanade_footer_color() { ?>
	<div style="position:relative;">
		<input name="esplanade_theme_options[footer_color]" type="text" id="footer_color" value="<?php echo esplanade_get_option( 'footer_color' ); ?>" />
		<div id="color_picker_footer_color" style="display:none; position:absolute; top:-85px; left:172px;"></div>
	</div>
	<script>
		function footerpickerUpdate(color) {
			jQuery('#footer_color').css("background-color", color);
			jQuery('#footer_color').val(color);
		}
		jQuery(document).ready(function($) {
			$('#footer_color').focus(function() {
				$('#color_picker_footer_color').show();
			});
			$('#footer_color').blur(function() {
				$('#color_picker_footer_color').hide();
			});
			var footer_color = $.farbtastic('#color_picker_footer_color', footerpickerUpdate);	
			footer_color.setColor('<?php echo esplanade_get_option( 'footer_color' ); ?>');
			footer_color.linkTo(footerpickerUpdate);         
		});
	</script>
<?php
}

function esplanade_footer_title_color() { ?>
	<div style="position:relative;">
		<input name="esplanade_theme_options[footer_title_color]" type="text" id="footer_title_color" value="<?php echo esplanade_get_option( 'footer_title_color' ); ?>" />
		<div id="color_picker_footer_title_color" style="display:none; position:absolute; top:-85px; left:172px;"></div>
	</div>
	<script>
		function footertitlepickerUpdate(color) {
			jQuery('#footer_title_color').css("background-color", color);
			jQuery('#footer_title_color').val(color);
		}
		jQuery(document).ready(function($) {
			$('#footer_title_color').focus(function() {
				$('#color_picker_footer_title_color').show();
			});
			$('#footer_title_color').blur(function() {
				$('#color_picker_footer_title_color').hide();
			});
			var footer_title_color = $.farbtastic('#color_picker_footer_title_color', footertitlepickerUpdate);	
			footer_title_color.setColor('<?php echo esplanade_get_option( 'footer_title_color' ); ?>');
			footer_title_color.linkTo(footertitlepickerUpdate);         
		});
	</script>
<?php
}

function esplanade_copyright_color() { ?>
	<div style="position:relative;">
		<input name="esplanade_theme_options[copyright_color]" type="text" id="copyright_color" value="<?php echo esplanade_get_option( 'copyright_color' ); ?>" style="color:#fff" />
		<div id="color_picker_copyright_color" style="display:none; position:absolute; top:-85px; left:172px;"></div>
	</div>
	<script>
		function copyrightpickerUpdate(color) {
			jQuery('#copyright_color').css("background-color", color);
			jQuery('#copyright_color').val(color);
		}
		jQuery(document).ready(function($) {
			$('#copyright_color').focus(function() {
				$('#color_picker_copyright_color').show();
			});
			$('#copyright_color').blur(function() {
				$('#color_picker_copyright_color').hide();
			});
			var copyright_color = $.farbtastic('#color_picker_copyright_color', copyrightpickerUpdate);	
			copyright_color.setColor('<?php echo esplanade_get_option( 'copyright_color' ); ?>');
			copyright_color.linkTo(copyrightpickerUpdate);         
		});
	</script>
<?php
}

function esplanade_copyright_links_color() { ?>
	<div style="position:relative;">
		<input name="esplanade_theme_options[copyright_links_color]" type="text" id="copyright_links_color" value="<?php echo esplanade_get_option( 'copyright_links_color' ); ?>" style="color:#fff" />
		<div id="color_picker_copyright_links_color" style="display:none; position:absolute; top:-85px; left:172px;"></div>
	</div>
	<script>
		function copyrightlpickerUpdate(color) {
			jQuery('#copyright_links_color').css("background-color", color);
			jQuery('#copyright_links_color').val(color);
		}
		jQuery(document).ready(function($) {
			$('#copyright_links_color').focus(function() {
				$('#color_picker_copyright_links_color').show();
			});
			$('#copyright_links_color').blur(function() {
				$('#color_picker_copyright_links_color').hide();
			});
			var copyright_links_color = $.farbtastic('#color_picker_copyright_links_color', copyrightlpickerUpdate);	
			copyright_links_color.setColor('<?php echo esplanade_get_option( 'copyright_links_color' ); ?>');
			copyright_links_color.linkTo(copyrightlpickerUpdate);         
		});
	</script>
<?php
}
function esplanade_seo_settings_sections() {
	add_settings_section( 'esplanade_home_tags', __( 'Home Page', 'esplanade' ), 'esplanade_home_tags', 'esplanade_options' );
	add_settings_section( 'esplanade_archive_tags', __( 'Archive Pages', 'esplanade' ), 'esplanade_archive_tags', 'esplanade_options' );
	add_settings_section( 'esplanade_single_tags', __( 'Single Posts &amp; Pages', 'esplanade' ), 'esplanade_single_tags', 'esplanade_options' );
	add_settings_section( 'esplanade_other_tags', __( 'Other', 'esplanade' ), 'esplanade_other_tags', 'esplanade_options' );
}

function esplanade_home_tags() {
	add_settings_field( 'esplanade_home_site_title_tag', __( 'Site Title Tag', 'esplanade' ), 'esplanade_home_site_title_tag', 'esplanade_options', 'esplanade_home_tags' );
	add_settings_field( 'esplanade_home_site_desc_tag', __( 'Site Description Tag', 'esplanade' ), 'esplanade_home_site_desc_tag', 'esplanade_options', 'esplanade_home_tags' );
	add_settings_field( 'esplanade_home_post_title_tag', __( 'Post Title Tag', 'esplanade' ), 'esplanade_home_post_title_tag', 'esplanade_options', 'esplanade_home_tags' );
}

function esplanade_home_site_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="esplanade_theme_options[home_site_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, esplanade_get_option( 'home_site_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function esplanade_home_site_desc_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="esplanade_theme_options[home_desc_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, esplanade_get_option( 'home_desc_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function esplanade_home_post_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="esplanade_theme_options[home_post_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, esplanade_get_option( 'home_post_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function esplanade_archive_tags() {
	add_settings_field( 'esplanade_archive_site_title_tag', __( 'Site Title Tag', 'esplanade' ), 'esplanade_archive_site_title_tag', 'esplanade_options', 'esplanade_archive_tags' );
	add_settings_field( 'esplanade_archive_site_desc_tag', __( 'Site Description Tag', 'esplanade' ), 'esplanade_archive_site_desc_tag', 'esplanade_options', 'esplanade_archive_tags' );
	add_settings_field( 'esplanade_archive_location_title_tag', __( 'Site Location Title Tag', 'esplanade' ), 'esplanade_archive_location_title_tag', 'esplanade_options', 'esplanade_archive_tags' );
	add_settings_field( 'esplanade_archive_post_title_tag', __( 'Post Title Tag', 'esplanade' ), 'esplanade_archive_post_title_tag', 'esplanade_options', 'esplanade_archive_tags' );
}

function esplanade_archive_site_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="esplanade_theme_options[archive_site_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, esplanade_get_option( 'archive_site_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function esplanade_archive_site_desc_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="esplanade_theme_options[archive_desc_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, esplanade_get_option( 'archive_desc_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function esplanade_archive_location_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="esplanade_theme_options[archive_location_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, esplanade_get_option( 'archive_location_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function esplanade_archive_post_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="esplanade_theme_options[archive_post_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, esplanade_get_option( 'archive_post_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function esplanade_single_tags() {
	add_settings_field( 'esplanade_single_site_title_tag', __( 'Site Title Tag', 'esplanade' ), 'esplanade_single_site_title_tag', 'esplanade_options', 'esplanade_single_tags' );
	add_settings_field( 'esplanade_single_site_desc_tag', __( 'Site Description Tag', 'esplanade' ), 'esplanade_single_site_desc_tag', 'esplanade_options', 'esplanade_single_tags' );
	add_settings_field( 'esplanade_single_post_title_tag', __( 'Post Title Tag', 'esplanade' ), 'esplanade_single_post_title_tag', 'esplanade_options', 'esplanade_single_tags' );
	add_settings_field( 'esplanade_single_comments_title_tag', __( 'Comments Title Tag', 'esplanade' ), 'esplanade_single_comments_title_tag', 'esplanade_options', 'esplanade_single_tags' );
	add_settings_field( 'esplanade_single_respond_title_tag', __( 'Reply Form Title Tag', 'esplanade' ), 'esplanade_single_respond_title_tag', 'esplanade_options', 'esplanade_single_tags' );
}

function esplanade_single_site_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="esplanade_theme_options[single_site_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, esplanade_get_option( 'single_site_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function esplanade_single_site_desc_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="esplanade_theme_options[single_desc_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, esplanade_get_option( 'single_desc_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function esplanade_single_post_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="esplanade_theme_options[single_post_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, esplanade_get_option( 'single_post_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function esplanade_single_comments_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="esplanade_theme_options[single_comments_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, esplanade_get_option( 'single_comments_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function esplanade_single_respond_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="esplanade_theme_options[single_respond_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, esplanade_get_option( 'single_respond_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function esplanade_other_tags() {
	add_settings_field( 'esplanade_widget_title_tag', __( 'Widget Title Tag', 'esplanade' ), 'esplanade_widget_title_tag', 'esplanade_options', 'esplanade_other_tags' );
}

function esplanade_widget_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="esplanade_theme_options[widget_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, esplanade_get_option( 'widget_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function esplanade_validate_theme_options( $input ) {
	if( isset( $input['submit-general'] ) || isset( $input['reset-general'] ) ) {
		if( ! in_array( $input['home_page_layout'], array( 'grid', 'blog' ) ) )
			$input['home_page_layout'] = esplanade_get_option( 'home_page_layout' );
		if( ! is_numeric( absint( $input['home_page_excerpts'] ) ) || $input['home_page_excerpts'] > get_option( 'posts_per_page' )|| '' == $input['home_page_excerpts'] )
			$input['home_page_excerpts'] = esplanade_get_option( 'home_page_excerpts' );
		else
			$input['home_page_excerpts'] = absint( $input['home_page_excerpts'] );
		$input['slider'] = ( isset( $input['slider'] ) ? true : false );
		$input['location'] = ( isset( $input['location'] ) ? true : false );
		$input['breadcrumbs'] = ( isset( $input['breadcrumbs'] ) ? true : false );
		$input['lightbox'] = ( isset( $input['lightbox'] ) ? true : false );
		if( ! in_array( $input['posts_nav_labels'], array( 'next/prev', 'older/newer', 'earlier/later', 'numbered' ) ) )
			$input['posts_nav_labels'] = esplanade_get_option( 'posts_nav_labels' );
		$input['fancy_dropdowns'] = ( isset( $input['fancy_dropdowns'] ) ? true : false );
		$input['post_nav'] = ( isset( $input['post_nav'] ) ? true : false );
		$input['facebook'] = ( isset( $input['facebook'] ) ? true : false );
		$input['twitter'] = ( isset( $input['twitter'] ) ? true : false );
		$input['google'] = ( isset( $input['google'] ) ? true : false );
		$input['pinterest'] = ( isset( $input['pinterest'] ) ? true : false );
		$input['author_box'] = ( isset( $input['author_box'] ) ? true : false );
		$input['copyright_notice'] = esc_attr( $input['copyright_notice'] );
		$input['theme_credit_link'] = ( isset( $input['theme_credit_link'] ) ? true : false );
		$input['author_credit_link'] = ( isset( $input['author_credit_link'] ) ? true : false );
		$input['wordpress_credit_link'] = ( isset( $input['wordpress_credit_link'] ) ? true : false );
	} elseif( isset( $input['submit-layout'] ) || isset( $input['reset-layout'] ) ) {
		if( ! in_array( $input['layout'], array( 'content-sidebar', 'sidebar-content', 'sidebar-content-sidebar', 'no-sidebars', 'full-width' ) ) )
			$input['layout'] = esplanade_get_option( 'layout' );
		$input['header_height'] = absint( $input['header_height'] );
		$input['sidebar_size'] = str_replace( '"', '', $input['sidebar_size'] );
		$input['sidebar_size'] = str_replace( '%', '', $input['sidebar_size'] );
		$input['sidebar_size'] = '"' . filter_var( $input['sidebar_size'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ) . '%"';
		$input['sidebar_left_size'] = str_replace( '"', '', $input['sidebar_left_size'] );
		$input['sidebar_left_size'] = str_replace( '%', '', $input['sidebar_left_size'] );
		$input['sidebar_left_size'] = '"' . filter_var( $input['sidebar_left_size'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ) . '%"';
		$input['sidebar_right_size'] = str_replace( '"', '', $input['sidebar_right_size'] );
		$input['sidebar_right_size'] = str_replace( '%', '', $input['sidebar_right_size'] );
		$input['sidebar_right_size'] = '"' . filter_var( $input['sidebar_right_size'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ) . '%"';
		$input['header_image_height'] = absint( $input['header_image_height'] );
	} elseif( isset( $input['submit-design'] ) || isset( $input['reset-general'] ) ) {
		if( ! in_array( $input['color_scheme'], array( 'neutral', 'sand', 'nature', 'earth' ) ) )
			$input['color_scheme'] = esplanade_get_option( 'color_scheme' );
		$input['user_css'] = esc_html( $input['user_css'] );
	} elseif( isset( $input['submit-typography'] ) || isset( $input['reset-typography'] ) ) {
		$fonts = esplanade_available_fonts();
		$units = array( 'px', 'pt', 'em', '%' );
		$input['body_font'] = ( array_key_exists( $input['body_font'], $fonts ) ? $input['body_font'] : esplanade_get_option( 'body_font' ) );
		$input['headings_font'] = ( array_key_exists( $input['headings_font'], $fonts ) ? $input['headings_font'] : esplanade_get_option( 'headings_font' ) );
		$input['content_font'] = ( array_key_exists( $input['content_font'], $fonts ) ? $input['content_font'] : esplanade_get_option( 'content_font' ) );
		$input['body_font_size'] = filter_var( $input['body_font_size'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		$input['body_font_size_unit'] = ( in_array( $input['body_font_size_unit'], $units ) ? $input['body_font_size_unit'] : esplanade_get_option( 'body_font_size_unit' ) );
		$input['body_line_height'] = filter_var( $input['body_line_height'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		$input['body_line_height_unit'] = ( in_array( $input['body_line_height_unit'], $units ) ? $input['body_line_height_unit'] : esplanade_get_option( 'body_line_height_unit' ) );
		$input['h1_font_size'] = filter_var( $input['h1_font_size'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		$input['h1_font_size_unit'] = ( in_array( $input['h1_font_size_unit'], $units ) ? $input['h1_font_size_unit'] : esplanade_get_option( 'h1_font_size_unit' ) );
		$input['h2_font_size'] = filter_var( $input['h2_font_size'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		$input['h2_font_size_unit'] = ( in_array( $input['h2_font_size_unit'], $units ) ? $input['h2_font_size_unit'] : esplanade_get_option( 'h2_font_size_unit' ) );
		$input['h3_font_size'] = filter_var( $input['h3_font_size'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		$input['h3_font_size_unit'] = ( in_array( $input['h3_font_size_unit'], $units ) ? $input['h3_font_size_unit'] : esplanade_get_option( 'h3_font_size_unit' ) );
		$input['h4_font_size'] = filter_var( $input['h4_font_size'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		$input['h4_font_size_unit'] = ( in_array( $input['h4_font_size_unit'], $units ) ? $input['h4_font_size_unit'] : esplanade_get_option( 'h4_font_size_unit' ) );
		$input['headings_line_height'] = filter_var( $input['headings_line_height'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		$input['headings_line_height_unit'] = ( in_array( $input['headings_line_height_unit'], $units ) ? $input['headings_line_height_unit'] : esplanade_get_option( 'headings_line_height_unit' ) );
		$input['content_font_size'] = filter_var( $input['content_font_size'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		$input['content_font_size_unit'] = ( in_array( $input['content_font_size_unit'], $units ) ? $input['content_font_size_unit'] : esplanade_get_option( 'content_font_size_unit' ) );
		$input['content_line_height'] = filter_var( $input['content_line_height'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		$input['content_line_height_unit'] = ( in_array( $input['content_line_height_unit'], $units ) ? $input['content_line_height_unit'] : esplanade_get_option( 'content_line_height_unit' ) );
		$input['mobile_font_size'] = filter_var( $input['mobile_font_size'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		$input['mobile_font_size_unit'] = ( in_array( $input['mobile_font_size_unit'], $units ) ? $input['mobile_font_size_unit'] : esplanade_get_option( 'mobile_font_size_unit' ) );
		$input['mobile_line_height'] = filter_var( $input['mobile_line_height'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		$input['mobile_line_height_unit'] = ( in_array( $input['mobile_line_height_unit'], $units ) ? $input['mobile_line_height_unit'] : esplanade_get_option( 'mobile_line_height_unit' ) );
		$input['body_color'] = esc_attr( $input['body_color'] );
		$input['headings_color'] = esc_attr( $input['headings_color'] );
		$input['content_color'] = esc_attr( $input['content_color'] );
		$input['links_color'] = esc_attr( $input['links_color'] );
		$input['links_hover_color'] = esc_attr( $input['links_hover_color'] );
		$input['menu_color'] = esc_attr( $input['menu_color'] );
		$input['menu_hover_color'] = esc_attr( $input['menu_hover_color'] );
		$input['sidebar_color'] = esc_attr( $input['sidebar_color'] );
		$input['sidebar_title_color'] = esc_attr( $input['sidebar_title_color'] );
		$input['sidebar_links_color'] = esc_attr( $input['sidebar_links_color'] );
		$input['footer_color'] = esc_attr( $input['footer_color'] );
		$input['footer_title_color'] = esc_attr( $input['footer_title_color'] );
		$input['footer_links_color'] = esc_attr( $input['footer_links_color'] );
		$input['copyright_color'] = esc_attr( $input['copyright_color'] );
		$input['copyright_links_color'] = esc_attr( $input['copyright_links_color'] );
	} elseif( isset( $input['submit-seo'] ) || isset( $input['reset-seo'] ) ) {
		$tags = array( 'h1', 'h2', 'h3', 'p', 'div' );
		foreach( $input as $key => $tag )
			if( ( 'reset-seo' != $key ) && ! in_array( $tag, $tags ) )
				$input[$key] = esplanade_get_option( $key );
	}
	if( isset( $input['reset-general'] ) || isset( $input['reset-layout'] ) || isset( $input['reset-design'] ) || isset( $input['reset-typography'] ) || isset( $input['reset-seo'] ) ) {
		$default_options = esplanade_default_options();
		foreach( $input as $name => $value )
			$input[$name] = $default_options[$name];
	}
	$input = wp_parse_args( $input, get_option( 'esplanade_theme_options', esplanade_default_options() ) );
	return $input;
}