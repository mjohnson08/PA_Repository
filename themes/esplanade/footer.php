		<div></br></br></div>
		<div id="footer">
			<?php get_sidebar( 'footer' ); ?>
			<div id="copyright">
				<p class="copyright"><?php esplanade_copyright_notice(); ?></p>
				<?php if( esplanade_get_option( 'theme_credit_link' ) || esplanade_get_option( 'author_credit_link' )  || esplanade_get_option( 'wordpress_credit_link' ) ) : ?>
					<p class="credits">
						<?php $theme_credit_link = '<a href="' . esc_url( 'http://www.onedesigns.com/wordpress-themes/esplanade-free-wordpress-theme' ) . '" title="' . esc_attr( __( 'Esplanade Theme', 'esplanade' ) ) . '">' . __( 'Esplanade Theme', 'esplanade' ) . '</a>'; ?>
						<?php $author_credit_link = '<a href="' . esc_url( 'http://www.onedesigns.com/' ) . '" title="' . esc_attr( __( 'One Designs', 'esplanade' ) ) . '">' . __( 'One Designs', 'esplanade' ) . '</a>'; ?>
						<?php $wordpress_credit_link = '<a href="' . esc_url( 'http://wordpress.org/' ) . '" title="' . esc_attr( __( 'WordPress', 'esplanade' ) ) . '">' . __( 'WordPress', 'esplanade' ) . '</a>';; ?>
						<?php if( esplanade_get_option( 'theme_credit_link' ) && esplanade_get_option( 'author_credit_link' ) && esplanade_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s by %2$s and %3$s', 'esplanade' ), $theme_credit_link, $author_credit_link, $wordpress_credit_link ); ?>
						<?php elseif( esplanade_get_option( 'theme_credit_link' ) && esplanade_get_option( 'author_credit_link' ) && ! esplanade_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s by %2$s', 'esplanade' ), $theme_credit_link, $author_credit_link ); ?>
						<?php elseif( esplanade_get_option( 'theme_credit_link' ) && ! esplanade_get_option( 'author_credit_link' ) && esplanade_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s and %2$s', 'esplanade' ), $theme_credit_link, $wordpress_credit_link ); ?>
						<?php elseif( ! esplanade_get_option( 'theme_credit_link' ) && esplanade_get_option( 'author_credit_link' ) && esplanade_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s and %2$s', 'esplanade' ), $author_credit_link, $wordpress_credit_link ); ?>
						<?php elseif( esplanade_get_option( 'theme_credit_link' ) && ! esplanade_get_option( 'author_credit_link' ) && ! esplanade_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s', 'esplanade' ), $theme_credit_link ); ?>
						<?php elseif( ! esplanade_get_option( 'theme_credit_link' ) && esplanade_get_option( 'author_credit_link' ) && ! esplanade_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s', 'esplanade' ), $author_credit_link ); ?>
						<?php elseif( ! esplanade_get_option( 'theme_credit_link' ) && ! esplanade_get_option( 'author_credit_link' ) && esplanade_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s', 'esplanade' ), $wordpress_credit_link ); ?>
						<?php endif; ?>
					</p>
				<?php endif; ?>
				<div class="clear"></div>
			</div><!-- #copyright -->
		</div><!-- #footer -->
	</div><!-- #wrapper -->
<?php wp_footer(); ?>
</body>
</html>