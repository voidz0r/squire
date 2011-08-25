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

use Squire\DependencyInjection\ServiceContainer;
use Squire\DependencyInjection\Service;

/**
 * Tests for `Squire\DependencyInjection\ServiceContainer`
 * 
 * This class checks that the `Squire\DependencyInjection\ServiceContainer`
 * class works correctly.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class ServiceContainerTest extends TestCase
{
	/**
	 * Tests that the services in a container are
	 * correctly set and retrieved.
	 * 
	 * @param array $services
	 * 
	 * @access public
	 * 
	 * @uses Squire\DependencyInjection\ServiceContainer
	 * 
	 * @dataProvider getContainerTests
	 */
	public function testContainer(array $services)
	{
		$container = new ServiceContainer();
		
		foreach ($services as $name => $service) {
			$container[$name] = $service;
		}
		
		foreach (array_keys($services) as $name) {
			$this->assertInstanceOf('Squire\DependencyInjection\Service', $container[$name]);
		}
	}
	
	/**
	 * Tests for `testContainer()`.
	 * 
	 * @return array
	 * @access public
	 * 
	 * @uses Squire\DependencyInjection\Service
	 */
	public function getContainerTests()
	{
		return array(
			array(
				// services to define
				array(
					'foo' => new Service(array($this, 'getStdClass')),
				),
			),
		);
	}
}
