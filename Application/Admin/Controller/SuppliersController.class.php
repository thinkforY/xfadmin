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
        $suppliers = D('Suppliers');
        $data=$suppliers->getPage($suppliers,"",'id',10,'id,suppliers_name,suppliers_logo,suppliers_phone,suppliers_mail,suppliers_title');
        $assign=array(
            'data'=>$data['data'],
            'page'=>$data['page'],
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
        $id = I('id');
        $data = D('Suppliers')->findData($id,"id,suppliers_name,suppliers_logo,suppliers_phone,suppliers_mail,suppliers_title");
        $this->assign("data",$data);
        $this->display();
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
                $this->success("修改供应商成功",U('Admin/Suppliers/index'));
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
        $id = I('id');
        $type = I('type');
        $data = D("Suppliers")->findData($id,"id,suppliers_profile,suppliers_qualification,suppliers_strength");
        $data['type'] = $type;
        if ($type == 1) {
            $data['desc'] = $data['suppliers_profile'];
        }elseif($type == 2){
            $data['desc'] = $data['suppliers_qualification'];
        }else{
            $data['desc'] = $data['suppliers_strength'];
        }
        $this->assign('data',$data);
        $this->display();
    }
    public function desc_save(){
        $post = I('post.');
        $map['id'] = $post['id'];
        if ($post['type'] == 1) {
            $data['suppliers_profile'] = $post['desc'];
        }elseif ($post['type'] == 2) {
            $data['suppliers_qualification'] = $post['desc'];
        }else{
            $data['suppliers_strength'] = $post['desc'];
        }
        $result = D("Suppliers")->editData($map,$data);
        if ($result) {
            $this->success("修改成功",U("Admin/Suppliers/index"));
        }else{
            $this->error("修改失败");
        }
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
