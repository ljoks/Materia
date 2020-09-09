<?php
/**
 * Materia
 * License outlined in licenses folder
 */

class Controller_Support extends Controller
{

	use Trait_CommonControllerTemplate {
		before as public common_before;
	}

	public function before()
	{
		$this->common_before();
		if ( ! \Materia\Perm_Manager::is_support_user() ) throw new \HttpNotFoundException;
		Css::push_group('support');
		Js::push_group(['angular', 'materia', 'admin']);
		parent::before();
	}

	public function get_user()
	{
		$this->theme->get_template()->set('title', 'User Support');
		$this->theme->set_partial('footer', 'partials/angular_alert');
		$this->theme->set_partial('content', 'partials/support/user');
	}
}