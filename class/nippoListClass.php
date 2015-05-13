<?php
// 日報投稿リストclass
class osNippoListClass extends osNippoPluginCommonClass {

	public function __construct(){

		parent::__construct();

	}
	/*
	*  ページビュー
	*/
	// Page 投稿一覧
	public function adminPage(){

		$total = 0;
		$data = osNippoThemeClass::getThemeList();
		global $post;
		$paged = (isset($_GET['p'])) ? $_GET['p']: 1;
		$arr = array('numberposts'=>20, 'paged'=>$paged);
		// テーマデータがあれば
		if(isset($data) && isset($data[0])){
			$post_type = array();
			//
			foreach($data as $d){
				$ptype = 'nippo-post'.$d['theme_id'];
				$post_type[] = $ptype;
				$count_posts = wp_count_posts($ptype, 'publish');
				$count = (isset($count_posts->publish)) ? $count_posts->publish: 0;
				$total = $total + $count;
			}
			$arr['post_type'] = $post_type;
			$list = get_posts($arr);
		}else{ // テーマ
			$list = '';
		}

		include_once(OSNP_PLUGIN_VIEW_DIR."/admin-nippoListPage.php");

	}
	// Page 投稿詳細
	public function adminSinglePage(){

		$get_id = (isset($_GET) && isset($_GET['id'])) ? $_GET['id']: 0;
		$detail = get_post($get_id);
		$meta = get_post_meta($get_id);
		// テーマデータ取得
		if(!empty($detail) && isset($detail->post_type)){
			$theme_id = str_replace('nippo-post', '', $detail->post_type);
			$theme_data = osNippoThemeClass::getThemeList('', $theme_id);
		}else{
			$theme_data = '';
		}

		include_once(OSNP_PLUGIN_VIEW_DIR."/admin-nippoSinglePage.php");

	}
	//
	public function view_backnext($paged='1', $total, $ct='20'){

		if(1<$paged){
			$back = $paged - 1;
			$back_query = add_query_arg('p', $back);
		}else{
			$back_query = '';
		}
		//
		$now = $paged * $ct;
		//
		if($now<$total){
			$next = $paged + 1;
			$next_query = add_query_arg('p', $next);
		}else{
			$next_query = '';
		}
		//
		if(!empty($back_query) || !empty($next_query)){
			echo '<div class="back_next">';
			if(!empty($back_query)){
				echo '<a href="'.$back_query.'">&lt;&lt; 前へ</a>　';
			}
			if(!empty($next_query)){
				echo '<a href="'.$next_query.'">次へ &gt;&gt;</a>';
			}
			echo '</div>';
		}

	}

}
$osNippoThemeClass = new osNippoThemeClass();
?>