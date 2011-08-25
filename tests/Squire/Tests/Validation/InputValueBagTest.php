<?php

/*
 * This file is part of the Squire library.
 * 
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

namespace Squire\Tests\Validation;

use Squire\Tests\TestCase;
use Squire\Validation\InputValueBag;
use Squire\Validation\Constraint\TypeConstraint;
use Squire\Validation\Constraint\EmailConstraint;

/**
 * Tests for `Squire\Validation\InputValueBag`
 * 
 * This class checks that the `Squire\Validation\InputValueBag`
 * class works correctly.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class InputValueBagTest extends TestCase
{
	/**
	 * Tests that the validation of the values in the
	 * bag is done correctly.
	 * 
	 * @param array $values Multidimensional array with values and constraints
	 * 
	 * @access public
	 * 
	 * @dataProvider getValidationTests
	 */
	public function testValidation(array $values)
	{
		$bag = new InputValueBag();
		
		$errors = array();
		foreach ($values as $name => $value) {
			$bag->import(array($name => $value['value']));
			
			$errors[$name] = array();
			
			$this->assertInstanceOf('Squire\Validation\InputValue', $bag[$name]);
			
			if (isset($value['constraints'])) {
				foreach ($value['constraints'] as $constraint) {
					$bag[$name]->addConstraint($constraint['constraint'], $constraint['error']);
					
					if (!$constraint['constraint']->isValid($value['value'])) {
						$errors[$name][] = $constraint['error'];
					}
				}
			}
		}
		
		$validation = $bag->validate();
		$this->assertEquals($errors, $validation);
	}
	
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
				// values
				array(
					// value
					'username' => array(
						// the provided value
						'value' => 'john.doe',
						
						// the constraints
						'constraints' => array(
							// constraint
							array(
								// constraint object
								'constraint' => new TypeConstraint('string'),
								
								// error message
								'error'		 => 'The username is not a string.',
							),
						),
					),
					
					// value
					'password' => array(
						// the provided value
						'value' => 'secret',
						
						// the constraints
						'constraints' => array(
							// constraint
							array(
								// constraint object
								'constraint' => new TypeConstraint('string'),
								
								// error message
								'error'		=> 'The password is not a string.', 
							),
						),
					),
					
					// email
					'email' => array(
						// the provided value
						'value' => 'invalid@email',
						
						// the constraints
						'constraints' => array(
							// constraint
							array(
								// constraint object
								'constraint' => new EmailConstraint(),
								
								// error message
								'error'		=> 'The provided e-mail is invalid.',
							),
						),
					),
				),
			),
		);
	}
}
