<?php
require_once '../classes/database.php';
require_once '../classes/utilisateur.php';
require_once '../classes/session.php';
require_once '../classes/ouvrier.php';
require_once '../classes/infos.php';
require_once '../classes/chef.php';
require_once 'users.php';

$session = new Session();

if(!empty($_POST['idchef'])) {
	
	$ch = new Chef();
	$ch->find_by_id($_POST['idchef']);
	$ch->delete();
	header('Location: ../gestion.php');

} else if(!empty($_POST['idouvrier'])) {

	$ou = new Ouvrier();
	$ou->find_by_id($_POST['idouvrier']);
	$ou->delete();
	header('Location: ../gestion.php?id='. $_POST['chefid']);

} else if(!empty($_POST['idinfo'])) {

    $in = new Infos();
    $in->find_by_id($_POST['idinfo']);
    $in_data = $in->get_infos();
    $in->delete();
    header('Location: ../rapports.php?id='. $in_data['o_id']);    
}