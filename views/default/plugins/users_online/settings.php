<?php
/**
 * Users Online plugin settings
 *
 * @package users_online
 * @author iionly
 * @copyright iionly 2014
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @website https://github.com/iionly
 * @email iionly@gmx.de
 */

$plugin = elgg_extract('entity', $vars);

// get current plugin settings values and set to default values if not yet set
$user_listing_limit = (int) $plugin->user_listing_limit;
$display_option = $plugin->display_option;
$show_admins = $plugin->show_admins;

// set value for maximum number of online users to be listed
echo elgg_view_field([
	'#type' => 'number',
	'#label' => elgg_echo('users_online:settings:user_listing_limit'),
	'name' => 'params[user_listing_limit]',
	'min' => 1,
	'max' => 200,
	'step' => 1,
	'value' => $user_listing_limit,
]);

// set location where to list online users
echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('users_online:settings:display_option'),
	'name' => 'params[display_option]',
	'options_values' => [
		'top' => elgg_echo('users_online:settings:top'),
		'sidebar' => elgg_echo('users_online:settings:sidebar'),
		'both' => elgg_echo('users_online:settings:both'),
	],
	'value' => $display_option,
]);

// include admins in the list of online users?
echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('users_online:settings:show_admins'),
	'name' => 'params[show_admins]',
	'options_values' => [
		'yes' => elgg_echo('option:yes'),
		'no' => elgg_echo('option:no'),
	],
	'value' => $show_admins,
]);
