<?php

defined('SYSPATH') or die('No direct access allowed.');
/**
 * LDAP User Model.
 *
 * @author     Beau Dacious <dacious.beau@gmail.com>
 * @copyright  (c) 2009 Beau Dacious
 * @license    http://www.opensource.org/licenses/mit-license.php
 */
class Model_LDAPUser extends Model_LDAP
{
    protected $userinfo = [];

    public static function factory($username = null)
    {
        $user = new self();

        if (null !== $username) {
            $user->get($username);
        }

        return $user;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->userinfo)) {
            $value = $this->userinfo[$name];

            if (is_array($value)) {
                if (array_key_exists('count', $value)) {
                    unset($value['count']);
                }

                $value = (count($value) == 1) ? reset($value) : $value;
            }

            return $value;
        }
    }

    public function get($username)
    {
        $userinfo = $this->ldap->user_info($username);

        if (!is_array($userinfo) || $userinfo['count'] == 0) {
            return false;
        }

        // Let's tidy up this array real quick...

        $userinfo = $userinfo[0]; // Don't need that anymore...

        foreach ($userinfo as $key => $value) {
            if ($key == 'count' || (is_numeric($key) && array_key_exists($value, $userinfo))) {
                unset($userinfo[$key]);
            }
        }

        $this->userinfo = $userinfo;
        $this->loaded = true;

        return $this; // method chaining
    }

    public function is_member_of($group)
    {
        // group model
        if ($group instanceof Model_LDAPGroup) {
            return in_array($group->dn, $this->userinfo['memberof']);
        }

        // dn
        if (in_array($group, $this->userinfo['memberof'])) {
            return true;
        }

        // simple name
        foreach ($this->userinfo['memberof'] as $value) {
            if (preg_match("/^CN={$group}/", $value) > 0) {
                return true;
            }
        }

        return false;
    }
}
