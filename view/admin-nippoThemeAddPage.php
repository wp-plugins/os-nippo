<?php
if(class_exists('osNippoAdminClass')){
?>

			<div class="osnp-pagetitle"><?php echo $pagetitle; ?></div>
			<?php self::msg_output($message); ?>
			<div class="osnp-contents">
			<?php
			if((!empty($get) && $mode=='wr') || $mode=='add'){
			?>
				<form action="<?php echo $form_action; ?>" method="POST" class="osnp-form">
					<div id="form-html">
						<table>
							<?php $value = (isset($get['theme_title'])) ? $get['theme_title']: ''; ?>
							<tr>
								<th>テーマ名</th><td><input type="text" name="theme_title" id="theme_title" value="<?php echo esc_html($value); ?>" /></td>
							</tr>
							<?php $value = (isset($get['theme_desc_text'])) ? $get['theme_desc_text']: ''; ?>
							<tr>
								<th>テーマ説明</th><td><textarea name="theme_desc_text" id="theme_desc_text"><?php echo esc_textarea($value); ?></textarea></td>
							</tr>
							<?php $value = (isset($get['permit_userlevel'])) ? $get['permit_userlevel']: 2; ?>
							<tr>
								<th>投稿権限</th>
								<td>
									<select name="permit_userlevel">
										<option value="10" <?php if($value==10){ echo "selected"; } ?>>管理者</option>
										<option value="3" <?php if($value==3){ echo "selected"; } ?>>編集者以上</option>
										<option value="2" <?php if($value==2){ echo "selected"; } ?>>投稿者以上</option>
										<option value="1" <?php if($value==1){ echo "selected"; } ?>>寄稿者以上</option>
										<option value="0" <?php if($value==0){ echo "selected"; } ?>>購読者以上</option>
									</select>
								</td>
							</tr>
						</table>
						<?php if($mode=='wr'): ?>
						<a name="theme-bottom" id="theme-bottom"></a>
						<div id="cod-themebox" class="copy-or-del">
							<div class="text-copy" style="display:none;">
								このテーマをコピーします。よろしいですか？
								<p>
									<span class="l15"><input type="button" value="コピーする" class="copy" /></span>
									<span class="l25"><input type="button" value="キャンセル" class="cancel" /></span>
								</p>
							</div>
							<div class="text-del" style="display:none;">
								このテーマを削除します。よろしいですか？
								<p>
									<span class="l15"><input type="button" value="削除する" class="delete" /></span>
									<span class="l25"><input type="button" value="キャンセル" class="cancel" /></span>
								</p>
							</div>
							<div class="first">
								<span class="l15"><small class="click-copy">このテーマをコピー</small></span>
								<span class="l25"><small class="click-del">このテーマを削除</small></span>
							</div>
						</div>
						<?php endif; ?>
						<div class="heading">フォーム情報</div>
						<div style="margin:0 10px 10px 10px;"><input type="button" value="フォームを追加" class="js-button" onclick="form_add()" /></div>
						<?php
						if(isset($get['form']) && !empty($get['form'][0])):
							$form_ct = 0;
							foreach($get['form'] as $i => $form){
								$t = 0;
								$form_id = (isset($form['form_id'])) ? $form['form_id']: '';
								$value = (isset($form['form_title'])) ? $form['form_title']: '';
						?>

						<table id="form-table<?php echo $i ?>">
							<tr>
								<th><label for="form-title<?php echo $i ?>">フォームタイトル</label></th>
								<td><input type="text" name="form[<?php echo $i ?>][form_title]" value="<?php echo esc_html($value); ?>" id="form_title<?php echo $i ?>" /><input type="hidden" name="form[<?php echo $i ?>][form_id]" value="<?php echo $form_id; ?>" /></td>
							</tr>
							<?php $value = (isset($form['form_title'])) ? $form['form_title']: ''; ?>
							<tr>
								<th><label for="form-label<?php echo $i ?>">フォームラベル</label></th>
								<td><input type="text" name="form[<?php echo $i ?>][form_label]" value="<?php echo esc_html($value); ?>" id="form_label<?php echo $i ?>" /></td>
							</tr>
							<?php $value = (isset($form['form_desc_text'])) ? $form['form_desc_text']: ''; ?>
							<tr>
								<th><label for="form-desc_text<?php echo $i ?>">フォームの説明文</label></th>
								<td><textarea name="form[<?php echo $i ?>][form_desc_text]" id="form-desc_text<?php echo $i ?>"><?php echo esc_textarea($value); ?></textarea></td>
							</tr>
							<?php $value = (isset($form['form_class'])) ? $form['form_class']: ''; ?>
							<tr>
								<th><label for="form-class<?php echo $i ?>">フォームclass</label></th>
								<td><input type="text" name="form[<?php echo $i ?>][form_class]" value="<?php echo esc_html($value); ?>" id="form_class<?php echo $i ?>" /></td>
							</tr>
							<?php $value = (isset($form['order'])) ? $form['order']: ''; ?>
							<tr>
								<th><label for="form-order<?php echo $i ?>">昇順</label></th>
								<td><input type="text" name="form[<?php echo $i ?>][order]" value="<?php echo esc_html($value); ?>" id="form_order<?php echo $i ?>" /></td>
							</tr>
							<tr>
								<th>入力欄</th>
								<td>
								<?php
								if(isset($form['input']) && !empty($form['input'][0])):
									foreach($form['input'] as $ii => $input){
										$value = (isset($input['input_title'])) ? $input['input_title']: '';
										$input_id = (isset($input['input_id'])) ? $input['input_id']: 0;
								?>
									<div id="input-table<?php echo $i ?>-<?php echo $ii ?>">
										<div class="div-inp">
											<lable>タイトル</lable>
											<input type="text" name="input[<?php echo $i ?>][<?php echo $ii ?>][input_title]" id="input_title<?php echo $i ?>-<?php echo $ii ?>" value="<?php echo esc_html($value); ?>" /><input type="hidden" name="input[<?php echo $i ?>][<?php echo $ii ?>][input_id]" value="<?php echo $input_id; ?>" />
										</div>
										<?php $value = (isset($input['input_label'])) ? $input['input_label']: ''; ?>
										<div class="div-inp">
											<lable>ラベル</lable>
											<input type="text" name="input[<?php echo $i ?>][<?php echo $ii ?>][input_label]" id="input_label<?php echo $i ?>-<?php echo $ii ?>" value="<?php echo esc_html($value); ?>" />
										</div>
										<?php $value = (isset($input['input_name'])) ? $input['input_name']: ''; ?>
										<div class="div-inp">
											<lable>Name</lable>
											<input type="text" name="input[<?php echo $i ?>][<?php echo $ii ?>][input_name]" id="input_name<?php echo $i ?>-<?php echo $ii ?>" value="<?php echo esc_html($value); ?>" />
										</div>
										<?php
										$time_num = (isset($input['input_time_num'])) ? $input['input_time_num']: 0;
										$value = (isset($input['input_type'])) ? $input['input_type']: '';
										?>
										<div class="div-inp">
											<lable>タイプ</lable>
											<input type="radio" name="time_num_flag[<?php echo $i ?>][<?php echo $ii ?>]" id="time_num_flag<?php echo $i ?>-<?php echo $ii ?>-0" value="0" onclick="func_time_num(<?php echo $i ?>, <?php echo $ii ?>, 0)" <?php if($time_num==0){ echo "checked"; } ?> /><label for="time_num_flag<?php echo $i ?>-<?php echo $ii ?>-0">通常の入力</label>
											<input type="radio" name="time_num_flag[<?php echo $i ?>][<?php echo $ii ?>]" id="time_num_flag<?php echo $i ?>-<?php echo $ii ?>-1" value="1" onclick="func_time_num(<?php echo $i ?>, <?php echo $ii ?>, 1)" <?php if($time_num!=0){ echo "checked"; } ?> /><label for="time_num_flag<?php echo $i ?>-<?php echo $ii ?>-1">日時のセレクトボックス</label>
											<div id="input-type<?php echo $i ?>-<?php echo $ii ?>" class="div-inp-inp">
												<?php $input_value = (isset($input['input_value'])) ? $input['input_value']: ''; ?>
												<div class="div-time_num pl15">
													<select name="input[<?php echo $i ?>][<?php echo $ii ?>][input_time_num]" id="time_num_select<?php echo $i ?>-<?php echo $ii ?>" class="time-num">
														<option value="12345" <?php if($time_num=='12345'){echo "selected";} ?>>yyyy年mm月dd日hh時ii分</option>
														<option value="123" <?php if($time_num=='123'){echo "selected";} ?>>yyyy年mm月dd日</option>
														<option value="23" <?php if($time_num=='23'){echo "selected";} ?>>mm月dd日</option>
														<option value="34" <?php if($time_num=='34'){echo "selected";} ?>>dd日hh時</option>
														<option value="45" <?php if($time_num=='45'){echo "selected";} ?>>hh時ii分</option>
													</select>
													<br />
													<small>yは西暦、mは月、dは日、hは時、iは分になります</small>
													<div>
														<label for="">デフォルトの値</label><input type="text" name="input[<?php echo $i ?>][<?php echo $ii ?>][input_time_num_default]" value="<?php echo esc_html($input_value); ?>" class="default-value" placeholder="" />
														<div class="val-msg"></div>
													</div>
												</div>
												<div class="div-type pl15">
													<select name="input[<?php echo $i ?>][<?php echo $ii ?>][input_type]" id="input_op<?php echo $i ?>-<?php echo $ii ?>" class="input_type_select">
														<option value="0" <?php if($value==0){echo "selected";} ?>>テキスト</option>
														<option value="1" <?php if($value==1){echo "selected";} ?>>テキストエリア</option>
														<option value="2" <?php if($value==2){echo "selected";} ?>>チェックボックス</option>
														<option value="3" <?php if($value==3){echo "selected";} ?>>ラジオボタン</option>
														<option value="4" <?php if($value==4){echo "selected";} ?>>セレクトボックス</option>
														<option value="5" <?php if($value==5){echo "selected";} ?>>パスワード</option>
													</select>
													<?php $value = (isset($input['checkbox_options'])) ? $input['checkbox_options']: ''; ?>
													<div class="select-checkbox">
														行ごとlabel,value,name,class<br />
														<textarea name="input[<?php echo $i ?>][<?php echo $ii ?>][checkbox_options]"><?php echo esc_textarea($value); ?></textarea>
													</div>
													<?php $value = (isset($input['radio_options'])) ? $input['radio_options']: ''; ?>
													<div class="select-radio">
														行ごとlabel,value,name,class<br />
														<textarea name="input[<?php echo $i ?>][<?php echo $ii ?>][radio_options]"><?php echo esc_textarea($value); ?></textarea>
													</div>
													<?php $value = (isset($input['select_options'])) ? $input['select_options']: ''; ?>
													<div class="select-selectbox">
														行ごとtext,value,class<br />
														<textarea name="input[<?php echo $i ?>][<?php echo $ii ?>][select_options]"><?php echo esc_textarea($value); ?></textarea>
													</div>
													<div>
														<label for="">デフォルトの値</label><input type="text" name="input[<?php echo $i ?>][<?php echo $ii ?>][input_value]" value="<?php echo esc_html($input_value); ?>" class="default-value" placeholder="" />
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="input-del">
										<div id="input-table-del<?php echo $i ?>-<?php echo $ii ?>" style="display:none;">
											<p class="red"><?php if(!empty($input_id)){ ?>入力設定id<?php echo $input_id; }else{ ?>この入力設定<?php } ?>は削除予定です。<br />下のチェックマークを外すとキャンセルされ、入力設定を表示します。</p>
										</div>
										<input type="checkbox" name="input_delete[<?php echo $i; ?>][<?php echo $ii ?>]" id="input-delete<?php echo $i; ?>-<?php echo $ii ?>" value="<?php if(!empty($input_id)){ echo $input_id; } ?>" class="input-del-checkbox" /><label for="input-delete<?php echo $i; ?>-<?php echo $ii ?>">この入力設定を削除する</label>
									</div>
									<hr>
								<?php
										$t++;
									}
								endif;
								?>
									<div id="input-add-area<?php echo $i ?>"></div>
									<div>
										<input type="button" value="入力を追加" class="js-button" onclick="input_add(<?php echo $i ?>)" />
									</div>
								</td>
							</tr>
						</table>
						<div class="form-del">
							<div id="form-table-del<?php echo $i ?>" style="display:none;">
								<p class="red"><?php if(!empty($form_id)){ ?>フォーム設定id<?php echo $form_id; }else{ ?>このフォーム設定<?php } ?>は削除予定です。<br />下のチェックマークを外すとキャンセルされ、フォーム設定を表示します。</p>
							</div>
							<input type="checkbox" name="form_delete<?php echo $i; ?>" id="form-delete<?php echo $i; ?>" value="<?php if(!empty($form_id)){ echo $form_id; } ?>" class="form-del-checkbox" /><label for="form-delete<?php echo $i; ?>">上のフォーム設定を削除する</label>
						</div>
						<input type="hidden" name="form-input-ct<?php echo $i; ?>" id="form-input-ct<?php echo $i; ?>" value="<?php echo $t; ?>" />
						<br />

						<?php
								$form_ct++;
							}
						endif;
						?>

					</div>
					<input type="hidden" name="form-ct" id="form-ct" value="<?php echo $form_ct; ?>" />
					<p>
					<?php
					switch($mode){
						// 作成
						case 'add':
					?>
							<input type="hidden" name="osnp_formname" value="theme_add" />
							<input type="submit" name="submit" value="作成" />
					<?php
							break;
						// 編集
						case 'wr':
					?>
							<input type="hidden" name="osnp_formname" value="theme_wr" />
							<input type="submit" name="submit" value="更新" />
					<?php
							break;
					}
					?>
					</p>
				</form>
				<script>
				<?php if($mode=='wr'): ?>
				// テーマをコピー
				j("#cod-themebox .click-copy").click(function () {
					j('#cod-themebox .text-copy').css('display', 'block');
					j('#cod-themebox .first').css('display', 'none');
				});
				// コピーを実行するurlへ
				j("#cod-themebox .text-copy .copy").click(function () {
					location.href = "admin.php?page=osnp-theme.php&mode=copy&copy_id=<?php echo $theme_id; ?>";
				});
				// コピーをキャンセル（非表示）
				j("#cod-themebox .text-copy .cancel").click(function () {
					j('#cod-themebox .text-copy').css('display', 'none');
					j('#cod-themebox .first').css('display', 'block');
				});
				// テーマを削除
				j("#cod-themebox .click-del").click(function () {
					j('#cod-themebox .text-del').css('display', 'block');
					j('#cod-themebox .first').css('display', 'none');
				});
				// 削除を実行するurlへ
				j("#cod-themebox .text-del .delete").click(function () {
					location.href = "admin.php?page=osnp-theme.php&mode=delete&delete_id=<?php echo $theme_id; ?>";
				});
				// 削除をキャンセル（非表示）
				j("#cod-themebox .text-del .cancel").click(function () {
					j('#cod-themebox .text-del').css('display', 'none');
					j('#cod-themebox .first').css('display', 'block');
				});
				<?php endif; ?>
				// フォームを削除
				j('.form-del-checkbox').click(function () {
					var id_name = j(this).attr("id");
					var str = id_name.replace(/form-delete/, "");
					// チェック
					if(j("#"+id_name).prop('checked')) {
						j("#form-table"+str).css('display', 'none');
						j("#form-table-del"+str).css('display', 'block');
					}
					else{
						j("#form-table"+str).css('display', 'table');
						j("#form-table-del"+str).css('display', 'none');
					}
				});
				// INPUTを削除
				j('.input-del-checkbox').click(function () {
					var id_name = j(this).attr("id");
					var str = id_name.replace(/input-delete/, "");
					// チェック
					if(j("#"+id_name).prop('checked')) {
						j("#input-table"+str).css('display', 'none');
						j("#input-table-del"+str).css('display', 'block');
					}
					else{
						j("#input-table"+str).css('display', 'block');
						j("#input-table-del"+str).css('display', 'none');
					}
				});
				//
				function select_options_view(i, ii){
					inp_op = j("#input_op"+i+'-'+ii).val();
					var inp_id = 'input-type'+i+'-'+ii;
					sw_select_options_view(inp_op, inp_id);
				}
				function sw_select_options_view(inp_op, inp_id){
					switch(inp_op){
						case 2: // チェックボックス
							j('#'+inp_id+' .select-checkbox').css('display', 'block');
							j('#'+inp_id+' .select-radio').css('display', 'none');
							j('#'+inp_id+' .select-selectbox').css('display', 'none');
							break;
						case 3: // ラジオボタン
							j('#'+inp_id+' .select-checkbox').css('display', 'none');
							j('#'+inp_id+' .select-radio').css('display', 'block');
							j('#'+inp_id+' .select-selectbox').css('display', 'none');
							break;
						case 4: // セレクトボックス
							j('#'+inp_id+' .select-checkbox').css('display', 'none');
							j('#'+inp_id+' .select-radio').css('display', 'none');
							j('#'+inp_id+' .select-selectbox').css('display', 'block');
							break;
						default:
							j('#'+inp_id+' .select-checkbox').css('display', 'none');
							j('#'+inp_id+' .select-radio').css('display', 'none');
							j('#'+inp_id+' .select-selectbox').css('display', 'none');
							break;
					}
				}
				//
				j(".input_type_select").change(function () {
					var id_name = j(this).attr("id");
					inp_op = parseInt(j('#'+id_name).val());
					var inp_id = j(this).parent().parent().attr("id");
					sw_select_options_view(inp_op, inp_id);
				});
				//
				function select_timenum_view(i, ii){
					var inp_id = 'input-type'+i+'-'+ii;
					inp_op = j('#'+inp_id+' .div-time_num select').val();
					sw_select_timenum_view(inp_op, inp_id);
				}
				function sw_select_timenum_view(inp_op, inp_id){
					inp_op = parseInt(inp_op);
					switch(inp_op){
						case 12345:
							j('#'+inp_id+' .div-time_num .val-msg').html('値はyyyy:mm:dd:hh:iiという形式で入力してください。');
							j('#'+inp_id+' .div-time_num .default-value').attr('placeholder', '2005:01:01:15:45');
							break;
						case 123:
							j('#'+inp_id+' .div-time_num .val-msg').html('値はyyyy:mm:ddという形式で入力してください。');
							j('#'+inp_id+' .div-time_num .default-value').attr('placeholder', '2005:01:01');
							break;
						case 23:
							j('#'+inp_id+' .div-time_num .val-msg').html('値はmm:ddという形式で入力してください。');
							j('#'+inp_id+' .div-time_num .default-value').attr('placeholder', '01:01');
							break;
						case 34:
							j('#'+inp_id+' .div-time_num .val-msg').html('値はdd:hhという形式で入力してください。');
							j('#'+inp_id+' .div-time_num .default-value').attr('placeholder', '01:15');
							break;
						case 45:
							j('#'+inp_id+' .div-time_num .val-msg').html('値はhh:iiという形式で入力してください。');
							j('#'+inp_id+' .div-time_num .default-value').attr('placeholder', '15:45');
							break;
					}
				}
				//
				j(".time-num").change(function () {
					var id_name = j(this).attr("id");
					inp_op = j('#'+id_name).val();
					var inp_id = j(this).parent().parent().attr("id");
					sw_select_timenum_view(inp_op, inp_id);
				});
				//
				function func_time_num(i, ii, d){
					if(d==1){
						j('#input-type'+i+'-'+ii+' .div-time_num').css('display', 'block');
						j('#input-type'+i+'-'+ii+' .div-type').css('display', 'none');
						select_timenum_view(i, ii);
					}
					else{
						j('#input-type'+i+'-'+ii+' .div-time_num').css('display', 'none');
						j('#input-type'+i+'-'+ii+' .div-type').css('display', 'block');
						select_options_view(i, ii);
					}
				}
				// 入力追加
				function input_add(i){

					ct = j('#form-input-ct'+i).val();
					ii = parseInt(ct) + 1;
					var add_html = '\
								<div class="div-inp">\
									<lable>タイトル</lable>\
									<input type="text" name="input['+i+']['+ii+'][input_title]" id="input_title'+i+'-'+ii+'" value="" />\
								</div>\
								<div class="div-inp">\
									<lable>ラベル</lable>\
									<input type="text" name="input['+i+']['+ii+'][input_label]" id="input_label'+i+'-'+ii+'" value="" />\
								</div>\
								<div class="div-inp">\
									<lable>Name</lable>\
									<input type="text" name="input['+i+']['+ii+'][input_name]" id="input_name'+i+'-'+ii+'" value="" />\
								</div>\
								<div class="div-inp">\
									<lable>タイプ</lable>\
									<input type="radio" name="time_num_flag['+i+']['+ii+']" id="time_num_flag'+i+'-'+ii+'-0" value="0" onclick="func_time_num('+i+', '+ii+', 0)" checked /><label for="time_num_flag'+i+'-'+ii+'-0">通常の入力</label>\
									<input type="radio" name="time_num_flag['+i+']['+ii+']" id="time_num_flag'+i+'-'+ii+'-1" value="1" onclick="func_time_num('+i+', '+ii+', 1)" /><label for="time_num_flag'+i+'-'+ii+'-1">日時のセレクトボックス</label>\
									<div id="input-type'+i+'-'+ii+'" class="div-inp-inp">\
										<div class="div-time_num pl15" style="display:none;">\
											<select name="input['+i+']['+ii+'][input_time_num]" id="time_num_select'+i+'-'+ii+'" class="time-num">\
												<option value="12345">yyyy年mm月dd日hh時ii分</option>\
												<option value="123">yyyy年mm月dd日</option>\
												<option value="23">mm月dd日</option>\
												<option value="34">dd日hh時</option>\
												<option value="45">hh時ii分</option>\
											</select>\
											<br />\
											<small>yは西暦、mは月、dは日、hは時、iは分になります</small>\
											<div>\
												<label for="">デフォルトの値</label><input type="text" name="input['+i+']['+ii+'][input_time_num_default]" value="" class="default-value" placeholder="" />\
												<div class="val-msg"></div>\
											</div>\
										</div>\
										<div class="div-type pl15">\
											<select name="input['+i+']['+ii+'][input_type]" id="input_op'+i+'-'+ii+'" class="input_type_select">\
												<option value="0">テキスト</option>\
												<option value="1">テキストエリア</option>\
												<option value="2">チェックボックス</option>\
												<option value="3">ラジオボタン</option>\
												<option value="4">セレクトボックス</option>\
												<option value="5">パスワード</option>\
											</select>\
											<div class="select-checkbox" style="display:none;">\
												行ごとlabel,value,name,class<br />\
												<textarea name="input['+i+']['+ii+'][checkbox_options]"></textarea>\
											</div>\
											<div class="select-radio" style="display:none;">\
												行ごとlabel,value,name,class<br />\
												<textarea name="input['+i+']['+ii+'][radio_options]"><?php echo esc_textarea($value); ?></textarea>\
											</div>\
											<div class="select-selectbox" style="display:none;">\
												行ごとtext,value,class<br />\
												<textarea name="input['+i+']['+ii+'][select_options]"></textarea>\
											</div>\
											<div>\
												<label for="">デフォルトの値</label><input type="text" name="input['+i+']['+ii+'][input_value]" value="" class="default-value" placeholder="" />\
											</div>\
										</div>\
									</div>\
								</div>\
								<hr>\
						';
						//
						j('#form-input-ct'+i).val(ii);
						var input_add_area = j('#input-add-area'+i).html();
						j('#input-add-area'+i).html(input_add_area+add_html);

				}
				// フォーム追加
				function form_add(){

					form_ct = j('#form-ct').val();
					i = parseInt(form_ct);
					var add_html = '\
					<table>\
						<tr>\
							<th><label for="form-title<?php echo $i ?>">フォームタイトル</label></th>\
							<td><input type="text" name="form['+i+'][form_title]" value="" id="form-title'+i+'" /><input type="hidden" name="form['+i+'][form_id]" value="<?php echo $form_id; ?>" /></td>\
						</tr>\
						<tr>\
							<th><label for="form-label'+i+'">フォームラベル</label></th>\
							<td><input type="text" name="form['+i+'][form_label]" value="" id="form-label'+i+'" /></td>\
						</tr>\
						<tr>\
							<th><label for="form-desc_text'+i+'">フォームの説明文</label></th>\
							<td><textarea name="form['+i+'][form_desc_text]" id="form-desc_text'+i+'"></textarea></td>\
						</tr>\
						<tr>\
							<th><label for="form-class'+i+'">フォームclass</label></th>\
							<td><input type="text" name="form['+i+'][form_class]" value="" id="form-class'+i+'" /></td>\
						</tr>\
						<tr>\
							<th><label for="form-order'+i+'">昇順</label></th>\
							<td><input type="text" name="form['+i+'][order]" value="" id="form-order'+i+'" /></td>\
						</tr>\
						<tr>\
							<th>入力欄</th>\
							<td>\
								<div id="input-add-area'+i+'"></div>\
								<div>\
									<input type="button" value="入力を追加" class="js-button" onclick="input_add('+i+')" />\
								</div>\
							</td>\
						</tr>\
					</table>\
					<input type="hidden" name="form-input-ct'+i+'" id="form-input-ct'+i+'" value="0" />\
					<br />\
					';
					var form_html_area = j('#form-html').html();
					j('#form-html').html(form_html_area+add_html);
					j('#form-ct').val(i);
					input_add(i, 0);
					//
					j(".input_type_select").change(function () {
						var id_name = j(this).attr("id");
						inp_op = parseInt(j('#'+id_name).val());
						var inp_id = j(this).parent().parent().attr("id");
						sw_select_options_view(inp_op, inp_id);
					});
					//
					j(".time-num").change(function () {
						var id_name = j(this).attr("id");
						inp_op = j('#'+id_name).val();
						var inp_id = j(this).parent().parent().attr("id");
						sw_select_timenum_view(inp_op, inp_id);
					});

				}
				// 読み込み時の動作
				j(document).ready(function(){
					for(var i=0; i<<?php echo $form_ct; ?>; ++i){
						var inp_ct = j('#form-input-ct'+i).val();
						for(var ii=0; ii<inp_ct; ++ii){
							time_num = j("input:radio[name='time_num_flag\["+i+"\]\["+ii+"\]']:checked").val();
							if(time_num==1){
								func_time_num(i, ii, 1);
							}
							else{
								func_time_num(i, ii, 0);
							}
						}
					}
					// 削除チェックボックス解除
					j('.form-del-checkbox').prop('checked',false);
					j('.input-del-checkbox').prop('checked',false);
				});
				</script>
				<?php echo $error_jscript; ?>

			<?php
			}else{
				echo "<p>データは存在しません</p>";
			}
			?>
			</div>

<?php
}
?>