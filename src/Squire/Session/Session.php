<?php

/*
 * This file is part of the Squire library.
 *
 * (c) 2011 Alessandro Desantis <desa.alessandro@gmail.com>
 *
 * The full copyright and license information are contained
 * in the COPYING.txt file distributed with the source code.
 */

namespace Squire\Session;

use Squire\Session\Storage\AbstractStorage;

/**
 * Session
 * 
 * An instance of this class represents a session. A session can contain
 * any type of information. Sessions IDs are stored in cookies.
 * 
 * @author Alessandro Desantis <desa.alessandro@gmail.com>
 */
class Session
{
	/**
	 * The storage system.
	 * 
	 * @var Squire\Session\Storage\AbstractStorage
	 * @access protected
	 */
	protected $storage = null;
	
	/**
	 * Max session lifetime.
	 * 
	 * @var int
	 * @access protected
	 */
	protected $maxlf = 3600;
	
	/**
	 * The current session's ID.
	 * 
	 * @var string
	 * @access protected
	 */
	protected $id = '';
	
	/**
	 * The session's data.
	 * 
	 * @var array
	 * @access protected
	 */
	protected $data = array();
	
	/**
	 * Creates a new session ID. A session ID is made of 32 alphanumeric
	 * characters.
	 * 
	 * @return string
	 * @access protected
	 * 
	 * @static
	 */
	static protected function createId()
	{
		$chars = array_merge(range('a', 'z'), range(0, 9));
		shuffle($chars);
		
		$code = '';
		for ($i = 0; $i < 32; $i++) {
			$code .= $chars[rand(0, count($chars) - 1)];
		}
		
		return $code;
	}
	
	/**
	 * Configures the session.
	 * 
	 * @param AbstractStorage &$storage Storage system
	 * @param integer         $maxlf    Max session lifetime
	 * @param string          $cookie   Session ID's cookie name
	 * 
	 * @return Squire\Session\Session
	 * @access public
	 */
	public function __construct(AbstractStorage &$storage, $maxlf = 3600,
		$cookie = 'session_id')
	{
		$this->storage = $storage;
		$this->maxlf   = $maxlf;
		$this->cookie  = $cookie;
		
		$storage->clearSessions($maxlf);
		
		if (
			isset($_COOKIE[$cookie]) &&
			$storage->sessionExists($_COOKIE[$cookie])
		) {
			$this->id = $_COOKIE[$cookie];
			$this->loadData();
		}
		else {
			$this->id = self::createId();
			setcookie($cookie, $this->getId(), time() + $maxlf, '/');
			$this->clear();
		}
	}
	
	/**
	 * Returns the storage system.
	 * 
	 * @return AbstractStorage
	 * @access public
	 */
	public function getStorage()
	{
		return $this->storage;
	}
	
	/**
	 * Returns the session's max lifetime.
	 * 
	 * @return int
	 * @access public
	 */
	public function getMaxLifetime()
	{
		return $this->maxlf;
	}
	
	/**
	 * Returns the cookie's name.
	 * 
	 * @return string
	 * @access public
	 */
	public function getCookie()
	{
		return $this->cookie;
	}
	
	/**
	 * Returns the session's ID.
	 * 
	 * @return string
	 * @access public
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * Persists a new key/value pair into the session.
	 * 
	 * @param string $key
	 * @param mixed  $value
	 * 
	 * @access public
	 */
	public function persist($key, $value)
	{
		$this->data[$key] = $value;
		$this->getStorage()->writeSession($this->getId(), $this->data);
		$this->loadData();
	}
	
	/**
	 * Returns whether the given session key exists.
	 * 
	 * @param string $key
	 * 
	 * @return boolean
	 * @access public
	 */
	public function has($key)
	{
		return isset($this->data[$key]);
	}
	
	/**
	 * Returns the value for the given session key.
	 * 
	 * @param string $key
	 * 
	 * @return mixed
	 * @access public
	 * 
	 * @throws \InvalidArgumentException If the key doesn't exist
	 */
	public function get($key)
	{
		if (!$this->has($key)) {
			throw new \InvalidArgumentException(sprintf(
				'"%s" is an invalid session key.',
				$key
			));
		}
		
		return $this->data[$key];
	}
	
	/**
	 * Removes all the data from the session.
	 * 
	 * @access public
	 */
	public function clear()
	{
		$this->getStorage()->writeSession($this->getId(), array());
	}
	
	/**
	 * Loads the session's data.
	 * 
	 * @access protected
	 */
	protected function loadData()
	{
		$this->data = $this->getStorage()->readSession($this->getId());
	}
}
