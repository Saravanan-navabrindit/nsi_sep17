
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
		enableNewsCTA,
		newsCTALink
	} = attributes;
	
	let blockAtts = {
		className: className,
	};
	let blockClasses = [ className ];

	let blockStyle = {};

	let customProps = {
		className: blockClasses.join(' '),
		style: blockStyle,
		key: 'latest-news-article'
	};

	return [
		<InspectorControls key="inspector-controls">
			<PanelBody title={ 'Appearance' } className={ 'crown-blocks-appearance' } initialOpen={ false }>

				<ToggleControl
					label={ 'Enable More News CTA' }
					checked={ enableNewsCTA }
					onChange={ (value) => { setAttributes({ enableNewsCTA: value }); } }
				/>

				{ !! enableNewsCTA && <TextControl
					label="More News CTA Link Override"
					help="Defaults to news index page if left blank."
					value={ newsCTALink }
					onChange={ ( value ) => setAttributes( { newsCTALink: value } ) }
					placeholder="https://"
				/> }

			</PanelBody>

		</InspectorControls>,
		<div { ...useBlockProps( customProps ) }>
			<ServerSideRender block="crown-blocks/latest-news-article" attributes={ attributes } />
		</div>
	];
}
