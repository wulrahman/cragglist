<?php

if($user->admin == 1) {

	require_once('include/header.php');

	require_once('include/main_header.php');

	require_once('include/main_nav.php');

	$user = array_pop(mysqli_fetch_row(mysqli_query($setting["Lid"],'SELECT COUNT(`id`) FROM `users` WHERE month(`timestamp`) = month(curdate())')));

    $game_play = mysqli_fetch_object(mysqli_query($setting["Lid"],'SELECT COUNT(`id`) as `hits` FROM `views` WHERE `url` LIKE "%/game/%" AND month(`timestamp`) = month(curdate())'));


	$user_old = array_pop(mysqli_fetch_row(mysqli_query($setting["Lid"],'SELECT COUNT(`id`) FROM `users` WHERE month(`timestamp`) = month(curdate() - interval 30 day)')));
    
	$game_play_old = mysqli_fetch_object(mysqli_query($setting["Lid"],'SELECT COUNT(`id`) as `hits` FROM `views` WHERE `url` LIKE "%/game/%" AND month(`timestamp`) = month(curdate() - interval 30 day)'));


	$user_percentage = round((($user->users - $user_old->users) / $user->users)*100);
    
    $game_percentage = round((($game_play->hits - $game_play_old->hits) / $game_play->hits)*100);


	?>

	<main>

		<article id="dashbody" class="">

			<ul id="summary">

				<li class="pure-u-1-2 member dashboard-summary-mobile">

					<div class="summarymain">

						<h3 class="summaryvalue"><span class="fa fa-user icon" aria-hidden="true"></span><?=$user?><?php

	          if ($user_percentage < 0) {

	            echo '<span class="changestatistics decrease">'.$user_percentage.'%</span>';

	          }
	          else {

	            echo '<span class="changestatistics increase">+'.$user_percentage.'%</span>';

	          }

	          ?></h3>

						<span class="summarydescription">Members</span>

					</div>

				</li><li class="pure-u-1-2 download dashboard-summary-mobile">

					<div class="summarymain">

						<h3 class="summaryvalue"><span class="fa fa-download icon" aria-hidden="true"></span><?=$game_play->hits?><?php

	          if ($game_percentage < 0) {

	            echo '<span class="changestatistics decrease">'.$game_percentage.'%</span>';

	          }
	          else {

	            echo '<span class="changestatistics increase">+'.$game_percentage.'%</span>';

	          }

	          ?></h3>

						<span class="summarydescription">Game Plays</span>

					</div>

				</li>

			</ul>

			<div id="rowdashboard">

				<div class="pure-u-2-3 chart mobile_display">

					<div class="chartmain">

						<div id="content">

							<form class="form-horizontal">

								<fieldset>

									<div class="input-prepend">

										<span class="add-on"><i class="icon-calendar"></i></span><input type="text" name="range" id="range" />

									</div>

								</fieldset>

							</form>

							<div id="placeholder">

								<figure id="chart"></figure>

							</div>

						</div>

					</div>

				</div><div id="dolist" class="pure-u-1-3 mobile_display">

					<ul>

						<li>Seo Marketing</li>

						<li>Monitoring user interactions</li>

						<li>Updating API structure</li>

					</ul>

				</div>

			</div>

			<?php require_once("../common/include/main_footer.php"); ?>

		</article>

	</main>

	<?php require_once("../common/include/main_footer.php"); ?>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

	<!-- xcharts includes -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/d3/2.10.0/d3.v2.js"></script>

	<!-- Our main script file -->
	<script src="<?=$setting["admin_url"]?>/files/js/dashboard.js"></script>

<?php
}
else {

	require_once('../common/pages/404.php');

}

?>
