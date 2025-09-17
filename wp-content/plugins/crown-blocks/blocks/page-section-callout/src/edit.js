
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
		[ 'core/heading', { placeholder: 'Section Title...', level: 1 } ], // defaults to H1 tag for header block
		[ 'core/paragraph', {} ]
	];
	
	const {
		backgroundColor,
		backgroundImageId,
		backgroundImageData,
		backgroundImageFocalPoint,
		textColor
	} = attributes;

	let blockClasses = [ className ];

	if(textColor == 'auto' && backgroundColor) {
		blockClasses.push('text-color-' + (CrownBlocks.isDarkColor(backgroundColor) ? 'light' : 'dark'));
	} else if(textColor != 'auto') {
		blockClasses.push('text-color-' + textColor);
	}

	let backgroundImageUrl = null;
	if(backgroundImageId) {
		backgroundImageUrl = backgroundImageData.sizes.large ? backgroundImageData.sizes.large.url : backgroundImageData.url;
	}

	let contentsStyle = {};
	if(backgroundColor) {
		contentsStyle.backgroundColor = backgroundColor;
	}

	// This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag
	let customProps = {
		className: blockClasses.join(' '),
		key: 'page-section-callout'
	};

	return [

		<InspectorControls key="inspector-controls">

			<PanelColorSettings
				title={ 'Color' }
				initialOpen={ true }
				colorSettings={ [
					{
						label: 'Backgroound Color',
						value: backgroundColor,
						onChange: (value) => { setAttributes({ backgroundColor: value }); },
						disableCustomColors: false
					}
				] }
			/>

			<PanelBody title={ 'Background Image' } className={ 'crown-blocks-background-image' } initialOpen={ true }>

				{ !! backgroundImageId && <FocalPointPicker 
					label="Focal Point"
					url={ backgroundImageData.sizes.medium ? backgroundImageData.sizes.medium.url : backgroundImageData.sizes.thumbnail.url }
					dimensions={ { width: 400, height: 100 } }
					value={ backgroundImageFocalPoint }
					onChange={ (value) => setAttributes({ backgroundImageFocalPoint: value }) } 
				/> }

				<MediaUpload
					onSelect={ (media) => { setAttributes({ backgroundImageId: media.id, backgroundImageData: media, backgroundImageFocalPoint: { x: 0.5, y: 0.5 } }); } }
					type="image"
					value={ backgroundImageId }
					render={ ({ open }) => (
						<div className={ 'crown-blocks-media-upload' }>
							{/* { backgroundImageId && <Button className={ 'image-preview' } onClick={ open }><img src={ backgroundImageData.sizes.medium ? backgroundImageData.sizes.medium.url : backgroundImageData.sizes.thumbnail.url } /></Button> } */}
							<Button className={ 'button' } onClick={ open }>Select Image</Button>
							{ backgroundImageId && <Button className={ 'button is-link is-destructive' } onClick={ (e) => { setAttributes({ backgroundImageId: null, backgroundImageData: null }); } }>Remove Image</Button> }
						</div>
					) }
				/>

			</PanelBody>

			<PanelBody title={ 'Text Color' } initialOpen={ true }>

				<ButtonGroup>
					<Button isPrimary={ textColor == 'auto' } isSecondary={ textColor != 'auto' } onClick={ (e) => setAttributes({ textColor: 'auto' }) }>Auto</Button>
					<Button isPrimary={ textColor == 'dark' } isSecondary={ textColor != 'dark' } onClick={ (e) => setAttributes({ textColor: 'dark' }) }>Dark</Button>
					<Button isPrimary={ textColor == 'light' } isSecondary={ textColor != 'light' } onClick={ (e) => setAttributes({ textColor: 'light' }) }>Light</Button>
				</ButtonGroup>

			</PanelBody>

		</InspectorControls>,

		<div { ...useBlockProps( customProps ) }>
			<div class="inner">
				{ backgroundImageUrl && <div className={ 'callout-image' }>
					<img src={ backgroundImageUrl } style={ { objectPosition: `${ backgroundImageFocalPoint.x * 100 }% ${ backgroundImageFocalPoint.y * 100 }%` } } />
				</div> }
				<div class="callout-contents" style={ contentsStyle }>
					<div class="inner">
						<InnerBlocks template={ TEMPLATE } />
					</div>
				</div>
			</div>
		</div>

	];
	
}
