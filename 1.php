<?php
header("Content-type: text/html; charset=utf-8");
$content="你是个sb";
$cookies = "BDUSS=Vk5UDh2a0dVMkppaU9iWWFLdTdqNXQ0VjZHVkJGMk14dWRSMS0yY0JPY3dvYnhWQVFBQUFBJCQAAAAAAAAAAAEAAADUWMIONb~p08PSu7j21MIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAUlVUwFJVVL";
$rs = url_get('https://sp0.baidu.com/yLsHczq6KgQFm2e88IuM_a/s?sample_name=bear_brain&request_query='.$content.'&bear_type=2',"",$cookies);
echo $rs;

//preg_match('/answer\\":\\"([\S\s]+)",\\"question/',$rs,$re)
//echo $re; 


function url_get($url,$POSTcontent="",$cookie="")
  {
   
      $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    if ($POSTcontent!=""){curl_setopt($ch, CURLOPT_POSTFIELDS,$POSTcontent);}
      if ($cookie!=""){curl_setopt($ch, CURLOPT_COOKIE,$cookie);}
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
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
