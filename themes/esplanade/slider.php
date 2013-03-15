<?php $sticky = get_option( 'sticky_posts' ); ?>
<?php if( ! empty( $sticky ) ) : ?>
	<?php $slider = new WP_Query( array( 'post__in' => $sticky, 'ignore_sticky_posts' => 1, 'posts_per_page' => 99 ) ); ?>
	<?php if( $slider->have_posts() ) : ?>
		<section id="slider">
			<ul class="slides">
				<?php while( $slider->have_posts() ) : $slider->the_post(); ?>
					<li>
						<article <?php post_class(); ?>>
							<div class="entry-container">
								<header class="entry-header">
									<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
									<aside class="entry-meta">
										<?php the_time( get_option( 'date_format' ) ); ?> | 
										<?php _e( 'Filed under', 'esplanade' ); ?>: <?php the_category( ', ' ) ?>
										<?php edit_post_link( __( 'Edit', 'esplanade' ), ' | ', '' ); ?>
									</aside><!-- .entry-meta -->
								</header><!-- .entry-header -->
								<div class="entry-summary">
									<?php if( has_post_format( 'audio' ) ) : ?>
										<?php esplanade_post_audio(); ?>
									<?php endif; ?>
									<?php the_excerpt(); ?>
								</div><!-- .entry-summary -->
								<div class="clear"></div>
							</div><!-- .entry-container -->
							<?php if( has_post_format( 'video' ) ) : ?>
								<?php esplanade_post_video(); ?>
							<?php elseif( has_post_thumbnail() ) : ?>
								<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
									<?php the_post_thumbnail( 'slider-thumb' ); ?>
								</a>
							<?php endif; ?>
							<div class="clear"></div>
						</article><!-- .post -->
					</li>
				<?php endwhile; ?>
			</ul>
			<div class="clear"></div>
		</section><!-- #slider -->
		<?php wp_reset_postdata(); ?>
	<?php endif; ?>
<?php endif; ?>