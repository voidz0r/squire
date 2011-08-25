<?php

/*
 * This file is part of the Squire library.
 * 
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

namespace Squire\Tests\Validation\Constraint;

use Squire\Validation\Constraint\CallbackConstraint;

/**
 * Tests for `Squire\Validation\Constraint\CallbackConstraint`
 * 
 * This class checks that the `Squire\Validation\Contraint\CallbackConstraint`
 * class behaves as expected.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class CallbackConstraintTest extends TestCase
{
	/**
	 * Tests for `testValidation()`.
	 * 
	 * @return array
	 * @access public
	 */
	public function getValidationTests()
	{
		return array(
			array(
				// constraint object
				new CallbackConstraint(array($this, 'isFoo')),
				
				// results
				array(
					// result
					array(
						// value
						'value' => 'foo',
						
						// result
						'result' => true,
					),
					
					// result
					array(
						// value
						'value' => 'bar',
						
						// result
						'result' => false,
					),
				),
			),
			
			array(
				// constraint object
				new CallbackConstraint(array($this, 'isFoo'), array(true)),
				
				// results
				array(
					// result
					array(
						// value
						'value' => 'FOO',
						
						// result
						'result' => false,
					),
					
					// result
					array(
						// value
						'value' => 'foo',
						
						// result
						'result' => true,
					),
				),
			),
		);
	}
	
	/**
	 * Returns whether the given value equals "foo".
	 * 
	 * @param mixed   $value
	 * @param boolean $cs    Whether to be case-sensitive
	 * 
	 * @return boolean
	 * @access public
	 */
	public function isFoo($value, $cs = false)
	{
		if (!$cs) {
			$value = strtolower($value);
		}
		
		return $value === 'foo';
	}
}
