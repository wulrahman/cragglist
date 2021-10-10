<?php

$title = "Cragglist Games";

$description = "Cragglist gaming, Play and experience amazing; Action, Advanture, Racing, Sports, Shooter, Board & more gaming online, Free games online.";

$keywords = "action, adventure, racing, sports, shooter, board, puzzle, girls, education, cooking, casino, others, online gaming, collect ,points, gaming, games, cragglist, cragglist.com, play, online";

require_once('include/header.php');
?>

<main id="gamebody">
    
    <?php

    require_once('include/main_header.php');

    ?>

    <div class="otherbody">
        
        <?php

        include('include/ads.php');

        ?>
        
    </div>
    
    <article class="game_main_body">
        
        <div class="pure-u-1-5 mobile_display">
            
            <?php

            include('include/category_header.php');

            ?>

        </div><div id="main_width_home"  class="pure-u-4-5 mobile_display">

            <?php

            $user->error;

            ?>

            <div class="grid_featured">

                <div class="grid_header">Popular</div>

                <ul>

                    <?php
                    
                    $game_play = mysqli_query($setting["Lid"],'SELECT COUNT(*) AS `count`, `url` FROM `views` WHERE `url` LIKE "%/game/%" AND month(`timestamp`) = month(curdate()) GROUP BY `url` ORDER BY `count` DESC LIMIT 4');

                    while ($view_row = mysqli_fetch_object($game_play)) { 
                        
                        preg_match("/\/(\d+)$/", $view_row->url,$matches);
                        
                        $view_row->id = $matches['1'];
                        
                        $query = mysqli_query($setting['Lid'],"SELECT `id`,`name`,`image`,`description` FROM `games` WHERE `published`=1 AND `id` = '".$view_row->id."'");
                        
                        $row = mysqli_fetch_object($query);

                        $url="http:".$setting['games_url']."/game/".$row->id;

                        ?><li class="grid_game pure-u-1-4">

                            <div class="grid_image">

                                <a title="<?=$row->description?>" href="<?=$url?>">

                                    <div style="background-image:url(<?=$row->image?>);"></div>

                                </a>

                            </div>

                            <div class="grid_info">

                                <a title="<?=$row->name?>" href="<?=$url?>"><?=shortenStr($row->name, 9)?></a>

                            </div>

                        </li><?php

                    }

                    ?>

                </ul>

            </div>
  
            <?php

            $query = mysqli_query($setting['Lid'],"SELECT `name`,`seo_url`,`id` FROM `cats` WHERE `parent_id` = '0' ORDER BY `cat_order` ASC LIMIT 6");

            while($row = mysqli_fetch_object($query)) {

                ?>

                <div class="home_categories">

                    <div class="grid_header">

                        <a href="<?=$setting['games_url']?>/category/<?=urlencode($row->seo_url)?>"><?=$row->name?></a>

                    </div>

                    <ul>

                        <?php

                        $querycategory = mysqli_query($setting['Lid'],"SELECT `id`,`name`,`image`,`description` FROM `games` WHERE (`category` = '".$row->id."' OR `category_parent` = '".$row->id."') AND `published`='1' ORDER BY `id` DESC LIMIT 4");

                        while ($row = mysqli_fetch_object($querycategory)) { 

                            $url="http:".$setting['games_url']."/game/".$row->id;

                            ?><li class="grid_game pure-u-1-4">

                                <div class="grid_image">

                                    <a title="<?=$row->description?>" href="<?=$url?>">

                                        <div style="background-image:url(<?=$row->image?>);"></div>

                                    </a>

                                </div>

                                <div class="grid_info">

                                    <a title="<?=$row->name?>" href="<?=$url?>"><?=limit_text($row->name, 9)?></a>

                                </div>

                            </li><?php

                        }

                        ?>

                    </ul>

                </div>

            <?php

            }

            ?>

        </div>
    
    </article>

    <?php

    require_once("../common/include/main_footer.php");

    require_once("../common/include/footer.php"); 

    ?>
    
</main>