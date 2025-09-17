<?php

// require_once TMWNI_DIR . 'inc/wp-background-processing/classes/wp-background-process.php';

class Add_Netsuite_Order extends WP_Background_Process {

	
	protected $action = 'tm_ns_process_orders';

	
	protected function task( $order_id ) {
		// Actions to perform
		require_once(TMWNI_DIR . 'inc/loader.php');
		$this->netsuiteOrderClient = new TMWNI_Loader();
		$order_netsuite_internal_id = $this->netsuiteOrderClient->addNetsuiteOrder($order_id);


		return false;
		
	}

	
	protected function complete() {
		parent::complete();

		// Show notice to user or perform some other arbitrary task...
	}

}
