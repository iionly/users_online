<?php

use Elgg\DefaultPluginBootstrap;

class UsersOnlineBootstrap extends DefaultPluginBootstrap {

	public function init() {
		if (elgg_is_logged_in()) {
			$display_option = elgg_get_plugin_setting('display_option', 'users_online');
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
}
