
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


/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit( { attributes, className, isSelected, setAttributes } ) {

	const {
		title,
		description
	} = attributes;

	let blockClasses = [
		className
	];

	// This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag
	let customProps = {
		className: blockClasses.join(' '),
		key: 'tabbed-content-tab'
	};

	return [

		<div { ...useBlockProps( customProps ) }>
			<div className="inner">

				<header class="tab-header">
					
					<RichText
						tagName="h3"
						className="tab-title"
						onChange={ (value) => setAttributes({ title: value }) } 
						value={ title }
						placeholder="Tab Title"
						allowedFormats={ [] }
					/>

					<RichText
						tagName="p"
						className="tab-description"
						onChange={ (value) => setAttributes({ description: value }) } 
						value={ description }
						placeholder="Optional Description"
						allowedFormats={ [] }
					/>

				</header>

				<div className="tab-contents">
					<div className="inner">

						<InnerBlocks />

					</div>
				</div>

			</div>
		</div>

	];
	
}
