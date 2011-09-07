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

use Squire\Routing\RouteCompiler;
use Squire\Routing\Route;

class CompiledRouteTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider getRegexTests
	 */
	public function testRegex(Route $route, $regex)
	{
		$compiler = new RouteCompiler();
		$compiled = $compiler->compile($route);
		
		$this->assertEquals($regex, $compiled->getRegex());
		$this->assertSame($route, $compiled->getRoute());
	}
	
	public function getRegexTests()
	{
		return array(
			array(
				new Route('/user/{id}', array(), array(
					'id' => '\d+',
				)),
				'@^/user/(\d+)/?$@',
			),
		);
	}
}
