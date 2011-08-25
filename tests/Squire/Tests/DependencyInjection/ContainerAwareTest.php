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

use Squire\Tests\DependencyInjection\TestCase;
use Squire\DependencyInjection\Service;
use Squire\DependencyInjection\ServiceContainer;
use Squire\Tests\DependencyInjection\Fixtures\ContainerAwareClass;

/**
 * Tests for `Squire\DependencyInjection\ContainerAware`
 * 
 * This clas tests that the `Squire\DependencyInjection\ContainerAware`
 * class behaves as expected.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class ContainerAwareTest extends TestCase
{
	/**
	 * Tests that services are correctly retrieved
	 * in the container aware class.
	 * 
	 * @param array $services Services to define
	 * 
	 * @access public
	 * 
	 * @uses Squire\DependencyInjection\ServiceContainer
	 * @uses Squire\DependencyInjection\Service
	 * @uses Squire\Tests\DependencyInjection\ContainerAwareClass
	 * 
	 * @dataProvider getContainerAwareTests
	 */
	public function testContainerAware(array $services)
	{
		$container = new ServiceContainer();
		
		foreach ($services as $name => $service) {
			$container[$name] = $service;
		}
		
		$container_aware = new ContainerAwareClass($container);
		
		foreach ($services as $name => $service) {
			$this->assertInstanceOf(get_class($service->getInstance()), $container_aware->getService($name));
		}
	}
	
	/**
	 * Tests for `testContainerAware()`.
	 * 
	 * @return array
	 * @access public
	 * 
	 * @uses Squire\DependencyInjection\Service
	 */
	public function getContainerAwareTests()
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
