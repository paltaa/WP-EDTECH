<?php

// This file contains sidebar information.

add_action( 'admin_init', 'krown_meta_boxes' );

//global $sidebars_array;

function krown_meta_boxes() {

/*---------------------------------
    INIT SOME USEFUL VARIABLES
    ------------------------------------*/
    
  $sidebars = ot_get_option('krown_sidebars');
  $sidebars_array = array();
  $sidebars_k = 0;
  if(!empty($sidebars)){
      foreach($sidebars as $sidebar){
          $sidebars_array[$sidebars_k++] = array(
              'label' => $sidebar['title'],
              'value' => $sidebar['id']
          );
      }
  }



  $krown_idp_featured_meta = array(
    'id'        => 'krown_idp_featured_meta',
    'title'     => 'Featured',
    'desc'      => '',
    'pages'     => array( 'ignition_product' ),
    'context'   => 'side',
    'priority'  => 'core',
    'fields'    => array(
        array(
          'label' => '',
          'id' => 'krown_idp_featured',
          'type' => 'radio',
          'desc' => 'Mark this project as featured (only for projects grid shortcode - doesn\'t add anything visual).',
          'std' => 'no-boxed',
          'choices' => array(
            array(
                'value' => '0',
                'label' => 'Not featured'
                ),
            array(
                'value' => '1',
                'label' => 'Featured'
                )
            )
          )

      )
    );

  $krown_page_options_2 = array(
    'id'        => 'krown_page_options_2',
    'title'     => 'Page layout',
    'desc'      => '',
    'pages'     => array( 'page' ),
    'context'   => 'side',
    'priority'  => 'high',
    'fields'    => array(

        array(
        'id'          => 'krown_page_layout',
        'label'       => 'Select layout',
        'desc'        => '',
        'std'         => 'fixed-width',
        'type'        => 'radio',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'fixed-width',
            'label'       => 'No Sidebar',
          ),
          array(
            'value'       => 'right-sidebar',
            'label'       => 'Right Sidebar',
          ),
          array(
            'value'       => 'left-sidebar',
            'label'       => 'Left Sidebar',
          )
        )
        ),

        array(
          'id'          => 'krown_sidebar_set',
          'label'       => 'Select sidebar',
          'desc'        => '',
          'std'         => '',
          'type'        => 'sidebar-select',
          'class'       => ''
          ),

        array(
          'label' => 'Style',
          'id' => 'krown_page_style',
          'type' => 'radio',
          'desc' => '',
          'std' => 'no-boxed',
          'choices' => array(
            array(
                'value' => 'no-boxed',
                'label' => 'Regular'
                ),
            array(
                'value' => 'boxed',
                'label' => 'Boxed'
                )
            )
          )

      )
    );

  ////////////////////

  $krown_page_slider = array(
    'id'        => 'krown_page_slider',
    'title' => 'Page Options',
    'desc' => '',
    'pages' => array( 'page' ),
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(

          array(
          'label' => 'Header type',
          'id' => 'krown_custom_header_set',
          'type' => 'select',
          'std' => 'w-custom-header-slider',
          'desc' => 'Choose whether you want to use a slider or a plain image for this page.',
          'choices' => array(
            array(
                'value' => 'w-custom-header-slider',
                'label' => 'Slider'
                ),
            array(
                'value' => 'w-custom-header-image',
                'label' => 'Image'
                ),
            array(
                'value' => 'w-custom-header-html',
                'label' => 'Call to action'
                )
            )
          ),
        array(
          'label' => 'Header height',
          'id' => 'krown_custom_header_height',
          'type' => 'text',
          'std' => '180',
          'desc' => 'Set the height of the header (for images & cta).',
          ),
          array(
            'id'      => '_desc',
            'label'   => '<span style="display: block; color: rgb(26, 141, 247); font-size: 1.1em ! important; margin-bottom: -20px; background: none repeat scroll 0% 0% rgb(255, 255, 255);">Image Header</span>',
            'desc'    => 'These settings are dedicated to the image header type.' ,
            'std'     => '',
            'type'    => 'textblock-titled',
            'class'   => '',
            'choices' => array()
            ),

        array(
          'label' => 'Image path',
          'id' => 'krown_custom_header_img',
          'type' => 'upload',
          'desc' => 'If you want to use a static image for the header, upload it here. It needs to be wide and at least as tall as the header\'s height.',
          ),


          array(
            'id'      => '_desc',
            'label'   => '<span style="display: block; color: rgb(26, 141, 247); font-size: 1.1em ! important; margin-bottom: -20px; background: none repeat scroll 0% 0% rgb(255, 255, 255);">Slider Header</span>',
            'desc'    => 'These settings are dedicated to the slider header type.' ,
            'std'     => '',
            'type'    => 'textblock-titled',
            'class'   => '',
            'choices' => array()
            ),

        array(
          'label' => 'Slider shortcode',
          'id' => 'krown_custom_header_slider',
          'type' => 'text',
          'desc' => 'If you want to use an instance of the revolution slider as your custom header, write it\'s <strong>SHORTCODE</strong> here. Note that the slider needs to be as tall as the the header\'s height.',
          ),

          array(
            'id'      => '_desc',
            'label'   => '<span style="display: block; color: rgb(26, 141, 247); font-size: 1.1em ! important; margin-bottom: -20px; background: none repeat scroll 0% 0% rgb(255, 255, 255);">CTA Header</span>',
            'desc'    => 'These settings are dedicated to the call-to-action type.' ,
            'std'     => '',
            'type'    => 'textblock-titled',
            'class'   => '',
            'choices' => array()
            ),


        array(
            'id'          => 'krown_custom_header_cta',
            'label'       => 'CTA List',
            'desc'        => 'Use these fields to create up to four call to action boxes that will appear in the header.',
            'std'         => '',
            'type'        => 'list-item',
            'class'       => '',
            'settings'    => array(

                    array(
                      'label' => 'CTA Text',
                      'id' => 'text',
                      'type' => 'textarea-simple',
                      'desc' => 'This will be a really big title on the action box. Simple HTML is allowed, to add line breaks and maybe colored spans. <strong>The output is wrapped in a H2 tag!</strong>',
                      'std' => ''
                    ),

                array(
                    'label'       => 'Image',
                    'id'          => 'image',
                    'type'        => 'upload',
                    'desc'        => 'Upload an image for this box.',
                    'std'         => '',
                    'rows'        => '',
                    'post_type'   => '',
                    'taxonomy'    => '',
                    'class'       => ''
                    ),

                    array(
                      'label' => 'Button label',
                      'id' => 'b_label',
                      'type' => 'text',
                      'desc' => 'The label of the button which will appear here.',
                      'std' => ''
                    ),

                    array(
                      'label' => 'Button link',
                      'id' => 'b_link',
                      'type' => 'text',
                      'desc' => 'The url for the action button.',
                      'std' => ''
                    ),

                    array(
                      'label' => 'Button target',
                      'id' => 'b_target',
                      'type' => 'select',
                      'desc' => 'The target for the action button.',
                      'std' => '_self',
                      'choices' => array(
                      		array(
                      			'value' => '_self',
                      			'label' => 'Same window'
                      		),
                      		array(
                      			'value' => '_blank',
                      			'label' => 'New window'
                      		)
                      	)
                    )

                )
            )


        )
    );



$krown_contact_meta = array(
    'id'        => 'krown_contact_meta',
    'title' => 'Map Options',
    'desc' => 'Use the following fields to configure this page\'s map. If you choose to hide the map, you could use a static image or slider, just like in any other page, however, if you choose to show the map, the static image will no longer appear.',
    'pages' => array( 'page' ),
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
          'label' => 'Enable map',
          'id' => 'krown_show_map',
          'type' => 'radio',
          'desc' => '',
          'std' => 'wout-custom-header-map',
          'choices' => array(
            array(
                'value' => 'w-custom-header-map',
                'label' => 'Enabled'
                ),
            array(
                'value' => 'wout-custom-header-map',
                'label' => 'Disabled'
                )
            )
          ),
        array(
          'label' => 'Map zoom level',
          'id' => 'krown_map_zoom',
          'type' => 'text',
          'desc' => 'Should be a number between 1 and 21.',
          'std' => '16'
          ),
        array(
          'label' => 'Map style',
          'id' => 'krown_map_style',
          'type' => 'radio',
          'desc' => '',
          'std' => 'true',
          'choices' => array(
            array(
                'value' => 'true',
                'label' => 'Greyscale'
                ),
            array(
                'value' => 'false',
                'label' => 'Default'
                )
            )
          ),
        array(
          'label' => 'Map latitude',
          'id' => 'krown_map_lat',
          'type' => 'text',
          'desc' => 'Enter a latitude coordinate for the map\'s center (your POI).',
          'std' => ''
          ),
        array(
          'label' => 'Map longitude',
          'id' => 'krown_map_long',
          'type' => 'text',
          'desc' => 'Enter a longitude coordinate for the map\'s center (your POI).',
          'std' => ''
          ),
        array(
          'label' => 'Show marker',
          'id' => 'krown_map_marker',
          'type' => 'radio',
          'desc' => '',
          'std' => 'true',
          'choices' => array(
            array(
                'value' => 'true',
                'label' => 'Show'
                ),
            array(
                'value' => 'false',
                'label' => 'Hide'
                )
            )
          ),
        array(
          'label' => 'Marker image',
          'id' => 'krown_map_img',
          'type' => 'upload',
          'desc' => 'Upload an image which will be the marker on your map.',
          'std' => ''
          )
        )
);



$krown_subtitle_meta = array(
    'id'        => 'krown_subtitle',
    'title'     => 'Page Subtitle',
    'desc'      => '',
    'pages'     => array( 'ignition_product', 'page' ),
    'context'   => 'normal',
    'priority'  => 'high',
    'fields'    => array(
        array(
          'label' => 'Text',
          'id' => 'krown_page_subtitle',
          'type' => 'text',
          'desc' => 'Write a subtitle which will appear below this post\'s title (optional).',
          'std' => '',
          )
      )
	);



    /*---------------------------------
        INIT METABOXES
        ------------------------------------*/

        $post_id = isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID'] : 'no');
        $template_file = $post_id != 'no' ? get_post_meta($post_id,'_wp_page_template',TRUE) : 'no';

        if($template_file == 'template-contact.php') {
            ot_register_meta_box($krown_contact_meta);
        } 

        if ( $template_file != 'template-blog.php' && $template_file != 'template-slider.php' ) {
            ot_register_meta_box($krown_page_options_2);
          }


          if ( $template_file == 'template-slider.php' ) {
          	ot_register_meta_box($krown_page_slider);
		} else {
      		ot_register_meta_box($krown_subtitle_meta);
		}
            ot_register_meta_box($krown_idp_featured_meta);


}

?>