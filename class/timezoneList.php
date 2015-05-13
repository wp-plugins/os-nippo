<?php
// タイムゾーンのcalss
class osnpTimezoneClass {

	public function zonelist(){

		$list = array(
			'アジア'=>array(
				'Asia/Hebron'=>'Hebron',
				'Asia/Kathmandu'=>'Kathmandu',
				'Asia/Khandyga'=>'Khandyga',
				'Asia/Novokuznetsk'=>'Novokuznetsk',
				'Asia/Ust-Nera'=>'Ust-Nera',
				'Asia/Aqtau'=>'アクタウ',
				'Asia/Aqtobe'=>'アクトベ',
				'Asia/Ashgabat'=>'アシガバート',
				'Asia/Aden'=>'アデン',
				'Asia/Anadyr'=>'アナディリ',
				'Asia/Almaty'=>'アルマトイ',
				'Asia/Amman'=>'アンマン',
				'Asia/Irkutsk'=>'イルクーツク',
				'Asia/Vladivostok'=>'ウラジオストク',
				'Asia/Ulaanbaatar'=>'ウランバートル',
				'Asia/Urumqi'=>'ウルムチ',
				'Asia/Yekaterinburg'=>'エカテリンブルク',
				'Asia/Jerusalem'=>'エルサレム',
				'Asia/Yerevan'=>'エレバン',
				'Asia/Omsk'=>'オムスク',
				'Asia/Oral'=>'オラル',
				'Asia/Kashgar'=>'カシュガル',
				'Asia/Qatar'=>'カタール',
				'Asia/Kabul'=>'カブール',
				'Asia/Kamchatka'=>'カムチャッカ',
				'Asia/Karachi'=>'カラチ',
				'Asia/Gaza'=>'ガザ',
				'Asia/Kuala_Lumpur'=>'クアラルンプール',
				'Asia/Kuwait'=>'クウェート',
				'Asia/Qyzylorda'=>'クズロルダ',
				'Asia/Kuching'=>'クチン',
				'Asia/Krasnoyarsk'=>'クラスノヤルスク',
				'Asia/Kolkata'=>'コルカタ',
				'Asia/Colombo'=>'コロンボ',
				'Asia/Sakhalin'=>'サハリン',
				'Asia/Samarkand'=>'サマルカンド',
				'Asia/Singapore'=>'シンガポール',
				'Asia/Jakarta'=>'ジャカルタ',
				'Asia/Jayapura'=>'ジャヤプラ',
				'Asia/Seoul'=>'ソウル',
				'Asia/Tashkent'=>'タシュケント',
				'Asia/Dhaka'=>'ダッカ',
				'Asia/Damascus'=>'ダマスカス',
				'Asia/Choibalsan'=>'チョイバルサン',
				'Asia/Thimphu'=>'ティンプー',
				'Asia/Tehran'=>'テヘラン',
				'Asia/Dili'=>'ディリ',
				'Asia/Tbilisi'=>'トビリシ',
				'Asia/Dushanbe'=>'ドゥシャンベ',
				'Asia/Dubai'=>'ドバイ',
				'Asia/Nicosia'=>'ニコジーア',
				'Asia/Novosibirsk'=>'ノヴォシビルスク',
				'Asia/Harbin'=>'ハルビン',
				'Asia/Baku'=>'バクー',
				'Asia/Baghdad'=>'バグダード',
				'Asia/Bangkok'=>'バンコク',
				'Asia/Bahrain'=>'バーレーン',
				'Asia/Bishkek'=>'ビシュケク',
				'Asia/Brunei'=>'ブルネイ',
				'Asia/Phnom_Penh'=>'プノンペン',
				'Asia/Beirut'=>'ベイルート',
				'Asia/Hovd'=>'ホブド',
				'Asia/Ho_Chi_Minh'=>'ホーチミン',
				'Asia/Pontianak'=>'ポンティアナック',
				'Asia/Macau'=>'マカオ',
				'Asia/Makassar'=>'マカッサル',
				'Asia/Magadan'=>'マガダン',
				'Asia/Muscat'=>'マスカット',
				'Asia/Manila'=>'マニラ',
				'Asia/Yakutsk'=>'ヤクーツク',
				'Asia/Rangoon'=>'ヤンゴン',
				'Asia/Riyadh'=>'リヤド',
				'Asia/Vientiane'=>'ヴィエンチャン',
				'Asia/Shanghai'=>'上海',
				'Asia/Taipei'=>'台北',
				'Asia/Pyongyang'=>'平壌',
				'Asia/Tokyo'=>'東京',
				'Asia/Chongqing'=>'重慶',
				'Asia/Hong_Kong'=>'香港',
			),
			'アフリカ'=>array(
				'Africa/Juba'=>'Juba',
				'Africa/El_Aaiun'=>'アイウン',
				'Africa/Accra'=>'アクラ',
				'Africa/Asmara'=>'アスマラ',
				'Africa/Addis_Ababa'=>'アディスアベバ',
				'Africa/Abidjan'=>'アビジャン',
				'Africa/Algiers'=>'アルジェー',
				'Africa/Windhoek'=>'ウィントフック',
				'Africa/Cairo'=>'カイロ',
				'Africa/Casablanca'=>'カサブランカ',
				'Africa/Kampala'=>'カンパラ',
				'Africa/Kigali'=>'キガリ',
				'Africa/Kinshasa'=>'キンシャサ',
				'Africa/Conakry'=>'コナクリ',
				'Africa/Sao_Tome'=>'サントメ',
				'Africa/Djibouti'=>'ジブチ',
				'Africa/Ceuta'=>'セウタ',
				'Africa/Dakar'=>'ダカール',
				'Africa/Dar_es_Salaam'=>'ダルエスサラーム',
				'Africa/Tunis'=>'チュニス',
				'Africa/Tripoli'=>'トリポリ',
				'Africa/Douala'=>'ドゥアラ',
				'Africa/Nairobi'=>'ナイロビ',
				'Africa/Niamey'=>'ニアメ',
				'Africa/Nouakchott'=>'ヌアクショット',
				'Africa/Gaborone'=>'ハボローネ',
				'Africa/Harare'=>'ハラレ',
				'Africa/Khartoum'=>'ハルツーム',
				'Africa/Bamako'=>'バマコ',
				'Africa/Bangui'=>'バンギ',
				'Africa/Banjul'=>'バンジュール',
				'Africa/Bissau'=>'ビサウ',
				'Africa/Freetown'=>'フリータウン',
				'Africa/Bujumbura'=>'ブジュンブラ',
				'Africa/Brazzaville'=>'ブラザヴィル',
				'Africa/Blantyre'=>'ブランタイヤ',
				'Africa/Porto-Novo'=>'ポルトノボ',
				'Africa/Maseru'=>'マセル',
				'Africa/Maputo'=>'マプト',
				'Africa/Malabo'=>'マラボ',
				'Africa/Mbabane'=>'ムババーネ',
				'Africa/Mogadishu'=>'モガディシュ',
				'Africa/Monrovia'=>'モンロビア',
				'Africa/Johannesburg'=>'ヨハネスブルク',
				'Africa/Lagos'=>'ラゴス',
				'Africa/Libreville'=>'リーブルビル',
				'Africa/Lusaka'=>'ルサカ',
				'Africa/Lubumbashi'=>'ルブンバシ',
				'Africa/Luanda'=>'ルワンダ',
				'Africa/Lome'=>'ロメ',
				'Africa/Ouagadougou'=>'ワガドゥグー',
				'Africa/Ndjamena'=>'ンジャメナ',
			),
			'アメリカ大陸'=>array(
				'America/Bahia_Banderas'=>'Bahia Banderas',
				'America/Creston'=>'Creston',
				'America/Kralendijk'=>'Kralendijk',
				'America/Lower_Princes'=>'Lower Princes',
				'America/Matamoros'=>'Matamoros',
				'America/Metlakatla'=>'Metlakatla',
				'America/Ojinaga'=>'Ojinaga',
				'America/Santa_Isabel'=>'Santa Isabel',
				'America/Santarem'=>'Santarem',
				'America/Sitka'=>'Sitka',
				'America/Asuncion'=>'アスンシオン',
				'America/Adak'=>'アダック',
				'America/Atikokan'=>'アティコカン',
				'America/Araguaina'=>'アラグアイナ',
				'America/Argentina/Salta'=>'アルゼンチン - Salta',
				'America/Argentina/Ushuaia'=>'アルゼンチン - ウスアイア',
				'America/Argentina/Catamarca'=>'アルゼンチン - カタマルカ',
				'America/Argentina/Cordoba'=>'アルゼンチン - コルドバ',
				'America/Argentina/San_Juan'=>'アルゼンチン - サンフアン',
				'America/Argentina/San_Luis'=>'アルゼンチン - サンルイス',
				'America/Argentina/Tucuman'=>'アルゼンチン - トゥクマン',
				'America/Argentina/Jujuy'=>'アルゼンチン - フフイ',
				'America/Argentina/Buenos_Aires'=>'アルゼンチン - ブエノスアイレス',
				'America/Argentina/Mendoza'=>'アルゼンチン - メンドーサ',
				'America/Argentina/La_Rioja'=>'アルゼンチン - ラ・リオハ',
				'America/Argentina/Rio_Gallegos'=>'アルゼンチン - リオガジェゴス',
				'America/Aruba'=>'アルバ',
				'America/Anchorage'=>'アンカレッジ',
				'America/Anguilla'=>'アンギラ',
				'America/Antigua'=>'アンティグア',
				'America/Yellowknife'=>'イエローナイフ',
				'America/Iqaluit'=>'イカルイト',
				'America/Inuvik'=>'イヌヴィック',
				'America/Indiana/Indianapolis'=>'インディアナ - インディアナポリス',
				'America/Indiana/Winamac'=>'インディアナ - ウィナマク',
				'America/Indiana/Tell_City'=>'インディアナ - テル・シティ',
				'America/Indiana/Knox'=>'インディアナ - ノックス',
				'America/Indiana/Petersburg'=>'インディアナ - ピーターズバーグ',
				'America/Indiana/Vevay'=>'インディアナ - ベベイ',
				'America/Indiana/Marengo'=>'インディアナ - マレンゴ',
				'America/Indiana/Vincennes'=>'インディアナ - ヴァンセンヌ',
				'America/Winnipeg'=>'ウィニペグ',
				'America/Eirunepe'=>'エイルネペ',
				'America/Edmonton'=>'エドモントン',
				'America/El_Salvador'=>'エルサルバドル',
				'America/Hermosillo'=>'エルモシージョ',
				'America/Cayenne'=>'カイエンヌ',
				'America/Caracas'=>'カラカス',
				'America/Cancun'=>'カンクン',
				'America/Campo_Grande'=>'カンポ・グランデ',
				'America/Guyana'=>'ガイアナ',
				'America/Curacao'=>'キュラソー',
				'America/Cuiaba'=>'クイアバ',
				'America/Guatemala'=>'グアテマラ',
				'America/Guadeloupe'=>'グアドループ',
				'America/Guayaquil'=>'グアヤキル',
				'America/Grand_Turk'=>'グランドターク',
				'America/Grenada'=>'グレナダ',
				'America/Glace_Bay'=>'グレースベイ',
				'America/Goose_Bay'=>'グースベイ',
				'America/Cayman'=>'ケイマン諸島',
				'America/Kentucky/Monticello'=>'ケンタッキー - モンティチェロ',
				'America/Kentucky/Louisville'=>'ケンタッキー - ルイビル',
				'America/Cambridge_Bay'=>'ケンブリッジベイ',
				'America/Costa_Rica'=>'コスタリカ',
				'America/Thunder_Bay'=>'サンダーベイ',
				'America/Santiago'=>'サンティアゴ',
				'America/Santo_Domingo'=>'サントドミンゴ',
				'America/Sao_Paulo'=>'サンパウロ',
				'America/St_Barthelemy'=>'サン・バルテルミー',
				'America/Chicago'=>'シカゴ',
				'America/Shiprock'=>'シップロック',
				'America/Jamaica'=>'ジャマイカ',
				'America/Juneau'=>'ジュノー',
				'America/Swift_Current'=>'スウィフトカレント',
				'America/Scoresbysund'=>'スコルズビスーン',
				'America/St_Kitts'=>'セントクリストファー・ネイビス',
				'America/St_Johns'=>'セントジョーンズ',
				'America/St_Thomas'=>'セントトーマス',
				'America/St_Vincent'=>'セントビンセント',
				'America/St_Lucia'=>'セントルシア',
				'America/Danmarkshavn'=>'ダンマークシャウン',
				'America/Thule'=>'チューレ',
				'America/Chihuahua'=>'チワワ',
				'America/Tijuana'=>'ティフアナ',
				'America/Tegucigalpa'=>'テグシガルパ',
				'America/Detroit'=>'デトロイト',
				'America/Denver'=>'デンバー',
				'America/Tortola'=>'トルトラ',
				'America/Toronto'=>'トロント',
				'America/Dominica'=>'ドミニカ',
				'America/Dawson'=>'ドーソン',
				'America/Dawson_Creek'=>'ドーソン・クリーク',
				'America/Nassau'=>'ナッソー',
				'America/Nipigon'=>'ニピゴン',
				'America/New_York'=>'ニューヨーク',
				'America/Godthab'=>'ヌーク (ゴットホープ)',
				'America/North_Dakota/Beulah'=>'ノースダコタ - Beulah',
				'America/North_Dakota/Center'=>'ノースダコタ - センター',
				'America/North_Dakota/New_Salem'=>'ノースダコタ - ニューセーラム',
				'America/Nome'=>'ノーム',
				'America/Havana'=>'ハバナ',
				'America/Halifax'=>'ハリファックス',
				'America/Bahia'=>'バイーア',
				'America/Barbados'=>'バルバドス',
				'America/Vancouver'=>'バンクーバー',
				'America/Panama'=>'パナマ',
				'America/Paramaribo'=>'パラマリボ',
				'America/Pangnirtung'=>'パンニルトゥング',
				'America/Phoenix'=>'フェニックス',
				'America/Fortaleza'=>'フォルタレザ',
				'America/Blanc-Sablon'=>'ブラン・サブロン',
				'America/Puerto_Rico'=>'プエルトリコ',
				'America/Belize'=>'ベリーズ',
				'America/Belem'=>'ベレン',
				'America/Whitehorse'=>'ホワイトホース',
				'America/Boa_Vista'=>'ボア・ヴィスタ',
				'America/Boise'=>'ボイシ',
				'America/Bogota'=>'ボゴタ',
				'America/Porto_Velho'=>'ポルトベーリョ',
				'America/Port-au-Prince'=>'ポルトープランス',
				'America/Port_of_Spain'=>'ポートオブスペイン',
				'America/Mazatlan'=>'マサトラン',
				'America/Maceio'=>'マセイオ',
				'America/Manaus'=>'マナウス',
				'America/Managua'=>'マナグア',
				'America/Marigot'=>'マリゴ',
				'America/Martinique'=>'マルティニーク',
				'America/Miquelon'=>'ミクロン',
				'America/Mexico_City'=>'メキシコシティ',
				'America/Menominee'=>'メノミニー',
				'America/Merida'=>'メリダ',
				'America/Moncton'=>'モンクトン',
				'America/Montevideo'=>'モンテビデオ',
				'America/Monterrey'=>'モンテレー',
				'America/Montserrat'=>'モントセラート',
				'America/Montreal'=>'モントリオール',
				'America/Yakutat'=>'ヤクタト',
				'America/La_Paz'=>'ラパス',
				'America/Rankin_Inlet'=>'ランキンインレット',
				'America/Rio_Branco'=>'リオ・ブランコ',
				'America/Lima'=>'リマ',
				'America/Rainy_River'=>'レイニーリバー',
				'America/Recife'=>'レシフェ',
				'America/Regina'=>'レジャイナ',
				'America/Resolute'=>'レゾリュート',
				'America/Los_Angeles'=>'ロサンゼルス',
				'America/Noronha'=>'ローニャ',
			),
			'インド'=>array(
				'Indian/Antananarivo'=>'アンタナナリボ',
				'Indian/Christmas'=>'クリスマス島',
				'Indian/Kerguelen'=>'ケルゲレン諸島',
				'Indian/Cocos'=>'ココス諸島',
				'Indian/Comoro'=>'コモロ',
				'Indian/Chagos'=>'チャゴス諸島',
				'Indian/Mahe'=>'マヘ',
				'Indian/Mayotte'=>'マヨット',
				'Indian/Maldives'=>'モルディブ',
				'Indian/Mauritius'=>'モーリシャス',
				'Indian/Reunion'=>'レユニオン',
			),
			'オーストラリア'=>array(
				'Australia/Adelaide'=>'アデレード',
				'Australia/Currie'=>'カリー',
				'Australia/Sydney'=>'シドニー',
				'Australia/Darwin'=>'ダーウィン',
				'Australia/Perth'=>'パース',
				'Australia/Brisbane'=>'ブリスベン',
				'Australia/Broken_Hill'=>'ブロークンヒル',
				'Australia/Hobart'=>'ホバート',
				'Australia/Melbourne'=>'メルボルン',
				'Australia/Eucla'=>'ユークラ',
				'Australia/Lindeman'=>'リンデマン',
				'Australia/Lord_Howe'=>'ロードハウ島',
			),
			'ヨーロッパ'=>array(
				'Europe/Busingen'=>'Busingen',
				'Europe/Athens'=>'アテネ',
				'Europe/Amsterdam'=>'アムステルダム',
				'Europe/Andorra'=>'アンドラ',
				'Europe/Istanbul'=>'イスタンブル',
				'Europe/Vienna'=>'ウィーン',
				'Europe/Uzhgorod'=>'ウージュホロド',
				'Europe/Oslo'=>'オスロ',
				'Europe/Kaliningrad'=>'カリーニングラード',
				'Europe/Guernsey'=>'ガーンジー',
				'Europe/Kiev'=>'キエフ',
				'Europe/Chisinau'=>'キシナウ',
				'Europe/Copenhagen'=>'コペンハーゲン',
				'Europe/Samara'=>'サマラ',
				'Europe/Sarajevo'=>'サラエヴォ',
				'Europe/San_Marino'=>'サンマリノ',
				'Europe/Zagreb'=>'ザグレブ',
				'Europe/Zaporozhye'=>'ザポロージェ',
				'Europe/Simferopol'=>'シンフェロポリ',
				'Europe/Gibraltar'=>'ジブラルタル',
				'Europe/Jersey'=>'ジャージー島',
				'Europe/Skopje'=>'スコピエ',
				'Europe/Stockholm'=>'ストックホルム',
				'Europe/Sofia'=>'ソフィア',
				'Europe/Tallinn'=>'タリン',
				'Europe/Dublin'=>'ダブリン',
				'Europe/Zurich'=>'チューリッヒ',
				'Europe/Tirane'=>'ティラナ',
				'Europe/Vatican'=>'バチカン',
				'Europe/Paris'=>'パリ',
				'Europe/Vilnius'=>'ビリニュス',
				'Europe/Vaduz'=>'ファドゥーツ',
				'Europe/Bucharest'=>'ブカレスト',
				'Europe/Budapest'=>'ブダペスト',
				'Europe/Bratislava'=>'ブラチスラヴァ',
				'Europe/Brussels'=>'ブリュッセル',
				'Europe/Prague'=>'プラハ',
				'Europe/Helsinki'=>'ヘルシンキ',
				'Europe/Belgrade'=>'ベオグラード',
				'Europe/Berlin'=>'ベルリン',
				'Europe/Podgorica'=>'ポドゴリツァ',
				'Europe/Madrid'=>'マドリード',
				'Europe/Mariehamn'=>'マリエハムン',
				'Europe/Malta'=>'マルタ',
				'Europe/Isle_of_Man'=>'マン島',
				'Europe/Minsk'=>'ミンスク',
				'Europe/Moscow'=>'モスクワ',
				'Europe/Monaco'=>'モナコ',
				'Europe/Riga'=>'リガ',
				'Europe/Lisbon'=>'リスボン',
				'Europe/Ljubljana'=>'リュブリャナ',
				'Europe/Luxembourg'=>'ルクセンブルク',
				'Europe/London'=>'ロンドン',
				'Europe/Rome'=>'ローマ',
				'Europe/Warsaw'=>'ワルシャワ',
				'Europe/Volgograd'=>'ヴォルゴグラード',
			),
			'北極'=>array(
				'Arctic/Longyearbyen'=>'ロングイェールビーン',
			),
			'南極'=>array(
				'Antarctica/Macquarie'=>'Macquarie',
				'Antarctica/Casey'=>'ケーシー',
				'Antarctica/Davis'=>'デイビス',
				'Antarctica/DumontDUrville'=>'デュモンデュルビル',
				'Antarctica/Palmer'=>'パーマー',
				'Antarctica/Vostok'=>'ボストーク',
				'Antarctica/McMurdo'=>'マクマード',
				'Antarctica/Mawson'=>'モーソン',
				'Antarctica/Rothera'=>'ロゼラ',
				'Antarctica/South_Pole'=>'南極点',
				'Antarctica/Syowa'=>'昭和基地',
			),
			'大西洋'=>array(
				'Atlantic/Azores'=>'アゾレス諸島',
				'Atlantic/Canary'=>'カナリア諸島',
				'Atlantic/Cape_Verde'=>'カーボベルデ',
				'Atlantic/South_Georgia'=>'サウスジョージア',
				'Atlantic/Stanley'=>'スタンレー',
				'Atlantic/St_Helena'=>'セントヘレナ',
				'Atlantic/Bermuda'=>'バミューダ島',
				'Atlantic/Faroe'=>'フェロー諸島',
				'Atlantic/Madeira'=>'マデイラ諸島',
				'Atlantic/Reykjavik'=>'レイキャビク',
			),
			'太平洋'=>array(
				'Pacific/Chuuk'=>'Chuuk',
				'Pacific/Pohnpei'=>'Pohnpei',
				'Pacific/Apia'=>'アピア',
				'Pacific/Easter'=>'イースター島',
				'Pacific/Wake'=>'ウェーク島',
				'Pacific/Efate'=>'エファテ島',
				'Pacific/Enderbury'=>'エンダーベリー',
				'Pacific/Auckland'=>'オークランド',
				'Pacific/Guadalcanal'=>'ガタルカナル島',
				'Pacific/Galapagos'=>'ガラパゴス諸島',
				'Pacific/Gambier'=>'ガンビア',
				'Pacific/Kiritimati'=>'キリスィマスィ',
				'Pacific/Kwajalein'=>'クェゼリン',
				'Pacific/Guam'=>'グアム',
				'Pacific/Kosrae'=>'コスラエ',
				'Pacific/Saipan'=>'サイパン',
				'Pacific/Johnston'=>'ジョンストン島',
				'Pacific/Tahiti'=>'タヒチ',
				'Pacific/Tarawa'=>'タラワ',
				'Pacific/Chatham'=>'チャタム',
				'Pacific/Tongatapu'=>'トンガタプ',
				'Pacific/Nauru'=>'ナウル',
				'Pacific/Niue'=>'ニウエ',
				'Pacific/Noumea'=>'ヌメア',
				'Pacific/Norfolk'=>'ノーフォーク',
				'Pacific/Pago_Pago'=>'パゴパゴ',
				'Pacific/Palau'=>'パラウ',
				'Pacific/Pitcairn'=>'ピトケアン諸島',
				'Pacific/Fakaofo'=>'ファカオフォ',
				'Pacific/Fiji'=>'フィジー',
				'Pacific/Funafuti'=>'フナフティ',
				'Pacific/Honolulu'=>'ホノルル',
				'Pacific/Port_Moresby'=>'ポートモレスビー',
				'Pacific/Majuro'=>'マジュロ',
				'Pacific/Marquesas'=>'マルキーズ諸島',
				'Pacific/Midway'=>'ミッドウェー諸島',
				'Pacific/Rarotonga'=>'ラロトンガ',
				'Pacific/Wallis'=>'ヴァレー',
			),
			'UTC'=>array(
				'UTC'=>'UTC',
			),
			'マニュアルオフセット'=>array(
				'UTC-12'=>'UTC-12',
				'UTC-11.5'=>'UTC-11:30',
				'UTC-11'=>'UTC-11',
				'UTC-10.5'=>'UTC-10:30',
				'UTC-10'=>'UTC-10',
				'UTC-9.5'=>'UTC-9:30',
				'UTC-9'=>'UTC-9',
				'UTC-8.5'=>'UTC-8:30',
				'UTC-8'=>'UTC-8',
				'UTC-7.5'=>'UTC-7:30',
				'UTC-7'=>'UTC-7',
				'UTC-6.5'=>'UTC-6:30',
				'UTC-6'=>'UTC-6',
				'UTC-5.5'=>'UTC-5:30',
				'UTC-5'=>'UTC-5',
				'UTC-4.5'=>'UTC-4:30',
				'UTC-4'=>'UTC-4',
				'UTC-3.5'=>'UTC-3:30',
				'UTC-3'=>'UTC-3',
				'UTC-2.5'=>'UTC-2:30',
				'UTC-2'=>'UTC-2',
				'UTC-1.5'=>'UTC-1:30',
				'UTC-1'=>'UTC-1',
				'UTC-0.5'=>'UTC-0:30',
				'UTC+0'=>'UTC+0',
				'UTC+0.5'=>'UTC+0:30',
				'UTC+1'=>'UTC+1',
				'UTC+1.5'=>'UTC+1:30',
				'UTC+2'=>'UTC+2',
				'UTC+2.5'=>'UTC+2:30',
				'UTC+3'=>'UTC+3',
				'UTC+3.5'=>'UTC+3:30',
				'UTC+4'=>'UTC+4',
				'UTC+4.5'=>'UTC+4:30',
				'UTC+5'=>'UTC+5',
				'UTC+5.5'=>'UTC+5:30',
				'UTC+5.75'=>'UTC+5:45',
				'UTC+6'=>'UTC+6',
				'UTC+6.5'=>'UTC+6:30',
				'UTC+7'=>'UTC+7',
				'UTC+7.5'=>'UTC+7:30',
				'UTC+8'=>'UTC+8',
				'UTC+8.5'=>'UTC+8:30',
				'UTC+8.75'=>'UTC+8:45',
				'UTC+9'=>'UTC+9',
				'UTC+9.5'=>'UTC+9:30',
				'UTC+10'=>'UTC+10',
				'UTC+10.5'=>'UTC+10:30',
				'UTC+11'=>'UTC+11',
				'UTC+11.5'=>'UTC+11:30',
				'UTC+12'=>'UTC+12',
				'UTC+12.75'=>'UTC+12:45',
				'UTC+13'=>'UTC+13',
				'UTC+13.75'=>'UTC+13:45',
				'UTC+14'=>'UTC+14',
			),
		);

		return $list;

	}

}
?>