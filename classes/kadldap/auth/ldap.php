<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * AD/LDAP Module for Kohana
 *
 * @package    KadLDAP
 * @author     Beau Dacious <dacious.beau@gmail.com>
 * @copyright  (c) 2009 Beau Dacious
 * @license    http://www.opensource.org/licenses/mit-license.php
 */

/**
 * LDAP Driver for Kohana's Auth module.
 */
class Kadldap_Auth_Ldap extends Kadldap_Auth
{

	/** @var Kadldap The Kadldap instance. */
	protected $ldap;

	public function __construct($config = array())
	{
		//exit(__FILE__);
		$this->ldap = Kadldap::instance();
		parent::__construct($config);
	}

	/**
	 * Defines [Auth::login].
	 *
	 * @param <type> $username
	 * @param <type> $password
	 * @param <type> $remember
	 * @return <type>
	 */
	public function _login($username, $password, $remember)
	{
		$authenticated = $this->ldap->authenticate($username, $password, TRUE);
		if ($authenticated)
		{
			return $this->complete_login($this->ldap->user_info($username));
		}
		return FALSE;
	}

	/**
	 * Compare password with original (plain text). Works for current (logged in) user.
	 *
	 * @param   string  $password
	 * @return  boolean
	 */
	public function check_password($password)
	{
		exit(__FILE__.' line '.__LINE__);
		//return $this->_login($this->get_user(), $password);
		/*$username = $this->get_user();

		if ($username === FALSE)
		{
			return FALSE;
		}

		return ($password === $this->password($username));
		*/
	}
	/**/

	public function force_login($username)
	{
		if ( $this->user_exists($username) )
		{
			return $this->complete_login($this->ldap->user_info($username));
		}
		else
		{
			return FALSE;
		}
	}
	/**/

	public function password($username)
	{
		exit(__FILE__.' line '.__LINE__);
		//exit(kohana::debug($this->ldap->user_info($username)));
		//return FALSE;
	}
	/**/

	/**
	 * Check if there is an active session. Optionally allows checking for a
	 * specific role.
	 *
	 * @param   string   role name
	 * @return  mixed
	 */
	public function logged_in($role = NULL)
	{
		//exit(kohana::debug($this->get_user()));
		if ($role == NULL)
		{
			return parent::logged_in();
		} else
		{
			return $this->ldap->user_ingroup($this->get_user(), $role);
		}
	}

	/**
	 *
	 * @return <type>
	 */
	/*public function auto_login()
	{
		$username = $this->session->get($this->config['session_key']);

		if ( $this->user_exists($username) )
		{
			return $this->complete_login($username);
		}
	}
	/**/

	/*protected function user_exists($username)
	{
		$userinfo = $this->ldap->user_info($username);
		return ( is_array($userinfo) && array_key_exists('count', $userinfo) && $userinfo['count'] == 1);
	}
	/**/

}
