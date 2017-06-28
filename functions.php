<?php
/**
 * anar functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package anar
 */

if ( ! function_exists( 'anar_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function anar_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on anri, use a find and replace
	 * to change 'anri' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'anar', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'anar' ),
	) );
    
    
    function anri_main_menu_callback(){
	?>
	<nav class="main-nav">
        <ul class="main-nav__items">
          <li class="main-nav__item  main-nav__item--active">
            <a href="<?php echo home_url(); ?>">Home</a>
          </li>
        </ul>
    </nav>
    <?php }
    
    require_once(__DIR__.'/inc/class.menus.php');
    require_once(__DIR__.'/inc/class.comment-walker.php');
    

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'anri_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'anar_setup' );

// post view function 

function postview( $id, $echo = false ){
	$view = get_post_meta( $id, 'post_view', true);

	if( $view == NULL ){
		$view = 0;
	}

	$view++;

	update_post_meta( $id, 'post_view', $view );

	if( $echo == false ){
		return $view;
	}else{
		echo $view;
	}
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function anar_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'anri_content_width', 640 );
}
add_action( 'after_setup_theme', 'anar_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function anri_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'anri' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'anri' ),
		'before_widget' => '<div class="sidebar-widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );
    
    register_widget('Anri_About_Widget');
    register_widget('Social_Share');
    register_widget('Popular_post');
    register_widget('Anri_tag');
}
add_action( 'widgets_init', 'anri_widgets_init' );



class Anri_About_Widget extends WP_Widget {
    
    public function __construct(){
    parent::__construct('about_me', 'About Me', array(
        'description' => 'Author Information Box contained with title, image and details'
    ));
    }
    
    public function Widget($about_1,$about_2){
        echo $about_1['before_widget'];
            echo $about_1['before_title'].$about_2['title'].$about_1['after_title']; ?>
                <div class="sidebar-widget__about-me">
                    <div class="sidebar-widget__about-me-image">
                      <img src="<?php echo $about_2['author_box_image']; ?>" alt="<?php echo $about_2['title']; ?>">
                    </div>
                    <p><?php echo $about_2['about_desc']; ?></p>
	            </div>
        <?php echo $about_1['after_widget'];
    }
    
    public function form($about_3){?>
           
        <div class="widget_field" style="margin: 10px 0;">
			<label for="<?php echo $this->get_field_id('title'); ?>">Title: </label>
			<input type="text" value="<?php echo $about_3['title']; ?>" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" class="widefat">
		</div>
		
		<div class="widget_field" style="margin: 10px 0;">
			<button class="button button-secondary" id="author_info_image">Upload Image</button>
			<input type="hidden" name="<?php echo $this->get_field_name('author_box_image'); ?>"  class="image_er_link" value="<?php echo $about_3['author_box_image']; ?>" />
			<div class="image_show" style="margin: 10px 0;">
				<img src="<?php echo $about_3['author_box_image']; ?>" width="300" height="auto" alt="">
			</div>
		</div>
		
		<div class="widget_field" style="margin: 10px 0;">
			<label for="<?php echo $this->get_field_id('about_desc'); ?>">Author Bio</label>
			<textarea style="margin: 10px 0;" name="<?php echo $this->get_field_name('about_desc'); ?>" id="<?php echo $this->get_field_id('about_desc'); ?>" class="widefat" rows="16" cols="20"><?php echo $about_3['about_desc']; ?></textarea>
		</div>
		
	<?php 
	}
    
    
	public function update( $new, $old ){

		$value = array();

		$value['title'] = strip_tags( $new['title'] );

		$value['author_box_image'] = strip_tags( $new['author_box_image'] );

		$value['about_desc'] = strip_tags( $new['about_desc'] );


		return $value;


	}

}

class Social_Share extends WP_Widget {
    public function __construct(){
    parent::__construct('social_share', 'Social Share', array(
        'description' => 'All of the social links will be added here'
    ));
    }
    
    public function Widget ($social1,$social2){
        echo $social1['before_widget'];
          echo $social1['before_title'].'Follow Me'.$social1['after_title']; ?>
          <div class="sidebar-widget__follow-me">
            <div class="sidebar-widget__follow-me-icons">
              <a href="<?php echo $social2['facebook_url']; ?>">
                <svg>
                  <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#facebook"></use>
                </svg>
              </a>
              <a href="<?php echo $social2['twitter_url']; ?>">
                <svg>
                  <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#twitter"></use>
                </svg>
              </a>

            </div>
          </div>
        <?php echo $social1['after_widget']; ?>
        <?php 
    }
    
    public function form($instance){
		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: </label><input type="text" class="widefat" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo $instance['title']; ?>"></p>

			<p><label for="<?php echo $this->get_field_id('facebook_url'); ?>">Facebook URL: </label><input type="text" class="widefat" name="<?php echo $this->get_field_name('facebook_url'); ?>" id="<?php echo $this->get_field_id('facebook_url'); ?>" value="<?php echo $instance['facebook_url']; ?>"></p>

			<p><label for="<?php echo $this->get_field_id('twitter_url'); ?>">Twitter URL: </label><input type="text" class="widefat" name="<?php echo $this->get_field_name('twitter_url'); ?>" id="<?php echo $this->get_field_id('twitter_url'); ?>" value="<?php echo $instance['twitter_url']; ?>"></p>

			
		<?php 
	}

	public function update($new_instance, $old_instance){

		$instance = array();

		$instance['title'] = strip_tags( $new_instance['title'] );

		$instance['facebook_url'] = esc_url( strip_tags( $new_instance['facebook_url'] ) );

		$instance['twitter_url'] = esc_url( strip_tags( $new_instance['twitter_url'] ) );


		return $instance;

	}
   
}

class Popular_post extends WP_Widget {
    public function __construct(){
        parent:: __construct('popupar_post','Popular Post', array(
            'description'   =>'The most popular post are shon in this widget according to post view',
        ));
    }
    
    public function Widget ($popular_1, $popular_2) {
        echo $popular_1['before_widget'];
        echo $popular_1['before_title'].$popular_2['title'].$popular_1['after_title']; ?>
        <div class="sidebar-widget__popular">
      	<?php 

      		$popular = new WP_Query(array(
      			'post_type' 		=> 'post',
      			'posts_per_page' 	=> $popular_2['count'],
      			'meta_key' 			=> 'post_view',
      			'orderby'			=> 'meta_value_num',
      			'order'				=> 'DESC'
      		));

      	 ?>

      	<?php while($popular->have_posts()) : $popular->the_post(); ?>
        <div class="sidebar-widget__popular-item">
          <div class="sidebar-widget__popular-item-image">
            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
          </div>
          <div class="sidebar-widget__popular-item-info">
            <div class="sidebar-widget__popular-item-date">
              <span><?php the_time('F d, Y'); ?></span>
            </div>
            <div class="sidebar-widget__popular-item-content">
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </div>
          </div>
        </div>
    	<?php endwhile; ?>

        
      </div>
    
	<?php echo $popular_1['after_widget'];
    }
    
    public function form($instance){
		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: </label><input type="text" class="widefat" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo $instance['title']; ?>"></p>
			
			<p><label for="<?php echo $this->get_field_id('count'); ?>">How Many Posts?</label><input type="number" class="widefat" name="<?php echo $this->get_field_name('count'); ?>" id="<?php echo $this->get_field_id('count'); ?>" value="<?php echo $instance['count']; ?>"></p>
		<?php 
	}
   
}

class Anri_tag extends WP_Widget_Tag_Cloud {
    	public function widget( $args, $instance ) {
		$current_taxonomy = $this->_get_current_taxonomy($instance);
		if ( !empty($instance['title']) ) {
			$title = $instance['title'];
		} else {
			if ( 'post_tag' == $current_taxonomy ) {
				$title = __('Tags');
			} else {
				$tax = get_taxonomy($current_taxonomy);
				$title = $tax->labels->name;
			}
		}

		/**
		 * Filters the taxonomy used in the Tag Cloud widget.
		 *
		 * @since 2.8.0
		 * @since 3.0.0 Added taxonomy drop-down.
		 *
		 * @see wp_tag_cloud()
		 *
		 * @param array $args Args used for the tag cloud widget.
		 */
		$tag_cloud = wp_tag_cloud( apply_filters( 'widget_tag_cloud_args', array(
			'taxonomy' => $current_taxonomy,
			'echo' => false
		) ) );

		if ( empty( $tag_cloud ) ) {
			return;
		}

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		echo '<div class="sidebar-widget__tag-cloud">';

		echo $tag_cloud;

		echo "</div>\n";
		echo $args['after_widget'];
	}
}

/**
 * Enqueue scripts and styles.
 */
function anri_scripts() {
	wp_enqueue_style( 'anri-style', get_stylesheet_uri() );
    wp_enqueue_style( 'main_style', get_template_directory_uri() . '/assets/css/style.min.css');
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css');

	wp_enqueue_script( 'anri-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'script', get_template_directory_uri() . '/assets/js/script.js', array(), ' ', true );

	wp_enqueue_script( 'anri-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'anri_scripts' );


// admin panel custom script 



function anri_admin_custom_scripts(){

	wp_enqueue_media();

	wp_enqueue_script('admin_custom_script',get_template_directory_uri().'/assets/js/admin_script.js', array('jquery'), '', true);

}

add_action('admin_enqueue_scripts', 'anri_admin_custom_scripts');


add_filter('comment_class','new_comment_class');

function new_comment_class($default){
    $default[] = 'single-post__comments-item';
    return $default;
}

add_action( 'comment_form_before',function(){
    echo  '<div class="single-post__comments-respond">' ;
} );
add_action( 'comment_form_after',function(){
    echo  '</div>' ;
} );

add_action('comment_post', 'notun_comment_field_mobile', 10, 2);

function notun_comment_field_mobile($comment_id, $approved){

	$mobile_number = isset( $_REQUEST['mobile'] ) ? $_REQUEST['mobile'] : '';

	update_comment_meta($comment_id, 'comment_mobile', $mobile_number);

}






/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
