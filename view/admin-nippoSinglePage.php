<?php
if(class_exists('osNippoAdminClass')){
?>

	<div id="osnp-plugin">
	<?php include_once(OSNP_PLUGIN_VIEW_DIR."/admin-head.php"); ?>
		<div class="osnp-wrap">
			<h2>日報の投稿詳細 id:<?php echo esc_html($get_id); ?></h2>
			<div class="osnp-contents nippo-detail">
			<?php
			if(!empty($detail)){
				$theme_name = (isset($theme_data[0]) && isset($theme_data[0]['theme_title'])) ? $theme_data[0]['theme_title']: '';
			?>
				<h3 class="theme_title"><?php echo $theme_name; ?></h3>
				<?php
				$post_title = (isset($detail->post_title)) ? $detail->post_title: '';
				$post_date = (isset($detail->post_date)) ? $detail->post_date: '';
				$post_content = (isset($detail->post_content)) ? $detail->post_content: '';
				?>
				<br />
				<table class="post_data">
					<tr>
						<th>タイトル</th><td><?php echo esc_html($post_title); ?></td>
					</tr>
					<tr>
						<th>作成日</th><td><?php echo $post_date; ?></td>
					</tr>
					<tr>
						<th>テキスト</th><td><?php echo $post_content; ?></td>
					</tr>
				</table>
				<?php
				if(!empty($meta)){
					$form_data = (isset($theme_data[0]) && isset($theme_data[0]['form'])) ? $theme_data[0]['form']: '';
					//
					foreach($form_data as $fd){
						$form_label = (isset($fd['form_label']))? $fd['form_label']: '';
						$input_data = (isset($fd['input'])) ? $fd['input']: '';
				?>
				<br />
				<table class="form_data">
					<tr>
						<th><?php echo esc_html($form_label); ?></th>
					</tr>
					<tr>
						<td>
						<div class="osnp_box">
						<?php
						if(!empty($input_data)){
							foreach($input_data as $inp){
								$input_id = (isset($inp['input_id'])) ? $inp['input_id']: 0;
								$input_type = (isset($inp['input_type'])) ? $inp['input_type']: 0;
								$input_time_num = (isset($inp['input_time_num'])) ? $inp['input_time_num']: 0;
								$input_class = (isset($inp['input_class'])) ? $inp['input_class']: '';
								$input_label = (isset($inp['input_label'])) ? $inp['input_label']: '';
								$mkey = OSNP_META_PRE.$input_id;
								$value = (isset($meta[$mkey]) && isset($meta[$mkey][0])) ? $meta[$mkey][0]: '';
								//
								if(empty($input_time_num)){
							?>
							<div class="<?php echo esc_html($input_class); ?>">
								<label><?php echo esc_html($input_label); ?></label>
								<?php echo esc_html($value); ?>
							</div>
							<?php
								}else{
									$pmeta_value = ($unserialize = @unserialize($value))!==FALSE ? $unserialize : $value;
									// 数字を1桁ずつ分割
									if(preg_match_all('/([0-9])/', $input_time_num, $matches)){
										$time_num = $matches[0];
									}else{
										$time_num = '';
									}
							?>
							<div class="<?php echo esc_html($input_class); ?>">
								<label><?php echo esc_html($input_label); ?></label>
									<?php
									foreach($pmeta_value as $t => $val){
										$aftr = '';
										echo esc_html($val);
										$m = (isset($time_num[$t])) ? $time_num[$t]: '';
										//
										switch($m){
											case 1: $aftr = '年';
												break;
											case 2: $aftr = '月';
												break;
											case 3: $aftr = '日';
												break;
											case 4: $aftr = '時';
												break;
											case 5: $aftr = '分';
												break;
										}
										echo $aftr;
									}
									?>
							</div>
							<?php
								}
							}
						}
						?>
						</div>
						</td>
					</tr>
				</table>
				<?php
					}
				}
				?>
			<?php
			}else{
				echo "日報の投稿データがありません。";
			}
			?>
			</div>
		</div>
	</div>

<?php
}
?>