<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * ModelName
 */
class NavbarModel extends BaseModel{
    // 自动验证
    protected $_validate=array(
        array('title','require','分类名称不能为空',0,'',3), // 验证字段必填
    );
    /**
     * 删除数据
     * @param   array   $map    where语句数组形式
     * @return  boolean         操作是否成功
     */
    public function deleteData($map){
        $count=$this
            ->where(array('pid'=>$map['id']))
            ->count();
        if($count!=0){
            return false;
        }
        $this->where(array($map))->delete();
        return true;
    }
}
