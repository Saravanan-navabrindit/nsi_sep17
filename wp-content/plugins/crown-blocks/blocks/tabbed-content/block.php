<?php

if(!class_exists('Crown_Block_Tabbed_Content')) {
	class Crown_Block_Tabbed_Content extends Crown_Block {

		public static $name = 'tabbed-content';

	}
	Crown_Block_Tabbed_Content::init();
}