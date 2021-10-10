<?php

$id=intval($_GET['id']);

$query=mysqli_query($setting['Lid'],"SELECT SQL_CALC_FOUND_ROWS `url`, `filetype`, `code` FROM `games` WHERE `id`='".$id."'");

$count=array_pop(mysqli_fetch_array(mysqli_query($setting['Lid'],"SELECT FOUND_ROWS()")));

if($count > 0) {

    $row = mysqli_fetch_object($query);

    if(($row->filetype != 'dcr' && $row->filetype != 'swf' && $row->filetype != 'unity' && $row->filetype != 'unity3d') && ($row->filetype == 'code' || $row->filetype == 'html')) {

       echo htmllink($row);

    }

}

?>





