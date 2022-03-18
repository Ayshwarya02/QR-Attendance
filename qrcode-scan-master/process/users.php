<?php
	require_once(__DIR__.'/../classes/database.php');
	require_once(__DIR__.'/../classes/utilisateur.php');
	require_once(__DIR__.'/../classes/session.php');
	require_once(__DIR__.'/../lib/password.php');

	global $id;
    function user_exists($username)
	{
	    global $db;
		$sql = 'SELECT u_id FROM utilisateur WHERE username = :username';
		$re=$db->query($sql,array("username"=>$username));
		$resultat=$re->fetch();

		if (empty($resultat)) {
			return false;
		} else {
			$GLOBALS['id'] = $resultat['u_id'];
			return true;
		}
	}

	function user_active($username)
	{
	    global $db;
	    $sql = 'SELECT u_id FROM utilisateur WHERE username = ? AND u_validation = ?';
		$re=$db->query($sql,array($username, 1));
		$resultat=$re->fetch();

		if (empty($resultat)) {
			return false;
		} else {
			return true;
		}
	}
