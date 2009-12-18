<?php
/************************************************************************/
/* Transformable                                                        */
/************************************************************************/
/* Copyright (c) 2009                                                   */
/* Adaptive Technology Resource Centre / University of Toronto          */
/*                                                                      */
/* This program is free software. You can redistribute it and/or        */
/* modify it under the terms of the GNU General Public License          */
/* as published by the Free Software Foundation.                        */
/************************************************************************/

define('TR_INCLUDE_PATH', '../include/');

include(TR_INCLUDE_PATH.'vitals.inc.php');
include_once(TR_INCLUDE_PATH.'classes/DAO/UserGroupsDAO.class.php');

$userGroupsDAO = new UserGroupsDAO();

$ids = explode(',', $_REQUEST['id']);

if (isset($_POST['submit_no'])) 
{
	$msg->addFeedback('CANCELLED');
	header('Location: user_group.php');
	exit;
} 
else if (isset($_POST['submit_yes']))
{
	foreach($ids as $id) 
	{
		$userGroupsDAO->Delete($id);
	}

	$msg->addFeedback('ACTION_COMPLETED_SUCCESSFULLY');
	header('Location: user_group.php');
	exit;
}

require(TR_INCLUDE_PATH.'header.inc.php');

unset($hidden_vars);

foreach($ids as $id) 
{
	$row = $userGroupsDAO->getUserGroupByID($id);
	$names[] = $row['title'];
}

$names_html = '<ul>'.html_get_list($names).'</ul>';
$hidden_vars['id'] = $_REQUEST['id'];

$msg->addConfirm(array('DELETE_USER_GROUP', $names_html), $hidden_vars);
$msg->printConfirm();

require(TR_INCLUDE_PATH.'footer.inc.php');
?>
