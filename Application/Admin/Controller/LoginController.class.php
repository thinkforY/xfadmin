<?php
namespace Admin\Controller;
use Common\Controller\BaseController;
/**
 * 后台首页控制器
 */
class LoginController extends BaseController{
	public function index(){
		if(IS_POST){
            // 做一个简单的登录 组合where数组条件
            $map=I('post.');
            $map['password']=md5($map['password']);
            $data=M('Users')->where($map)->find();
            if (empty($data)) {
                $this->error('账号或密码错误');
            }else{
                $_SESSION['user']=array(
                    'id'=>$data['id'],
                    'username'=>$data['username'],
                    'avatar'=>$data['avatar']
                    );
                $this->success('登录成功、前往管理后台',U('Admin/Index/index'));
            }
        }else{
            $this->display();
        }
	}
	public function logout(){
		session('user',null);
        $this->success('退出成功、前往登录页面',U('Admin/Login/index'));
	}
}