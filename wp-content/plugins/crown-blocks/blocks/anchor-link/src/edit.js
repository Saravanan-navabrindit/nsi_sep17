
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
const { InnerBlocks, RichText, MediaUpload, BlockControls, AlignmentToolbar, InspectorControls, PanelColorSettings } = wp.blockEditor;
const { PanelBody, RadioControl, ColorPicker, RangeControl, FocalPointPicker, ToggleControl, TextControl, TextareaControl, SelectControl, Button, ButtonGroup, Icon, BaseControl } = wp.components;
const { getColorObjectByColorValue } = wp.blockEditor;
const { useSelect, dispatch, select } = wp.data;

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit( { attributes, className, isSelected, setAttributes, clientId } ) {

	const ALLOWED_BLOCKS = [ 'crown-blocks/anchor-link-content' ];

	const TEMPLATE = [
		[ 'crown-blocks/anchor-link-content', {}, [
			[ 'core/paragraph', { placeholder: 'Enter link content...' } ]
		] ]
	];
	
	const {
		fullWidth,
		// backgroundColor,
		// textColor,
		tabsHtml,
		tabsSelectHtml
	} = attributes;

	// Pass specific attributes down to child blocks and get tabs content
	let tabs = [];
	let tabsSelectOptions = [];
	let tabbedContentBlockObject = select('core/block-editor').getBlocksByClientId(clientId)[0];
	if ( tabbedContentBlockObject ) {
		tabbedContentBlockObject.innerBlocks.forEach(function (block, index, blocks ) {
			// send attributes down to children
			// dispatch('core/block-editor').updateBlockAttributes(block.clientId, { backgroundColor: backgroundColor });

			// add html needed for tab panel nav menu
			let tab_content = '';
			if ( block.attributes.iconData ) tab_content += '<div class="tab-icon"><img src="' + ( block.attributes.iconData.sizes ? block.attributes.iconData.sizes.thumbnail.url : block.attributes.iconData.url ) + '" /></div>';
			tab_content += '<div class="tab-content">';
				if ( block.attributes.title ) tab_content += '<h4 class="title">' + block.attributes.title + '</h4>';
				if ( block.attributes.description ) tab_content += '<div class="description">' + block.attributes.description + '</div>';
			tab_content += '</div>';
			if ( block.attributes.link ) {
				tabs.push( '<a class="tab" href="' + block.attributes.link + '"><div class="inner">' + tab_content + '</div></a>' );
			} else {
				tabs.push( '<div class="tab ' + ( index === 0 ? 'active' : '' ) + '" data-index="'+ index +'" ><div class="inner">' + tab_content + '</div></div>' );
			}

			// add options for tabs select input dropdown (mobile)
			tabsSelectOptions.push( '<option value="' + index + '">' + ( block.attributes.title ? block.attributes.title : 'Tab ' + (index + 1) ) + '</option>' );
		});
	}
	setAttributes( {
		tabsHtml: tabs.join(''),
		tabsSelectHtml: tabsSelectOptions.join('')
	} );

	let blockClasses = [ className ];

	if ( fullWidth ) {
		blockClasses.push('full-width');
	}

	// if (textColor == 'auto') {
	// 	blockClasses.push('active-text-color-' + (CrownBlocks.isDarkColor(backgroundColor) ? 'light' : 'dark'));
	// } else if (textColor != 'auto') {
	// 	blockClasses.push('active-text-color-' + textColor);
	// }

	let blockStyle = {};

	let panelsStyle = {};
	// if (backgroundColor) {
	// 	panelsStyle.backgroundColor = backgroundColor;
	// }

	// let bgColorSettings = [{
	// 	label: 'Background Color',
	// 	value: backgroundColor,
	// 	onChange: (value) => setAttributes({ backgroundColor: value ? value : '' })
	// }];

	// This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag
	let customProps = {
		className: blockClasses.join(' '),
		style: blockStyle,
		key: 'tabbed-content'
	};

	return [

		<InspectorControls key="inspector-controls">

			{/* <PanelColorSettings
				title={ 'Background Color' }
				initialOpen={ false }
				colorSettings={ bgColorSettings }
			/> */}

		</InspectorControls>,

		<div { ...useBlockProps( customProps ) }>
			<div className="inner">

				<label>Tabs Preview</label>
				<div className="tabs" dangerouslySetInnerHTML={ {__html: tabsHtml} }></div>
				{/* <select className="tabs-select" dangerouslySetInnerHTML={ {__html: tabsSelectHtml} }></select> */}

				<label>Block Content</label>
				<div className="panels" style={ panelsStyle }>
					<InnerBlocks allowedBlocks={ ALLOWED_BLOCKS } template={ TEMPLATE } />
				</div>
				
			</div>
		</div>

	];
	
}
