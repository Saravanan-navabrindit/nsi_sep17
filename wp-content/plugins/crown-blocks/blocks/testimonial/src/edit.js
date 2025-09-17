
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
 const { registerBlockType } = wp.blocks;
 const { InnerBlocks, RichText, Editable, MediaUpload, BlockControls, AlignmentToolbar, InspectorControls, PanelColorSettings, URLInput } = wp.blockEditor;
 const { PanelBody, RadioControl, ColorPicker, Button, ButtonGroup, RangeControl, FocalPointPicker, ToggleControl, TextControl, TextareaControl, SelectControl } = wp.components;


/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit( { attributes, className, isSelected, setAttributes, clientId } ) {

	const ALLOWED_BLOCKS = [ 'core/paragraph' ];

	const TEMPLATE = [
		[ 'core/paragraph', {}, [] ]
	];
	
	const {
		textAlign,
		sourceName,
		sourceTitle,
		blockId,
		headshotImageId,
		headshotImageData,
		headshotImageFocalPoint
	} = attributes;

	setAttributes({ blockId: clientId });
	
	let blockClasses = [
		className
	];

	if ( textAlign ) {
		blockClasses.push('text-align-' + textAlign);
	}

	let headshotImageUrl = null;
	if(headshotImageId) {
		headshotImageUrl = headshotImageData.sizes.large ? headshotImageData.sizes.large.url : headshotImageData.url;
		blockClasses.push('has-headshot-image');
	}

	// This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag
	let customProps = {
		className: blockClasses.join(' '),
		key: 'testimonial'
	};
	
	return [

		<InspectorControls key="inspector-controls">

			<PanelBody title={ 'Headshot Image' } className={ 'crown-blocks-background-image' } initialOpen={ true }>

				{ !! headshotImageId && <FocalPointPicker 
					label="Focal Point"
					url={ headshotImageData.sizes.medium ? headshotImageData.sizes.medium.url : headshotImageData.url }
					dimensions={ { width: 400, height: 100 } }
					value={ headshotImageFocalPoint }
					onChange={ (value) => setAttributes({ headshotImageFocalPoint: value }) } 
				/> }

				<MediaUpload
					onSelect={ (media) => { setAttributes({ headshotImageId: media.id, headshotImageData: media, headshotImageFocalPoint: { x: 0.5, y: 0.5 } }); } }
					type="image"
					value={ headshotImageId }
					render={ ({ open }) => (
						<div className={ 'crown-blocks-media-upload' }>
							<Button className={ 'button' } onClick={ open }>Select Image</Button>
							{ headshotImageId && <Button className={ 'button is-link is-destructive' } onClick={ (e) => { setAttributes({ headshotImageId: null, headshotImageData: null }); } }>Remove Image</Button> }
						</div>
					) }
				/>

			</PanelBody>

		</InspectorControls>,

		<div { ...useBlockProps( customProps ) }>
			<div className="inner">

				{ headshotImageUrl && <div className="testimonial__headshot">
					<img src={ headshotImageUrl } style={ { backgroundPosition: `${ headshotImageFocalPoint.x * 100 }% ${ headshotImageFocalPoint.y * 100 }%` } } />
				</div> }

				<div className="testimonial__quote">
					<div className="inner">
						<InnerBlocks allowedBlocks={ ALLOWED_BLOCKS } template={ TEMPLATE } />
					</div>
				</div>

				<footer className="testimonial__source">
					<div className="inner">
						<div className="testimonial__source-details">
							<RichText
								tagName="p"
								className="testimonial__source-name"
								onChange={ (value) => setAttributes({ sourceName: value }) } 
								value={ sourceName }
								placeholder="Source Name"
								allowedFormats={ [] }
							/>

							<RichText
								tagName="p"
								className="testimonial__source-title"
								onChange={ (value) => setAttributes({ sourceTitle: value }) } 
								value={ sourceTitle }
								placeholder="Title/Company"
								allowedFormats={ [] }
							/>
						</div>
							
					</div>
				</footer>

			</div>
			
		</div>
		
	];
	
}
