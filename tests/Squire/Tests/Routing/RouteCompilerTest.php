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

class RouteCompilerTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider getRegexTests
	 */
	public function testRegex(Route $route, $expected_regex)
	{
		$compiler = new RouteCompiler();
		$regex = $compiler->compileRegex($route);
		
		$this->assertEquals($expected_regex, $regex);
	}
	
	public function getRegexTests()
	{
		return array(
			array(
				new Route('/post/{slug}/{id}', array(), array(
					'slug' => '[a-zA-Z0-9\-]+',
					'id'   => '\d+',
				)),
				'@^/post/([a-zA-Z0-9\-]+)/(\d+)/?$@'
			),
			
			array(
				new Route('/page/{slug}', array(
					'slug' => 'home'
				), array(
					'slug' => '[a-zA-Z0-9\-]+'
				)),
				'@^/page/?([a-zA-Z0-9\-]+)?/?$@'
			),
		);
	}
}
