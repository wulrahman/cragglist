<?php

require_once("../setting.php");

require_once("../portable-utf8.php");

require_once("../common.php");

if($user->admin ==1) {

	$type=$_GET['type'];

	$id=intval($_GET['id']);

	if($type == "home") {

		require_once("auth/home.php");

	}
	else if($type == "members") {

		if($id > 0) {

            require_once("auth/editmember.php");

		}
		else {

			require_once("auth/members.php");

		}

	}
	else if($type == "comments") {

		require_once("auth/comments.php");

	}
	else if($type == "image" && $id > 0) {

		require_once("auth/editimage.php");

	}
	else if($type == "email") {

		if($id > 0) {

			require_once("auth/viewemail.php");

		}
		else {

			require_once("auth/email.php");

		}

	}
    else if($type == "categories"){

		if($id > 0) {

            require_once("auth/editcategory.php");

		}
		else {

            require_once("auth/categories.php");

		}

	}
    else if ($type == 'games') { 
        
        if($id > 0) {

            require_once("auth/editgame.php");

		}
		else {

            require_once("auth/games.php");

		} 

    }
    else if ($type == 'feed') { 

        require_once("auth/feed.php"); 

    }
    else if ($type == 'addgame') { 

        require_once("auth/addgame.php"); 

    }
    else if ($type == 'kongregate') { 

        require_once("auth/kongregate.php"); 

    }
    else if ($type == 'fog') { 

        require_once("auth/fog.php"); 

    }
	else if ($type == 'curl') {

		require_once("auth/curl.php");

	}
	else if($type == "404"){

		require_once("../common/pages/404.php");

	}
	else {

		require_once("auth/home.php");

	}


}
else {

	require_once("../common/pages/404.php");

}

?>
