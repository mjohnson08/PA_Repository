<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">	
	<?php if( ( esplanade_is_teaser() ) && has_post_thumbnail() ) : ?>
		<figure>
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( 'teaser-thumb' ); ?>
			</a>
		</figure>
	<?php endif; ?>
	<figure>
		<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 78 ); ?>
		</a>
	</figure>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php if( is_paged() || ! esplanade_is_teaser() ) : ?>
		<aside class="entry-meta">
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a> | 
			<?php _e( 'Filed under', 'esplanade' ); ?>: <?php the_category( ', ' ) ?>
			<?php edit_post_link( __( 'Edit', 'esplanade' ), ' | ', '' ); ?>
		</aside><!-- .entry-meta -->
	<?php endif; ?>
	<div class="clear"></div>
</article><!-- .post -->
<?php if( esplanade_is_teaser() ) : ?>
	<?php esplanade_teaser_clearfix(); ?>
<?php endif; ?>