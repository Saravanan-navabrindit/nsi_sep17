<form method="post" action="admin-post.php" enctype="multipart/form-data">
		<input type="hidden" name="action" value="save_tm_ns_settings">
<input type="hidden" name="current_tab_id" value="<?php echo esc_attr($current_tab_id); ?>"> 
<?php wp_nonce_field('nonce'); ?>
		<table class="form-table">      <tbody>
		<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="ns_host">NetSuite Host URL</label>
						 <div class="tooltip dashicons-before dashicons-editor-help">
				  <span class="tooltiptext">NetSuite DataCenter URL.Replace the default value if this is different.</span>
				</div>
						
					</th>
			<td class="forminp">
				<fieldset>
					<input class="input-text regular-input" placeholder="https://webservices.na1.netsuite.com"  type="text" name="ns_host" id="ns_host" value="<?php isset($options['ns_host']) ? esc_attr_e($options['ns_host']) :  ''; ?>">
				</fieldset>
			</td>
		</tr>

        <tr valign="top">
            <th scope="row" class="titledesc">
                <label for="ns_restlet_host">NetSuite Restlet Host URL</label>
                <div class="tooltip dashicons-before dashicons-editor-help">
                    <span class="tooltiptext">NetSuite Restlet API URL.</span>
                </div>

            </th>
            <td class="forminp">
                <fieldset>
                    <input class="input-text regular-input" placeholder="https://webservices.na1.netsuite.com"  type="text" name="ns_restlet_host" id="ns_restlet_host" value="<?php isset($options['ns_restlet_host']) ? esc_attr_e($options['ns_restlet_host']) :  ''; ?>">
                </fieldset>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row" class="titledesc">
                <label for="ns_mappings_libraries_query">Mappings Libraries Restlet query</label>
                <div class="tooltip dashicons-before dashicons-editor-help">
                    <span class="tooltiptext">Query for getting Mappings Libraries with NS Restlet API</span>
                </div>

            </th>
            <td class="forminp">
                <fieldset>
                    <input class="input-text regular-input" placeholder="app/site/hosting/restlet.nl?script=6981&deploy=1"  type="text" name="ns_mappings_libraries_query" id="ns_mappings_libraries_query" value="<?php isset($options['ns_mappings_libraries_query']) ? esc_attr_e($options['ns_mappings_libraries_query']) :  ''; ?>">
                </fieldset>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row" class="titledesc">
                <label for="ns_rma_pdf_fetch_script_id">RMA PDF fetching script ID</label>
                <div class="tooltip dashicons-before dashicons-editor-help">
                    <span class="tooltiptext">Script ID that is used to fetch RMA PDF documents from NetSuite</span>
                </div>
            </th>
            <td class="forminp">
                <fieldset>
                    <input class="input-text regular-input" placeholder="6977"  type="text" name="ns_rma_pdf_fetch_script_id" id="ns_rma_pdf_fetch_script_id" value="<?php isset($options['ns_rma_pdf_fetch_script_id']) ? esc_attr_e($options['ns_rma_pdf_fetch_script_id']) :  ''; ?>">
                </fieldset>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row" class="titledesc">
                <label for="ns_rma_fetch_items_positions_in_order">Fetch items positions in order Script ID</label>
                <div class="tooltip dashicons-before dashicons-editor-help">
                    <span class="tooltiptext">Script ID that is used to fetch items positions in order</span>
                </div>
            </th>
            <td class="forminp">
                <fieldset>
                    <input class="input-text regular-input" placeholder="6995"  type="text" name="ns_rma_fetch_items_positions_in_order" id="ns_rma_fetch_items_positions_in_order" value="<?php isset($options['ns_rma_fetch_items_positions_in_order']) ? esc_attr_e($options['ns_rma_fetch_items_positions_in_order']) :  ''; ?>">
                </fieldset>
            </td>
        </tr>

		<tr valign="top">
			<th scope="row" class="titledesc">
				<label for="ns_account">NetSuite Account id</label>
				<div class="tooltip dashicons-before dashicons-editor-help">
				  <span class="tooltiptext">Check help tab for more info</span>
				</div>
				<span class="woocommerce-help-tip" data-tip="NetSuite Account id"></span>
			</th>
			<td class="forminp">
				<fieldset>
					<input class="input-text regular-input " type="text" name="ns_account" id="ns_account" style="" value="<?php isset($options['ns_account']) ? esc_attr_e(trim($options['ns_account'])) :  ''; ?>" placeholder="">
				</fieldset>
			</td>
		</tr>

		
		<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="ns_consumer_key">NetSuite Consumer Key</label>
						 <div class="tooltip dashicons-before dashicons-editor-help">
				  <span class="tooltiptext">Check help tab for more info</span>
				</div>
					</th>
			<td class="forminp">
		<fieldset>
			<input class="input-text regular-input " type="text" name="ns_consumer_key" id="ns_consumer_key" 
			value="<?php isset($options['ns_consumer_key']) ? esc_attr_e(trim($options['ns_consumer_key'])) :  ''; ?>">
		</fieldset>
			</td>
		</tr>
				<tr valign="top">
			<th scope="row" class="titledesc">
					<label for="ns_consumer_secret">NetSuite Consumer Secret</label>
					<div class="tooltip dashicons-before dashicons-editor-help">
				  <span class="tooltiptext">Check help tab for more info</span>
				</div>          
			</th>
			<td class="forminp">

		<fieldset>
			<input class="input-text regular-input " type="password" name="ns_consumer_secret" id="ns_consumer_secret" 
			value="<?php isset($options['ns_consumer_secret']) ? esc_attr_e($options['ns_consumer_secret']) :  ''; ?>">
		</fieldset>
			</td>
		</tr>

		<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="ns_token_id">NetSuite Token ID</label>
						 <div class="tooltip dashicons-before dashicons-editor-help">
				  <span class="tooltiptext">Check help tab for more info</span>
				</div>
					</th>
			<td class="forminp">
				<fieldset>

<input class="input-text regular-input " type="text" name="ns_token_id" id="ns_token_id" 
value="<?php isset($options['ns_token_id']) ? esc_attr_e($options['ns_token_id']) :  ''; ?>">
									</fieldset>
			</td>
		</tr>
				<tr valign="top">
			<th scope="row" class="titledesc">
					<label for="ns_token_secret">NetSuite Token Secret</label>
					<div class="tooltip dashicons-before dashicons-editor-help">
				  <span class="tooltiptext">Check help tab for more info</span>
				</div>   
			</th>
			<td class="forminp">
				<fieldset>
					<input class="input-text regular-input " type="password" name="ns_token_secret" id="ns_token_secret"  
					value="<?php isset($options['ns_token_secret']) ? esc_attr_e($options['ns_token_secret']) :  ''; ?>"> 
				</fieldset>
			</td>
		</tr>
		  <tr valign="top">
						<th scope="row" class="titledesc">
							<label for="hma_algorithm_method">Signature Algorithm Method</label>
							<div class="tooltip dashicons-before dashicons-editor-help">
								<span class="tooltiptext">Use HMAC-SHA256 If your NetSuite account is upto 2021.1</span>
							</div>
						</th>
						<td class="forminp">
							<fieldset>
								<select name="hma_algorithm_method" id="hma_algorithm_method" style="" class="">
					<?php 
					foreach ($hma_methods as $hma_method_id=>$hma_method) { 
						?>
						<option 
						<?php 
						if (isset($options['hma_algorithm_method']) && $options['hma_algorithm_method'] == $hma_method_id) {
echo 'selected ';} 
						?>
						 value="<?php echo esc_attr($hma_method_id); ?>"><?php echo esc_attr($hma_method); ?> </option>
					<?php } ?>
				</select>
						</td>
						
					</tr>
		
		
		
		</tbody></table>        
		<div class="row justify-content-end">
			<div class="col-md-2">
				<input name="save_post" class="btn btn-primary" type="submit" value="Save changes">      
			</div>
			<div class="col-md-10">
				<input name="save_post" id="test_api_creds" class="btn btn-success" value="Test API Credentials">      
				<span class="h5">(Please save settings before testing)</span>
			</div>        
		</div>
	</form>
