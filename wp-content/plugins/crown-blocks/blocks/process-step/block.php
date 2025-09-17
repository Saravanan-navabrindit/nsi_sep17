<?php

if(!class_exists('Crown_Block_Process_Step')) {
	class Crown_Block_Process_Step extends Crown_Block {

		public static $name = 'process-step';

	}
	Crown_Block_Process_Step::init();
}
