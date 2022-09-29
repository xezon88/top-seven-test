<?php
/**
 * The template for displaying home page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * Template name: Home page
 * 
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package top-seven-test
 */

get_header();
?>

	<main id="primary" class="site-main">

	<?php 
	global $wpdb;
	$query = "SELECT * FROM {$wpdb -> posts} WHERE post_type = 'slider_home' AND post_status = 'publish'";
	$p = $wpdb -> get_results( $query );
	 print_r( $p ); echo '</br></br></br></br>' ;

	 foreach ($p as $post) {
		echo '<br>';
		print_r($post);
		
		echo '</br>';
		print_r(get_post_meta($post->ID, $key = '', true));
		
		echo '</br>';
		echo '</br>';

		$value = get_post_meta($post->ID, $key = 'slide_img', true);


		$image_attributes = wp_get_attachment_image_src($value, $size = 'full');
		print_r($image_attributes);
		$src = $image_attributes[0];

		?> 
		<img src="<?php echo $src?>" alt="" width="100%" height="100%">
		
		<?php

		echo '</br>';
		echo '</br>';

		$text = get_post_meta($post->ID, $key = 'slide_text', true);

		
        echo apply_filters( 'the_content', $text );


		echo '</br>';
		echo '</br>';
		echo '</br>';
		echo '</br>';
	 }
	?>


	
		<?php
		
			the_post();

			
		?>

	</main><!-- #main -->

<?php

get_footer();
