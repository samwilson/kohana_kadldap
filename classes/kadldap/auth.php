<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Overrides some functionality when using the LDAP driver.
 *
 * @package    Kadldap
 * @author     Beau Dacious <dacious.beau@gmail.com>
 * @copyright  (c) 2009 Beau Dacious
 * @license    http://www.opensource.org/licenses/mit-license.php
 *
 */
abstract class Kadldap_Auth extends Auth
{

	/**
	 * Login method override for Auth module.
	 *
	 * The Auth module salts all passwords before passing them around. This is
	 * no good if we're working with LDAP.
	 *
	 * @param string $username
	 * @param string $password
	 * @param boolean $remember
	 * @return <type>
	 */
	public function login($username, $password, $remember = FALSE)
	{
		if (empty($password))
		{
			return FALSE;
		}

		if (strtoupper($this->_config['driver']) == 'LDAP')
		{
			return $this->_login($username, $password, $remember);
		}
		else
		{
			return parent::login($username, $password, $remember);
		}
	}

}
