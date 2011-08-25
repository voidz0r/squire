<?php

/*
 * This file is part of the Squire library.
 * 
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

namespace Squire\Tests;

/**
 * Test case
 * 
 * This is an advanced test case which extends the one
 * provided by PHPUnit adding more functionalities. It
 * was made to suit Squire's tests needings.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * @abstract
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{
	/**
	 * This is called at start-up. Checks that the class
	 * being tested actually exists. If not, skips the
	 * test (it may have been removed by the user because
	 * it was not needed by his application).
	 * 
	 * @access public
	 */
	public function setUp()
	{
		$reflection = new \ReflectionObject($this);
		chdir(dirname($reflection->getFilename()));

		$tested_class = $this->getTestedClass();
		
		if (!class_exists($tested_class)) {
			$this->markTestSkipped(sprintf(
				'"%s" class does not exist (may have been removed by the user).',
				$tested_class
			));
		}
	}
	
	/**
	 * Returns the name of the tested class.
	 * 
	 * @return string
	 * @access public
	 */
	public function getTestedClass()
	{
		static $tested_class;
		
		if (!is_null($tested_class)) {
			return $tested_class;
		}
		
		$reflection = new \ReflectionObject($this);
		
		$parts = explode('\\', $reflection->getNamespaceName());
		unset($parts[1]);
		
		$tested_namespace = implode('\\', $parts);
		$tested_class 	  = "{$tested_namespace}\\" . substr($reflection->getShortName(), 0, -4);
		
		return $tested_class;
	}
}
