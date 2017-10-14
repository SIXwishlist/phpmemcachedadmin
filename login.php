<?php
/**
 * Copyright 2010 Cyrille Mahieux
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and limitations
 * under the License.
 *
 * ><)))°> ><)))°> ><)))°> ><)))°> ><)))°> ><)))°> ><)))°> ><)))°> ><)))°>
 *
 * Live Stats top style
 *
 * @author Cyrille Mahieux : elijaa(at)free.fr
 * @since 12/04/2010
 */
# Require
require_once 'Library/Bootstrap.php';

# We need to make sure we have a password
$password = $_ini->get('password');
if ($password === false)
{
	$_ini->set('password', bin2hex(random_bytes(15)));
	$_ini->write();
	die("New password was set, please refresh the webpage.<br>If this message will appear again, check chmod of your settings file.");
}

# Start session
session_start();

# Initializing requests
$request = (isset($_REQUEST['request_command'])) ? $_REQUEST['request_command'] : null;

switch ($request) {

	case "do-logout":
		$logout = isset($_SESSION['login']);
		unset($_SESSION['login']);
		include 'View/Login/Login.phtml';
		die("");
	
	case "do-login":
		$password2 = (isset($_REQUEST['pass'])) ? $_REQUEST['pass'] : false;
		if (strcasecmp($password, $password2) != 0) {
			$error = "Password incorrect, please try again";
		} else {
			$_SESSION['login'] = true;
		}
		
	default:
		# Showing login form
		if (!isset($_SESSION['login'])) {
			include 'View/Login/Login.phtml';
			die("");
		}
		
		if (basename($_SERVER['SCRIPT_NAME']) === 'login.php')
			header("Location: index.php");
}



session_write_close();