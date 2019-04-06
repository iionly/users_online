<?php
/**
 * Gallery listing view for online users
 *
 * @uses $vars['entity'] the user to list
 */

/* @var $user ElggUser */
$user = elgg_extract('entity', $vars);
$size = elgg_extract('size', $vars, 'tiny');

if ($user->isAdmin()) {
	$class = "usersonlineicon-$size usersonlineadminicon";
} else if ($user->isFriend()) {
	$class = "usersonlineicon-$size usersonlinefriendicon";
} else {
	$class = "usersonlineicon-$size";
}

echo elgg_view_entity_icon($user, $size, ['img_class' => $class]);
