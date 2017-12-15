<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * ModelName
 */
class CategoryModel extends BaseModel{
    // 自动验证
    protected $_validate=array(
        array('canme','require','分类名称不能为空',0,'',3), // 验证字段必填
    );
    public function getList(){
    	return $this->field("id,cname,type")->select();
    }
}
