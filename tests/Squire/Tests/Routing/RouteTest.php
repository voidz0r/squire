<?php

/*
 * This file is part of the Squire framework.
 *
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 *
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

namespace Squire\Tests\Routing;

use Squire\Routing\Route;

class RouteTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider getGettersTests
	 */
	public function testGetters($pattern, array $defaults, array $requirements)
	{
		$route = new Route($pattern, $defaults, $requirements);
		
		$this->assertSame('/' . ltrim($pattern, '/'), $route->getPattern());
		$this->assertSame($defaults, $route->getDefaults());
		$this->assertSame($requirements, $route->getRequirements());
	}
    
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testExceptionOnInvalidParameterDefault()
	{
		$route = new Route(null, array(), array());
		$route->getDefault('invalidParameter');
	}
    
    /**
     * @expectedException InvalidArgumentException
     */
	public function testExceptionOnInvalidParameterRequirement()
	{
		$route = new Route(null, array(), array());
		$route->getRequirement('invalidParameter');
	}
	
	public function getGettersTests()
	{
		return array(
			array(
				'post/{slug}/{id}',
				array(
					'slug' => 'hello-world',
					'id'   => '1',
				),
				array(
					'slug' => '[a-zA-Z0-9\-]+',
					'id'   => '\d+',
				),
			),
		);
	}
}
