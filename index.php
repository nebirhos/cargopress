<?php get_header(); ?>

<ul class="project-grid">
  <?php while ( have_posts() ) : the_post() ?>
  <li class="project-cell">
    <a href="<?php the_permalink(); ?>"
       title="<?php printf( __('Go to %s', 'cargopress'), the_title_attribute('echo=0') ); ?>"
       rel="bookmark">
      <?php $img_src = get_post_meta($post->ID, 'lead_image', true); ?>
      <?php if ( $img_src != "" ) { ?>
        <img src="<?php bloginfo('template_directory'); ?>/scripts/timthumb.php?src=<?php echo $img_src; ?>&w=200&h=134" />
      <?php } else {?>
        <div class="no-image"></div>
      <?php } ?>
      <h2><?php the_title(); ?></h2>
      <div><span><?php the_title(); ?></span></div>
    </a>
  </li>
  <?php endwhile; ?>
</ul>

<?php get_footer(); ?>
