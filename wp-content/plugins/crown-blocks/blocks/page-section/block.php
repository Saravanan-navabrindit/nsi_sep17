<?php

if(!class_exists('Crown_Block_Page_Section')) {
	class Crown_Block_Page_Section extends Crown_Block {

		public static $name = 'page-section';

	}
	Crown_Block_Page_Section::init();
}