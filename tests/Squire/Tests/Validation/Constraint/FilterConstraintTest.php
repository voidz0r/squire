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

use Squire\Validation\Constraint\FilterConstraint;

/**
 * Tests for `Squire\Validation\Constraint\FilterConstraint`
 * 
 * This class checks that the `Squire\Validation\Contraint\FilterConstraint`
 * class behaves as expected.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class FilterConstraintTest extends TestCase
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
				new FilterConstraint(FILTER_VALIDATE_IP),
				
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
						'value' => '127.0.0.1',
						
						// result
						'result' => true,
					),
				),
			),
		);
	}
}
