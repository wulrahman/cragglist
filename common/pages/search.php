<?php

$q = mysqli($_GET['q']);

$title="Cragglist ".htmlspecialchars($q);

require_once('include/header.php');

require_once('include/main_header.php');

require_once('../stemming/wordstemmer.php');
require_once('../stemming/search.php');

require_once("../summary/SummaryTool.php");
require_once("../summary/SentenceTokenizer.php");

$i = 0;

$limit = '9';

$page = intval($_GET["page"]);

if ($page=="") {

	$page = 1;

}

$start = ($page-1) * $limit;

foreach(explode(" ",$q) as $p) {

	if(!space($p)) {

		$match[] = '('.$p.'*)';

	}

}

$matchs = implode(' ', $match);

$query = mysqli_query($setting["Lid"],"SELECT 

SQL_CALC_FOUND_ROWS

`id`, `type` 

FROM 

    (
        SELECT 

            `games`.`id`, '3' AS `type`, 

            ((MATCH(`games`.`name`) AGAINST ('".$matchs."' IN BOOLEAN MODE)) + (MATCH(`games`.`description`) AGAINST ('".$matchs."' IN BOOLEAN MODE))) AS `relevance` 

            FROM 

                `games`

            WHERE

                `games`.`published` = 1

            HAVING Relevance > 0

    ) AS `table`

ORDER BY `relevance` DESC

LIMIT ".$start.", ".$limit."

");

$query_sql = "SELECT COUNT(`id`) as `count`, `id` FROM `query` WHERE `query` = '".$q."'";

$common = extractCommonWords($q, 100);

$common = array_keys($common);

foreach($common as $p) {

    if(!space($p)) {

        $check[] = $p;

        if(strlen($p) > 1 ) {

            $bold[] = $p;

        }

    }

}


$expand = array_count_values(str_word_count(strtolower($q), 1));

$news_array = news_main($expand, $common, $q, $page, $limit, $deep_search, $query_row);

?>

<main>

	<article id="otherbody">

        <div class="otherbody">

            <?php require_once("../common/include/ads.php"); ?>

        </div>
        
        <div id="item-list">
            
            <?php
            
            foreach($news_array['results'] as $key => $news) { 

                $news = $news_array['results'][$key];

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

                     <a href="<?=$news['source']?>">

                         <div class="pure-u-5-24">

                            <img src="<?=$setting['main_url']?>/main/<?=$news['thumb_url']?>" class="item-thumb">

                        </div>

                         <div class="pure-u-13-24 item-list-product"><h5 class="item-name"><?=limit_text(urldecode($news['title']),9)?></h5>

                            <p class="item-desc">

                                <?=limit_text(strip_tags(indextext(urldecode($news['abstract']))),30)?>

                            </p>

                        </div>

                    </a>

                    </div>

                </li><?php

            }

			$count = array_pop(mysqli_fetch_row(mysqli_query($setting["Lid"],"SELECT FOUND_ROWS()")));

			if($count == 0) {

			?><div>

					<h1>No results for <b><?=htmlspecialchars($_GET['q'])?></b></h1>

				</div><?php

			}
			else { ?>

				<h1>Results for: <b><?=htmlspecialchars($_GET['q'])?></b></h1>

                <ul>

                    <?php

                    $i = 0;

                    while ($row = mysqli_fetch_object($query)) {

                        if($row->type == 3) {

                            $item_query = mysqli_query($setting['Lid'], "SELECT 

                            `games`.`category`, `games`.`id`, `games`.`name`, `games`.`image`, `games`.`description`

                            FROM 

                                `games` 

                            WHERE 

                                `games`.`published`='1' AND `games`.`id` = '".$row->id."'");

                            $row = mysqli_fetch_object($item_query);

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

                                 <a title="<?=$row->description?>" href="http:<?=$setting["games_url"]?>/game/<?=$row->id?>">

                                     <div class="pure-u-5-24">

                                        <img src="<?=$row->image?>" alt="<?=$row->name?>" class="item-thumb">

                                    </div>

                                     <div class="pure-u-13-24 item-list-product"><h5 class="item-name"><?=limit_text($row->name,9)?></h5>

                                        <p class="item-desc">

                                            <?=limit_text(strip_tags(indextext($row->description)),30)?>

                                        </p>

                                    </div>

                                </a>

                                </div>

                            </li><?php

                        }
                        
                    }

                    ?>

                </ul>

                <div class="pagination">

                    <?php

                    $previous = $page-1;

                    $next = $page+1;

                    $total = ceil($count / $limit);

                    $url =   $setting["url"].'/content?q='.urlencode($q).'&page=';

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

                </div><?php

            }

            ?>

        </div>

        <?php require_once("include/main_footer.php"); ?>

	</article>

</main>

<?php require_once("include/footer.php"); ?>