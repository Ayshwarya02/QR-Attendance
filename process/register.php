<?php
	require_once(__DIR__.'/../classes/database.php');
	require_once(__DIR__.'/../classes/utilisateur.php');
	require_once(__DIR__.'/../classes/session.php');
	require_once(__DIR__.'/../lib/password.php');
	require_once(__DIR__.'/users.php');

  	$session = new Session();

  	$valid = true;

	if (!empty($_POST)) {
	  $requiredFields = array('firstname', 'lastname', 'email', 'password', 'confirm_password');
	  foreach ($_POST as $key => $value) {
	    if (empty($value) && in_array($key, $requiredFields)) {
	      $session->message('Tous les champs sont obligatoires.');
	      $valid = false;
	      header('Location: ../signup.php');
	    }
	  }

	if(!$session->is_there_any_msg()) {
	  if (user_exists($_POST['email'])) {
	    $session->message('Désolé l\'adresse email: ' . $_POST['email'] . ' est déjà utilisé par un autre membre');
	    $valid = false;
	    header('Location: ../signup.php');
	  }

	  if (strlen($_POST['password']) < 6) {
	    $session->message('Le mot de passe doit être de 6 caractères ou plus');
	    $valid = false;
	    header('Location: ../signup.php');
	  }

	  if ($_POST['password'] !== $_POST['confirm_password']) {
	    $session->message('Les mots de passe saisis ne sont pas identiques');
	    $valid = false;
	    header('Location: ../signup.php');
	  }
	}
}

  	if ($valid) {
		$emailcode = md5($_POST['email'] + microtime());
		$emailcode = substr($emailcode, -13, 7);
		$register_data = array(
			'u_nom' => ucfirst($_POST['lastname']),
			'u_prenom' => ucfirst($_POST['firstname']),
			'username' => $_POST['email'],
			'u_password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
			'u_validation' => 1,
		);
		$_SESSION['data'] = $register_data;
		$_SESSION['code'] = $emailcode;
		$ut = new Utilisateur();
		foreach ($register_data as $key => $value) {
			$ut->set_utilisateur($key,$value);
		}
		if ($ut->create()) {
			header('Location: ../login.php');
		} else {
			var_dump($ut);
		}
	}
