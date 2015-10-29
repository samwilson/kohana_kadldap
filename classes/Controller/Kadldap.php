<?php

defined('SYSPATH') or die('No direct access allowed.');
/**
 * Module controller for Kadldap, to test configuration and connection details.  This
 * uses the Userguide controller and views, and is linked to from the userguide.
 *
 * @author     Sam Wilson <sam@samwilson.id.au>
 * @copyright  (c) 2011 Sam Wilson
 * @author     Github user 'sfroeth'
 * @copyright  (c) 2011 sfroeth
 * @license    http://www.opensource.org/licenses/mit-license.php
 */
class Controller_Kadldap extends Controller_Userguide
{
    public function action_index()
    {
        // Set up template and view
        $view = View::factory('kadldap/index');
        $this->template->content = $view;
        $this->template->title = 'Kadldap';
        $this->template->menu = '';
        $this->template->breadcrumb = [
            Route::get('docs/guide')->uri()            => __('User Guide'),
            Route::get('docs/guide')->uri().'/kadldap' => $this->template->title,
            'Configuration Test',
        ];
        $view->kadldap = Kadldap::instance();
        $view->message = false;

        // Check auth driver
        $auth_driver = Kohana::$config->load('auth')->get('driver');
        if ($auth_driver != 'LDAP') {
            $view->message = "Incorrect configuration! Auth driver is set to '$auth_driver', but should be 'LDAP'.";
        }

        // Process login
        if (isset($_POST['login'])) {
            $post = Validation::factory($_POST)
                ->rule('username', 'not_empty')
                ->rule('password', 'not_empty');
            if ($post->check()) {
                $username = $post['username'];
                $password = arr::get($post, 'password', '');
                try {
                    if (Auth::instance()->login($username, $password)) {
                        $view->message = 'Successful login.';
                    } else {
                        $view->message = 'Login failed.';
                    }
                } catch (\Adldap\Exceptions\AdldapException $e) {
                    $view->message = $e->getMessage();
                }
            } else {
                $view->message = 'You must enter both your username and password.';
            }
        }

        // Get information about the logged-in user
        if (Auth::instance()->logged_in()) {
            $username = Auth::instance()->get_user();
            $password = Auth::instance()->password($username);
            $view->kadldap->authenticate($username, $password);
            $view->userinfo = $view->kadldap->users()
                ->find($username)
                ->getAttributes();
        } else {
            $view->userinfo = null;
        }
    }

    public function action_logout()
    {
        Auth::instance()->logout();
        $this->redirect('kadldap');
    }
}
