<?php do_action( 'main_bottom' ); ?>
</section> <!-- .main -->
<?php get_sidebar( 'primary' ); ?>
<?php do_action( 'after_main' ); ?>

<footer id="site-footer" class="site-footer" role="contentinfo">
    <?php do_action( 'footer_top' ); ?>
    <div class="design-credit">
        <span>
            <?php
            $footer_text = sprintf( __( '<a href="%s">Business_blog WordPress Theme</a> by Compete Themes.', 'business-blog' ), 'https://www.competethemes.com/business_blog/' );
            $footer_text = apply_filters( 'ct_business_blog_footer_text', $footer_text );
            echo wp_kses_post( $footer_text );
            ?>
        </span>
    </div>
</footer>
</div><!-- .max-width -->
</div><!-- .overflow-container -->

<?php do_action( 'body_bottom' ); ?>

<?php wp_footer(); ?>

</body>
</html>