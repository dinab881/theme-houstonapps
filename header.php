<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section
 *
 * @package Houstonapps
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title( '' ); ?></title>
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri();?>/favicon_astro.ico"  type="image/x-icon" />
    <?php wp_head(); ?>

</head>

<!--LANDING PAGE-->
<section class="welcome_page large-12 columns">
