<?php do_action( 'startup_blog_main_bottom' ); ?>
</section> <!-- .main -->
<?php if ( get_theme_mod( 'sidebar' ) != 'before' ) {
    get_sidebar( 'primary' );
} ?>
<?php do_action( 'startup_blog_after_main' ); ?>
</div> <!-- .max-width -->
</div> <!-- .main-content-container -->
<footer id="site-footer" class="site-footer" role="contentinfo">
    <div class="max-width">
        <?php do_action( 'startup_blog_footer_top' ); ?>
        <div class="site-credit">
            <?php
            echo '<a href="' . esc_url( get_home_url() ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a>';
            if ( get_theme_mod( 'tagline' ) != 'header' && get_theme_mod( 'tagline' ) != 'no' ) {
                bloginfo( 'description' );
            }
            ?>
        </div>
        <div class="design-credit">
            <span>
                <?php
                // translators: placeholder is a URL to the theme's page
                $footer_text = sprintf( __( '<a href="%s">Business Blog</a> by Compete Themes.', 'startup-blog' ), 'https://www.competethemes.com/startup_blog/' );
                $footer_text = apply_filters( 'ct_startup_blog_footer_text', $footer_text );
                echo wp_kses_post( $footer_text );
                ?>
            </span>
        </div>
    </div>
    <?php do_action( 'startup_blog_footer_bottom' ); ?>
</footer>
</div><!-- .overflow-container -->

<?php do_action( 'startup_blog_body_bottom' ); ?>

<?php wp_footer(); ?>

</body>
</html>