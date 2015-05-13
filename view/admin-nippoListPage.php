<?php
if(class_exists('osNippoAdminClass')){
?>

	<div id="osnp-plugin">
	<?php include_once(OSNP_PLUGIN_VIEW_DIR."/admin-head.php"); ?>
		<div class="osnp-wrap">
			<h2>日報の投稿一覧</h2>
			<div class="osnp-contents">
			<?php
			if(!empty($list)){
			?>
				<table>
					<tr>
					<th>タイトル</th><th>投稿者</th><th>投稿日時</th>
					</tr>
				<?php
					foreach($list as $post){
						setup_postdata($post);
				?>
					<tr>
						<td><a href="admin.php?page=osnp-postsingle.php&id=<?php the_ID(); ?>"><?php the_title(); ?></a></td>
						<td><?php the_author(); ?></td>
						<td><?php the_time('Y-m-d H:i:s'); ?></td>
					</tr>
				<?php
					}
				?>
				</table>
			<?php
				self::view_backnext($paged, $total, '20');
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