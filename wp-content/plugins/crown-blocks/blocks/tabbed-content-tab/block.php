<?php

if(!class_exists('Crown_Block_Tabbed_Content_Tab')) {
	class Crown_Block_Tabbed_Content_Tab extends Crown_Block {

		public static $name = 'tabbed-content-tab';

	}
	Crown_Block_Tabbed_Content_Tab::init();
}