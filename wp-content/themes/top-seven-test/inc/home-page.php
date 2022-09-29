<?php

function disable_content_editor()
{
	if (isset($_GET['post'])) {
		$post_ID = $_GET['post'];
	} else if (isset($_POST['post_ID'])) {
		$post_ID = $_POST['post_ID'];
	}

	if (!isset($post_ID) || empty($post_ID)) {
		return;
	}

	$page_template = get_post_meta($post_ID, '_wp_page_template', true);
	if ($page_template == 'page-home-page.php') {
		remove_post_type_support('page', 'editor');
		remove_post_type_support('page', 'custom-fields');
		remove_post_type_support('page', 'comments');
		remove_post_type_support('page', 'slug');
		remove_post_type_support('page', 'author');
	}
}

add_action('admin_init', 'disable_content_editor');


if (isset($_GET['post'])) {
	$post_ID = $_GET['post'];
} else if (isset($_POST['post_ID'])) {
	$post_ID = $_POST['post_ID'];
}

if (!isset($post_ID) || empty($post_ID)) {
	return;
}

$page_template = get_post_meta($post_ID, '_wp_page_template', true);
if ($page_template == 'page-home-page.php') {


		function meta_boxes_about_us_block_title()
		{

			add_meta_box('about-us-block-title', 'Заголовок блока О нас', 'print_meta_boxes_about_us_block_title', 'page', 'normal', 'high');
		}

		add_action('admin_menu', 'meta_boxes_about_us_block_title');

		function meta_boxes_about_us_content()
		{

			add_meta_box('about-us-content', 'Контент', 'print_meta_boxes_about_us_content', 'page', 'normal', 'high');
		}

		add_action('admin_menu', 'meta_boxes_about_us_content');

		function meta_boxes_about_us_video() {
			add_meta_box('about-us-video', 'Видео "О нас"', 'print_meta_boxes_about_us_video', 'page', 'normal', 'high');
		}

		add_action( 'admin_menu', 'meta_boxes_about_us_video' );



		function print_meta_boxes_about_us_block_title($post)
		{

			$content = get_post_meta($post->ID, 'about_us_block_title', true);

			wp_editor($content, 'about_us_block_title', array(
				'wpautop'       => 1,
				'media_buttons' => 0,
				'textarea_name' => 'about_us_block_title', //нужно указывать!
				'textarea_rows' => 4,
				'tabindex'      => null,
				'editor_css'    => '',
				'editor_class'  => '',
				'teeny'         => 0,
				'dfw'           => 0,
				'tinymce'       => 1,
				'quicktags'     => 1,
				'drag_drop_upload' => false
			));
		}

		function print_meta_boxes_about_us_content($post)
		{

			$content = get_post_meta($post->ID, 'about_us_content', true);

			wp_editor($content, 'about_us_content', array(
				'wpautop'       => 1,
				'media_buttons' => 0,
				'textarea_name' => 'about_us_content', //нужно указывать!
				'textarea_rows' => 9,
				'tabindex'      => null,
				'editor_css'    => '',
				'editor_class'  => '',
				'teeny'         => 0,
				'dfw'           => 0,
				'tinymce'       => 1,
				'quicktags'     => 1,
				'drag_drop_upload' => false
			));
		}

		function get_about_us_video($post_id) {
			$about_us_video = get_post_meta($post_id, 'about_us_video', true);
		 
			preg_match('%(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $about_us_video, $youTubeMatch);
		 
			if ($youTubeMatch[1]) {
				?>
				<div class="video">

					<div class="video__preview">
					<img id="video__img" src="https://i.ytimg.com/vi/<?php echo $youTubeMatch[1]; ?>/hqdefault.jpg" alt="">

					</div>
					<button class="video__button">&#9658;</button>
				</div>
					
				<?php
			}
			
		}

		function print_meta_boxes_about_us_video( $post ) {
		 
			
			echo get_about_us_video( $post->ID);   
		 
			echo '<h4 style="margin: 10px 0 0 0;">Ссылка на видео</h4>';
			echo '<input type="text" id="about_us_video" name="about_us_video" value="' . get_post_meta($post->ID, 'about_us_video', true) . '" style="width: 100%;" />';
		}


		function save_box_data_home_page($post_id)
		{
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
				return $post_id;
			}
			if ($_POST) {

				update_post_meta($post_id, 'about_us_content', $_POST['about_us_content']);
				update_post_meta($post_id, 'about_us_block_title', $_POST['about_us_block_title']);
				update_post_meta( $post_id, 'about_us_video', $_POST['about_us_video'] );

				return $post_id;
			}
		}

		add_action('save_post', 'save_box_data_home_page');
	
	}