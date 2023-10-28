<?php

session_start();

function validate_admin()
{
	if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] != "Admin") {
		header("Location: index.php");
	}
}
function validate_user()
{
	if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] != "User") {
		header("Location: index.php");
	}
}

function validate_login()
{
	if (isset($_SESSION["user"])) {
		header("Location: index.php");
	}
}
