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

use Elgg\Database\QueryBuilder;

// limit number of users to be displayed
$limit = (int) elgg_get_plugin_setting('user_listing_limit', 'users_online');

// display admins currently logged in?
$show_admins = elgg_get_plugin_setting('show_admins', 'users_online');

// always added logged in user
$logged_in_guid = elgg_get_logged_in_user_guid();

// active users within the last 5 minutes
$time = time() - 300;

$users_online = elgg_list_entities([
	'type' => 'user',
	'limit' => $limit,
	'offset' => 0,
	'wheres' => function(QueryBuilder $qb, $alias) use ($time, $show_admins, $logged_in_guid) {
		$qb->orderBy('e.last_action', 'DESC');

		if ($show_admins != 'yes') {
			// Fetch guids of all admins
			$subquery = $qb->subquery('metadata', 'ad');
			$subquery->select('ad.entity_guid')
				->where($qb->compare('ad.name', '=', 'admin', ELGG_VALUE_STRING))
				->andWhere($qb->compare('ad.value', '=', 'yes', ELGG_VALUE_STRING));

			// We do not want the admins
			$admin_filter = $qb->compare('e.guid', 'NOT IN', $subquery->getSQL());

			$ands = $qb->merge([
				$qb->compare('e.last_action', '>=', $time, ELGG_VALUE_INTEGER),
				$admin_filter,
			]);
		} else {
			$ands = $qb->compare('e.last_action', '>=', $time, ELGG_VALUE_INTEGER);
		}

		$ors = [
			$qb->compare('e.guid', '=', $logged_in_guid, ELGG_VALUE_INTEGER),
			$ands,
		];

		return $qb->merge($ors, 'OR');
	},
	'list_type' => 'gallery',
	'item_view' => 'users_online/list/user',
	'size' => 'small',
	'no_results' => elgg_echo('users_online:noonline'),
]);

echo elgg_view_module('aside', elgg_echo('users_online:online'), $users_online);
