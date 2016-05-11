<?php
	
/* ------------------------
-----   Accordion   -----
------------------------------*/

function krown_accordion_function( $atts, $content ){

    extract( shortcode_atts( array(
        'el_class'  => '',
        'type'		=> 'accordion',
        'size'		=> 'large',
        'opened' 	=> '0'
    ), $atts ) );

    $html = '<div data-opened="' . $opened . '" class="krown-accordion ' . $type . ' ' . $size . ( $el_class != '' ? ' ' . $el_class : '' ) . ' clearfix">';

    $html .= do_shortcode( $content );

    $html .= '</div>';

    return $html;

}

add_shortcode( 'krown_accordion', 'krown_accordion_function' );

/* ------------------------
-----   Latest posts   -----
------------------------------*/

function krown_latest_posts_function( $atts, $content ) {
	
	extract( shortcode_atts( array(
		'el_class'  => '',
		'no' 		=> '4'
	), $atts ) );

	$html = '<div class="krown-latest-posts classic">
		<ul class="posts-grid clearfix">';

	$all_posts = new WP_Query( array(
		'post_type' => 'post',
		'posts_per_page' => $no,
	) );

	while ( $all_posts->have_posts() ) {

		$all_posts->the_post();

		global $post;
		$retina = krown_retina(); 

		$html .= '<li class="item">';

		if ( has_post_thumbnail() ) {

			$thumb = get_post_thumbnail_id();
			$img_url = wp_get_attachment_url( $thumb, 'full' ); 
			$image = aq_resize( $img_url, $retina === 'true' ? 510 : 255, $retina === 'true' ? 346 : 173, true, false );  

			$html .= '<a class="post-img fancybox-thumb" href="' . get_permalink() . '"><img src="' . $image[0] . '" width="' . $image[1]. '" height="' . $image[2] . '" alt="" /><span></span></a>';

		}

		$html .= '<a href="' . get_permalink() . '"><h3>' . get_the_title() . '</h3></a>';

		$html .= '<span class="post-cat">' . krown_categories( $post->ID, 'category', ', ', 'name', false ) . '</span>';

		$html .= '<p class="post-excerpt">' . krown_excerpt( 'krown_excerptlength_post' ) . '</p>';

		$html .= '</li>';

	}

	$html .= '</ul></div>';

	return $html;

}

add_shortcode( 'krown_latest_posts', 'krown_latest_posts_function' );

/* ------------------------
-----   Widget area   -----
------------------------------*/

function krown_widget_area_function( $atts, $content ) {

	ob_start();
	dynamic_sidebar( $atts['id'] );
	$html = ob_get_contents();
	ob_end_clean();
	return $html;

}

add_shortcode( 'krown_widget_area', 'krown_widget_area_function' );

/* ------------------------
-----   Columns   -----
------------------------------*/

function krown_section_function( $atts, $content ) {
	
	extract( shortcode_atts( array(
		'el_class'  => '',
		'background' => '#fff'
	), $atts ) );

	$html = '<div class="krown-section clearfix" style="background:' . $background . '">' . do_shortcode( $content ) . '</div>';

	return $html;

}

add_shortcode( 'krown_section', 'krown_section_function' );

function krown_column_function( $atts, $content ){
	
	extract( shortcode_atts( array(
		'el_class'  => '',
		'width' 	=> '1/1'
	), $atts ) );

	$html = '';
	
	if( isset( $atts['el_position'] ) && strpos( $atts['el_position'], 'first') !== false ) {
		$html .= '<div class="krown-column-row clearfix">';
	}

	$html .= '<div class="krown-column-container clearfix ' . ( isset( $atts['el_position'] ) ? $atts['el_position'] . ' ' : '' );

	switch( $width ) {
		case '1/1':
			$html .= 'span12';
			break;
		case '1/2':
			$html .= 'span6';
			break;
		case '1/4':
			$html .= 'span3';
			break;
		case '3/4':
			$html .= 'span9';
			break;
		case '1/3':
			$html .= 'span4';
			break;
		case '2/3':
			$html .= 'span8';
			break;
		default:
			$html .= 'span12';
	}

	$html .= ( $el_class != '' ? ' ' . $el_class : '' ) . ' clearfix">';
	$html .= do_shortcode( $content );
	$html .= '</div>';

	if( isset( $atts['el_position'] ) && strpos( $atts['el_position'], 'last') !== false ) {
		$html .= '</div>';
	}

	return $html;

}

add_shortcode( 'krown_column', 'krown_column_function' );

/* ------------------------
-----   Gallery   -----
------------------------------*/

function krown_gallery_function( $attr ) {

    global $post;

    $post = get_post();

    static $instance = 0;
    $instance++;

    if ( ! empty( $attr['ids'] ) ) {
        if ( empty( $attr['orderby'] ) ) {
            $attr['orderby'] = 'post__in';
        }
        $attr['include'] = $attr['ids'];
    }

    $html = apply_filters( 'post_gallery', '', $attr );
    if ( $html != '' ) {
        return $html;
    }

    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] ) {
            unset( $attr['orderby'] );
        }
    }

    extract( shortcode_atts( array(
        'order'          => 'ASC',
        'orderby'        => 'menu_order ID',
        'id'             => $post->ID,
        'include'        => '',
        'exclude'        => '',
        'type'           => 'thumbs',
        'columns'        => '3',
        'width'          => 'null',
        'lightbox'       => 'false',
        'grid'           => 'false'
    ), $attr ) );

    $id = intval( $id );
    if ( 'RAND' == $order ) {
        $orderby = 'none';
    }

    if ( ! empty( $include ) ) {

        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

        $attachments = array();

        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }

    } else if ( ! empty( $exclude ) ) {
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty( $attachments ) ) {
        return '';
    }

    if ( is_feed() ) {
        $html = "\n";
        foreach ( $attachments as $att_id => $attachment ) {
            $html .= wp_get_attachment_link($att_id, $size, true) . "\n";
        }
        return $html;
    }

    $slides = '';

    $thumbs_col = 100 / $columns;
    $thumbs_width = floor(1140 / $columns);

    $i = 0;

    foreach ( $attachments as $id => $attachment ) {

        $link = isset( $attr['link'] ) && 'file' == $attr['link'] ? wp_get_attachment_image_src( $id, 'full', false, false ) : wp_get_attachment_image_src( $id, 'full', true, false );

        $caption = get_post( $id )->post_excerpt;
        $title = get_post( $id )->post_title;

        $extra_class = '';
        if ( $i % $columns == 0 ) {
            $extra_class = ' first';
        }
        if ( ++$i % $columns == 0 ) {
            $extra_class = ' last';
        } 

        if ( $type == 'slider' ) {

            $slides .= '<li>';

            if ( $lightbox == 'true') {
                $slides .= '<a href="' . $link[0] . '" class="fancybox fancybox-thumb">';
            }

            if ( $grid == 'true' ) {
                $link[0] = aq_resize( $link[0], '680', null );
            }

            $slides .= '<img src="' . $link[0] . '" alt="' . $caption .'" />';


            if ( $lightbox == 'true') {
                $slides .= '</a>';
            }

            if ( isset( $caption ) && $caption != '' ) {
                $slides .= '<p class="flex-caption">'. $caption . '</p>';
            }

            $slides .= '</li>';


        } else {

            $slides .= '<a class="fancybox fancybox-thumb' . $extra_class . '" data-fancybox-group="gallery-' . $instance . '" data-fancybox-title="' . $caption . '" href="' . $link[0] . '" style="width:' . $thumbs_col . '%"><img src="' . aq_resize( $link[0], $thumbs_width, $thumbs_width, true ) . '" /></a>';

        }

    }

    if ( $type == 'slider' ) {

        $html = '<div class="flexslider mini"><ul class="slides">' . $slides . '</ul></div>';

    } else {

        $html = '<div class="krown-thumbnail-gallery clearfix">' . $slides . '</div>';

    }

    return $html;

}

remove_shortcode( 'gallery', 'gallery_shortcode' );
add_shortcode( 'gallery', 'krown_gallery_function' );

/* ------------------------
-----   Buttons   -----
------------------------------*/

function krown_button_function( $atts, $content ) { 

    extract( shortcode_atts( array(
        'el_class'  => '',
        'label' 	=> 'Button',
        'target' 	=> '_blank',
        'style'		=> 'normal',
        'size'		=> 'medium',
        'url' 		=> '#'
    ), $atts ) );

    $html = '<a class="krown-button ' . $size . ' ' . $style . ($el_class != '' ? ' ' . $el_class : '') . '" href="' . $url . '" target="' . $target . '">' . $label . '</a>';
   
   return $html;

}

add_shortcode( 'krown_button', 'krown_button_function' );

?>