<?php get_header(); ?>
	<div id="container">
		<?php if( 'sidebar-content-sidebar' == esplanade_get_option( 'layout' ) ) : ?>
			<div class="content-sidebar-wrap">
		<?php endif; ?>
		<section id="content">
			<?php if( have_posts() ) : the_post(); ?>
				<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
					<div class="entry">
						<?php if( esplanade_get_option( 'breadcrumbs' ) ) : ?>
							<div id="location">
								<?php esplanade_breadcrumbs(); ?>
							</div><!-- #location -->
						<?php endif; ?>
						<header class="entry-header">
							<<?php esplanade_title_tag( 'post' ); ?> class="entry-title"><?php the_title(); ?></<?php esplanade_title_tag( 'post' ); ?>>
							<aside class="entry-meta">
								<?php the_time( get_option( 'date_format' ) ); ?>
								<?php edit_post_link( __( 'Edit', 'esplanade' ), ' | ', '' ); ?>
							</aside><!-- .entry-meta -->
						</header><!-- .entry-header -->
						<div class="entry-content">
							<figure class="entry-attachment">
								<a href="<?php echo wp_get_attachment_url(); ?>" title="<?php the_title_attribute(); ?>" rel="attachment">
									<?php _e( 'Download', 'esplanade' ); ?>
								</a>
								<?php if ( ! empty( $post->post_excerpt ) ) : ?>
									<figcaption class="entry-caption">
										<?php the_excerpt(); ?>
									</figcaption><!-- .entry-caption -->
								<?php endif; ?>
							</figure><!-- .entry-attachment -->
							<?php the_content(); ?>
							<div class="clear"></div>
						</div><!-- .entry-content -->
						<footer class="entry-utility">
							<?php wp_link_pages( array( 'before' => '<p class="post-pagination">' . __( 'Pages:', 'esplanade' ), 'after' => '</p>' ) ); ?>
							<?php esplanade_social_bookmarks(); ?>
						</footer><!-- .entry-utility -->
					</div><!-- .entry -->
					<?php comments_template(); ?>
				</article><!-- .post -->
			<?php else : ?>
				<?php esplanade_404(); ?>
			<?php endif; ?>
		</section><!-- #content -->
		<?php if( 'sidebar-content-sidebar' == esplanade_get_option( 'layout' ) ) : ?>
				<?php get_sidebar( 'left' ); ?>
			</div><!-- #content-sidebar-wrap -->
			<?php get_sidebar( 'right' ); ?>
		<?php elseif( ( 'no-sidebars' != esplanade_get_option( 'layout' ) ) && ( 'full-width' != esplanade_get_option( 'layout' ) ) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
	</div><!-- #container -->
<?php get_footer(); ?>