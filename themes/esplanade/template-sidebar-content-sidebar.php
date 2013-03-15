<?php
/*
Template Name: Sidebar / Content / Sidebar
*/
?><?php get_header(); ?>
	<div id="container">
		<div class="content-sidebar-wrap">
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
								<h1 class="entry-title"><?php the_title(); ?></h1>
							</header><!-- .entry-header -->
							<div class="entry-content">
								<?php the_content(); ?>
								<div class="clear"></div>
							</div><!-- .entry-content -->
							<?php wp_link_pages( array( 'before' => '<footer class="entry-utility"><p class="post-pagination">' . __( 'Pages:', 'esplanade' ), 'after' => '</p></footer><!-- .entry-utility -->' ) ); ?>
						</div><!-- .entry -->
						<?php comments_template(); ?>
					</article><!-- .post -->
				<?php else : ?>
					<?php esplanade_404(); ?>
				<?php endif; ?>
			</section><!-- #content -->
			<?php get_sidebar( 'left' ); ?>
		</div><!-- #content-sidebar-wrap -->
		<?php get_sidebar( 'right' ); ?>
	</div><!-- #container -->
<?php get_footer(); ?>