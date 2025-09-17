
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
const { PanelBody, FocalPointPicker, RangeControl, ToggleControl, TextControl, SelectControl, Button, ButtonGroup, Icon, BaseControl } = wp.components;
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
		[ 'core/paragraph', {} ]
	];

	const {
		contentAlign,
		backgroundImageId,
		backgroundImageData,
		backgroundImageFocalPoint,
		backgroundImageOpacity,
		backgroundImageGrayscale,
		backgroundImageBlendMode,
		backgroundImageContain,
		backgroundColor,
		textColor,
	} = attributes;

	let blockClasses = [ className ];

	if ( contentAlign ) {
		blockClasses.push('content-align-' + contentAlign);
	}

	if(textColor == 'auto' && backgroundColor) {
		blockClasses.push('text-color-' + (CrownBlocks.isDarkColor(backgroundColor) ? 'light' : 'dark'));
	} else if(textColor != 'auto') {
		blockClasses.push('text-color-' + textColor);
	}

	let blockStyle = {};
	if(backgroundColor) {
		// blockStyle.backgroundColor = backgroundColor;
		let settings = wp.data.select('core/editor').getEditorSettings();
		if(settings.colors) {
			let colorObject = getColorObjectByColorValue(settings.colors, backgroundColor);
			if(colorObject) blockClasses.push('bg-color-' + colorObject.slug);
		}
	}

	let backgroundImageUrl = null;
	if(backgroundImageId) {
		backgroundImageUrl = backgroundImageData.sizes.fullscreen ? backgroundImageData.sizes.fullscreen.url : backgroundImageData.url;
		blockClasses.push('has-bg-image');
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
		key: 'image-cta'
	};

	return [

		<InspectorControls key="inspector-controls">

			<PanelColorSettings
				title={ 'Background Color' }
				initialOpen={ false }
				colorSettings={ bgColorSettings }
			/>

			<PanelBody title={ 'Background Image' } className={ 'crown-blocks-background-image' } initialOpen={ false }>

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

				{ !! backgroundImageId && <RangeControl
					label="Opacity"
					value={ backgroundImageOpacity }
					onChange={ (value) => setAttributes({ backgroundImageOpacity: value }) }
					min={ 0 }
					max={ 100 }
				/> }

				{ !! backgroundImageId && <RangeControl
					label="Grayscale"
					value={ backgroundImageGrayscale }
					onChange={ (value) => setAttributes({ backgroundImageGrayscale: value }) }
					min={ 0 }
					max={ 100 }
				/> }

				{ !! backgroundImageId && <SelectControl
					label="Blend Mode"
					value={ backgroundImageBlendMode }
					onChange={ (value) => setAttributes({ backgroundImageBlendMode: value }) }
					options={ [
						{ label: 'Normal', value: 'normal' },
						{ label: 'Multiply', value: 'multiply' },
						{ label: 'Screen', value: 'screen' },
						{ label: 'Overlay', value: 'overlay' },
						{ label: 'Soft Light', value: 'soft-light' },
						{ label: 'Hard Light', value: 'hard-light' },
						{ label: 'Darken', value: 'darken' },
						{ label: 'Lighten', value: 'lighten' }
					] }
				/> }

				{ !! backgroundImageId && <ToggleControl
					label={ 'Contain background image' }
					checked={ backgroundImageContain }
					onChange={ (value) => { setAttributes({ backgroundImageContain: value }); } }
				/> }

			</PanelBody>

			<PanelBody title={ 'Text Settings' } initialOpen={ false }>

				<BaseControl label={ 'Text Color' }>
					<ButtonGroup>
						<Button isPrimary={ textColor == 'auto' } isSecondary={ textColor != 'auto' } onClick={ (e) => setAttributes({ textColor: 'auto' }) }>Auto</Button>
						<Button isPrimary={ textColor == 'dark' } isSecondary={ textColor != 'dark' } onClick={ (e) => setAttributes({ textColor: 'dark' }) }>Dark</Button>
						<Button isPrimary={ textColor == 'light' } isSecondary={ textColor != 'light' } onClick={ (e) => setAttributes({ textColor: 'light' }) }>Light</Button>
					</ButtonGroup>
				</BaseControl>

			</PanelBody>

		</InspectorControls>,

		<BlockControls>
			<AlignmentToolbar
				value={ contentAlign }
				onChange={(value) => setAttributes({ contentAlign: value })}
				alignmentControls={ [{
					icon: 'align-right',
					title: 'Align content left',
					align: 'left'
				  }, {
					icon: 'align-left',
					title: 'Align content right',
					align: 'right'
				}] }
			/>
		</BlockControls>,

		<div { ...useBlockProps( customProps ) }>
			<div className="section-bg">
				{ backgroundImageUrl && <div className={ 'bg-image' } style={ {
					backgroundImage: 'url(' + backgroundImageUrl + ')',
					opacity: (backgroundImageOpacity / 100),
					backgroundPosition: `${ backgroundImageFocalPoint.x * 100 }% ${ backgroundImageFocalPoint.y * 100 }%`,
					filter: `grayscale(${ backgroundImageGrayscale / 100 })`,
					mixBlendMode: backgroundImageBlendMode,
					backgroundSize: backgroundImageContain ? 'contain' : 'cover'
				} }></div> }
			</div>
			<div className="inner" style={ { backgroundColor: backgroundColor } }>

				<InnerBlocks template={ TEMPLATE } />
				
			</div>
		</div>

	];
	
}
