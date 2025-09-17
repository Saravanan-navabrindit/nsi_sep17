
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
 const { PanelBody, RadioControl, CheckboxControl, ColorPicker, RangeControl, FocalPointPicker, ToggleControl, TextControl, TextareaControl, SelectControl, Button, ButtonGroup, Icon, BaseControl } = wp.components;
 const { getColorObjectByColorValue } = wp.blockEditor;
 import ServerSideRender from '@wordpress/server-side-render';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit( { attributes, className, isSelected, setAttributes } ) {

	// const TEMPLATE = [
	// 	[ 'core/heading', { placeholder: 'Page Header Title...', level: 1 } ],
	// ];
	
	const {
		// textAlign,
	} = attributes;

	// This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag
	let customProps = {
		// className: blockClasses.join(' '),
		// style: blockStyle,
		key: 'member-benefit-table'
	};
	
	return [

		// <InspectorControls key="inspector-controls">

		// 	<PanelBody title={ 'Text Color' } initialOpen={ false }>

		// 		<ButtonGroup>
		// 			<Button isPrimary={ textColor == 'auto' } isSecondary={ textColor != 'auto' } onClick={ (e) => setAttributes({ textColor: 'auto' }) }>Auto</Button>
		// 			<Button isPrimary={ textColor == 'dark' } isSecondary={ textColor != 'dark' } onClick={ (e) => setAttributes({ textColor: 'dark' }) }>Dark</Button>
		// 			<Button isPrimary={ textColor == 'light' } isSecondary={ textColor != 'light' } onClick={ (e) => setAttributes({ textColor: 'light' }) }>Light</Button>
		// 		</ButtonGroup>

		// 	</PanelBody>

		// </InspectorControls>,
		
		<div class="crown-block-editor-container">
			<ServerSideRender block="crown-blocks/member-benefit-table" attributes={ attributes } />
		</div>
		
	];

}
