<?php
class BlogController {
	public function addBlog() {
		$res = D('cate')->getCategory();
		include "./view/blog/publish.html";
	}
	public function doAdd() {
		$title   = empty($_POST['title']) ? '' : $_POST['title'];
		$content = empty($_POST['content']) ? '' : $_POST['content'];
		$createtime = date('Y-m-d,H:i:s');
		$cateid = empty($_POST['cateid']) ? '' : $_POST['cateid'];
		$id = $_SESSION['me']['id'];
		$user = D('user')->getUserById($id);
		$userinfo = current($user);

		foreach ($userinfo as $key => $value) {
			$username = $userinfo['username'];
		}

		$res = D('cate')->getCategory();
		foreach ($res as $key => $value) {
			$catename = $res[$key]['category'];
		}
		// var_dump($catename);die();
		if (empty($title) || empty($content)) {
			echo "参数错误";
			die();
		}
		$res = D('blog')->addBlog($title,$content,$createtime,$username,$catename);
		// var_dump($res);die();
		if ($res !== false) {
			// echo "添加博客成功";
			header("location:index.php?c=blog&a=lists");
		} else {
			echo "添加博客失败";
		}
	}

	public function lists() {
		$lists = D('blog')->getList();
		$res   = D('cate')->getCategory();
		include "./view/blog/csdn.html";
	}


	public function info() {
		// echo "111";die();
		$id = $_GET['id'];
		$res = D('blog')->getInfoById($id);
		// var_dump($res);die();
		include "./view/blog/csdn_blog_default.html";
	}

	public function cate() {
		$id = $_GET['cateid'];
		$res = D('cate')->getBlogByCate($id);
		$category = $res['category'];
		// var_dump($category);die();
		$blog = D('blog')->getInfoByCatename($category);
		// var_dump($blog);die();
		$res = D('cate')->getCategory();
		include "./view/blog/csdn_blog_cate.html";
	}
	// public function 
}