<?php
/**
 * The template for displaying landing page.
 *
 * @package Shape
 * @since Shape 1.0
 */
get_header();
?>
	<header>
		<?php
		if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<?php

			$values     = get_post_custom( $post->ID );
			$html_title = isset( $values['houstonapps_heading1'] ) ? $values["houstonapps_heading1"][0] : '';
			$heading2   = isset( $values['houstonapps_heading2'] ) ? $values["houstonapps_heading2"][0] : '';

			if ( $html_title ) { ?>
				<h1><?php echo $html_title; ?></h1>
			<?php } else { ?>
				<h1><?php the_title(); ?></h1>
			<?php } ?>


			<?php
			if ( $heading2 ) { ?>
				<h2><?php echo $heading2; ?></h2>
			<?php } ?>

			<?php the_content(); ?>

		<?php endwhile;
		else:
			// no posts found
		endif;
		?>

		<button data-hnd-toggle="#about_us_page" class="main_btn">Explore</button>
	</header>

<?php get_sidebar(); ?>
<?php get_footer(); ?>