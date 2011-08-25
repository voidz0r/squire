<?php

/*
 * This file is part of the Squire library.
 * 
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

namespace Squire\Tests\DependencyInjection;

use Squire\DependencyInjection\Service;

/**
 * Tests for `Squire\DependencyInjection\Service`
 * 
 * This class checks that the `Squire\DependencyInjection\Service`
 * behaves as expected.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class ServiceTest extends TestCase
{
	/**
	 * Tests that a service returns the correct instance.
	 * 
	 * @param callback $callback The callback
	 * @param array    $params	 Parameters to use
	 * 
	 * @access public
	 * 
	 * @uses Squire\DependencyInjection\Service
	 * 
	 * @dataProvider getTests
	 */
	public function testInstance($callback, array $params)
	{
		$service = new Service($callback);
		
		foreach ($params as $name => $value) {
			$service[$name] = $value;
		}
		
		$return_value = call_user_func($callback, $params);
		$this->assertInstanceOf(get_class($return_value), $service->getInstance());
	}
	
	/**
	 * Tests that shared services always return the
	 * same instance.
	 * 
	 * @param callback $callback Callback
	 * @param array    $params   Parameters
	 * 
	 * @access public
	 * 
	 * @uses Squire\DependencyInjection\Service
	 * 
	 * @dataProvider getTests
	 */
	public function testShared($callback, array $params)
	{
		$service = new Service($callback, true);
		
		foreach ($params as $name => $value) {
			$service[$name] = $value;
		}
		
		$this->assertSame($service->getInstance(), $service->getInstance());
	}
	
	/**
	 * Tests for `testInstance()` and `testShared()`.
	 * 
	 * @return array
	 * @access public
	 */
	public function getTests()
	{
		return array(
			array(
				// service callback
				array($this, 'getStdClass'),
				
				// params
				array(),
			)
		);
	}
}
