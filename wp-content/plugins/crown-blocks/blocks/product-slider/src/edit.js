
/**
 * Import Crown helper functions
 */
 import CrownBlocks from '../../../common.js';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
 */
import { useBlockProps } from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * Import required components for editing
 */
 const { __ } = wp.i18n;
 const { registerBlockType } = wp.blocks;
 const { InnerBlocks, RichText, MediaUpload, BlockControls, AlignmentToolbar, InspectorControls, PanelColorSettings } = wp.blockEditor;
 const { PanelBody, RadioControl, CheckboxControl, ColorPicker, RangeControl, FocalPointPicker, ToggleControl, TextControl, TextareaControl, SelectControl, Button, ButtonGroup, Icon, BaseControl, FormTokenField } = wp.components;
 const { getColorObjectByColorValue } = wp.blockEditor;

 import ServerSideRender from '@wordpress/server-side-render';

 import { withSelect } from '@wordpress/data';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */

export default function Edit({ attributes, className, isSelected, setAttributes } ) {

	const {
		maxPostCount,
		manuallySelectPosts,
		excludePrevPosts,
		filterCategories,
		filterBrands,
		filterPostsExclude,
		filterPostsInclude,
		filterPostSkusInclude
	} = attributes;
	
	let blockAtts = {
		className: className,
	};
	let blockClasses = [ className ];

	let blockStyle = {};

	let customProps = {
		className: blockClasses.join(' '),
		style: blockStyle,
		key: 'product-slider'
	};

	return [

		<InspectorControls key="inspector-controls">

			<PanelBody title={ 'Appearance' } initialOpen={ true }>

				<SelectControl
					label="Max number of products to display"
					value={ maxPostCount }
					onChange={ (value) => setAttributes({ maxPostCount: value }) }
					options={ [
						{ label: '4', value: '4' },
						{ label: '8', value: '8' },
						{ label: '12', value: '12' },
						{ label: '16', value: '16' },
						{ label: '20', value: '20' },
						{ label: '24', value: '24' }
					] }
				/>

			</PanelBody>

			<PanelBody title={ 'Filtering Options' } initialOpen={ true }>

				<ToggleControl
					label={ 'Manually select products' }
					checked={ manuallySelectPosts }
					onChange={ (value) => { setAttributes({ manuallySelectPosts: value }); } }
				/>

				{/* { !! !manuallySelectPosts && <ToggleControl
					label={ 'Exclude posts featured in other recent post feeds above this on the page (note: does not affect output in editor)' }
					checked={ excludePrevPosts }
					onChange={ (value) => { setAttributes({ excludePrevPosts: value }); } }
				/> } */}

				{/* { !! !manuallySelectPosts && <FormTokenField 
					label="Filter by Category"
					value={ filterCategories } 
					suggestions={ categorySuggestions } 
					onChange={ (tokens) => {
						let matchedTokens = [];
						for(let i in tokens) {
							let token = typeof tokens[i] === 'string' ? tokens[i] : (tokens[i].value ? tokens[i].value : '');
							if(categorySuggestions.includes(token)) {
								matchedTokens.push(token);
							}
						}
						let filterCategories = [];
						for(let i in matchedTokens) {
							if(availableCategories[matchedTokens[i]]) {
								filterCategories.push({ value: matchedTokens[i], id: availableCategories[matchedTokens[i]].id });
							}
						}
						setAttributes({ filterCategories: filterCategories })
					} }
					placeholder="Search categories..."
				/> } */}

				{ !! !manuallySelectPosts && <TextControl
					label="Filter by Category"
					help="Provide a comma-separated list of category names."
					value={ filterCategories }
					onChange={ (value) => setAttributes({ filterCategories: value }) }
				/> }

				{ !! !manuallySelectPosts && <TextControl
					label="Filter by Brand"
					help="Provide a comma-separated list of brand names."
					value={ filterBrands }
					onChange={ (value) => setAttributes({ filterBrands: value }) }
				/> }

				{/* { !! !manuallySelectPosts && <FormTokenField 
					label="Exclude Specific Posts from Feed"
					value={ filterPostsExclude } 
					suggestions={ postsExcludeSuggestions } 
					onChange={ (tokens) => {
						let matchedTokens = [];
						for(let i in tokens) {
							let token = typeof tokens[i] === 'string' ? tokens[i] : (tokens[i].value ? tokens[i].value : '');
							if(postsExcludeSuggestions.includes(token)) {
								matchedTokens.push(token);
							}
						}
						let filterPostsExclude = [];
						for(let i in matchedTokens) {
							if(availablePostsExclude[matchedTokens[i]]) {
								filterPostsExclude.push({ value: matchedTokens[i], id: availablePostsExclude[matchedTokens[i]].id });
							}
						}
						setAttributes({ filterPostsExclude: filterPostsExclude })
					} }
					placeholder="Search posts..."
				/> } */}

				{/* { !! manuallySelectPosts && <FormTokenField 
					label="Select which products to display (add in desired order)"
					value={ filterPostsInclude } 
					suggestions={ postsIncludeSuggestions } 
					onChange={ (tokens) => {
						let matchedTokens = [];
						for(let i in tokens) {
							let token = typeof tokens[i] === 'string' ? tokens[i] : (tokens[i].value ? tokens[i].value : '');
							if(postsIncludeSuggestions.includes(token)) {
								matchedTokens.push(token);
							}
						}
						let filterPostsInclude = [];
						for(let i in matchedTokens) {
							if(availablePostsInclude[matchedTokens[i]]) {
								filterPostsInclude.push({ value: matchedTokens[i], id: availablePostsInclude[matchedTokens[i]].id });
							}
						}
						setAttributes({ filterPostsInclude: filterPostsInclude })
					} }
					placeholder="Search posts..."
				/> } */}

				{ !! manuallySelectPosts && <TextControl
					label="Product SKUs to Display"
					help="Provide a comma-separated list of SKUs in the order in which to display."
					value={ filterPostSkusInclude }
					onChange={ (value) => setAttributes({ filterPostSkusInclude: value }) }
				/> }

			</PanelBody>

		</InspectorControls>,

		<div { ...useBlockProps( customProps ) }>
			<ServerSideRender block="crown-blocks/product-slider" attributes={ attributes } />
		</div>

	];
}
