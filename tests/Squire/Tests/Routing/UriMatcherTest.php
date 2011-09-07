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

class UriMatcherTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider getMatchingTests
	 */
	public function testMatching(Route $route, array $tests)
	{
		$compiler = new RouteCompiler();
		$compiled = $compiler->compile($route);
		$matcher  = $compiled->getMatcher();
		
		foreach ($tests as $uri => $return) {
			$this->assertEquals($return, $matcher->match($uri));
		}
	}
	
	public function getMatchingTests()
	{
		return array(
			array(
				new Route('/page/{slug}', array(
					'slug' => 'home',
				), array(
					'slug' => '[a-zA-Z0-9\-]+'
				)),
				array(
					'/page' => array(
						'slug' => 'home'
					),
					'/page/about' => array(
						'slug' => 'about',
					),
					'/page/%invalid%' => false,
				),
			),
		);
	}
}
