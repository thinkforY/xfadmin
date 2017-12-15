<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
/**
 * 文章
 */
class PostsController extends AdminBaseController{
    /**
     * 文章列表
     */
    public function index(){
    	$article = D("Article");
    	$field = "xf_article.id,xf_article.title,xf_article.thumb,xf_article.sort,xf_article.publish_time,xf_article.status,xf_category.cname";
    	$join = "LEFT JOIN xf_category ON xf_article.cid=xf_category.id";
    	$data = $article->getPage($article,"","sort DESC",10,$field,$join);
    	$assign = array(
    		"data"=>$data['data'],
    		"page"=>$data['page'],
    	);
    	$this->assign($assign);
       	$this->display();
    }
    public function add(){
    	$category = D('Category')->getList();
    	$assign = array(
    		"category"=>$category,
    	);
    	$this->assign($assign);
    	$this->display();
    }
    public function edit(){
    	$id = I('id');
    	$category = D('Category')->getList();
    	$data = D('Article')->findData($id,"id,title,thumb,status,cid,introduction,content");
    	$assign = array(
    		"category"=>$category,
    		"data"=>$data,
    	);
    	$this->assign($assign);
    	$this->display();
    }
    public function delete_posts(){
    	$id=I('get.id');
        $map=array(
            'id'=>$id
            );
        $result=D('Article')->deleteData($map);
        if($result){
            $this->success('删除成功',U('Admin/Posts/index'));
        }else{
            $this->error('删除失败');
        }
    }
    public function save(){
    	$article = D('Article');
    	$post = I('post.');
    	$pic = post_upload("/Upload/Article/");
		if ($pic['name']) {
			$min_thumb = crop_image($pic['name'],170,115);
			$cateres = $article->findData($post['id'],"original,thumb");
			@unlink('.'.$cateres['original']);
			@unlink('.'.$cateres['thumb']);
			$post['original'] = $pic['name'];
			$post['thumb'] = $min_thumb;
		}
		if ($post['status']) {
			$post['publish_time'] = time();
		}else{
			$post['publish_time'] = "";
		}
		if ($post['id']) {
			$map['id'] = $post['id'];
			$result = $article->editData($map,$post);
			if ($result) {
				$this->success("修改文章成功",U('Admin/Posts/index'));
			}else{
				$this->error("修改文章失败");
			}
		}else{
			$result = $article->addData($post);
			if ($result) {
				$this->success("添加文章成功",U('Admin/Posts/index'));
			}else{
				$this->error('添加文章失败');
			}
		}
    }
    //文章排序
    public function order_posts(){
    	$data=I('post.');
    	p($data);die;
		$result=D('Article')->orderData($data,"id","sort");
		if ($result) {
			$this->success('排序成功',U('Admin/Posts/index'));
		}else{
			$this->error('排序失败');
		}
    }
    //栏目
    public function category_list(){
    	$category = D("Category");
    	$data = $category->getPage($category,"","",10,"id,cname,type");
    	$assign = array(
    		"data"=>$data['data'],
    		"page"=>$data['page'],
    	);
    	$this->assign($assign);
    	$this->display();
    }
    public function add_category(){
    	$data=I('post.');
        unset($data['id']);
        $result=D('Category')->addData($data);
        if ($result) {
            $this->success('添加成功',U('Admin/Posts/category_list'));
        }else{
            $this->error('添加失败');
        }
    }
    public function edit_category(){
    	$data=I('post.');
        $map=array(
            'id'=>$data['id']
            );
        $result=D('Category')->editData($map,$data);
        if ($result) {
            $this->success('修改成功',U('Admin/Posts/category_list'));
        }else{
            $this->error('修改失败');
        }
    }
    public function delete_category(){
    	$id=I('get.id');
        $map=array(
            'id'=>$id
            );
        $result=D('Category')->deleteData($map);
        if($result){
            $this->success('删除成功',U('Admin/Posts/category_list'));
        }else{
            $this->error('删除失败');
        }
    }
}