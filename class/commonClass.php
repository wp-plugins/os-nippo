<?php
// 共通class
class osNippoPluginCommonClass {

	public function __construct(){

		add_action('plugins_loaded', array('osNippoPluginCommonClass', 'plugin_get_option'));
		// ヘッダー
		add_action('wp_head', array('osNippoPluginCommonClass', 'plugin_header'));
		// JS、CSS読み込み
		add_action('wp_print_scripts', array('osNippoPluginCommonClass', 'os_wp_enqueue'));

	}
	/*
	*  ヘッダーの処理
	*/
	public function plugin_header(){

		print '<meta name="generator" content="os-nippo" />'."\n";

	}
	// JS、CSS
	public function os_wp_enqueue(){

		// jQuery
		wp_enqueue_script('jquery');
		$dir_ex = explode("/", rtrim(OSNP_PLUGIN_DIR, "/")); // 現在のプラグインのパス
		$now_plugin = end($dir_ex); // 現在のプラグインのディレクトリ名
		wp_enqueue_script('j', plugins_url($now_plugin).'/js/j.js', array(), '1.0');
		// 管理画面なら
		if(is_admin()){
			// 現ページ取得
			$now_page = (isset($_GET['page'])) ? $_GET['page'] : '';
			//
			if(stristr($now_page, 'osnp-')){
				wp_enqueue_style('style', plugins_url($now_plugin).'/style-admin.css', array(), '1.0');
			}
			//
			wp_enqueue_style('post-style', plugins_url($now_plugin).'/style-post.css', array(), '1.0');
		}else{
			wp_enqueue_style('style', plugins_url($now_plugin).'/style.css', array(), '1.0');
		}

	}
	/*
	*  オプション取得
	*/
	public function plugin_get_option(){

		$GLOBALS['osnp_option_data'] = get_option(OSNP_PLUGIN_OPTION_NAME);

	}
	/*
	*  独自リダイレクト（先にヘッダが送信されているとリダイレクトできないため）
	*/
	public function os_redirect($url=''){

		if(self::header_check()==TRUE){
			print '<meta http-equiv="refresh" content="0;URL='.$url.'" />';
		}else{
			wp_safe_redirect($url);
		}

	}
	// ヘッダーが送信されているかチェック
	public function header_check(){

		if(headers_sent($filename, $linenum)){
			//print_r(headers_list());
			//echo "$filename の $linenum 行目でヘッダがすでに送信されています。\n";
			return TRUE;
		}else{
			return FALSE;
		}

	}
	/*
	*  メッセージ
	*/
	public function message(){

		$msg = array();

		if(isset($_GET) && isset($_GET['msg'])){
			switch($_GET['msg']){
				case 'upd-ok':
					$msg[] = '更新しました！';
					break;
				case 'upd-error':
					$msg[] = '更新に失敗しました';
					break;
				case 'new-ok':
					$msg[] = '作成しました！';
					break;
				case 'new-error':
					$msg[] = '新規作成に失敗しました';
					break;
				case 'post':
					$msg[] = '投稿の処理中です…';
					break;
				case 'theme-copy-ok':
					$msg[] = 'テーマをコピーしました！';
					break;
				case 'theme-delete-ok':
					$msg[] = 'テーマを削除しました！';
					break;
			}
		}

		return $msg;

	}
	//
	public function msg_output($msg_array=''){

		if(isset($msg_array) && is_array($msg_array)){
			foreach($msg_array as $msg){
				echo '<p class="msg-output">'.esc_html($msg).'</p>';
			}
		}

	}
	// 文字コード判定
	public function d_enc($str=''){

		if(is_array($str)){
			foreach($str as $s){
				$en = self::d_enc($s);
				break;
			}
		}else{
			$en = mb_detect_encoding($str, mb_detect_order());
		}
		//
		if(!empty($en)){
			return $en;
		}else{ // 失敗なら内部文字エンコーディングを取得
			return mb_internal_encoding();
		}

	}

}
?>