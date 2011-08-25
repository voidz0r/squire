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

use Squire\Validation\Constraint\LengthConstraint;

/**
 * Tests for `Squire\Validation\Constraint\LengthConstraint`
 * 
 * This class checks that the `Squire\Validation\Constraint\LengthConstraint`
 * class works correctly.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class LengthConstraintTest extends TestCase
{
	/**
	 * Tests for `testValidation()`
	 * 
	 * @return array
	 * @access public
	 */
	public function getValidationTests()
	{
		$constraint = new LengthConstraint();
		$constraint->setMin(1);
		$constraint->setMax(10);
		
		return array(
			// constraint object
			$constraint,
			
			// results
			array(
				// result
				array(
					// value
					'value' => '',
					
					// result
					'result' => false,
				),
				
				// result
				array(
					// value
					'value' => 'thisisaverylongstring',
					
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
		);
	}
}
