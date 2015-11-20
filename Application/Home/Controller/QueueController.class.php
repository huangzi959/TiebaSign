<?php
namespace Home\Controller;
use Think\Controller;

header('Content-Type:text/html;charset=utf-8');
class QueueController extends Controller {
    public function index(){

    }

    public function LoadTb($cookieid,$page=1){
        $db = M('SignList');
        // 清除当前数据
        $db->where('cookieid=%d',$cookieid)->delete();

        // 获取Cookie数据
        $cookieRes = M('Cookie')->where('id=%d',$cookieid)->find();
        $cookie = 'BDUSS='.$cookieRes['cookies'].';';
        $username = $cookieRes['username'];

        $raw_name = GetTbName($cookie);
		
        echo $raw_name;
        if($raw_name)
        {
            $data = array(
                'id' => $cookieid,
                'name' => $raw_name.'(正在加载)'
                 );
       		M('Cookie')->save($data);
        }
        else
        {
            $data = array(
                'id' => $cookieid,
                'name' => 'Cookie无效',
                'overdue' => 1
                 );
        	M('Cookie')->save($data);
            return;
        }


        // 加载贴吧数据
        $count = 0;
        for($i=1;;$i=$i+1){
            $content = curl_get("http://tieba.baidu.com/f/like/mylike?&pn=".$i,$cookie);
            $content = mb_convert_encoding($content,'utf-8','gbk');
            $reslike = array();
            preg_match_all('/title="([\S]*)".*balvid="([\d]*)".*balvname="([\S]*)"/U',$content,$reslike);
            
            for($j=0;$j<count($reslike[1]);++$j)
            {
                if($reslike[2][$j] == null) continue;
                $data = array(
                    'username'  =>  $username,
                    'cookieid'  =>  $cookieid,
                    'fid'       =>  $reslike[2][$j],
                    'tiebaname' =>  $reslike[1][$j],
                    'urlname'   =>  $reslike[3][$j],
                    'issign'    =>  2
                    );
                $db->add($data);
            }
            
            $count+=count($reslike[1]);
            
            if(count($reslike[1])==0) {
                break;
            }
            
            if($count>2000) break;
        }

        $data = array(
            'id' => $cookieid,
            'name' => $raw_name
             );
        M('Cookie')->save($data);
        echo $raw_name.' 贴吧加载完成，共'.$count.'个贴吧';
    }

    public function CronInterface(){
        $db = M('SignList');
        $queue = new \SaeTaskQueue('NewSign');
        // 统计剩余未签到
        $leftCount = $db->where('issign!=1')->count();
        $queueLeftLength = $queue->leftLength();
        $workArr = array();

        if($leftCount == 0)
        {
            echo 'Left UnSign Tieba is empty';
            return;
        }

        // 剩余未签到是否大于队列长度
        if($leftCount > $queueLeftLength)
        {
            $workArr = $db->where('issign!=1')->limit($queueLeftLength)->select();
        }
        else
        {
            $workArr = $db->where('issign!=1')->select();
        }

        // 分发至队列
        foreach ($workArr as $value) {
            $queue->addTask(
                "/index.php/Home/Queue/TbSign", 
                "cookieid=".$value['cookieid'].'&tiebaname='.$value['tiebaname'].'&fid='.$value['fid'].'&urlname='.$value['urlname'].'&signlistid='.$value['id']
                );
        }
        
        $queue->push();
    }

    public function TbSign($cookieid,$tiebaname,$fid,$urlname,$signlistid){
        $kv = new \SaeKV();
        $kv->init();
        $cookies = $kv->get('Cookie'.$cookieid);
        echo $cookies;
        // 记录数据
        if($va = sign($cookies,$tiebaname,$fid,urlencode($tiebaname)))
        {
            
            echo $va;
            $data = array(
                'id' => $signlistid, 
                'issign' => 1
                );
            M('SignList')->save($data);
        }
    }

    public function ClearSignStatus()
    {
        $cookieArr = M('Cookie')->where('overdue=0')->select();

        // 查询是否过期
        foreach ($cookieArr as $value) {
            // 双重查询确认
            if(GetTbName('BDUSS='.$value['cookies'].';') == false && GetTbName('BDUSS='.$value['cookies'].';') == false)
            {
                // 标记过期
                M('Cookie')->where('id=%d',$value['id'])->setField('overdue',1);

                // 删除Cookie缓存
                $kv = new \SaeKV();
                $kv->init();
                $cookies = $kv->delete('Cookie'.$value['id']);

                // 删除该Cookie的贴吧
                M('SignList')->where('cookieid=%d',$value['id'])->delete();
				
                $email = M('User')->where('username="%s"',$value['username'])->getField('email');
                // 通知用户
                send_mail($email,'【C云签】您的百度账户Cookie已失效','您的百度账户【'.$value['name'].'】Cookie已失效，请到 http://signtb.sinaapp.com 查看与重置');
            }
        }

        M('SignList')->where('id>0')->setField('issign',0);
    }
}
