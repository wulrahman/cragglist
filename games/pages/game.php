<?php

$id=intval($_GET['id']);

$query=mysqli_query($setting['Lid'],"SELECT SQL_CALC_FOUND_ROWS `category`,`hits`,`name`,`width`,`height`,`url`,`timestamp`,`image` ,`filetype`,`code`,`instructions`,`description`,`id` FROM `games` WHERE `id`='".$id."'");

$count=array_pop(mysqli_fetch_array(mysqli_query($setting['Lid'],"SELECT FOUND_ROWS()")));

if($count > 0) {
    
	$row = mysqli_fetch_object($query);
    
	$title=$row->name;

	$description=$row->description;
    
	require_once('include/header.php');
    
	if ($user->login_status == 1) {	
        
		mysqli_query($setting['Lid'],"UPDATE `users` SET `plays` = `plays` + 1 WHERE `id`='".$user->id."'");
        
	}
    
	mysqli_query($setting['Lid'],"UPDATE `games` SET `hits` = `hits` + 1 WHERE `id`='".$row->id."'");
    
	?>

	<script>
	function gofullscreen(b){var a=document.getElementById(b);if(a.mozRequestFullScreen){a.mozRequestFullScreen()}else{if(a.webkitRequestFullScreen){a.webkitRequestFullScreen()}}}
	</script>

    <main id="otherbody">
        
        <?php

        require_once('include/main_header.php');
        
        include('include/ads.php');
    
        ?>

	   <div id="game_game">
        
            <div id="fullscreen">

                <?php

                if ($row->filetype == 'dcr') { ?>

                    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab" id="<?=$row->name?>" width="<?=$row->width?>" height="<?=$row->height?>" VIEWASTEXT>

                        <embed>

                            <param name="src" value="<?=$row->url?>">

                            <param name="swRemote" value="swSaveEnabled="true" swVolume="true" swRestart="true" swPausePlay="true" swFastForward="true" swContextMenu="true">
                            <param name="swStretchStyle" value="fill">
                            <param name="bgColor" value="#000000">
                            <param name="quality" value="high">
                            <param name="allowFullScreen" value="true">
                            <embed src="<?=$row->url?>" bgColor="#000000"  width="<?=$row->width?>" height="<?=$row->height?>" swRemote="swSaveEnabled="true" swVolume="true" swRestart="true" swPausePlay="true" swFastForward="true" swContextMenu="true" swStretchStyle="fill" type="application/x-director" pluginspage="http://www.adobe.com/go/getflashplayer" allowFullScreen="true">

                        </embed>

                    </object>

                    <?php

                } 
                else if (($row->filetype == 'png') || ($row->filetype == 'gif') || ($row->filetype == 'jpg') || ($row->filetype == 'jpeg')) {

                    echo '<img src="'.$row->image.'" width="'.$row->width.'" height="'.$row->height.'" >';

                }
                else if ($row->filetype == 'swf') { ?>

                    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab" width="<?=$row->width?>" height="<?=$row->height?>" id="<?=$row->name?>" align="middle">

                        <param name="movie" value="<?=$row->url?>">

                        <param name="quality" value="high">

                        <param name="bgcolor" value="#000000">

                        <param name="play" value="true">

                        <param name="loop" value="true">

                        <param name="wmode" value="direct">

                        <param name="scale" value="showall">

                        <param name="menu" value="true">

                        <param name="devicefont" value="false">

                        <param name="salign" value="">

                        <param name="allowScriptAccess" value="sameDomain">

                        <param name="allowFullScreen" value="true">

                        <!--[if !IE]>-->

                        <object type="application/x-shockwave-flash" data="<?=$row->url?>" codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab" width="<?=$row->width?>" height="<?=$row->height?>">

                            <param name="movie" value="<?=$row->url?>">

                            <param name="quality" value="high">

                            <param name="bgcolor" value="#000000">

                            <param name="play" value="true">

                            <param name="loop" value="true">

                            <param name="wmode" value="direct">

                            <param name="scale" value="showall">

                            <param name="menu" value="true">

                            <param name="devicefont" value="false">

                            <param name="salign" value="">

                            <param name="allowScriptAccess" value="sameDomain">

                            <param name="allowFullScreen" value="true">

                            <!--<![endif]-->

                            <a href="http://www.adobe.com/go/getflash">

                                <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player">

                            </a>

                        <!--[if !IE]>-->

                        </object>

                    <!--<![endif]-->

                    </object>

                <?php

                } 
                else if ($row->filetype == 'unity' || $row->filetype == 'unity3d') { ?>

                    <script type="text/javascript" src="http://webplayer.unity3d.com/download_webplayer-3.x/3.0/uo/UnityObject.js"></script>

                    <script type="text/javascript">

                        function GetUnity() {

                            if (typeof unityObject != "undefined") {

                                return unityObject.getObjectById("unityPlayer");

                            }

                            return null;

                        }

                        if (typeof unityObject != "undefined") {

                            unityObject.embedUnity("unityPlayer", "<?=$row->url?>", "<?=$row->width?>", "<?=$row->height?>");

                        }

                    </script>

                    <div style="margin: auto;width: <?=$row->width?>px;">

                        <div id="unityPlayer">

                            <div class="3dmissing">

                                <a href="http://unity3d.com/webplayer/" title="Unity Web Player. Install now!">

                                    <img alt="Unity Web Player. Install now!" src="http://webplayer.unity3d.com/installation/getunity.png" width="193" height="63" >

                                </a>

                            </div>

                        </div>

                    </div>

                <?php

                } 
                else if ($row->filetype == 'code' || $row->filetype == 'html') { 
                    
                     echo '<iframe src="'.$row->url.'" width="'.$row->width.'" height="'.$row->height.'" frameborder=0></iframe>';

                }
                else {

                    echo '<iframe src="'.$row->url.'" width="'.$row->width.'" height="'.$row->height.'" frameborder=0></iframe>';

                } 
                ?>

            </div>
        
        </div>

	   <article class="game_main_body">
        
            <?php
    
            include('include/ads.php');
    
            ?>
        
            <div id="game_details">

                <div class="game_title"><?=$row->name?></div>

                <div>

                    <?php

                    if($row->description!=="") {

                        echo '<div class="game_header">Description</div>
                        <div class="game_details">
                        '.str_ireplace('.', '. ',preg_replace('/\.\.+/', '.',strip_tags($row->description))).'
                        </div>';

                    }

                    if($row->instructions!=="") {

                        echo '<div class="game_header">Instructions</div>
                        <div class="game_details">
                        '.str_ireplace('.', '. ',preg_replace('/\.\.+/', '.',strip_tags($row->instructions))).'
                        </div>';

                    }

                    ?>

                </div>

            </div><?php

            if ($user->login_status == 1) {	

                mysqli_query($setting['Lid'],"UPDATE `users` SET `points` = `points` + 1 WHERE `id`='".$user->id."'");

            }

            ?><div>

                <?php

                foreach(array_filter(explode(" ",$row->name)) as $p) {

                    $qs[]='+'.$p;

                }

                $qs=mysqli(implode(" ",$qs));

                $more_query = mysqli_query($setting['Lid'],"SELECT 
                
                SQL_CALC_FOUND_ROWS 
                
                `id`,`name`,`image`,`description`, 
                ((MATCH(`description`) AGAINST ('".$qs."*' IN BOOLEAN MODE)) + (MATCH(`name`) AGAINST ('".$qs."*' IN BOOLEAN MODE))) AS `relevance` 
                
                FROM 
                
                    `games` 
                    
                WHERE 
                
                    `published`='1'  AND `id`!='".$row->id."' 
                    
                HAVING Relevance > 0.1  
                
                ORDER BY 
                
                    `relevance` DESC 
                    
                LIMIT 6");

                $count=array_pop(mysqli_fetch_array(mysqli_query($setting['Lid'],"SELECT FOUND_ROWS()")));

                if($count > 0) { 

                    ?>

                    <div id="more_games">

                        <div class="game_header">More games</div>

                        <ul>

                            <?php

                            while ($more = mysqli_fetch_object($more_query)) { 

                                $url="http:".$setting['games_url']."/game/".$more->id;

                                ?><li class="grid_game pure-u-1-6">

                                    <div class="grid_image">

                                        <a title="<?=$more->description?>" href="<?=$url?>">

                                            <div style="background-image:url(<?=$more->image?>);"></div>

                                        </a>

                                    </div>

                                    <div class="grid_info">

                                        <a title="<?=$more->name?>" href="<?=$url?>"><?=limit_text($more->name, 9)?></a>

                                    </div>

                                </li><?php
                                    
                            }

                            ?>

                        </ul>

                    </div><?php

                }

                ?>

            </div>

        </article>

        <?php

        require_once("../common/include/main_footer.php");

        require_once("../common/include/footer.php"); 

        ?>

    </main>

<?php
    
}
else { 
    
	require_once('../common/pages/404_require.php'); 
    
} 
?>