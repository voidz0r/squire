<?php

/*
 * This file is part of the Squire library.
 * 
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

namespace Squire\Http\Session\Storage;

/**
 * Abstract session storage
 * 
 * This is the skeleton class that must be extended by
 * all the session storage classes.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
abstract class AbstractStorage
{
	/**
	 * Returns whether the given session ID exists.
	 * 
	 * @param string $sid Session ID
	 * 
	 * @return boolean
	 * @access public
	 */
	abstract public function sessionExists($sid);
	
	/**
	 * Given a session's ID, returns that session's data.
	 * 
	 * @param string $sid Session ID
	 * 
	 * @return array
	 * @access public
	 * 
	 * @throws \InvalidArgumentException If the session doesn't exist
	 */
	abstract public function readSession($sid);
	
	/**
	 * Writes the given data into the specified session.
	 * 
	 * @param string $sid  Session ID
	 * @param array  $data Session data
	 * 
	 * @access public
	 */
	abstract public function writeSession($sid, array $data);
	
	/**
	 * Deletes the specified session.
	 * 
	 * @param string $sid Session ID
	 * 
	 * @access public
	 * 
	 * @throws \InvalidArgumentException If the session doesn't exist
	 */
	abstract public function removeSession($sid);
	
	/**
	 * Removes all the expired sessions.
	 * 
	 * @param int $maxlf Max lifetime
	 * 
	 * @access public
	 */
	abstract public function clearSessions($maxlf);
}
