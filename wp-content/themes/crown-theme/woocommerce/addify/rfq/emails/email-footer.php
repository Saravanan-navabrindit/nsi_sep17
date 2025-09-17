<?php

defined( 'ABSPATH' ) || exit;
?>
                        </div>
                    <!-- End Content -->
                    </div>
                </div>
                <div id="template_footer" class="quote-template_footer">
                    <div id="credit" class="quote-credit">
                        <?php echo wp_kses_post( wpautop( wptexturize( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) ) ) ); ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>