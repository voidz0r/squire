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

use Squire\Tests\TestCase as BaseTestCase;

/**
 * Custom test case for `Squire\DependencyInjection`
 * 
 * This test case has been made to suit the needs of the
 * tests written for the `Squire\DependencyInjection`
 * component.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * @abstract
 */
abstract class TestCase extends BaseTestCase
{
	/**
	 * This is a service callback. Returns an instance
	 * of stdClass. Does not use any provided parameters.
	 * 
	 * @param array $params
	 * 
	 * @return \stdClass
	 * @access public
	 */
	public function getStdClass(array $params)
	{
		return new \stdClass();
	}
}
