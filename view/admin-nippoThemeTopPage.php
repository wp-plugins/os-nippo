<?php
if(class_exists('osNippoAdminClass')){

?>

			<div class="osnp-pagetitle">日報テーマ一覧</div>
			<?php self::msg_output($message); ?>
			<div class="osnp-contents">
<?php
			if(!empty($data) && is_array($data)){
?>
				<table>
				<tr>
					<th>ID</th><th>テーマ名</th><th>テーマ説明</th><th>作成日時</th><th>編集</th>
				</tr>
<?php
				foreach($data as $d){
					$tid = $d['theme_id'];
					//
					switch($user_level){
						// 管理者
						case 'administrator':
							$theme_name_td = "<a href=\"edit.php?post_type=nippo-post{$tid}\" title=\"このテーマの投稿一覧\">".esc_html($d['theme_title'])."</a>";
							$wr_td = "<a href=\"admin.php?page=osnp-theme.php&mode=wr&id={$tid}\">編集</a>";
							break;
						// その他
						default:
							$level = 'level_'.$d['permit_userlevel'];
							$level_check = (isset($allcaps[$level])) ? $allcaps[$level]: 0;
							//
							if($level_check==1){
								$theme_name_td = "<a href=\"edit.php?post_type=nippo-post{$tid}\" title=\"このテーマの投稿一覧\">".esc_html($d['theme_title'])."</a>";
							}else{
								$theme_name_td = esc_html($d['theme_title']);
							}
							//
							if($user_id==$d['add_uid']){
								$wr_td = "<a href=\"admin.php?page=osnp-theme.php&mode=wr&id={$tid}\">編集</a>";
							}else{
								$wr_td = " - ";
							}
					}
					echo "\t\t\t\t<tr>\n";
					echo "\t\t\t\t\t<td>".$tid."</td><td>{$theme_name_td}</td><td>".esc_html($d['theme_desc_text'])."</td><td>".$d['create_time']."</td><td>{$wr_td}</td>";
					echo "\t\t\t\t</tr>\n";
				}
?>
				</table>
				<div>
					<small>※編集は編集権限がないとできません。</small>
				</div>
<?php
			}else{
				echo "<p>データがありません。新規作成してください。</p>";
			}
?>
			</div>

<?php
}
?>