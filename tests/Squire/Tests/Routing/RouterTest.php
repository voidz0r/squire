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
use Squire\Routing\CompiledRoute;
use Squire\Routing\RouteCompiler;
use Squire\Routing\Router;

class RouterTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider getMatchingTests
	 */
	public function testMatching(array $routes, array $tests)
	{
		$router   = new Router();
		$compiler = new RouteCompiler();
		
		foreach ($routes as $name => $route) {
			if (!$route instanceof CompiledRoute) {
				$route = $compiler->compile($route);
			}
			
			$router[$name] = $route;
		}
		
		foreach ($tests as $uri => $return) {
			$this->assertEquals($return, $router->execute($uri));
		}
	}
	
	public function getMatchingTests()
	{
		return array(
			array(
				array(
					'user_profile' => new Route('/user/{id}', array(), array(
						'id' => '\d+',
					)),
					
					'page_show' => new Route('/page/{slug}', array(
						'slug' => 'home',
					), array(
						'slug' => '[a-zA-Z0-9\-]+',
					)),
					
					'post_read' => new Route('/post/{slug}/{id}', array(),
						array(
							'slug' => '[a-zA-Z0-9\-]+',
							'id'   => '\d+',
						)
					),
				),
				
				array(
					'/user/1' => array(
						'route'  => 'user_profile',
						'params' => array('id' => 1),
					),
					
					'/user/invalid' => false,
					
					'/page/about' => array(
						'route'  => 'page_show',
						'params' => array('slug' => 'about'),
					),
					
					'/page' => array(
						'route'  => 'page_show',
						'params' => array('slug' => 'home'),
					),
					
					'/page/%invalid' => false,
					
					'/post/hello-world/26' => array(
						'route'  => 'post_read',
						'params' => array('slug' => 'hello-world', 'id' => 26),
					),
					
					'/post' => false,
				),
			),
		);
	}
}
