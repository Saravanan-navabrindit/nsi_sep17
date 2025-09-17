<?php
if ( ! defined( 'ABSPATH' ) ) exit;

global $addify_rfq;

if ( is_user_logged_in() && is_object( $addify_rfq ) && is_object( $addify_rfq->quote_types_obj ) ) {
    $all_quote_types = $addify_rfq->quote_types_obj->afrfq_get_all_quote_types();
    $quote_types = sort_quote_types_with_job_request_first( $all_quote_types );
    $bridge_port_brand = false;
    $selected_quote_type = get_current_user_quote_type_value();
    $current_user = wp_get_current_user();
    $admin_id   = get_original_admin_id();
    $admin_user = $admin_id ? get_userdata($admin_id) : null;

    $brand_check_condition = false;
    $email_to_check = null;
    $is_shop_manager = false;
    $is_dual_shop_manager = false;
    if ( is_switched_customer() ) {
        $switched_roles = (array) $current_user->roles;

        if ( in_array( 'shop_manager', $switched_roles, true ) ) {
            $is_shop_manager = true;
            $email_to_check = strtolower( $current_user->user_email );
        } elseif ( in_array( 'dual_shop_manager', $switched_roles, true ) ) {
            $is_dual_shop_manager = true;
            $email_to_check = strtolower( $current_user->user_email );
        } elseif ( $admin_user ) {
            if ( in_array( 'shop_manager', (array) $admin_user->roles, true ) ) {
                $is_shop_manager = true;
                $email_to_check = strtolower( $admin_user->user_email );
            } elseif ( in_array( 'dual_shop_manager', (array) $admin_user->roles, true ) ) {
                $is_dual_shop_manager = true;
                $email_to_check = strtolower( $admin_user->user_email );
            }
        }
    } else {
        if ( in_array( 'shop_manager', (array) $current_user->roles, true ) ) {
            $is_shop_manager = true;
            $email_to_check = strtolower( $current_user->user_email );
        } elseif ( in_array( 'dual_shop_manager', (array) $current_user->roles, true ) ) {
            $is_dual_shop_manager = true;
            $email_to_check = strtolower( $current_user->user_email );
        }
    }

    if ( $is_dual_shop_manager ) {
        $dsm_allowed_brands_option = get_option( 'dsm_allowed_brands' );
        $domains = $dsm_allowed_brands_option['data']['dsm-domain'] ?? array();
        $brands = $dsm_allowed_brands_option['data']['dsm-brands'] ?? array();

        if ( ! empty( $domains ) && ! empty( $brands ) ) {
            foreach ( $domains as $index => $domain ) {
                $lowercase_domain = strtolower( $domain );
                if ( $email_to_check && str_contains( $email_to_check, trim($lowercase_domain) ) ) {
                    $available_brands = isset( $brands[ $index ] ) ? array_map( 'trim', explode( ',', $brands[ $index ] ) ) : array();

                    if ( in_array( 'bridgeport', array_map( 'strtolower', $available_brands ), true ) ) {
                        $bridge_port_brand = true;
                    }
                }
            }
        }
    }
    ?>
    <div class="pdp-quick-view" id="myaccount-popup" style="display:none;">
        <button class="popup-close-button" aria-label="Close alert" type="button">
            <span aria-hidden="true">&times;</span>
        </button>

        <div class="quote-type-radios">
            <h4>Select Quote Type</h4>
            <?php foreach ( $quote_types as $quote_type ) : 
                $quote_id = intval( $quote_type->ID );
                $quote_title = isset($quote_type->post_title) ? esc_html( $quote_type->post_title ) : esc_html( get_the_title( $quote_id ) );
                $quote_type_bridgeport_only = get_post_meta( $quote_id, 'quote_type_bridgeport_brand', true );
                if ( $is_dual_shop_manager && $quote_type_bridgeport_only === 'yes' && ! $bridge_port_brand ) {
                    continue;
                }
            ?>
                <div class="quote-type-option">
                    <label>
                        <input type="radio" name="afrfq_field_quote_types" value="<?php echo $quote_id; ?>">
                        <?php echo $quote_title; ?>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>
        <div>
            <p class="quote-type-not-selected" style="display:none; color:red;">Please select a quote type!</p>
        </div>
        <a href="javascript:void(0);" id="submit-quote-selection" class="button alt">Submit</a>
    </div>
    <div class="type-already-selected-warning-popup" id="type_already_selected_popup">
        <button class="popup-close-button" id="type-already-selected-close" aria-label="Close alert" type="button" data-close>
            <span aria-hidden="true">&times;</span></button>
        <div class="popup-content">
            <p>A quote type is already selected. To change it, please clear your current quote. Thank you!</p>
        </div>
    </div>
    <?php
        $job_quote_id = 0;
        $job_quote_title = '';
        if ( is_object( $addify_rfq ) && is_object( $addify_rfq->quote_types_obj ) ) {
            $quote_types = $addify_rfq->quote_types_obj->afrfq_get_all_quote_types();
            foreach ( $quote_types as $quote_type ) {
                $qt_id = intval( $quote_type->ID );
                $qt_title = $quote_type->post_title;
                if ( trim( $qt_title ) === 'Job Quote Request' ) {
                    $job_quote_id = $qt_id;
                    $job_quote_title = $qt_title;
                    break;
                }
            }
        }
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const popupTrigger = document.querySelector('.open-new-quote-popup');
            const popup = document.getElementById('myaccount-popup');
            const closeQuickViewBtn = document.querySelector('#myaccount-popup .popup-close-button');
            const closeAlreadySelectedBtn = document.querySelector('#type_already_selected_popup #type-already-selected-close');
            const submitButton = document.getElementById('submit-quote-selection');
            const selected_quote_type_not_selected_msg = document.querySelector('.quote-type-not-selected');

            if (popupTrigger) {
                popupTrigger.addEventListener('click', function (e) {
                    e.preventDefault();

                    fetch("<?php echo admin_url('admin-ajax.php'); ?>", {
                        method: "POST",
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                        body: new URLSearchParams({ action: "check_quote_type_exists" }),
                        cache: "no-store"
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.exists) {
                            window.location.href = "<?php echo esc_url( home_url( '/request-a-quote' ) ); ?>";
                        } else if (data && data.success === false && data.data && data.data.code) {
                                    popup.style.display = 'none';
                                    document.querySelector('#type_already_selected_popup')?.classList.add('active');
                        }
                        else {
                            selected_quote_type_not_selected_msg.style.display = 'none';
                            popup.style.display = 'block';
                        }
                    });
                });
            }

            // Handle submit
            if (submitButton) {
                submitButton.addEventListener('click', function () {
                    const selectedRadio = document.querySelector('input[name="afrfq_field_quote_types"]:checked');
                    if (!selectedRadio) {
                        selected_quote_type_not_selected_msg.style.display = 'block';
                        return;
                    }
                    const selectedValue = selectedRadio.value;
                    const selectedTitle = selectedRadio.parentElement.textContent.trim();

                    fetch("<?php echo admin_url('admin-ajax.php'); ?>", {
                        method: "POST",
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                        body: new URLSearchParams({
                            action: "set_selected_quote_type",
                            id: selectedValue,
                            title: selectedTitle
                        })
                    }).then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = "<?php echo esc_url( home_url( '/request-a-quote' ) ); ?>";
                        } else if (data && data.success === false && data.data && data.data.code) {
                                    popup.style.display = 'none';
                                    document.querySelector('#type_already_selected_popup')?.classList.add('active');
                        } else {
                            alert('Unexpected error. Please try again.');
                        }
                    });
                });
            }

            // Close already-selected popup
            if (closeQuickViewBtn) {
                closeQuickViewBtn.addEventListener('click', () => popup.style.display = 'none');
            }
            if (closeAlreadySelectedBtn) {
                closeAlreadySelectedBtn.addEventListener('click', () => {
                    document.querySelector('#type_already_selected_popup')?.classList.remove('active');
                });
            }

            const requestQuoteLink = document.querySelector('.woocommerce-MyAccount-navigation a[href*="request-a-quote"]:not(.open-new-quote-popup)');
            const defaultQuoteType = {
                id: "<?php echo esc_js($job_quote_id); ?>",
                title: "<?php echo esc_js($job_quote_title); ?>"
            };
            if (requestQuoteLink) {
                requestQuoteLink.addEventListener('click', function (e) {
                    e.preventDefault();

                    let alreadySelected = <?php echo json_encode( WC()->session->get('selected_quote_type')['id'] ?? null ); ?>;
                    if (alreadySelected) {
                        window.location.href = requestQuoteLink.href;
                        return;
                    }

                    fetch("<?php echo admin_url('admin-ajax.php'); ?>", {
                        method: "POST",
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                        body: new URLSearchParams({
                            action: "set_selected_quote_type",
                            id: defaultQuoteType.id,
                            title: defaultQuoteType.title
                        })
                    }).then(r => r.json())
                    .then(data => {
                        window.location.href = requestQuoteLink.href;
                    });
                });
            }
        });
    </script>
    <?php
}
?>
