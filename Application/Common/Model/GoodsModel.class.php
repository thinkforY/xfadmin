<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * 菜单操作model
 */
class GoodsModel extends BaseModel{
	protected $_validate = array(
      array('goods_name','require','商品名称不得为空！',1), 
      array('cate_id','require','商品分类不得为空！',1),
      array('market_price','require','市场价格不得为空！',1), 
      array('shop_price','require','本店价格不得为空！',1), 
      array('goods_name','','商品名称不得重复！',1,unique,3), 
      
    );
	//获取推荐位
	public function getRecposs(){
		$recpos = D("Recpos");
		return $recpos->field('id,rec_name')->where(array('rec_type'=>0))->select();
	}
	//获取推荐位的值
	public function getRecValue($id){
		$recvalue = D("Recvalue");
		return $recvalue->field('rec_id,value_id')->where(array("rec_type"=>0,"value_id"=>$id))->select();
	}
	//获取供应商
	public function getSuppliersList(){
		return D("Suppliers")->field("id,suppliers_name")->select();
	}
	public function _after_insert($data,$option){
		//商品型号添加
		$model_name = I('post.model_name');
		$model_price = I('post.model_price');
		$model_desc = I('post.model_desc');
		$model_date = I('post.model_date');
		if ($model_name) {
			foreach ($model_name as $k => $v) {
				D("Models")->add(array(
					'model_name'=>$v,
					'model_desc'=>$model_desc[$k],
					'model_date'=>$model_date[$k],
					'model_price'=>$model_price[$k],
					'goods_id'=>$data['id'],
				));
			}
		}
		//处理商品多图片上传
		$picArr = I('post.image');
		if ($picArr) {
			foreach ($picArr as $k => $v) {
				D("Goods_pic")->add(array(
					'goods_id'=>$data['id'],
					'goods_pic'=>$v,
				));
			}
		}
        //处理商品推荐位
        $recid = I('post.rec_id');
        if ($recid) {
            foreach ($recid as $k => $v) {
                D('Recvalue')->add(array(
                    'value_id'=>$data['id'],
                    'rec_id'=>$v,
                    'rec_type'=>0,
                    ));
            }
        }
    }
    public function _before_update(&$data,$option){
    	//商品型号添加
    	$models = D('Models')->where(array('goods_id'=>$option['where']['id']))->delete();
		$model_name = I('post.model_name');
		$model_price = I('post.model_price');
		$model_desc = I('post.model_desc');
		$model_date = I('post.model_date');
		if ($model_name) {
			foreach ($model_name as $k => $v) {
				D("Models")->add(array(
					'model_name'=>$v,
					'model_desc'=>$model_desc[$k],
					'model_date'=>$model_date[$k],
					'model_price'=>$model_price[$k],
					'goods_id'=>$data['id'],
				));
			}
		}
    	//处理商品多图片上传
    	$goodsPic = D('Goods_pic')->where(array('goods_id'=>$option['where']['id']))->select();
    	foreach ($goodsPic as $k => $v) {
    		@unlink('.'.$v['goods_pic']);
    	}
    	D('Goods_pic')->where(array('goods_id'=>$option['where']['id']))->delete();
		$picArr = I('post.image');
		if ($picArr) {
			foreach ($picArr as $k => $v) {
				D("Goods_pic")->add(array(
					'goods_id'=>$data['id'],
					'goods_pic'=>$v,
				));
			}
		}
    	//处理商品推荐位
    	D("Recvalue")->where(array('value_id'=>$option['where']['id']))->delete();
        $recid = I('post.rec_id');
        if ($recid) {
            foreach ($recid as $k => $v) {
                D('Recvalue')->add(array(
                    'value_id'=>$data['id'],
                    'rec_id'=>$v,
                    'rec_type'=>0,
                    ));
            }
        }
    }
}
