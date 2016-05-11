<?php

//Add an action that will load all widgets
add_action( 'widgets_init', 'rb_load_widgets' );

//Function that registers the widgets
function rb_load_widgets() {
	register_widget('krown_id_search');
	register_widget('krown_id_categories');
}


class krown_id_categories extends WP_Widget {
	
	function krown_id_categories (){
		
		$widget_ops = array( 'classname' => 'categories', 'description' => 'Widget to show project categories' );
		$control_ops = array( 'width' => 250, 'height' => 120, 'id_base' => 'email-widget' );
		$this->WP_Widget( 'email-widget', 'IgnitionDeck Categories', $widget_ops, $control_ops );
		
	}
		
	function widget($args, $instance){
			
		extract($args);

		$title = apply_filters( 'widget_title', $instance['title'] );
			
		echo $before_widget;

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		echo '<ul class="categories">';

		wp_list_categories( array(
			'orderby' 			=> 'name',
			'order'	  			=> 'ASC',
			'show_count' 		=> 0,
			'hide_empty'		=> 0,
			'title_li'			=> '',
			'show_option_none' 	=> '',
			'taxonomy' 			=> 'project_category',
			'walker'			=> new IgnitionDeck_Category_Menu()
		) );

		echo '</ul>';

		echo $after_widget;
			
	}
			
	function update($new_instance, $old_instance){
		
		$instance = $old_instance;
			
		$instance['title'] = strip_tags($new_instance['title']);
			
		return $instance;
			
	}
		
	function form($instance){
		
		$defaults = array(  'title' => '' );
			
		$instance = wp_parse_args((array) $instance, $defaults);
			
		?>
			
			
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'krown' ); ?></label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" class="widefat" type="text" />
			</p>
			
		<?php
			
	}
		
}

class krown_id_search extends WP_Widget {
	
	function krown_id_search (){
		
		$widget_ops = array( 'classname' => 'search', 'description' => 'A dedicated projects search form' );
		$control_ops = array( 'width' => 250, 'height' => 120, 'id_base' => 'search-widget' );
		$this->WP_Widget( 'search-widget', 'IgnitionDeck Search', $widget_ops, $control_ops );
		
	}
		
	function widget($args, $instance){
			
		extract($args);

		$title = apply_filters( 'widget_title', $instance['title'] );
			
		echo $before_widget;

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		echo '<form role="search" method="get" id="searchform" class="hover-show" action="' . home_url( '/' ) . '" >
			<label class="screen-reader-text hidden" for="s">' . __( 'Search for:', 'krown' ) . '</label>
			<input type="search" value="" name="s" id="s" placeholder="' . __( 'Type and hit enter', 'krown' ) . '" />
			<input type="hidden" name="post_type" value="ignition_product" />
			<input id="submit_s" type="submit" />
	    </form>';

		echo $after_widget;
			
	}
			
	function update($new_instance, $old_instance){
		
		$instance = $old_instance;
			
		$instance['title'] = strip_tags($new_instance['title']);
			
		return $instance;
			
	}
		
	function form($instance){
		
		$defaults = array(  'title' => '' );
			
		$instance = wp_parse_args((array) $instance, $defaults);
			
		?>
			
			
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'krown' ); ?></label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" class="widefat" type="text" />
			</p>
			
		<?php
			
	}
		
}

?>