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
		$banner = D('Banner');
		$field = "xf_banner.id,xf_banner.adname,xf_banner.adpic,xf_banner.adlink,xf_suppliers.suppliers_name";
		$join = "LEFT JOIN xf_suppliers ON xf_banner.sid=xf_suppliers.id";
		$data=$banner->getPage($banner,"",'id',10,$field,$join);
		$assign=array(
			'data'=>$data['data'],
			'page'=>$data['page'],
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
		$pic = post_upload("/Upload/Ad/");
		if ($pic['name']) {
			$cateres = D('Banner')->findData($data['id'],"adpic");
			@unlink('.'.$cateres['adpic']);
			$data['adpic'] = $pic['name'];
		}
		$result=D('Banner')->addData($data);
		if ($result) {
			$this->success('添加成功',U('Admin/Banner/index'));
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
		$pic = post_upload("/Upload/Ad/");
		if ($pic['name']) {
			$cateres = D('Banner')->findData($data['id'],"adpic");
			@unlink('.'.$cateres['adpic']);
			$data['adpic'] = $pic['name'];
		}
		$result=D('Banner')->editData($map,$data);
		if ($result) {
			$this->success('修改成功',U('Admin/Banner/index'));
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
		$result=D('Banner')->deleteData($map);
		if($result){
			$this->success('删除成功',U('Admin/Banner/index'));
		}else{
			$this->error('请先删除子轮播图');
		}
	}

	/**
	 * 轮播图排序
	 */
	public function order(){
		$data=I('post.');
		$result=D('Banner')->orderData($data);
		if ($result) {
			$this->success('排序成功',U('Admin/Banner/index'));
		}else{
			$this->error('排序失败');
		}
	}


}
