<?php
session_start();
if(isset($_SESSION['access_token']))
{
	$acc = $_SESSION['access_token'];//echo $acc;echo "</br>";
	$id = explode("&",$acc);
	//echo $id[0];
	$graph_url = "https://graph.facebook.com/me?" . $id[0];
	$user = @json_decode(file_get_contents($graph_url));
	$f_url = "https://graph.facebook.com/me/friends?fields=id,name,first_name,middle_name,last_name,gender,locale,languages,link,username,third_party_id,installed,timezone,updated_time,verified,bio,birthday,cover,currency,devices,education,email,hometown,interested_in,location,political,favorite_athletes,favorite_teams,picture,quotes,relationship_status,religion,security_settings,significant_other,video_upload_limits,website,work,family,groups&" . $id[0];
	
	//print_r($fuser);
	mysql_connect("vegam.db.9034621.hostedresource.com","vegam","Ingersol1");
	mysql_select_db("vegam");
	foreach($user as $key=>$val){	
	switch($key){
	case "id":
		$_SESSION['i'] = $val;$id = $val;//echo "ln..." . $_SESSION['lid'];echo "fb..." . $_SESSION['fid'];
		$sqlstt = "insert into fb_profile (id) VALUES ($val)";
		mysql_query($sqlstt);
		$stt = "insert into fv_sports (uid) VALUES ($val)";
		mysql_query($stt);
		$stt1 = "insert into fb_id (id) VALUES ($val)";
		mysql_query($stt1);
		$sqlstt = "insert into fb_it (id) VALUES ($val)";
		mysql_query($sqlstt);

		$ses = $_SESSION['fid']; $ses1 = $_SESSION['lid'];
		$csqlstt = "UPDATE  `vegam`.`cont_lf` SET  `fid` =  '$val' WHERE `cont_lf`.`sessionid` = '$ses' OR `cont_lf`.`sessionid` = '$ses1'";
		mysql_query($csqlstt);	
		$tok = $_SESSION['access_token'];
		$sql2 = "update fb_profile set acc_tok = '$tok' where id = $id";
		mysql_query($sql2);
		break;
	
	case "name":
		$sqlstt = "update fb_profile set name = '$val' where id = $id";
		mysql_query($sqlstt);break;
	case "first_name":
		$sqlstt = "update fb_profile set first_name = '$val' where id = $id";
		mysql_query($sqlstt);break;
	case "last_name":
		$sqlstt = "update fb_profile set last_name = '$val' where id = $id";
		mysql_query($sqlstt);break;
	case "link":
		$sqlstt = "update fb_profile set link = '$val' where id = $id";
		mysql_query($sqlstt);break;
	case "username":
		$sqlstt = "update fb_profile set username = '$val' where id = $id";
		mysql_query($sqlstt);break;
	case "birthday":
		$sqlstt = "update fb_profile set birthday = '$val' where id = $id";
		mysql_query($sqlstt);break;
	case "hometown":
		$hti = $user->hometown->id;$htn = $user->hometown->name;
		$sqlstt = "update fb_profile set hometown = '$htn' where id = $id";
		mysql_query($sqlstt);break;
	case "location":
		$loci = $user->location->id;$locn = $user->location->name;
		$sqlstt = "update fb_profile set location = '$locn' where id = $id";
		mysql_query($sqlstt);break;
	case "bio":
		$sqlstt = "update fb_profile set bio = '$val' where id = $id";
		mysql_query($sqlstt);break;
	case "quotes":
		$sqlstt = "update fb_profile set quotes = '$val' where id = $id";
		mysql_query($sqlstt);break;
	case "favorite_athletes":
		/*echo $user->favorite_athletes[0]->id;echo $user->favorite_athletes[0]->name;echo "</br>";
		echo $user->favorite_athletes[1]->id;echo $user->favorite_athletes[1]->name;echo "</br>";
		echo $user->favorite_athletes[2]->id;echo $user->favorite_athletes[2]->name;echo "</br>";*/
		//echo sizeof($val);echo "</br>";

		/*for($i = 0; $i <= sizeof($val); $i++)
		{
			$ai = $user->favorite_athletes[$i]->id;$an = $user->favorite_athletes[$i]->name;
			$sqlstt = "insert into fb_athelete VALUES ($ai,'$an') where uid = $_SESSION['i']";
			mysql_query($sqlstt);
		}*/
	break;
	case "gender":
		$i = $_SESSION['i'];
		$sqlstt = "UPDATE  `vegam`.`fb_id` SET  `gender` =  '$val' WHERE `fb_id`.`id` =$i ";
		mysql_query($sqlstt);break;
	case "interested_in":
		$in = $user->interested_in[$i];
		$uid = $_SESSION['i'];
		$sqlstt = "UPDATE  `vegam`.`fb_profile` SET  `interested_in` =  '$in' WHERE  `fb_profile`.`id` =$uid";
		mysql_query($sqlstt);break;
	case "relationship_status":
		$i = $_SESSION['i'];
		$sqlstt = "UPDATE  `vegam`.`fb_profile` SET  `relationship_status` =  '$val' WHERE  `fb_profile`.`id` =$i ";
		mysql_query($sqlstt);break;
	case "religion":
		$sqlstt = "update fb_profile set religion = '$val' where id = $i";
		mysql_query($sqlstt);break;
	case "political":
		$sqlstt = "update fb_profile set political = '$val' where id = $i";
		mysql_query($sqlstt);break;
	case "email":
		$i = $_SESSION['i'];//echo $i;
		$sqlstt = "UPDATE  `vegam`.`fb_id` SET  `email` =  '$val' WHERE `fb_id`.`id` =$i ";
		mysql_query($sqlstt);
		
		break;
	case "website":
		$i = $_SESSION['i'];
		$sqlstt = "UPDATE  `vegam`.`fb_profile` SET  `website` =  '$val' WHERE  `fb_profile`.`id` =$i ";
		mysql_query($sqlstt);break;
	case "timezone":
		$i = $_SESSION['i'];
		$sqlstt = "UPDATE  `vegam`.`fb_profile` SET  `timezone` =  '$val' WHERE  `fb_profile`.`id` =$i ";
		mysql_query($sqlstt);break;
	case "locale":
		$i = $_SESSION['i'];
		$sqlstt = "UPDATE  `vegam`.`fb_profile` SET  `locale` =  '$val' WHERE  `fb_profile`.`id` =$i ";
		mysql_query($sqlstt);break;
	case "languages":
		$uid = $_SESSION['i'];
		//echo sizeof($val);echo "</br>";
		for($i = 0; $i <= sizeof($val); $i++)
		{
			$li = $user->languages[$i]->id;$ln = $user->languages[$i]->name;
			$sqlstt = "INSERT INTO  `vegam`.`fb_lang` (`id`,`name`) VALUES ('$li','$ln') ";
			mysql_query($sqlstt);
			$stt2 = "UPDATE  `vegam`.`fb_lang` SET  `uid` =  $uid WHERE  `fb_lang`.`id` =$li";
			mysql_query($stt2);		
		}

		break;
	case "verified":
		//echo "veri..." . $val;
		$v = $val;
		$sqlstt = "update fb_profile set verified = $v where id = $i";
		mysql_query($sqlstt);break;
	case "updated_time":
		$i = $_SESSION['i'];
		$sqlstt = "UPDATE  `vegam`.`fb_profile` SET  `updated_time` =  '$val' WHERE  `fb_profile`.`id` =$i ";
		mysql_query($sqlstt);break;
	case "work":
		//echo sizeof($val);echo "</br>";
		$uid = $_SESSION['i'];
		for($i = 0; $i <= sizeof($val); $i++)
		{
			$ei = $user->work[$i]->employer->id;$en = $user->work[$i]->employer->name;
			$pi = $user->work[$i]->position->id;$pn = $user->work[$i]->position->name;
			$sd = $user->work[$i]->start_date;$ed = $user->work[$i]->end_date;

			$sqlstt = "INSERT INTO  `vegam`.`fb_work` (`ei` ,`en` ,`pi` ,`pn` ,`sd`,`ed` ) VALUES ('$ei',  '$en',  '$pi',  '$pn',  '$sd',  '$pi')";
			mysql_query($sqlstt);
			$sql = "UPDATE  `vegam`.`fb_work` SET  `uid` =  $uid WHERE  `fb_work`.`ei` =$ei";
			mysql_query($sql);
		}
		break;
	case "education":
		//$S = sizeof($val);echo "school..." . $s ."</br>";
		$uid = $_SESSION['i'];
		for($i = 0; $i <= sizeof($val); $i++)
		{
			$si = $user->education[$i]->school->id;
			$sn = $user->education[$i]->school->name;
			$st = $user->education[$i]->type;
			$swi = $user->education[$i]->with->id;
			$swn = $user->education[$i]->with->name;
			$syi = $user->education[$i]->year->id;
			$syn = $user->education[$i]->year->name;
			

			$sqlstt = "insert into fb_edu VALUES ($si,'$sn','$st',$syi,$syn)";
			mysql_query($sqlstt);
			$sql = "UPDATE  `vegam`.`fb_edu` SET  `uid` =  $uid WHERE  `fb_edu`.`schoolid` =$si";
			mysql_query($sql);
			//echo $si;echo $sn;echo $st;echo $swi;echo $swn;echo $syi;echo $syn;
		}
		
	break;
	case "inspirational_people":
		//echo sizeof($val);echo "</br>";
		$uid = $_SESSION['i'];
		for($i = 0; $i <= sizeof($val); $i++)
		{
			$fbi = $user->inspirational_people[$i]->id;$fbn = $user->inspirational_people[$i]->name;
			$sqlstt = "insert into fb_ins VALUES ($fbi,'$fbn')";
			mysql_query($sqlstt);
			$sql = "UPDATE  `vegam`.`fb_ins` SET  `uid` =  $uid WHERE  `fb_ins`.`id` =$fbi";
			mysql_query($sql);
		}break;
	case "sports":
		//echo sizeof($val);echo "</br>";
		$i = $_SESSION['i'];
		for($i = 0; $i <= sizeof($val); $i++)
		{
			$si = $user->sports[$i]->id;$sn = $user->sports[$i]->name;
			$sqlstt = "insert into fv_sports (id,name) VALUES ($si,'$sn')";
			mysql_query($sqlstt);
			$sqlstt1 = "UPDATE  `vegam`.`fv_sports` SET  `uid` =  $uid WHERE  `fv_sports`.`id` =$si";
			mysql_query($sqlstt1);
		}break;		
	case "favorite_teams":
		//echo sizeof($val);echo "</br>";
		$uid = $_SESSION['i'];
		for($i = 0; $i <= sizeof($val); $i++)
		{
			$ti = $user->favorite_teams[$i]->id;$tn = $user->favorite_teams[$i]->name;
			$sqlstt = "insert into fb_fav_tem (id,name) VALUES ($ti,'$tn')";
			mysql_query($sqlstt);
			$stt = "UPDATE  `vegam`.`fb_fav_tem` SET  `uid` =  $uid WHERE  `fb_fav_tem`.`id` =$ti";
			mysql_query($stt);
		}break;	
	
	}
							}

	//header("Location: http://vegam.co/fb_test/friends.php?" . $_SESSION['access_token']);
	$fuser = @json_decode(file_get_contents($f_url));//print_r($fuser);

	foreach ((array)$fuser as $key => $val){
	switch($key){
	case "data":
		$s = sizeof($val);

		for($i = 0; $i <= $s; $i++)
		{
			$j = $fuser->data[$i]->id;
			$fn = $fuser->data[$i]->first_name;
			$ln = $fuser->data[$i]->last_name;
			$un = $fuser->data[$i]->username;
			$link = $fuser->data[$i]->link;
			$web = $fuser->data[$i]->website;
			$local = $fuser->data[$i]->locale;
			$tpi = $fuser->data[$i]->third_party_id;
			$n = $fuser->data[$i]->name;
			$g = $fuser->data[$i]->gender;
			$r = $fuser->data[$i]->relationship_status;
			$b = $fuser->data[$i]->birthday;
			$in = $fuser->data[$i]->interested_in;
			$ht = $fuser->data[$i]->hometown->name;
			$loc = $fuser->data[$i]->location->name;
			$p = $fuser->data[$i]->political;
			$bio = $fuser->data[$i]->bio;
			$q = $fuser->data[$i]->quotes;
					$sqlstt7 = "INSERT INTO  `vegam`.`fb_frndlist` (`id` ,`first_name` ,`last_name` ,`username` ,`link` ,`name` ,`gender` ,`relationship_status` ,`birthday` ,`location` ,`hometown`) VALUES ('$j',  '$fn',  '$ln',  '$un',  '$link ',  '$n',  '$g',  '$r',  '$b',  '$loc',  '$ht')";
					mysql_query($sqlstt7);
					$sqlsttb = "update fb_frndlist set bio = '$bio' where id = $j";
					mysql_query($sqlsttb);
					$sqlsttq = "update fb_frndlist set quotes = '$q' where id = $j";
					mysql_query($sqlsttq);
					
						$fsql = "insert into fb_frnd (fid) VALUES ($j)";
						mysql_query($fsql);
						$uid = $_SESSION['i'];
						$ustt = "update fb_frnd set uid = '$uid' where fid = $j";
						mysql_query($ustt);
					
					


			$lang = $fuser->data[$i]->languages;
			for($lna = 0; $lna < sizeof($lang); $lna++){
				$lid = $fuser->data[$i]->languages[$lna]->id;
				$lname = $fuser->data[$i]->languages[$lna]->name;
					$sqlstt = "INSERT INTO  `vegam`.`fb_lang` VALUES ('$lid','$lname',$j) ";
					mysql_query($sqlstt);
					/*$fstt = "UPDATE  `vegam`.`fb_lang` SET  `uid` =  '$j' WHERE CONVERT(  `fb_lang`.`id` USING utf8 ) =  '$lid' AND CONVERT(  `fb_lang`.`name` USING utf8 ) =  '$lname' AND  `fb_lang`.`uid` =0 LIMIT 1";
					mysql_query($fstt);*/	}
			$e = $fuser->data[$i]->education;
			for($ed = 0; $ed < sizeof($e); $ed++){
				$est = $fuser->data[$i]->education[$ed]->type;
				$esi = $fuser->data[$i]->education[$ed]->school->id;
				$esn = $fuser->data[$i]->education[$ed]->school->name;
				$esyi = $fuser->data[$i]->education[$ed]->year->id;
				$esyn = $fuser->data[$i]->education[$ed]->year->name;
							$esqlstt = "insert into fb_edu VALUES ($esi,'$esn','$est',$esyi,$esyn,$j)";
							mysql_query($esqlstt);}
			$f = $fuser->data[$i]->family;
			for($fa = 0; $fa <= sizeof($f); $fa++){
				$fi = $fuser->data[$i]->family->data[$fa]->id;
				$n = $fuser->data[$i]->family->data[$fa]->name;
				$r = $fuser->data[$i]->family->data[$fa]->relationship;
				$famsqlstt = "insert into fb_family  VALUES ($fi,'$n','$r',$j)";
				mysql_query($famsqlstt);				
				}
			$w = $fuser->data[$i]->work;
			for($wo = 0; $wo < sizeof($w); $wo++){
				$fei = $fuser->data[$i]->work[$wo]->employer->id;
				$fen = $fuser->data[$i]->work[$wo]->employer->name;
				$fpi = $fuser->data[$i]->work[$wo]->position->id;
				$fpn = $fuser->data[$i]->work[$wo]->position->name;
				$fsd = $fuser->data[$i]->work[$wo]->start_date;
				$fed = $fuser->data[$i]->work[$wo]->end_date;
				$fproi = $fuser->data[$i]->work[$wo]->projects->id;
				$fpron = $fuser->data[$i]->work[$wo]->projects->name;
				$fprosd = $fuser->data[$i]->work[$wo]->projects->start_date;
			$fwsqlstt = "INSERT INTO  `vegam`.`fb_fwork` VALUES ('$fei',  '$fen',  '$fpi',  '$fpn',  '$fsd', '$fed', $j)";
			mysql_query($fwsqlstt);
	
				}
			$d = $fuser->data[$i]->devices;//echo "size of d..." . sizeof($d);echo " ";
			for($o = 0; $o <= sizeof($d); $o++){
				$de = $fuser->data[$i]->devices[$o]->os;//echo $de;echo " ";
				}
			$ft = $fser->data[$i]->favorite_teams;
			for($fte = 0; $fte <= sizeof($ft); $fte++){
				$fti = $fuser->data[$i]->favorite_teams[$fte]->id;
				$ftn = $fuser->data[$i]->favorite_teams[$fte]->name;
				$sqlstt = "insert into fb_fav_tem  VALUES ($fti,'$ftn',$j)";
				mysql_query($sqlstt);
				/*$stt = "UPDATE  `vegam`.`fb_fav_tem` SET  `uid` =  $j WHERE  `fb_fav_tem`.`id` =$fti";
				mysql_query($stt);	*/			}
			$fa = $fuser->data[$i]->favorite_athletes;
			for($fat = 0; $fat <= sizeof($fa); $fat++){
				$fati = $fuser->data[$i]->favorite_athletes[$fat]->id;
				$fatn = $fuser->data[$i]->favorite_athletes[$fat]->name;
				$fa_sqlstt = "insert into fb_athelete  VALUES ($fati,'$fatn',$j)";
				mysql_query($fa_sqlstt);				
				}

		

			
		}
	

	break;
		

	case "paging":
		$s = sizeof($val);$_SESSION['i'];
		for($i = 0; $i <= sizeof($val); $i++)
		{
			$pag = $fuser->paging->next;
					$psql = "insert into fb_frnd_page (paging) VALUES ($pag)";
					mysql_query($psql);
					$uid = $_SESSION['i'];
					$ustt = "update fb_frnd_page set id = '$uid' where paging = $pag";
					mysql_query($ustt);
	
		}break;
		
	}	
}	
}
?>