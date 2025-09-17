<form action="admin-post.php" method="post" id="settings_tm_ns">
    <input type="hidden" name="action" value="save_tm_ns_settings">
    <input type="hidden" name="current_tab_id" value="<?php echo esc_attr($current_tab_id); ?>">
    <?php
    wp_nonce_field('nonce');
    // pr($options); die('done');

    ?>
    <h2>
        Product/Inventory Sync Settings
    </h2>
    <div class="inventory-table-main">
        <div class="inv-table">
            <h3>
                Stock Management
            </h3>
            <table class="form-table">
                <tbody>
                <tr valign="top" class="">
                    <th scope="row" class="titledesc">
                        Update Inventory(Stock quantity) from NetSuite
                        <div class="tooltip dashicons-before dashicons-editor-help">
                            <span class="tooltiptext">Update WooCommerce Product Stock Quantity from NetSuite</span>
                        </div>
                    </th>
                    <td class="forminp forminp-checkbox">
                        <input name="enableInventorySync"
                            <?php
                            if (isset($options['enableInventorySync']) && 'on' == $options['enableInventorySync']) {
                                echo 'checked ';
                            }
                            ?>
                               id="enableInventorySync" type="checkbox">
                    </td>
                </tr>

                <tr valign="top" class="radio-input">
                    <th scope="row" class="titledesc">
                        <label for="inventoryDefaultLocation">Fetch Inventory from </label>
                        <div class="tooltip dashicons-before dashicons-editor-help">
                            <span class="tooltiptext">If select inventory  from all location items default location will be used else inventory from all location will be used</span>
                        </div>
                    </th>
                    <td class="forminp">
                        <div class="radio">
                            <label>
                                <input type="radio" name="inventoryDefaultLocation" class="inventoryDefaultLocation"
                                       value="1"
                                    <?php
                                    if ((isset($options['inventoryDefaultLocation']) && (1 == $options['inventoryDefaultLocation']))) {
                                        echo 'checked';
                                    } elseif (!isset($options['inventoryDefaultLocation'])) {
                                        echo 'checked';
                                    }
                                    ?>
                                > All Locations
                            </label>
                        </div>
                    </td>
                </tr>
                <tr class="radio-input">
                    <th></th>
                    <td>
                        <div class="radio">
                            <label>
                                <input type="radio" name="inventoryDefaultLocation" class="inventoryDefaultLocation"
                                       value="2"
                                    <?php
                                    if ((isset($options['inventoryDefaultLocation']) && (2 == $options['inventoryDefaultLocation']))) {
                                        echo 'checked';
                                    } elseif (!isset($options['inventoryDefaultLocation'])) {
                                        echo 'checked';
                                    }
                                    ?>
                                > Default Locations
                            </label>
                        </div>
                    </td>
                </tr>
                <tr class="radio-input">
                    <th></th>
                    <td>
                        <div class="radio">
                            <label>
                                <input type="radio" name="inventoryDefaultLocation" class="inventoryDefaultLocation"
                                       value="3"
                                    <?php
                                    if ((isset($options['inventoryDefaultLocation']) && (3 == $options['inventoryDefaultLocation']))) {
                                        echo 'checked';
                                    }
                                    ?>
                                > Selected Locations
                            </label>
                        </div>
                    </td>
                </tr>
                <tr valign="top"
                    class="<?php echo (!isset($options['inventoryDefaultLocation']) || 'on' == $options['inventoryDefaultLocation'] || 3 != $options['inventoryDefaultLocation']) ? 'hidden' : ''; ?>">
                </tr>
                <tr valign="top"
                    class="<?php echo (!isset($options['inventoryDefaultLocation']) || 'on' == $options['inventoryDefaultLocation'] || 3 != $options['inventoryDefaultLocation']) ? 'hidden' : ''; ?>">
                    <th scope="row" class="titledesc">
                    </th>
                    <td class="forminp">
                            <span>
                            <select id="netstuite_locations" name="netstuite_locations[]"
                                    multiple="multiple" style="height:65px !important">
                                <?php
                                $locations = get_option('netstuite_locations');
                                if (!empty($locations)) {
                                    foreach ($locations as $loc_key => $loc_value) {
                                        if (isset($options['netstuite_locations']) && !empty($options['netstuite_locations']) && in_array($loc_key, $options['netstuite_locations'])) {

                                            ?>
                                            <option selected="selected"
                                                    value="<?php echo esc_attr($loc_key); ?>"><?php echo esc_attr($loc_value); ?></option>

                                        <?php } else { ?>
                                            <option value="<?php echo esc_attr($loc_key); ?>"><?php echo esc_attr($loc_value); ?></option>

                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </select>
                            <a href="#" title="get locations from netsuite" id="locationRefresh">
                                <span class="loaderSpiner">
                                    <i class="glyphicon glyphicon-refresh"></i>
                                </span>
                            </a>
                        </span>
                    </td>


                </tr>
                <!-- excluded brands -->
                <tr valign="top" class="radio-input">
                    <th scope="row" class="titledesc">
                        <label for="excluded_brands">Excluded brands </label>
                        <div class="tooltip dashicons-before dashicons-editor-help">
                            <span class="tooltiptext">Select brands to exclude from inventory sync</span>
                        </div>
                    </th>
                    <td class="forminp">
                        <?php
                        $brands = get_terms([
                            'taxonomy' => 'product_brand',
                            'hide_empty' => false,
                        ]);
                        $excluded_brands = get_option('ns_inventory_settings_excluded_brands');

                        if ($excluded_brands === false) {
                            $excluded_brands = [];
                            add_option('ns_inventory_settings_excluded_brands', $excluded_brands);
                        }

                        foreach ($brands as $brand) : ?>
                            <div>
                                <label style="font-weight: normal">
                                    <input type="checkbox" name="excluded_brands[]"
                                           value="<?php echo $brand->slug ?>" <?php echo in_array($brand->slug, $excluded_brands) ? "checked" : "" ?> />
                                    <?php echo $brand->name ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </td>
                </tr>
                <!-- excluded brands -->
                <tr valign="top">
                    <th scope="row" class="titledesc">
                        Override Manage Stock
                        <div class="tooltip dashicons-before dashicons-editor-help">
                            <span class="tooltiptext">If checked enable stock management at product level</span>
                        </div>
                    </th>
                    <td class="forminp forminp-checkbox">
                        <input name="overrideManageStock"
                            <?php
                            if (isset($options['overrideManageStock']) && 'on' == $options['overrideManageStock']) {
                                echo 'checked ';
                            }
                            ?>
                               id="overrideManageStock" type="checkbox">
                        <label for="overrideManageStock">(Note : This will only work when inventory sync is
                            enabled.)</label>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row" class="titledesc">
                        Update stock status
                        <div class="tooltip dashicons-before dashicons-editor-help">
                            <span class="tooltiptext">If checked  update stock status</span>
                        </div>
                    </th>
                    <td class="forminp forminp-checkbox">
                        <input value="yes" name="updateStockStatus"
                            <?php
                            if (!isset($options['updateStockStatus']) || 'yes' == $options['updateStockStatus']) {
                                echo 'checked ';
                            }
                            ?>
                               id="updateStockStatus" type="checkbox">
                        <label for="updateStockStatus"></label>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row" class="titledesc">
                        <label for="inventorySyncField">Inventory Quantity Field</label>

                        <div class="tooltip dashicons-before dashicons-editor-help">
                            <span class="tooltiptext">Set a value for get inventory from NetSuite (Qunatity on Hand or Quantity Available)</span>
                        </div>
                    </th>
                    <td class="forminp forminp-select">
                        <select name="inventorySyncField" id="inventorySyncField" style="" class="">
                            <option value="">Choose the quantity field</option>
                            <option
                                <?php
                                if (isset($options['inventorySyncField']) && 'quantityAvailable' == $options['inventorySyncField']) {
                                    echo 'selected ';
                                }
                                ?>
                                    value="quantityAvailable">Quantity Available
                            </option>
                            <option
                                <?php
                                if (isset($options['inventorySyncField']) && 'quantityOnHand' == $options['inventorySyncField']) {
                                    echo 'selected ';
                                }
                                ?>
                                    value="quantityOnHand">Quantity On Hand
                            </option>
                        </select>
                    </td>
                </tr>


                </tbody>
            </table>
        </div>
        <div class="inv-table">
            <h3>
                Price Management
            </h3>
            <table class="form-table">
                <tbody>
                    <tr valign="top" class="">
                        <th scope="row" class="titledesc">
                            Update Product Price from NetSuite
                            <div class="tooltip dashicons-before dashicons-editor-help">
                                <span class="tooltiptext">Update WooCommerce Product Price from NetSuite</span>
                            </div>
                        </th>
                        <td class="forminp forminp-checkbox">
                            <input name="enablePriceSync"
                                <?php
                                if (isset($options['enablePriceSync']) && 'on' == $options['enablePriceSync']) {
                                    echo 'checked ';
                                }
                                ?>
                                   id="enablePriceSync" type="checkbox">
                        </td>
                    </tr>
                    <tr valign="top" class="">
                        <th scope="row" class="titledesc">
                            Price Level Name
                            <div class="tooltip dashicons-before dashicons-editor-help">
                                <span class="tooltiptext">Mention the price level of the product Example Base Price , Online Price</span>
                            </div>
                        </th>
                        <td class="forminp forminp-select">
                            <select name="price_level_name" id="price_level_name" style="" class="">
                                <option
                                <?php

                                $price_levels = get_option('netstuite_price_levels');
                                if (!empty($price_levels)) {


                                    foreach ($price_levels as $key => $price_level) {
                                        if (isset($options['price_level_name']) && !empty($options['price_level_name']) && $options['price_level_name'] == $price_level) {
                                            ?>
                                            <option selected="selected"
                                                    value="<?php echo esc_attr($price_level); ?>"><?php echo esc_attr($price_level); ?></option>

                                        <?php } else { ?>
                                            <option value="<?php echo esc_attr($price_level); ?>"><?php echo esc_attr($price_level); ?></option>

                                            <?php
                                        }
                                    }

                                }
                                ?>
                            </select>
                            <a href="#" title="get price level list from netsuite" id="priceLevelRefresh">
                                <span class="loaderSpiner">
                                    <i class="glyphicon glyphicon-refresh"></i>
                                </span>
                            </a>
                        </td>

                    </tr>

                    <!-- excluded brands for price -->
                    <tr valign="top" class="radio-input">
                        <th scope="row" class="titledesc">
                            <label for="excluded_brands_price">Excluded brands</label>
                            <div class="tooltip dashicons-before dashicons-editor-help">
                                <span class="tooltiptext">Select brands to exclude from price sync</span>
                            </div>
                        </th>
                        <td class="forminp">
                            <?php
                            $excluded_brands_price = get_option('ns_price_settings_excluded_brands');
                            if ($excluded_brands_price === false) {
                                $excluded_brands_price = [];
                                add_option('ns_price_settings_excluded_brands', $excluded_brands_price);
                            }

                            foreach ($brands as $brand) : ?>
                                <div>
                                    <label style="font-weight: normal">
                                        <input type="checkbox" name="excluded_brands_price[]"
                                               value="<?php echo $brand->slug ?>" <?php echo in_array($brand->slug, $excluded_brands_price) ? "checked" : "" ?> />
                                        <?php echo $brand->name ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                    <!-- excluded brands for price end -->


                </tbody>
            </table>
        </div>
        <div class="inv-table-last">
            <table class="form-table form-table-last">
                <tbody>
                <tr valign="top" class="">
                    <th scope="row" class="titledesc">
                        Default search key for NS item by Woo SKU
                        <div class="tooltip dashicons-before dashicons-editor-help">
                            <span class="tooltiptext">Matches Woo SKU on Netsuite with the selected field for inventory search</span>
                        </div>
                    </th>
                    <td class="forminp forminp-select">
                        <select id="sku_mapping_field" name="sku_mapping_field">
                            <option value="">Choose the matching field</option>
                            <option value="itemId"
                                <?php


                                echo isset($options['sku_mapping_field']) && 'itemId' == $options['sku_mapping_field'] ? ' selected="selected"' : '';


                                ?>
                            >Item Name/Number
                            </option>
                            <option value="upcCode" <?php echo isset($options['sku_mapping_field']) && 'upcCode' == $options['sku_mapping_field'] ? ' selected="selected"' : ''; ?> >
                                UPC Code
                            </option>
                            <option value="displayName" <?php echo isset($options['sku_mapping_field']) && 'displayName' == $options['sku_mapping_field'] ? ' selected="selected"' : ''; ?> >
                                Display Name/Code
                            </option>
                            <option value="vendorName" <?php echo isset($options['sku_mapping_field']) && 'vendorName' == $options['sku_mapping_field'] ? ' selected="selected"' : ''; ?> >
                                Vendor Name/Code
                            </option>
                            <option value="customFieldList" <?php echo isset($options['sku_mapping_field']) && 'customFieldList' == $options['sku_mapping_field'] ? ' selected="selected"' : ''; ?> >
                                Custom Field
                            </option>
                        </select>
                    </td>
                </tr>

                <tr valign="top"
                    class="<?php echo (isset($options['sku_mapping_field']) && 'customFieldList' == $options['sku_mapping_field']) ? '' : 'hidden'; ?>">
                    <th scope="row" class="titledesc">
                    </th>
                    <td class="forminp forminp-select">
                        <input id="sku_mapping_custom_field" name="sku_mapping_custom_field"
                               value="<?php isset($options['sku_mapping_custom_field']) ? esc_attr_e(trim($options['sku_mapping_custom_field'])) : ''; ?>">
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row" class="titledesc">
                        <label for="inventorySyncFrequency">Inventory and(or) Price Sync Frequency</label>

                        <div class="tooltip dashicons-before dashicons-editor-help">
                            <span class="tooltiptext">Set a frequency for inventory and(or) price update from NetSuite</span>
                        </div>
                    </th>
                    <td class="forminp forminp-select">
                        <select name="inventorySyncFrequency" id="inventorySyncFrequency" style="" class="">
                            <?php
                            foreach ($inventory_sync_frequencies as $inventory_sync_frequency_id => $inventory_sync_frequency_name) {
                                ?>
                                <option
                                    <?php
                                    if (isset($options['inventorySyncFrequency']) && $options['inventorySyncFrequency'] == $inventory_sync_frequency_id) {
                                        echo 'selected ';
                                    }
                                    ?>
                                        value="<?php echo esc_attr($inventory_sync_frequency_id); ?>"><?php echo esc_attr($inventory_sync_frequency_name); ?> </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row" class="titledesc">
                        Synchronization settings for CRON and manual products update
                        <div class="tooltip dashicons-before dashicons-editor-help">
                            <span class="tooltiptext">Settings below are used during automatic CRON synchronization and
                            manual synchronization when "Sync all products" is turned on.</span>
                        </div>
                    </th>
                    <td></td>
                </tr>
                <?php
                $sync_status_inv = get_option('ns_synchronization_status_inventory');
                $sync_status_price = get_option('ns_synchronization_status_price');
                $sync_status_all = get_option('ns_synchronization_status_all');
                $clear_queue_price = get_option('ns_clear_sync_queue_price');
                $clear_queue_inv = get_option('ns_clear_sync_queue_inventory');

                $sync_types = array(
                    'inventory' => array(
                        'status' => $sync_status_inv,
                        'desc' => 'Used during CRON sync and Manual sync for "Sync all products" with "inventory"/"all" sync types',
                        'clear_queue' => $clear_queue_inv
                    ),
                    'price' => array(
                        'status' => $sync_status_price,
                        'desc' => 'Used during CRON sync and Manual sync for "Sync all products" with "price"/"all" sync types',
                        'clear_queue' => $clear_queue_price
                    ),
                    'all' => array(
                        'status' => $sync_status_all,
                        'desc' => ''
                    ),
                );
                foreach($sync_types as $type => $details) { ?>
                    <tr valign="top">
                        <th scope="row" class="titledesc">
                            <label for="ns_synchronization_status_<?php echo $type;?>">Synchronization status for: <?php echo $type;?></label>

                            <div class="tooltip dashicons-before dashicons-editor-help">
                                <span class="tooltiptext">Set <?php echo $type;?> synchronization on/off. <?php echo $details['desc'];?> </span>
                            </div>
                        </th>
                        <td class="forminp forminp-select">
                            <select name="ns_synchronization_status_<?php echo $type;?>" id="ns_synchronization_status_<?php echo $type;?>" style="" class="">
                                <option value="on"<?php if ( $details['status'] == 'on' ) echo ' selected';?>>ON</option>
                                <option value="off"<?php if ( $details['status'] == 'off' ) echo ' selected';?>>OFF</option>
                            </select>
                        </td>
                    </tr>
                    <?php if ( $type != 'all' ) { ?>
                        <tr valign="top">
                            <th scope="row" class="titledesc">
                                <label for="ns_clear_sync_queue_<?php echo $type;?>">Clear queue for: <?php echo $type;?></label>

                                <div class="tooltip dashicons-before dashicons-editor-help">
                                    <span class="tooltiptext">Clears queue only when sync status is set to OFF. Can take a few minutes for clear to happen.</span>
                                </div>
                            </th>
                            <td class="forminp">
                                <label><input type="checkbox" value="yes" name="ns_clear_sync_queue_<?php echo $type;?>"<?php echo $details['clear_queue'] === 'yes' ? ' checked' : '';?>></label>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                <?php
                do_action('tm_ns_after_inventory_settings');
                ?>
                <tr valign="top">
                    <th scope="row" class="titledesc">
                        <input type="submit" class="button-primary" name="save_post" value="Save Settings"/>
                    </th>
                </tr>
                <?php
                if (isset($options['enableInventorySync']) && 'on' == $options['enableInventorySync'] || (isset($options['enablePriceSync']) && 'on' == $options['enablePriceSync'])) {
                    ?>
                    <tr>
                        <th scope="row" class="titledesc">
                            <a class="button-primary manual-update-inventory"
                               href="<?php echo get_admin_url(null, 'edit.php?post_type=product&page=acf-options-manual-sync-ns');?>"
                            >Manual update inventory and(or) price</a>
                            <div class="inventory-loader"></div>
                        </th>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div id="inventoy_progress">
        <span id="right_progress" style="display: none">
            <div class="progress_processed">
                <span>Processed <span
                    class="processed_count">0</span> of <span
                    id="of">0</span> records</span>
            </div>
            <div class="progress_details">


                <span class="progress_details_item updated_count" style="">
                    Updated <span class="updated_records_count">0</span>
                </span>
                <span class="progress_details_item skipped_count">
                    Skipped <span class="skipped_records_count">0</span>
                </span>
            </div>
        </span>
    </div>
    <fieldset class="inventory-logs">
        <legend class="log-head">Log</legend>
        <div class="log-list">
        </div>
    </fieldset>
</form>
