<?php
session_start();
 $app_id = "399674773411831";
 $app_secret = "38e6be5bce1da6bf392a431ee02b8775";

$my_url = "http://vegam.co/auth/facebook/callback.php"; //For example http://localhost/myFbApp/callback.php



//You will get this from connect.php as a query parameter

$code = $_REQUEST["code"];
//header( 'Location: http://vegam.co/fb/store.php?' . $code);
//echo "code..." . $code; echo "</br>";

$token_url = "https://graph.facebook.com/oauth/access_token?client_id=". $app_id . "&redirect_uri=" . urlencode($my_url) . "&client_secret=". $app_secret . "&code=" . $code."&scope=user_about_me,friends_about_me,user_activities,friends_activities,user_birthday,friends_birthday,user_checkins,friends_checkins,user_education_history,friends_education_history,email,user_events,friends_events,user_groups,friends_groups,user_hometown,friends_hometown,user_interests,friends_interests,user_likes,friends_likes,user_location,friends_location,user_notes,friends_notes,user_photos,friends_photos,user_questions,friends_questions,user_relationships,friends_relationships,user_relationship_details,friends_relationship_details,user_religion_politics,friends_religion_politics,user_status,friends_status,user_subscriptions,friends_subscriptions,user_videos,friends_videos,user_website,friends_website,user_work_history,friends_work_history,read_friendlists,read_insights,read_mailbox,read_requests,read_requests,xmpp_login,ads_management,create_event,manage_friendlists,manage_notifications,user_online_presence,friends_online_presence,publish_checkins,rsvp_event,publish_actions,user_actions.music,friends_actions.music,user_actions.news,friends_actions.news,user_actions.video,friends_actions.video,user_games_activity,friends_games_activity,manage_pages,read_stream,publish_stream";


//Access Token is here 
$access_token = @file_get_contents($token_url);

$_SESSION['access_token'] = $access_token;
/*echo $_SESSION['access_token'];
$graph_url = "https://graph.facebook.com/me?access_token=" . $access_token;
$user = @json_decode(file_get_contents($graph_url));
print_r($user);*/


header( 'Location: http://vegam.co/auth/facebook/store.php?' . $_SESSION['access_token']);

?>