<?php
/**
 * Users Online
 *
 * Show users who are currently logged in the sidebar
 * with blue border around users' avatars who are friends of logged in user
 *
 * @package users_online
 * @author iionly
 * @copyright iionly 2014
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @website https://github.com/iionly
 * @email iionly@gmx.de
 */

// limit number of users to be displayed
$limit = (int) elgg_get_plugin_setting('user_listing_limit', 'users_online', 20);
// display admins currently logged in?
$show_admins = elgg_get_plugin_setting('show_admins', 'users_online', 'yes');
$show_admins = ($show_admins == 'yes') ? "('yes', 'no')" : "('no')";

// always added logged in user
$logged_in_guid = elgg_get_logged_in_user_guid();

// active users within the last 5 minutes
$dbprefix = elgg_get_config('dbprefix');
$time = time() - 300;
$users_online = elgg_get_entities([
	'type' => 'user',
	'limit' => $limit,
	'joins' => ["join {$dbprefix}users_entity u on e.guid = u.guid"],
	'wheres' => ["((u.last_action >= $time) and (u.admin in $show_admins)) or (u.guid = $logged_in_guid)"],
	'order_by' => "u.last_action desc",
	'batch' => true,
]);

$body = '';
if ($users_online) {
	foreach($users_online as $user) {
		if ($user->isAdmin()) {
			$class = "usersonlineadminicon";
		} else if ($user->isFriend()) {
			$class = "usersonlinefriendicon";
		} else {
			$class = "usersonlineicon";
		}
		$body .= elgg_view_entity_icon($user, 'tiny', ['img_class' => $class]);
	}
} else {
	$body = elgg_echo('users_online:noonline');
}

echo elgg_view_module('aside', elgg_echo('users_online:online'), $body);
