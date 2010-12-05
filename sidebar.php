<div id="sidebar">
  <?php if ( is_sidebar_active('menutop_widget_area') ) : ?>
  <div id="menu-top">
    <?php dynamic_sidebar('menutop_widget_area'); ?>
  </div>
  <?php endif; ?>

  <ul class="menu projects">
    <?php $aPosts = get_posts('numberposts=-1'); ?>
    <?php foreach($aPosts as $post) : ?>
    <?php setup_postdata($post); ?>
    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
    <?php endforeach; ?>
  </ul>

  <?php if ( is_sidebar_active('menubottom_widget_area') ) : ?>
  <div id="menu-bottom">
    <?php dynamic_sidebar('menubottom_widget_area'); ?>
  </div>
  <?php endif; ?>
</div>
