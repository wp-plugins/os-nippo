<?php
if(class_exists('osNippoAdminClass')){
	// タイムゾーン
	if(isset($options['timezone'])){
		$timezone = $options['timezone'];
	}else{
		$timezone = osnpTimezoneGet();
	}
?>

	<div id="osnp-plugin">
	<?php include_once(OSNP_PLUGIN_VIEW_DIR."/admin-head.php"); ?>
		<div class="osnp-wrap">
			<h2>設定</h2>
			<div class="osnp-contents">
				<?php self::msg_output($message); ?>
				<form action="admin.php?page=osnp-options.php" method="POST" class="osnp-form">
					<table>
						<tr>
						<?php
						$value = (isset($options['theme_authority'])) ? $options['theme_authority']: 0;
						?>
							<th>日報テーマ<br />編集権限</th>
							<td>
							<input type="radio" name="theme_authority" id="theme_authority0" value="0" <?php if($value==0){ echo "checked"; } ?> /><label for="theme_authority0">管理者権限ユーザのみ日報テーマを作成可能</label>
							<p style="margin:0 10px 5px 15px;padding:0;">（テーマ編集も管理者権限ユーザのみ）</p>
							<input type="radio" name="theme_authority" id="theme_authority1" value="1" <?php if($value==1){ echo "checked"; } ?> /><label for="theme_authority1">投稿ユーザも日報テーマを作成可能</label>　<small>※1</small>
							<p style="margin:0 5px 5px 15px;padding:0;">（テーマ編集は作成者及び管理者権限ユーザが可能）</p>
							</td>
						</tr>
						<tr>
							<th><label for="timezone">タイムゾーン</label></th>
							<td>
								<select name="timezone" id="timezone">
									<option value="" <?php if(empty($timezone)){ ?>selected<?php } ?>>設定しない</option>

								<?php
								$timeZoneData = osnpTimezoneClass::zonelist();
								//
								foreach($timeZoneData as $group => $d){
								?>
									<optgroup label="<?php echo $group; ?>">

									<?php
									foreach($d as $zone => $name){
									?>
									<option value="<?php echo $zone; ?>" <?php if($timezone==$zone){ ?>selected<?php } ?>><?php echo $name; ?></option>
									<?php
									echo "\n";
									}
									?>

									</optgroup>
								<?php
								}
								?>

								</select>
								<div>タイムゾーン設定での現在時刻 : <?php echo date("Y-m-d H:i:s", time()); ?></div>
							</td>
						</tr>
						<tr>
						<?php
						$value = (isset($options['license'])) ? $options['license']: 'free';
						?>
							<th><label for="license">ライセンス</label></th>
							<td>
								<input type="text" name="license" id="license" value="<?php echo esc_html($value); ?>" /><br />
								<div style="font-size:11px;">※ライセンスを取得した方のみ、ご記入ください。デフォルトは「free」です。</div>
							</td>
						</tr>
					</table>
					<input type="hidden" name="osnp_formname" value="option" />
					<div class="submit">
						<input type="submit" name="submit" value="更新する" />
					</div>
				</form>
				<div>
				<small>※1　権限がauthor、editorの場合にテーマを編集できます。</small>
				</div>
			</div>
		</div>
	</div>

<?php
}
?>