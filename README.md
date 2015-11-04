Active Directory and LDAP authentication for Kohana
===================================================

A [Kohana 3.3](http://kohanaframework.org) module
that wraps [Adldap2](https://github.com/Adldap2/Adldap2)
to provide Active Directory and LDAP authentication.

## 1. Install
Copy the module to the `kadldap` directory in your `MODPATH`, or install with
[Composer](https://getcomposer.org) by adding the following to your
`composer.json` file (to get the latest stable version):

    "adldap2/adldap2-kohana": "3.*"

Then enable the module with `Kohana::modules()` (usually in `bootstrap.php`).

## 2. Configure
Set up the Auth config file:

    <?php defined('SYSPATH') OR die('No direct access allowed.');
    return array('driver' => 'LDAP');

Set up the Kadldap config file by copying `MODPATH/kadldap/config/kadldap.php`
to `APPPATH/config/kadldap.php` and editing the values therein.

## 3. Use
Use [Auth](http://kohanaframework.org/3.3/guide/auth) as usual. e.g.:

    Auth::instance()->login($username, $password);

or:

    Auth::instance()->logged_in('Security Group Name');

It's also possible to get a list of a user's Security Groups (*roles*, in Kohana
parlance) with:

    Auth::instance()->get_roles();

## 4. Contribute

Please report all issues at https://github.com/Adldap2/Adldap2-Kohana/issues
