<?php

/*
 * This file is part of the Squire framework.
 * 
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

namespace Squire\Tests\ClassLoader;

use Squire\ClassLoader\UniversalLoader;

class UniversalLoaderTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider getLoadingTests
	 */
	public function testLoading(array $namespaces, array $prefixes,
		array $classes)
	{
		$loader = new UniversalLoader();
		$loader->registerNamespaces($namespaces);
		$loader->registerPrefixes($prefixes);
		
		foreach ($classes as $class) {
			$loader->loadClass($class);
			$this->assertTrue(class_exists($class) || interface_exists($class));
		}
	}
	
	public function getLoadingTests()
	{
		return array(
			array(
				array(
					'Acme' => dirname(__FILE__) . '/fixtures',
				),
				array(
					'Foo' => dirname(__FILE__) . '/fixtures',
				),
				array(
					'Acme\TestClass',
					'Foo_TestClass',
				),
			),
		);
	}
}
