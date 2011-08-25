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

use Squire\Validation\Constraint\TypeConstraint;

/**
 * Tests for `Squire\Validation\Constraint\TypeConstraint`
 * 
 * This class checks that the `Squire\Validation\Contraint\TypeConstraint`
 * class behaves as expected.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class TypeConstraintTest extends TestCase
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
				new TypeConstraint('integer'),
				
				// results
				array(
					// result
					array(
						// value
						'value' => 1,
						
						// result
						'result' => true,
					),
					
					// result
					array(
						// value
						'value' => '1',
						
						// result
						'result' => false,
					),
				),
			),
		);
	}
}
