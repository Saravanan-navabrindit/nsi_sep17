<?php

if(!class_exists('Crown_Block_Example')) {
	class Crown_Block_Example extends Crown_Block {

		public static $name = 'example-block';

	}
	Crown_Block_Example::init();
}