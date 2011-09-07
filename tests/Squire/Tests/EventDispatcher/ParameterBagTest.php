<?php

/*
 * This file is part of the Squire framework.
 * 
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

namespace Squire\Tests\EventDispatcher;

use Squire\EventDispatcher\ParameterBag;

class ParameterBagTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider getBagTests
	 */
	public function testBag(array $params)
	{
		$bag = ParameterBag::fromArray($params);
		
		$this->assertSame($params, $bag->all());
		
		foreach ($params as $key => $value) {
			$this->assertTrue(isset($bag[$key]));
			
			$this->assertSame($value, $bag[$key]);
			
			unset($bag[$key]);
			$this->assertFalse(isset($bag[$key]));
		}
		
		$bag = ParameterBag::fromArray($params);
		$bag->clear();
		
		$this->assertSame(array(), $bag->all());
	}
	
	public function getBagTests()
	{
		return array(
			array(
				array(
					'foo'  => 'bar',
					'bar'  => 'baz',
					'john' => 'doe',
				),
			),
		);
	}
}
