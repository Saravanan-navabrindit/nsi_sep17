{{#if (eq title "Price")}}
<?php if (is_user_logged_in()) {?>
    <div class="facet">
        <div hawksearch-facet-heading class="facet__heading{{attribute ' facet__heading--collapsible' collapsible}}">
            {{title}}
            {{#if tooltip}}
            <hawksearch-tooltip text="{{tooltip}}"></hawksearch-tooltip>
            {{/if}}
            {{#if collapsible}}
            <hawksearch-icon name="{{if-else collapsed 'chevron-right' 'chevron-down'}}" size="1.5em" class="facet__heading__toggle"></hawksearch-icon>
            {{/if}}
        </div>
        {{#unless collapsed}}
        <div class="facet__content">
            {{#if searchable}}
            <input type="text" placeholder="Quick Lookup" hawksearch-facet-search value="{{filter}}" class="facet__search" />
            {{/if}}
            {{#if (eq type "checkbox")}}
            <hawksearch-checkbox-list-facet hawksearch-facet></hawksearch-checkbox-list-facet>
            {{/if}}
            {{#if (eq type "color")}}
            <hawksearch-color-facet hawksearch-facet></hawksearch-color-facet>
            {{/if}}
            {{#if (eq type "date-range")}}
            <hawksearch-date-range-facet hawksearch-facet></hawksearch-date-range-facet>
            {{/if}}
            {{#if (eq type "link")}}
            <hawksearch-link-list-facet hawksearch-facet></hawksearch-link-list-facet>
            {{/if}}
            {{#if (eq type "numeric-range")}}
            <hawksearch-numeric-range-facet hawksearch-facet></hawksearch-numeric-range-facet>
            {{/if}}
            {{#if (eq type "range-slider")}}
            <hawksearch-range-slider-facet hawksearch-facet></hawksearch-range-slider-facet>
            {{/if}}
            {{#if (eq type "recent-searches")}}
            <hawksearch-recent-searches-facet hawksearch-facet></hawksearch-recent-searches-facet>
            {{/if}}
            {{#if (eq type "related-searches")}}
            <hawksearch-related-searches-facet hawksearch-facet></hawksearch-related-searches-facet>
            {{/if}}
            {{#if (eq type "search")}}
            <hawksearch-search-within-facet hawksearch-facet></hawksearch-search-within-facet>
            {{/if}}
            {{#if (eq type "size")}}
            <hawksearch-size-facet hawksearch-facet></hawksearch-size-facet>
            {{/if}}
        </div>
        {{/unless}}
    </div>
<?php }?>
{{else}}
<div class="facet">
    <div hawksearch-facet-heading class="facet__heading{{attribute ' facet__heading--collapsible' collapsible}}">
        {{title}}
        {{#if tooltip}}
        <hawksearch-tooltip text="{{tooltip}}"></hawksearch-tooltip>
        {{/if}}
        {{#if collapsible}}
        <hawksearch-icon name="{{if-else collapsed 'chevron-right' 'chevron-down'}}" size="1.5em" class="facet__heading__toggle"></hawksearch-icon>
        {{/if}}
    </div>
    {{#unless collapsed}}
    <div class="facet__content">
        {{#if searchable}}
        <input type="text" placeholder="Quick Lookup" hawksearch-facet-search value="{{filter}}" class="facet__search" />
        {{/if}}
        {{#if (eq type "checkbox")}}
        <hawksearch-checkbox-list-facet hawksearch-facet></hawksearch-checkbox-list-facet>
        {{/if}}
        {{#if (eq type "color")}}
        <hawksearch-color-facet hawksearch-facet></hawksearch-color-facet>
        {{/if}}
        {{#if (eq type "date-range")}}
        <hawksearch-date-range-facet hawksearch-facet></hawksearch-date-range-facet>
        {{/if}}
        {{#if (eq type "link")}}
        <hawksearch-link-list-facet hawksearch-facet></hawksearch-link-list-facet>
        {{/if}}
        {{#if (eq type "numeric-range")}}
        <hawksearch-numeric-range-facet hawksearch-facet></hawksearch-numeric-range-facet>
        {{/if}}
        {{#if (eq type "range-slider")}}
        <hawksearch-range-slider-facet hawksearch-facet></hawksearch-range-slider-facet>
        {{/if}}
        {{#if (eq type "recent-searches")}}
        <hawksearch-recent-searches-facet hawksearch-facet></hawksearch-recent-searches-facet>
        {{/if}}
        {{#if (eq type "related-searches")}}
        <hawksearch-related-searches-facet hawksearch-facet></hawksearch-related-searches-facet>
        {{/if}}
        {{#if (eq type "search")}}
        <hawksearch-search-within-facet hawksearch-facet></hawksearch-search-within-facet>
        {{/if}}
        {{#if (eq type "size")}}
        <hawksearch-size-facet hawksearch-facet></hawksearch-size-facet>
        {{/if}}
    </div>
    {{/unless}}
</div>
{{/if}}
