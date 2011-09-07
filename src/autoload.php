<?php

/*
 * This file is part of the Squire framework.
 * 
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

spl_autoload_register(function($class) {
	$class = ltrim($class, '\\');
	
	if (strpos($class, 'Squire\\') !== 0) {
		return;
	}
	
	$fname = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
	$fpath = dirname(__FILE__) . DIRECTORY_SEPARATOR . $fname;
	
	if (is_file($fpath)) {
		require_once $fpath;
	}
});
