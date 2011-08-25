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

use Squire\Validation\Constraint\NotEmptyConstraint;

/**
 * Tests for `Squire\Validation\Constraint\NotEmptyConstraint`
 * 
 * This class checks that the `Squire\Validation\Contraint\NotEmptyConstraint`
 * class behaves as expected.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class NotEmptyConstraintTest extends TestCase
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
				new NotEmptyConstraint(),
				
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
						'value' => 'foo',
						
						// result
						'result' => true,
					),
				),
			),
		);
	}
}
