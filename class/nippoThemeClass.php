<?php
// 日報テンプレート編集class
class osNippoThemeClass extends osNippoPluginCommonClass {

	public function __construct(){

		parent::__construct();

	}
	/*
	*  ページビュー
	*/
	// Page 日報テンプレート編集
	public function adminPage(){

		global $osnp_option_data;
		global $current_user;
		get_currentuserinfo();
		$user_level = 'guest';
		$user_id = 0;
		$allcaps = array();
		// 権限のデータがあれば
		if(isset($current_user->roles) && isset($current_user->roles[0])){
			$user_level = $current_user->roles[0];
			$user_id = (isset($current_user->ID)) ? $current_user->ID: 0;
			$allcaps = (isset($current_user->allcaps)) ? $current_user->allcaps: '';
		}
		$options = $osnp_option_data;
		$message = self::message();
		$mode = (isset($_REQUEST) && isset($_REQUEST['mode'])) ? $_REQUEST['mode']: 'list';
		$file_name = '';
		$form_action = '';
		$error_jscript = '';
		$post_msg = '';
		$post_permit_flag = 0;
		//
		switch($mode){
			// 作成
			case 'add':
				$form_action = 'admin.php?page=osnp-theme.php&mode=add&msg=post';
				$file_name = 'admin-nippoThemeAddPage.php';
				$get = self::add_get();
				$pagetitle = '日報テーマ作成';
				$post_msg = 'new-ok';
				$post_permit_flag = 1;
				break;
			// 編集
			case 'wr':
				$theme_id = (isset($_REQUEST) && isset($_REQUEST['id'])) ? $_REQUEST['id']: 0;
				$form_action = 'admin.php?page=osnp-theme.php&mode=wr&id='.$theme_id.'&msg=post';
				$file_name = 'admin-nippoThemeAddPage.php';
				$data = osNippoThemeClass::getThemeList('postedit_permit', $theme_id);
				$get = (isset($data[0])) ? $data[0]: '';
				// 管理者権限以外は作成ユーザじゃないと編集できない
				switch($user_level){
					case 'administrator':
						$post_permit_flag = 1;
						break;
					default:
						$add_uid = (isset($get['add_uid'])) ? $get['add_uid']: 0;
						// 一致すれば
						if($user_id==$add_uid){
							$post_permit_flag = 1;
						}else{ // 一致しなければ
							$file_name = 'admin-nippoThemeNonePage.php';
						}
				}
				$pagetitle = '日報テーマ編集 id:'.$theme_id;
				$post_msg = 'upd-ok';
				break;
			// テーマ複製
			case 'copy':
				$message = self::theme_copy();
				$message_only = 1;
				break;
			// テーマ削除
			case 'delete':
				$message = self::theme_delete();
				$message_only = 1;
				break;
			// 一覧
			case 'list':
				$file_name = 'admin-nippoThemeTopPage.php';
				$data = osNippoThemeClass::getThemeList();
				break;
		}
		// POST時
		switch($mode){
			// 作成
			case 'add': case 'wr':
				if(!empty($_POST['submit']) && self::action_formname()===true && $post_permit_flag==1){
					$validate = self::validation_post(); // バリデーション
					//
					if($result = osNippoPluginValidationClass::validates($validate)){ // チェックOK
						$return = self::nippo_insert();
						// 成功
						if(empty($return['validate'])){
							$return_id = (isset($return['id'])) ? $return['id']: 0;
							$redirect_url = 'admin.php?page=osnp-theme.php&mode=wr&id='.$return_id.'&msg='.$post_msg;
							self::os_redirect($redirect_url);
						}else{ // エラー
							$error_jscript = osNippoPluginValidationClass::js_error_css($return['validate']);
							$message = osNippoPluginValidationClass::arr_message($return['validate']);
						}
					}else{ // チェックNG
						$error_jscript = osNippoPluginValidationClass::js_error_css($validate);
						$message = osNippoPluginValidationClass::arr_message($validate);
					}
				}
				break;
		}
		//
		include_once(OSNP_PLUGIN_VIEW_DIR."/admin-nippoThemePage.php");

	}
	/*
	*  テーマ一覧取得
	*/
	public function getThemeList($type='', $theme_id=''){

		$return_data = array();
		$sql_where = '';
		$params = array();
		$params[] = 0;
		//
		switch($type){
			// 日報の投稿許可による条件検索
			case 'post_permit': case 'postedit_permit':
				$user = wp_get_current_user();
				$or_where = '';
				//
				if(isset($user->allcaps)){
					$allcaps = $user->allcaps;
					//
					for($i=0; $i<11; $i++){
						$key = 'level_'.$i;
						//
						if(isset($allcaps[$key]) && $allcaps[$key]==1){
							$or_where .= '`permit_userlevel`=%d OR ';
							$params[] = $i;
						}
					}
					//
					if(!empty($or_where)){
						$sql_where .= ' AND ('.rtrim($or_where, ' OR ').')';
					}
				}
				break;
		}
		// テーマidの指定があれば
		if(!empty($theme_id) && is_numeric($theme_id)){
			$sql_where .= ' AND `theme_id`=%d';
			$params[] = $theme_id;
		}
		//
		global $wpdb;
		$sql = "SELECT * FROM `".OSNP_THEME_TABLE."` WHERE `delete_flag`=%d".$sql_where;
		$data = $wpdb->get_results( $wpdb->prepare($sql, $params) );
		//
		if(!empty($data)){
			$theme_i = 0;
			//
			foreach($data as $d){
				//
				foreach($d as $key => $val){
					$return_data[$theme_i][$key] = $val;
				}
				//
				switch($type){
					case 'post_permit':
						break;
					default:
						//
						$form_i = 0;
						$form_sql = "SELECT * FROM `".OSNP_THEME_FORM_TABLE."` WHERE `theme_id`=%d AND `delete_flag`=%d ORDER by `order`";
						$form_params = array($d->theme_id, 0);
						$form_data = $wpdb->get_results( $wpdb->prepare($form_sql, $form_params) );
						//
						if(!empty($form_data)){
							foreach($form_data as $fd){
								//
								foreach($fd as $fd_key => $fd_val){
									$return_data[$theme_i]['form'][$form_i][$fd_key] = $fd_val;
								}
								//
								$input_i = 0;
								$input_sql = "SELECT * FROM `".OSNP_THEME_INPUT_TABLE."` WHERE `form_id`=%d AND `delete_flag`=%d ORDER by `input_order`";
								$input_params = array($fd->form_id, 0);
								$input_data = $wpdb->get_results( $wpdb->prepare($input_sql, $input_params) );
								//
								if(!empty($input_data)){
									foreach($input_data as $ind){
										//
										foreach($ind as $ind_key => $ind_val){
											$return_data[$theme_i]['form'][$form_i]['input'][$input_i][$ind_key] = $ind_val;
										}
										//
										$input_i++;
									}
								}
								//
								$form_i++;
								unset($input_sql); unset($input_params); unset($input_data);
							}
						}
						//
						unset($form_sql); unset($form_params); unset($form_data);
				}
				$theme_i++;
			}
			//
			unset($sql); unset($params); unset($data);
		}

		return $return_data;

	}
	//
	public function add_get(){

		$get = (isset($_POST)) ? $_POST: '';
		// フォーム情報が空の場合
		if(!isset($get['form'])){
			$input = array('0'=>array('input_title'=>''));
			$get['form'] = array('0'=>array('form_title'=>'', 'input'=>$input));
		}

		return $get;

	}
	/*
	*  POST処理
	*/
	// 新規作成または更新
	public function nippo_insert($post=''){

		$return = array('id'=>0, 'validate'=>array());
		$validate = '';
		$theme_data = array();
		global $wpdb;
		$wpdb->hide_errors();
		$get_id = (isset($_GET) && isset($_GET['id'])) ? $_GET['id']: '';
		//
		if(empty($post)){
			$post = (isset($_POST)) ? $_POST: '';
		}
		$now = date("Y-m-d H:i:s", time());
		// データチェック
		if(!empty($get_id)){
			$data = osNippoThemeClass::getThemeList('postedit_permit', $get_id);
			$theme_data = (isset($data[0])) ? $data[0]: '';
		}
		// テーマ作成・更新
		$theme_title = (isset($post['theme_title'])) ? $post['theme_title']: '日報 id:'.$get_id;
		$theme_desc_text = (isset($post['theme_desc_text'])) ? $post['theme_desc_text']: '';
		$permit_userlevel = (isset($post['permit_userlevel'])) ? $post['permit_userlevel']: 0;
		$column = array('theme_title'=>$theme_title, 'theme_desc_text'=>$theme_desc_text, 'permit_userlevel'=>$permit_userlevel, 'update_time'=>$now);
		// 更新
		if(!empty($get_id) && !empty($theme_data)){
			$theme_id = $get_id;
			$upd_result = $wpdb->update(OSNP_THEME_TABLE, $column, array('theme_id'=>$get_id), array('%s', '%s', '%d', '%s'), array('%d'));
			// 成功なら
			if($upd_result!==FALSE){
				$validate = self::form_insert($post, $theme_data, 'upd');
			}else{ // 失敗なら
				$return['validate'] = array(
					'theme_error'=>array('error'=>1, 'rule'=>'', 'text'=>'更新に失敗しました！'),
				);
			}
		}else{ // 新規作成
			global $current_user;
			get_currentuserinfo();
			$user_id = (isset($current_user->ID)) ? $current_user->ID: 0;
			$arr_merge = array('create_time'=>date("Y-m-d H:i:s", time()), 'add_uid'=>$user_id);
			$column = array_merge($column, $arr_merge);
			$wpdb->insert(OSNP_THEME_TABLE, $column, array('%s', '%s', '%d', '%s', '%s', '%d'));
			$theme_data = array();
			// 成功なら
			if($theme_id = $wpdb->insert_id){
				$theme_data['theme_id'] = $theme_id;
				$validate = self::form_insert($post, $theme_data, 'ins');
			}else{ // 失敗なら
				$return['validate'] = array(
					'theme_error'=>array('error'=>1, 'rule'=>'', 'text'=>'新規作成に失敗しました！'),
				);
			}
		}
		//
		$return['id'] = $theme_id;
		$return['validate'] = $validate;
		unset($column);

		return $return;

	}
	// フォーム更新
	public function form_insert($post, $theme_data, $theme_type='ins'){

		global $wpdb;
		$return = array();
		$now = date("Y-m-d H:i:s", time());

		if(is_array($post['form'])){
			foreach($post['form'] as $i => $p){
				$ins = 0;
				$theme_id = (isset($theme_data['theme_id'])) ? $theme_data['theme_id']: 0;
				$form_title = (isset($p['form_title'])) ? $p['form_title']: '';
				$form_label = (isset($p['form_label'])) ? $p['form_label']: '';
				$form_desc_text = (isset($p['form_desc_text'])) ? $p['form_desc_text']: '';
				$form_class = (isset($p['form_class'])) ? $p['form_class']: '';
				$order = (isset($p['order'])) ? $p['order']: '';
				$column = array('theme_id'=>$theme_id, 'form_title'=>$form_title, 'form_label'=>$form_label, 'form_desc_text'=>$form_desc_text, 'form_class'=>$form_class, 'order'=>$order);
				$esc = array('%d', '%s', '%s', '%s', '%s', '%d');
				//
				switch($theme_type){
					case 'upd': // 更新
						if(!empty($p['form_id'])){ // 更新
							$upd_return = $wpdb->update(OSNP_THEME_FORM_TABLE, $column, array('form_id'=>$p['form_id']), $esc, array('%d'));
						}else{ // 新規
							$ins = 1;
						}
						break;
					default: // 新規
						$ins = 1;
				}
				// 新規作成なら
				if(!empty($ins)){
					$column = array_merge($column, array('create_time'=>$now));
					$esc = array_merge($esc, array('%s'));
					$wpdb->insert(OSNP_THEME_FORM_TABLE, $column, $esc);
					// 成功ならinput処理
					if($ins_id = $wpdb->insert_id){
						$return = self::input_insert($post, $i, $ins_id);
						//
						if(!empty($return)){
							break;
						}
					}else{ // 失敗なら
						$return = self::form_wpdb_error('form_error', '新規作成に失敗しました！');
						break;
					}
				// 更新なら
				}else{
					// 成功ならinput処理
					if($upd_return!==FALSE){
						$return = self::input_insert($post, $i, $p['form_id']);
						//
						if(!empty($return)){
							break;
						}
					}else{ // 失敗
						$return = self::form_wpdb_error('form_error', '更新に失敗しました！');
						break;
					}
				}
				unset($column); unset($esc); unset($ins);
			}
		}
		// DBエラーがあれば
		if($wpdb->last_error && empty($return)){
			$return = array(
				'database_error'=>array('error'=>1, 'rule'=>'', 'text'=>'データベースエラー！'),
			);
		}

		return $return;

	}
	// input更新
	public function input_insert($post, $i, $form_id){

		global $wpdb;
		$return = array();
		$now = date("Y-m-d H:i:s", time());
		//
		if(isset($post['input']) && isset($post['input'][$i]) && is_array($post['input'][$i])){
			//
			foreach($post['input'][$i] as $ii => $p){
				$input_type = (isset($p['input_title'])) ? $p['input_title']: '';
				$input_label = (isset($p['input_label'])) ? $p['input_label']: '';
				$input_name = (isset($p['input_name'])) ? $p['input_name']: '';
				$input_name = mb_convert_kana($input_name, "a", 'UTF-8');
				$input_time_num = (isset($p['input_time_num'])) ? $p['input_time_num']: '';
				$checkbox_options = (isset($p['checkbox_options'])) ? $p['checkbox_options']: '';
				$radio_options = (isset($p['radio_options'])) ? $p['radio_options']: '';
				$select_options = (isset($p['select_options'])) ? $p['select_options']: '';
				//
				if(empty($p['time_num_flag'])){
					$input_value = (isset($p['input_value'])) ? $p['input_value']: '';
				}else{
					$input_value = (isset($p['input_time_num_default'])) ? $p['input_time_num_default']: '';
				}
				$column = array('form_id'=>$form_id, 'input_title'=>$input_type, 'input_label'=>$input_label, 'input_name'=>$input_name, 'input_time_num'=>$input_time_num, 'input_type'=>$input_type, 'checkbox_options'=>$checkbox_options, 'radio_options'=>$radio_options, 'select_options'=>$select_options, 'input_value'=>$input_value);
				$esc = array('%d', '%s', '%s', '%s', '%d', '%d', '%s', '%s', '%s', '%s');
				// 更新
				if(!empty($p['input_id'])){
					$upd_return = $wpdb->update(OSNP_THEME_INPUT_TABLE, $column, array('input_id'=>$p['input_id']), $esc, array('%d'));
					// 成功なら
					if($upd_return!==FALSE){

					}else{ // 失敗
						$return = self::form_wpdb_error('form_error', '更新に失敗しました！');
						break;
					}
				// 新規作成
				}else{
					$column = array_merge($column, array('create_time'=>$now));
					$esc = array_merge($esc, array('%s'));
					$wpdb->insert(OSNP_THEME_INPUT_TABLE, $column, $esc);
					// 成功なら
					if($ins_id = $wpdb->insert_id){

					}else{
						$return = self::form_wpdb_error('form_error', '更新に失敗しました！');
						break;
					}
				}
			}
		}

		return $return;

	}
	// フォームエラー処理
	public function form_wpdb_error($class='form_error', $text=''){

		global $wpdb;
		$return = array();
		// エラー
		if(!empty($class) && !empty($text)){
			$return[$class] = array('error'=>1, 'rule'=>'', 'text'=>$text);
			// DBエラー
			if($wpdb->last_error){
				$return['db_error'] = array('error'=>1, 'rule'=>'', 'text'=>$wpdb->last_error);
			}
		}

		return $return;

	}
	//
	public function action_formname(){

		if(isset($_POST['osnp_formname'])){
			if($_POST['osnp_formname']=='theme_add' || $_POST['osnp_formname']=='theme_wr'){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}

	}
	/*
	*  テーマ複製
	*/
	public function theme_copy(){

		$message = array();
		$get_id = (isset($_GET) && isset($_GET['copy_id'])) ? $_GET['copy_id']: '';
		// id指定していれば
		if(!empty($get_id)){
			$message[] = 'テーマを複製中…';
			$data = osNippoThemeClass::getThemeList('postedit_permit', $get_id);
			// 存在すれば
			if(!empty($data) && !empty($data[0])){
				global $current_user;
				get_currentuserinfo();
				// 権限のデータがあれば
				if(isset($current_user->roles) && isset($current_user->roles[0]) && isset($current_user->ID)){
					// 管理者権限もしくは作成者とユーザIDが一致すれば実行する
					if($current_user->roles[0]=='administrator' || $current_user->ID==$data[0]['add_uid']){
						$copy_data = array();
						// テーマ作成用の配列を作成
						foreach($data[0] as $key => $d){
							switch($key){
								// テーマタイトルにコピーを付加
								case 'theme_title':
									$copy_data[$key] = $d.'コピー';
									break;
								// テーマidを空にする
								case 'theme_id':
									$copy_data[$key] = '';
									break;
								// フォーム
								case 'form':
									foreach($d as $i => $form){
										foreach($form as $f_key => $fd){
											switch($f_key){
												// フォームidを空に
												case 'form_id':
													$copy_data['form'][$i][$f_key] = '';
													break;
												// 入力
												case 'input':
													foreach($fd as $t => $input){
														foreach($input as $i_key => $inp){
															switch($i_key){
																// 入力idを空に
																case 'input_id':
																	$copy_data['input'][$i][$t][$i_key] = '';
																	break;
																// その他
																default:
																	$copy_data['input'][$i][$t][$i_key] = $inp;
															}
														}
													}
													break;
												// その他
												default:
													$copy_data['form'][$i][$f_key] = $fd;
											}
										}
									}
									break;
								// その他
								default:
									$copy_data[$key] = $d;
							}
						}
						// 新規作成
						$return = self::nippo_insert($copy_data);
						// エラーがなければリダイレクト
						if(empty($return['validate'])){
							$redirect_url = 'admin.php?page=osnp-theme.php&msg=theme-copy-ok';
							self::os_redirect($redirect_url);
						}else{
							$message = osNippoPluginValidationClass::arr_message($validate);
						}
					}else{
						$message[] = 'このテーマの編集権限がありません！';
					}
				}else{
					$message[] = 'あなたのユーザ情報が取得できませんでした。';
				}
			}else{
				$message[] = '存在しないテーマが指定されました。';
			}
		}else{
			$message[] = 'idの指定がないので、テーマの複製はできません。';
		}

		return $message;

	}
	/*
	*  テーマ削除
	*/
	public function theme_delete(){

		$message = array();
		global $wpdb;
		$get_id = (isset($_GET) && isset($_GET['delete_id'])) ? $_GET['delete_id']: '';
		//
		if(!empty($get_id)){
			$message[] = 'テーマを削除中…';
			$data = osNippoThemeClass::getThemeList('postedit_permit', $get_id);
			// 存在すれば
			if(!empty($data) && !empty($data[0])){
				global $current_user;
				get_currentuserinfo();
				// 権限のデータがあれば
				if(isset($current_user->roles) && isset($current_user->roles[0]) && isset($current_user->ID)){
					// 管理者権限もしくは作成者とユーザIDが一致すれば実行する
					if($current_user->roles[0]=='administrator' || $current_user->ID==$data[0]['add_uid']){
						$error = 0;
						// テーマ、削除フラグ
						$del_return = $wpdb->update(OSNP_THEME_TABLE, array('delete_flag'=>1), array('theme_id'=>$get_id), array('%d'), array('%d'));
						$form = (!empty($data[0]['form'])) ? $data[0]['form']: '';
						$input = (!empty($form) && !empty($form[0]) && !empty($form[0]['input'])) ? $form[0]['input']: '';
						// テーマ削除成功
						if($del_return!==FALSE){
							// フォーム、削除フラグ
							if(!empty($form) && !empty($form[0]) && !empty($form[0]['form_id'])){
								$del_form_return = $wpdb->update(OSNP_THEME_FORM_TABLE, array('delete_flag'=>1), array('theme_id'=>$get_id), array('%d'), array('%d'));
								// 失敗
								if($del_form_return===FALSE){
									$error = 1;
								}
							}
						}else{ // テーマ削除失敗
							$error = 1;
						}
						// エラーがなければ、入力、削除フラグ
						if($error==0){
							if(!empty($input) && !empty($input[0]) && !empty($input[0]['input_id'])){
								foreach($form as $f){
									if(!empty($f['form_id'])){
										$del_inp_return = $wpdb->update(OSNP_THEME_INPUT_TABLE, array('delete_flag'=>1), array('form_id'=>$f['form_id']), array('%d'), array('%d'));
										// 失敗
										if($del_inp_return===FALSE){
											$error = 1;
											break;
										}
									}
								}
							}
						}
						// 成功なら
						if($error==0){
							$redirect_url = 'admin.php?page=osnp-theme.php&msg=theme-delete-ok';
							self::os_redirect($redirect_url);
						}else{
							$message[] = '削除に失敗しました！';
						}
					}else{
						$message[] = 'このテーマの編集権限がありません！';
					}
				}else{
					$message[] = 'あなたのユーザ情報が取得できませんでした。';
				}
			}else{
				$message[] = '存在しないテーマもしくは既に削除済みのテーマが指定されました。';
			}
		}else{
			$message[] = 'idの指定がないので、テーマの削除はできません。';
		}

		return $message;

	}
	/*
	*  バリデーション
	*/
	private function validation_post($post=''){

		$post = (!empty($post)) ? $post: $_POST;
		$validate = array();
		// メッセージを修正
		$change_arr = array();
		//
		foreach($post as $key => $p){
			switch($key){
				case 'theme_title':
					$this_validate = osNippoPluginValidationClass::validation_rule($p, $key, array('empty', array('number', 0, 150)));
					$change_arr['theme_title'] = '日報テーマ名';
					break;
				case 'form':
					foreach($p as $i => $arr){
						foreach($arr as $fkey => $pp){
							switch($fkey){
								case 'form_title': case 'form_label':
									$val_key = $fkey.$i;
									$this_validate = osNippoPluginValidationClass::validation_rule($pp, $val_key, array('empty', array('number', 0, 200)));
									$change_arr[$val_key] = ($fkey=='form_title') ? 'フォームタイトル' : 'フォームラベル';
									break;
							}
							// 結合
							if(!empty($validate)){
								$validate = array_merge($validate, $this_validate);
							}else{
								$validate = $this_validate;
							}
						}
					}
					break;
				case 'input':
					foreach($p as $i => $arr){
						foreach($arr as $t => $pp){
							foreach($pp as $fkey => $inp){
								$val_key = $fkey.$i.'-'.$t;
								//
								switch($fkey){
									case 'input_title': case 'input_label':
										$this_validate = osNippoPluginValidationClass::validation_rule($inp, $val_key, array('empty', array('number', 0, 200)));
										$change_arr[$val_key] = ($fkey=='input_title') ? '入力タイトル' : '入力ラベル';
										break;
									case 'input_name':
										$this_validate = osNippoPluginValidationClass::validation_rule($inp, $val_key, array('empty', 'alphanumeric-em-ub', array('number', 0, 200)));
										$change_arr[$val_key] = '入力Name';
										break;
								}
								// 結合
								if(!empty($validate)){
									$validate = array_merge($validate, $this_validate);
								}else{
									$validate = $this_validate;
								}
							}
						}
					}
					break;
			}
			// 結合
			if(!empty($validate)){
				$validate = array_merge($validate, $this_validate);
			}else{
				$validate = $this_validate;
			}
		}
		// メッセージ作成
		$validate = osNippoPluginValidationClass::validates_message($validate, $change_arr);

		return $validate;

	}
	/*
	*  テーマを利用できるユーザ判定
	*/
	public function check_permit_userlevel($user_level='0'){

		$_return = array('level'=>0, 'text'=>'');
		//
		switch($user_level){
			case 8: case 9: case 10:
				$_return['text'] = '管理者';
				break;
			case 3: case 4: case 5: case 6: case 7:
				$_return['text'] = '編集者以上';
				break;
			case 2:
				$_return['text'] = '投稿者以上';
				break;
			case 1:
				$_return['text'] = '寄稿者以上';
				break;
			case 0:
				$_return['text'] = '購読者以上';
				break;
		}

		return $_return;

	}

}
$osNippoThemeClass = new osNippoThemeClass();
?>