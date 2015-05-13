<?php
if(class_exists('osNippoAdminClass')){

?>

	<div id="osnp-plugin">
	<?php include_once(OSNP_PLUGIN_VIEW_DIR."/admin-head.php"); ?>
		<div class="osnp-wrap">
			<h2>日報テーマの作成・編集</h2>
			<div id="osnp-headmenu"><span><a href="admin.php?page=osnp-theme.php">日報テーマ一覧</a></span><span><a href="admin.php?page=osnp-theme.php&amp;mode=add">日報テーマ作成</a></span></div>
			<?php
			if(!empty($file_name)){
				include_once(OSNP_PLUGIN_VIEW_DIR."/".$file_name);
			}elseif(!empty($message_only)){
				self::msg_output($message);
			}else{
				echo "<p class=\"msg\">存在しないページが指定されました！</p>";
			}
			?>
		</div>
	</div>

<?php
}
?>