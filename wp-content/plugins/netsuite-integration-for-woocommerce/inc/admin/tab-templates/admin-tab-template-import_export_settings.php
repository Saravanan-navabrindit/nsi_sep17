<form  action="admin-post.php" method="post" id="import_export_settings_tm_ns" enctype="multipart/form-data" > 
  <input type="hidden" name="action" value="import_export_tm_ns"> 
  <input type="hidden" name="current_tab_id" value="<?php echo esc_attr($current_tab_id); ?>">
  <?php wp_nonce_field('nonce'); ?>
  <h2>
	Import/Export Settings
  </h2>
  <div class="inventory-table-main">
	<div class="inv-table">
	  <table>
		<tr valign="top">
		  <th scope="row" class="titledesc">
			<input type="submit" class="button-primary" name="Export" value="Export Settings" id="export_settings" /> 
		  </th>
		</tr>
	  </table>
	</div>
	<div class="inv-table">
				  <input accept="application/JSON" required type="file" name="importfile" id="importfile"  /> 

	  <table>
		<tr>
		  <th scope="row" class="titledesc">

		  </th>
		</tr>
		<tr valign="top">
		  <th scope="row" class="titledesc">
			<input type="submit" class="button-primary" name="Import" value="Import Settings" id="import_settings" /> 
		  </th>
		</tr>
	  </table>
	</div>

  </div>

</form>
