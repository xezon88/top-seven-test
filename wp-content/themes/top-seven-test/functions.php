<?php

/**
 * top-seven-test functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package top-seven-test
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function top_seven_test_setup()
{
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on top-seven-test, use a find and replace
		* to change 'top-seven-test' to the name of your theme in all the template files.
		*/
	load_theme_textdomain('top-seven-test', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support('title-tag');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'top-seven-test'),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'top_seven_test_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'top_seven_test_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function top_seven_test_content_width()
{
	$GLOBALS['content_width'] = apply_filters('top_seven_test_content_width', 640);
}
add_action('after_setup_theme', 'top_seven_test_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function top_seven_test_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'top-seven-test'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'top-seven-test'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'top_seven_test_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function top_seven_test_scripts()
{
	wp_enqueue_style('top-seven-test-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('top-seven-test-style', 'rtl', 'replace');

	wp_enqueue_script('top-seven-test-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	wp_enqueue_script('jquery', get_template_directory_uri() . '/js/jquery.min.js', array(), _S_VERSION, true);


	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'top_seven_test_scripts');

function top_seven_test_scripts_admin()
{

	wp_enqueue_script('jquery', get_template_directory_uri() . '/js/jquery.min.js', array(), _S_VERSION, true);


	wp_enqueue_media();


	wp_enqueue_script('admin-scripts', get_template_directory_uri() . '/js/admin-scripts.js', array(),  _S_VERSION, true);
}
add_action('admin_enqueue_scripts', 'top_seven_test_scripts_admin');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}



add_action('init', 'register_post_types');

function register_post_types()
{

	register_post_type('slider_home', [
		'label'  => 'Слайды',
		'labels' => [
			'name'               => 'Слайды', // основное название для типа записи
			'singular_name'      => 'Слайд', // название для одной записи этого типа
			'add_new'            => 'Добавить слайд', // для добавления новой записи
			'add_new_item'       => 'Добавить слайд', // заголовка у вновь создаваемой записи в админ-панели.
			'all_items'     => 'Все слайды',
			'edit_item'          => 'Редактировать слайд', // для редактирования типа записи
			'new_item'           => 'Новый слайд', // текст новой записи
			'menu_name'          => 'Слайдер', // название меню
		],
		'description'         => '',
		'public'              => true,
		'show_in_menu'        => true, // показывать ли в меню адмнки
		'show_in_rest'        => null, // добавить в REST API. C WP 4.7
		'rest_base'           => null, // $post_type. C WP 4.7
		'menu_position'       => 12,
		'menu_icon'           => 'dashicons-embed-photo',
		'hierarchical'        => false,
		'supports'            => ['title'], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		'taxonomies'          => [],
		'has_archive'         => false,
		'rewrite'             => true,
		'query_var'           => true,
	]);
}

function select_slide_img($name, $value = '', $w = 100, $h = 300)
{
	$default = get_template_directory_uri() . '/img/noimg.jpeg';
	if ($value) {
		$image_attributes = wp_get_attachment_image_src($value, array($w, $h));
		$src = $image_attributes[0];
	} else {
		$src = $default;
	}
	echo '
    <div class="select_image_button">
        <img data-src="' . $default . '" src="' . $src . '" width="' . $w . '%" height="' . $h . 'px" />
        <div>
            <input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $value . '" />
            <button type="submit" class="select_image_button button">Выбрать</button>
            <button type="submit" class="remove_image_button button">&times;</button>
        </div>
    </div>
	
    ';
}

function slide_text() {
	?>
	
	<textarea name="slide_text" id="slide_text" cols="100" rows="10"></textarea>
	
	<?php
}

function meta_boxes_slider_img()
{
	add_meta_box('slide-img', 'Изображение', 'print_meta_boxes_slider_img', 'slider_home', 'normal', 'high');
	//add_meta_box('slide-text', 'Текст слайда', 'print_meta_boxes_slider', 'slider_home', 'normal', 'high');
	//add_meta_box('slide-button', 'Текст и ссылка кнопки', 'print_meta_boxes_slider', 'slider_home', 'normal', 'high');
}

add_action('admin_menu', 'meta_boxes_slider_img');


function meta_boxes_slider_text()
{
	//add_meta_box('slide-img', 'Изображение', 'print_meta_boxes_slider', 'slider_home', 'normal', 'high');
	add_meta_box('slide-text', 'Текст слайда', 'print_meta_boxes_slider_text', 'slider_home', 'normal', 'high');
	//add_meta_box('slide-button', 'Текст и ссылка кнопки', 'print_meta_boxes_slider', 'slider_home', 'normal', 'high');
}

add_action('admin_menu', 'meta_boxes_slider_text');

/*
 * Заполняем метабокс
 */
function print_meta_boxes_slider_img($post)
{
	if (function_exists('select_slide_img')) {
		select_slide_img('slide_img', get_post_meta($post->ID, 'slide_img', true));
	}
}

function print_meta_boxes_slider_text($post)
{
	if (function_exists('slide_text')) {
		//slide_text('slide_text', get_post_meta($post->ID, 'slide_text', true));
		$content = get_post_meta($post->ID, 'slide_text', true);
		wp_editor( $content, 'slide_text', array() );
	}
}

/*
 * Сохраняем данные произвольного поля
 */
function save_box_data_slider($post_id)
{
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}
	if ($_POST) {
		update_post_meta($post_id, 'slide_img', $_POST['slide_img']);
		return $post_id;
	}

	if(isset($_POST['slide_text'])){
        update_post_meta($post_id, 'slide_text', $_POST['slide_text']);
    }
}

add_action('save_post', 'save_box_data_slider');
