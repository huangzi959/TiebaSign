<?php
namespace Home\Controller;
use Think\Controller;
class SettingController extends Controller {
    public function index(){
        $cookieList = M('Cookie')->where('username="%s"',cookie('username'))->select();
        $this->assign('cookieList',$cookieList);
        $this->assign('cookieCount',count($cookieList));
        $this->display();
    }

    public function AddCookie($cookie)
    {
        if(!test_user()) 
        {
            echo json_encode(array('error' => '添加失败','status' => false ));
            return;
        }

        $data = array(
            'username' => cookie('username'),
            'cookies'  => $cookie
             );
        if($cookieid = M('Cookie')->add($data))
        {
            $queue = new \SaeTaskQueue('NewCookie');
            $queue->addTask("/index.php/Home/Queue/LoadTb", "cookieid=".$cookieid);
            $queue->push();
            
            $kv = new \SaeKV();
            $kv->init();
            $kv->set('Cookie'.$cookieid,$cookie);
            echo json_encode(array('info' => '添加成功，队列加载中','status' => true ));
        }
        else
            echo json_encode(array('error' => '添加失败','status' => false ));
    }

    public function DelCookie($id)
    {
        if(!test_user()) 
        {
            echo json_encode(array('error' => '删除失败','status' => false ));
            return;
        }

        if(M('Cookie')->where('id=%d',$id)->delete())
        {
            M('SignList')->where('cookieid=%d',$id)->delete();
            $kv = new \SaeKV();
            $kv->init();
            $kv->delete('Cookie'.$id);
            
            echo json_encode(array('info' => '删除成功','status' => true ));
        }
        else
            echo json_encode(array('error' => '删除失败','status' => false ));
    }

    public function CookieReload($cookieid)
    {
        $queue = new \SaeTaskQueue('NewSign');
        $queue->addTask("/index.php/Home/Queue/LoadTb", "cookieid=".$cookieid);
        $queue->push();
        echo json_encode(array('info' => '操作完毕，队列加载中','status' => true ));
    }
}