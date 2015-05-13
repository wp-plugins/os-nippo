<?php
// SQLを操作するclass
class osNippoPluginInstallClass {

	public function __construct(){

		// プラグインを有効化したとき
		if(function_exists('register_activation_hook')){
			register_activation_hook(OSNP_PLUGIN_FILE, array('osNippoPluginInstallClass', 'my_register_activation_func'));
		}
		// プラグインを無効化したとき
		if(function_exists('register_deactivation_hook')){
			register_deactivation_hook(OSNP_PLUGIN_FILE, array('osNippoPluginInstallClass', 'my_deactivation_function_name'));
		}

	}
	/*
	*  プラグイン有効時の処理
	*/
	public function my_register_activation_func(){

		self::addTable();

	}
	/*
	*  プラグイン無効時の処理
	*/
	public function my_deactivation_function_name(){


	}
	/*
	*  SQL
	*/
	// テーブルの存在チェック
	public function show_table($tbl){

		global $wpdb;
		return $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $tbl));

	}
	// sqlを操作するファイルを読み込み、sqlを実行
	public function sql_performs($sql=''){

		global $osmp_sqlfile_check;
		// 既に読み込まれていないければファイル読み込み
		if($osmp_sqlfile_check!='1'){
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			$GLOBALS['osnp_sqlfile_check'] = 1; // 読み込みチェック
		}

		return dbDelta($sql);

	}
	/*
	*  テーブル処理
	*/
	// プラグイン用のテーブルを作成
	public function addTable(){

		// テーブルを作成
		$charset = self::charset();
		// テーマテーブル
		$show_table = self::show_table(OSNP_THEME_TABLE);
		if(empty($show_table)){// なければ作成
			self::addThemeTable($charset);
		}
		// テーマ用Formテーブル
		$show_table = self::show_table(OSNP_THEME_FORM_TABLE);
		if(empty($show_table)){// なければ作成
			self::addThemeFormTable($charset);
		}
		// テーマ用inputテーブル
		$show_table = self::show_table(OSNP_THEME_INPUT_TABLE);
		if(empty($show_table)){// なければ作成
			self::addThemeInputTable($charset);
		}
		// デフォルトテーマデータを作成
		self::nippoDefaultTheme();

	}
	// プラグイン用のテーブルを削除
	public function deleteTable(){

		global $wpdb;
		$wpdb->query("DELETE FROM ".OSNP_THEME_TABLE.";");

	}
	// 文字コード
	public function charset($charset=''){

		if(empty($charset)){
			$charset = defined("DB_CHARSET") ? DB_CHARSET : "utf8";
		}

		return $charset;

	}
	/*
	*  OSNP_THEME_TABLE = 日報テーマテーブル
	*  theme_id テーマデータid || add_uid テーマ作成者のユーザid
	*  theme_title テーマ名 || テーマの説明文 theme_desc_text
	*  permit_userlevel このテーマを使用できるユーザレベル 99=すべてのユーザに非表示
	*  default_flag デフォルトテーマフラグ
	*  delete_flag 削除フラグ || create_time 作成日時 || update_time 更新日時
	*/
	public function addThemeTable($charset=''){

		if(empty($charset)){
			$charset = self::charset($charset);
		}
		//
		$sql = "CREATE TABLE " .OSNP_THEME_TABLE. " (\n".
				"`theme_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,\n".
				"`add_uid` bigint(20) NOT NULL DEFAULT '0',\n".
				"`theme_title` text NOT NULL,\n".
				"`theme_desc_text` text NOT NULL,\n".
				"`permit_userlevel` int(2) NOT NULL DEFAULT '0',\n".
				"`default_flag` int(1) NOT NULL DEFAULT '0',\n".
				"`delete_flag` int(1) NOT NULL DEFAULT '0',\n".
				"`create_time` datetime NOT NULL,\n".
				"`update_time` timestamp NOT NULL,\n".
				"PRIMARY KEY (`theme_id`)\n".
			") ENGINE = MyISAM DEFAULT CHARSET=".$charset." AUTO_INCREMENT=1 \n";
		self::sql_performs($sql);

	}
	/*
	*  OSNP_THEME_FORM_TABLE = 日報テーマ用フォームテーブル
	*  form_id テーマ用フォームデータid
	*  theme_id テーマデータid
	*  form_title フォーム名
	*  form_label フォームラベル
	*  form_desc_text フォームの説明文
	*  form_class class名
	*  order 昇順
	*  delete_flag 削除フラグ || create_time 作成日時 || update_time 更新日時
	*/
	public function addThemeFormTable($charset=''){

		if(empty($charset)){
			$charset = self::charset($charset);
		}
		//
		$sql = "CREATE TABLE " .OSNP_THEME_FORM_TABLE. " (\n".
				"`form_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,\n".
				"`theme_id` bigint(20) NOT NULL DEFAULT '0',\n".
				"`form_title` text NOT NULL,\n".
				"`form_label` varchar(255) NOT NULL,\n".
				"`form_desc_text` text NOT NULL,\n".
				"`form_class` varchar(255) NOT NULL,\n".
				"`order` int(3) NOT NULL DEFAULT '0',\n".
				"`delete_flag` int(1) NOT NULL DEFAULT '0',\n".
				"`create_time` datetime NOT NULL,\n".
				"`update_time` timestamp NOT NULL,\n".
				"PRIMARY KEY (`form_id`)\n".
			") ENGINE = MyISAM DEFAULT CHARSET=".$charset." AUTO_INCREMENT=1 \n";
		self::sql_performs($sql);

	}
	/*
	*  OSNP_THEME_INPUT_TABLE = 日報テーマ用入力テーブル
	*  input_id 入力データid
	*  form_id テーマ用フォームデータid
	*  input_title 入力タイトル
	*  input_label 入力ラベル
	*  input_name name="input_name"
	*  input_time_num 1以上はinput_type～select_optionsを無視。
	*     0=何もしない、1=年select、2=月select、3=日select、4=時select、5=分select
	*     123=年月日、23=月日、34=日時
	*  input_type 入力タイプ  0=text、1=textarea、2=checkbox、3=radio、4=select、5=password
	*  input_value デフォルトのvalue値
	*  checkbox_options 入力タイプがcheckboxのときの選択肢。行ごとlabel,value,name,class
	*  radio_options 入力タイプがradioのときの選択肢。行ごとlabel,value,name,class
	*  select_options 入力タイプがselectのときの選択肢。行ごとtext,value,class
	*  input_inline 0=block、1=inline
	*  input_class class名
	*  input_rule 0=任意、1=必須
	*  input_order 昇順
	*  delete_flag 削除フラグ || create_time 作成日時 || update_time 更新日時
	*/
	public function addThemeInputTable($charset=''){

		if(empty($charset)){
			$charset = self::charset($charset);
		}
		//
		$sql = "CREATE TABLE " .OSNP_THEME_INPUT_TABLE. " (\n".
				"`input_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,\n".
				"`form_id` bigint(20) NOT NULL DEFAULT '0',\n".
				"`input_title` text NOT NULL,\n".
				"`input_label` varchar(255) NOT NULL,\n".
				"`input_name` varchar(255) NOT NULL,\n".
				"`input_time_num` int(5) NOT NULL DEFAULT '0',\n".
				"`input_type` int(1) NOT NULL DEFAULT '0',\n".
				"`input_value` text NOT NULL,\n".
				"`checkbox_options` text NOT NULL,\n".
				"`radio_options` text NOT NULL,\n".
				"`select_options` text NOT NULL,\n".
				"`input_class` varchar(255) NOT NULL,\n".
				"`input_rule` int(1) NOT NULL DEFAULT '0',\n".
				"`input_order` int(3) NOT NULL DEFAULT '0',\n".
				"`delete_flag` int(1) NOT NULL DEFAULT '0',\n".
				"`create_time` datetime NOT NULL,\n".
				"`update_time` timestamp NOT NULL,\n".
				"PRIMARY KEY (`input_id`)\n".
			") ENGINE = MyISAM DEFAULT CHARSET=".$charset." AUTO_INCREMENT=1 \n";
		self::sql_performs($sql);

	}
	// インストール時に、デフォルトテーマ作成
	public function nippoDefaultTheme(){

		global $wpdb;
		$sql = "SELECT * FROM `".OSNP_THEME_TABLE."` as `theme`, `".OSNP_THEME_FORM_TABLE."` as `form`, `".OSNP_THEME_INPUT_TABLE."` as `input` WHERE `theme`.`delete_flag`=%d AND `theme`.`default_flag`=%d AND `theme`.`theme_id`=`form`.`theme_id` AND `form`.`form_id`=`input`.`form_id`";
		$params = array(0, 1);
		$data = $wpdb->get_results( $wpdb->prepare($sql, $params) );
		// なければ新規作成
		if(empty($data)){
			$now = date("Y-m-d H:i:s", time());
			$wpdb->insert(OSNP_THEME_TABLE, array('add_uid'=>1, 'theme_title'=>'日報', 'theme_desc_text'=>'デフォルトテーマ', 'default_flag'=>1, 'create_time'=>$now), array('%d', '%s', '%s', '%d', '%s'));
			// 作成できたら
			if($theme_id = $wpdb->insert_id){
				$wpdb->insert(OSNP_THEME_FORM_TABLE, array('theme_id'=>$theme_id, 'form_title'=>'報告日時', 'form_label'=>'報告日時', 'create_time'=>$now), array('%d', '%s', '%s', '%s'));
				// できたら
				if($form_id = $wpdb->insert_id){
					$wpdb->insert(OSNP_THEME_INPUT_TABLE, array('form_id'=>$form_id, 'input_title'=>'報告日', 'input_label'=>'報告日', 'input_name'=>'ymd', 'input_time_num'=>123, 'input_class'=>'block', 'create_time'=>$now), array('%d', '%s', '%s', '%s', '%d', '%s', '%s'));
					$wpdb->insert(OSNP_THEME_INPUT_TABLE, array('form_id'=>$form_id, 'input_title'=>'始業時間', 'input_label'=>'始業時間', 'input_name'=>'start_hi', 'input_time_num'=>45, 'input_class'=>'inline', 'input_value'=>'08:30', 'create_time'=>$now), array('%d', '%s', '%s', '%s', '%d', '%s', '%s', '%s'));
					$wpdb->insert(OSNP_THEME_INPUT_TABLE, array('form_id'=>$form_id, 'input_title'=>'終業時間', 'input_label'=>'終業時間', 'input_name'=>'end_hi', 'input_time_num'=>45, 'input_class'=>'inline', 'input_value'=>'17:30', 'create_time'=>$now), array('%d', '%s', '%s', '%s', '%d', '%s', '%s', '%s'));
				}
				unset($form_id);
				//
				$wpdb->insert(OSNP_THEME_FORM_TABLE, array('theme_id'=>$theme_id, 'form_title'=>'業務内容', 'form_label'=>'業務内容', 'create_time'=>$now), array('%d', '%s', '%s', '%s'));
				// できたら
				if($form_id = $wpdb->insert_id){
					for($i=1; $i<11; $i++){
						$before_val_hour = 7 + $i;
						$before_hour = sprintf("%02d", $before_val_hour);
						$before_input_value = $before_hour.':30';
						$wpdb->insert(OSNP_THEME_INPUT_TABLE, array('form_id'=>$form_id, 'input_title'=>'開始', 'input_label'=>'開始', 'input_name'=>'gm_start_hi'.$i, 'input_time_num'=>45, 'input_class'=>'inline', 'input_value'=>$before_input_value, 'create_time'=>$now), array('%d', '%s', '%s', '%s', '%d', '%s', '%s'));
						$after_val_hour = 8 + $i;
						$after_hour = sprintf("%02d", $after_val_hour);
						$after_input_value = $after_hour.':30';
						$wpdb->insert(OSNP_THEME_INPUT_TABLE, array('form_id'=>$form_id, 'input_title'=>'終了', 'input_label'=>'終了', 'input_name'=>'gm_end_hi'.$i, 'input_time_num'=>45, 'input_class'=>'inline', 'input_value'=>$after_input_value, 'create_time'=>$now), array('%d', '%s', '%s', '%s', '%d', '%s', '%s'));
						$wpdb->insert(OSNP_THEME_INPUT_TABLE, array('form_id'=>$form_id, 'input_title'=>'内容', 'input_label'=>'内容', 'input_name'=>'text'.$i, 'input_type'=>1, 'input_class'=>'block size-max', 'create_time'=>$now), array('%d', '%s', '%s', '%s', '%d', '%s'));
					}
				}
			}
		}

	}

}
$osNippoPluginInstallClass = new osNippoPluginInstallClass();
?>