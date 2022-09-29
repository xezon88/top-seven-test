<?php 
add_action('init', 'register_tariff_plan');

function register_tariff_plan()
{

	register_post_type('tariff_plan', [
		'label'  => 'Тарифные планы',
		'labels' => [
			'name'               => 'Тарифные планы', // основное название для типа записи
			'singular_name'      => 'Тарифный план', // название для одной записи этого типа
			'add_new'            => 'Добавить тарифный план', // для добавления новой записи
			'add_new_item'       => 'Добавить тарифный план', // заголовка у вновь создаваемой записи в админ-панели.
			'all_items'    		 => 'Все тарифные планы',
			'edit_item'          => 'Редактировать тарифный план', // для редактирования типа записи
			'new_item'           => 'Новый тарифный план', // текст новой записи
			'menu_name'          => 'Тарифные планы', // название меню
		],
		'description'         => '',
		'public'              => true,
		'show_in_menu'        => true, // показывать ли в меню адмнки
		'show_in_rest'        => null, // добавить в REST API. C WP 4.7
		'rest_base'           => null, // $post_type. C WP 4.7
		'menu_position'       => 13,
		'menu_icon'           => 'dashicons-list-view',
		'hierarchical'        => false,
		'supports'            => ['title'], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		'taxonomies'          => [],
		'has_archive'         => false,
		'rewrite'             => true,
		'query_var'           => true,
	]);
}



function price_tariff_plan( $post_id, $value = '')
{
	if (get_post_meta($post_id, 'price_tariff_plan', true)) {
		$value = get_post_meta($post_id, 'price_tariff_plan', true);	
	}
?>
	<div>
		<input type="text" id="price_tariff_plan" name="price_tariff_plan" value="<?php echo $value;?>" />
	</div>
	
<?php
}

function meta_boxes_tariff_plan_price()
{

	add_meta_box('tariff-plan-price', 'Цена тарифного плана', 'print_meta_boxes_tariff_plan_price', 'tariff_plan', 'normal', 'high');
}

add_action('admin_menu', 'meta_boxes_tariff_plan_price');

function meta_boxes_tariff_plan_options()
{
	
	add_meta_box('tariff-plan-options', 'Опции тарифного плана', 'print_meta_boxes_tariff_plan_options', 'tariff_plan', 'normal', 'high');
	
}

add_action('admin_menu', 'meta_boxes_tariff_plan_options');


function print_meta_boxes_tariff_plan_options($post)
{
	if (function_exists('slide_text')) {

		$content = get_post_meta($post->ID, 'tariff_plan_options', true);

		wp_editor($content, 'tariff_plan_options', array(
			'wpautop'       => 1,
			'media_buttons' => 0,
			'textarea_name' => 'tariff_plan_options', //нужно указывать!
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
}

function print_meta_boxes_tariff_plan_price($post)
{
	if (function_exists('price_tariff_plan')) {
		price_tariff_plan('price_tariff_plan', get_post_meta($post->ID, 'price_tariff_plan', true));
	
	}
}

function save_box_data_tariff_plan($post_id)
{
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}
	if ($_POST) {

		update_post_meta($post_id, 'tariff_plan_options', $_POST['tariff_plan_options']);
		update_post_meta($post_id, 'price_tariff_plan', $_POST['price_tariff_plan']);
	
		return $post_id;
	}
}

add_action('save_post', 'save_box_data_tariff_plan');