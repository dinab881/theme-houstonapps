<?php
/**
 * The template for displaying footer.
 *
 * @package Houstonapps
 * @since Houstonapps 1.0
 */
?>
</section>

<?php
if ( is_page() && is_front_page()) {?>
	<section id="about_us_page" class="about_us_page large-12 columns">
			<div class="wrapper large-12 columns">
				<!--WHO WE ARE-->
				<?php if ( is_active_sidebar( 'sidebar-1' ) ) :?>
				<header class="large-12 columns">
					<?php dynamic_sidebar( 'sidebar-1' ); ?>
				</header>
				<?php endif; ?>

				<main class="large-12 columns">

					<!--TEAM-->
					<?php
					display_team_members();
					?>

					<!--WORKING PROCESS-->
					<?php
					display_working_process();
					?>

					<!--TECHNOLOGIES-->
					<?php
					display_technologies();
					?>

					<!--CONTACTS-->
					<?php
					display_contacts();
					?>

				</main>
			</div>
			<button data-hnd-toggle="#about_us_page" type="button" class="open_btn"></button>
	</section>
<?php } ?>

<?php wp_footer(); ?>
</body>
</html>