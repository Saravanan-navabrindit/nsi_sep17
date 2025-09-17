
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
			posts : select('core').getEntityRecords('postType', 'post', { per_page: -1 })
		}
	});

	let disallowedBlocks = [];
	const ALLOWED_BLOCKS = wp.blocks.getBlockTypes().map(block => block.name).filter(blockName => !disallowedBlocks.includes(blockName));

	const {
		openNewWindow,
		url,
		buttonLabel,
		videoID
	} = attributes	;
	
	let blockAtts = {
		className: className,
		...attributes
	};

	let blockClasses = [ className ];

	let blockStyle = {};

	// This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag
	let customProps = {
		className: blockClasses.join(' '),
		style: blockStyle,
		key: 'post-header'
	};

	return [

		<InspectorControls key="inspector-controls">
			<PanelBody title={ 'Optional Settings' } initialOpen={ true }>

				<ToggleControl
					label={ 'Open link in new window' }
					checked={ openNewWindow }
					onChange={ (value) => { setAttributes({ openNewWindow: value }); } }
				/>

				<TextControl
					label="URL"
					value={ url }
					onChange={ (value) => setAttributes({ url: value }) }
				/>

				<TextControl
					label="Button Label"
					value={ buttonLabel }
					onChange={ (value) => setAttributes({ buttonLabel: value }) }
				/>

				<TextControl
					label="Optional Video"
					value={ videoID }
					onChange={ (value) => setAttributes({ videoID: value }) }
				/>

			</PanelBody>
		</InspectorControls>,

		<div { ...useBlockProps( customProps) }>
			<div class="crown-block-editor-container">

				<ServerSideRender block="crown-blocks/post-header" attributes={ blockAtts } />
			</div>
		</div>
	];
}
