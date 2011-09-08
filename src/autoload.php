<?php

/*
 * This file is part of the Squire framework.
 * 
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

require_once dirname(__FILE__) . '/Squire/ClassLoader/AbstractLoader.php';
require_once dirname(__FILE__) . '/Squire/ClassLoader/UniversalLoader.php';
use Squire\ClassLoader\UniversalLoader;

$loader = new UniversalLoader();
$loader->register();

$loader->registerNamespaces(array(
	'Squire\\Tests' => dirname(__FILE__) . '/../tests',
	'Squire'        => dirname(__FILE__),
));
