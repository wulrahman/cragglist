<div class="category_nav">
    
    <div>

		<nav class="pure-menu custom-restricted-width">

			<ul class="pure-menu-list">
                
                <li class="pure-menu-item"><a class="pure-menu-link" href="<?=$setting['games_url']?>/category/all">All</a></li>

                <?php

                $query = mysqli_query($setting['Lid'],"SELECT `name`,`seo_url` FROM `cats` WHERE `parent_id` = 0 ORDER BY `cat_order` LIMIT 10");

                while ($category = mysqli_fetch_object($query)) {

                    echo '<li class="pure-menu-item"><a class="pure-menu-link" href="'.$setting['games_url'].'/category/'.$category->seo_url.'">'.$category->name.'</a></li>';

                }

                ?>

				<li id="navbutton2" class="pure-menu-has-children pure-menu-allow-hover">

					<a href="#" id="menuLink1" class="pure-menu-link">More</a>

				    <ul class="pure-menu-children">

                        <?php

                        $query = mysqli_query($setting['Lid'],"SELECT `name`,`seo_url` FROM `cats` WHERE `parent_id` = 0 ORDER BY `cat_order` LIMIT 10, 100");

                        while ($category = mysqli_fetch_object($query)) {

                            echo '<li class="pure-menu-item"><a class="pure-menu-link" href="'.$setting['games_url'].'/category/'.$category->seo_url.'">'.$category->name.'</a></li>';

                        }

                        ?>

					</ul>
            
				</li>

            </ul>
            
        </nav>

	</div>

</div>