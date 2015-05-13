<?php
if(class_exists('osNippoAdminClass')){
?>
	<div id="osnp-plugin">
		<?php include_once(OSNP_PLUGIN_VIEW_DIR."/admin-head.php"); ?>
		<div class="osnp-wrap">
			<h2>はじめに</h2>
			<div class="osnp-contents">
				<p>OS日報プラグインを導入していただき、ありがとうございます。</p>
				<p>当プラグインのご利用は無料です。個人サイトでも商用サイトでも利用できますが、必ず<a href="?page=osnp-agreement.php">利用規約</a>をご覧ください。</p>
				<p>ご連絡は<a href="http://lp.olivesystem.jp/plugin-nippo-mail" title="問い合わせ" target="_blank">問い合わせフォーム</a>からお願い致します。</p>
			</div>
			<h2>最低動作環境</h2>
			<div class="osnp-contents">
				WordPress3.1以上、JQuery1.7以上、ユーザのブラウザでJQueryが動作すること。
			</div>
			<h2>主な特徴</h2>
			<div class="osnp-contents">
				<h3 class="green">日報のテーマが作成できる</h3>
				<p>日報の投稿テーマが作成できます。ユーザのレベルごとに日報の投稿テーマを替えられます。</p>
			</div>
			<h2>更新履歴</h2>
			<div class="osnp-contents">
				<p>2015.05.12 リリース</p>
			</div>
		</div>
	</div>

<?php
}
?>