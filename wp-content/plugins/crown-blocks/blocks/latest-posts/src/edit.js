
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

export default function Edit({ posts, attributes, className, isSelected, setAttributes } ) {
	withSelect(function(select) {
		return {
			posts : select('core').getEntityRecords('postType', 'post', { per_page: -1 }),
			categories: select('core').getEntityRecords('taxonomy', 'category', { per_page: -1 }),
		}
	});

	const topics = wp.data.select('core').getEntityRecords('taxonomy', 'category', { per_page: -1, hide_empty: false });

	let topicOptions = [{
		value: 0, label: 'All Topics'
	}];
	if ( topics ) {
		topics.forEach(term => {
			topicOptions.push( {value: term.id, label: term.name} );
		});
	}

	let disallowedBlocks = [];
	const ALLOWED_BLOCKS = wp.blocks.getBlockTypes().map(block => block.name).filter(blockName => !disallowedBlocks.includes(blockName));

	const {
		topic
	} = attributes	;
	
	let blockAtts = {
		className: className,
	};
	let blockClasses = [ className ];

	let blockStyle = {};

	// This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag
	let customProps = {
		className: blockClasses.join(' '),
		style: blockStyle,
		key: 'latest-posts'
	};

	return [
		<InspectorControls key="inspector-controls">

		<PanelBody title={ 'Categories' } className={ 'crown-blocks-post-options' } initialOpen={ true }>
		<SelectControl
			label="Topic"
			value={ topic }
			onChange={ (value) => setAttributes({ topic: value }) }
			options={ topicOptions }
		/>
		</PanelBody>

		</InspectorControls>,
		<div class="crown-block-editor-container">

			<ServerSideRender block="crown-blocks/latest-posts" attributes={ attributes } />

		</div>
	];
}
