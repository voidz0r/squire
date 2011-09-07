<?php

/*
 * This file is part of the Squire framework.
 * 
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

require_once dirname(__FILE__) . '/../src/autoload.php';

spl_autoload_register(function($class) {
	$class = ltrim($class, '\\');
	
	if (strpos($class, 'Squire\\Tests') !== 0) {
		return;
	}
	
	$fname = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
	$fpath = dirname(__FILE__) . DIRECTORY_SEPARATOR . $fname;
	
	if (is_file($fpath)) {
		require_once $path;
	}
}, true);