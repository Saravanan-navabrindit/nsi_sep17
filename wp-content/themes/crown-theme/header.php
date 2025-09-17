<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>

	<head>

		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" >

		<link rel="profile" href="https://gmpg.org/xfn/11">

		<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
		<link rel="manifest" href="/site.webmanifest">
		<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#000000">
		<meta name="msapplication-TileColor" content="#000000">
		<meta name="theme-color" content="#ffffff">

		<noscript>
			<style>
				/* add styles here that would normally require javascript to be visible */
			</style>
		</noscript>

		<script>
			function ctSetVw() {
				let vw = document.documentElement.clientWidth / 100;
				document.documentElement.style.setProperty('--ct-vw', `${vw}px`);
			}
			ctSetVw();
			window.addEventListener('resize', ctSetVw);
		</script>

        <script type="text/javascript">

            const stylesToAdd = `
            .autocomplete {
                width:40vw;
            }
            .search-field {
                width: 244px;
            }
            .search-field span.icon {
                position: absolute;
                display: block;
                left: 1rem;
                top: 50%;
                margin-top: -0.6rem;
                z-index: 1;
            }
            .search-field input {
              border-radius: 100px;
              background-color: #E6E6E6;
              background-clip: padding-box;
              border: none !important;
              height: 38px;
              padding: 0.5rem 0.45rem;
              padding-left: 42px;
            }
            .search-field:hover input {
              border: none;
            }
            .search-field:focus input, .search-field:active input, .search-field:focus-within input{
              border: none;
              box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.25);
            }
            .search-results-list__item {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }
            .search-results-list__item__buttons {
                display: flex;
                gap: 10px;
                justify-content: space-around;
            }

            .search-results-list__item.processing {
                opacity: 0.6;
                cursor: wait;
            }

            .search-results-list__item.processing a {
                pointer-events: none;
            }

            .search-results-list__item__buttons a.button {
                background-color: #000000;
                border-color: #000000;
                color: #FFFFFF;
                padding-right: 12px;
                padding-left: 12px;
                height: auto;
            }

            .search-results-list__item.processing .search-results-list__item__buttons a.button{
                opacity: 0.25;
                pointer-events: none;
            }

            .search-results-list__item__sku {
                margin-bottom: var(--padding-sm);
            }
            `;

            var HawkSearch = HawkSearch || {};
            const key = '<?php echo HAWKSEARCH_CLIENT_GUID ?>';
            const search_results_route = '<?php echo HAWKSEARCH_API_SEARCH_RESULTS_ROUTE ?>';
            const search_api_endpoint_url = '<?php echo HAWKSEARCH_API_SEARCH_URL ?>';
            const tracking_api_endpoint_url = '<?php echo HAWKSEARCH_API_TRACKING_URL ?>';

            HawkSearch.config = {
                clientId: key,
                search: {
                    url: search_results_route,
                    itemTypes: {
                        default: 'product'
                    },
                    endpointUrl: search_api_endpoint_url
                },
                tracking: {
                    endpointUrl: tracking_api_endpoint_url
                },
                components: {
                    'search-results-item': {
                        template: `<?php include_once('hawksearch/search-results-item__template.php'); ?>`
                    },
                    'search-field': {
                        template: `<?php include_once('hawksearch/search-field__template.php'); ?>`
                    },
                    'autocomplete': {
                        template: `<?php include_once('hawksearch/autocomplete__template.php'); ?>`
                    },
                    'facet-wrapper': {
                        template: `<?php include_once('hawksearch/facet-wrapper__template.php'); ?>`
                    }
                },
                css: {
                    customStyles: stylesToAdd
                }
            };
        </script>
        <script src="//cdn.jsdelivr.net/npm/@bridgeline-digital/hawksearch-handlebars-ui@5.0.1/dist/index.js" defer></script>
		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?>>

		<?php wp_body_open(); ?>

		<div id="page">

			<a class="sr-only sr-only-focusable" href="#main">Skip to content</a>
			
			<?php get_template_part( 'template-parts/site-announcement' ); ?>

			<?php get_template_part( 'template-parts/site-header' ); ?>

			<div id="main" role="main">
				<div class="inner">
					<div class="container">
						<div class="inner">
                            <div id="loader_fme-nsi">
                                <img
                                     src="<?php echo get_template_directory_uri() . '/assets/img/loader1.gif' ?>" alt="spinner">
                            </div>
