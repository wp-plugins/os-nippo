<?php
// 日報テンプレート編集class
class osNippoPostClass extends osNippoPluginCommonClass {

	public function __construct(){

		parent::__construct();
		// カスタム投稿タイプ
		add_action('init', array('osNippoPostClass', 'codex_custom_init'));
		// メタを追加
		add_action('admin_init', array('osNippoPostClass', 'custom_meta_init'));
		add_action('save_post', array('osNippoPostClass', 'custom_save_postdata'));
		//
		add_action('admin_init', array('osNippoPostClass', 'postlist_redirect'));

	}
	/*
	*  カスタム投稿タイプ
	*/
	public function codex_custom_init(){

		$data = osNippoThemeClass::getThemeList('post_permit');
		//
		if(!empty($data) && is_array($data)){
			foreach($data as $d){
				$theme_id = $d['theme_id'];
				$title = $d['theme_title'];
				$name = 'nippo-post'.$theme_id;
				//
				register_post_type(
					$name,
					array(
						'menu_position' => 4,
						'labels' => array(
							'name' => $title.'の管理',
							'add_new_item' => $title.'を追加',
							'edit_item' => $title.'の編集',
						),
						'public' => true, 'rewrite' => true, 'show_in_nav_menus' => true,
						'supports' => array(
							'title', 'editor', 'thumbnail',
						),
					)
				);
				register_taxonomy_for_object_type('category', $name);
			}
		}

	}
	/*
	*  管理者以外は自分の投稿一覧を表示するページへリダイレクト
	*/
	public function postlist_redirect(){

		$parse_url = parse_url($_SERVER["REQUEST_URI"]);
		$path = (isset($parse_url['path'])) ? $parse_url['path']: '';
		$query = (isset($parse_url['query'])) ? $parse_url['query']: '';
		// 日報ページなら
		if(stristr($path, '/edit.php') && stristr($query, 'post_type=nippo-post') && !stristr($query, '&author=')){
			global $osnp_option_data;
			global $current_user;
			get_currentuserinfo();
			// 権限のデータがあれば
			if(isset($current_user->roles) && isset($current_user->roles[0])){
				$user_level = $current_user->roles[0];
			}
			// 処理
			switch($user_level){
				// 管理者ならそのまま表示
				case 'administrator':
					break;
				// それ以外のユーザは自分の投稿一覧のみ
				default:
					parse_str($query, $params);
					$url = '';
					//
					foreach($params as $key => $p){
						$url .= '&'.$key.'='.$p;
						//
						if($key=='author'){
							$author_ok = 1;
							break;
						}
					}
					// authorがなければauthor=ユーザidでリダイレクト
					if(!isset($author_ok)){
						$uid = $current_user->ID;
						$redirect_url = $path.'?'.$url.'&author='.$uid;
						wp_redirect($redirect_url);
						exit;
					}
			}
		}

	}
	/*
	*  フィールド
	*/
	public function custom_meta_init(){

		$post_type = '';
		$action = (isset($_GET) && isset($_GET['action'])) ? $_GET['action']: '';
		//
		switch($action){
			case 'edit':
				$post_id = (isset($_GET) && isset($_GET['post'])) ? $_GET['post']: '';
				$post_type = get_post_type($post_id);
				break;
			default:
				$post_type = (isset($_GET) && isset($_GET['post_type'])) ? $_GET['post_type']: 'post';
		}
		//
		if(preg_match("/nippo-post([0-9]+)/u", $post_type, $matches)){
			$theme_id = trim($matches[1]);
			$data = osNippoThemeClass::getThemeList('postedit_permit', $theme_id);
			//
			if(!empty($data)){
				global $post;
				$post_id = (isset($post->ID)) ? $post->ID: '';
				$meta_value = get_post_meta($post_id, 'nippo', true);
				$callback_args = array('form_id'=>0, 'post_type'=>$post_type, 'form'=>array(), 'post_meta'=>$meta_value);
				//
				foreach($data as $d){
					foreach($d['form'] as $form){
							$form_id = (isset($form['form_id'])) ? $form['form_id']: 0;
							$title = (isset($form['form_label'])) ? $form['form_label']: '日報';
							$callback_args['form_id'] = $form_id;
							$callback_args['form'] = $form;
							add_meta_box('nippo_metabox_'.$form_id, $title, array('osNippoPostClass', 'inner_custom_box'), $post_type, 'normal', 'high', $callback_args);
					}
				}
			}
		}

	}
	//
	public function inner_custom_box($post='', $callback_args=''){

		if(!empty($callback_args['args']) && !empty($callback_args['args']['form'])){
			//
			$post_id = (!empty($post) && isset($post->ID)) ? $post->ID: 0;
			$post_type = (isset($callback_args['args']['post_type'])) ? $callback_args['args']['post_type']: 'nippo-post0';
			$name = str_replace('-', '_',$post_type);
			$form = $callback_args['args']['form'];
			$form_id = (isset($callback_args['args']['form_id'])) ? $callback_args['args']['form_id']: 0;
			$post_meta = get_post_meta($post_id);
?>
		<div class="osnp_box">
<?php
			//
			if(!empty($form['input']) && is_array($form['input'])){
				foreach($form['input'] as $input){
					$input_id = (isset($input['input_id'])) ? $input['input_id']: 0;
					$input_name = (isset($input['input_name'])) ? $input['input_name']: '';
					$input_type = (isset($input['input_type'])) ? $input['input_type']: 0;
					$input_time_num = (isset($input['input_time_num'])) ? $input['input_time_num']: 0;
					$input_class = (isset($input['input_class'])) ? $input['input_class']: '';
					$input_value = (isset($input['input_value'])) ? $input['input_value']: '';
					$label = (isset($input['input_label'])) ? $input['input_label']: '';
					$meta_key = OSNP_META_PRE.$input_id;
					//
					if(isset($post_meta[$meta_key]) && isset($post_meta[$meta_key][0])){
						$pmeta_value = ($unserialize = @unserialize($post_meta[$meta_key][0]))!==FALSE ? $unserialize : $post_meta[$meta_key][0];
					}else{
						$pmeta_value = '';
					}
?>
			<div class="osnp_inner_custom_box <?php echo $input_class; ?>">
				<label for="<?php echo $input_name; ?>"><?php echo esc_html($label); ?></label>
<?php
					//
					if(empty($input_time_num)){
						echo "\t\t\t\t";
						//
						switch($input_type){
							case 1:
								echo '<textarea name="'.$input_name.'" id="'.$input_name.'">'.$pmeta_value.'</textarea>';
								break;
							default:
								echo '<input type="text" name="'.$input_name.'" id="'.$input_name.'" value="'.esc_html($pmeta_value).'" />';
						}
						//
						echo "\n";
					}
					// 年月日日時分の特殊なselect
					else{
						// 数字を1桁ずつ分割
						if(preg_match_all('/([0-9])/', $input_time_num, $matches)){
							// 選択値
							if(empty($pmeta_value)){
								$selected_ex = self::ymdhis_explode($input_value);
							}else{
								$selected_ex = self::ymdhis_explode($pmeta_value);
							}
							//
							if(isset($matches[0])){
								foreach($matches[0] as $i => $m){
									if($i==0){
										$tag_id = $input_name;
									}else{
										$tag_id = '';
									}
									$aftr = '';
									$options = '';
									//
									if(isset($selected_ex[$i])){
										$selected = $selected_ex[$i];
									}else{
										$selected = '';
									}
									//
									switch($m){
										case 1:
											$options = self::year_select_options($selected);
											$aftr = '年';
											break;
										case 2:
											$options = self::month_select_options($selected);
											$aftr = '月';
											break;
										case 3:
											$options = self::day_select_options($selected);
											$aftr = '日';
											break;
										case 4:
											$options = self::hour_select_options($selected);
											$aftr = '時';
											break;
										case 5:
											$options = self::min_select_options($selected);
											$aftr = '分';
											break;
									}
									//
									echo "\t\t\t\t<select name=\"".$input_name."[{$i}]\" id=\"{$tag_id}\">".$options."</select>".$aftr."\n";
								}
							}
						}
					}
?>
			</div>
<?php

				if(preg_match('/[\s]after\-clear|^after\-clear/', $input_class, $matches)){
					echo '<div class="block clearfix"></div>'."\n";
				}

				}// foreach end
			}// if end
?>
			<div id="osnp-post-editarea"></div>
		</div>
<?php
		}

	}
	/*
	*  POST時の処理
	*/
	public function custom_save_postdata(){

		global $post;
		$post_id = (isset($post->ID)) ? $post->ID: 0;
		$post_type = get_post_type($post_id);
		//
		if(preg_match("/nippo-post([0-9]+)/u", $post_type, $matches)){
			$theme_id = trim($matches[1]);
			$data = osNippoThemeClass::getThemeList('postedit_permit', $theme_id);
			$plevel = (isset($data[0]) && isset($data[0]['permit_userlevel'])) ? $data[0]['permit_userlevel']: 0;
			// ユーザ情報取得
			global $current_user;
			get_currentuserinfo();
			$level = 'level_'.$plevel; // ユーザレベルのfalse=0 or true=1
			// 投稿権限があれば
			if(isset($current_user->allcaps) && !empty($current_user->allcaps[$level])){
				if(isset($data[0]) && isset($data[0]['form']) && is_array($data[0]['form'])){
					foreach($data[0]['form'] as $i => $form){
						if(isset($form['input']) && is_array($form['input'])){
							foreach($form['input'] as $ii => $inp){
								$key = $inp['input_name'];
								if(isset($_POST) && isset($_POST[$key])){
									$meta_value = $_POST[$key];
									$meta_key = OSNP_META_PRE.$inp['input_id'];
									// キーが存在しないなら新規、存在するなら更新
									if(!add_post_meta($post_id, $meta_key, $meta_value, true)){
										update_post_meta($post_id, $meta_key, $meta_value);
									}
								}
							}
						}
					}
				}
			}
		}

	}
	/*
	*  select値
	*/
	// 年
	public function year_select_options($selected='', $str=''){

		$option_html = '';
		$now_year = date("Y", time());
		//
		for($i=0; $i<10; $i++){
			$year = $now_year - $i;
			//
			if(empty($selected)){
				$html_selected = ($year==$now_year) ? 'selected': '';
			}else{
				$html_selected = ($year==$selected) ? 'selected': '';
			}
			$option_html .= '<option value="'.$year.'" '.$html_selected.'>'.$year.$str.'</option>';
		}

		return $option_html;

	}
	// 月日時分
	public function mdhi_select_options($mdhi='', $selected='', $str=''){

		$option_html = '';
		$now = '01';
		$start_i = 1;
		//
		switch($mdhi){
			case 'i':
				$now = sprintf("%02d", date("i", time()));
				$start_i = 0;
				$end_i = 61;
				break;
			case 'h':
				$now = sprintf("%02d", date("H", time()));
				$start_i = 0;
				$end_i = 25;
				break;
			case 'd':
				$now = sprintf("%02d", date("d", time()));
				$end_i = 32;
				break;
			default:
				$now = sprintf("%02d", date("m", time()));
				$end_i = 13;
		}
		//
		for($i=$start_i; $i<$end_i; $i++){
			$t = sprintf("%02d", $i);
			//
			if(empty($selected)){
				$html_selected = ($t==$now) ? 'selected': '';
			}else{
				$html_selected = ($t==$selected) ? 'selected': '';
			}
			$option_html .= '<option value="'.$t.'" '.$html_selected.'>'.$t.$str.'</option>';
		}

		return $option_html;

	}
	// 月
	public function month_select_options($selected='', $str=''){
		return self::mdhi_select_options('m', $selected, $str);
	}
	// 日
	public function day_select_options($selected='', $str=''){
		return self::mdhi_select_options('d', $selected, $str);
	}
	// 時
	public function hour_select_options($selected='', $str=''){
		return self::mdhi_select_options('h', $selected, $str);
	}
	// 分
	public function min_select_options($selected='', $str=''){
		return self::mdhi_select_options('i', $selected, $str);
	}
	//
	public function ymdhis_explode($str=''){

		if(is_array($str)){
			return $str;
		}else{
			$str = str_replace(array('-', ' '), ':', $str);
			return explode(':', $str);
		}

	}

}
$osNippoPostClass = new osNippoPostClass();
?>