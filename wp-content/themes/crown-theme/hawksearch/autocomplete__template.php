<div class="autocomplete">
	<div class="row">
		{{#if products.results.length}}
		<div class="column column--12 column-md--8">
			<span class="autocomplete__title autocomplete__title--products">{{products.title}}</span>
			<div class="row autocomplete__products">
				{{#each products.results}}
				<div class="column column--12 column-sm--4">
					<div class="autocomplete__product">
						<a hawksearch-product="{{id}}" href="{{url}}" class="autocomplete__product__image">
							<img hawksearch-image src="{{imageUrl}}" alt="" />
						</a>
						<span class="autocomplete__product__title">
                            <a hawksearch-product="{{id}}" href="{{url}}">{{html title}}</a>
                        </span>
                        <div class="search-results-list__item__sku">
                            <span class="sku">#{{sku}}</span>
                        </div>
						{{#if rating}}
						<hawksearch-rating rating="{{rating}}"></hawksearch-rating>
						{{/if}}
						<hawksearch-variant-selector></hawksearch-variant-selector>
					</div>
				</div>
				{{/each}}
			</div>
		</div>
		{{/if}}
		{{#if (or categories.results.length content.results.length queries.results.length)}}
		<div class="column column--12 column-md--4">
			{{#if productSuggestedQueries.results.length}}
			<span class="autocomplete__title autocomplete__title--queries">{{productSuggestedQueries.title}}</span>
			<ul class="autocomplete__list">
				{{#each productSuggestedQueries.results}}
				<li>
					<a hawksearch-query="{{query}}" href="{{url}}">{{query}}</a>
				</li>
				{{/each}}
			</ul>
			{{/if}}
			{{#if contentSuggestedQueries.results.length}}
			<span class="autocomplete__title autocomplete__title--queries">{{contentSuggestedQueries.title}}</span>
			<ul class="autocomplete__list">
				{{#each contentSuggestedQueries.results}}
				<li>
					<a hawksearch-query="{{query}}" href="{{url}}">{{query}}</a>
				</li>
				{{/each}}
			</ul>
			{{/if}}
			{{#if categories.results.length}}
			<span class="autocomplete__title autocomplete__title--categories">{{categories.title}}</span>
			<ul class="autocomplete__list">
				{{#each categories.results}}
				<li>
					<a hawksearch-category-field="{{field}}" hawksearch-category-value="{{value}}" href="{{url}}">{{html title}}</a>
				</li>
				{{/each}}
			</ul>
			{{/if}}
			{{#if content.results.length}}
			<span class="autocomplete__title autocomplete__title--content">{{content.title}}</span>
			<ul class="autocomplete__list">
				{{#each content.results}}
				<li>
					<a hawksearch-content="{{id}}" href="{{url}}">{{html title}}</a>
				</li>
				{{/each}}
			</ul>
			{{/if}}
			{{#if queries.results.length}}
			<span class="autocomplete__title autocomplete__title--queries">{{queries.title}}</span>
			<ul class="autocomplete__list">
				{{#each queries.results}}
				<li>
					<a hawksearch-query="{{query}}" href="{{url}}">{{query}}</a>
				</li>
				{{/each}}
			</ul>
			{{/if}}
		</div>
		{{/if}}
	</div>
	<div class="autocomplete__view-all">
		<a hawksearch-view-all>{{viewAllText}}</a>
	</div>
</div>