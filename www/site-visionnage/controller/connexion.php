<?php
	include('connexionBD.php');
	$login = $_POST['pseudo'];
	$password = $_POST['password'];
	$reponse = $bdd->query('SELECT * FROM users');
	while ($users = $reponse -> fetch())
	{
		if ($users['name_user'] == $login && $users['password'] == $password)
		{
			session_start();
			$_SESSION['login']=$login;
			$_SESSION['id_user']=$users['id_user'];
			$_SESSION['password']=$password;
			$_SESSION['age']=$users['age_user'];
			$_SESSION['occ']=$users['occ_user'];
			$connexion = 1 ;
		}
		elseif ($users['name_user'] == $login or $users['password'] == $password)
		{
			$champs = 2;
		}
	}
	if (isset($connexion))
	{
		echo $connexion;
	}
	elseif (isset($champs))
	{
		echo $champs;//Il manque un champ
	}
	else
	{
		echo $connexion = 0;//Fail login
	}
?>