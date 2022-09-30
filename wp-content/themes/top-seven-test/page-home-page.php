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

	$query = "SELECT * FROM {$wpdb->posts} WHERE post_type = 'slider_home' AND post_status = 'publish'";

	$slides = $wpdb->get_results($query); ?>
	<div class="slider__home">
		<?php
		foreach ($slides as $slide) {

			$image = get_post_meta($slide->ID, $key = 'slide_img', true);
			$image_attributes = wp_get_attachment_image_src($image, $size = 'full');
			$src = $image_attributes[0];

			$slide_text = get_post_meta($slide->ID, $key = 'slide_text', true);
			$slide_text = apply_filters('the_content', $slide_text);
			$slide_text = preg_split('/\r\n|\r|\n/', $slide_text);
			$slide_text = array_map('strip_tags', $slide_text);

			$slide_button_text = get_post_meta($slide->ID, $key = 'slide_button_text', true);
			$slide_button_link = get_post_meta($slide->ID, $key = 'slide_button_link', true);

		?>
			<div class="slide">
				<div class="slide__img">
					<img src="<?php echo $src; ?>" alt="" width="100%" height="100%">
				</div>
				<div class="slide__content">
					<div class="slide__text">
						<?php foreach ($slide_text as $string_text) {
							if ($string_text) {
								echo '<p>' . $string_text . '</p>';
							}
						} ?>
					</div>
					<?php
					if ($slide_button_text) { ?>

						<div class="slide__button button">
							<?php
							if ($slide_button_link) { ?>
								<a href="<?php echo $slide_button_link; ?>"><?php echo $slide_button_text; ?></a>
							<?php } else { ?>
								<a href="#modal__form"><?php echo $slide_button_text; ?></a>
							<?php } ?>
						</div>

					<?php } ?>
				</div>
			</div>
		<?php } ?>
	</div>
	<?php wp_reset_query(); ?>

	<div class="about-us">

		<?php

		$id = get_queried_object_id();

		$title = get_post_meta($id, $key = 'about_us_block_title', true);
		$title = apply_filters('the_content', $title);
		$title = preg_split('/\r\n|\r|\n/', $title);
		$title = array_map('strip_tags', $title);

		$content = get_post_meta($id, $key = 'about_us_content', true);
		$content = apply_filters('the_content', $content);

		$video = get_post_meta($id, $key = 'about_us_video', true);
		preg_match('%(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video, $youTubeMatch);

		?>

		<div class="about-us__title block-title">
			<?php
			foreach ($title as $title_string) {
				if ($title_string) {
					echo '<p>' . $title_string . '</p>';
				}
			}

			?>
		</div>

		<div class="about-us__content">
			<div class="about-us__content-text">
				<?php echo $content ?>
				<div class="button">
					<a href="">learn more</a>
				</div>

			</div>
			<div class="about-us__content-video">
				<div class="video">

					<div class="video__preview">
						<img id="video__img" src="https://i.ytimg.com/vi/<?php echo $youTubeMatch[1]; ?>/hqdefault.jpg" alt="">

					</div>
					<button class="video__button">&#9658;</button>
				</div>
			</div>

		</div>

	</div>
	<?php wp_reset_query(); ?>

	<div class="pricing-table">
		<div class="pricing-table__title block-title">
			<p>price</p>
			<p>pricing table</p>
		</div>

		<div class="tariffs-plan">


			<?php

			global $wpdb;

			$query = "SELECT * FROM {$wpdb->posts} WHERE post_type = 'tariff_plan' AND post_status = 'publish'";

			$tariffs = $wpdb->get_results($query);

			foreach ($tariffs as $tariff) {

				$tariff_title = $tariff->post_title;

				$link = $tariff->guid;

				$price = get_post_meta($tariff->ID, $key = 'price_tariff_plan', true);

				$options = get_post_meta($tariff->ID, $key = 'tariff_plan_options', true);
				$options = apply_filters('the_content', $options);
				$options = preg_split('/\r\n|\r|\n/', $options);
				$options = array_map('strip_tags', $options);

			?>
				<div class="tariff">
					<div class="tariff__title">
						<?php echo '<p>' . $tariff_title . '</p>'; ?>
					</div>
					<div class="tariff__price">
						<?php echo '<p>$ ' . $price . '</p>'; ?>
						<p><span>/ month</span></p>
					</div>
					<div class="tariff__options">
						<?php
						foreach ($options as $option) {
							if ($option) {
								echo '<p>' . $option . '</p>';
							}
						}
						?>
					</div>

					<div class="tariff__button button">
						<a href="<?php echo $link ?>">choose</a>
					</div>

					<?php

					?>
				</div>
			<?php
			}

			?>
		</div>
	</div>
	<?php wp_reset_query(); ?>
	<div class="contact-form">
		<div class="contact-form__title block-title">
			<p>CONTACT US</p>
			<p>our agency located in Melbourne, Australia</p>
		</div>
		<div class="contact-form__form">
			<?php //echo do_shortcode('[contact-form-7 id="94" title="Contact form 1"]'); 
			?>

			<?php echo do_shortcode('[contact-form-7 id="95" title="Untitled"]'); ?>

		</div>
	</div>







</main><!-- #main -->

<?php

get_footer();
