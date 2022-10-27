<?php
add_action('init', 'register_slider_posts');

function register_slider_posts()
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
		'menu_icon'           => 'dashicons-slides',
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

function slide_text()
{
}


function slide_button_text($post_id, $value = '')
{
	if (get_post_meta($post_id, 'slide_button_link', true)) {
		$value = get_post_meta($post_id, 'slide_button_link', true);
	}
?>
	<div>
		<label for="slide_button_text">Текст - Если оставить пустым кнопка исчезнет</label>
		<input type="text" id="slide_button_text" name="slide_button_text" value="<?php echo $value; ?>" />
	</div>

<?php
}

function slide_button_link($post_id, $value = '')
{
	if (get_post_meta($post_id, 'slide_button_link', true)) {
		$value = get_post_meta($post_id, 'slide_button_link', true);
	}
?>
	<div>
		<label for="slide_button_link">Ссылка - Если оставить пустым будет открываться форма обратной связи</label>
		<input type="text" id="slide_button_link" name="slide_button_link" value="<?php echo $value; ?>" />
	</div>
<?php
}

function meta_boxes_slider_img()
{
	add_meta_box('slide-img', 'Изображение', 'print_meta_boxes_slider_img', 'slider_home', 'normal', 'high');
}

add_action('admin_menu', 'meta_boxes_slider_img');


function meta_boxes_slider_text()
{

	add_meta_box('slide-text', 'Текст слайда', 'print_meta_boxes_slider_text', 'slider_home', 'normal', 'high');
}

add_action('admin_menu', 'meta_boxes_slider_text');


function meta_boxes_slider_button()
{

	add_meta_box('slide-button', 'Текст и ссылка кнопки', 'print_meta_boxes_slider_button', 'slider_home', 'normal', 'high');
}

add_action('admin_menu', 'meta_boxes_slider_button');


function print_meta_boxes_slider_img($post)
{
	if (function_exists('select_slide_img')) {
		select_slide_img('slide_img', get_post_meta($post->ID, 'slide_img', true));
	}
}

function print_meta_boxes_slider_text($post)
{
	if (function_exists('slide_text')) {

		$content = get_post_meta($post->ID, 'slide_text', true);

		wp_editor($content, 'slide_text', array(
			'wpautop'       => 1,
			'media_buttons' => 0,
			'textarea_name' => 'slide_text', //нужно указывать!
			'textarea_rows' => 5,
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
}

function print_meta_boxes_slider_button($post)
{
	if (function_exists('slide_button_link') && function_exists('slide_button_text')) {
		slide_button_text('slide_button_text', get_post_meta($post->ID, 'slide_button_text', true));
		slide_button_link('slide_button_link', get_post_meta($post->ID, 'slide_button_link', true));
	}
}

function save_box_data_slider($post_id)
{
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}
	if ($_POST) {
		update_post_meta($post_id, 'slide_img', $_POST['slide_img']);
		update_post_meta($post_id, 'slide_text', $_POST['slide_text']);
		update_post_meta($post_id, 'slide_button_text', $_POST['slide_button_text']);
		update_post_meta($post_id, 'slide_button_link', $_POST['slide_button_link']);
		return $post_id;
	}
}

add_action('save_post', 'save_box_data_slider');
