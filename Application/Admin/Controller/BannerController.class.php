<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
/**
 * 轮播图管理
 */
class BannerController extends AdminBaseController{
	/**
	 * 轮播图列表
	 */
	public function index(){
		$suppliers = D('Suppliers')->getSuppliersList();
		$data=D('AdminNav')->getTreeData('tree','order_number DESC,id');
		$assign=array(
			'data'=>$data,
			'suppliers'=>$suppliers,
			);
		$this->assign($assign);
		$this->display();
	}

	/**
	 * 添加轮播图
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
	 * 修改轮播图
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
	 * 删除轮播图
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
			$this->error('请先删除子轮播图');
		}
	}

	/**
	 * 轮播图排序
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
