=== HTTP Requests Manager ===
Contributors: veppa
Donate link: https://www.paypal.com/donate/?hosted_button_id=LZ4LP4MQJDH7Y
Tags: wp_http, log, debug, optimization, limit
Requires at least: 4.7
Tested up to: 6.8
Stable tag: 1.3.8
License: GPLv2

Limit, Debug, Optimize WP_HTTP requests. Limit by request count, page load time, reduce timeout for each request. Speed up login and admin pages.

== Description ==

= Prevent WP HTTP requests from slowing down your WordPress website and admin interface =

Do you have a slow WordPress admin that takes longer than usual to load? Sometime longer than 5 seconds to load admin or login pages. In rare occasions WordPress may even timeout and show 504 page. 

Reason may be slow external WP_HTTP requests. [HTTP Requests Manager plugin](https://veppa.com/http-requests-manager/) will log all WP HTTP requests with time taken to complete for each request. If there are multiple requests per page they will be color grouped. 

https://youtu.be/l_fvAnKPJkM

[Check plugin overview on YouTube](https://youtu.be/l_fvAnKPJkM) | [Watch plugin tutorials](https://youtube.com/playlist?list=PLvn-qBzU0II7b5D4OYDnKpNpuvxiM0f4b)


Plugin tested with PHP version 5.6, 7.x and up to 8.4.

= Do not confuse WP_HTTP request with HTML requests that loads page assets like js, css, image, font =

Plugin only detects and manages requests made using WP_Http class. Which is default method used and advised by WordPress for getting remote data and updates. 

Plugin will not detect any requests made by other WordPress classes like WP_Http_Curl or PHP functions like curl_exec, fsockopen, file_get_contents etc. 

Do not confuse it with HTML requests (loading assets like css, js, image) done by HTML page. WP_Http requests are performed only inside PHP files and not visible in web browser. 

[Learn more about difference between WP_HTTP requests and HTML requests](https://veppa.com/http-requests-manager/#what_is_detected_with_http_requests_manager)

= How plugin prevents slow pages containing WP_HTTP requests? = 

Plugin helps to prevent website slowdown by: 

* Sets request timeout period to 2 second. Where default is 5. 
* Limit number of request per page by 3. Default is unlimited.
* Limit WP HTTP request if page load time is longer than 3 seconds. Default is unlimited.
* Option to block all external requests or allow only requests to wordpress.org for plugin, theme and core updates.


= Operation mode =

Plugin has following operation modes in setting to manage WP HTTP requests. Here is what each mode does:

- **Only log HTTP requests** — logs all non cron requests. No blocking done.
- **Only log HTTP requests (+ cron requests)** — logs all requests including cron. No blocking done.
- **Smart block** — logs non cron HTTP requests and blocks request using following rules.
	1. Page processing time exceeded 3 seconds.
	2. Number of request for single page reached 3.
	3. Sets timeout for each request to 2 second.
	4. Sets number of redirects for request to 1.
	5. Apply custom rules for "Smart block" defined in settings. 
	6. Prevent some built in requests: happy browser, maybe update, self pings, do_enclose.
	7. Skip some limitations listed above for: file downloads (plugin, theme, other), requests inside cron jobs.
- **Block external requests** — all requests not matching your current domain will be blocked. No updates for WordPress core, plugins and themes. (+ Smart block features.)
- **Block external requests (allow WordPress.org only)** — all requests not matching your current domain and wordpress.org will be blocked. Allows updates for WordPress core, plugins and themes coming from wordpress.org website. (+ Smart block features.)

**Custom rules** only work in "Smart block" mode. It will not work in "Block external requests" or "Block external requests (allow WordPress.org only)" mode.

= Disable logging =

After using plugin for some time and knowing which requests are performed you can disable logging. Operation mode will remain unchanged. Request blocking will remain in tact. No new logs will be recorded. You can analyze old logs, they will not be deleted.

= Load before other plugins  =

In order to catch more requests you can enable "Load before other plugins" option. It uses Must-Use plugin feature and load before other regular plugins. This way you will make sure to detect all WP_HTTP requests by other plugins.

= Custom rules for "Smart Block" mode =

Allow or block some requests based on domain, plugin or all. Choose on which page type rule will be applied. For example you can block requests in frontend while allowing in other pages.

Finally you can define action as block or allow for custom rule. For example you can make sure that some plugin will always be allowed to send WP_HTTP request. This can be SEO or mail plugin that uses remote API for functioning. 

= Features =

* View performance improvement of your WordPress website due to blocking some remote HTTP requests.
* View blocked requests by this plugin. Show reason why it was blocked.
* View failed requests with error message.
* View what initiated HTTP request: WordPress core, plugin or theme.
* View on which page request was made. Also view page type is frontend, admin, login, cron, ajax, xmlrpc or rest_api. 
* View list of other requests made on same page view. 
* View sent and received data.
* How long it took to get response in seconds. 
* Check Point with page time and memory usage for most common hooks like plugins_loaded, init, wp_loaded, setup_theme, after_setup_theme, shutdown. This will give some idea about cause of slow pages.
* Only last 1000 records will be stored. 
* Group requests by URL, domain, initiator, plugin, page, response status etc. 
* Add custom rules (conditional logic) to block or allow certain requests. 


Log summary populated for visible logs in selected page. Summary has following information cards:

* Performance gain quantifier (2x) as a result of optimization. 
* Blocked requests percentage. When hovered it will show request breakdown by core, plugins or theme.
* Number of requests per page. When hovered shows breakdown by page type: Frontend, admin, login, cron, ajax, xmlrpc, rest_api.
* Request time / Page time percentage.
* Average page time.
* Average request time.
* Number of domains. On hover shows breakdown of domains. 


= Use cases =

* Check if WordPress communication to remote APIs works without any problem. — [Check how easy it is to debug WP_HTTP requests →](https://veppa.com/debug-wp_http/) 
* Identify if your website slow because of WP_HTTP requests. Average page load time, average request time and average number of requests per page shown as summary at the top of reports. 
* Block all external request on development or localhost website. All updates will be blocked. You switch off blocking when you want to perform Core, Plugin, Theme updates. No need to use **define('WP_HTTP_BLOCK_EXTERNAL', true);** in your wp-config.php. Plugin will prevent requests automatically when you choose "Block external requests" or "Block external requests (allow WordPress.org only)" operation mode. 
* Block non WordPress request. No data will be sent to third parties. They are usually loading other website news, plugin/theme promotions, advertisements, sending usage statistics etc. 
* Prevent your website from timeout. By blocking all requests if page generation time exceeds 3 seconds. Kill slow HTTP request with small timeout of 2 second. Slow request can be because of temporary network problem or remote website can be too busy to respond on time. Slow request is not your fault so your website should not suffer from it. — [Learn how WP_HTTP Optimization works →](https://veppa.com/optimize-wp-http-requests/)

[More info about "HTTP Requests Manager" plugin on official home page →](https://veppa.com/http-requests-manager/)


= Credits =
* Initial logging functionality was taken from [Log HTTP Requests (version 1.4, year 2023) Github →](https://github.com/FacetWP/log-http-requests)
* Blocking, grouping and additional features added by [veppa →](https://veppa.com/)

= What's next =

If you find this plugin useful to view WP_HTTP requests and speeding up your admin pages by blocking some requests then give good rating. Also check my other projects:

* [Tutorial to get high PageSpeed Score](https://veppa.com/improve-pagespeed/) — video showing how I get PageSpeed Score 100 for my own website powered by WordPress CMS.
* [Cloudflare Custom Rules](https://veppa.com/wordpress-cloudflare-optimization/) — pluginsless solutions for Page Cache, Antibot (prevents automated spam comments and brute-force login attacks) etc.
* [Share button without plugin](https://veppa.com/share-button/) — add super fast native sharing button to your website. Tiny inline code, ad blocker safe, no external dependencies.
* [bbPress WP Tweaks](https://veppa.com/bbpress-wp-tweaks/) — add custom sidebar, additional widgets and forum columns for sites powered with bbPress forum plugin.

Visit veppa.com to learn from my [WordPress tutorials](https://veppa.com/category/learn-wordpress/). 

== Installation ==

1. Download and activate the plugin.
2. Browse to `Tools` → `HTTP Requests Manager` to view log entries and choose operation mode. Operation mode "Only log HTTP requests" will be activated by default.
3. Use "Smart block" operation mode to optimize WP_HTTP usage.

== Screenshots ==

1. Screenshot shows latest HTTP requests and reason why they are blocked. Summary cards at the top show total percentage of blocked requests (54% in current view). You can also see estimated performance improvement 2.2x because of blocking some remote requests. Hosts card shows that there are 3 different hosts were requests sent. When you hover over card tooltip will show breakdown of hosts in percentage. We can see that 31% or requests were made to api.wordpress.org website. Also we can see that plugins actively using external requests to load data and some promotions from their servers.

2. When Smart Block enabled total page generation time will be limited to 3 seconds. Page with 10 requests, will improve from 11-12 seconds to 3 seconds, regardless of web hosting resources.  

3. WP_HTTP request and response data. Popup opens when you click on request from table. Page and request times shows as well. 

4. Blocked request due to page time exceeding 3 seconds. Additional information regarding page shown with currently active manager mode.

5. Check point shows how plugins and requests effect page time and memory usage.

6. Group requests to simplify report. You can group by request domain, page type, initiator, response status etc. Bar colors will visually indicate requests by response status as blocked orange, success green, error red. 

7. Requests grouped by initiator core / theme / plugin. Clicking on group will reveal requests inside that group.

8. Settings page to select operation mode, disable logging and adding custom rules. Settings will be saved each time when you change any option. 

9. Select operation mode to fit your need. Only blocking modes will speed up WordPress admin pages. Be aware that blocking modes may break functionality of some plugins that rely on external API requests. 

10. Define custom rules to always allow some plugins or domains only in "Smart block" mode. Custom rules will be ordered by high priority. First matching rule will be applied. 


== Frequently Asked Questions ==

= How long logs stored in database? =

There is no time limit to store logs. Last 1000 logs will be stored. On average it is about 10 days of logs.

= Is it possible to pause plugin and only view recorded logs? =

Yes, set operation mode to "Only log HTTP requests" and check "disable logging" checkbox in "Settings" tab. With these settings new logs will not be added and you can review already existing old logs. 

= Does plugin removes logs and options on uninstall? =

Yes it removes logs and options stored in database when you uninstall this plugin. 

= Which pages are recorded? =

All pages with WP_HTTP requests are recorded. Slow pages without any WP_HTTP requests are not recorded. 

= Which remote requests are not detected? =

This plugin detects only requests made using [WP_HTTP](https://developer.wordpress.org/reference/classes/wp_http/) class defined by WordPress. It is preferred way of doing remote requests. WordPress core and most plugins/themes use it. 

Plugin will not detect requests made using other classes and functions. For example remote requests made with WordPress class [WP_Http_Curl](https://developer.wordpress.org/reference/classes/wp_http_curl/) (deprecated starting from WordPress version 6.4) or PHP functions like curl_exec, fsockopen, file_get_contents are not detected by this plugin.  Because they do not have hooks similar to WordPress to manage requests before making them.

Unfortunately when plugin/theme uses other functions (not WP_HTTP class) they will not be detected by this plugin.  

= How much performance improvement can be gained? =

Performance gain on pages with WP_HTTP requests can be up to 5x. It all depends on which blocking method used and how heavyly remote requests are used by core and pugins. 

= Are all WordPress pages have WP_HTTP requests? =

No. WP_HTTP requests are performed periodically or on certain action. When you check logged requests, there will be around 50-100 pages with requests per day. On website with 10k daily page views (human and bot traffic) it will make around 1% of all pages.

= How can I feel speed improvement provided by this plugin? =

You will most likely feel speed difference in admin area. Pages previously loading slowly or timing out regularly should load much faster. 

== Changelog ==


= 1.3.8 - 22 May 2025  =

  * Fixed: _load_textdomain_just_in_time called too early notice.


= 1.3.7 - 20 March 2025  =

  * Fixed: Array type warning inside MU file.
  * Optimization: Truncate long responses. Reduce saved and reported data size by 50%. Average data for 100 requests after this optimization should be — uncompressed ~1mb, compressed ~100kb.


= 1.3.6 - 30 October 2024  =

  * Fixed: Checking HTTP_HOST variable existence before using.
  * Fixed: Page type detection rechecked if used fallback type admin or frontend. (rest api detected as frontend because of late initialization).
  * Update: Optimized code related to loaded plugin detection. Reduced function execution time from 300ms to 17ms.
  * Update: Increased custom rules limit from 10 to 30.

= 1.3.5 - 2 September 2024  =

 * Fixed: Increased request_source field size to 255 characters. 

= 1.3.4 - 26 August 2024  =

 * Added: Separate group view requests by core: pingback, enclosure, browse happy, serve happy, update, translation, health, oEmbed etc.
 * Added: Show total number of requests in detail view for given page.
 * Added: When possible force blocking rules by defining constants to (block all external) and (allow only wp requests).
 * Fixed: Do not add cp (checkpoint) hooks if logging disabled. Prevent waste of memory.
 * Update: Made "Only log HTTP requests" default operation mode. 

= 1.3.3 - 30 June 2024  =
 
 * Added: URL becomes empty when it is not validated by WordPress. Empty request URLs now shows clickable text [empty]. Original URL will be shows inside Checkpoint.  
 * Added: When request responded (from cache or error) by other plugin without sending to remote server it will be labeled as 'other' and not blocked.
 * Fixed: color coding requests from same page on logs page. 
 * Fixed: Requests with longer plugin name were not recorded to database because of bug. Now database field length increased and longer strings will be truncated to fit when needed. 
 
= 1.3.2 - 26 June 2024  =

  * Added: Skip smart block limitation while updating WordPress core.
  * Update: Do not lower request timeout inside cron job and custom rules with allow action.

= 1.3.1 - 6 May 2024 =

* Updated support to WordPress 6.5

= 1.3.0 - 6 May 2024 =

* Added: Priority loading mode using MU plugin feature. Plugin will load as Must-Use plugin before other plugins for catching as many requests as possible.
* Added: Prevent requests initiated by do_enclose function after adding/updating post with images and links. Every time when post saved all links inside post will be requested for checking their file type. For example post with 20 links and 10 images will make 30 requests to check file type for each URL. Only audio and video URLs are saved as enclosure. Other requests are not used and wastes server resources. This request prevention will eliminate tens of requests to non audio/video URLs. When enabled related cron request for post with 30 URLs will finish in 1 second instead of 30 seconds.
* Added: Log prevented requests for better understanding what is changed after enabling some blocking mode. Previously prevented self pings and do_enclose requests were not logged. 
* Added: Calls from xmlrpc.php file are moved to new page group called "xmlrpc" from previous "frontend".
* Added: Summary card showing average performance improvement occurred due to blocking some remote API/HTTP requests. 
* Fixed: increased request timeout from 1 second to 2 seconds for allowing enough time to complete CURL calls made to HTTPS servers.
* Fixed: responses to non streaming requests will be grouped as "success" instead of "error". 

= 1.2.4 - 12 February 2024 =

* Fixed: prevent calling is_user_logged_in function when it is not declared.

= 1.2.3 - 30 November 2023 =

* Fixed: Domain select box population when adding new Custom Rule. 

= 1.2.2 - 29 November 2023 =

* Fixed: Variable name typo inside get_arr_val function.


= 1.2.1 - 29 November 2023 =

* Fixed: Incorrect links in options page.


= 1.2.0 - 28 November 2023 =

* Added: Separate tabs for log, settings, more tools
* Added: Group request logs by URL, domain, page, page type, plugin, response status etc. Better for viewing important information.
* Added: Custom rules to block/allow by all/domain/plugin in everywhere/admin/frontend/ajax/cron/rest_api/login. Maximum 10 custom rules can be added. Custom rules apply only in smart block mode. 
* Added: Option to disable logging. Old logs can be viewed. Plugin will work a bit faster when logging disabled.
* Added: Disable self ping (only when blocking in "smart block+" mode). Self ping sends pings to images and links on same domain. Post with 20+ links and images will take 10+ seconds to send self pings.
* Added: Disable auto update check on admin page in "smart block+" mode. _maybe_update_core, _maybe_update_themes, _maybe_update_plugins slows down admin pages up to 5+ seconds on first visit after 12 hours and can even timeout. Update checks via cron is not effected.
* Fixed: Undefined array key "file" error
* Update: Store last 1k records 

= 1.1.0 - 12 June 2023 =

* Added: Separate table to log page info like check point with time and memory usage. 
* Added: New tab to show Check Points for page with time and memory usage in request details popup window.
* Fixed: Remove plugin tables on uninstall.
* Update: Reduced response body before sending to view in admin panel. This will reduce loaded json data size. 
* Update: Clear log button now recreates tables which will eliminate table inconsistency with new versions of plugin in future. 

= 1.0.7 - 5 June 2023 =

* Initial release. Log HTTP Requests (version 1.4) used as base.
