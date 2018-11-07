<?php
/**
 * Gallery listing view for online users
 *
 * @uses $vars['entity'] the user to list
 */

/* @var $user ElggUser */
$user = elgg_extract('entity', $vars);

if ($user->isAdmin()) {
	$class = "usersonlineicon usersonlineadminicon";
} else if ($user->isFriend()) {
	$class = "usersonlineicon usersonlinefriendicon";
} else {
	$class = "usersonlineicon";
}

echo elgg_view_entity_icon($user, 'tiny', ['img_class' => $class]);
