<?php

/*
 * This file is part of the Squire library.
 * 
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

namespace Squire\Tests\ClassLoader;

use Squire\Tests\TestCase;
use Squire\ClassLoader\UniversalLoader;

/**
 * Tests for `Squire\ClassLoader\UniversalLoader`
 * 
 * This class checks that the `Squire\ClassLoader\UniversalLoader`
 * class behaves as expected.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class UniversalLoaderTest extends TestCase
{
	/**
	 * Tests that the classes are correctly loaded basing on
	 * the registered prefixes and namespaces.
	 * 
	 * @param array $namespaces Namespaces to register
	 * @param array $prefixes   Prefixes to register
	 * @param array $classes    Classes locations
	 * 
	 * @access public
	 * 
	 * @dataProvider getLoadingTests
	 */
	public function testLoading(array $namespaces, array $prefixes, array $classes)
	{
		$loader = new UniversalLoader();
		
		$loader->registerNamespaces($namespaces);
		$loader->registerPrefixes($prefixes);
		
		foreach ($classes as $class => $location) {
			$this->assertEquals($location, $loader->findClass($class));
		}
	}
	
	/**
	 * Tests for `testLoading()`.
	 * 
	 * @return array
	 * @access public
	 */
	public function getLoadingTests()
	{
		return array(
			array(
				// namespaces
				array(
					'Acme'  => 'Fixtures/acme/src',
				),
				
				// prefixes
				array(
					'Foo' => 'Fixtures/foo/src',
				),
				
				// expected classes locations
				array(
					'Acme\TestClass' => 'Fixtures/acme/src/Acme/TestClass.php',
					'Foo_TestClass'  => 'Fixtures/foo/src/Foo/TestClass.php',
				),
			),
		);
	}
}
