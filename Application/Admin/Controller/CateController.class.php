<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
/**
 * 后台首页控制器
 */
class CateController extends AdminBaseController{
	/**
	 * 首页
	 */
	public function index(){
		$data=D('Cate')->getTreeData('tree','sort DESC,id');
		$assign=array(
			'data'=>$data
			);
		$this->assign($assign);
		$this->display();
	}
	/**
	 * 添加分类
	 */
	public function add(){
		$rec = D("Cate")->getCateRecposs();
		$this->assign("recpos",$rec);
		$this->display();
	}
	/**
	 * 添加子分类
	 */
	public function addcld(){
		$data=I('post.');
		unset($data['id']);
		$result=D('Cate')->addData($data);
		if ($result) {
			$this->success('添加成功',U('Admin/Cate/index'));
		}else{
			$this->error('添加失败');
		}
	}
	/**
	 * 修改分类
	 */
	public function edit(){
		$cate = D("Cate");
		$id = I('id');
		$recres = $cate->getRecValue();
		$rec = $cate->getCateRecposs();
		foreach ($rec as $k => $v) {
			foreach ($recres as $k1 => $v1) {
				if ($v1['rec_id'] == $v['id']) {
					$rec[$k]['check'] = "checked";
				}else{
					$rec[$k]['check'] = "";
				}
			}
		}
		$data = $cate->findData($id,"id,catename,catepic");
		$this->assign(array(
			'data'=>$data,
			"recpos"=>$rec
		));
		$this->display();
	}
	/**
	 * 修改子分类
	 */
	public function editcld(){
		$data=I('post.');
		$map=array(
			'id'=>$data['id']
			);
		$result=D('Cate')->editData($map,$data);
		if ($result) {
			$this->success('修改成功',U('Admin/Cate/index'));
		}else{
			$this->error('修改失败');
		}
	}
	public function save(){
		$cate = D("Cate");
		$recv = D("recvalue");
		$post=I('post.');
		$catepic = post_upload("/Upload/Cate/");
		if ($catepic) {
			$cateres = $cate->findData($post['id'],"catepic");
			@unlink('.'.$cateres['catepic']);
			$data['catepic'] = $catepic['name'];
		}
		$data['catename'] = $post['catename'];
		$data['pid'] = 0;
		if ($post['id']) {
			$recres = $cate->getRecValue();
			if ($recres) {
				$recv->where(array('value_id'=>$post['id']))->delete();
			}
			$map['id'] = $post['id'];
			$result = $cate->editData($map,$data);
			if ($result) {
				$reca = $post['rec_id'];
				foreach ($reca as $k => $v) {
					$recs['rec_id'] = $v;
					$recs['value_id'] = $post['id'];
					$recs['rec_type'] = 1;
					$recv->add($recs);
				}
				$this->success("修改分类成功",U('Admin/Cate/index'));
			}else{
				$this->error("修改分类失败");
			}
		}else{
			$result = $cate->addData($data);
			if ($result) {
				$recArr = $post['rec_id'];
				foreach ($recArr as $k => $v) {
					$recs['rec_id'] = $v;
					$recs['value_id'] = $result;
					$recs['rec_type'] = 1;
					$recv->add($recs);
				}
				$this->success("添加分类成功",U('Admin/Cate/index'));
			}else{
				$this->error("添加分类失败");
			}
		}
	}
	/**
	 * 删除分类
	 */
	public function delete(){
		$id=I('get.id');
		$map=array(
			'id'=>$id
			);
		$result=D('Cate')->deleteData($map);
		if($result){
			$this->success('删除成功',U('Admin/Cate/index'));
		}else{
			$this->error('请先删除子分类');
		}
	}

	/**
	 * 分类排序
	 */
	public function order_cate(){
		$data=I('post.');
		$result=D('Cate')->orderData($data);
		if ($result) {
			$this->success('排序成功',U('Admin/Cate/index'));
		}else{
			$this->error('排序失败');
		}
	}
}
