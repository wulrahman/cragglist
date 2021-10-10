<?php

$title = ucfirst($seo=$_GET['seo']);

$seo=mysqli($_GET["seo"]);

$page=intval($_GET['page']);

require_once('include/header.php');

if($page == 0) {
    
	$page=1;
    
}

$sortby=$_GET["sortby"];

$limit=16;

$query = mysqli_query($setting['Lid'],"SELECT SQL_CALC_FOUND_ROWS `id`,`seo_url` FROM `cats` WHERE `seo_url`='".$seo."' LIMIT 1");

$count=array_pop(mysqli_fetch_array(mysqli_query($setting['Lid'],"SELECT FOUND_ROWS()")));

if($count > 0) {

	$category_main = mysqli_fetch_object($query);
    
    $where = "`category`='".$category_main->id."' AND";
    
}
    
?>

<main id="otherbody">
    
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
            
        </div><div class="pure-u-4-5 mobile_display">

            <?php

            $key = array('a-z', 'z-a', 'newest', 'oldest', 'plays', 'highscores');

            $array=array('`name` ASC', '`name` DESC', '`id` DESC', '`id` ASC', '`hits` DESC', '`highscores` DESC');

            if(in_array($sortby, $key)) {

                $sort = $array[array_search($sortby, $key)];

            }
            else {

                $sort = '`id` DESC';

                $sortby="all";

            }

            $query = mysqli_query($setting['Lid'],"SELECT SQL_CALC_FOUND_ROWS `category`,`id`,`name`,`image`,`description` FROM `games` WHERE ".$where." `published`=1 ORDER BY ".$sort." LIMIT ".(($page-1)*$limit).",".$limit."");

            $count=array_pop(mysqli_fetch_array(mysqli_query($setting['Lid'],"SELECT FOUND_ROWS()")));

            if($count > 0) { 

            ?>

                <div id="item-list" class="otherbody-right">

                    <div id="sort_options">

                        <ul>

                            <?php

                            foreach(array('Newest','Oldest','Plays','Highscores','A-Z','Z-A') as $key) {

                                echo '<li><a href="'.$setting['games_url'].'/category/'.$seo.'/'.strtolower($key).'">'.$key.'</a></li>';

                            }

                            ?>

                        </ul>

                    </div>

                    <ul>

                        <?php

                        while ($row = mysqli_fetch_object($query)) { 

                            $url="http:".$setting['games_url']."/game/".$row->id;

                            ?>

                            <li class="game_itemlist">

                                <?php

                                $i++;

                                if($i % 2 == 0) {

                                    echo '<div class="item-list pure-g item-list-even">';

                                }
                                else {

                                    echo '<div class="item-list pure-g">';

                                }

                                ?>

                                 <a title="<?=$row->description?>" href="<?=$url?>">

                                     <div class="pure-u-5-24">

                                        <img src="<?=$row->image?>" alt="<?=$row->name?>" class="item-thumb">

                                    </div>

                                    <div class="pure-u-19-24 item-list-product"><h5 class="item-name"><?=limit_text($row->name,9)?></h5>

                                        <p class="item-desc">

                                            <?=limit_text(strip_tags(indextext($row->description)),30)?>

                                        </p>

                                    </div>

                                </a>

                                </div>

                            </li>

                        <?php

                        }

                        ?>

                    </ul>

                    <div class="pagination">

                        <?php

                        $previous = $page-1;

                        $next = $page+1;

                        $total = ceil($count / $limit);

                        $url = $setting["games_url"].'/category/'.$seo.'/'.$sortby.'/';

                        if ($page > 1){

                            echo '<li><a href="'.$url.$previous.'">Previous</a></li>';

                        }

                        for ($i = max(1, $page - 5); $i <= min($page + 5, $total); $i++) {

                            echo '<li><a href="'.$url.$i.'">'.$i.'</a></li>';

                        }

                        if ($page < $total){

                            echo '<li><a href="'.$url.$next.'">Next</a></li>';

                        }

                        ?>

                    </div>

                </div>

                <?php

            }
            else {

                echo '<div class="errors">No games where found.</div>';

            }

        ?></div>

    </article>

    <?php

    require_once("../common/include/main_footer.php");

    require_once("../common/include/footer.php"); 

    ?>

</main>
