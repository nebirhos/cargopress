<div id="sidebar">
  <?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>

  <ul class="menu projects">
    <?php $aPosts = get_posts('numberposts=-1'); ?>
    <?php foreach($aPosts as $post) : ?>
    <?php setup_postdata($post); ?>
    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
    <?php endforeach; ?>
  </ul>

  <?php if ( is_sidebar_active('menu_widget_area') ) : ?>
  <div id="menu-bottom">
    <?php dynamic_sidebar('menu_widget_area'); ?>
  </div>
  <?php endif; ?>
</div>
