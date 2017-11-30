<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
/**
 * 后台推荐位管理
 */
class RecposController extends AdminBaseController{

//******************推荐位***********************
    /**
     * 推荐位列表
     */
    public function index(){
        $recpos = D('Recpos');
        $data=$recpos->getPage($recpos,"",'id',10,"id,rec_name,rec_type");
        $assign=array(
            'data'=>$data['data'],
            'page'=>$data['page'],
            );
        $this->assign($assign);
        $this->display();
    }

    /**
     * 添加推荐位
     */
    public function add(){
        $data=I('post.');
        unset($data['id']);
        $result=D('Recpos')->addData($data);
        if ($result) {
            $this->success('添加成功',U('Admin/Recpos/index'));
        }else{
            $this->error('添加失败');
        }
    }

    /**
     * 修改推荐位
     */
    public function edit(){
        $data=I('post.');
        $map=array(
            'id'=>$data['id']
            );
        $result=D('Recpos')->editData($map,$data);
        if ($result) {
            $this->success('修改成功',U('Admin/Recpos/index'));
        }else{
            $this->error('修改失败');
        }
    }

    /**
     * 删除推荐位
     */
    public function delete(){
        $id=I('get.id');
        $map=array(
            'id'=>$id
            );
        $result=D('Recpos')->deleteData($map);
        if($result){
            $this->success('删除成功',U('Admin/Recpos/index'));
        }else{
            $this->error('请先删除子推荐位');
        }

    }
}
