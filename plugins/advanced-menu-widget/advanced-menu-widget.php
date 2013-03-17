<?php
/*
 * Plugin Name: Advanced Menu Widget
 * Plugin URI: http://www.techforum.sk/
 * Description: Enhanced Navigation Menu Widget
 * Version: 0.2
 * Author: Ján Bočínec
 * Author URI: http://johnnypea.wp.sk/
 * License: GPL2+
*/

function add_rem_menu_widget() {
	//unregister_widget( 'WP_Nav_Menu_Widget' );
	register_widget('Advanced_Menu_Widget');
}
add_action('widgets_init', 'add_rem_menu_widget');

function selective_display($itemID, $children_elements, $strict_sub = false) {
	global $wpdb;

	if ( ! empty($children_elements[$itemID]) ) {
		foreach ( $children_elements[$itemID] as &$childchild ) {
			$childchild->display = 1;
			if ( ! empty($children_elements[$childchild->ID]) && ! $strict_sub ) {
				selective_display($childchild->ID, $children_elements);
			}
		}
	}
	
}

class Selective_Walker extends Walker_Nav_Menu
{

    function walk( $elements, $max_depth) {

        $args = array_slice(func_get_args(), 2);
        $output = '';

        if ($max_depth < -1) //invalid parameter
            return $output;

        if (empty($elements)) //nothing to walk
            return $output;

        $id_field = $this->db_fields['id'];
        $parent_field = $this->db_fields['parent'];

        // flat display
        if ( -1 == $max_depth ) {
            $empty_array = array();
            foreach ( $elements as $e )
                $this->display_element( $e, $empty_array, 1, 0, $args, $output );
            return $output;
        }

        /*
         * need to display in hierarchical order
         * separate elements into two buckets: top level and children elements
         * children_elements is two dimensional array, eg.
         * children_elements[10][] contains all sub-elements whose parent is 10.
         */
        $top_level_elements = array();
        $children_elements  = array();
        foreach ( $elements as $e) {
            if ( 0 == $e->$parent_field )
                $top_level_elements[] = $e;
            else
                $children_elements[ $e->$parent_field ][] = $e;
        }

        /*
         * when none of the elements is top level
         * assume the first one must be root of the sub elements
         */
        if ( empty($top_level_elements) ) {

            $first = array_slice( $elements, 0, 1 );
            $root = $first[0];

            $top_level_elements = array();
            $children_elements  = array();
            foreach ( $elements as $e) {
                if ( $root->$parent_field == $e->$parent_field )
                    $top_level_elements[] = $e;
                else
                    $children_elements[ $e->$parent_field ][] = $e;
            }
        }

        $current_element_markers = array( 'current-menu-item', 'current-menu-parent', 'current-menu-ancestor' );

        foreach ( $top_level_elements as $e ) {

            // descend only on current tree
            $descend_test = array_intersect( $current_element_markers, $e->classes );
            if ( empty( $descend_test ) )  unset ( $children_elements );

            $this->display_element( $e, $children_elements, $max_depth, 0, $args, $output );
        }

        /*
         * if we are displaying all levels, and remaining children_elements is not empty,
         * then we got orphans, which should be displayed regardless
         */
        if ( ( $max_depth == 0 ) && count( $children_elements ) > 0 ) {
            $empty_array = array();
            foreach ( $children_elements as $orphans )
                foreach( $orphans as $op )
                    $this->display_element( $op, $empty_array, 1, 0, $args, $output );
         }

         return $output;
    }

}

/**
 * Advanced Menu Widget class
 */
 class Advanced_Menu_Widget extends WP_Widget {

	function Advanced_Menu_Widget() {
		$widget_ops = array( 'description' => 'Use this widget to add one of your custom menus as a widget.' );
		parent::WP_Widget( 'advanced_menu', 'Advanced Menu', $widget_ops );
	}

	function widget($args, $instance) {
		
		$only_related_walker = ( $instance['only_related'] == 2 || $instance['only_related'] == 3 || 1 == 1 )? new Selective_Walker : new Walker_Nav_Menu;
		$strict_sub = $instance['only_related'] == 3 ? 1 : 0;
		$only_related = $instance['only_related'] == 2 || $instance['only_related'] == 3 ? 1 : 0;
		$depth = $instance['depth'] ? $instance['depth'] : 0;		
		$container = isset( $instance['container'] ) ? $instance['container'] : 'div';
		$container_id = isset( $instance['container_id'] ) ? $instance['container_id'] : '';
		$menu_class = isset( $instance['menu_class'] ) ? $instance['menu_class'] : 'menu';
		$before = isset( $instance['before'] ) ? $instance['before'] : '';
		$after = isset( $instance['after'] ) ? $instance['after'] : '';
		$link_before = isset( $instance['link_before'] ) ? $instance['link_before'] : '';
		$link_after = isset( $instance['link_after'] ) ? $instance['link_after'] : '';
		$filter = !empty($instance['filter']) ? $instance['filter'] : 0;
		$filter_selection = $instance['filter_selection'] ? $instance['filter_selection'] : 0;
		$custom_widget_class  = isset( $instance['custom_widget_class'] ) ? trim($instance['custom_widget_class']) : '';
		$include_parent = !empty($instance['include_parent']) ? 1 : 0;
		$start_depth = !empty($instance['start_depth']) ? absint($instance['start_depth']) : 0;

		// Get menu
		$nav_menu = wp_get_nav_menu_object( $instance['nav_menu'] );

		if ( !$nav_menu )
			return;

		$instance['title'] = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);

		if ( $custom_widget_class ) {
			echo str_replace ('class="', 'class="' . "$custom_widget_class ", $args['before_widget']);
		} else {
			echo $args['before_widget'];			
		}

		if ( !empty($instance['title']) )
			echo $args['before_title'] . $instance['title'] . $args['after_title'];

		wp_nav_menu( array( 'fallback_cb' => '', 'menu' => $nav_menu, 'walker' => $only_related_walker, 'depth' => $depth, 'only_related' => $only_related, 'strict_sub' => $strict_sub, 'filter_selection' => $filter_selection, 'container' => $container,'container_id' => $container_id,'menu_class' => $menu_class, 'before' => $before, 'after' => $after, 'link_before' => $link_before, 'link_after' => $link_after, 'filter' => $filter, 'include_parent' => $include_parent, 'start_depth' => $start_depth ) );

		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );		
		$instance['nav_menu'] = (int) $new_instance['nav_menu'];
		$instance['depth'] = (int) $new_instance['depth'];
		$instance['only_related'] = !$new_instance['filter_selection'] ? (int) $new_instance['only_related'] : 0;
		$instance['filter_selection'] = (int) $new_instance['filter_selection'];			
		$instance['container'] = $new_instance['container'];
		$instance['container_id'] = $new_instance['container_id'];
		$instance['menu_class'] = $new_instance['menu_class'];
		$instance['before'] = $new_instance['before'];
		$instance['after'] = $new_instance['after'];
		$instance['link_before'] = $new_instance['link_before'];
		$instance['link_after'] = $new_instance['link_after'];
		$instance['filter'] = !empty($new_instance['filter']) ? $new_instance['filter'] : 0;
		$instance['include_parent'] = !empty($new_instance['include_parent']) ? 1 : 0;
		$instance['custom_widget_class'] = $new_instance['custom_widget_class'];
		$instance['start_depth'] = absint( $new_instance['start_depth'] );

		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';
		$only_related = isset( $instance['only_related'] ) ? (int) $instance['only_related'] : 1;
		$depth = isset( $instance['depth'] ) ? (int) $instance['depth'] : 0;		
		$container = isset( $instance['container'] ) ? $instance['container'] : 'div';
		$container_id = isset( $instance['container_id'] ) ? $instance['container_id'] : '';
		$menu_class = isset( $instance['menu_class'] ) ? $instance['menu_class'] : 'menu';
		$before = isset( $instance['before'] ) ? $instance['before'] : '';
		$after = isset( $instance['after'] ) ? $instance['after'] : '';
		$link_before = isset( $instance['link_before'] ) ? $instance['link_before'] : '';
		$link_after = isset( $instance['link_after'] ) ? $instance['link_after'] : '';
		$filter_selection = isset( $instance['filter_selection'] ) ? (int) $instance['filter_selection'] : 0;
		$custom_widget_class = isset( $instance['custom_widget_class'] ) ? $instance['custom_widget_class'] : '';
		$start_depth = isset($instance['start_depth']) ? absint($instance['start_depth']) : 0;
				
		// Get menus
		$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

		// If no menus exists, direct the user to go and create some.
		if ( !$menus ) {
			echo '<p>'. sprintf( __('No menus have been created yet. <a href="%s">Create some</a>.'), admin_url('nav-menus.php') ) .'</p>';
			return;
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('custom_widget_class'); ?>"><?php _e('Custom Widget Class:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('custom_widget_class'); ?>" name="<?php echo $this->get_field_name('custom_widget_class'); ?>" value="<?php echo $custom_widget_class; ?>" />
		</p>		
		<p>
			<label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:'); ?></label>
			<select id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
		<?php
			foreach ( $menus as $menu ) {
				$selected = $nav_menu == $menu->term_id ? ' selected="selected"' : '';
				echo '<option'. $selected .' value="'. $menu->term_id .'">'. $menu->name .'</option>';
			}
		?>
			</select>
		</p>
		<p><label for="<?php echo $this->get_field_id('only_related'); ?>"><?php _e('Show hierarchy:'); ?></label>
		<select name="<?php echo $this->get_field_name('only_related'); ?>" id="<?php echo $this->get_field_id('only_related'); ?>" class="widefat">
			<option value="1"<?php selected( $only_related, 1 ); ?>><?php _e('Display all'); ?></option>
			<option value="2"<?php selected( $only_related, 2 ); ?>><?php _e('Only related sub-items'); ?></option>
			<option value="3"<?php selected( $only_related, 3 ); ?>><?php _e( 'Only strictly related sub-items' ); ?></option>
		</select>
		</p>
		<p><label for="<?php echo $this->get_field_id('start_depth'); ?>"><?php _e('Starting depth:'); ?></label>
		<input id="<?php echo $this->get_field_id('start_depth'); ?>" name="<?php echo $this->get_field_name('start_depth'); ?>" type="text" value="<?php echo $start_depth; ?>" size="3" />
		</p>
		<p><label for="<?php echo $this->get_field_id('depth'); ?>"><?php _e('How many levels to display:'); ?></label>
		<select name="<?php echo $this->get_field_name('depth'); ?>" id="<?php echo $this->get_field_id('depth'); ?>" class="widefat">
			<option value="0"<?php selected( $depth, 0 ); ?>><?php _e('Unlimited depth'); ?></option>
			<option value="1"<?php selected( $depth, 1 ); ?>><?php _e( '1 level deep' ); ?></option>
			<option value="2"<?php selected( $depth, 2 ); ?>><?php _e( '2 levels deep' ); ?></option>
			<option value="3"<?php selected( $depth, 3 ); ?>><?php _e( '3 levels deep' ); ?></option>
			<option value="4"<?php selected( $depth, 4 ); ?>><?php _e( '4 levels deep' ); ?></option>
			<option value="5"<?php selected( $depth, 5 ); ?>><?php _e( '5 levels deep' ); ?></option>
			<option value="-1"<?php selected( $depth, -1 ); ?>><?php _e( 'Flat display' ); ?></option>
		</select>
		<p>
		<p><label for="<?php echo $this->get_field_id('filter_selection'); ?>"><?php _e('Filter selection from:'); ?></label>
		<select name="<?php echo $this->get_field_name('filter_selection'); ?>" id="<?php echo $this->get_field_id('filter_selection'); ?>" class="widefat">
		<option value="0"<?php selected( $only_related, 0 ); ?>><?php _e('Display all'); ?></option>
		<?php 
		$menu_id = ( $nav_menu ) ? $nav_menu : $menus[0]->term_id;
		$menu_items = wp_get_nav_menu_items($menu_id); 
		foreach ( $menu_items as $menu_item ) {
			echo '<option value="'.$menu_item->ID.'"'.selected( $filter_selection, $menu_item->ID ).'>'.$menu_item->title.'</option>';
		}
		?>		
		</select>
		</p>
		<p>Select the filter:</p>
		<p>
			<label for="<?php echo $this->get_field_id('filter'); ?>_0">
			<input id="<?php echo $this->get_field_id('filter'); ?>_0" name="<?php echo $this->get_field_name('filter'); ?>" type="radio" value="0" <?php checked( $instance['filter'] || empty($instance['filter']) ); ?> /> None
			</label><br />
            <label for="<?php echo $this->get_field_id('filter'); ?>_1">
            <input id="<?php echo $this->get_field_id('filter'); ?>_1" name="<?php echo $this->get_field_name('filter'); ?>" type="radio" value="1" <?php checked("1" , $instance['filter']); ?> /> Display direct path
			</label><br />
			<label for="<?php echo $this->get_field_id('filter'); ?>_2">
            <input id="<?php echo $this->get_field_id('filter'); ?>_2" name="<?php echo $this->get_field_name('filter'); ?>" type="radio" value="2" <?php checked("2" , $instance['filter']); ?> /> Display only children of selected item
			</label>
		</p>	
		<p><input id="<?php echo $this->get_field_id('include_parent'); ?>" name="<?php echo $this->get_field_name('include_parent'); ?>" type="checkbox" <?php checked(isset($instance['include_parent']) ? $instance['include_parent'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('include_parent'); ?>"><?php _e('Include parents'); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('container'); ?>"><?php _e('Container:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('container'); ?>" name="<?php echo $this->get_field_name('container'); ?>" value="<?php echo $container; ?>" />
			<small><?php _e( 'Whether to wrap the ul, and what to wrap it with.' ); ?></small>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('container_id'); ?>"><?php _e('Container ID:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('container_id'); ?>" name="<?php echo $this->get_field_name('container_id'); ?>" value="<?php echo $container_id; ?>" />
			<small><?php _e( 'The ID that is applied to the container.' ); ?></small>			
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('menu_class'); ?>"><?php _e('Menu Class:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('menu_class'); ?>" name="<?php echo $this->get_field_name('menu_class'); ?>" value="<?php echo $menu_class; ?>" />
			<small><?php _e( 'CSS class to use for the ul element which forms the menu.' ); ?></small>						
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('before'); ?>"><?php _e('Before the link:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('before'); ?>" name="<?php echo $this->get_field_name('before'); ?>" value="<?php echo $before; ?>" />
			<small><?php _e( htmlspecialchars('Output text before the <a> of the link.') ); ?></small>			
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('after'); ?>"><?php _e('After the link:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('after'); ?>" name="<?php echo $this->get_field_name('after'); ?>" value="<?php echo $after; ?>" />
			<small><?php _e( htmlspecialchars('Output text after the <a> of the link.') ); ?></small>						
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('link_before'); ?>"><?php _e('Before the link text:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('link_before'); ?>" name="<?php echo $this->get_field_name('link_before'); ?>" value="<?php echo $link_before; ?>" />
			<small><?php _e( 'Output text before the link text.' ); ?></small>			
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('link_after'); ?>"><?php _e('After the link text:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('link_after'); ?>" name="<?php echo $this->get_field_name('link_after'); ?>" value="<?php echo $link_after; ?>" />
			<small><?php _e( 'Output text after the link text.' ); ?></small>			
		</p>	
		<?php
	}
}