<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
/**
 * 导航管理
 */
class NavbarController extends AdminBaseController{
	/**
	 * 导航列表
	 */
	public function index(){
		$data=D('AdminNav')->getTreeData('tree','order_number DESC,id');
		$assign=array(
			'data'=>$data
			);
		$this->assign($assign);
		$this->display();
	}

	/**
	 * 添加导航
	 */
	public function add(){
		$data=I('post.');
		unset($data['id']);
		$result=D('AdminNav')->addData($data);
		if ($result) {
			$this->success('添加成功',U('Admin/Nav/index'));
		}else{
			$this->error('添加失败');
		}
	}

	/**
	 * 修改导航
	 */
	public function edit(){
		$data=I('post.');
		$map=array(
			'id'=>$data['id']
			);
		$result=D('AdminNav')->editData($map,$data);
		if ($result) {
			$this->success('修改成功',U('Admin/Nav/index'));
		}else{
			$this->error('修改失败');
		}
	}

	/**
	 * 删除导航
	 */
	public function delete(){
		$id=I('get.id');
		$map=array(
			'id'=>$id
			);
		$result=D('AdminNav')->deleteData($map);
		if($result){
			$this->success('删除成功',U('Admin/Nav/index'));
		}else{
			$this->error('请先删除子导航');
		}
	}

	/**
	 * 导航排序
	 */
	public function order(){
		$data=I('post.');
		$result=D('AdminNav')->orderData($data);
		if ($result) {
			$this->success('排序成功',U('Admin/Nav/index'));
		}else{
			$this->error('排序失败');
		}
	}


}
