<?php

// avoid direct access
defined('ABSPATH') or die("Nothing here. Move along mate.");

// WP_Query arguments
$args = array(
  'post_type'              => array( 'post' ),
  'post_status'            => array( 'publish' ),
  'posts_per_page'         => 4,
);

$query = new WP_Query( $args );

$count = 0;

if ( $query->have_posts() )
{
  echo '<div class="front-post"><div class="wrap">';
  while ( $query->have_posts() )
  {
    $query->the_post(); $count++;

    ?>
    <article <?php post_class(); ?>itemscope="" itemtype="http://schema.org/CreativeWork">
      <?php if ( $count == 1 ): ?>
        <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr(get_the_title()) ?>">
        <?php the_post_thumbnail('front-blog-thumbnail', array('class' => 'aligncenter', 'alt' => esc_attr(get_the_title()), 'title' => esc_attr(get_the_title()) ));?>
        <?php $first = false; ?>
        </a>
      <?php endif; ?>
      <header class="entry-header">
        <h2 class="entry-title" itemprop="headline">
          <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
        </h2>
      </header>
      <div class="entry-content" itemprop="text">
        <?php if ( $count == 1 ) { echo wpautop(wp_trim_words( get_the_content(), 100, '...' )); } else { echo wpautop(wp_trim_words( get_the_content(), 40, '...' )); } ?>
        <p class="entry-meta"><?php echo __('Posted'); ?> <?php the_time('m-j-Y'); ?> // <?php echo __('By'); ?> <?php the_author_posts_link(); ?> // <a href="<?php comments_link(); ?>"><?php comments_number( '0 Comment', '1 Comment', '% Comments' ); ?></a></p>
        <p><a href="<?php the_permalink(); ?>" class="more-link">Read More</a></p>
      </div>
    </article>

    <?php
  }

  echo '</div></div>';

}
else
{

  echo '<div class="front-post"><div class="wrap">'.__('No entry.','upward-spiral').'</div></div>';

}

wp_reset_postdata();
