<?php
/*---------------------------------
	Setup OptionTree
------------------------------------*/

add_filter( 'ot_show_pages', '__return_false' );
add_filter( 'ot_theme_mode', '__return_true' );
require_once( 'option-tree/ot-loader.php' );

function filter_ot_upload_text(){
	return __( 'Insert', 'krown' );
}
function filter_ot_header_list(){
	echo '<li id="option-tree-version"><span>' . __( 'Backer Options', 'krown' ) . '</span></li>';
}
function filter_ot_header_version_text(){
	return '1.1';
}

add_filter( 'ot_header_list', 'filter_ot_header_list' );
add_filter( 'ot_upload_text', 'filter_ot_upload_text' );
add_filter( 'ot_header_version_text', 'filter_ot_header_version_text');

/*---------------------------------
	Include other files
------------------------------------*/

include( 'includes/theme-options.php' );
include( 'includes/customizer-options.php' );
include( 'includes/custom-styles.php' );
include( 'includes/metaboxes.php' );
include( 'includes/plugins.php' );
include( 'includes/widget.php' );
include( 'includes/ignitiondeck-functions.php' );

if ( ! function_exists( 'aq_resize' ) ) {
	include( 'includes/aq_resizer.php' );
}

/*---------------------------------
	Enable SVG upload
------------------------------------*/

function krown_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'krown_mime_types' );

/*---------------------------------
	Retina info (by js cookie)
------------------------------------*/

if ( ! function_exists( 'krown_retina' ) ) {

	function krown_retina() {

		if ( isset( $_COOKIE['dpi'] ) ) {
			$retina = $_COOKIE['dpi'];
		} else { 
			$retina = false;
		}

		return $retina;

	}

}

/*---------------------------------
	A custom pagination function
------------------------------------*/

if ( ! function_exists( 'krown_pagination' ) ) {

	function krown_pagination( $query = null, $paginated = false, $range = 2, $echo = true ) {  

		if ( $query == null ) {
			global $wp_query;
			$query = $wp_query;
		}

		$page = $query->query_vars['paged'];
		$pages = $query->max_num_pages;

		if ( $page == 0 ) {
			$page = 1;
		}

		$html = '';

		if( $pages > 1 ) {

			$html .= '<nav class="pagination clearfix">';

			if ( ! $paginated ) {

				if ( $page + 1 <= $pages ) {
					$html .= '<a class="prev" href="' . get_pagenum_link( $page + 1 ) . '">' . '<i class="krown-icon-arrow_left"></i>' . __( 'Older Post' ,'krown' ) . '</a>';
				}

				if ( $page - 1 >= 1 ) {
					$html .= '<a class="next" href="' . get_pagenum_link( $page - 1 ) . '">' . __( 'Newer Post' ,'krown' ) . '<i class="krown-icon-arrow_right"></i></a>';
				}

			} else {

				for ( $i = 1; $i <= $pages; $i++ ) {

					if ( $i == 1 || $i == $pages || $i == $page || ( $i >= $page - $range && $i <= $page + $range ) ) {
						$html .= '<a href="' . get_pagenum_link( $i ) . '"' . ( $page == $i ? ' class="active"' : '' ) . '>' . $i . '</a>';
					} else if ( ( $i != 1 && $i == $page - $range - 1 ) || ( $i != $page && $i == $page + $range + 1 ) ) {
						$html .= '<a class="none">...</a>';
					}

				}

			}
				
			$html .= '</nav>';

		}

		if ( $echo ) {
			echo $html;
		} else {
			return $html;
		}
		 
	}

}

/*---------------------------------
	Make some adjustments on theme setup
------------------------------------*/

if ( ! function_exists( 'krown_setup' ) ) {

	function krown_setup() {

		// Add more widget areas based on user settings

		$sidebars = ot_get_option( 'krown_sidebars' );
		if ( ! empty( $sidebars ) ) {
			foreach ( $sidebars as $sidebar ) {
				register_sidebar( array(
					'name' => $sidebar['title'],
					'id' => $sidebar['id'],
					'description' => '',
					'before_widget' => '<section id="%1$s" class="widget %2$s clearfix">',
					'after_widget' => '</section>',
					'before_title' => '<h4 class="widget-title">',
					'after_title' => '</h4>',
				) );
			}
		} 

		// Setup radio images for metaboxes (action)

		add_filter( 'ot_radio_images', 'filter_radio_images', 10, 2 );

		// Setup theme update with PIXELENTITY's class
			
		if( ot_get_option( 'krown_updates_user' ) != '' && ot_get_option( 'krown_updates_api' ) != '' ){

			require_once( 'pixelentity-theme-update/class-pixelentity-theme-update.php' );
			PixelentityThemeUpdate::init( ot_get_option( 'krown_updates_user' ), ot_get_option( 'krown_updates_api' ), 'KrownThemes' );

		}

		// Make theme available for translation

		load_theme_textdomain( 'krown', get_template_directory() . '/lang' );

		$locale = get_locale();
		$locale_file = get_template_directory() . "/lang/$locale.php";

		if ( is_readable( $locale_file ) ) {
			require_once( $locale_file );
		}
	
		// Define content width (stupid feature, this theme has no width)

		if( ! isset( $content_width ) ) {
			$content_width = 940;
		}
		
		// Add RSS feed links to head

		add_theme_support( 'automatic-feed-links' );

		// Add post thumbnails support

		add_theme_support( 'post-thumbnails' );

		// Add HTML5 support

		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

		// Enable excerpts for pages

		add_post_type_support( 'page', 'excerpt' );

		// Enable shortcodes inside text widgets

		add_filter( 'widget_text', 'do_shortcode' );
			
		// Add primary navigation 

		register_nav_menus( array(
			'primary' => __( 'Primary Navigation', 'krown' ),
		) );

		// WP 4.1 title tag

		add_theme_support( 'title-tag' );
		
	}

}

add_action( 'after_setup_theme', 'krown_setup' );

/*---------------------------------
	Title tag up to WP 4.1
------------------------------------*/

add_action( 'after_setup_theme', 'krown_setup' );

if ( ! function_exists( '_wp_render_title_tag' ) ) {

	function theme_slug_render_title() {
	    echo '<title>' . wp_title( '|', false, 'right' ) . "</title>\n";
	}

	add_action( 'wp_head', 'theme_slug_render_title' );

	function krown_filter_wp_title( $title, $separator ) {

		if ( is_feed() ) return $title;

		global $paged, $page;

		if ( is_search() ) {

			$title = sprintf( __( 'Search results for %s', 'iwrite' ), '"' . get_search_query() . '"' );
			if ( $paged >= 2 )
				$title .= " $separator " . sprintf( __( 'Page %s', 'iwrite' ), $paged );
			$title .= " $separator " . get_bloginfo( 'name', 'display' );
			return $title;
		}

		$title .= get_bloginfo( 'name', 'display' );
		$site_description = get_bloginfo( 'description', 'display' );

		if ( $site_description && ( is_home() || is_front_page() ) )
			$title .= " $separator " . $site_description;

		if ( $paged >= 2 || $page >= 2 )
			$title .= " $separator " . sprintf( __( 'Page %s', 'iwrite' ), max( $paged, $page ) );

		return $title;

	}

	add_filter( 'wp_title', 'krown_filter_wp_title', 10, 2 );

}

/*---------------------------------
	Setup radio images for metaboxes (function)
------------------------------------*/

function filter_radio_images( $array, $field_id ) {

	if ( $field_id == 'krown_sidebar_layout' ) {
		$array = array(
			array(
				'value'   => 'full-width',
				'label'   => __( 'Full Width', 'option-tree' ),
				'src'     => OT_URL . '/assets/images/layout/full-width.png'
			),
			array(
				'value'   => 'right-sidebar',
				'label'   => __( 'Right Sidebar', 'option-tree' ),
				'src'     => OT_URL . '/assets/images/layout/right-sidebar.png'
			),
			array(
				'value'   => 'left-sidebar',
				'label'   => __( 'Left Sidebar', 'option-tree' ),
				'src'     => OT_URL . '/assets/images/layout/left-sidebar.png'
			)
		);
	}

	return $array;
  
}

/*---------------------------------
	Insert analytics code into the footer
------------------------------------*/

if ( ! function_exists( 'krown_analytics' ) ) {

	function krown_analytics() {
		echo ot_get_option( 'krown_tracking' );
	}

}

add_filter( 'wp_footer', 'krown_analytics' );

/*---------------------------------
	Create a wp_nav_menu fallback, to show a home link
------------------------------------*/

function krown_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'krown_page_menu_args' );

/*---------------------------------
	Register widget areas
------------------------------------*/

function krown_widgets_init() {

	register_sidebar( array(
		'name' => __('Blog sidebar', 'krown'),
		'id' => 'krown_blog_widget_area',
		'description' => __('The blog/post default sidebar', 'krown'),
		'before_widget' => '<section id="%1$s" class="widget %2$s clearfix">',
		'after_widget' => '</section>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => __('IgnitionDeck sidebar', 'krown'),
		'id' => 'krown_id_widget_area',
		'description' => __('This sidebar will appear on IgnitionDeck archives pages (tags, categories, authors).', 'krown'),
		'before_widget' => '<section id="%1$s" class="widget %2$s clearfix">',
		'after_widget' => '</section>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => __('Footer first widget area', 'goodwork'),
		'id' => 'krown_footer_widget_1',
		'description' => __('The top footer\'s first widget area(1/4)', 'goodwork'),
		'before_widget' => '<section id="%1$s" class="widget %2$s clearfix">',
		'after_widget' => '</section>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => __('Footer second widget area', 'goodwork'),
		'id' => 'krown_footer_widget_2',
		'description' => __('The top footer\'s second widget area(2/4)', 'goodwork'),
		'before_widget' => '<section id="%1$s" class="widget %2$s clearfix">',
		'after_widget' => '</section>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => __('Footer third widget area', 'goodwork'),
		'id' => 'krown_footer_widget_3',
		'description' => __('The top footer\'s third widget area(3/4)', 'goodwork'),
		'before_widget' => '<section id="%1$s" class="widget %2$s clearfix">',
		'after_widget' => '</section>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => __('Footer fourth widget area', 'goodwork'),
		'id' => 'krown_footer_widget_4',
		'description' => __('The top footer\'s fourth widget area(4/4)', 'goodwork'),
		'before_widget' => '<section id="%1$s" class="widget %2$s clearfix">',
		'after_widget' => '</section>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => __('Footer\'s bottom first widget area', 'goodwork'),
		'id' => 'krown_footer_widget_5',
		'description' => __('The footer\'s bottom stripe first widget area(1/2)', 'goodwork'),
		'before_widget' => '<div id="%1$s" class="widget left %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<span class="hidden">',
		'after_title' => '</span>',
	) );

	register_sidebar( array(
		'name' => __('Footer\'s bottom second widget area', 'goodwork'),
		'id' => 'krown_footer_widget_6',
		'description' => __('The footer\'s bottom stripe second widget area(2/2)', 'goodwork'),
		'before_widget' => '<div id="%1$s" class="widget right %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<span class="hidden">',
		'after_title' => '</span>',
	) );

}  

add_action( 'widgets_init', 'krown_widgets_init' );

/*---------------------------------
	Remove "Recent Comments Widget" Styling
------------------------------------*/

function krown_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'krown_remove_recent_comments_style' );

/*---------------------------------
	Function that replaces the default the_excerpt function
------------------------------------*/

if ( ! function_exists( 'krown_excerptlength_post' ) ) {

	// Length (words no)
	 
	function krown_excerptlength_post() {
	    return 15;
	}

}

if ( ! function_exists( 'krown_excerptlength_post_big' ) ) {

	// Length (words no)
	 
	function krown_excerptlength_post_big() {
	    return 80;
	}

}

if ( ! function_exists( 'krown_excerptmore' ) ) {

	// More text

	function krown_excerptmore() {
	    return ' ...';
	}

}

function complete_excerpt( ) {

}

if ( ! function_exists( 'krown_excerpt' ) ) {

	// The actual function
	
	function krown_excerpt( $length_callback = '', $more_callback = 'krown_excerptmore' ) {

	    global $post;
		
	    if ( function_exists( $length_callback ) ) {
			add_filter( 'excerpt_length', $length_callback );
	    }
		
	    if ( function_exists( $more_callback ) ){
			add_filter( 'excerpt_more', $more_callback );
	    }
		
	    $output = get_the_excerpt();

	    if ( empty( $output ) ) {

	    	// If the excerpt is empty (on pages created 100% with shortcodes), we should take the content, strip shortcodes, remove all HTML tags, then return the correct number of words

	    	$output = strip_tags( preg_replace( "~(?:\[/?)[^\]]+/?\]~s", '', $post->post_content ) );
	    	$output = explode( ' ', $output, $length_callback() );
	    	array_pop( $output );
	    	$output = implode( ' ', $output ) . $more_callback();

	    } else {

	    	// Continue with the regular excerpt method

		    $output = apply_filters( 'wptexturize', $output );
		    $output = apply_filters( 'convert_chars', $output );

	    }
		
	    return $output;
		
	}   

}

/*--------------------------------
	Function that returns all categories of a custom post
------------------------------------*/

function krown_categories( $post_id, $taxonomy, $delimiter = ', ', $get = 'name', $echo = true, $link = false ){
	
	$tags = wp_get_post_terms( $post_id, $taxonomy );
	$list = '';
	foreach( $tags as $tag ){
		if ( $link ) {
			$list .= '<a href="' . get_category_link( $tag->term_id ) . '"> ' . $tag->$get . '</a>' . $delimiter;
		} else {
			$list .= $tag->$get . $delimiter;
		}
	}

	if ( $echo ) {
		echo substr( $list, 0, strlen($delimiter)*(-1) );
	} else { 
		return substr( $list, 0, strlen($delimiter)*(-1) );
	}

}

/*---------------------------------
	Redefine the search form structure
------------------------------------*/

if ( ! function_exists( 'krown_search_form' ) ) {

	function krown_search_form( $form ) {

	    $form = '
		<form role="search" method="get" id="searchform" class="hover-show" action="' . home_url( '/' ) . '" >
			<label class="screen-reader-text hidden" for="s">' . __( 'Search for:', 'krown' ) . '</label>
			<input type="search" value="" name="s" id="s" placeholder="' . __( 'Type and hit enter', 'krown' ) . '" />
			<input id="submit_s" type="submit" />
	    </form>';
	    return $form;
		
	}

}

add_filter( 'get_search_form', 'krown_search_form' );

/*---------------------------------
	Return the title of the current page (if any)
------------------------------------*/

if ( ! function_exists( 'krown_check_page_title' ) ) {

	function krown_check_page_title() {

		global $post;

		$page_title = $page_subtitle = '';

		if ( is_404() ) {

			// 404
			$page_title = __( '404', 'krown' );
			$page_subtitle = __( 'Page Not Found', 'krown' );

		} else if ( is_search() ) {

			// Search
			$page_title = __( 'Search Results', 'krown' );
			$page_subtitle = __( 'For', 'krown' ) . ' "' . get_search_query() . '"';

		} else if ( is_page_template( 'template-slider.php' ) ) {

			// Page with slider
			$page_title = '';

		} else {

			// Regular pages

			$page_title = get_the_title();
			$page_subtitle = get_post_meta( $post->ID, 'krown_page_subtitle', true );

			// Portfolio posts vs Blog posts
			if( is_singular( 'ignition_product' ) ) {

				$page_title = get_the_title( $post->ID );

			} else if ( is_singular( 'post' ) ) {

				$page_title = get_the_title( $post->ID );
				$page_subtitle = '<aside class="post-meta">
					<ul>
						<li class="date"><a href="' . get_permalink() . '"><time pubdate datetime="' . get_the_time( 'c' ) . '">' . get_the_time( __( 'F j, Y', 'krown' ) ) . '</time></a></li>
						<li class="comments"><a href="' . get_permalink() . '#comments">' . __( 'Comments', 'krown' ) . ' ' . get_comments_number( '0', '1', '%' ) . '</a></li>
					</ul>
				</aside>';

			}

			// Archives

			if ( is_category() ) {

				$page_title = __( 'Categories Archives', 'krown' );
				$page_subtitle = get_category( get_query_var( 'cat' ) )->name;

			} else if ( is_author() ) {

				$page_title = __( 'Author Archives', 'krown' );
				$page_subtitle = get_userdata( get_query_var( 'author' ) )->display_name;

			} else if ( is_tag() ) {

				$page_title = __( 'Tags Archives', 'krown' );
				$page_subtitle = single_tag_title( '', false );

			} else if ( is_day() ) {

				$page_title = __( 'Daily Archives', 'krown' );
				$page_subtitle = get_the_date();

			} else if ( is_month() ) {

				$page_title = __( 'Monthly Archives', 'krown' );
				$page_subtitle = get_the_date( 'F Y' );

			} else if ( is_year() ) {

				$page_title = __( 'Yearly Archives', 'krown' );
				$page_subtitle = get_the_date( 'Y' );

			} else if ( get_query_var( 'taxonomy' ) == 'project_category' ) {

				$page_title = __( 'Categories Archives', 'krown' );
				$page_subtitle = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) )->name; 

			} else if ( is_archive() ) {

				$page_title = __( 'Archives', 'krown' );

			}

		}

		// Return by case
		if ( $page_title != '' ) {
			return '<header id="page-title"><h1 class="title">' . $page_title . '</h1>' . ( $page_subtitle != '' ? '<h2 class="subtitle">' . $page_subtitle . '</h2>' : '' ) . '</header>';
		} else {
			return '';
		}

	}

}

/*---------------------------------
	Custom header
------------------------------------*/

if ( ! function_exists( 'krown_custom_header' ) ) {

	function krown_custom_header() {

		global $post;

		$output = '';

		if ( isset( $post ) ) {

			$header_type = get_post_meta( $post->ID, 'krown_custom_header_set', true );

			if ( ! is_search() ) {

				if ( is_page_template( 'template-slider.php' ) && ( $header_type == 'w-custom-header-image' || $header_type == 'w-custom-header-slider' || $header_type == 'w-custom-header-html' ) ) {

					// Get values

					$header_height = get_post_meta( $post->ID, 'krown_custom_header_height', true );

					// Configure header object based on type

					$output .= '<div id="custom-header" class="header-below"' . ( $header_type != 'w-custom-header-slider' ? ' style="height:' . $header_height . 'px"' : '' ) . '>';

					if ( $header_type == 'w-custom-header-image' ) {
						$output .= '<div class="header-image" style="background-image:url(' . get_post_meta( $post->ID, 'krown_custom_header_img', true ) . '); height:' . $header_height . 'px"></div>';

					} else if ( $header_type == 'w-custom-header-slider' ) {
						$output .= do_shortcode( get_post_meta( $post->ID, 'krown_custom_header_slider', true ) );
					} else if ( $header_type == 'w-custom-header-html' ) {

						$ctas = get_post_meta( $post->ID, 'krown_custom_header_cta', true );

						if ( ! empty( $ctas ) ) {

							$ctawidth = 100 / sizeof( $ctas );

							foreach ( $ctas as $cta ) {

								$output .= '<div class="cta" style="width:' . $ctawidth . '%"><div class="cta-back" style="background-image:url(' . $cta['image'] . ')"></div>' . '<div class="cta-holder"><h2>' . $cta['text'] . '</h2><div class="cta-link"><a class="krown-button custom" href="' . $cta['b_link'] . '" target="' . $cta['b_target'] . '">' . $cta['b_label'] . '</a></div></div></div>';

							} 

						}

					}

					$output .= '</div>';

					// Add custom tabs if present

					$custom_tabs = get_post_meta( $post->ID, 'krown_custom_header_slider_complex', true );

					if ( ! empty( $custom_tabs ) && $header_type == 'w-custom-header-slider' ) {

						preg_match( "/(revapi.+;)/", $output, $matches );
						if ( ! empty( $matches[0] ) ) {
							$api = str_replace( array( ';', "\n" ), '', $matches[0] );
						}

						$output .= '<div id="custom-tabs"><ul class="wrapper clearfix">';
						$size_class = ' style="width:' . ( 100 / sizeof( $custom_tabs ) ) . '%"';

						foreach ( $custom_tabs as $tab ) {
							$output .= '<li' . $size_class . '><h4>' . $tab['title'] . '</h4>';
							if ( $tab['icon'] != 'icon-none' ) {
								$output .= '<i class="krown-' . $tab['icon'] . '"></i>';
							}
							$output .= '</li>';
						}

						$output .= '</ul></div>';

						$output .= '<script type="text/javascript">
							var $ = jQuery.noConflict();
							$(document).ready(function(){

								var $revTabs = $("#custom-tabs").find("li");

								' . $api . '.on("revolution.slide.onchange", function(e, data){
									$revTabs.removeClass("selected");
									$revTabs.eq(data.slideIndex-1).addClass("selected");
								});

								$revTabs.click(function(){
									' . $api . '.revshowslide($(this).index()+1);
								});

							});
						</script>';

					}

				}

			}

		}

		echo $output;

	}

}

/*---------------------------------
	Custom login logo
------------------------------------*/

function krown_custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image: url(' . ot_get_option( 'krown_custom_login_logo_uri', get_template_directory_uri() . '/images/krown-login-logo.png' ) . ') !important; background-size: 273px 63px !important; width: 273px !important; height: 63px !important; }
    </style>';
}

add_action( 'login_head', 'krown_custom_login_logo' );

/*---------------------------------
	Custom sidebars for pages
------------------------------------*/

if ( ! function_exists( 'krown_sidebar' ) ) {

	function krown_sidebar() {

		global $post;

		if ( is_singular( 'portfolio' ) ) {

			$page_id = isset( $_GET['id'] ) && $_GET['id'] != '' ? $_GET['id'] : get_option( 'krown_portfolio_page' );

			if ( get_post_meta( $page_id, 'krown_page_layout', true ) == 'left-sidebar' || get_post_meta( $page_id, 'krown_page_layout', true ) == 'right-sidebar' ) {

				krown_sidebar_output( get_post_meta( $page_id, 'krown_sidebar_set', true ) );

			}

		} else if ( ( is_search() || is_archive() ) && isset( $_GET['post_type'] ) && $_GET['post_type'] == 'ignition_product' ) {

			krown_sidebar_output( 'krown_id_widget_area' );

		} else if ( ( is_singular( 'post' ) || is_search() || is_archive() || is_page_template( 'template-blog.php' ) ) && get_option( 'krown_blog_layout', 'no-sidebar' ) != 'no-sidebar' ) {

			krown_sidebar_output( 'krown_blog_widget_area' );

		} else if ( isset( $post ) && ( get_post_meta( $post->ID, 'krown_page_layout', true ) == 'left-sidebar' || get_post_meta( $post->ID, 'krown_page_layout', true ) == 'right-sidebar' ) ) {

			krown_sidebar_output( get_post_meta( $post->ID, 'krown_sidebar_set', true ) );

		}

	}

}

if ( ! function_exists( 'krown_sidebar_output' ) ) {

	function krown_sidebar_output( $id ) {

		if ( is_active_sidebar( $id ) ) {

			echo '<aside id="sidebar"> ';
			dynamic_sidebar( $id );
			echo '</aside>';

		}

	}

}

/*---------------------------------
	Add sidebar class (useful for styling)
------------------------------------*/

function krown_sidebar_class() {

	global $post;

	if ( is_singular( 'portfolio' ) ) {

		return 'layout-' . get_post_meta( isset( $_GET['id'] ) && $_GET['id'] != '' ? $_GET['id'] : get_option( 'krown_portfolio_page' ), 'krown_page_layout', true );

	} else if ( is_singular( 'post' ) || is_archive() || is_search() || is_page_template( 'template-blog.php' ) ) {

		return 'layout-' . get_option( 'krown_blog_layout' );

	} else if ( isset( $post ) && $post->post_type == 'page' ) {

		return 'layout-' . get_post_meta( $post->ID, 'krown_page_layout', true );

	}

}

/*---------------------------------
	Fix empty search issue
------------------------------------*/

function krown_request_filter( $query_vars ) {

    if( isset( $_GET['s'] ) && empty( $_GET['s'] ) ) {
        $query_vars['s'] = " ";
    }

    return $query_vars;
}

add_filter('request', 'krown_request_filter');

/*---------------------------------
	Sharing buttons
------------------------------------*/

if ( ! function_exists( 'krown_share_buttons' ) ) {

	function krown_share_buttons( $post_id ) {

		global $post;

		$html = '<aside class="share-buttons clearfix">';

		$html .= '<p>' . __( 'Share this', 'krown' ) . ' ' . ( is_singular( 'ignition_product' ) ? __( 'project', 'krown' ) : __( 'post', 'krown' ) ) . '</p>';

		$html .= '<div class="holder clearfix">';

		$url = urlencode( get_permalink( $post_id ) );
		$title = urlencode( get_the_title( $post_id ) );
		$media = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'large' );

		$html .= '<a target="_blank" class="btn-twitter" href="https://twitter.com/home?status=' . $title . '+' . $url . '"></a>';

		$html .= '<a target="_blank" class="btn-facebook" href="https://www.facebook.com/share.php?u=' . $url . '&title=' . $title . '"></a>';

		//$html .= '<a target="_blank" class="btn-pinterest" href="http://pinterest.com/pin/create/bookmarklet/?media=' . $media[0] . '&url=' . $url . '&is_video=false&description=' . $title . '"></a>';

		$html .= '<a target="_blank" class="btn-gplus" href="https://plus.google.com/share?url=' . $url . '"></a>';

		$html .= '</div></aside>';

		echo $html;

	}

}

/*---------------------------------
	Enqueue front scripts
------------------------------------*/

function krown_enqueue_scripts() {

	global $post;

	wp_deregister_style( 'wp-mediaelement' );
	wp_deregister_script( 'wp-mediaelement' );
	wp_deregister_script( 'wp-playlist' );

	// Register some js libraries

	wp_register_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array( 'jquery' ), NULL, true );
	wp_register_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?sensor=false', NULL, true );
	wp_register_script( 'wp-playlist', get_template_directory_uri() . '/js/mejs-gw-playlist.min.js', array( 'wp-util', 'backbone', 'mediaelement' ), NULL, true );

	// Enqueue theme scripts based on page templates and shortcodes. I haven't used "has_shortcode()" because that function doesn't work with nested shortcodes

	if ( isset( $post ) ) {

		if ( is_singular( 'ignition_product' ) || strpos( $post->post_content, '[gallery' ) >= 0 ) {
			wp_enqueue_script( 'flexslider' );
		}

		if ( is_page_template( 'template-contact.php' ) ) {
			wp_enqueue_script( 'google-maps' );
		}

		if ( strpos( $post->post_content, '[playlist') >= 0 ) {
			wp_enqueue_script( 'wp-playlist' );
		}

	}

	// Enqueue the rest of libraries all the time, since they are used almost on any page

	wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', array( 'jquery' ), NULL, true );
	wp_enqueue_script( 'fancybox', get_template_directory_uri().'/js/jquery.fancybox.pack.js', array('jquery'), NULL, true );
	wp_enqueue_script( 'theme_plugins', get_template_directory_uri().'/js/plugins.min.js', array('jquery'), NULL, true );
	wp_enqueue_script( 'theme_scripts', get_template_directory_uri().'/js/scripts.min.js', array('theme_plugins'), NULL, true );
	wp_enqueue_script( 'wp-mediaelement', get_template_directory_uri().'/js/mediaelement-and-player.min.js', array('theme_plugins'), NULL, true  );


	// Enqueue styles

	wp_enqueue_style( 'krown-style-parties', get_template_directory_uri() . '/css/third-parties.css' );
	wp_enqueue_style( 'krown-style', get_stylesheet_uri() );

	// Handle comments script

	if ( is_single() || is_page() ) {
		wp_enqueue_script( 'comment-reply' );
	} else {
		wp_dequeue_script( 'comment-reply' );
	}
	
	// We need to pass some useful variables to the theme scripts through the following function

	$colors = get_option( 'krown_colors' );

	wp_localize_script(
		'theme_scripts', 
		'themeObjects',
		array(
			'base' 		=> get_template_directory_uri(),
			'mainColor'	=> $colors['main1'],
			'pieColor1' => $colors['pie1'],
			'pieColor2' => $colors['pie2'],
			'pieColor3' => $colors['pie3']
		)
	);

}

add_action( 'wp_enqueue_scripts', 'krown_enqueue_scripts', 100 );

/*---------------------------------
	Enqueue admin styles
------------------------------------*/

function krown_admin_scripts() {
	wp_enqueue_style( 'krown-admin', get_template_directory_uri() . '/css/admin-style.css' );
}

add_action( 'admin_enqueue_scripts', 'krown_admin_scripts' );

/*---------------------------------
	Custom styling for TinyMCE
------------------------------------*/

// Add a series of predefined text types

if ( ! function_exists( 'krown_mce_custom_styles' ) ) {

	function krown_mce_custom_styles($settings) {

	    $settings['theme_advanced_blockformats'] = 'p,h1,h2,h3,h4';

	    $style_formats = array(
	        array('title' => 'Extreme', 'inline' => 'span', 'classes' => 'extreme'),
	        array('title' => 'Large', 'inline' => 'span', 'classes' => 'large'),
	        array('title' => 'Medium', 'inline' => 'span', 'classes' => 'medium'),
	        array('title' => 'Regular', 'inline' => 'span', 'classes' => 'regular'),
	        array('title' => 'Small', 'inline' => 'span', 'classes' => 'small'),
	        array('title' => 'Cite', 'inline' => 'cite', 'classes' => '')
	    );

	    $settings['style_formats'] = json_encode( $style_formats );

	    return $settings;
	    
	}

}

add_filter('tiny_mce_before_init', 'krown_mce_custom_styles');

// Customize TinyMCE editor font sizes

if ( ! function_exists( 'krown_mce_text_sizes' ) ) {

	function krown_mce_text_sizes( $initArray ){
		$initArray['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 18px 21px 24px 28px 32px 36px";
		return $initArray;
	}

}

add_filter( 'tiny_mce_before_init', 'krown_mce_text_sizes' );

// Add new buttons to the TinyMCE interface

if ( ! function_exists( 'krown_mce_buttons' ) ) {

	function krown_mce_buttons( $buttons ) {

		array_unshift( $buttons, 'fontsizeselect' );
    	array_unshift( $buttons, 'styleselect');
		return $buttons;
	}

}

add_filter( 'mce_buttons_2', 'krown_mce_buttons' );

/*---------------------------------
    Update Notice
------------------------------------*/

add_action( 'admin_notices', 'krown_update_notice' );

function krown_update_notice() {

	if ( get_option( 'krown_koncept_version' ) != '1.1' ) {

        echo '<div class="updated" style="position: relative;">
        	<h4>You have just updated to version 1.1 - <a style="text-decoration" href="' . admin_url( 'themes.php?page=ot-theme-options&krown_update_done_do=1#section_log' ) . '">Read the CHANGELOG</a></h4>';

        printf(__('<em style="position: absolute; top: 18px; right: 20px;"><a href="%1$s">Dismiss</a></em>'), '?krown_update_done_do=1');

        echo "<p></p></div>";

	}

}
add_action( 'admin_init', 'krown_update_done_do' );

function krown_update_done_do() {
	global $current_user;
    $user_id = $current_user->ID;
    if ( isset( $_GET['krown_update_done_do'] ) && '1' == $_GET['krown_update_done_do'] ) {
        update_option( 'krown_koncept_version', '1.1' );
	}
}

/*---------------------------------
    Navigation Walker
------------------------------------*/

class Krown_Nav_Walker extends Walker_Nav_Menu {

    function start_lvl( &$output, $depth=0, $args=array() ) {
    	if ( $depth == 0 ) {
        	$output .= '<div class="sub-menu-holder"><ul class="sub-menu">';
    	} else if ( $depth == 1 ) {
        	$output .= '<div class="third-menu-holder"><ul class="third-menu">';
    	}
    }

    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ){

        $id_field = $this->db_fields['id'];

        if ( is_object( $args[0] ) ) {
            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
        }

        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );

    }

    function start_el( &$output, $object, $depth=0, $args=array(), $current_object_id=0 ) {

        global $wp_query;
        global $rb_submenus;

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $new_output = '';
        $depth_class = ( $args->has_children ? 'parent ' : '' );

        $class_names = $value = $selected_class = '';
        $classes = empty( $object->classes ) ? array() : ( array ) $object->classes;

        $current_indicators = array('current-menu-item', 'current-menu-parent', 'current_page_item', 'current_page_parent', 'current-menu-ancestor');

        foreach ( $classes as $el ) {
            if ( in_array( $el, $current_indicators ) ) {
                $selected_class = 'selected ';
            }
        }

        $class_names = ' class="' . $selected_class . $depth_class . 'menu-item' . ( ! empty( $classes[0] ) ? ' ' . $classes[0] : '' ) . '"';

        if ( ! get_post_meta( $object->object_id , '_members_only' , true ) || is_user_logged_in() ) {
            $output .= $indent . '<li id="menu-item-'. $object->ID . '"' . $class_names . '>';
        }

        $attributes  = ! empty( $object->attr_title ) ? ' title="'  . esc_attr( $object->attr_title ) .'"' : '';
        $attributes .= ! empty( $object->target )     ? ' target="' . esc_attr( $object->target     ) .'"' : '';
        $attributes .= ! empty( $object->xfn )        ? ' rel="'    . esc_attr( $object->xfn        ) .'"' : '';
        $attributes .= ! empty( $object->url )        ? ' href="'   . esc_attr( $object->url        ) .'"' : '';

        $object_output = $args->before;
        $object_output .= '<a' . $attributes . '>';
        $object_output .= $args->link_before . apply_filters( 'the_title', $object->title, $object->ID ) . $args->link_after;
        $object_output .= '</a>';
        $object_output .= $args->after;

        if ( !get_post_meta( $object->object_id, '_members_only' , true ) || is_user_logged_in() ) {

            $output .= apply_filters( 'walker_nav_menu_start_el', $object_output, $object, $depth, $args );

        }

        $output .= $new_output;

    }

    function end_el(&$output, $object, $depth=0, $args=array()) {

        if ( !get_post_meta( $object->object_id, '_members_only' , true ) || is_user_logged_in() ) {
            $output .= "</li>\n";
        }

    }
    
    function end_lvl(&$output, $depth=0, $args=array()) {

        $output .= "</ul></div>\n";

    }

}

?>