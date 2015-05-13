<?php
/*
Plugin Name: OS日報プラグイン
Plugin URI: http://lp.olivesystem.jp/plugin-nippo
Description: WordPressで日報を作成できるプラグインです。
Version: 1.0.0
Author: OLIVESYSTEM（オリーブシステム）
Author URI: http://lp.olivesystem.jp/
*/
if(!isset($wpdb)){
	global $wpdb;
}
// 現在のプラグインバージョン
define('OSNP_PLUGIN_VERSION','1.0.0');
// 設定を保存する項目名
define('OSNP_PLUGIN_OPTION_NAME', 'osnp_option');
// サイトURL
define('OSNP_SURL', site_url());
// サイト名
define('OSNP_STITLE', get_bloginfo('name'));
// テーブル名
define('OSNP_PREFIX', $wpdb->prefix); // プレフィックス
define('OSNP_THEME_TABLE', OSNP_PREFIX.'osnp_theme_data');
define('OSNP_THEME_FORM_TABLE', OSNP_PREFIX.'osnp_theme_form_data');
define('OSNP_THEME_INPUT_TABLE', OSNP_PREFIX.'osnp_theme_input_data');
// metaキーのプレフィックス
define('OSNP_META_PRE', 'osnpkey');
// このファイル
define('OSNP_PLUGIN_FILE', __FILE__);
// プラグインのディレクトリ
define('OSNP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('OSNP_PLUGIN_VIEW_DIR', OSNP_PLUGIN_DIR.'view');
define('OSNP_PLUGIN_CLASS_DIR', OSNP_PLUGIN_DIR.'class');
define('OSNP_PLUGIN_FUNCTION_DIR', OSNP_PLUGIN_DIR.'function');
// グローバル変数
$osnp_user_data = '';
$osnp_sqlfile_check = '';
$osnp_option_data = '';
// 関数
include_once(OSNP_PLUGIN_DIR.'functionCall.php');
// class読み込み
include_once(OSNP_PLUGIN_DIR.'classCall.php');
?>