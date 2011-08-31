<?php

/*
 * This file is part of the Squire library.
 * 
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 * 
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

namespace Squire\Session\Storage;

/**
 * Filesystem session storage
 * 
 * This storage system writes the sessions' data into the filesystem. Each
 * session's data is written into a file named [SESSION_ID].sess. This is
 * similar to PHP's default session system.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class FilesystemStorage extends AbstractStorage
{
	/**
	 * The path to the session files.
	 * 
	 * @var string
	 * @access protected
	 */
	protected $path = '';
	
	/**
	 * Sets the path to the session files.
	 * 
	 * @param string $path Path
	 * 
	 * @return Squire\Session\Storage\FilesystemStorage
	 * @access public
	 * 
	 * @throws \InvalidArgumentException If the directory isn't valid
	 */
	public function __construct($path)
	{
		if (!is_dir($path)) {
			throw new \InvalidArgumentException(sprintf(
				'"%s" is an invalid directory.',
				$path
			));
		}
		
		if (!is_readable($path)) {
			throw new \InvalidArgumentException(sprintf(
				'"%s" is not a readable directory.',
				$path
			));
		}
		
		$this->path = $path;
	}
	
	/**
	 * Returns the path to the session directory.
	 * 
	 * @return string
	 * @access public
	 */
	public function getPath()
	{
		return $this->path;
	}
	
	/**
	 * Returns the path to the file containing the data about the given
	 * session's ID. Note that this method will behave as expected even
	 * if the session doesn't exist.
	 * 
	 * @param string $sid Session ID
	 * 
	 * @return string
	 * @access protected
	 */
	protected function getSessionPath($sid)
	{
		return $this->getPath() . '/' . $sid . '.sess';
	}

	/**
	 * Returns whether the given session ID exists.
	 * 
	 * @param string $sid Session ID
	 * 
	 * @return boolean
	 * @access public
	 */
	public function sessionExists($sid)
	{
		return file_exists($this->getSessionPath($sid));
	}
	
	/**
	 * Given a session's ID, returns that session's data.
	 * 
	 * @param string $sid Session's ID
	 * 
	 * @return array
	 * @access public
	 * 
	 * @throws \InvalidArgumentException If the session doesn't exist
	 */
	public function readSession($sid)
	{
		if (!$this->sessionExists($sid)) {
			throw new \InvalidArgumentException(sprintf(
				'"%s" session file does not exist.',
				$this->getSessionPath($sid)
			));
		}

		return unserialize(file_get_contents($this->getSessionPath($sid)));
	}
	
	/**
	 * Writes the specified data into the given session.
	 * 
	 * @param string $sid  Session ID
	 * @param array  $data Session data
	 * 
	 * @access public
	 */
	public function writeSession($sid, array $data)
	{
		if ($this->sessionExists($sid)) {
			$this->removeSession($sid);
		}
		
		file_put_contents($this->getSessionPath($sid), serialize($data));
	}
	
	/**
	 * Removes the specified session.
	 * 
	 * @param string $sid Session ID
	 * 
	 * @access public
	 * 
	 * @throws \InvalidArgumentException If the session doesn't exist
	 */
	public function removeSession($sid)
	{
		if (!$this->sessionExists($sid)) {
			throw new \InvalidArgumentException(sprintf(
				'"%s" session file does not exist.',
				$this->getSessionPath($sid)
			));
		}
		
		unlink($this->getSessionPath($sid));
	}
	
	/**
	 * Removes all the expired sessions.
	 * 
	 * @param int $maxlf Max lifetime
	 * 
	 * @access public
	 */
	public function clearSessions($maxlf)
	{
		foreach (glob($this->getPath() . '/*.sess') as $sessfile) {
			if (time() - filemtime($sessfile) > $maxlf) {
				unlink($sessfile);
			}
		}
	}
}
