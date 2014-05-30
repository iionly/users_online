<?php
/**
 * Users Online
 *
 * @package users_online
 * @author iionly
 * @copyright iionly 2014
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @website https://github.com/iionly
 * @email iionly@gmx.de
 */

elgg_register_event_handler('init', 'system', 'users_online_init');

function users_online_init() {
	elgg_extend_view('css/elgg', 'users_online/css');
	if (elgg_is_logged_in()) {
		$display_option = elgg_get_plugin_setting('display_option', 'users_online');
		if (!display_option) {
			$display_option = 'top';
		}
		if ($display_option == 'top') {
			elgg_extend_view('page/elements/body', 'users_online/users_online', 400);
		} else if ($display_option == 'sidebar') {
			elgg_extend_view('page/elements/sidebar', 'users_online/sidebar');
		} else {
			elgg_extend_view('page/elements/body', 'users_online/users_online', 400);
			elgg_extend_view('page/elements/sidebar', 'users_online/sidebar');
		}
	}
}
