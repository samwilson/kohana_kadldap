<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Kadldap extends Controller_Userguide
{

	public function action_index()
	{
		$view = View::factory('kadldap/index');
		$this->template->content = $view;
		$this->template->title = 'Kadldap';
		$this->template->menu = NULL;
		$this->template->breadcrumb = array(
			Route::get('docs/guide')->uri() => __('User Guide'),
			Route::get('docs/guide')->uri().'/kadldap.about' => $this->template->title,
			'Configuration Test'
		);

		$view->message = FALSE;
		if (isset($_POST['login']))
		{
			$post = Validate::factory($_POST)
				->filter(TRUE,'trim')
				->rule('username', 'not_empty')
				->rule('username', 'min_length', array(1))
				->rule('password', 'not_empty');
			if($post->check())
			{
				$username = $post['username'];
				$password = arr::get($post, 'password', '');
				try
				{
					if (Auth::instance()->login($username, $password))
					{
						$view->message = 'Successful login.';
					} else
					{
						$view->message = 'Login failed.';
					}
				} catch (adLDAPException $e)
				{
					$view->message = $e->getMessage();
				}
			} else
			{
				$view->message = 'You must enter both your username and password.';
			}
		}

		if (Auth::instance()->logged_in())
		{
			$username = Auth::instance()->get_user();
			$password = Auth::instance()->password($username);
			$view->kadldap = Kadldap::instance();
			$view->kadldap->authenticate($username, $password);
		}
		
	}

	public function action_logout()
	{
		auth::instance()->logout();
		$this->request->redirect('kadldap');
	}

}