 
<?php

if($user->admin == 1) {

	require_once('include/header.php');

	require_once('include/main_header.php');

	require_once('include/main_nav.php');
    
    $page=intval($_GET['page']);

    if ($page == 0) {

        $page = 1;

    }

    $limit = 16;
    
    $categorys = $_GET['category'];
    
    if(isset($categorys)) {
                    
        $category_query = mysqli_query($setting['Lid'],"SELECT SQL_CALC_FOUND_ROWS `id` FROM `cats` WHERE `parent_id` = 0 AND `seo_url`='".$categorys."'");

        $count=array_pop(mysqli_fetch_array(mysqli_query($setting['Lid'],"SELECT FOUND_ROWS()")));
        
        if($count > 0) {
            
            $category_row = mysqli_fetch_object($category_query);
            
            $addsql_array[] = "`category`='".$category_row->id."'";
            
        }   
        else {
            
            $categorys = 'all';
            
        }

    }
    else {
        
        $categorys = 'all';
        
    }
    
    ?>

    <main>
        
        <div class="pure-u-1-5 mobile_display">
            
            <div class="category_nav">

                <div>

                    <nav class="pure-menu custom-restricted-width">

                        <ul class="pure-menu-list">

                            <li class="pure-menu-item"><a class="pure-menu-link" href="<?=$setting['games_url']?>/games/all">All</a></li>

                            <?php

                            $query = mysqli_query($setting['Lid'],"SELECT `name`,`seo_url` FROM `cats` WHERE `parent_id` = 0 ORDER BY `cat_order` LIMIT 10");

                            while ($category = mysqli_fetch_object($query)) {

                                echo '<li class="pure-menu-item"><a class="pure-menu-link" href="'.$setting["admin_url"].'/games/'.$category->seo_url.'">'.$category->name.'</a></li>';

                            }

                            ?>

                            <li id="navbutton2" class="pure-menu-has-children pure-menu-allow-hover">

                                <a href="#" id="menuLink1" class="pure-menu-link">More</a>

                                <ul class="pure-menu-children">

                                    <?php

                                    $query = mysqli_query($setting['Lid'],"SELECT `name`,`seo_url` FROM `cats` WHERE `parent_id` = 0 ORDER BY `cat_order` LIMIT 10, 100");

                                    while ($category = mysqli_fetch_object($query)) {

                                        echo '<li class="pure-menu-item"><a class="pure-menu-link" href="'.$setting["admin_url"].'/games/'.$category->seo_url.'">'.$category->name.'</a></li>';

                                    }

                                    ?>

                                </ul>

                            </li>

                        </ul>

                    </nav>

                </div>

            </div>
            
        </div><div class="pure-u-4-5 mobile_display">

            <article id="otherbody">

                <a href="<?=$setting["admin_url"]?>/addgame">ADD GAME</a>

                <div>

                    <?php

                    if(count($addsql_array) > 0) {

                        $addsql = "WHERE ".implode(" AND ", $addsql_array);

                     }

                    $query = mysqli_query($setting['Lid'],"SELECT SQL_CALC_FOUND_ROWS `category`,`id`,`name`,`image`,`description` FROM `games` ".$addsql." ORDER BY `id` DESC LIMIT ".(($page-1)*$limit).",".$limit."");

                    $count=array_pop(mysqli_fetch_array(mysqli_query($setting['Lid'],"SELECT FOUND_ROWS()")));

                    if($count > 0) { 

                    ?>

                        <div id="item-list">

                            <ul>

                                <?php

                                while ($row = mysqli_fetch_object($query)) { 

                                    $url=$setting["admin_url"]."/editgame/".$row->id;

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

                                             <div class="pure-u-3-24 hide_mobile">

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

                                $url = $setting["admin_url"].'/games/'.$categorys.'/';

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

                <?php require_once("../common/include/main_footer.php");?>

           </article>

        </div>
    
    </main>

    <?php
    
	require_once("../common/include/main_footer.php");
}
else {

	require_once('../common/pages/404.php');

}

?>