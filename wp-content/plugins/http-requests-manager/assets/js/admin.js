(function ($)
{
	$(function ()
	{

		// Refresh
		VPHRM.refresh = function ()
		{
			$('.vphrm-refresh').text('Refreshing...').attr('disabled', 'disabled');
			$.post(ajaxurl, {
				'action': 'vphrm_query',
				'_wpnonce': VPHRM.nonce,
				'data': VPHRM.query_args
			}, function (data)
			{
				console.log('refresh, data=', data);
				VPHRM.response = data;
				if (data.domains)
				{
					VPHRM.populate_domains_select(data);
				}

				if (typeof data.custom_rules !== 'undefined')
				{
					VPHRM.custom_rule_view(data.custom_rules);
				}

				// reset for regular refresh
				VPHRM.query_args.page = 1;

				// populate stats for generating group data			
				VPHRM.format_stats(data);

				if (data.rows && data.rows.length)
				{
					// display all summary, pagination, data table
					var html = '<div class="vphrm-summary">' + data.stats.message.join(' ') + '</div>'
							+ '<div class="vphrm-pager">' + data.pager + '</div>'
							+ '<div class="vphrm-content" id="vphrm-content">'
							+ VPHRM.view()
							+ '</div>'
							+ '<div class="vphrm-pager">' + data.pager + '</div>';

					// update view
					$('.vphrm-wrap').html(html);
					$('.vphrm-group-view').show();
				}
				else
				{
					// no records found. 
					VPHRM.no_results();
				}

			}, 'json')
					.fail(function (jqXHR, textStatus, error)
					{
						console.log(VPHRM.message_connection_error + ": " + error, jqXHR, textStatus, error);
						alert(VPHRM.message_connection_error + ": " + error);
					})
					.always(function ()
					{
						$('.vphrm-refresh').text('Refresh').removeAttr('disabled');
					});
			;
		};



		VPHRM.populate_domains_select = function (data)
		{
			console.log('populate_domains_select=', data.domains);
			// store domain in seperate var. load it only once per 
			VPHRM.domains = data.domains;
			delete data.domains;

			/*
			 * <select name="rule_domain" id="rule_domain">
			 <option value="domain1.com">domain1.com</option>
			 <option value="domain2.com">domain2.com</option>
			 </select>
			 
			 */
			var select = '';
			for (var x in VPHRM.domains)
			{
				if (VPHRM.domains[x])
				{
					select += '<option value="' + VPHRM.domains[x] + '">' + VPHRM.domains[x] + '</option>';
				}
			}

			if (select)
			{
				// valid domains loaded 
				// prevent loading it on pagination 
				VPHRM.query_args.get_domains = 0;

				// generate domains select box for custom rule 
				var $type_select = $('#rule_type:first');
				$type_select.after('<select name="rule_domain" id="rule_domain">' + select + '</select>');

				$type_select.find('option[value="all"]').before('<option value="domain">domain</option>');

				// apply type switch 
				VPHRM.switch_rule_type();
			}
		};

		VPHRM.cmp_count_total = function (a, b)
		{
			/* sort array of objects by value 
			 * used to sort when grouped */
			if (a.count_total < b.count_total)
			{
				return -1;
			}
			if (a.count_total > b.count_total)
			{
				return 1;
			}
			return 0;

		};

		VPHRM.view_update = function ()
		{
			// set current view 
			VPHRM.group_view = $('select.vphrm-group-view').val();

			// populate and show view
			$('.vphrm-content').html(VPHRM.view());

			// window.location.href = '#vphrm-content';
			/*var element = document.getElementById("vphrm-content");
			 element.scrollIntoView();*/



			// save view 
			VPHRM.view_save();


			$('select.vphrm-group-view').attr('disabled', 'disabled');
			setTimeout(function ()
			{
				$('select.vphrm-group-view').removeAttr('disabled');
			}, 100);
		};
		VPHRM.view = function ()
		{
			var data = VPHRM.response;


			if (data.rows)
			{

				switch (VPHRM.group_view)
				{
					case 'group-req-url':
						return VPHRM.view.group_req_url('url');
						break;
					case 'group-req-domain':
						return VPHRM.view.group_req_url('request_host');
						break;
					case 'group-page-url':
						return VPHRM.view.group_req_url('page-url');
						break;
					case 'group-page-type':
						return VPHRM.view.group_req_url('page-type');
						break;
					case 'group-request-group':
						return VPHRM.view.group_req_url('request_group');
						break;
					case 'group-request-source':
						return VPHRM.view.group_req_url('request_source');
						break;
					case 'group-response':
						return VPHRM.view.group_req_url('response');
						break;
					case 'group-no':
					default:
						return VPHRM.view.group_no();
						break;
				}
			}

			return '';

		};


		VPHRM.view.get_req_status = function (row)
		{
			var status = 'error';


			var request_args = JSON.parse(row.request_args);
			// block_request is used in old logs. 
			// request_action is new way of recording blocked status
			if (request_args._info.request_action === 'block' || request_args._info.block_request)
			{
				status = 'blocked';
			}
			else if (row.status_code == '200' || !request_args.blocking)
			{
				status = 'success';
			}

			/*
			 * // row.request_status is not reliable 
			 switch (row.request_status)
			 {
			 case 'blocked':
			 status = 'blocked';
			 break;
			 case '200':
			 status = 'success';
			 break;
			 case '-':
			 case '404':
			 default:
			 status = 'error';
			 }
			 */

			return status;
		};

		VPHRM.view.group_req_url = function (key)
		{
			// generate table rows 
			var data = VPHRM.response;
			var result = {};

			key = key || 'url';

			var group_name = '';
			var max_count = 0;

			for (var idx in data.rows)
			{
				var row = data.rows[idx];
				var req_status = VPHRM.view.get_req_status(row);

				switch (key)
				{
					case 'response':
						group_name = req_status;
						break;
					case 'page-url':
						var page = VPHRM.get_request_page_by_id(row.page_id);
						//group_name = page.url;
						group_name = page.url.split('?')[0];
						break;
					case 'page-type':
						var page = VPHRM.get_request_page_by_id(row.page_id);
						group_name = page.page_type;
						break;
					case 'url':
						//group_name = row['url'];
						group_name = row['url'].split('?')[0].replace('http://', 'https://');
						break;
					default:
						group_name = row[key];
				}


				result[group_name] = result[group_name] || {
					context: {},
					html: '',
					runtime: 0,
					count_blocked: 0,
					count_error: 0,
					count_success: 0,
					count_total: 0
				};
				result[group_name].html += VPHRM.format_row(idx, result[group_name].context);
				result[group_name].count_total++;
				result[group_name].runtime += row.runtime;
				max_count++;
				switch (req_status)
				{
					case 'blocked':
						result[group_name].count_blocked++;
						break;
					case 'success':
						result[group_name].count_success++;
						break;
					case 'error':
					case '-':
					case '404':
					default:
						result[group_name].count_error++;
				}
			}


			// order by requests 
			var keysSorted = Object.keys(result).sort(function (a, b)
			{
				return result[b].count_total - result[a].count_total;
			});

			var html = '';
			var toggle_id = 0;
			for (var x in keysSorted)
			{

				var result_row = result[keysSorted[x]];
				var perc = Math.round(result_row.count_total * 100 / max_count);
				var perc_error = Math.round(result_row.count_error * 100 / result_row.count_total);
				var perc_blocked = Math.round(result_row.count_blocked * 100 / result_row.count_total);
				var runtime = (result_row.runtime / Math.max(1, result_row.count_total)).toFixed(1) * 1;
				var bar = '<span class="vphrm-bar" style="width:' + (perc * 0.9) + '%" '
						+ 'title="' + (result_row.count_total - result_row.count_error - result_row.count_blocked) + ' requests">'
						+ (perc_error ? '<span class="vphrm-bar-section-error" style="width:' + perc_error + '%" '
								+ 'title="' + result_row.count_error + ' error"></span>' : '')
						+ (perc_blocked ? '<span class="vphrm-bar-section-blocked" style="width:' + perc_blocked + '%" '
								+ 'title="' + result_row.count_blocked + ' blocked"></span>' : '')
						+ '</span> '
						+ perc + '%';



				toggle_id++;
				html += '<div class="vphrm-card vphrm-card-full">'
						+ '<p class="vphrm-toggle vphrm-toggle-action" data-toggle=".vphrm-toggle-' + toggle_id + '">'
						+ '<span>' + keysSorted[x] + '</span> '
						+ ' <i class="vphrm-badge light" title="' + result_row.count_total + ' requests"><b>#</b> '
						+ result_row.count_total + '</i> '
						+ (runtime > 0 ? ' <i class="vphrm-badge light" title="Average time ' + runtime + 's"><b>◷</b> '
								+ (runtime > 1 ? '<b>' + runtime + 's' + '</b>' : runtime + 's') + '</i> ' : '')
						+ '<br><span>' + bar + '</span>'
						+ '</p>'
						+ '<div class="vphrm-toggle-' + toggle_id + ' vphrm-toggle-hide">' + VPHRM.format_table(result_row.html) + '</div>'
						+ '</div>';
			}


			return html;

		};

		VPHRM.view.group_no = function ()
		{
			// generate table rows 
			var data = VPHRM.response;
			var html = '';
			var context = {};

			for (var idx in data.rows)
			{
				html += VPHRM.format_row(idx, context);
			}


			// table of requests			
			return VPHRM.format_table(html);

		};

		VPHRM.format_table = function (html)
		{
			/* display table of requests */
			return   '<table class="widefat vphrm-listing wp-list-table plugins">'
					+ '<thead>'
					+ '<tr>'
					+ '<th class="column-primary">Request</th>'
					+ '<th title="HTTP response code">Status</th>'
					+ '<th title="seconds">Runtime</th>'
					+ '<th title="seconds">Page time</th>'
					+ '<th>Date Added</th>'
					+ '</tr>'
					+ '</thead>'
					+ '<tbody id="the-list">' + html + '</tbody>'
					+ '</table>';
		};


		VPHRM.get_request_page_by_id = function (id)
		{
			/* return page or return empty page if not found */
			var page = (VPHRM.response.pages[id]) || {
				runtime: 0,
				info: ''
			};

			// parse info
			if (typeof page.info === 'string')
			{
				page.info = VPHRM.parse_json(page.info) || {
					req_num: 0
				};
			}

			return page;
		};


		VPHRM.format_row = function (idx, context)
		{
			/* format table row for request */
			context = context || {
				runtime_css: '',
				page_runtime_css: '',
				page_num: 0,
				page_style: ''
			};

			context.page_num = context.page_num || 0;

			var page_colors = [
				'#FBFACD',
				'#CDF0EA',
				'#FFD4B2',
				'#AAE3E2',
				'#E9EDC9',
				'#B5F1CC',
				'#F6F1E9'
			];

			var row = VPHRM.response.rows[idx];
			var page = VPHRM.get_request_page_by_id(row.page_id);
			var runtime = parseFloat(row.runtime);
			var page_runtime = parseFloat(page.runtime);
			context.runtime_css = (runtime > 2) ? ' error' : ((runtime > 1) ? ' warn' : '');
			context.page_runtime_css = (page_runtime > 2) ? ' error' : ((page_runtime > 1) ? ' warn' : '');

			// group same page by color
			if (context.last_page_id !== row.page_id)
			{
				context.last_page_id = row.page_id;
				context.page_num++;
				context.page_style = ' style="background-color:' + page_colors[ context.page_num % page_colors.length ] + '"';
			}


			var html = `
                    <tr>
                        <td class="field-url vphrm-break-word">
                            <div><a href="javascript:;" data-id="` + idx + `">` + (row.url || '[empty]') + `</a></div>`
					+ VPHRM.format_row_badges(row) + `
                        </td>
                        <td class="field-inline">` + row.status_code + `</td>
                        <td class="field-inline` + context.runtime_css + `">` + row.runtime + `</td>
                        <td class="field-inline` + context.page_runtime_css + `" title="` + page.url + `">` + page_runtime + `</td>
                        <td class="field-inline" title="` + row.date_raw + `"` + context.page_style + `>` + row.date_added + `</td>
                    </tr>
                    `;

			return html;

		};


		VPHRM.format_row_badges = function (row)
		{
			/* add badgs to request row: Blocked, Error, Plugin etc. */
			if (typeof row.badges === 'undefined')
			{

				var request_args = JSON.parse(row.request_args);
				var response = VPHRM.parse_json(row.response);

				// show badges if blocked
				row.badges = [];
				// row.badges.push('<i>'+request_args._info.manager_mode+'</i>');
				if (request_args._info.request_action)
				{
					row.badges.push('<i class="vphrm-badge'
							+ (request_args._info.request_action === 'block' ? ' warn' : ' success')
							+ '">'
							+ '<b>' + request_args._info.request_action + ':</b> '
							+ request_args._info.request_action_info
							+ '</i>');
				}
				else if (request_args._info.block_request)
				{
					// handle old format blocked requests 
					row.badges.push('<i class="vphrm-badge warn"><b>blocked:</b> ' + request_args._info.block_request + '</i>');
				}

				// show error message inline
				var err = ((((response || {}).errors || {}).http_request_failed || [])[0] || '');
				if (err)
				{
					row.badges.push('<i class="vphrm-badge error"><b>Error:</b> ' + err + '</i>');
				}

				// show caller responsible plugin or theme
				var caller = ((request_args._info.backtrace_file || {}).caller || false);
				if (caller)
				{
					if (typeof caller.type !== 'undefined')
					{
						/*
						 old format before  1.0.9
						 "caller": {
						 "file": "wp-includes/update.php",
						 "type": "core",
						 "name": ""
						 }
						 */
						if (caller.type !== 'core')
						{
							row.badges.push('<i class="vphrm-badge caller caller-' + caller.type + '"><b>' + caller.type + ':</b> ' + caller.name + '</i>');
						}
					}
					else
					{
						/*
						 format since  1.0.9
						 "caller": {
						 "plugin-slug": "plugin",
						 "plugin-slug-other": "plugin",
						 "theme-slug": "theme",
						 "": "core"
						 }
						 */
						// new format 
						// show multiple callers if defined 
						for (var x in caller)
						{
							if (caller[x] !== 'core')
							{
								row.badges.push('<i class="vphrm-badge caller caller-' + caller[x] + '"><b>' + caller[x] + ':</b> ' + x + '</i>');
							}
						}
					}
				}
			}


			return row.badges.join(' ');
		};

		VPHRM.format_stats = function (data)
		{
			/* calculate and format stats using data */
			var stats = {
				requests: data.rows.length || 0,
				pages: Object.keys(data.pages).length || 0,
				page_time_max: 0,
				page_time_total: 0,
				page_time_each: {},
				page_time_before_each: {},
				req_per_page_each: {},
				hosts: {},
				page_types: {},
				req_types: {},
				req_sources: {},
				req_time_max: 0,
				req_time_total: 0,
				req_time_total_blocking: 0,
				requests_blocking: 0,
				num_blocked: 0,
				message: []
			};

			// save to global variable 
			data.stats = stats;

			for (var idx in data.rows)
			{

				var row = data.rows[idx];


				var page = VPHRM.get_request_page_by_id(row.page_id);

				var runtime = parseFloat(row.runtime);
				var page_runtime = parseFloat(page.runtime);

				var request_args = JSON.parse(row.request_args);
				var response = VPHRM.parse_json(row.response);
				var uniqid = row.page_id;
				var req_status = VPHRM.view.get_req_status(row);
				var req_is_blocked = (req_status === 'blocked');

				// calculate stats

				if (typeof stats.page_time_each[uniqid] === 'undefined')
				{
					// calculate once per page 
					stats.page_time_each[uniqid] = page_runtime;
					stats.req_per_page_each[uniqid] = page.info.req_num;
					stats.page_time_max = Math.max(stats.page_time_max, page_runtime);
					stats.page_time_before_each[uniqid] = request_args._info.timer_before;
					stats.page_time_total += page_runtime;
				}

				stats.req_time_max = Math.max(stats.req_time_max, row.runtime);
				stats.req_time_total += row.runtime;
				stats.req_time_total_blocking += (req_is_blocked || !request_args.blocking) ? 0 : row.runtime;
				stats.requests_blocking += (req_is_blocked || !request_args.blocking) ? 0 : 1;
				stats.num_blocked += (req_is_blocked ? 1 : 0);
				var request_host = request_args._info.request_host || '-';
				stats.hosts[request_host] = (stats.hosts[request_host] || 0) + 1;
				row.request_host = request_host;
				var page_type = page.page_type || '-';
				stats.page_types[page_type] = (stats.page_types[page_type] || 0) + 1;

				// show responsible plugin or theme
				row.request_source = row.request_source || 'core';
				row.request_group = row.request_group || 'core';
				var caller = ((request_args._info.backtrace_file || {}).caller || false);
				if (caller)
				{
					if (typeof caller.type !== 'undefined')
					{
						/*
						 old format before  1.0.9
						 "caller": {
						 "file": "wp-includes/update.php",
						 "type": "core",
						 "name": ""
						 }
						 */

						row.request_group = caller.type;
						row.request_source = row.request_group + ((row.request_group !== 'core') ? ': ' + caller.name : '');
					}
					else
					{
						/*
						 format since  1.0.9
						 "caller": {
						 "plugin-slug": "plugin",
						 "plugin-slug-other": "plugin",
						 "theme-slug": "theme",
						 "": "core"
						 }
						 */
						// new format 
						// show multiple callers if defined 
						for (var x in caller)
						{
							if (row.request_group === 'core')
							{
								// use first caller for stats
								row.request_group = caller[x];
								row.request_source = row.request_group + ((row.request_group !== 'core') ? ': ' + x : '');
							}
						}
					}
				}

				// get more details about core
				if (row.request_source === 'core')
				{
					var more_info = VPHRM.row_core_more_info(row,request_args);
					if(more_info)
					{
						row.request_source += ': '+more_info;
					}
				}

				// count req_types and req_sources 
				stats.req_types[row.request_group] = (stats.req_types[row.request_group] || 0) + 1;
				stats.req_sources[row.request_source] = (stats.req_sources[row.request_source] || 0) + 1;


			}

			// blocked requests, percentage
			stats.message = [];
			if (stats.pages && stats.requests)
			{

				// get top 5 hosts with %					
				stats.hosts_summary = VPHRM.summarize_data(stats.hosts, 10);
				stats.page_type_summary = VPHRM.summarize_data(stats.page_types, 0);
				stats.req_type_summary = VPHRM.summarize_data(stats.req_types, 0);
				stats.req_source_summary = VPHRM.summarize_data(stats.req_sources, 10);
				stats.num_allowed = stats.requests - stats.num_blocked;
				stats.num_performance = stats.num_allowed ? (stats.requests / stats.num_allowed).toFixed(1) * 1 : 10;
				stats.message = [
					'<span class="vphrm-card" title="' + (stats.num_blocked ? stats.num_performance + '×' : '-') + ' performance improvement">'
							+ '<span class="vphrm-card-val">'
							+ (stats.num_blocked ? stats.num_performance + '×' : '-')
							+ '</span>'
							+ '<span class="vphrm-card-name">'
							+ 'Performance imp.'
							+ '</span>'
							+ '</span>',
					'<span class="vphrm-card" title="' + stats.num_blocked + ' requests blocked out of ' + stats.requests + "\nRequest sources:\n" + stats.req_source_summary + '">'
							+ '<span class="vphrm-card-val">'
							+ Math.round(stats.num_blocked * 100 / stats.requests) + '%'
							+ '</span>'
							+ '<span class="vphrm-card-name">'
							+ 'Blocked requests'
							+ '</span>'
							+ '</span>',
					'<span class="vphrm-card" title="Total ' + stats.requests + ' requests over ' + stats.pages + ' pages ' + "\nPage types:\n" + stats.page_type_summary + '">'
							+ '<span class="vphrm-card-val">'
							+ (stats.requests / stats.pages).toFixed(1) * 1
							+ '</span>'
							+ '<span class="vphrm-card-name">'
							+ 'Requests / page'
							+ '</span>'
							+ '</span>',
					'<span class="vphrm-card" title="' + stats.req_time_total.toFixed(1) * 1 + 's total request time of ' + stats.page_time_total.toFixed(1) * 1 + 's total page time">'
							+ '<span class="vphrm-card-val">'
							+ Math.round(stats.req_time_total * 100 / stats.page_time_total) + '%'
							+ '</span>'
							+ '<span class="vphrm-card-name">'
							+ 'Request time / page'
							+ '</span>'
							+ '</span>',
					'<span class="vphrm-card" title="' + stats.page_time_total.toFixed(1) * 1 + 's total page time / ' + stats.pages + ' pages">'
							+ '<span class="vphrm-card-val">'
							+ (stats.page_time_total / stats.pages).toFixed(1) * 1 + 's'
							+ '</span>'
							+ '<span class="vphrm-card-name">'
							+ 'Page time avg.'
							+ '</span>'
							+ '</span>',
					'<span class="vphrm-card" title="' + stats.req_time_total_blocking.toFixed(1) * 1 + 's total request time / ' + Math.max(1, stats.requests_blocking) + ' regular requests">'
							+ '<span class="vphrm-card-val">'
							+ (stats.req_time_total_blocking / Math.max(1, stats.requests_blocking)).toFixed(1) * 1 + 's'
							+ '</span>'
							+ '<span class="vphrm-card-name">'
							+ 'Request time avg.'
							+ '</span>'
							+ '</span>'
							+ '</span>',
					'<span class="vphrm-card" title="' + stats.hosts_summary + '">'
							+ '<span class="vphrm-card-val">'
							+ Object.keys(stats.hosts).length
							+ '</span>'
							+ '<span class="vphrm-card-name">'
							+ 'Domains'
							+ '</span>'
							+ '</span>'
							+ '</span>'

				];

				/*,
				 '<a class="vphrm-card" href="https://www.paypal.com/donate/?hosted_button_id=LZ4LP4MQJDH7Y" target="_blank" title="Donate to this plugin.">'
				 + '<span class="vphrm-card-val">'
				 + 'c[_] '
				 + '</span>'
				 + '<span class="vphrm-card-name">'
				 + 'Buy me a coffee'
				 + '</span>'
				 + '</a>'
				 + '</span>'*/
			}

			// return stats.message.join(' ');
		};

		// get more infor about core function for grouping 
		VPHRM.row_core_more_info = function (row, request_args)
		{

			// pingback, enclosure, oembed, siteahelth, browse happy, serve happy, 
			backtrace = request_args._info.backtrace || [];
			for (x in backtrace)
			{

				if (backtrace[x] === 'do_enclose')
				{
					return 'enclosure';
				}
				if (backtrace[x] === 'pingback')
				{
					return 'pingback';
				}
				if (backtrace[x] === 'WP_oEmbed->fetch')
				{
					return 'oEmbed';
				}
				if (backtrace[x] === '_wp_cron')
				{
					return 'cron';
				}
				if (backtrace[x] === 'WP_Site_Health->perform_test')
				{
					return 'health';
				}
			}


			// check url
			var base_url = row['url'].split('?')[0].replace('http://', 'https://');
		
			if (base_url.search('https://api.wordpress.org/plugins/update-check/') != -1)
			{
				return 'update';
			}
			if (base_url.search('https://api.wordpress.org/themes/update-check/') != -1)
			{
				return 'update';
			}
			if (base_url.search('https://api.wordpress.org/core/checksums/') != -1)
			{
				return 'update';
			}
			if (base_url.search('https://api.wordpress.org/core/version-check/') != -1)
			{
				return 'version-check';
			}
			if (base_url.search('https://api.wordpress.org/core/serve-happy/') != -1)
			{
				return 'serve-happy';
			}
			if (base_url.search('https://api.wordpress.org/core/browse-happy/') != -1)
			{
				return 'browse-happy';
			}
			if (base_url.search('https://api.wordpress.org/plugins/info/') != -1)
			{
				return 'plugins-info';
			}
			if (base_url.search('https://api.wordpress.org/translations/') != -1)
			{
				return 'translations';
			}

			return '';
		}


		// Clear
		VPHRM.clear = function ()
		{
			$('.vphrm-clear').text('Clearing...').attr('disabled', 'disabled');
			$.post(ajaxurl, {
				'action': 'vphrm_clear',
				'_wpnonce': VPHRM.nonce
			}, function (data)
			{
				VPHRM.no_results();
			}, 'json')
					.fail(function (jqXHR, textStatus, error)
					{
						console.log(VPHRM.message_connection_error + ": " + error);
						alert(VPHRM.message_connection_error + ": " + error);
					})
					.always(function ()
					{
						$('.vphrm-clear').text('Clear log').removeAttr('disabled');
					});
		};
		VPHRM.no_results = function ()
		{
			/*$('.vphrm-listing tbody').text('');
			 $('.vphrm-listing').hide();
			 $('.vphrm-pager').text('');*/

			$('.vphrm-wrap').html('No records found. Visit <a href="plugin-install.php">Plugins page</a> then come back here to see some HTTP Requests.');
			$('.vphrm-group-view').hide();
		};
		VPHRM.show_details = function (action)
		{
			var id = VPHRM.active_id;
			if ('next' == action && id < VPHRM.response.rows.length - 1)
			{
				id = id + 1;
			}
			else if ('prev' == action && id > 0)
			{
				id = id - 1;
			}

			VPHRM.active_id = id;
			var data = VPHRM.response.rows[id];
			var page = VPHRM.get_request_page_by_id(data.page_id);

			// show important page info as badges 
			if (typeof page.badges === 'undefined')
			{
				page.badges = [];
				
				page.badges.push('<i class="vphrm-badge"><b>page_type:</b> ' + page.page_type + '</i>');
				page.badges.push('<i class="vphrm-badge"><b>is_user_logged_in:</b> ' + (page.info.is_user_logged_in ? 'true' : 'false') + '</i>');
				page.badges.push('<i class="vphrm-badge"><b>manager_mode:</b> ' + page.info.manager_mode + '</i>');
				if (typeof page.info.ajax_action !== 'undefined')
				{
					page.badges.push('<i class="vphrm-badge"><b>ajax_action:</b> ' + page.info.ajax_action + '</i>');
				}
				page.badges.push('<i class="vphrm-badge"><b>requests:</b> ' + page.info.req_num + '</i>');
			}


			// reduce long response str
			var str_response = JSON.stringify(VPHRM.parse_json(data.response), null, 2);

			/* response body reduced in php before sending for faster data loading. reduce with twice size for being save in js */
			if (str_response.length > 1024 * 20)
			{
				str_response = str_response.substr(0, 1024 * 20) + "\n ...[" + VPHRM.nice_bytes(str_response.length) + ']';
			}

			var request_args = JSON.parse(data.request_args);

			$('.http-url').html(VPHRM.text_more_link(data.url) + '<br/>' + data.badges.join(' '));
			$('.http-page').html(page.url + '<br/>' + page.badges.join(' '));
			$('.http-page-runtime').text(page.runtime + 's');
			$('.http-request-id').text(id);
			$('.http-request-runtime').text(data.runtime + 's');
			$('.http-request-args').text(JSON.stringify(request_args, null, 2));
			$('.http-response').text(str_response);
			$('.vphrm-cp').html(VPHRM.populate_cp_table(page, data.id));

			$('.media-modal').addClass('open');
			$('.media-modal-backdrop').addClass('open');
		};
		VPHRM.populate_cp_table = function (page, request_id)
		{
			// populate cp table 
			var vphrm_cp = '';
			var cp;
			var css_diff;
			var css;
			var css_request;
			var t_old = 0;
			var m_old = 0;
			var m_diff = 0;
			var t_diff = 0;
			request_id = parseInt(request_id);
			if (typeof page.info.cp !== 'undefined')
			{
				for (x in page.info.cp)
				{
					cp = page.info.cp[x];
					m_diff = cp.m - m_old;
					t_diff = cp.t - t_old;
					css_diff = (t_diff > 2) ? ' error' : ((t_diff > 1) ? ' warn' : '');
					css = (cp.t > 2) ? ' error' : ((cp.t > 1) ? ' warn' : '');
					t_old = cp.t;
					m_old = cp.m;

					css_request = parseInt(cp.request_id || 0) === parseInt(request_id) ? ' warn' : '';

					vphrm_cp += `
                    <tr>
                        <td class="vphrm-break-word` + css_request + `">` + VPHRM.text_more_link(cp.name) + `</td>
                        <td class="field-inline` + css_diff + `">` + t_diff.toFixed(3) + `</td>
                        <td class="field-inline` + css + `">` + cp.t + `</td>
                        <td class="field-inline">` + (m_diff ? VPHRM.nice_bytes(m_diff) : 0) + `</td>
                        <td class="field-inline">` + VPHRM.nice_bytes(cp.m) + `</td>                        
                    </tr>
                    `;
				}
			}

			if (vphrm_cp)
			{
				vphrm_cp = '<table class="widefat vphrm-listing wp-list-table plugins">'
						+ '<thead>'
						+ '<tr>'
						+ '<th class="column-primary">Check point</th>'
						+ '<th>Time diff</th>'
						+ '<th>Time</th>'
						+ '<th>Memory diff</th>'
						+ '<th>Memory</th>'
						+ '</tr>'
						+ '</thead>'
						+ '<tbody id="the-list">' + vphrm_cp + '</tbody>'
						+ '</table>';
			}

			return vphrm_cp;
		}

		VPHRM.text_more_link = function (string)
		{
			if (string.length > 100)
			{
				// convert &#038; to & 
				string = string.replace(/&#038;/g, "&");

				string = string.substring(0, 100)
						+ '<a href="#" class="vphrm-more"> [view more] </a><span class="vphrm-more-hidden">'
						+ string.substring(100)
						+ '</span>';
			}
			return string;
		};

		VPHRM.parse_json = function (data)
		{
			var str_response = '';
			try
			{
				str_response = JSON.parse(data);
			}
			catch (err)
			{
				//console.log('error parsing data', err, data);
				//str_response = '[error parsing data]';
				str_response = data;
			}

			return str_response;
		};
		VPHRM.change_mode = function ()
		{
			var $me = $(this);
			var mode = $me.val();
			$me.attr('disabled', 'disabled');
			$('.vphrm-mode-error').hide();
			$.post(ajaxurl, {
				'action': 'vphrm_mode_change',
				'_wpnonce': VPHRM.nonce,
				'mode': mode
			}, function (data)
			{
				if (data.status == 'ok')
				{
					$me.attr('data-current', data.mode);
				}
				else
				{
					// data error
					alert(data.message);
					$me.val($me.attr('data-current'));
				}

			}, 'json')
					.fail(function (jqXHR, textStatus, error)
					{
						console.log(VPHRM.message_save_error + ": " + error);
						alert(VPHRM.message_save_error + ": " + error);
						$me.val($me.attr('data-current'));
					})
					.always(function ()
					{
						$me.removeAttr('disabled');
					});
		};

		VPHRM.change_logging = function ()
		{
			var $me = $(this);
			var checked = $me.is(':checked');
			$me.attr('disabled', 'disabled');
			$.post(ajaxurl, {
				'action': 'vphrm_disable_logging',
				'_wpnonce': VPHRM.nonce,
				'disable_logging': checked ? 1 : 0
			}, function (data)
			{
				if (data.status == 'ok')
				{
					// saved
				}
				else
				{
					// data error
					alert(data.message);
					// revert to old cheched/unchecked state
					$me.prop('checked', !checked);

				}

			}, 'json')
					.fail(function (jqXHR, textStatus, error)
					{
						console.log(VPHRM.message_save_error + ": " + error);
						alert(VPHRM.message_save_error + ": " + error);
						// revert to old cheched/unchecked state
						$me.prop('checked', !checked);
					})
					.always(function ()
					{
						$me.removeAttr('disabled');
					});
		};


		VPHRM.change_load_must_use = function ()
		{
			var $me = $(this);
			var checked = $me.is(':checked');
			$me.attr('disabled', 'disabled');
			$.post(ajaxurl, {
				'action': 'vphrm_load_must_use',
				'_wpnonce': VPHRM.nonce,
				'load_must_use': checked ? 1 : 0
			}, function (data)
			{
				if (data.status == 'ok')
				{
					// saved
				}
				else
				{
					// data error
					alert(data.message);
					// revert to old cheched/unchecked state
					$me.prop('checked', !checked);

				}

			}, 'json')
					.fail(function (jqXHR, textStatus, error)
					{
						console.log(VPHRM.message_save_error + ": " + error);
						alert(VPHRM.message_save_error + ": " + error);
						// revert to old cheched/unchecked state
						$me.prop('checked', !checked);
					})
					.always(function ()
					{
						$me.removeAttr('disabled');
					});
		};



		VPHRM.view_save = function ()
		{
			var view = $('select.vphrm-group-view').val();
			VPHRM.group_view = view;

			$.post(ajaxurl, {
				'action': 'vphrm_save_view',
				'_wpnonce': VPHRM.nonce,
				'view': view
			}, function (data)
			{
				if (data.status == 'ok')
				{
					//console.log('view saved');
				}
				else
				{
					// data error
					//console.log(data.message);
				}

			}, 'json')
					.fail(function (jqXHR, textStatus, error)
					{
						//console.log("error saving view: " + error);
					});
		};


		VPHRM.custom_rule_save = function ()
		{
			var $form = $('.vphrm-form-custom-rule:first form');

			var $me = $form.find('#submit');

			var send = $form.serialize();

			$me.attr('disabled', 'disabled');
			$.post(ajaxurl, {
				'action': 'vphrm_custom_rule_save',
				'_wpnonce': VPHRM.nonce,
				'send': send
			}, function (data)
			{
				console.log('custom_rule_save=', data);
				if (data.status === 'ok')
				{
					// data ok. populate and view custom rules 
					VPHRM.custom_rule_view(data.custom_rules);
					$('.vphrm-form-custom-rule:first #cancel').click();
				}
				else
				{
					// data error
					alert(data.message);
				}

			}, 'json')
					.fail(function (jqXHR, textStatus, error)
					{
						console.log(VPHRM.message_save_error + ": " + error);
						alert(VPHRM.message_save_error + ": " + error);
					})
					.always(function ()
					{
						$me.removeAttr('disabled');
					});
		};

		VPHRM.custom_rule_delete = function ()
		{
			var $me = $(this);
			var id = $me.attr('data-idx');

			console.log('custom_rule_delete', id);

			$me.attr('disabled', 'disabled');
			$.post(ajaxurl, {
				'action': 'vphrm_custom_rule_delete',
				'_wpnonce': VPHRM.nonce,
				'id': id
			}, function (data)
			{
				console.log('custom_rule_delete=', data);
				if (data.status === 'ok')
				{
					// data ok. populate and view custom rules 
					VPHRM.custom_rule_view(data.custom_rules);
				}
				else
				{
					// data error
					alert(data.message);
				}

			}, 'json')
					.fail(function (jqXHR, textStatus, error)
					{
						console.log(VPHRM.message_save_error + ": " + error);
						alert(VPHRM.message_save_error + ": " + error);
					})
					.always(function ()
					{
						$me.removeAttr('disabled');
					});
		};

		VPHRM.custom_rule_view = function (custom_rules)
		{
			var html = '';

			for (var x in custom_rules)
			{
				var rule = custom_rules[x];
				/*
				 * '<div class="vphrm-card vphrm-card-full">'
				 + '<i class="vphrm-badge light"><b>plugin:</b> plugin-name</i>  '
				 + '<i class="vphrm-badge error"><b>block:</b> everywhere</i> '
				 + '<button class="button-link-delete delete" title="Remove">&times;</button>'
				 + '</div>';
				 */

				html += '<div class="vphrm-card vphrm-card-full">';


				if (!!rule['plugin'])
				{
					html += '<i class="vphrm-badge light"><b>plugin:</b> ' + rule['plugin'] + '</i> ';
				}
				else if (!!rule['domain'])
				{
					html += '<i class="vphrm-badge light"><b>domain:</b> ' + rule['domain'] + '</i> ';
				}
				else if (!!rule['all'])
				{
					html += '<i class="vphrm-badge light"><b>all</b></i> ';
				}

				if (!!rule['allow'] || rule['allow'] === '')
				{
					html += '<i class="vphrm-badge success"><b>allow in:</b> ' + (rule['allow'] === '' ? 'everywhere' : rule['allow']) + '</i> ';
				}
				else if (!!rule['block'] || rule['block'] === '')
				{
					html += '<i class="vphrm-badge warn"><b>block in:</b> ' + (rule['block'] === '' ? 'everywhere' : rule['block']) + '</i> ';
				}

				html += '<button class="button-link-delete delete" title="Remove" data-idx="' + x + '">&times;</button>';
				html += '</div>';

			}

			// view custom rules 
			var $view = $('.vphrm-custom-rules');
			if (!$view.length)
			{
				$view = $('<div class="vphrm-custom-rules"></div>');
				$('.vphrm-form-custom-rule:first').after($view);
			}

			$view.html(html);

		};

		VPHRM.nice_bytes = function (a)
		{
			let b = 0, c = parseInt(a, 10) || 0;
			for (; 1024 <= c && ++b; )
				c /= 1024;
			return c.toFixed(10 > c && 0 < b ? 1 : 0) + " " + ["bytes", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"][b]
		};

		VPHRM.summarize_data = function (obj, limit_rows)
		{
			// get top 5 hosts with % as plain text			
			var keysSorted = Object.keys(obj).sort(function (a, b)
			{
				return obj[b] - obj[a]
			});
			// total
			var total = 0;
			// display summary 
			for (var property in obj)
			{
				total += obj[property];
			}

			// total rows 
			var rows_left = Object.keys(obj).length;
			var rest_percent = 100;
			var host = '';
			var host_cnt = 0;
			var host_percent = 0;
			var hosts_summary = '';
			limit_rows = (limit_rows < 1) ? 100 : limit_rows;
			for (var property in keysSorted)
			{
				if (limit_rows > 0)
				{
					host = keysSorted[property];
					host_cnt = obj[host];
					host_percent = Math.round(host_cnt * 100 / total);
					rest_percent -= host_percent;
					hosts_summary += host + ' ' + host_percent + "% \n";
					limit_rows--;
					rows_left--;
				}
			}

			if (rest_percent > 0 && rows_left > 0)
			{
				hosts_summary += 'other ' + rest_percent + "% \n";
			}

			return hosts_summary;
		};

		VPHRM.switch_rule_type = function ()
		{
			var $rules = $('.vphrm-form-custom-rule');
			var $type = $rules.find('#rule_type');

			// console.log('switch_rule_type', $type.val());

			switch ($type.val())
			{
				case 'plugin':
					$rules.find('#rule_domain').hide();
					$rules.find('#rule_plugin').show();
					break;
				case 'domain':
					$rules.find('#rule_domain').show();
					$rules.find('#rule_plugin').hide();
					break;
				case 'all':
				default:
					$rules.find('#rule_domain').hide();
					$rules.find('#rule_plugin').hide();
			}

		};


		VPHRM.init_events = function ()
		{
			// change operation mode
			$(document).on('change', '.vphrm-mode', VPHRM.change_mode);

			// 
			$(document).on('change', 'input#disable_logging[type="checkbox"]', VPHRM.change_logging);
			$(document).on('change', 'input#load_must_use[type="checkbox"]', VPHRM.change_load_must_use);

			// change view group
			$(document).on('change', '.vphrm-group-view', VPHRM.view_update);
			// Page change
			$(document).on('click', '.vphrm-page:not(.active)', function ()
			{
				VPHRM.query_args.page = parseInt($(this).attr('data-page'));
				VPHRM.refresh();
			});

			// Open detail modal
			$(document).on('click', '.field-url a', function ()
			{
				VPHRM.active_id = parseInt($(this).attr('data-id'));
				VPHRM.show_details('curr');
			});
			// Close modal window
			$(document).on('click', '.media-modal-close', function ()
			{
				var $this = $(this);
				if ($this.hasClass('prev') || $this.hasClass('next'))
				{
					var action = $this.hasClass('prev') ? 'prev' : 'next';
					VPHRM.show_details(action);
					return;
				}

				$('.media-modal').removeClass('open');
				$('.media-modal-backdrop').removeClass('open');
				$(document).off('keydown.vphrm-modal-close');
			});
			$(document).keydown(function (e)
			{

				if (!$('.media-modal').hasClass('open'))
				{
					return;
				}

				if (-1 < $.inArray(e.keyCode, [27, 38, 40]))
				{
					e.preventDefault();
					if (27 == e.keyCode)
					{ // esc
						$('.media-modal-close').click();
					}
					else if (38 == e.keyCode)
					{ // up
						$('.media-modal-close.prev').click();
					}
					else if (40 == e.keyCode)
					{ // down
						$('.media-modal-close.next').click();
					}
				}
			});
			/* tab switch */
			$(document).on('click', '.nav-tab', function ()
			{
				var $me = $(this);
				var $tab_wrap = $me.parents('.nav-tab-wrapper:first');
				var target_class = $me.attr('href').replace('#', '');
				var $target = $('.' + target_class);
				var $panel_wrap = $target.parents('.vphrm-panel-wrapper:first');

				// clear actives
				$tab_wrap.find('.nav-tab').removeClass('nav-tab-active');
				$panel_wrap.find('.vphrm-panel').removeClass('vphrm-panel-active');

				// set active state to selected tab and panel 
				$me.addClass('nav-tab-active');
				$target.addClass('vphrm-panel-active');

				return false;
			});
			/* view more text link  */
			$(document).on('click', '.vphrm-more', function ()
			{
				var $me = $(this);
				var $text = $me.next();
				$text.removeClass('vphrm-more-hidden');
				$me.remove();
				return false;
			});

			/* view report rows in group view */
			$(document).on('click', '.vphrm-toggle-action', function ()
			{
				var $me = $(this);
				var toggle = $me.attr('data-toggle');
				//console.log('.vphrm-toggle-action', toggle);
				$(toggle).toggleClass('vphrm-toggle-hide');
				return false;
			});


			/* custom rules events */
			// save custom rule 
			$(document).on('click', '.vphrm-form-custom-rule #submit', VPHRM.custom_rule_save);
			$(document).on('click', '.vphrm-custom-rules .vphrm-card .delete', VPHRM.custom_rule_delete);
			$(document).on('change', '.vphrm-form-custom-rule #rule_type', VPHRM.switch_rule_type);
			// apply initial rule type switch
			VPHRM.switch_rule_type();
		};
		VPHRM.init_events();

		// Ajax
		VPHRM.refresh();

	});
})(jQuery);
