<div class="row">
	<h3>Order Settings</h3>
	<div class="col-md-12">
		<h4>General Settings</h4>
		<form   action="admin-post.php" method="post" id="settings_tm_ns"> 
			<div class="well">
				<input type="hidden" name="action" value="save_tm_ns_settings"> 
				<input type="hidden" name="current_tab_id" value="<?php echo esc_attr($current_tab_id . '_general_settings'); ?>">
				<?php wp_nonce_field('nonce'); ?>

				<table class="form-table general-form-table">
					<tbody>
						
						<tr valign="top" class="">
							<th scope="row" class="titledesc">
								Enable Order Sync
								<span class="woocommerce-help-tip" data-tip="To enable order sync"></span>
							</th>
							<td class="forminp forminp-checkbox">
								<input name="enableOrderSync" 
								<?php 
								if (isset($options['enableOrderSync']) && 'on' == $options['enableOrderSync']) {
									echo 'checked ';} 
								?>
									id="enableOrderSync" type="checkbox">                        
								</td>
							</tr>
							<tbody><tbody id="order_enable_fields" 
							<?php 
							if (!isset($options['enableOrderSync'])) {
								?>
								 class= "order_enable_fields" <?php } ?>>
							<tr valign="top">
								<th scope="row" class="titledesc">
									<label for="ns_order_autosync_status">Netsuite Auto Sync Order Status (Default: Processing)</label>
									<div class="tooltip dashicons-before dashicons-editor-help">
										<span class="tooltiptext">This will be the status for which this plugin will auto sync the WooCommerce orders to NetSuite. Default status will be WC-PROCESSING </span>
									</div>

								</th>
								<td class="forminp">
									<fieldset>
										<?php 
										$wc_order_status = wc_get_order_statuses();
										?>
										<select class="input-text  " type="text" name="ns_order_autosync_status" id="ns_order_autosync_status">
											<option value="">Please select</option>
											<?php foreach ($wc_order_status as $status_key => $status_label) : ?>
												<?php if ('wc-cancelled' != $status_key  && 'wc-refunded' != $status_key && 'wc-failed' != $status_key) : ?>
													<option value="<?php echo wp_kses_data(str_replace('wc-', '', $status_key)); ?>" 
														<?php 
														if (isset($options['ns_order_autosync_status']) && wp_kses_data(str_replace('wc-', '', $status_key) ) == $options['ns_order_autosync_status']) {
															echo 'selected'; } 
														?>
															><?php echo esc_attr(trim($status_label)); ?>
														</option>
													<?php endif; ?>
												<?php endforeach; ?>
											</select>
										</fieldset>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row" class="titledesc">
										<label for="ns_autosync_on_order_status_changes">Auto Sync Orders to Netsuite when order status changes to</label>
										<div class="tooltip dashicons-before dashicons-editor-help">
											<span class="tooltiptext">Order will be automatically sync to NetSuite whenever the order status is change to the selected statuses</span>
										</div>
									</th>
									<td class="forminp">
										<fieldset>
											<?php 
									//$wc_order_status = wc_get_order_statuses();
											?>
											<select class="input-text" multiple type="text" name="ns_autosync_on_order_status_changes[]" id="ns_autosync_on_order_status_changes">
												<option value="on-hold_to_processing" 
												<?php 
												if (isset($options['ns_autosync_on_order_status_changes']) && in_array('on-hold_to_processing', $options['ns_autosync_on_order_status_changes']) ) {
													echo 'selected'; } 
												?>
													>On-Hold To Processing</option>
													<option value="pending_to_processing" 
													<?php 
													if (isset($options['ns_autosync_on_order_status_changes']) && in_array('pending_to_processing', $options['ns_autosync_on_order_status_changes']) ) {
														echo 'selected'; } 
													?>
														>Pending To Processing</option>
														<option value="on-hold_to_completed" 
														<?php 
														if (isset($options['ns_autosync_on_order_status_changes']) && in_array('on-hold_to_completed', $options['ns_autosync_on_order_status_changes']) ) {
															echo 'selected'; } 
														?>
															>on-Hold To Completed</option>
															<option value="processing_to_completed" 
															<?php 
															if (isset($options['ns_autosync_on_order_status_changes']) && in_array('processing_to_completed', $options['ns_autosync_on_order_status_changes']) ) {
																echo 'selected'; } 
															?>
																>Processing To Completed</option>
															</select>
														</fieldset>
													</td>
												</tr>

												<tr valign="top">
													<th scope="row" class="titledesc">
														<label for="ns_autosync_on_order_status_changes">Order Delete on NetSuite on WC Delete</label>
														<div class="tooltip dashicons-before dashicons-editor-help">
															<span class="tooltiptext">Delete Order from NetSuite When it get deleted on WooCommerce</span>
														</div>
													</th>
													<td class="forminp forminp-checkbox">
														<input name="syncDeletedOrders" 
														<?php
														if (isset($options['syncDeletedOrders']) && 'on' == $options['syncDeletedOrders']) {
															echo 'checked ';
														}
														?>
														id="syncDeletedOrders" type="checkbox">                        
													</td>
												</tr>

												<tr valign="top">
													<th scope="row" class="titledesc">
														<label for="ns_autosync_on_order_status_changes">Re-Create NS Order on Restore From Trash</label>
														<div class="tooltip dashicons-before dashicons-editor-help">
															<span class="tooltiptext">Re-Create NS Order on Restore From Trash</span>
														</div>
													</th>
													<td class="forminp forminp-checkbox">
														<input name="recreateOnRestore" 
														<?php
														if (isset($options['recreateOnRestore']) && 'on' == $options['recreateOnRestore']) {
															echo 'checked ';
														}
														?>
														id="recreateOnRestore" type="checkbox">                        
													</td>
												</tr>

												<tr valign="top">
													<th scope="row" class="titledesc">
														<label for="ns_order_shiping_line_item">Order Shipping Line Item Internal ID</label>

														<div class="tooltip dashicons-before dashicons-editor-help">
															<span class="tooltiptext">The shipping cost will be assigned to this item. This is a non-inventory item on NetSuite.</span>
														</div>
													</th>
													<td class="forminp">
														<input name="ns_order_shiping_line_item_enable" 
														<?php
														if (isset($options['ns_order_shiping_line_item_enable']) && 'on' == $options['ns_order_shiping_line_item_enable']) {
															echo 'checked ';
														}
														?>
														id="ns_order_shiping_line_item_enable" type="checkbox"> 

														<span>
															<input type="text" name="ns_order_shiping_line_item" id="ns_order_shiping_line_item" value="<?php isset($options['ns_order_shiping_line_item']) ? esc_attr_e(trim($options['ns_order_shiping_line_item'])) :  ''; ?>" 
															<?php if (!isset($options['ns_order_shiping_line_item_enable'])) { ?>
															class= "ns_order_shiping_line_item" <?php } ?>
															>
														</span>
													</td>

												</tr>
												<tr valign="top" class="radio-input">
													<th scope="row" class="titledesc">
														<label for="ns_order_line_item_location">Send Order Line Item Location</label>
														<div class="tooltip dashicons-before dashicons-editor-help">
															<span class="tooltiptext">Use this to set order Line Item Location</span>
														</div>
													</th>
													<td class="forminp">
														<div class="radio">

															<label>
																<input type="radio" value="1" name="order_item_location" id="not_required" 
																<?php 
																if (( !isset($options['order_item_location']) ) || ( isset($options['order_item_location']) && ( 1==$options['order_item_location'] ) )) {
																	echo 'checked'; } 
																?>
																	> Not required
																</label>
															</div>

														</tr>
														<tr class="radio-input">
															<th></th>
															<td>
																<div class="radio">
																	<label>
																		<input type="radio" name="order_item_location" id="default_location"  value="2" 
																		<?php 
																		if (( isset($options['order_item_location']) && ( 2==$options['order_item_location'] ) )) {
																			echo 'checked'; } 
																		?>
																			> Send Default Item Location with Order Items
																		</label>
																	</div>

																</td>
															</tr>
															<tr class="radio-input">
																<th></th>
																<td>
																	<div class="radio">
																		<label>
																			<input type="radio" name="order_item_location" id="defined_location" value="3" 
																			<?php 
																			if (( isset($options['order_item_location']) && ( 3==$options['order_item_location'] ) )) {
																				echo 'checked'; } 
																			?>
																				> Define Item Location to use with All Order Items
																			</label>

																		</div>
																	</td>
																</tr>
																<tr id="hidden_tr_input" 
																<?php 
																if (!isset($options['order_item_location']) || ( isset($options['order_item_location']) && 3 != $options['order_item_location'] )) {
																	?>
																	class= 'hidden_tr_input' 
																	<?php } ?>>
																	<th></th>
																	<td>
																		<input 
																		<?php 
																		if (isset($options['order_item_location']) && 3 == $options['order_item_location']) {
																			?>
																			required <?php } ?> class="form-control input-sm ns-field-value" type="text" name="order_item_location_value"  value="<?php isset($options['order_item_location_value']) ? esc_attr_e(trim($options['order_item_location_value'])) :  ''; ?>">
																		</td>
																	</tr>

																	<tr valign="top" class="">
																		<th scope="row" class="titledesc">
																			Enable Coupon Sync
																			<div class="tooltip dashicons-before dashicons-editor-help">
																				<span class="tooltiptext">Enables coupon sync. to NetSuite.</span>
																			</div>
																		</th>
																		<td class="forminp forminp-checkbox">
																			<input name="ns_coupon_netsuite_sync" 
																			<?php
																			if (isset($options['ns_coupon_netsuite_sync']) && 'on' == $options['ns_coupon_netsuite_sync']) {
																				echo 'checked ';
																			}
																			?>
																			id="ns_coupon_netsuite_sync" type="checkbox">                        
																		</td>

																	</tr>
																	<tr>
																		<td id="promo_required_fields"
																		<?php if (!isset($options['ns_coupon_netsuite_sync'])) { ?>
																		class="promo_required_fields forminp forminp-select"<?php } ?>
																		>
																		<fieldset>	
																		<select id="ns_promo_custform_id" name="ns_promo_custform_id">
																			<option value="">Choose the promo custom form</option>
																		<?php
																		$customForms = get_option('netsuite_promo_customForm');
																		if (!empty($customForms)) {
																			foreach ($customForms as $form_key => $form_value) {
																				if (!empty($options['ns_promo_custform_id']) && ( $form_key == $options['ns_promo_custform_id'] )) {
																					?>
																				<option value="<?php echo esc_attr($form_key); ?>" selected="selected"><?php echo esc_attr($form_value); ?></option>
																										  <?php 
																				} elseif ('Order Promotion' == $form_value) {
																					?>

																				<option value="<?php echo esc_attr($form_key); ?>"><?php echo esc_attr($form_value); ?>
																					
																				</option>
																			<?php 
																				}} 

																		}
																		?>



																		</select>					

																			<select id="ns_promo_discount_id" name="ns_promo_discount_id">
																				<option value="">Choose the discount id</option>
																		<?php
																		$discountItem = get_option('netsuite_promo_discountItem');
																		if (!empty($discountItem)) {
																			foreach ($discountItem as $item_key => $item_value) {
																				if (!empty($options['ns_promo_discount_id']) && ( $item_key == $options['ns_promo_discount_id'] )) {
																					?>
																				<option value="<?php echo esc_attr($item_key); ?>" selected="selected"><?php echo esc_attr($item_value); ?></option><?php } else { ?>

																				<option value="<?php echo esc_attr($item_key); ?>"><?php echo esc_attr($item_value); ?>
																					
																				</option>
																			<?php 
																							   }} 

																		}
																		?>



																		</select>
																		<a href="#" title="get customform and discount item from netsuite" id="Promofields">
																					 <i class="glyphicon glyphicon-refresh" ></i>
		</a>



																		</fieldset>
																	</td>
																</tr>
																<?php					
																	do_action('tm_ns_after_order_settings');
																?>
																
															</tbody>
															<tr valign="top">
																	<th scope="row" class="titledesc">
																		<input type="submit" class="button-primary" name="save_post" value="Save Settings" /> 
																	</th>

																</tr>
														</table>
													</div>
												</form>
												<!-- refund settings -->
												<h4>Refund Settings</h4>
												<form   action="admin-post.php" method="post" id="settings_tm_ns"> 
													<div class="well">
														<input type="hidden" name="action" value="save_tm_ns_settings"> 
														<input type="hidden" name="current_tab_id" value="<?php echo esc_attr($current_tab_id . '_fulfillment_settings'); ?>">
															<table class="form-table general-form-table">
																
																	<tbody>  
																	
																		<tr valign="top" class="">
																			<th scope="row" class="titledesc">
																				Refund Orders NetSuite to Woo
																				<div class="tooltip dashicons-before dashicons-editor-help">
																					<span class="tooltiptext">Refunds the orders on woocommerce if orders  refunds on NetSuite</span>
																				</div>
																			</th>
																			<td class="forminp forminp-checkbox">
																				<input name="refund_order_ns_to_woo" 
																				<?php
																				if (isset($options['refund_order_ns_to_woo']) && 'on' == $options['refund_order_ns_to_woo']) {
																					echo 'checked ';
																				}
																				?>
																				id="refund_order_ns_to_woo" type="checkbox">                        
																			</td>
																		</tr>
																		<td class="forminp">
									<fieldset id=refundOrderStatus 
									<?php 
									if (!isset($options['refund_order_ns_to_woo'])) {
										?>
																		 class= "order_refund_fields_enable" <?php } ?>>
										<label>Select Order Refund Status(optional)</label>
										<select class="input-text  " type="text" name="ns_order_refund_status" id="ns_order_refund_status">
											<option value="">Select Status</option>>
											<option value="All" 
											<?php
											if (isset($options['ns_order_refund_status']) && 'All' == $options['ns_order_refund_status']) {
												echo 'selected';
											}
											?>
																				>All</option>
											<option value="_returnAuthorizationPendingReceipt" 
											<?php
											if (isset($options['ns_order_refund_status']) && 'Pending Receipt' == $options['ns_order_refund_status']) {
												echo 'selected';
											}
											?>
																				>PENDING BILLING</option>
											<option value="_returnAuthorizationRefunded" 
											<?php
											if (isset($options['ns_order_refund_status']) && 'Refunded' == $options['ns_order_refund_status']) {
												echo 'selected';
											}
											?>
																				>REFUNDED</option>

											</select>
										</fieldset>
									</td>
																		<tr valign="top" class="">
																			<th scope="row" class="titledesc">
																				Refund Orders Woo to NetSuite
																				<div class="tooltip dashicons-before dashicons-editor-help">
																					<span class="tooltiptext">Refunds the orders on NetSuite if orders  refunds on woocommerce</span>
																				</div>
																			</th>
																			<td class="forminp forminp-checkbox">
																				<input name="refund_order_woo_to_ns" 
																				<?php
																				if (isset($options['refund_order_woo_to_ns']) && 'on' == $options['refund_order_woo_to_ns']) {
																					echo 'checked ';
																				}
																				?>
																				id="refund_order_woo_to_ns" type="checkbox">                        
																			</td>
																		</tr>
	
																		
																		
																		
																		
																	</tbody>
																	<tbody>
																		

																		

																		<tr valign="top">
																			<th scope="row" class="titledesc">
																				<input type="submit" class="button-primary" name="save_post" value="Save Settings" /> 
																			</th>

																		</tr>

																	</tbody>
																</table>
															</td>
														</form>
													</div>
												<!-- refund settings close -->
												<h4>Fulfillment Sync</h4>
												<form   action="admin-post.php" method="post" id="settings_tm_ns"> 
													<div class="well">
														<input type="hidden" name="action" value="save_tm_ns_settings"> 
														<input type="hidden" name="current_tab_id" value="<?php echo esc_attr($current_tab_id . '_fulfillment_settings'); ?>">
															<table class="form-table general-form-table">
																<tbody>
																	<tr valign="top" class="">
																		<th scope="row" class="titledesc">
																			Fulfillment Sync
																			<span class="woocommerce-help-tip" data-tip="To enable Fulfillment sync"></span>
																		</th>
																		<td class="forminp forminp-checkbox">
																			<input name="enableFulfilmentSync" 
																			<?php 
																			if (isset($options['enableFulfilmentSync']) && 'on' == $options['enableFulfilmentSync']) {
																				echo 'checked ';} 
																			?>
																				id="enableFulfilmentSync" type="checkbox">                        
																			</td>
																		</tr>

																	</tbody>
																	<tbody id="order_fulfilment_fields" 
																	<?php 
																	if (!isset($options['enableFulfilmentSync'])) {
																		?>
																		 class= "order_fulfilment_fields" <?php } ?>>
																		<tr valign="top" class="">
																			<th scope="row" class="titledesc">
																				Mark Order as Completed 
																				<div class="tooltip dashicons-before dashicons-editor-help">
																					<span class="tooltiptext">Mark order as Completed when Order is Fully Billed On NetSuite</span>
																				</div>
																			</th>
																			<td class="forminp forminp-checkbox">
																				<input name="ns_order_auto_complete" 
																				<?php
																				if (isset($options['ns_order_auto_complete']) && 'on' == $options['ns_order_auto_complete']) {
																					echo 'checked ';
																				}
																				?>
																				id="ns_order_auto_complete" type="checkbox">                        
																			</td>
																		</tr>
																		<tr valign="top" class="">
																			<th scope="row" class="titledesc">
																				Send Order Tracking Email to Customer
																				<div class="tooltip dashicons-before dashicons-editor-help">
																					<span class="tooltiptext">Will trigger an email to customer when we receive the tracking number from NetSuite</span>
																				</div>
																			</th>
																			<td class="forminp forminp-checkbox">
																				<input name="ns_order_tracking_email" 
																				<?php
																				if (isset($options['ns_order_tracking_email']) && 'on' == $options['ns_order_tracking_email']) {
																					echo 'checked ';
																				}
																				?>
																				id="ns_order_tracking_email" type="checkbox">                        
																			</td>
																		</tr>
																		<tr>
	<th>Order Field</th>
	<th>Order Meta Key Field</th>
  </tr>
																		<tr valign="top" class="">
																			<th scope="row" class="titledesc">
																				Tracking Number
																			</th>
																			<td class="forminp">
																				<input  class="input-text" type="text" name="ns_order_tracking_number" id="ns_order_tracking_number" value="<?php isset($options['ns_order_tracking_number']) ? esc_attr_e($options['ns_order_tracking_number']) :  ''; ?>">                      
																			</td>
																		</tr>
																		<tr valign="top" class="">
																			<th scope="row" class="titledesc">
																				Shipping Courier
																			</th>
																			<td class="forminp">
																				<input  class="input-text" type="text" name="ns_order_shipping_courier" id="ns_order_shipping_courier" value="<?php isset($options['ns_order_shipping_courier']) ? esc_attr_e($options['ns_order_shipping_courier']) :  ''; ?>">                      
																			</td>
																		</tr>
																		<tr valign="top" class="">
																			<th scope="row" class="titledesc">
																				Pickup date
																			</th>
																			<td class="forminp">
																				<input  class="input-text" type="text" name="ns_order_pickup_date" id="ns_order_pickup_date" value="<?php isset($options['ns_order_pickup_date']) ? esc_attr_e($options['ns_order_pickup_date']) :  ''; ?>">                      
																			</td>
																		</tr>
																		
																		
																	</tbody><tbody>
																		

																		

																		<tr valign="top">
																			<th scope="row" class="titledesc">
																				<input type="submit" class="button-primary" name="save_post" value="Save Settings" /> 
																			</th>

																		</tr>

																	</tbody>
																</table>
															</td>
														</form>
													</div>

													<div class="col-md-12">
														<form class="tm_netsuite_ajax_form_save" role="form">
															<h4>Order Conditional Mapping</h4>
															<?php
															if (!empty($cm_options)) {
																foreach ($cm_options as $key => $cm_option) {
																	$index = $key + 1;
																	?>

																	<div class="well" data-index="<?php echo esc_attr($index); ?>">
																		<table class="netsuite_conditional_mapping table" cellspacing="0" cellpadding="0">
																			<tbody>
																				<span class="exlcude_in_update">
																					<input type="checkbox" 
																					<?php
																					if (isset($cm_option['exlcude_in_update'])) {
																						echo 'checked';
																					}
																					?>
																					name="cm[<?php echo esc_attr($index); ?>][exlcude_in_update]" class="form-control update_checkbox" />
																					<label>Exclude in Update</label>
																				</span>

																				<?php if (isset($cm_option['required']) && 1 == $cm_option['required']) { ?>    
																				<span class="text-danger requiredCM pull-right">(*) Required Field</span>  
																				<?php } else { ?>
																				<span style="float:right;" class='btn btn-danger removeCMRow'>X</span>                       
																				<?php } ?>
																				<tr>
																					<td>
																						<span class="h5 required">Operation</span><br />
																						<select class="cm_operator input-sm" name="cm[<?php echo esc_attr($index); ?>][operator]">
																							<option value="0">-- select operator --</option>
																							<option value="1" 
																							<?php
																							if (1 == $cm_option['operator']) {
																								echo 'selected';
																							}
																							?>
																							>Map Netsuite Field to Fixed Value Based on WC Field Value</option>
																							<option value="2" 
																							<?php
																							if (2 == $cm_option['operator']) {
																								echo 'selected';
																							}
																							?>
																							>Map NetSuite Field to Fixed Value</option>
																							<option value="3" 
																							<?php
																							if (3 == $cm_option['operator']) {
																								echo 'selected';
																							}
																							?>
																							>Map NetSuite Field to WC Field</option>
																						</select>
																					</td>
																					<?php if (2 != $cm_option['operator']) { ?>
																					<td>
																						<span class="h6 required">WC Field Source</span><br/>
																						<select class="cm_type input-sm" name="cm[<?php echo esc_attr($index); ?>][type]">
																							<option value="0">-- select field type --</option>
																							<option value="1" 
																							<?php
																							if (1 == $cm_option['type']) {
																								echo 'selected';
																							}
																							?>
																							>Customer Field</option>
																							<option value="2" 
																							<?php
																							if (2 == $cm_option['type']) {
																								echo 'selected';
																							}
																							?>
																							>Customer Meta Field</option>
																							<option value="3" 
																							<?php
																							if (3 == $cm_option['type']) {
																								echo 'selected';
																							}
																							?>
																							>Order Field</option>

																							<option value="4" 
																							<?php
																							if (4 == $cm_option['type']) {
																								echo 'selected';
																							}
																							?>
																							>Order Meta Field</option>
																						</select>
																					</td>

																					<?php } ?>
																				</tr>

																				<?php 
																				$allow_html =TMWNI_Settings::shapeSpace_allowed_html();
																				echo  wp_kses($cm_option['template'], $allow_html);
							//echo ($cm_option['template']); 
																				?>
																			</tbody>
																		</table>
																	</div>

																	<?php } ?>
																	<?php } else { ?>

																	<div class="well" data-index="1">
																		<table class="netsuite_conditional_mapping table" cellspacing="0" cellpadding="0">
																			<tbody>
																				<span class="exlcude_in_update"></span>
																				<span style="float:right;" class='btn btn-danger removeCMRow'>X</span>
																				<tr>
																					<td>
																						<span class="h5">Operation</span><br />
																						<select class="cm_operator input-sm" name="cm[1][operator]">
																							<option value="0" selected>-- select operator --</option>
																							<option value="1">Map NetSuite Field to Fixed Value Based on WC Field Value</option>
																							<option value="2">Map NetSuite Field to Fixed Value</option>
																							<option value="3">Map NetSuite Field to WC Field</option>
																						</select>
																					</td>
																				</tr>
																			</tbody>
																		</table>
																	</div>

																	<?php } ?>

																	<input type="button" class="btn btn-primary" value="(+) Add More" id="addMoreConditionalMappingRows" style="float: right; margin-top: 10px;" />
																	<input type="hidden" name="action" value="tm_netsuite_cm_save" >
																	<input type="hidden" name="cm_type" value="order" >																	
																	<button class="btn btn-success btn-lg">Save</button>
																	<hr />
																</form>
															</div>
														</div>
