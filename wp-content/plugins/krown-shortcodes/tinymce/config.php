<?php

$current_theme = wp_get_theme();
if ( file_exists( $current_theme->get_template_directory() . '/includes/krown-shortcodes-config.php' ) ) {
	include_once( $current_theme->get_template_directory() . '/includes/krown-shortcodes-config.php' );
}

/* ------------------------
-----   Accordion    -----
------------------------------*/

if ( ! isset( $krown_shortcodes['accordion'] ) ) {

	$krown_shortcodes['accordion'] = array(
	    'params' => array(
	    	'type' => array(
	            'std' => 'accordion',
	            'type' => 'select',
	            'label' => __('Type', 'textdomain'),
	            'desc' => __('The type of the current shortcode. An accordion can only have one section opened at a given time, while the toggles allow you to open or close all sections at once.', 'textdomain'),
				'options' => array(
					'accordion' => 'Accordion',
					'toggle' => 'Toggle'
				)
			),
	    	'size' => array(
	            'std' => 'large',
	            'type' => 'select',
	            'label' => __('Size', 'textdomain'),
	            'desc' => __('The size of the current shortcode. There are only small differences between the two.', 'textdomain'),
				'options' => array(
					'large' => 'Large',
					'small' => 'Small'
				)
			),
			'opened' => array(
	            'std' => '0',
	            'type' => 'text',
	            'label' => __('Opened', 'textdomain'),
	            'desc' => __('You can choose which of the sections will be opened at load. "0" is the first, while "-1" will leave all sections closed.', 'textdomain')
			)
	    ),
	    'no_preview' => true,
	    'shortcode' => '[krown_accordion type="{{type}}" size="{{size}}" opened="{{opened}}"] {{child_shortcode}} [/krown_accordion]',
	    'popup_title' => __('Insert Accordion', 'textdomain'),
	    'child_shortcode' => array(
	        'params' => array(
	            'title' => array(
	                'std' => 'Title',
	                'type' => 'text',
	                'label' => __('Section Title', 'textdomain'),
	                'desc' => __('Title of the accordion section.', 'textdomain'),
	            ),
	            'content' => array(
	                'std' => '',
	                'type' => 'textarea',
	                'label' => __('Section Content', 'textdomain'),
	                'desc' => __('Add the accordion section content.', 'textdomain')
	            )
	        ),
	        'shortcode' => '[krown_accordion_section title="{{title}}"] {{content}} [/krown_accordion_section]',
	        'clone_button' => __('Add Section', 'textdomain')
	    )
	);

}

/* ------------------------
-----   Alert Messages    -----
------------------------------*/

if ( ! isset( $krown_shortcodes['alert'] ) ) {

	$krown_shortcodes['alert'] = array(
		'no_preview' => true,
		'params' => array(
			'type' => array(
				'type' => 'select',
				'label' => __('Alert Style', 'textdomain'),
				'desc' => __('Select the alert\'s type, ie the alert colour.', 'textdomain'),
				'options' => array(
					'info' => 'Info (blue)',
					'success' => 'Success (green)',
					'error' => 'Error (red)',
					'notice' => 'Notice (yellow)'
				)
			),
			'content' => array(
				'std' => 'Your Alert!',
				'type' => 'textarea',
				'label' => __('Alert Text', 'textdomain'),
				'desc' => __('Add the alert\'s text.', 'textdomain'),
			)
			
		),
		'shortcode' => '[krown_alert type="{{type}}"] {{content}} [/krown_alert]',
		'popup_title' => __('Insert Alert', 'textdomain')
	);

}

/* ------------------------
-----   Basic Column  -----
------------------------------*/

if ( ! isset( $krown_shortcodes['columns'] ) ) {

	$krown_shortcodes['columns'] = array(
		'params' => array(),
		'shortcode' => ' {{child_shortcode}} ', // as there is no wrapper shortcode
		'popup_title' => __('Insert Columns', 'textdomain'),
		'no_preview' => true,
		
		// child shortcode is clonable & sortable
		'child_shortcode' => array(
			'params' => array(
				'column' => array(
					'type' => 'select',
					'label' => __('Column Type', 'textdomain'),
					'desc' => __('Select the type, ie width of the column.', 'textdomain'),
					'options' => array(
						'1/1' => 'Full Width (1/1)',
						'1/3' => 'One Third (1/3)',
						'2/3' => 'Two Thirds (2/3)',
						'1/2' => 'One Half (1/2)',
						'1/4' => 'One Fourth (1/4)',
						'3/4' => 'Three Fourths (3/4)'
					)
				),
				'el_first' => array(
					'type' => 'select',
					'std' => '',
					'label' => __('First Column', 'textdomain'),
					'desc' => __('Check this if the current column is the first one in a row.', 'textdomain'),
					'options' => array(
						'' => 'No',
						'first' => 'Yes'
					)
				),
				'el_last' => array(
					'type' => 'select',
					'std' => '',
					'label' => __('Last Column', 'textdomain'),
					'desc' => __('Check this if the current column is the last one in a row.', 'textdomain'),
					'options' => array(
						'' => 'No',
						'last' => 'Yes'
					)
				),
				'content' => array(
					'std' => '',
					'type' => 'textarea',
					'label' => __('Column Content', 'textdomain'),
					'desc' => __('Add the column content.', 'textdomain'),
				)
			),
			'shortcode' => '[krown_column width="{{column}}" el_position="{{el_first}} {{el_last}}"] {{content}} [/krown_column] ',
			'clone_button' => __('Add Column', 'textdomain')
		)
	);

}

/* ------------------------
-----   Buttons    -----
------------------------------*/

if ( ! isset( $krown_shortcodes['button'] ) ) {

	$krown_shortcodes['button'] = array(
		'no_preview' => true,
		'params' => array(
			'url' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Button URL', 'textdomain'),
				'desc' => __('Add the button\'s url eg http://example.com.', 'textdomain')
			),
			'size' => array(
				'type' => 'select',
				'label' => __('Button Size', 'textdomain'),
				'desc' => __('Select the button\'s size.', 'textdomain'),
				'options' => array(
					'small' => 'Small',
					'medium' => 'Medium',
					'large' => 'Large'
				)
			),
			'style' => array(
				'type' => 'select',
				'label' => __('Button Style', 'textdomain'),
				'desc' => __('Select the button\'s style.', 'textdomain'),
				'options' => array(
					'normal' => 'Dark',
					'color' => 'Color',
					'empty' => 'Empty'
				)
			),
			'target' => array(
				'type' => 'select',
				'label' => __('Button Target', 'textdomain'),
				'desc' => __('_self = open in same window. _blank = open in new window.', 'textdomain'),
				'options' => array(
					'_self' => '_self',
					'_blank' => '_blank'
				)
			),
			'label' => array(
				'std' => 'Button Text',
				'type' => 'text',
				'label' => __('Button\'s Text', 'textdomain'),
				'desc' => __('Add the button\'s text.', 'textdomain'),
			)
		),
		'shortcode' => '[krown_button url="{{url}}" size="{{size}}" style="{{style}}" target="{{target}}" label="{{label}}"]',
		'popup_title' => __('Insert Button', 'textdomain')
	);

}

/* ------------------------
-----   Contact Form    -----
------------------------------*/

if ( ! isset( $krown_shortcodes['form'] ) ) {

	$krown_shortcodes['form'] = array(
		'no_preview' => true,
		'params' => array(
			'label_name' => array(
				'std' => 'Name',
				'type' => 'text',
				'label' => __('Name Label', 'textdomain'),
				'desc' => __('Add the text for the name input field.', 'textdomain')
			),
			'label_email' => array(
				'std' => 'Email',
				'type' => 'text',
				'label' => __('Email Label', 'textdomain'),
				'desc' => __('Add the text for the email input field.', 'textdomain')
			),
			'label_subject' => array(
				'std' => 'Subject',
				'type' => 'text',
				'label' => __('Subject Label', 'textdomain'),
				'desc' => __('Add the text for the subject input field.', 'textdomain')
			),
			'label_message' => array(
				'std' => 'Message',
				'type' => 'text',
				'label' => __('Sessage Label', 'textdomain'),
				'desc' => __('Add the text for the message input field.', 'textdomain')
			),
			'label_send' => array(
				'std' => 'Send',
				'type' => 'text',
				'label' => __('Send Button Label', 'textdomain'),
				'desc' => __('Add the text for the send button.', 'textdomain')
			),
			'email' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Recipent Email Address', 'textdomain'),
				'desc' => __('Enter the email address where you wish to receive the emails sent from this form.', 'textdomain')
			),
			'success' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Success Message', 'textdomain'),
				'desc' => __('Add a message which appears when the email was sucessfuly sent.', 'textdomain')
			),
			'error' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Error Message', 'textdomain'),
				'desc' => __('Add a message which appears when user hasn\'t complete all fields properly.', 'textdomain')
			)
		),
		'shortcode' => '[krown_form label_name="{{label_name}}" label_email="{{label_email}}"  label_subject="{{label_subject}}" label_message="{{label_message}}" label_send="{{label_send}}" email="{{email}}" success="{{success}}" error="{{error}}"]',
		'popup_title' => __('Insert Form', 'textdomain')
	);

}

/* ------------------------
-----   Flickr Feed   -----
------------------------------*/

if ( ! isset( $krown_shortcodes['flickr'] ) ) {

	$krown_shortcodes['flickr'] = array(
		'no_preview' => true,
		'params' => array(
			'id' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Flickr ID', 'textdomain'),
				'desc' => __('Enter your flickr id as it appears on: <a href="http://idgettr.com/" target="_blank">idgettr.com</a>.', 'textdomain')
			),
			'no' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Number of images', 'textdomain'),
				'desc' => __('Choose a number of images which will be taken from the feed. Max 25.', 'textdomain')
			)
		),
		'shortcode' => '[krown_flickr id="{{id}}" no="{{no}}"]',
		'popup_title' => __('Insert Flickr Feed', 'textdomain')
	);

}

/* ------------------------
-----   Icons    -----
------------------------------*/

if ( ! isset( $krown_shortcodes['icon'] ) ) {

	$krown_shortcodes['icon'] = array(
		'no_preview' => true,
		'params' => array(
            'size' => array(
                'std' => '',
                'type' => 'select',
                'label' => __('Size', 'textdomain'),
                'desc' => __('Select the icon\'s size', 'textdomain'),
				'options' => array(
					'tiny' => 'Tiny',
					'small' => 'Small',
					'medium' => 'Medium',
					'large' => 'Large'
				)
            ),
            'type' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Type', 'textdomain'),
                'desc' => __('Write the name of the icon you desire to use. A full list of icons <a href="http://demo.krownthemes.com/help/krown-shortcodes-fonts/" target="_blank">can be found here</a>.', 'textdomain')
            ),
            'color' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Color', 'textdomain'),
                'desc' => __('Write a color of the icon. It can be any <a href="http://www.w3schools.com/cssref/css_colornames.asp" target="_blank">css color name</a> or <a href="http://www.w3schools.com/cssref/css_colors_legal.asp" target="_blank">css color value</a>.', 'textdomain')
            ),
            'break' => array(
                'std' => '',
                'type' => 'select',
                'label' => __('Wrapping', 'textdomain'),
                'desc' => __('Choose how will this icon wrap against the text.', 'textdomain'),
				'options' => array(
					'float' => 'Float around text',
					'break' => 'Break text'
				)
            )
		),
		'shortcode' => '[krown_icon size="{{size}}" type="{{type}}" color="{{color}}" break="{{break}}"]',
		'popup_title' => __('Insert Promo Box', 'textdomain')
	);

}

/* ------------------------
-----   Latest Posts    -----
------------------------------*/

if ( ! isset( $krown_shortcodes['posts'] ) ) {

	$krown_shortcodes['posts'] = array(
		'no_preview' => true,
		'params' => array(
            'no' => array(
                'std' => '4',
                'type' => 'text',
                'label' => __('Posts number', 'textdomain'),
                'desc' => __('Choose how many posts will appear in this grid.', 'textdomain')
            )
		),
		'shortcode' => '[krown_latest_posts no="{{no}}"]',
		'popup_title' => __('Insert Posts Grid', 'textdomain')
	);

}

/* ------------------------
-----   Projects Grid    -----
------------------------------*/

if ( ! isset( $krown_shortcodes['projects'] ) ) {

	$krown_shortcodes['projects'] = array(
		'no_preview' => true,
		'params' => array(
            'category' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Select categories', 'textdomain'),
                'desc' => __('If you only want to show projects from certain categories, insert the category id here.', 'textdomain')
            ),
            'author' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Select author', 'textdomain'),
                'desc' => __('If you only want to show projects from a certain author, insert the author\'s username here. Only one author is allowed.', 'textdomain')
            ),
            'orderby' => array(
                'std' => 'date',
                'type' => 'select',
                'label' => __('Order by', 'textdomain'),
                'desc' => __('Choose ordering method.', 'textdomain'),
				'options' => array(
					'date' => 'Date',
					'days_left' => 'Days left',
					'percent_raised' => 'Raised percentage',
					'funds_raised' => 'Raised funds',
					'featured' => 'Featured products'
				)
            ),
            'order' => array(
                'std' => 'Desc',
                'type' => 'select',
                'label' => __('Order', 'textdomain'),
                'desc' => __('Choose ordering direction.', 'textdomain'),
				'options' => array(
					'DESC' => 'Descending',
					'ASC' => 'Ascending'
				)
            ),
            'max' => array(
                'std' => '4',
                'type' => 'text',
                'label' => __('Projects number', 'textdomain'),
                'desc' => __('Choose how many projects do you want to show in this grid. If you write <strong>-1</strong>, all filtered projects will be shown.', 'textdomain')
            ),
            'style' => array(
                'std' => 'default',
                'type' => 'select',
                'label' => __('Style', 'textdomain'),
                'desc' => __('Choose grid style.', 'textdomain'),
				'options' => array(
					'default' => 'Masonry grid',
					'carousel' => 'Carousel'
				)
            ),
            'visible' => array(
                'std' => '4',
                'type' => 'select',
                'label' => __('Carousel visible projects', 'textdomain'),
                'desc' => __('If you are using a carousel, choose the number of the projects you want to be visible at a time. The other filtered projects will be only shown on user interaction. <strong>Note that this doesn\'t affect the display, but the interaction. So if you want only three visible projects you should put the carousel in a column with a 3/4 width, and so on.', 'textdomain'),
				'options' => array(
					'4' => '4',
					'3' => '3',
					'2' => '2',
					'1' => '1'
				)
            )
		),
		'shortcode' => '[project_grid category="{{category}}" author="{{author}}" orderby="{{orderby}}" order="{{order}}" max="{{max}}" visible="{{visible}}" style="{{style}}"]',
		'popup_title' => __('Insert Projects Grid', 'textdomain')
	);

}

/* ------------------------
-----   Promo Box    -----
------------------------------*/

if ( ! isset( $krown_shortcodes['box'] ) ) {

	$krown_shortcodes['box'] = array(
		'no_preview' => true,
		'params' => array(
            'style' => array(
                'std' => 'light-1',
                'type' => 'select',
                'label' => __('Style', 'textdomain'),
                'desc' => __('Select the text box\'s style', 'textdomain'),
				'options' => array(
					'light-1' => 'Light 1',
					'light-2' => 'Light 2',
					'dark' => 'Dark',
					'color' => 'Color'
				)
            ),
            'content' => array(
                'std' => '',
                'type' => 'textarea',
                'label' => __('Box Content', 'textdomain'),
                'desc' => __('Add the box content.', 'textdomain')
            )
		),
		'shortcode' => '[krown_box el_class="{{style}}"] {{content}} [/krown_box]',
		'popup_title' => __('Insert Promo Box', 'textdomain')
	);

}

/* ------------------------
-----   Section    -----
------------------------------*/

if ( ! isset( $krown_shortcodes['section'] ) ) {

	$krown_shortcodes['section'] = array(
		'no_preview' => true,
		'params' => array(
            'background' => array(
                'type' => 'text',
                'label' => __('Background', 'textdomain'),
                'desc' => __('Write a color for the background (or a complete CSS background declaration rule). The color can be any <a href="http://www.w3schools.com/cssref/css_colornames.asp" target="_blank">css color name</a> or <a href="http://www.w3schools.com/cssref/css_colors_legal.asp" target="_blank">css color value</a>.', 'textdomain')
            ),
            'content' => array(
                'std' => '',
                'type' => 'textarea',
                'label' => __('Section Content', 'textdomain'),
                'desc' => __('Add the box content (or better, insert the shortcode and then insert your other content in the middle, because it might be more complex.', 'textdomain')
            )
		),
		'shortcode' => '[krown_section background="{{background}}"] {{content}} [/krown_section]',
		'popup_title' => __('Insert Section', 'textdomain')
	);

}

/* ------------------------
-----   Social Icons   -----
------------------------------*/

if ( ! isset( $krown_shortcodes['social'] ) ) {

	$krown_shortcodes['social'] = array(
		'params' => array(
			'target' => array(
				'type' => 'select',
				'label' => __('Icon Target', 'textdomain'),
				'desc' => __('_self = open in same window. _blank = open in new window.', 'textdomain'),
				'options' => array(
					'_self' => '_self',
					'_blank' => '_blank'
				)
			)
		),
	    'no_preview' => true,
	    'shortcode' => '[krown_social target="{{target}}"{{child_shortcode}}]',
	    'popup_title' => __('Insert Social Icons', 'textdomain'),
	    'child_shortcode' => array(
	        'params' => array(
	            'type' => array(
	                'type' => 'select',
	                'label' => __('Icon Type', 'textdomain'),
	                'desc' => __('Choose the icon\'s type (social network).', 'textdomain'),
					'options' => array(
						'behance' => 'Behance',
						'cloud' => 'Cloud',
						'delicious' => 'Delicious',
						'digg' => 'Digg',
						'dribbble' => 'Dribbble',
						'email' => 'Email',
						'evernote' => 'Evernote',
						'facebook' => 'Facebook',
						'flickr' => 'Flickr',
						'github' => 'GitHub',
						'googlecircles' => 'Google Circles',
						'gplus' => 'Google Plus',
						'lastfm' => 'Last FM',
						'linkedin' => 'LinkedIn',
						'picasa' => 'Picasa',
						'pinterest' => 'Pinterest',
						'rss' => 'RSS',
						'skype' => 'Skype',
						'stumbleupon' => 'Stumbleupon',
						'tumblr' => 'Tumblr',
						'twitter' => 'Twitter',
						'vimeo' => 'Vimeo',
						'youtube' => 'YouTube'
					)
	            ),
	            'url' => array(
	            	'std' => '',
	                'type' => 'text',
	                'label' => __('Icon Url', 'textdomain'),
	                'desc' => __('Add the url to your social profile related with the chosen icon.', 'textdomain')
	            )
	        ),
	        'shortcode' => ' {{type}}="{{url}}"',
	        'clone_button' => __('Add Icon', 'textdomain')
	    )
	);

}

/* ------------------------
-----   Tabs   -----
------------------------------*/

if ( ! isset( $krown_shortcodes['tabs'] ) ) {

	$krown_shortcodes['tabs'] = array(
	    'no_preview' => true,
	    'shortcode' => '[krown_tabs] {{child_shortcode}} [/krown_tabs]',
	    'popup_title' => __('Insert Tabs', 'textdomain'),
	    'child_shortcode' => array(
	        'params' => array(
	            'title' => array(
	                'std' => 'Title',
	                'type' => 'text',
	                'label' => __('Tab Title', 'textdomain'),
	                'desc' => __('Title of the tab.', 'textdomain'),
	            ),
	            'content' => array(
	                'std' => '',
	                'type' => 'textarea',
	                'label' => __('Tab Content', 'textdomain'),
	                'desc' => __('Add the tab content.', 'textdomain')
	            )
	        ),
	        'shortcode' => '[krown_tabs_section title="{{title}}"] {{content}} [/krown_tabs_section]',
	        'clone_button' => __('Add Tab', 'textdomain')
	    )
	);

}

/* ------------------------
-----   Team Member    -----
------------------------------*/

if ( ! isset( $krown_shortcodes['team'] ) ) {

	$krown_shortcodes['team'] = array(
		'no_preview' => true,
		'params' => array(
            'image' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Member Picture', 'textdomain'),
                'desc' => __('Use an absolute URL to a valid image file.', 'textdomain')
            ),
            'title' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Title', 'textdomain'),
                'desc' => __('Add the member\'s title.', 'textdomain')
            ),
            'subtitle' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Subtitle', 'textdomain'),
                'desc' => __('Add the member\'s subtitle.', 'textdomain')
            ),
            'content' => array(
                'std' => '',
                'type' => 'textarea',
                'label' => __('Content', 'textdomain'),
                'desc' => __('Add the member\'s content (it can be anything from some text or a social shortcode for example).', 'textdomain')
            )
		),
		'shortcode' => '[krown_team image="{{image}}" title="{{title}}" subtitle="{{subtitle}}"] {{content}} [/krown_team]',
		'popup_title' => __('Insert Team Member', 'textdomain')
	);

}

/* ------------------------
-----   Twitter Feed   -----
------------------------------*/

if ( ! isset( $krown_shortcodes['twitter'] ) ) {

	$krown_shortcodes['twitter'] = array(
		'no_preview' => true,
		'params' => array(
            'user' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Username', 'textdomain'),
                'desc' => __('Add the desired twitter username (just the name without any special symbols).', 'textdomain')
            ),
            'name' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Real Name', 'textdomain'),
                'desc' => __('Add the desired real (long) name.', 'textdomain')
            ),
            'avatar' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Avatar', 'textdomain'),
                'desc' => __('Add an absolute path to a jpg or png image, which will be your static twitter avatar on the site.', 'textdomain')
            ),
            'no' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Number of Tweets', 'textdomain'),
                'desc' => __('Choose the number of tweets to appear in the widget.', 'textdomain')
            ),
            'rotate' => array(
                'std' => '',
                'type' => 'select',
                'label' => __('Enable Rotation', 'textdomain'),
                'desc' => __('If enabled, the widget will rotate through tweets, instead of displaying all of them at once.', 'textdomain'),
				'options' => array(
					'enabled' => 'Enabled',
					'disabled' => 'Disabled'
				)
            ),
            'text_reply' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Reply Label', 'textdomain'),
                'desc' => __('Add the reply button\'s label.', 'textdomain')
            ),
            'text_retweet' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Retweet Label', 'textdomain'),
                'desc' => __('Add the retweet button\'s label.', 'textdomain')
            ),
            'text_favorite' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Favorite Label', 'textdomain'),
                'desc' => __('Add the favorite button\'s label.', 'textdomain')
            )
		),
		'shortcode' => '[krown_twitter user="{{user}}" no="{{no}}" name="{{name}}" avatar="{{avatar}}" text_reply="{{text_reply}} "text_retweet="{{text_retweet}}" text_favorite="{{text_favorite}}" rotate="{{rotate}}"]',
		'popup_title' => __('Insert Twitter', 'textdomain')
	);

}

?>