<?php

/*
 * This file is part of the Squire framework.
 * 
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

namespace Squire\Tests\ClassLoader;

use Squire\ClassLoader\UniversalLoader;

class UniversalLoaderTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider getFindingTests
	 */
	public function testFinding(array $namespaces, array $prefixes,
		array $classes)
	{
		$loader = new UniversalLoader();
		$loader->registerNamespaces($namespaces);
		$loader->registerPrefixes($prefixes);
		
		foreach ($classes as $class => $result) {
			$loader->loadClass($class);
			
			if ($result) {
				$this->assertTrue(
					class_exists($class) ||
					interface_exists($class)
				);
			}
			else {
				$this->assertFalse(
					class_exists($class) ||
					interface_exists($class)
				);
			}
		}
	}
	
	public function getFindingTests()
	{
		return array(
			array(
				array(
					'Acme' => dirname(__FILE__) . '/fixtures',
				),
				array(
					'Foo' => dirname(__FILE__) . '/fixtures',
				),
				array(
					'Acme\TestClass' => true,
					'Foo_TestClass'  => true,
					'Acme\Invalid'   => false,
					'Foo_Invalid'    => false,
					'Invalid'        => false,
					'Foo\Invalid'    => false,
				),
			),
		);
	}
	
	public function testSplAutoload()
	{
		$loader = new UniversalLoader();
		$loader->register();
		
		$this->assertContains(
			array($loader, 'loadClass'),
			spl_autoload_functions()
		);
		
		$loader->unregister();
		
		$this->assertFalse(in_array(
			array($loader, 'loadClass'),
			spl_autoload_functions())
		);
	}
	
	/**
	 * @expectedException \LogicException
	 */
	public function testExceptionOnInvalidSplAutoloadRegister()
	{
		$loader = new UniversalLoader();
		$loader->register();
		$loader->register();
	}
	
	/**
	 * @expectedException \LogicException
	 */
	public function testExceptionOnInvalidSplAutoloadUnregister()
	{
		$loader = new UniversalLoader();
		$loader->unregister();
	}
	
	/**
	 * @expectedException \LogicException
	 */
	public function testExceptionOnUndefinedClass()
	{
		$loader = new UniversalLoader();
		
		$loader->registerNamespace('Acme', dirname(__FILE__) . '/fixtures');
		$loader->loadClass('Acme\UndefinedClass');
	}
}
