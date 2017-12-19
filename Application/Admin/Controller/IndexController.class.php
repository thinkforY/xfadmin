<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
/**
 * 后台首页控制器
 */
class IndexController extends AdminBaseController{
	/**
	 * 首页
	 */
	public function index(){
		if (!check_login()) {
			$this->error("请先登录",U("Admin/Login/index"));
		}else{
			// 分配菜单数据
			$nav_data=D('AdminNav')->getTreeData('level','order_number DESC,id');
			$assign=array(
				'data'=>$nav_data
				);
			$this->assign($assign);
			$this->display();
		}
	}
	/**
	 * elements
	 */
	public function elements(){

		$this->display();
	}
	
	/**
	 * welcome
	 */
	public function welcome(){
	    $this->display();
	}



}
