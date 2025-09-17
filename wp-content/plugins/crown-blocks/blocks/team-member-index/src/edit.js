
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

 import blockConfig from '../block.json';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */

export default function Edit({ attributes, className, isSelected, setAttributes }) {
	
	const {
		includeDepartments,
		excludeDepartments
	} = attributes;
	
	let blockAtts = {
		className: className,
	};
	let blockClasses = [ className ];

	let blockStyle = {};

	let customProps = {
		className: blockClasses.join(' '),
		style: blockStyle,
		key: blockConfig.name
	};

	return [
		<InspectorControls key="inspector-controls">

			<PanelBody title={ 'Settings' } initialOpen={ true }>

				<TextControl
					label="Include Departments"
					help="Comma-separated list of departments to only include."
					value={ includeDepartments }
					onChange={ ( value ) => setAttributes( { includeDepartments: value } ) }
					placeholder=""
				/>

				<TextControl
					label="Exclude Departments"
					help="Comma-separated list of departments to exclude."
					value={ excludeDepartments }
					onChange={ ( value ) => setAttributes( { excludeDepartments: value } ) }
					placeholder=""
				/>

			</PanelBody>

		</InspectorControls>,
		<div { ...useBlockProps( customProps ) }>
			<ServerSideRender block={ blockConfig.name } attributes={ attributes } />
		</div>
	];
}
