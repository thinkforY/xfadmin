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
		$suppliers = D('Suppliers')->getSuppliersList();
		$data=D('Navbar')->getTreeData('tree','sort DESC,id',"title","id","pid");
		foreach ($data as $k => $v) {
			if ($v['sid'] == 0) {
				$data[$k]['suppliers_name'] = "中工电仪";
			}else{
				$supp = D("Suppliers")->field('suppliers_name')->find();
				$data[$k]['suppliers_name'] = $supp['suppliers_name'];
			}
		}
		$assign=array(
			'data'=>$data,
			"suppliers"=>$suppliers,
			);
		$this->assign($assign);
		$this->display();
	}

	/**
	 * 添加导航
	 */
	public function add(){
		$data=I('post.');
		$data['create_time'] = date("Y-m-d",time());
		unset($data['id']);
		$result=D('Navbar')->addData($data);
		if ($result) {
			$this->success('添加成功',U('Admin/Navbar/index'));
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
		$result=D('Navbar')->editData($map,$data);
		if ($result) {
			$this->success('修改成功',U('Admin/Navbar/index'));
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
		$result=D('Navbar')->deleteData($map);
		if($result){
			$this->success('删除成功',U('Admin/Navbar/index'));
		}else{
			$this->error('请先删除子导航');
		}
	}

	/**
	 * 导航排序
	 */
	// public function order(){
	// 	$data=I('post.');
	// 	$result=D('Navbar')->orderData($data,"id","sort");
	// 	if ($result) {
	// 		$this->success('排序成功',U('Admin/Navbar/index'));
	// 	}else{
	// 		$this->error('排序失败');
	// 	}
	// }


}
