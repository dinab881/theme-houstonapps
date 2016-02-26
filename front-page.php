<?php
/**
 * Created by PhpStorm.
 * User: Dina
 * Date: 24.02.2016
 * Time: 14:34
 */
get_header();
?>
    <header>
        <?php
            if ( have_posts() ) : while ( have_posts() ) : the_post();?>

                <?php
                $html_title = get_post_meta($post->ID, "houstonapps_heading1", true);
                $heading2 = get_post_meta($post->ID, "houstonapps_heading2", true);

                if ($html_title) { ?>
                    <h1><?php echo $html_title; ?></h1>
                <?php } else { ?>
                    <h1><?php the_title(); ?></h1>
                <?php } ?>


                <?php
                if ($heading2) { ?>
                    <h2><?php echo $heading2; ?></h2>

                <?php } ?>

                <?php the_content(); ?>

          <?php  endwhile; else:
            // no posts found
            endif;
        ?>

        <button data-hnd-toggle="#about_us_page" class="main_btn">Explore</button>
    </header>
</section>

    <section id="about_us_page" class="about_us_page large-12 columns">
        <div class="wrapper large-12 columns">
            <?php if ( is_active_sidebar( 'sidebar-1' )):?>
                <?php dynamic_sidebar( 'sidebar-1' ); ?>
            <?php endif;?>

            <?php if ( is_active_sidebar( 'sidebar-2' )):?>
                <?php dynamic_sidebar( 'sidebar-2' ); ?>
            <?php endif;?>

        </div>

        <button data-hnd-toggle="#about_us_page" type="button" class="open_btn"></button>
    </section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>