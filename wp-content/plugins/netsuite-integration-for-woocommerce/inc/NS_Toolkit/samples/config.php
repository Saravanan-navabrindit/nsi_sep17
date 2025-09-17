<?php
$TMWNI_OPTIONS = TMWNI_Settings::getTabSettings();

ini_set('default_socket_timeout', 600);
define('NS_ENDPOINT', '2020_2');
define('NS_HOST', isset($TMWNI_OPTIONS['ns_host']) ? rtrim($TMWNI_OPTIONS['ns_host'], '/\\') : '');
define('NS_ACCOUNT', isset($TMWNI_OPTIONS['ns_account']) ? trim($TMWNI_OPTIONS['ns_account']) : '');
define('NS_APPID', isset($TMWNI_OPTIONS['ns_app_id']) ? trim($TMWNI_OPTIONS['ns_app_id']) : '');
define('NS_TOKEN_ID', isset($TMWNI_OPTIONS['ns_token_id']) ? trim($TMWNI_OPTIONS['ns_token_id']) : '');
define('NS_TOKEN_SECRET', isset($TMWNI_OPTIONS['ns_token_secret']) ? trim($TMWNI_OPTIONS['ns_token_secret']) : '');
define('NS_CONSUMER_KEY', isset($TMWNI_OPTIONS['ns_consumer_key']) ? trim($TMWNI_OPTIONS['ns_consumer_key']) : '');
define('NS_CONSUMER_SECRET', isset($TMWNI_OPTIONS['ns_consumer_secret']) ? trim($TMWNI_OPTIONS['ns_consumer_secret']) : '');

if (isset($TMWNI_OPTIONS['hma_algorithm_method'])) {
define('NS_HMAC_ALGORITHM', 'HMAC-SHA1' ==$TMWNI_OPTIONS['hma_algorithm_method'] ? 'HMAC-SHA1' : 'HMAC-SHA256');
define('NS_HMAC_METHOD', 'HMAC-SHA1' ==$TMWNI_OPTIONS['hma_algorithm_method'] ? 'sha1' : 'sha256');
} else {
define('NS_HMAC_ALGORITHM', '');
define('NS_HMAC_METHOD', '');	
}


