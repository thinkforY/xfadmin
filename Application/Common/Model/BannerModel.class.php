<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * ModelName
 */
class BannerModel extends BaseModel{
    public function _before_delete($option){
        $id=$option['where']['id'];
        //删除文章图片
        $this->field("adpic")->find($id);
        @unlink('.'.$this->adpic);
    }
}
