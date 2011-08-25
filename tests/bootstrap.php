<?php

/*
 * This file is part of the Squire library.
 * 
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

require_once dirname(__FILE__) . '/../src/autoload.php';

spl_autoload_register(function($class) {
	if (strpos($class, 'Squire\Tests') === false) {
		return;
	}
	
	$path = dirname(__FILE__) . '/' . str_replace('\\', '/', $class) . '.php';
	
	if (is_file($path)) {
		require_once $path;
	}
}, true, true);
