$(document).ready(function(){var showChar=300;var ellipsestext="...";var moretext="more";var lesstext="less";$('.more').each(function(){var content=$(this).html();if(content.length>showChar){var c=content.substr(0,showChar);var h=content.substr(showChar-1,content.length-showChar);var html=c+'<span class="moreellipses">'+ellipsestext+'&nbsp;</span><span class="morecontent"><span>'+h+'</span>&nbsp;&nbsp;<a href="" class="morelink">'+moretext+'</a></span>';$(this).html(html)}});$(".morelink").click(function(){if($(this).hasClass("less")){$(this).removeClass("less");$(this).html(moretext)}else{$(this).addClass("less");$(this).html(lesstext)}$(this).parent().prev().toggle();$(this).prev().toggle();return false})});
function pagefunction(f,e,i,h){var g=""+site_url+"/"+h+"ajax/"+e+".php";$.ajax({url:g,type:"POST",data:{page:f}}).done(function(a){$("#"+i+"").html(a)})}function pagefunctionid(g,f,k,j,i){var h=""+site_url+"/"+i+"ajax/"+f+".php";$.ajax({url:h,type:"POST",data:{page:g,id:j}}).done(function(a){$("#"+k+"").html(a)})}function report_show(){$("#report").css("display","block")}function report_hide(){$("#report").css("display","none")}function report(d,c){if($("#reportme").val().replace(/\s/g,"")!==""){$.ajax({url:""+site_url+"/pages/ajax/add_report.php",type:"POST",data:{id:c,type:d,report:$("#reportme").val()}}).done(report_hide(),$("#reportme").val(""))}}$(document).ready(function(){$("#ua_avatar").mouseenter(showUserMenu);$("#ua_avatar").mouseleave(hideUserMenu)});function showUserMenu(){$("#user_area_dropdown").css("display","block")}function hideUserMenu(){$("#user_area_dropdown").css("display","none")}
