<?php
/**
 * Users Online
 *
 * Show a box listing users who are currently logged in at the site at top of page
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
$users_online = elgg_list_entities([
	'type' => 'user',
	'limit' => $limit,
	'offset' => 0,
	'joins' => ["join {$dbprefix}users_entity u on e.guid = u.guid"],
	'wheres' => ["((u.last_action >= $time) and (u.admin in $show_admins)) or (u.guid = $logged_in_guid)"],
	'order_by' => "u.last_action desc",
	'list_type' => 'gallery',
	'item_view' => 'users_online/list/user',
]);

$table_content = elgg_format_element('td', ['class' => 'usersonlinetext'], elgg_format_element('h3', [], elgg_echo('users_online:online')));
if ($users_online) {
	$table_content .= elgg_format_element('td', [], $users_online);
} else {
	$table_content .= elgg_format_element('td', ['class' => 'usersonlinetext'], elgg_echo('users_online:noonline'));
}

$table_content = elgg_format_element('tr', [], $table_content);
$table_content = elgg_format_element('div', [], elgg_format_element('table', ['class' => 'usersonline', 'border' => '0', 'cellspacing' => '0', 'cellpadding' => '0'], $table_content));

echo elgg_format_element('div', ['align' => 'center', 'class' => 'mtn mbm'], $table_content);
