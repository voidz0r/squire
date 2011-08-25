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
use Squire\ClassLoader\MapLoader;

/**
 * Tests for `Squire\ClassLoader\MapLoader`
 * 
 * This class checks that the `Squire\ClassLoader\MapLoader`
 * class behaves as expected.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class MapLoaderTest extends TestCase
{
	/**
	 * Tests that the classes are correctly found basing
	 * on the information provided by the map.
	 * 
	 * @param array $classes Classes locations
	 * 
	 * @access public
	 * 
	 * @dataProvider getLoadingTests
	 */
	public function testLoading(array $classes)
	{
		$loader = new MapLoader();
		$loader->registerClasses($classes);
		
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
				// classes
				array(
					'Acme\TestClass' => 'Fixtures/acme/src/Acme/TestClass.php',
					'Foo_TestClass'  => 'Fixtures/foo/src/Foo/TestClass.php',
				)
			),
		);
	}
}
