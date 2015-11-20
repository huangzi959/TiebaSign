<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index($cookieid=0){

        if($cookieid==0)
        {
    	   $arr = M('SignList')->where('username="%s"',cookie('username'))->select();
        }
        else if($cookieid==-1)
        {
            $arr = M('SignList')->where('username="%s" AND issign!=1',cookie('username'))->select();
        }
        else
        {
            $arr = M('SignList')->where('username="%s" AND cookieid=%d',cookie('username'),$cookieid)->select();
        }

    	$cookieList = M('Cookie')->where('username="%s"',cookie('username'))->select();
        $overdueCount = M('Cookie')->where('username="%s" AND overdue=1',cookie('username'))->count();

    	$cookieIndex = array();

    	foreach ($cookieList as $value) {
    		$cookieIndex[$value['id']] = $value['name'];
    	}

    	foreach ($arr as &$value) {
    		$value['cookiename'] = $cookieIndex[$value['cookieid']];
    	}

        $this->assign('overdueCount',$overdueCount);
        $this->assign('cookieList',$cookieList);
    	$this->assign('SignList',$arr);
        $this->display();
    }
}