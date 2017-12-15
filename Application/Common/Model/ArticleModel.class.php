<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * ModelName
 */
class ArticleModel extends BaseModel{
    // 自动验证
    protected $_validate=array(
        array('canme','require','分类名称不能为空',0,'',3), // 验证字段必填
    );

    // 自动完成
    protected $_auto=array(
        array('create_time','time',1,'function'), // 对date字段在新增的时候写入当前时间戳
    );
    public function _before_delete($option){
        $id=$option['where']['id'];
        //删除文章图片
        $this->field("original,thumb")->find($id);
        @unlink('.'.$this->original);
        @unlink('.'.$this->thumb);
    }
}
