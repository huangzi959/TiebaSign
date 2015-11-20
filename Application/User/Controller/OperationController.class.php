<?php
namespace User\Controller;
use Think\Controller;
Class OperationController extends Controller{
  	public function index(){
    	$this->error('illegal operation');
 	}
	
 	public function login($user, $pass, $remember_me){
 		if(IS_POST)
 		{
			// 注册
			$resultArr = D('User')->Login($user, $pass);
			if($resultArr['status'])
			{
				// Set cookie value
				$user = $resultArr['username'];
				if($remember_me == 'on') cookie('token',login_en_code(D('User')->login_random($user).$user));
				cookie('username',$user);

				// Set session
				/// user_status 是用户登录的标识
				/// 0 is no Login
				/// 1 is password Login
				/// 2 is cookies Login
				session('user_status',1);
			}
			echo json_encode($resultArr['json']);
		}
	}

	public function register($username,$password,$email,$code)
	{
		if(IS_POST)
		{
			$d = time(); //待处理的日期
			$w = date("w",$d); //这天是星期几

			if($code == NULL)
			{
				echo json_encode(array('error' => '邀请码不是一个有效项' ));
				return;
			}

			$isCounterCode = false;
			if($code == 'can')
			{
				$c = new \SaeCounter();
				if(($yqmCounter = $c->get('yqm')) > 50)
				{
					echo json_encode(array('error' => '人数已满' ));
					return;
				}
				else
				{
					$isCounterCode = true;
				}
			}

			if($code != 'cccc'.($w*4) && !$isCounterCode)
			{
				echo json_encode(array('error' => '邀请码不是一个有效项' ));
				return;
			}

			$resArr = D('User')->CreateUser($username,$password,$email);
			
			// 注册后立即登录
			if($resArr['info'] == 'Success')
			{
				$c->set('yqm',$yqmCounter+1);
				cookie('token',login_en_code(D('User')->login_random($username).$username));
				cookie('username',$username);
				session('user_status',1);
			}
			echo json_encode($resArr);
		}
	}

	public function logout(){
		$user_api = new \User\Api\UserApi();
		$user_api->logout();
		echo 1;
	}

	public function ChangePassword($oldpw,$newpw)
    {
    	if(IS_POST)
    	{
    		echo json_encode(D('User')->ChangePassword($oldpw,$newpw));
    	}
    }
}