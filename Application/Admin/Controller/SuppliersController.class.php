<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
/**
 * 后台供应商管理
 */
class SuppliersController extends AdminBaseController{

//******************供应商***********************
    /**
     * 供应商列表
     */
    public function index(){
        $data=D('Suppliers')->getTreeData('tree','id','suppliers_name');
        $assign=array(
            'data'=>$data
            );
        $this->assign($assign);
        $this->display();
    }

    /**
     * 添加供应商
     */
    public function add(){
        
        $this->display();
    }

    /**
     * 修改供应商
     */
    public function edit(){
        $this->display();
        $data=I('post.');
        $map=array(
            'id'=>$data['id']
            );
        $result=D('Suppliers')->editData($map,$data);
        if ($result) {
            $this->success('修改成功',U('Admin/Suppliers/index'));
        }else{
            $this->error('修改失败');
        }
    }
    public function save(){
        $data = I('post.');
        $suppliers = D("Suppliers");
        $filepath = post_upload("/Upload/Suppliers/");
        if ($filepath['name']) {
            // $thumb = crop_image($filepath['name'],200,66);
            $suppliersres = $suppliers->findData($data['id'],"suppliers_logo");
            @unlink('.'.$suppliersres['catepic']);
            $data['suppliers_logo'] = $filepath['name'];
        }
        if ($data['id']) {
            $map['id'] = $data['id'];
            $result = $suppliers->editData($map,$data);
            if ($result) {
                $this->success("修改供应商成功",U('Admin/Cate/index'));
            }else{
                $this->error("修改供应商失败");
            }
        }else{
            unset($data['id']);
            $result=$suppliers->addData($data);
            if ($result) {
                $this->success('添加成功',U('Admin/Suppliers/index'));
            }else{
                $this->error('添加失败');
            }
        }
    }
    //企业简介、企业资质、企业实力
    public function description(){
        $this->display();
    }
    /**
     * 删除供应商
     */
    public function delete(){
        $id=I('get.id');
        $map=array(
            'id'=>$id
            );
        $result=D('Suppliers')->deleteData($map);
        if($result){
            $this->success('删除成功',U('Admin/Suppliers/index'));
        }else{
            $this->error('请先删除子供应商');
        }

    }
}
