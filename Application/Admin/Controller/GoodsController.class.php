<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
/**
 * 后台首页控制器
 */
class GoodsController extends AdminBaseController{
	/**
	 * 
	 */
	public function index(){
		// 商品数据
		$goods = D('Goods');
		$map['is_on_sale'] = 1;
		$field = "xf_goods.id,xf_goods.goods_name,xf_goods.market_price,xf_goods.shop_price,xf_goods.is_on_sale,xf_goods.sort,xf_cate.catename,xf_suppliers.suppliers_name";
		$join = "LEFT JOIN xf_cate ON xf_goods.cate_id=xf_cate.id LEFT JOIN xf_suppliers ON xf_goods.suppliers_id=xf_suppliers.id";
		$goodsres=D('Goods')->getPage($goods,$map,'sort DESC,id',10,$field,$join);
		$assign=array(
			'data'=>$goodsres['data'],
			'page'=>$goodsres['page'],
			);
		$this->assign($assign);
		$this->display();
	}
	/**
	 * 添加商品
	 */
	public function add(){
		$cate = D("Cate")->getTreeData('tree','sort DESC,id');
		$suppliers = D('Goods')->getSuppliersList();
		$recpos = D('Goods')->getRecposs();
		$assign = array(
			'recpos'=>$recpos,
			'cate'=>$cate,
			'suppliers'=>$suppliers,
		);
		$this->assign($assign);
		$this->display();
	}
	public function edit(){
		$goods = D('Goods');
		$id = I('id');
		$cate = D("Cate")->getTreeData('tree','sort DESC,id');
		$suppliers = $goods->getSuppliersList();
		$recres = $goods->getRecValue($id);
		$rec = $goods->getRecposs();
		foreach ($rec as $k => $v) {
			foreach ($recres as $k1 => $v1) {
				if ($v1['rec_id'] == $v['id']) {
					$rec[$k]['check'] = 1;
				}
			}
		}
		$data = $goods->findData($id,"id,goods_name,original_img,market_price,shop_price,sales_sum,simple_desc,cate_id,suppliers_id,goods_content,is_on_sale");
		$models = D('Models')->getModelsList($id);
		$assign = array(
			'recpos'=>$rec,
			'cate'=>$cate,
			'suppliers'=>$suppliers,
			'data'=>$data,
			'models'=>$models,
		);
		$this->assign($assign);
		$this->display();
	}
	public function save(){
		$goods = D("Goods");
		$post = I('post.');
		$pic = post_upload("/Upload/Goods/");
		if ($pic['name']) {
			$min_thumb = crop_image($pic['name'],144,144);
			$mid_thumb = crop_image($pic['name'],200,200);
			$max_thumb = crop_image($pic['name'],300,300);
			$cateres = $goods->findData($post['id'],"original_img,min_thumb,mid_thumb,max_thumb");
			@unlink('.'.$cateres['original_img']);
			@unlink('.'.$cateres['min_thumb']);
			@unlink('.'.$cateres['mid_thumb']);
			@unlink('.'.$cateres['max_thumb']);
			$post['original_img'] = $pic['name'];
			$post['min_thumb'] = $min_thumb;
			$post['mid_thumb'] = $mid_thumb;
			$post['max_thumb'] = $max_thumb;
		}
		$post['onscle'] = date("Y-m-d",time());
		if ($post['id']) {
			$map['id'] = $post['id'];
			$result = $goods->editData($map,$post);
			if ($result) {
				$this->success("修改商品成功",U('Admin/Goods/index'));
			}else{
				$this->error("修改商品失败");
			}
		}else{
			$result = $goods->addData($post);
			if ($result) {
				$this->success("添加商品成功",U('Admin/Goods/index'));
			}else{
				$this->error('添加商品失败');
			}
		}
	}
	public function delete(){
		$id=I('get.id');
		$map=array(
			'id'=>$id
			);
		$result=D('Goods')->deleteData($map);
		if($result){
			$this->success('删除成功',U('Admin/Goods/index'));
		}else{
			$this->error('删除失败');
		}
	}
	public function goods_order(){
		$data=I('post.');
		$result=D('Goods')->orderData($data,"id","sort");
		if ($result) {
			$this->success('排序成功',U('Admin/Goods/index'));
		}else{
			$this->error('排序失败');
		}
	}
	public function desc(){
		$this->display();
	}
	public function desc_save(){

	}
	//异步预览上传
	public function webuploader(){
		// 如果是post提交则显示上传的文件 否则显示上传页面
	    if(IS_POST){
	        p($_POST);die;
	    }
	}
	public function ajax_upload(){
		// 根据自己的业务调整上传路径、允许的格式、文件大小
    	ajax_upload('/Upload/image/');
	}
}
