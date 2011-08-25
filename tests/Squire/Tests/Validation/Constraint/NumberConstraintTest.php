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

use Squire\Validation\Constraint\NumberConstraint;

/**
 * Tests for `Squire\Validation\Constraint\NumberConstraint`
 * 
 * This class checks that the `Squire\Validation\Contraint\NumberConstraint`
 * class behaves as expected.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class NumberConstraintTest extends TestCase
{
	/**
	 * Tests for `testValidation()`.
	 * 
	 * @return array
	 * @access public
	 */
	public function getValidationTests()
	{
		$constraint = new NumberConstraint();
		$constraint->setMin(1);
		$constraint->setMax(5);
		
		return array(
			array(
				// constraint object
				$constraint,
				
				// results
				array(
					// result
					array(
						// value
						'value' => 'foo',
						
						// result
						'result' => false,
					),
					
					// result
					array(
						// value
						'value' => 0,
						
						// result
						'result' => false,
					),
					
					// result
					array(
						// value
						'value' => 6,
						
						// result
						'result' => false,
					),
					
					// result
					array(
						// value
						'value' => 5,
						
						// result
						'result' => true,
					),
				),
			),
		);
	}
}
