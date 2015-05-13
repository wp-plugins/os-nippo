<?php
// 管理画面class
class osNippoAdminClass extends osNippoPluginCommonClass {

	public function __construct(){

		parent::__construct();
		// まず実行
		add_action('admin_init', array('osNippoAdminClass', 'actionAdminInit'));
		// 管理画面メニュー
		add_action('admin_menu', array('osNippoAdminClass', 'menuViews'));

	}
	/*
	*  プラグインメニュー
	*/
	// メニュー表示
	public function menuViews(){

		global $osnp_option_data;
		global $current_user;
		get_currentuserinfo();
		// 権限のデータがあれば
		if(isset($current_user->roles) && isset($current_user->roles[0])){
			$user_level = $current_user->roles[0];
		}
		// 処理
		switch($user_level){
			case 'administrator':
				self::_menuViews($user_level);
				break;
			case 'author': case 'editor':
				if(isset($osnp_option_data['theme_authority']) && $osnp_option_data['theme_authority']==1){
					self::_menuViews($user_level);
				}
				break;
		}


	}
	public function _menuViews($user_level='administrator'){

		// メニュー表示
		add_menu_page('OS日報プラグイン', 'OS日報プラグイン', $user_level, 'osnp-admin.php', array('osNippoAdminClass', 'adminPage'));
		add_submenu_page('osnp-admin.php', '日報テーマ作成・編集', '日報テーマ作成・編集', $user_level, 'osnp-theme.php', array('osNippoThemeClass', 'adminPage'));
		add_submenu_page('osnp-admin.php', '日報の投稿一覧', '日報の投稿一覧', 'administrator', 'osnp-postlist.php', array('osNippoListClass', 'adminPage'));
		add_submenu_page('osnp-admin.php', '設定', '設定', 'administrator', 'osnp-options.php', array('osNippoAdminClass', 'adminOptionsPage'));
		// メニューに非表示するページ
		add_submenu_page('osnp-admin.php', '日報の投稿詳細', null, 'administrator', 'osnp-postsingle.php', array('osNippoListClass', 'adminSinglePage'));
		add_submenu_page('osnp-admin.php', '利用規約', null, $user_level, 'osnp-agreement.php', array('osNippoAdminClass', 'agreementPage'));

	}
	//
	public function actionAdminInit(){

		// POST処理
		if(isset($_GET) && isset($_GET['page']) && stristr($_GET['page'], "osnp-")){
			if(isset($_POST) && isset($_POST['submit']) && isset($_POST['osnp_formname'])){
				$formname = $_POST['osnp_formname'];
				//
				switch($formname){
					// 設定
					case 'option':
						self::post_option();
						break;
				}
			}
		}

	}
	/*
	*  ページビュー
	*/
	// Page はじめに
	public function adminPage(){

		include_once(OSNP_PLUGIN_VIEW_DIR."/admin-adminPage.php");

	}
	// Page 設定
	public function adminOptionsPage(){

		global $osnp_option_data;
		$options = $osnp_option_data;
		$message = self::message();
		include_once(OSNP_PLUGIN_CLASS_DIR."/timezoneList.php");
		include_once(OSNP_PLUGIN_VIEW_DIR."/admin-optionPage.php");

	}
	// Page 利用規約
	public function agreementPage(){

		include_once(OSNP_PLUGIN_VIEW_DIR."/admin-agreementPage.php");

	}
	// 設定処理
	public function post_option(){

		$option_data = get_option(OSNP_PLUGIN_OPTION_NAME);
		//
		foreach($_POST as $key => $p){
			if($key!='submit' && $key!='osnp_formname'){
				$option_data[$key] = $p;
			}
		}
		//
		update_option(OSNP_PLUGIN_OPTION_NAME, $option_data);
		wp_safe_redirect('admin.php?page=osnp-options.php&msg=upd-ok');

	}

}
$osNippoAdminClass = new osNippoAdminClass();
?>