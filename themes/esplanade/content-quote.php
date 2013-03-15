<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	<?php if( has_post_thumbnail() ) : ?>
		<?php $thumb = ( esplanade_is_teaser() ? 'teaser-thumb' : 'blog-thumb' ); ?>
		<figure>
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( $thumb ); ?>
			</a>
		</figure>
	<?php endif; ?>
	<div class="entry-summary">
		<?php esplanade_first_blockquote(); ?>
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