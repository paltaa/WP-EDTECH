<?php
/**
 * This file contains some IgnitionDeck related functions
 */

/*---------------------------------
	Raised Funds Filter
------------------------------------*/

if ( ! function_exists( 'krown_id_funds_raised' ) ) {

	function krown_id_funds_raised( $content ) {
		$content = str_replace( '.00', '', $content );
		return $content;
	}

}

add_filter( 'id_funds_raised', 'krown_id_funds_raised', 100, 3 );
add_filter( 'id_project_goal', 'krown_id_funds_raised', 100, 3 );
add_filter( 'id_price_selection', 'krown_id_funds_raised', 100, 3 );

wp_enqueue_style( 'the-media-views', includes_url() . 'css/media-views.css' );

/*---------------------------------
	Return author campaigns count
------------------------------------*/

function krown_count_posts( $userid, $post_type = 'post' ) {

	global $wpdb;
	$where = get_posts_by_author_sql( $post_type, true, $userid );
	$count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts $where" );
  	return apply_filters( 'get_usernumposts', $count, $userid );

}

/*---------------------------------
	Change backer avatar
------------------------------------*/

function krown_insert_before_backer() {
	$id = absint($_GET['backer_profile']);
	echo get_avatar( $id, ( isset( $retina ) && $retina === 'true' ? 250 : 125 ), $default='' );
}
add_filter( 'ide_after_backer_profile', 'krown_insert_before_backer' );

/*---------------------------------
	Activate categories for IgnitionDeck CTP
------------------------------------*/

function namespace_add_custom_types( $query ) {

	if ( ! is_admin() && isset( $_GET['post_type'] ) && $_GET['post_type'] == 'ignition_product' && is_archive() && empty( $query->query_vars['suppress_filters'] ) ) {
		$query->set( 'post_type', array( 'ignition_product' ) );
		return $query;
	}

}
add_filter( 'pre_get_posts', 'namespace_add_custom_types' );

/*---------------------------------
	Remove IDE default project page
------------------------------------*/

remove_action('wp', 'ide_use_default_project_page');

/* ------------------------
-----   Add login links   -----
------------------------------*/

if ( ! function_exists( 'krown_add_dashboard_links' ) ) {

	function krown_add_dashboard_links( $items, $args ) {

		$durl = md_get_durl();

	    if ( is_user_logged_in() && $args->theme_location == 'primary' ) {
	        $items .= '<li class="green"><a href="'. $durl . '">' . __( 'Dashboard', 'krown' ) . '</a></li>';
	        $items .= '<li class="green"><a href="'. wp_logout_url( get_permalink() ) .'">' . __( 'Log Out', 'krown' ) . '</a></li>';
	    } else if ( ! is_user_logged_in() && $args->theme_location == 'primary' ) {
	        $items .= '<li class="green"><a href="'. $durl .'">' . __( 'Log In', 'krown' ) . '</a></li>';
	        $items .= '<li class="green"><a href="' . $durl . '?action=register' . '">' . __( 'Sign Up', 'krown' ) . '</a></li>';
	    }

	    return $items;

	}

}

if ( function_exists( 'md_get_durl' ) ) {
	add_filter( 'wp_nav_menu_items', 'krown_add_dashboard_links', 10, 2 );
}

/* ------------------------
-----   Create author profile page   -----
------------------------------*/

if ( ! function_exists( 'krown_author_profile' ) ) {

	function krown_author_profile() {

		$author = get_userdata( get_query_var( 'author' ) );

		$twitter_link = get_user_meta( $author->ID, 'twitter', true );
		$fb_link = get_user_meta( $author->ID, 'facebook', true );
		$google_link = get_user_meta( $author->ID, 'google', true );
		$website_link = $author->user_url;

		$html = '<div class="ignitiondeck backer_profile custom">
			<div class="backer_info">
				<div class="backer_avatar">' . get_avatar( $author->user_email, ( isset( $retina ) && $retina === 'true' ? 250 : 125 ), $default='' ) . '</div>
				<div class="backer_title">
					<h3>' . $author->display_name . '</h3>
					<div class="id-backer-links">';

						if ( $website_link != '' ) {
							$html .= '<a class="website" href="' . $website_link . '">' . __( 'Website', 'krown' ) . '</a>';
						}

						if ( $twitter_link != '' ) {
							$html .= '<a class="twitter" href="' . $twitter_link . '">' . __( 'Twitter', 'krown' ) . '</a>';
						}

						if ( $fb_link != '' ) {
							$html .= '<a class="facebook" href="' . $fb_link . '">' . __( 'Facebook', 'krown' ) . '</a>';
						}

						if ( $google_link != '' ) {
							$html .= '<a class="googleplus" href="' . $google_link . '">' . __( 'Google Plus', 'krown' ) . '</a>';
						}

					$html .= '</div>
					<p>' . wpautop( $author->description ) . '</p>
				</div>
			</div>
			<div class="backer_data"><p class="backer_joined">' . __( 'Joined', 'krown' ) . ' ' . date( __( 'n/j/Y', 'krown' ), strtotime( $author->user_registered ) ) . '</p></div>
		</div>';

		echo $html;

	}

}

/* ------------------------
-----   Add a wrapping class when needed   -----
------------------------------*/

function krown_md_ch_class() {
	global $post;
	if ( ( isset( $_GET['action'] ) && $_GET['action'] == 'register' ) || ( isset( $post ) && strpos( $post->post_content, '[memberdeck_checkout') !== false ) ) {
		echo ' wrap-md';
	}
}

/* ------------------------
-----   REfilter creator profile page   -----
------------------------------*/

function krown_md_ide_check_creator_profile() {
	if (isset($_GET['creator_projects']) && $_GET['creator_projects'] == 1 && is_user_logged_in()) {
		add_filter('the_content', 'krown_md_ide_creator_projects');
	}
}

remove_action( 'init', 'md_ide_check_creator_profile' );
add_action( 'init', 'krown_md_ide_check_creator_profile' );

function krown_md_ide_creator_projects($content) {
	ob_start();
	global $current_user;
	get_currentuserinfo();
	$user_id = $current_user->ID;
	echo '<div class="memberdeck">';
	include_once IDC_PATH.'templates/_mdProfileTabs.php';
	echo '<ul class="md-box-wrapper full-width cf"><li class="md-box full"><div class="md-profile">';
	echo '<h3>'.__( 'My Projects', 'krown' ).'</h3>';
	echo '<ul class="md-projects-list clearfix">';
	$user_projects = get_user_meta($user_id, 'ide_user_projects', true);
	if (!empty($user_projects)) {
		$user_projects = unserialize($user_projects);
		if (is_array($user_projects)) {
			foreach ($user_projects as $editable_project) {
				$post_id = $editable_project;
				$project_id = get_post_meta($post_id, 'ign_project_id', true);
				if (!empty($project_id)) {
					$post = get_post($post_id);
					if (isset($post)) {
						$status = $post->post_status;
						if (strtoupper($status) !== 'TRASH') {
							$project = new ID_Project($project_id);
							$the_project = $project->the_project();

							if ( has_post_thumbnail( $post->ID ) ) {
								$thumb = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ), 'full' );
							} else {
								$thumb = get_post_meta($post_id, 'ign_product_image1', true);
							} 
							
							$permalink = get_permalink($post_id);
							if (strtoupper($status) == 'DRAFT') {
								$permalink = $permalink.'&preview=true';
							}
							include get_template_directory() . '/includes/ignitiondeck-templates/_myProjects.php';
						}
					}
				}
			}
		}
	}
	echo '</ul><button class="create_project button-medium" onclick="location.href=\'?create_project=1\'">'.__('Create Project', 'memberdeck').'</button></div></li></ul>';
	echo '</div>';
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

/* ------------------------
-----   Dequeue strech assets  -----
------------------------------*/

remove_action('wp_enqueue_scripts', 'idstretch_styles');

/* ------------------------
-----   Projects Grid  -----
------------------------------*/

// This is a redefinemenet of the project_grid shortcode which is available in the IgnitionDeck plugin

function krown_project_grid_shortcode( $atts ) {

	// Default attributes

    extract( shortcode_atts( array(
        'el_class'   => '',
        'category'   => '',
        'author' 	 => '',
        'orderby'    => 'date', 
        'order' 	 => 'DESC',
        'max'		 => '-1',
        'visible'    => '4',
        'pagination' => 'no',
        'style'		 => 'default'
    ), $atts ) );

    // Start output and Query arguments

    $html = '<div class="krown-id-grid ' . $style . ' clearfix" id="ign-' . rand( 99, 9999 ) . '">';

	// Start carousel (if case)

    if ( $style == 'carousel' ) {
    	$html .= '<div class="holder"><div class="carousel-holder clearfix" data-visible="' . $visible . '">';
    }

	// Define categories if present (multiple)

	if ( isset( $attrs['category'] ) ) {
		$category = $attrs['category'];
		$args = array(
			'post_type' => 'ignition_product',
			'tax_query' => array(
				array(
					'taxonomy' => 'project_category',
					'field' => 'id',
					'terms' => $category
				)
			)
		);
	} else {
		$args['post_type'] = 'ignition_product';
	}

	// Define order based on given attributes

	if ( $orderby == 'days_left' ) {
		$args['orderby'] = 'meta_value_num';
		$args['meta_key'] = 'ign_days_left';
	} else if ( $orderby == 'percent_raised' ) {
		$args['orderby'] = 'meta_value_num';
		$args['meta_key'] = 'ign_percent_raised';
	} else if ( $orderby == 'funds_raised' ) {
		$args['orderby'] = 'meta_value_num';
		$args['meta_key'] = 'ign_fund_raised';
	} else if ( $orderby == 'featured' ) {
		$args['orderby'] = 'meta_value_num';
		$args['meta_key'] = 'krown_idp_featured';
	} else {
		$args['orderby'] = $orderby;
	}

	$args['order'] = $order;

	// Define author if present (single)

	if ( $author != '' ) {
		$args['author_name'] = $author;
	}

	// Define number of projects

	$args['posts_per_page'] = $max;

	// Define pagination

	if ( $pagination == 'yes' ) {
		$args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );
	}

	// Start query and get object

	$all_posts = new WP_Query( $args );
	ob_start();

	while ( $all_posts->have_posts() ) {

		$all_posts->the_post();
		global $post;
		get_template_part( 'content-ignition_product' );

	}

	// Reset post data, close container and return output

	$html .= ob_get_contents();
	ob_end_clean();

	wp_reset_query();

	// End carousel (if case)

    if ( $style == 'carousel' ) {
    	$html .= '</div></div><a href="#" class="btn btn-prev"><i class="krown-icon-arrow_left"></i></a><a href="#" class="btn btn-next"><i class="krown-icon-arrow_right"></i></a>';
    }

    $html .= '</div>';

    // Add pagination

    if ( $pagination == 'yes' ) {
		$html .= krown_pagination( $all_posts, true, 2, false );
	}

    return $html;

}

remove_shortcode( 'project_grid' );
add_shortcode( 'project_grid', 'krown_project_grid_shortcode' );

/* ------------------------
-----   Posts per page  -----
------------------------------*/

if ( ! function_exists( 'krown_id_ppp' ) ) {

	function krown_id_ppp( $query ) {
		if ( $query->is_archive() && $query->is_main_query() ) {
			$query->set( 'posts_per_page', 9 );
		}
	}

}
add_action( 'pre_get_posts', 'krown_id_ppp' );

/* ------------------------
-----   Embedding stylesheet  -----
------------------------------*/

/* - in a future update
function krown_id_embed_style() {
	return '<link rel="stylesheet" id="ignitiondeck-iframe-css" href="' . get_template_directory_uri() . '/css/iframe-embed.css" type="text/css" media="all" />';
}
add_filter( 'embed_widget_stylesheet', 'krown_id_embed_style' ); */

/* ------------------------
-----   ID Categories Walker  -----
------------------------------*/

class IgnitionDeck_Category_Menu extends Walker_Category {

	var $tree_type = 'category';
	var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		if ( 'list' != $args['style'] )
			return;

		$indent = str_repeat("\t", $depth);
		$output .= "$indent<ul class='children'>\n";
	}

	function end_lvl( &$output, $depth = 0, $args = array() ) {
		if ( 'list' != $args['style'] )
			return;

		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		extract($args);

		$cat_name = esc_attr( $category->name );

		/** This filter is documented in wp-includes/category-template.php */
		$cat_name = apply_filters( 'list_cats', $cat_name, $category );

		$link = '<a href="' . esc_url( get_term_link($category) ) . '?post_type=ignition_product" ';
		if ( $use_desc_for_title == 0 || empty($category->description) ) {
			$link .= 'title="' . esc_attr( sprintf(__( 'View all posts filed under %s' ), $cat_name) ) . '"';
		} else {
			$link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
		}

		$link .= '>';
		$link .= $cat_name . '</a>';

		if ( !empty($feed_image) || !empty($feed) ) {
			$link .= ' ';

			if ( empty($feed_image) )
				$link .= '(';

			$link .= '<a href="' . esc_url( get_term_feed_link( $category->term_id, $category->taxonomy, $feed_type ) ) . '?post_type=ignition_product"';

			if ( empty($feed) ) {
				$alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s' ), $cat_name ) . '"';
			} else {
				$title = ' title="' . $feed . '"';
				$alt = ' alt="' . $feed . '"';
				$name = $feed;
				$link .= $title;
			}

			$link .= '>';

			if ( empty($feed_image) )
				$link .= $name;
			else
				$link .= "<img src='$feed_image'$alt$title" . ' />';

			$link .= '</a>';

			if ( empty($feed_image) )
				$link .= ')';
		}

		if ( !empty($show_count) )
			$link .= ' (' . number_format_i18n( $category->count ) . ')';

		if ( 'list' == $args['style'] ) {
			$output .= "\t<li";
			$class = 'cat-item cat-item-' . $category->term_id;
			if ( !empty($current_category) ) {
				$_current_category = get_term( $current_category, $category->taxonomy );
				if ( $category->term_id == $current_category )
					$class .=  ' current-cat';
				elseif ( $category->term_id == $_current_category->parent )
					$class .=  ' current-cat-parent';
			}
			$output .=  ' class="' . $class . '"';
			$output .= ">$link\n";
		} else {
			$output .= "\t$link<br />\n";
		}
	}

	function end_el( &$output, $page, $depth = 0, $args = array() ) {
		if ( 'list' != $args['style'] )
			return;

		$output .= "</li>\n";
	}

}

?>