<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
/**
 * 后台配置管理
 */
class ConfController extends AdminBaseController{
	/**
	 * 配置列表
	 */
	public function index(){
		$conf = D('Conf');
		$data=$conf->getPage($conf,"","sort DESC,id ASC",10,"id,cname,ename,value,values,d_type,sort");
		$assign=array(
			'data'=>$data['data'],
			'page'=>$data['page'],
			);
		$this->assign($assign);
		$this->display();
	}

	/**
	 * 添加配置
	 */
	public function add(){
		$this->display();
	}
	public function save(){
		$data=I('post.');
		if ($data['id']) {
			$map=array(
				'id'=>$data['id']
				);
			$result=D('Conf')->editData($map,$data);
			if ($result) {
				$this->success('修改成功',U('Admin/Conf/index'));
			}else{
				$this->error('修改失败');
			}
		}else{
			$result=D('Conf')->addData($data);
			if ($result) {
				$this->success('添加成功',U('Admin/Conf/index'));
			}else{
				$this->error('添加失败');
			}
		}
	}
	/**
	 * 修改配置
	 */
	public function edit(){
		$id = I('get.id');
		$data = D('Conf')->findData($id,"id,cname,ename,value,values,d_type,sort");
		$assign = array(
			'data'=>$data,
		);
		$this->assign($assign);
		$this->display();
	}

	/**
	 * 删除配置
	 */
	public function delete(){
		$id=I('get.id');
		$map=array(
			'id'=>$id
			);
		$result=D('Conf')->deleteData($map);
		if($result){
			$this->success('删除成功',U('Admin/Conf/index'));
		}else{
			$this->error('删除失败');
		}
	}

	/**
	 * 配置排序
	 */
	public function order(){
		$data=I('post.');
		$result=D('Conf')->orderData($data);
		if ($result) {
			$this->success('排序成功',U('Admin/Conf/index'));
		}else{
			$this->error('排序失败');
		}
	}

	/**
	 * 配置项
	 */
	public function conf(){
		$conf = D('Conf');
		if (IS_POST) {
			if ($conf->editSave()) {
				$this->success('修改配置项成功',U('Admin/Conf/conf'));
			}else{
				$this->error('修改配置项失败');
			}
			return;
		}
		$list = $conf->getPage($conf,"","sort DESC",'',"id,cname,ename,d_type,c_type,value,values,sort");
		$this->assign('configres',$list['data']);
		$this->display();
	}
}
