<?php
namespace Common\Controller;
use Common\Controller\BaseController;
/**
 * admin 基类控制器
 */
class AdminBaseController extends BaseController{
	/**
	 * 初始化方法
	 */
	public function _initialize(){
		parent::_initialize();
		$auth=new \Think\Auth();
		$rule_name=MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
		$result=$auth->check($rule_name,$_SESSION['user']['id']);
		if(!$result){
			if (!check_login()) {
				if ($rule_name != "Admin/Index/index") {
					$this->error("登录超时，请重新登陆");
				}else{
					$this->error("请先登录",U("Admin/Login/index"));
				}
			}else{
				$this->error('您没有权限访问');
			}
		}
	}




}

