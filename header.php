<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
  <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
  <title><?php cargopress_title() ?></title>

  <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
  <link href='http://fonts.googleapis.com/css?family=Arvo:regular,bold&subset=latin' rel='stylesheet' type='text/css'>

  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
  <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>" title="<?php printf( __( '%s latest posts', 'cargoteam' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
  <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'cargoteam' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />

  <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="header">
  <div id="portfolio-title">
    <?php if ( is_home() || is_front_page() ) { ?>
      <h1>
        <a href="<?php bloginfo( 'url' ) ?>/" title="<?php bloginfo( 'name' ) ?>" rel="home"><?php bloginfo( 'name' ) ?></a>
      </h1>
    <?php } else { ?>
      <a href="<?php bloginfo( 'url' ) ?>/" title="<?php bloginfo( 'name' ) ?>" rel="home"><?php bloginfo( 'name' ) ?></a>
    <?php } ?>


  </div>
</div>

<?php get_sidebar(); ?>

<div id="main">
