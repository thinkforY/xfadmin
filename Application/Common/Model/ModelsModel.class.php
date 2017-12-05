<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * 菜单操作model
 */
class ModelsModel extends BaseModel{
	protected $_validate = array(
      array('model_name','require','型号名称不得为空！',1), 
      array('model_name','','型号名称不得重复！',1,unique,3), 
    );
    public function getModelsList($goods_id){
    	$list = $this->field("id,model_name,model_price,model_date,model_desc")->where(array('goods_id'=>$goods_id))->order("id ASC")->select();
    	return $list;
    }
}
