<?php

function newfangled_theme_page() { 
    $title = esc_html(__('newfangled','newfangled'));  
    add_theme_page( 
        esc_html(__( 'Upgrade To newfangled Pro','newfangled')),
        $title.'<i class="fa fa-plane theme-icon"></i>', 
        'edit_theme_options',
        'newfangled_upgrade',
        'newfangled_display_upgrade'
    );
}   

add_action('admin_menu','newfangled_theme_page');

 
function newfangled_display_upgrade() {
     $theme_data = wp_get_theme('newfangled'); ?>
     <div class="newfangled-wrapper about-wrap">
        <h1><?php printf(esc_html__('Welcome to %1$s - Version %2$s', 'newfangled'), $theme_data->Name ,$theme_data->Version ); ?></h1><?php
        printf( __('<div class="about-text"> Newfangled is a free WordPress theme to use for multipurpose. It fits for business,commercial Uses and other purposes. You can use multiple sliders and Icon with services, BreadCrumb with related featured image of Post and Page. It has a Clean look of Blog view and widgetized footer. Newfangled is a responsive, Translation Ready and Customizable Options.</div>', 'newfangled') ); ?>
        <p class="about-text upgrade-btn clearfix"><?php printf( __( 'Newfangled is our first theme and me and my friend both are combined to create Newfangled. We will also like to give a PRO version for Newfangled. Help me develop the theme and provide support by <a href="%2$s">donating even a small sum</a>', 'newfangled' ), 'Newfangled', 'https://www.paypal.me/SuganyaSelvakumar' ,'joyousthemes@gmail.com'); ?></p>

        <div class="theme_info info-tab-content">
            <div class="theme_info_column clearfix">
                <div class="theme_info_left">
                    <div class="theme_link">
                        <h3><?php esc_html_e( 'Theme Customizer', 'newfangled' ); ?></h3>
                        <p class="about"><?php printf(esc_html__('%s supports the Theme Customizer for all theme settings. Click "Customize" to start customize your site.', 'newfangled'), $theme_data->Name); ?></p>
                        <p>
                            <a href="<?php echo admin_url('customize.php'); ?>" class="button button-primary"><?php esc_html_e('Start Customize', 'newfangled'); ?></a>
                        </p>
                    </div>  
                    <div class="theme_link">
                        <h3><?php esc_html_e( 'Having Trouble, Need Support?', 'newfangled' ); ?></h3>
                        <p class="about"><?php printf(esc_html__('Support for %s WordPress theme is conducted through Webulous free support ticket system.', 'newfangled'), $theme_data->Name); ?></p>
                        <p>  
                            <a href="mailto:joyousthemes@gmail.com" target="_blank" class="button button-secondary"><?php esc_html_e('Mail Us', 'newfangled'); ?></a>
                        </p>
                    </div> 
                </div>  
                <div class="theme_info_right">
                    <img src="<?php echo get_template_directory_uri(); ?>/screenshot.png" alt="Theme Screenshot" />
                </div>
            </div>
        </div>
    </div><?php
}        

	$options = array(
		'capability' => 'edit_theme_options',
		'type' => 'theme_mod',
		'panels' => apply_filters( 'newfangled_customizer_options', array(
			'newfangled' => array(
				'priority'       => 9,
				'title'          => __('Theme Options', 'newfangled'),
				'description'    => __('Theme Options', 'newfangled'),
				'sections' => array(
					'general' => array(
						'title' => __('General', 'newfangled'),
						'description' => __('General settings that affects overall site', 'newfangled'),
						'fields' => array(
							'breadcrumb_section' => array(
								'type' => 'checkbox',
								'label' => __('Enable Breadcrumb Section', 'newfangled'),
								'default' => 1,
								'sanitize_callback' => 'newfangled_boolean',
							),
							'breadcrumb' => array(
								'type' => 'checkbox',
								'label' => __('Enable Breadcrumb', 'newfangled'),
								'default' => 1,
								'sanitize_callback' => 'newfangled_boolean',
							),
							'breadcrumb_bg' => array(
								'type' => 'image',
								'label' => __('Breadcrumb Background Image', 'newfangled'),
								'default' => get_template_directory_uri() .'/images/breadcrumb.png',
							    'sanitize_callback' => 'esc_url_raw',
							),
							'breadcrumb_char' => array(
								'type' => 'select',
								'label' => __('Select Breadcrumb Character', 'newfangled'),
								'choices' => array(
									'1' => '&raquo;',
									'2' => '&#47;',
									'3' => '&gt;'
								),
								'sanitize_callback' => 'newfangled_breadcrumb_char_choices',
								'default' => '1',
							),
							 'numeric_pagination' => array(
                                'type' => 'checkbox',
                                'label' => __('Enable Numeric Page Navigation', 'newfangled'),
                                'description' => __('Check to display numeric page navigation, instead of Previous Posts / Next Posts links.', 'newfangled'),
                                'default' => 1, 
                                'sanitize_callback' => 'newfangled_boolean', 
                            ),
                            'sidebar_position' => array(
                                'type' => 'radio',
                                'label' => __('Website Layout Options', 'newfangled'),
                                'description' => __('Select main content and sidebar alignment.', 'newfangled'),
                                'choices' => array(
                                    'left' => __('Sidebar Left', 'newfangled'),
                                    'right' => __('Sidebar Right', 'newfangled'),
                                    'fullwidth' => __('Full Width', 'newfangled'),
                                    'no-sidebar' => __('No Sidebar', 'newfangled'),
                                ),
                                'default' => 'right',  
                                'sanitize_callback' => 'sanitize_text_field', 
                            ),
						),
					),
					'header' => array(
						'title' => __('Header', 'newfangled'),
						'description' => __('Header options', 'newfangled'),
						'fields' => array(
							'logo_title' => array(
								'type' => 'checkbox',
								'label' => __('Logo as Title', 'newfangled'),
								'default' => 0,
								'sanitize_callback' => 'newfangled_boolean',
							),
							'tagline' => array(
								'type' => 'checkbox',
								'label' => __('Show site Tagline', 'newfangled'),
								'default' => 1,
								'sanitize_callback' => 'newfangled_boolean',
							),
						),
					),
					'footer' => array(
						'title' => __('Footer', 'newfangled'),
						'description' => __('Footer related options', 'newfangled'),
						'fields' => array(
							'footer_widgets' => array(
								'type' => 'checkbox',
								'label' => __('Footer Widget Area', 'newfangled'),
								'default' => 1,
								'sanitize_callback' => 'newfangled_boolean',
							),
							'copyright' => array(
                                'type' => 'textarea',
                                'label' => __('Footer Copyright Text (Validated that it\'s HTML Allowed)', 'newfangled'),
                                'description' => __('HTML Allowed. <b>This field is even HTML validated! </b>', 'newfangled'),
                                'sanitize_callback' => 'newfangled_footer_copyright',
                            ),
						),
					),
					'home' => array(
						'title' => __('Home', 'newfangled'),
						'description' => __('Home Page options', 'newfangled'),
						'fields' => array(
							'slider_field' => array(   
								'type' => 'checkbox',
								'label' => __('Enable Home Page Slider Section', 'newfangled'),
								'default' => 1,
								'sanitize_callback' => 'newfangled_boolean',
							),
							'slider_cat' => array(
								'type' => 'category',
								'label' => __('Slider Posts Category', 'newfangled'),
								'sanitize_callback' => 'absint',
							),
							'slider_count' => array(
								'type' => 'text',
								'label' => __('No. of Sliders', 'newfangled'),
								'sanitize_callback' => 'absint',
								'default' => 3,
							),
							'service_field' => array(   
								'type' => 'checkbox',
								'label' => __('Enable Home Page Service Section', 'newfangled'),
								'default' => 1,
								'sanitize_callback' => 'newfangled_boolean',
							),
							'service_title' => array(   
								'type' => 'text',
								'label' => __('Enter your section title', 'newfangled'),
								'default' => 'Our Services',
							),
							'service_section_icon_1' => array(  
								'type' => 'icons-picker',
								'label' => __('Choose Service Section Icons #1', 'newfangled'),
								'sanitize_callback' => 'esc_html',
							),  
							'service_1' => array(
								'type' => 'dropdown-pages',
								'label' => __('Service Section #1', 'newfangled'),
								'sanitize_callback' => 'absint',
							), 
							'service_color_1' => array( 
								'type' => 'color',
								'label' => __('Service #1 Color', 'newfangled'),
								'default' => '#ff6600',
								'sanitize_callback' => 'sanitize_hex_color',
							),
							'service_section_icon_2' => array(
								'type' => 'icons-picker',
								'label' => __('Choose Service Section Icons #2', 'newfangled'),
								'sanitize_callback' => 'sanitize_text_field',
							),
							'service_2' => array(
								'type' => 'dropdown-pages',
								'label' => __('Service Section #2', 'newfangled'),
								'sanitize_callback' => 'absint',
							),
							'service_color_2' => array( 
								'type' => 'color',
								'label' => __('Service #2 Color', 'newfangled'),
								'default' => '#79b458',  
								'sanitize_callback' => 'sanitize_hex_color',
							), 
							'service_section_icon_3' => array( 
								'type' => 'icons-picker',
								'label' => __('Choose Service Section Icons #3', 'newfangled'),
								'sanitize_callback' => 'esc_html',
							),
							'service_3' => array(
								'type' => 'dropdown-pages',
								'label' => __('Service Section #3', 'newfangled'),
								'sanitize_callback' => 'absint',
							),
							'service_color_3' => array( 
								'type' => 'color',
								'label' => __('Service #3 Color', 'newfangled'),
								'default' => '#8080ff',
								'sanitize_callback' => 'sanitize_hex_color',
							),  
							'image_content_section_status' => array(   
								'type' => 'checkbox',
								'label' => __('Check this box to Show Image section', 'newfangled'),
								'default' => 1,
								'sanitize_callback' => 'newfangled_boolean',
							),
							'image_content_section_1' => array(
								'type' => 'dropdown-pages',
								'label' => __('Image content Section #1', 'newfangled'),
								'sanitize_callback' => 'absint',
							),
							'image_content_section_2' => array(
								'type' => 'dropdown-pages',
								'label' => __('Image content Section #2', 'newfangled'),
								'sanitize_callback' => 'absint',
							), 
							'enable_recent_post_service' => array(
                                'type' => 'checkbox',
                                'label' => __('Enable Home Page Recent Post Section', 'newfangled'),
                                'default' => 1,
                                'sanitize_callback' => 'newfangled_boolean',  
                            ), 
                            'recent_post_title' => array(   
								'type' => 'text',
								'label' => __('Enter your section title', 'newfangled'),
								'default' => 'Read our Blog Posts',
							),
							'recent_posts_count' => array(
								'type' => 'text',
								'label' => __('No. of Recent Posts', 'newfangled'),
								'sanitize_callback' => 'absint',
								'default' => 3,  
							), 
							'enable_home_default_content' => array(
                                'type' => 'checkbox',
                                'label' => __('Enable Home Page Default Content', 'newfangled'),
                                'default' => 0,  
                                'sanitize_callback' => 'newfangled_boolean',
                            ),
						),
					),
					'blog' => array(
						'title' => __('Blog', 'newfangled'),
						'description' => __('Blog Related Posts options', 'newfangled'),
						'fields' => array(
							'featured_image' => array(  
								'type' => 'checkbox',
								'label' => __('Enable Featured Image', 'newfangled'),
								'default' => 1,
								'sanitize_callback' => 'newfangled_boolean',
							),
                           'featured_image_size' => array(
                                'type' => 'radio',
                                'label' => __('Choose the featured image display type for Blog Page ', 'newfangled'),
                                'choices' => array(
                                    '1' => __('Large Featured Image', 'newfangled'),
                                    '2' => __('Small Featured Image', 'newfangled'),        
                                ),
                                'default' => '1', 
                                'sanitize_callback' => 'absint',
                            ),
							'single_featured_image' => array(
								'type' => 'checkbox',
								'label' => __('Enable Single Post Featured Image', 'newfangled'),
								'default' => 0,
								'sanitize_callback' => 'newfangled_boolean',
							),
                            'single_featured_image_size' => array(
                                'type' => 'radio',
                                'label' => __('Choose the featured image display type for Single Page ', 'newfangled'),
                                'choices' => array(
                                    '1' => __('Large Featured Image', 'newfangled'),
                                    '2' => __('Small Featured Image', 'newfangled'),       
                                ),
                                'default' => '1', 
                                'sanitize_callback' => 'absint',  
                            ),
                             'author_bio_box' => array(
                                'type' => 'checkbox',
                                'label' => __(' Enable Author Bio Box below single post', 'newfangled'),
                                'description' => __('Show Author information box below single post.', 'newfangled'),
                                'default' => 0,
                                'sanitize_callback' => 'newfangled_boolean',    
                            ),
                            'related_posts' => array(
                                'type' => 'checkbox',
                                'label' => __('Show Related posts', 'newfangled'),
                                'description' => __('Show related posts.', 'newfangled'),
                                'default' => 0, 
                                'sanitize_callback' => 'newfangled_boolean', 
                            ),
                            'related_posts_hierarchy' => array(
                                'type' => 'radio',
                                'label' => __('Related Posts Must Be Shown As:', 'newfangled'),
                                'choices' => array(
                                    '1' => __('Related Posts By Tags', 'newfangled'),
                                    '2' => __('Related Posts By Categories', 'newfangled'),      
                                ),
                               'default' => '1', 
                               'sanitize_callback' => 'absint',    
                            ),
                            'comments' => array(
                                'type' => 'checkbox',
                                'label' => __(' Show Comments', 'newfangled'),
                                'description' => __('Show Comments', 'newfangled'),
                                'default' => 1,  
                                'sanitize_callback' => 'newfangled_boolean',
                            ),
						),
					),

				)
			),
		) 
	)
	);

function newfangled_boolean($value) {
	if(is_bool($value)) {
		return $value;
	} else {
		return false;
	}
}

function newfangled_breadcrumb_char_choices($value='') {
	$choices = array('1','2','3');

	if( in_array($value, $choices)) {
		return $value;
	} else {
		return '1';
	}
}

if ( ! function_exists( 'newfangled_footer_copyright' ) ) {

    function newfangled_footer_copyright($string) {
        $allowed_tags = array(    
                            'a' => array(
                            	'href' => array(),
								'title' => array(),
								'target' => array(),
                            ),
							'img' => array(
								'src' => array(),  
								'alt' => array(),
							),
							'p' => array(),
							'br' => array(),
							'em' => array(),
                            'strong' => array(),
        );
        return wp_kses( $string,$allowed_tags);

    }
}

