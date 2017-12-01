<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * 菜单操作model
 */
class CateModel extends BaseModel{
	public function getTreeData($type='tree',$order=''){
		// 判断是否需要排序
		if(empty($order)){
			$data=$this->select();
		}else{
			$data=$this->order('sort is null,'.$order)->select();
		}
		// 获取树形或者结构数据
		if($type=='tree'){
			$data=\Org\Nx\Data::tree($data,'catename','id','pid');
		}elseif($type="level"){
			$data=\Org\Nx\Data::channelLevel($data,0,'&nbsp;','id');
		}
		// p($data);die;
		return $data;
	}

	/**
	 * 删除数据
	 * @param	array	$map	where语句数组形式
	 * @return	boolean			操作是否成功
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

	//获取分类推荐位
	public function getCateRecposs(){
		$recpos = D("Recpos");
		return $recpos->field('id,rec_name')->where(array('rec_type'=>1))->select();
	}
	//获取推荐位的值
	public function getRecValue(){
		$recvalue = D("Recvalue");
		return $recvalue->field('rec_id,value_id')->where(array("rec_type"=>1))->select();
	}
}
