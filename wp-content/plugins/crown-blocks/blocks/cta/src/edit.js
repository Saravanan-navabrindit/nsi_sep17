
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
const { PanelBody, RadioControl, CheckboxControl, ColorPicker, RangeControl, FocalPointPicker, ToggleControl, TextControl, TextareaControl, SelectControl, Button, ButtonGroup, Icon, BaseControl } = wp.components;
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

	const TEMPLATE = [
		[ 'core/heading', {level: 3} ],
		[ 'core/paragraph', {} ],
		[ 'crown-blocks/button', {type: 'outline'} ]
	];

	const {
		imageId,
		imageData,
		backgroundColor,
		textColor,
		reverseImageSlant,
		align
	} = attributes;

	let blockClasses = [ className ];

	if(textColor == 'auto' && backgroundColor) {
		blockClasses.push('text-color-' + (CrownBlocks.isDarkColor(backgroundColor, 0.45) ? 'light' : 'dark'));
	} else if(textColor != 'auto') {
		blockClasses.push('text-color-' + textColor);
	}

	let blockStyle = {};
	if(backgroundColor) {
		blockStyle.backgroundColor = backgroundColor;
		let settings = wp.data.select('core/editor').getEditorSettings();
		if(settings.colors) {
			let colorObject = getColorObjectByColorValue(settings.colors, backgroundColor);
			if(colorObject) blockClasses.push('bg-color-' + colorObject.slug);
		}
	}

	let imageUrl = null;
	if(imageId) {
		imageUrl = imageData.sizes && imageData.sizes.large ? imageData.sizes.large.url : imageData.url;
		blockClasses.push('has-preview-image');
	}

	if ( reverseImageSlant ) {
		blockClasses.push('reverse-image-slant');
	}

	if ( align ) {
		blockClasses.push('align-' + align);
	}

	let bgColorSettings = [{
		label: 'Background Color',
		value: backgroundColor,
		onChange: (value) => setAttributes({ backgroundColor: value ? value : '' })
	}];

	// This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag
	let customProps = {
		className: blockClasses.join(' '),
		style: blockStyle,
		key: 'cta'
	};

	return [

		<InspectorControls key="inspector-controls">

			<PanelColorSettings
				title={ 'Background Color' }
				initialOpen={ false }
				colorSettings={ bgColorSettings }
			/>

			<PanelBody title={ 'Background Image' } className={ 'crown-blocks-background-image' } initialOpen={ false }>

				<MediaUpload
					onSelect={ (media) => { setAttributes({ imageId: media.id, imageData: media }); } }
					type="image"
					value={ imageId }
					render={ ({ open }) => (
						<div className={ 'crown-blocks-media-upload' }>
							{ imageId && <Button className={ 'image-preview' } onClick={ open }><img src={ imageData.sizes && imageData.sizes.thumbnail ? imageData.sizes.thumbnail.url : imageData.url } /></Button> }
							<Button className={ 'button' } onClick={ open }>Select Background Image</Button>
							{ imageId && <Button className={ 'button is-link is-destructive' } onClick={ (e) => { setAttributes({ imageId: null, imageData: null }); } }>Remove Background Image</Button> }
						</div>
					) }
				/>

				<ToggleControl
					label={ 'Reverse Image Slant' }
					checked={ reverseImageSlant }
					onChange={ (value) => { setAttributes({ reverseImageSlant: value }); } }
				/>

			</PanelBody>

			<PanelBody title={ 'Alignment Settings' } initialOpen={ false }>
				<SelectControl
					value={ align }
					onChange={ (value) => setAttributes({ align: value }) }
					options={ [
						{ label: 'Left', value: 'left' },
						{ label: 'Center', value: 'center' }
					] }
				/>
			</PanelBody>

		</InspectorControls>,

		<div { ...useBlockProps( customProps ) }>
			<div className="inner">

				{ imageUrl && <div className="cta__background-image" style={ { backgroundImage: 'url(' + imageUrl + ')' } }></div> }

				<div className="cta__content">
					<InnerBlocks template={ TEMPLATE } />
				</div>

			</div>
		</div>

	];
	
}
