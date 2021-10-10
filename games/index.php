<?php

require_once("../setting.php");

require_once("../common.php");

require_once("../portable-utf8.php");

$q = mysqli($_GET['q']);

$action = mysqli($_GET['action']);

if($action == "game") {

    require_once('pages/game.php');

}
else if($action == "category") {

    require_once('pages/category.php');

}
else if($action == "html") {

    require_once('pages/html.php');

}
else {

	require_once('pages/main.php');

}

?>