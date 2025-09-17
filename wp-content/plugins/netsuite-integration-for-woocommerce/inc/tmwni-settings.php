<?php


	//define( 'WC_ODOO_INTEGRATION_INIT_VERSION', $plugin_version );

class TMWNI_Settings {
	public static $VERSION = 1;
	public static $ns_inventory_log_file = 'netsuite-inventory-log.html';

	public static $ns_order_id = 'ns_order_internal_id';
	public static $ns_rec_type_order = 'order';
	public static $ns_customer_user_id = '_customer_user';
	public static $ns_external_order_id = 'ns_order_external_id';
	public static $ns_product_id = 'ns_product_internal_id';
	public static $ns_customer_id = 'ns_customer_internal_id';
	public static $ns_guest_customer_id = 'ns_guest_customer_internal_id';
	public static $ns_order_refund_internal_id = 'ns_order_refund_internal_id';

	public static $page_id = 'tmwni';
	public static $error_log_file_name = 'tmwni_errors.log';
	public static $ns_order_customer_id = 'ns_order_customer_id';
	public static $inventory_sku_lot_limit = 50;
	//define default tab
	public static $default_tab = 'dashboard';
	//customer
	public static $order_shipping_line_item_id = '2174';
	public static $pricing_group = 'Base Price';
	public static $customerDummyFisrtName = 'Woo';
	public static $customerDummyLastName = 'Customer';

	public static $netsuite_country = array(
		'AF' => '_afghanistan',
		'AX' => '_alandIslands',
		'AL' => '_albania',
		'DZ' => '_algeria',
//    '' => '_americanSamoa',
		'AD' => '_andorra',
		'AO' => '_angola',
		'AI' => '_anguilla',
		'AQ' => '_antarctica',
		'AG' => '_antiguaAndBarbuda',
		'AR' => '_argentina',
		'AM' => '_armenia',
		'AW' => '_aruba',
		'AU' => '_australia',
		'AT' => '_austria',
		'AZ' => '_azerbaijan',
		'BS' => '_bahamas',
		'BH' => '_bahrain',
		'BD' => '_bangladesh',
		'BB' => '_barbados',
		'BY' => '_belarus',
		'BE' => '_belgium',
		'BZ' => '_belize',
		'BJ' => '_benin',
		'BM' => '_bermuda',
		'BT' => '_bhutan',
		'BO' => '_bolivia',
		'BQ' => '_bonaireSaintEustatiusAndSaba',
		'BA' => '_bosniaAndHerzegovina',
		'BW' => '_botswana',
		'BV' => '_bouvetIsland',
		'BR' => '_brazil',
		'IO' => '_britishIndianOceanTerritory',
		'BN' => '_bruneiDarussalam',
		'BG' => '_bulgaria',
		'BF' => '_burkinaFaso',
		'BI' => '_burundi',
		'KH' => '_cambodia',
		'CM' => '_cameroon',
		'CA' => '_canada',
//    '' => '_canaryIslands',
		'CV' => '_capeVerde',
		'KY' => '_caymanIslands',
		'CF' => '_centralAfricanRepublic',
//    '' => '_ceutaAndMelilla',
		'TD' => '_chad',
		'CL' => '_chile',
		'CN' => '_china',
		'CX' => '_christmasIsland',
		'CC' => '_cocosKeelingIslands',
		'CO' => '_colombia',
		'KM' => '_comoros',
//    '' => '_congoDemocraticPeoplesRepublic',
//    '' => '_congoRepublicOf',
		'CK' => '_cookIslands',
		'CR' => '_costaRica',
//    '' => '_coteDIvoire',
		'HR' => '_croatiaHrvatska',
		'CU' => '_cuba',
		'CW' => '_curacao',
		'CY' => '_cyprus',
		'CZ' => '_czechRepublic',
		'DK' => '_denmark',
		'DJ' => '_djibouti',
		'DM' => '_dominica',
		'DO' => '_dominicanRepublic',
//    '' => '_eastTimor',
		'EC' => '_ecuador',
		'EG' => '_egypt',
		'SV' => '_elSalvador',
		'GQ' => '_equatorialGuinea',
		'ER' => '_eritrea',
		'EE' => '_estonia',
		'ET' => '_ethiopia',
		'FK' => '_falklandIslands',
		'FO' => '_faroeIslands',
		'FJ' => '_fiji',
		'FI' => '_finland',
		'FR' => '_france',
		'GF' => '_frenchGuiana',
		'PF' => '_frenchPolynesia',
		'TF' => '_frenchSouthernTerritories',
		'GA' => '_gabon',
		'GM' => '_gambia',
		'GE' => '_georgia',
		'DE' => '_germany',
		'GH' => '_ghana',
		'GI' => '_gibraltar',
		'GR' => '_greece',
		'GL' => '_greenland',
		'GD' => '_grenada',
		'GP' => '_guadeloupe',
        'GU' => '_guam',
		'GT' => '_guatemala',
		'GG' => '_guernsey',
		'GN' => '_guinea',
		'GW' => '_guineaBissau',
		'GY' => '_guyana',
		'HT' => '_haiti',
		'HM' => '_heardAndMcDonaldIslands',
//    '' => '_holySeeCityVaticanState',
		'HN' => '_honduras',
		'HK' => '_hongKong',
		'HU' => '_hungary',
		'IS' => '_iceland',
		'IN' => '_india',
		'ID' => '_indonesia',
		'IR' => '_iranIslamicRepublicOf',
		'IQ' => '_iraq',
		'IE' => '_ireland',
		'IM' => '_isleOfMan',
		'IL' => '_israel',
		'IT' => '_italy',
		'JM' => '_jamaica',
		'JP' => '_japan',
		'JE' => '_jersey',
		'JO' => '_jordan',
		'KZ' => '_kazakhstan',
		'KE' => '_kenya',
		'KI' => '_kiribati',
//    '' => '_koreaDemocraticPeoplesRepublic',
//    '' => '_koreaRepublicOf',
//    '' => '_kosovo',
		'KW' => '_kuwait',
		'KG' => '_kyrgyzstan',
		'LA' => '_laoPeoplesDemocraticRepublic',
		'LV' => '_latvia',
		'LB' => '_lebanon',
		'LS' => '_lesotho',
		'LR' => '_liberia',
		'LY' => '_libya',
		'LI' => '_liechtenstein',
		'LT' => '_lithuania',
		'LU' => '_luxembourg',
		'MO' => '_macau',
		'MK' => '_macedonia',
		'MG' => '_madagascar',
		'MW' => '_malawi',
		'MY' => '_malaysia',
		'MV' => '_maldives',
		'ML' => '_mali',
		'MT' => '_malta',
		'MH' => '_marshallIslands',
		'MQ' => '_martinique',
		'MR' => '_mauritania',
		'MU' => '_mauritius',
		'YT' => '_mayotte',
		'MX' => '_mexico',
		'FM' => '_micronesiaFederalStateOf',
		'MD' => '_moldovaRepublicOf',
		'MC' => '_monaco',
		'MN' => '_mongolia',
		'ME' => '_montenegro',
		'MS' => '_montserrat',
		'MA' => '_morocco',
		'MZ' => '_mozambique',
		'MM' => '_myanmar',
		'NA' => '_namibia',
		'NR' => '_nauru',
		'NP' => '_nepal',
		'NL' => '_netherlands',
		'NC' => '_newCaledonia',
		'NZ' => '_newZealand',
		'NI' => '_nicaragua',
		'NE' => '_niger',
		'NG' => '_nigeria',
		'NU' => '_niue',
		'NF' => '_norfolkIsland',
//    '' => '_northernMarianaIslands',
		'NO' => '_norway',
		'OM' => '_oman',
		'PK' => '_pakistan',
//    '' => '_palau',
		'PA' => '_panama',
		'PG' => '_papuaNewGuinea',
		'PY' => '_paraguay',
		'PE' => '_peru',
		'PH' => '_philippines',
		'PN' => '_pitcairnIsland',
		'PL' => '_poland',
		'PT' => '_portugal',
        'PR' => '_puertoRico',
		'QA' => '_qatar',
		'RE' => '_reunionIsland',
		'RO' => '_romania',
		'RU' => '_russianFederation',
		'RW' => '_rwanda',
		'BL' => '_saintBarthelemy',
		'SH' => '_saintHelena',
		'KN' => '_saintKittsAndNevis',
		'LC' => '_saintLucia',
		'MF' => '_saintMartin',
		'VC' => '_saintVincentAndTheGrenadines',
		'WS' => '_samoa',
		'SM' => '_sanMarino',
		'ST' => '_saoTomeAndPrincipe',
		'SA' => '_saudiArabia',
		'SN' => '_senegal',
		'RS' => '_serbia',
		'SC' => '_seychelles',
		'SL' => '_sierraLeone',
		'SG' => '_singapore',
//    '' => '_sintMaarten',
		'SK' => '_slovakRepublic',
		'SI' => '_slovenia',
		'SB' => '_solomonIslands',
		'SO' => '_somalia',
		'ZA' => '_southAfrica',
		'GS' => '_southGeorgia',
		'SS' => '_southSudan',
		'ES' => '_spain',
		'LK' => '_sriLanka',
//    '' => '_stateOfPalestine',
//    '' => '_stPierreAndMiquelon',
		'SD' => '_sudan',
		'SR' => '_suriname',
		'SJ' => '_svalbardAndJanMayenIslands',
		'SZ' => '_swaziland',
		'SE' => '_sweden',
		'CH' => '_switzerland',
		'SY' => '_syrianArabRepublic',
		'TW' => '_taiwan',
		'TJ' => '_tajikistan',
		'TZ' => '_tanzania',
		'TH' => '_thailand',
		'TG' => '_togo',
		'TK' => '_tokelau',
		'TO' => '_tonga',
		'TT' => '_trinidadAndTobago',
		'TN' => '_tunisia',
		'TR' => '_turkey',
		'TM' => '_turkmenistan',
		'TC' => '_turksAndCaicosIslands',
		'TV' => '_tuvalu',
		'UG' => '_uganda',
		'UA' => '_ukraine',
		'AE' => '_unitedArabEmirates',
		'GB' => '_unitedKingdom',
		'US' => '_unitedStates',
		'UY' => '_uruguay',
//    '' => '_uSMinorOutlyingIslands',
		'UZ' => '_uzbekistan',
		'VU' => '_vanuatu',
		'VE' => '_venezuela',
		'VN' => '_vietnam',
		'VG' => '_virginIslandsBritish',
        'VI' => '_virginIslandsUSA',
		'WF' => '_wallisAndFutunaIslands',
		'EH' => '_westernSahara',
		'YE' => '_yemen',
		'ZM' => '_zambia',
		'ZW' => '_zimbabwe'
	);
	//map tab ids to tab names
	public static $tabs = [
	'general_settings' => 'General Settings',
	'inventory_settings' => 'Inventory Settings',
	'customer_settings' => 'Customer Settings',
	'order_settings' => 'Order Settings',
	'logs' => 'NetSuite API Logs',
	'help' => 'Help & Support',
	'dashboard' => 'Dashboard',
	'import_export_settings' => 'Import/Export Settings'

];
	public static $inventory_sync_frequency = [
	'hourly' => 'Hourly',
	'twicedaily' => 'Twice a day',
	'daily' => 'Every day'
];
	public static $hma_method = [
	'HMAC-SHA1' => 'HMAC-SHA1',
	'HMAC-SHA256' => 'HMAC-SHA256',
];

	/**
	 * Get Tab Settings
	 *
	*/ 
	public static function getTabSettings( $tab_id = '', $sub_tab = '') {
		$settings = array();
		if ('' == $tab_id) {
			foreach (self::$tabs as $tab_id => $tab_heading) {
				$option_key = self::getTabOptionKey($tab_id);
				if ('Order Settings' == $tab_heading) {
					$order_fulfillment_settings = get_option('tmwni_order_settings_fulfillment_settings_options');
					$order_general_settings = get_option('tmwni_order_settings_general_settings_options');
					// pr($order_general_settings); die('zzzz');
					if (!empty($order_fulfillment_settings) && !empty($order_general_settings)) {
						$tab_option_data = array_merge($order_fulfillment_settings, $order_general_settings);
					} elseif (!empty($order_fulfillment_settings)) {
						$tab_option_data = $order_fulfillment_settings;

					} elseif (!empty($order_general_settings)) {
						$tab_option_data = $order_general_settings;
					} else {
						$tab_option_data = get_option($option_key);
					}
					
				
				} else {
					$tab_option_data = get_option($option_key);
					
				}

				if (!empty($tab_option_data)) {
						$settings = array_merge($settings, $tab_option_data);
				}
				
			}
		} else {
			$option_key = self::getTabOptionKey($tab_id, $sub_tab);
			$settings = get_option($option_key);
		}
		return $settings;
	}
	/**
	 * Get Tab
	 *
	*/ 
	public static function getTabOptionKey( $tab_id, $sub_tab = '') {
		if ('' != $sub_tab) {
			$sub_tab = '_' . $sub_tab;
		}
		return self::$page_id . '_' . $tab_id . $sub_tab . '_options';
	}
	/**
	 * Save Options
	 *
	*/ 
	public static function saveOption( $tab_id = '', $data) {
		if ('' == $tab_id) {
			$tab_id = self::$default_tab;
		}
		$option_key = self::getTabOptionKey($tab_id);
		update_option($option_key, $data, 'no');

	}

	//Check if required amazon creds are saved by admin
	public static function areCredentialsDefined() {
		global $TMWNI_OPTIONS;
		if (empty($TMWNI_OPTIONS['ns_consumer_key']) || empty($TMWNI_OPTIONS['ns_consumer_secret']) || empty($TMWNI_OPTIONS['ns_token_id']) || empty($TMWNI_OPTIONS['ns_token_secret']) || empty($TMWNI_OPTIONS['ns_account']) || empty($TMWNI_OPTIONS['ns_host'])) {
			return false;
		}
		return true;
	}







	/**
	 * Write Logs to DB
	 *
	*/ 
	public static function writeLogtoDB( $status, $object_id, $object, $error = '') {
		global $wpdb;
		$query_array = ['status' => $status, 'woo_object_id' => $object_id, 'operation' => $object];
		$query_array['notes'] = $error;
		$wpdb->insert($wpdb->prefix . 'tm_woo_netsuite_logs', $query_array);
		return false;
	}
	public static function shapeSpace_allowed_html() {
		$fields = wp_kses_allowed_html( 'post' );
		$allowed_atts = array(
			'align'      => array(),
			'class'      => array(),
			'type'       => array(),
			'id'         => array(),
			'dir'        => array(),
			'lang'       => array(),
			'style'      => array(),
			'xml:lang'   => array(),
			'src'        => array(),
			'alt'        => array(),
			'href'       => array(),
			'rel'        => array(),
			'rev'        => array(),
			'target'     => array(),
			'novalidate' => array(),
			'type'       => array(),
			'value'      => array(),
			'name'       => array(),
			'tabindex'   => array(),
			'action'     => array(),
			'method'     => array(),
			'for'        => array(),
			'width'      => array(),
			'height'     => array(),
			'data'       => array(),
			'title'      => array(),
			'checked'=>true,
			'select'=>array(),
			'option'=>array(),
			'selected'=>array(),
			'multiple'=>array(),
		);
		$fields['form'] = array('action'         => true,
			'accept'         => true,
			'accept-charset' => true,
			'enctype'        => true,
			'method'         => array(),
			'name'           => true,
			'target'         => true,
			'class'         => true);
		$fields['input'] = $allowed_atts;
		$fields['select'] = $allowed_atts;
		$fields['option'] = $allowed_atts;


		$fields['script']   = $allowed_atts;
		$fields['style']    = $allowed_atts;



		return $fields;		


	}


}
