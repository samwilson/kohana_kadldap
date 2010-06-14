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

	/** @var string The user's password is stored in the session under this key. */
	private $_password_session_suffix = '_kadldap_password';

	/** @var array[string] The groups to which the current user belongs. */
	private $_groups;

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
			$this->_session->set($this->_config['session_key'].$this->_password_session_suffix, $password);
			return $this->complete_login($username);
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
		//exit(__FILE__.' line '.__LINE__);
		//return $this->_login($this->get_user(), $password);
		/*$username = $this->get_user();

		if ($username === FALSE)
		{
			return FALSE;
		}

		return ($password === $this->password($username));
		*/
	}

	public function password($username)
	{
		return $this->_session->get($this->_config['session_key'].$this->_password_session_suffix);
	}

	/**
	 * Check if there is an active session. Optionally allows checking for a
	 * specific role (or 'group', in LDAP parlance).
	 *
	 * @param   string   role name
	 * @return  mixed
	 */
	public function logged_in($role = NULL)
	{
		$logged_in = parent::logged_in();

		// If no role requested, or not logged in, don't check for role/group
		// membership.
		if ($role == NULL || !$logged_in)
		{
			return $logged_in;
		} else
		{
			// If a role is being checked, first find this user's groups,
			// and then see if the requested role is in them.
			$username = $this->get_user();
			if (!is_array($this->_groups))
			{
				$this->ldap->authenticate($username, $this->password($username));
				$this->_groups = $this->ldap->user_groups($username);
				if (!is_array($this->_groups))
				{
					$this->_groups = array();
				}
			}
			return in_array($role, $this->_groups);
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
