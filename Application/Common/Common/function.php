<?php

// 权限编码到权限名称
function PemissionToName($id)
{
    switch ($id) {
        case 1:
            return '创始人';
            break;
        case 2:
            return '管理员';
        default:
            return '未知';
            break;
    }
}

function login_en_code($string){
    return md5(md5($string));
}

// 测试用户是否真实
function test_user(){
    $cookie_username_token = login_en_code(M('User')->where('username="%s"',cookie('username'))->getField('random').cookie('username'));
    if(session('user_status') != 1 && cookie('token') != $cookie_username_token) return false;
    else return true;
}

function GetTbName($cookie){
    $name=url_get("http://tieba.baidu.com/f/user/json_userinfo","",$cookie);
	if($name == 'null') return false;
    else return iconv("GB2312","UTF-8",getmid($name,'"user_name_weak":"','","'));
}

function curl_get($url,$cookie){
    $f = new SaeFetchurl();
    $f -> setCookie("BDUSS",$cookie);
    $content = $f->fetch($url);
    if($f->errno() == 0)  return $content;
    else return $f->errmsg();
}
function curl_get2($url,$cookie,&$resCookies){
    $f = new SaeFetchurl();
    $f -> setCookie("BDUSS",$cookie);
    $content = $f->fetch($url);
    $resCookies = $f->responseCookies(false);
    if($f->errno() == 0)  return $content;
    else return $f->errmsg();
}

// 用于获取账户名
function url_get($url,$POSTcontent="",$cookie="")
{

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    if ($POSTcontent!=""){curl_setopt($ch, CURLOPT_POSTFIELDS,$POSTcontent);}
    if ($cookie!=""){curl_setopt($ch, CURLOPT_COOKIE,$cookie);}
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function getmid($txt,$left,$right)
{
   preg_match_all("{".$left."(.*?)".$right."}",$txt,$data,PREG_SET_ORDER);
   return $data[0][1];
}

function sign($cookie,$tiebaname,$fid,$urlname){
    $f = new SaeFetchurl();
    $f->setMethod("post");
    $f->setCookie("BDUSS",$cookie);
    $tbs = tbs($cookie);
        curl_get2("http://tieba.baidu.com/f/user/json_userinfo",$cookie,$rescookie);
        $cookieT = "TIEBA_USERTYPE=".$rescookie['TIEBA_USERTYPE'].";TIEBAUID=".$rescookie['TIEBAUID'].";BAIDUID=".$rescookie['BAIDUID']."=1;BDUSS=".$cookie;
    $poststr = $cookieT."fid=".$fid."from=tiebakw=".$tiebaname."net_type=1tbs=".$tbs;
    $sign = md5($poststr."tiebaclient!!!");
    $poststr = $cookieT."&fid=".$fid."&from=tieba&kw=".$urlname."&net_type=1&tbs=".$tbs."&sign=".$sign;
    $f->setPostData($poststr);
    $text = $f->fetch("http://c.tieba.baidu.com/c/c/forum/sign");
    if($f->errno() == 0) return $text;
    else return false;
}

function tbs($cookie=""){
    $f = new SaeFetchurl();
    $f->setCookie("BDUSS",$cookie);
    $content = $f->fetch("http://tieba.baidu.com/dc/common/tbs");
    $tbs = explode('"',$content);
    return $tbs[3];
}

function send_mail($to, $subject = 'Your register infomation', $body) {
    $loc_host = "SAE";         
    $smtp_acc = "cyunqiandao@sina.com";
    $smtp_pass="sxcuic";       
    $smtp_host="smtp.sina.com";   
    $from="cyunqiandao@sina.com";     
    $headers = "Content-Type: text/plain; charset=\"utf-8\"\r\nContent-Transfer-Encoding: base64";
    $lb="\r\n";             //linebreak
        
    $hdr = explode($lb,$headers);   
   if($body) {$bdy = preg_replace("/^\./","..",explode($lb,$body));}//??????Body

    $smtp = array(
          array("EHLO ".$loc_host.$lb,"220,250","HELO error: "),
          array("AUTH LOGIN".$lb,"334","AUTH error:"),
          array(base64_encode($smtp_acc).$lb,"334","AUTHENTIFICATION error : "),
          array(base64_encode($smtp_pass).$lb,"235","AUTHENTIFICATION error : "));
    $smtp[] = array("MAIL FROM: <".$from.">".$lb,"250","MAIL FROM error: ");
    $smtp[] = array("RCPT TO: <".$to.">".$lb,"250","RCPT TO error: ");
    $smtp[] = array("DATA".$lb,"354","DATA error: ");
    $smtp[] = array("From: ".$from.$lb,"","");
    $smtp[] = array("To: ".$to.$lb,"","");
    $smtp[] = array("Subject: ".$subject.$lb,"","");
    foreach($hdr as $h) {$smtp[] = array($h.$lb,"","");}
    $smtp[] = array($lb,"","");
    if($bdy) {foreach($bdy as $b) {$smtp[] = array(base64_encode($b.$lb).$lb,"","");}}
    $smtp[] = array(".".$lb,"250","DATA(end)error: ");
    $smtp[] = array("QUIT".$lb,"221","QUIT error: ");
    $fp = @fsockopen($smtp_host, 25);
    if (!$fp) echo "Error: Cannot conect to ".$smtp_host."
";
    while($result = @fgets($fp, 1024)){if(substr($result,3,1) == " ") { break; }}
    
    $result_str="";
    foreach($smtp as $req){
          @fputs($fp, $req[0]);
          if($req[1]){
                while($result = @fgets($fp, 1024)){
                    if(substr($result,3,1) == " ") { break; }
                };
                if (!strstr($req[1],substr($result,0,3))){
                    $result_str.=$req[2].$result."
";
                }
          }
    }
    @fclose($fp);
    return $result_str;
}
