<?php get_header(); ?>

<?php the_post(); ?>
<h1 class="title"><?php the_title(); ?></h1>
<div id="content">
  <?php the_content(); ?>
</div>

<?php get_footer(); ?>
