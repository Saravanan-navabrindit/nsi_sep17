<div class="row">
	<h3>Customer Sync Settings</h3>
	<div class="col-md-12">
		<h4>General Settings</h4>
		<form class="well"  action="admin-post.php" method="post" id="settings_tm_ns"> 
			<input type="hidden" name="action" value="save_tm_ns_settings"> 
			<input type="hidden" name="current_tab_id" value="<?php echo esc_attr($current_tab_id); ?>">
			<?php wp_nonce_field('nonce'); ?>

			
			<table class="form-table">
				<tbody>
					<tr valign="top" class="">
						<th scope="row" class="titledesc">
							Enable Customer Sync
							<span class="woocommerce-help-tip" data-tip="To enable customer sync"></span>
						</th>
						<td class="forminp forminp-checkbox">
							<input name="enableCustomerSync" 
							<?php
							if (isset($options['enableCustomerSync']) && 'on' == $options['enableCustomerSync']) {
								echo 'checked ';
							}
							?>
							 id="enableCustomerSync" type="checkbox">                        
						</td>
					</tr>
					<tr valign="top">
						<th scope="row" class="titledesc">
							<label for="ns_customer_department_id">Sync These Contact Roles</label>
							<div class="tooltip dashicons-before dashicons-editor-help">
								<span class="tooltiptext">Sync These Contact Roles</span>
							</div>
						</th>
						<td class="forminp">
							<fieldset>
								<select id="customer_roles" name="customer_roles[]" class="customer_roles" multiple="multiple" style="height:65px !important">
									<?php
									global $wp_roles;
									$user_roles = $wp_roles->get_names();
									if (isset($options['customer_roles']) && !empty($options['customer_roles'])) {
										$options_role = $options['customer_roles'];
									} else {
										$options_role = array();
									}

									foreach ($user_roles as $user_role_value => $user_role_name) {
										?>
										 
										<option <?php echo in_array($user_role_value, $options_role) ? ' selected="selected"' : ''; ?> value="<?php echo esc_attr($user_role_value); ?>"><?php echo esc_attr($user_role_name); ?></option>
									<?php 
									}
									?>
								</select>
						</td>
					</tr>
					<tr valign="top" class="">
						<th scope="row" class="titledesc">
							Send customers as Company
							<span class="woocommerce-help-tip" data-tip="To enable Send customers as Company"></span>
						</th>
						<td class="forminp forminp-checkbox">
							<input name="enableSendCustomersAsCo" 
							<?php
							if (isset($options['enableSendCustomersAsCo']) && 'on' == $options['enableSendCustomersAsCo']) {
								echo 'checked ';
							}
							?>
							 id="enableSendCustomersAsCo" type="checkbox">                        
						</td>
					</tr>
					<tr valign="top" class="">
						<th scope="row" class="titledesc">
							Is Netsuite Customer Entity ID auto generated ?
							<div class="tooltip dashicons-before dashicons-editor-help">
								<span class="tooltiptext">Enable when netsuite customers entity id is auto generated. If disabled then entity id will be populated with the email id which can be overridden by Customer Conditional Mapping</span>
							</div>
						</th>
						<td class="forminp forminp-checkbox">
							<input name="isEntityIdAuto" 
							<?php
							if (isset($options['isEntityIdAuto']) && 'on' == $options['isEntityIdAuto']) {
								echo 'checked ';
							}
							?>
							 id="isEntityIdAuto" type="checkbox">                        
						</td>
					</tr>
					<?php					
					do_action('tm_ns_after_customer_settings');
					?>
					<tr valign="top">
						<th scope="row" class="titledesc">
							<input type="submit" class="button-primary" name="save_post" value="Save Settings" /> 
						</th>

					</tr>
				</tbody>
			</table>
		</form>
	</div>
	<div class="col-md-12">
		<form class="tm_netsuite_ajax_form_save" role="form">
			<h4>Customer Conditional Mapping</h4>
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
								<span style='float:right;' class='btn btn-danger removeCMRow'>X</span> <?php } ?>
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
										<span class="h6 required">WC Field Source</span><br />
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
			<input type="hidden" name="cm_type" value="customer" >
			<button class="btn btn-success btn-lg">Save</button>
			<hr />
		</form>
	</div>
</div>

