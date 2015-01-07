<?php
/**
 * Materia
 * It's a thing
 *
 * @package	    Materia
 * @version    1.0
 * @author     UCF New Media
 * @copyright  2011 New Media
 * @link       http://kogneato.com
 */


/**
 * The go between for the user and the Materia Package.
 *
 * The widget managers for the Materia package.
 *
 * @package	    Main
 * @author      ADD NAME HERE
 */

namespace Materia;

class Widget_Manager
{

	/**
	 * Finds the widget(s) based on the widget_idS
	 *
	 * @param $widget_idS array The widget_idS that are needed to be looked up.
	 *
	 * @return array The information and metadata about the widget or widgets called for.
	 */
	static public function get_widgets($widget_ids=null)
	{
		$widgets = [];
		// =============== Get the requested widgets =================
		if (empty($widget_ids))
		{
			$results = \DB::select('id')
				->from('widget')
				->where('in_catalog', '1')
				->order_by('name')
				->execute();


			$ids = \Arr::flatten($results);

			// if logged in, add in any hidden widgets I can see
			if ($user_id = \Model_User::find_current_id())
			{
				$hidden = Perm_Manager::get_all_objects_for_user($user_id, Perm::WIDGET, [Perm::VISIBLE]);
				$ids = array_unique(array_merge($ids, $hidden));
			}

			if (count($ids) > 0)
			{
				foreach ($ids as $id)
				{
					$widgets[] = $widget = new Widget();
					$widget->get($id);
				}
			}
		}
		// =============== Get requested widgets ===============
		else
		{
			foreach ($widget_ids as $widget_id)
			{
				$widget = new Widget();
				$widget->get($widget_id);
				array_push($widgets, $widget);
			}
		}
		return $widgets;
	}

	static public function search($name)
	{
		$widget_ids = \DB::select('id')
			->from('widget')
			->where('name', 'LIKE', '%'.$name.'%')
			->execute()
			->as_array('id');

		return self::get_widgets(array_keys($widget_ids));
	}

}