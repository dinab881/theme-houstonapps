<?php
/**
 * Created by PhpStorm.
 * User: Dina
 * Date: 24.02.2016
 * Time: 12:11
 */
get_header();
?>
    <header>
        <?php
        if ( have_posts() ) : while ( have_posts() ) : the_post();?>
            <h1><?php the_title();?></h1>
            <p><?php the_content(); ?></p>

        <?php  endwhile; else:
            // no posts found
        endif;
        ?>

    </header>
    </section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>