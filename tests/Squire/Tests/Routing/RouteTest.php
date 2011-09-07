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
		
		$this->assertEquals('/' . ltrim($pattern, '/'), $route->getPattern());
		$this->assertEquals($defaults, $route->getDefaults());
		$this->assertEquals($requirements, $route->getRequirements());
	}
        
        /**
         * Unit test for testing if the Route::getDefault() throws exception if 
         * there's an invalid parameter
         * 
         * @dataProvider getGettersTests
         * @expectedException InvalidArgumentException
         */
        public function testGetDefaultShouldThrowException($pattern, array $defaults, array $requirements)
        {
            $route = new Route($pattern, $defaults, $requirements);
            $route->getDefault("invalidParam");
        }
        
        /**
         * Unit test for testing if the Route::getRequirement() throws exception
         * if there's an invalid parameter
         * 
         * @dataProvider getGettersTests
         * @expectedException InvalidArgumentException
         */
        public function testGetRequirementShouldThrowException($pattern, array $defaults, array $requirements)
        {
            $route = new Route($pattern, $defaults, $requirements);
            $route->getRequirement("invalidRequirement");
        }
	
	public function getGettersTests()
	{
		return array(
			array(
				'post/{slug}/{id}',
				array(
					'slug' => 'hello-world',
					'id'   => 1,
				),
				array(
					'slug' => '[a-zA-Z0-9\-]+',
					'id'   => '\d+',
				),
			),
		);
	}
}
