<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/admin/lib/lib.php";
$type= $_POST['mem_email'];
$searchword = $_GET['searchword'];
$PG_table = $V_DB["member"];
$mod = $_GET['mod'];
// MODE에 따른 출력
if($searchword && $mod=='mem_email')
{
	$sql = " select count(*) as cnt from v_member where $mod = '$searchword' ";
	$check = sql_fetch($sql);
	if(!$check[cnt]) {
		echo "1";
	}
	else
	{
		echo "2";
	}
}
else if($searchword && $mod=='mem_id')
{


		$sql = " select count(*) as cnt from v_member where $mod = '$searchword' ";
		$check = sql_fetch($sql);

	if(!$check[cnt]) {
		echo "1";
	}
	else
	{
		echo "2";
	}
}


else if($searchword && $mod=='mem_pass')
{


		// 변수를 정리합니다.
			$mem_name = $_GET[mem_name];
			$mem_email = $_GET[mem_email];

			//$mb_sch = sql_password($_POST[ssn1].$_POST[ssn2]);



			$sql = " select * from $PG_table where mem_name = '".$mem_name."' and mem_email = '".$mem_email."'";
			$member = sql_fetch($sql);


		if($member==TRUE) {

			$newPass = substr(md5(rand(0,9)),0,8);

			$PassUP = sql_password($newPass);



			// 새로운 비밀번호로 변경합니다.

			$sql = " update $PG_table set mem_pass = '$PassUP' where mem_id = '{$member[mem_id]}' ";

			sql_query($sql);



			$to = $member["mem_name"];

			$Receiver = $member["mem_email"];

			$fname = $default["site_name"];

			$fmail = $default["admin_email"];



			$subject = "요청하신 아이디와 임시 비밀번호 입니다.";



			ob_start();

			include $_SERVER["DOCUMENT_ROOT"]."{$G_member[skin_url]}/search_idpw.skin.php";

			$content = ob_get_contents();

			ob_end_clean();

			mailer($fname, $fmail, $Receiver, $subject, $content, 1);


			echo "등록하신 메일(".$member[mem_email].")로 보내드렸습니다.\n분실하지 않도록 유의하여 주시기 바랍니다.";
		}else{
			echo "검색하신 정보와 일치하는 내용의 회원이 없습니다.\n다시 한번확인하여 주시기 바랍니다.";
		}

}



else if($searchword && $mod=='mem_zip')
{
                     if($add_type == 2){
						$mrs = '<select name="address" id="address">';
                            $zipfile = array();
                            $fp = fopen("../member/way_zip.db", "r");    
                            while(!feof($fp)) {
                                $zipfile[] = fgets($fp, 4096);
                            }
                            fclose($fp);
            
                            $search_count = 0;     
                            if($addr1)
                            {
                        
                                while ($zipcode = each($zipfile))
                                {
            
            
                                    if(strstr(substr($zipcode[1],9,512), $addr1))
                                    {
                                        $list[$search_count][zip1] = substr($zipcode[1],0,3);
                                        $list[$search_count][zip2] = substr($zipcode[1],4,3);
                                        $addr = explode(" ", substr($zipcode[1],8));
            
            
                                        if(strstr(substr($zipcode[1],9,512), $addr1))
                                        {
                                            $list[$search_count][zip1] = substr($zipcode[1],0,3);
                                            $list[$search_count][zip2] = substr($zipcode[1],4,3);
                                            $addr = explode(" ", substr($zipcode[1],8));
                                        
                                            if(sizeof($addr) > 5){
                                                if (trim($addr[sizeof($addr)-1]))
                                                {
                                                    $list[$search_count][addr] = str_replace($addr[sizeof($addr)-1], "", substr($zipcode[1],8));
                                                    $list[$search_count][addr_val] = str_replace($addr[sizeof($addr)-1], "", substr($zipcode[1],8));
                                                    $list[$search_count][bunji] = trim($addr[sizeof($addr)-1]);
                                                }else{
                                                    $list[$search_count][addr] = str_replace($addr[sizeof($addr)-2], "", substr($zipcode[1],8));
                                                    $list[$search_count][addr_val] = str_replace($addr[sizeof($addr)-1], "", substr($zipcode[1],8));
                                                    $list[$search_count][bunji] = trim($addr[sizeof($addr)-1]);
                                                }
            
                                            }else{
                                                    $list[$search_count][addr] = substr($zipcode[1],8);						
                                                    $list[$search_count][addr_val] = substr($zipcode[1],8);						
                                            }
            
                                        }
                
                                        $list[$search_count][encode_addr] = urlencode($list[$search_count][addr]);
                                        $search_count++;
                                    } 
                                }
                
                            }
            
                            for ($i=0; $i<count($list); $i++) {
                            $mrs .= '<option value="'.$list[$i][zip1].'-'.$list[$i][zip2].'||'.$list[$i][addr].'">';
                            $mrs .= $list[$i][addr_val]." ".$list[$i][bunji];
                            }
                          $mrs .= '</select>';
                   }else{


						$mrs = '<select name="address" id="address">';
                                 
                            $zipfile = array();
                            $fp = fopen("../member/zip.db", "r");    
                            while(!feof($fp)) {
                                $zipfile[] = fgets($fp, 4096);
                            }
                            fclose($fp);
            
                            $search_count = 0;     
                            if($addr1)
                            {
                                while ($zipcode = each($zipfile))
                                {
                                    if(strstr(substr($zipcode[1],9,512), $addr1))
                                    {
                                        $list[$search_count][zip1] = substr($zipcode[1],0,3);
                                        $list[$search_count][zip2] = substr($zipcode[1],4,3);
                                        $addr = explode(" ", substr($zipcode[1],8));
            
            
                                        if(strstr(substr($zipcode[1],9,512), $addr1))
                                        {
                                            $list[$search_count][zip1] = substr($zipcode[1],0,3);
                                            $list[$search_count][zip2] = substr($zipcode[1],4,3);
                                            $addr = explode(" ", substr($zipcode[1],8));
                                        
                                            if(sizeof($addr) > 5){
                                                if (trim($addr[sizeof($addr)-1]))
                                                {
                                                    $list[$search_count][addr] = str_replace($addr[sizeof($addr)-1], "", substr($zipcode[1],8));
                                                    $list[$search_count][addr_val] = str_replace($addr[sizeof($addr)-1], "", substr($zipcode[1],8));
                                                    $list[$search_count][bunji] = trim($addr[sizeof($addr)-1]);
                                                }else{
                                                    $list[$search_count][addr] = str_replace($addr[sizeof($addr)-2], "", substr($zipcode[1],8));
                                                    $list[$search_count][addr_val] = str_replace($addr[sizeof($addr)-1], "", substr($zipcode[1],8));
                                                    $list[$search_count][bunji] = trim($addr[sizeof($addr)-1]);
                                                }
            
                                            }else{
                                                    $list[$search_count][addr] = substr($zipcode[1],8);						
                                                    $list[$search_count][addr_val] = substr($zipcode[1],8);						
                                            }
            
                                        }
                
                                        $list[$search_count][encode_addr] = urlencode($list[$search_count][addr]);
                                        $search_count++;
                                    } 
                                }
                
                            }
            
                            for ($i=0; $i<count($list); $i++) {
                            $mrs .= '<option value="'.$list[$i][zip1].'-'.$list[$i][zip2].'||'.$list[$i][addr].'">';
                            $mrs .= $list[$i][addr_val]." ".$list[$i][bunji];
                            }
                          $mrs .= '</select>';
							}
	if (!$search_count)
	{
		echo "x";
	}
	else
	{
		echo $mrs;
	}
	exit;
}


?>