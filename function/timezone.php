<?php
//
function osnpTimezoneSet(){
	$timezone = osnpTimezoneGet(); // PHP側のデフォルト取得
	//
	if($option_data = get_option(OSNP_PLUGIN_OPTION_NAME)){
		// データがあれば
		if(isset($option_data['timezone'])){
			date_default_timezone_set($option_data['timezone']);
		}else{
			date_default_timezone_set($timezone);
		}
		unset($option_data);
	}else{
		date_default_timezone_set($timezone);
	}
}
// 設定されているタイムゾーンを取得 php.ini優先
function osnpTimezoneGet(){
	if(ini_get('date.timezone')){
		$timezone = ini_get('date.timezone');
	}else{
		if(date_default_timezone_get()){
			$timezone = date_default_timezone_get();
		}else{
			$timezone = 'UTC';
		}
	}
	return $timezone;
}