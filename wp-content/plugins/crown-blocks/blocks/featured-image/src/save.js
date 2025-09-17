
/**
 * Import Crown helper functions
 */
 import CrownBlocks from '../../../common.js';

/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
 */
import { useBlockProps } from '@wordpress/block-editor';

/**
 * Import required components for saving
 */
const { InnerBlocks, RichText } = wp.blockEditor;
const { getColorObjectByColorValue } = wp.blockEditor;

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#save
 *
 * @return {WPElement} Element to render.
 */
export default function save( { attributes, className } ) {

	const {
		textAlign,
		contentAlign,
		contentAlignVertical,
		// restrictContentWidth,
		// contentsMaxWidth,

		backgroundColor,
		backgroundImageId,
		backgroundImageData,
		backgroundImageFocalPoint,
		backgroundImageOpacity,
		backgroundImageGrayscale,
		backgroundImageBlendMode,
		backgroundImageContain,
		backgroundPosition,
		textColor
	} = attributes;

	let blockClasses = [ className ];

	let contentStyle = {};
	let contentBgClass = ['section-bg'];

	// if ( restrictContentWidth ) {
	// 	contentStyle.maxWidth = contentsMaxWidth + 'px';
	// }

	if ( contentAlign ) {
		blockClasses.push('content-align-' + contentAlign);
	}
	if ( contentAlignVertical ) {
		blockClasses.push('content-align-vertical-' + contentAlignVertical);
	}

	if ( backgroundPosition ) {
		blockClasses.push('bg-position-' + backgroundPosition);
	} 

	if ( textAlign ) {
		blockClasses.push('text-align-' + textAlign);
	}

	if(textColor == 'auto' && backgroundColor) {
		blockClasses.push('text-color-' + (CrownBlocks.isDarkColor(backgroundColor) ? 'light' : 'dark'));
	} else if(textColor != 'auto') {
		blockClasses.push('text-color-' + textColor);
	}

	let blockStyle = {};
	if(backgroundColor) {
		contentStyle.backgroundColor = backgroundColor;
		let settings = wp.data.select('core/editor').getEditorSettings();
		if(settings.colors) {
			let colorObject = getColorObjectByColorValue(settings.colors, backgroundColor);
			if(colorObject) contentBgClass.push('bg-color-' + colorObject.slug);
		}
	}

	let backgroundImageUrl = null;
	if(backgroundImageId) {
		backgroundImageUrl = backgroundImageData.sizes.fullscreen ? backgroundImageData.sizes.fullscreen.url : backgroundImageData.url;
		blockClasses.push('has-bg-image');
	}

	// This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag
	let customProps = {
		className: blockClasses.join(' '),
		style: blockStyle,
		key: 'page-section'
	};
	
	return (

		<div { ...useBlockProps.save( customProps ) }>
			<div className="section-bg">
				{ backgroundImageUrl && <div className={ 'bg-image' } style={ {
					backgroundImage: 'url(' + backgroundImageUrl + ')',
					opacity: (backgroundImageOpacity / 100),
					backgroundPosition: `${ backgroundImageFocalPoint.x * 100 }% ${ backgroundImageFocalPoint.y * 100 }%`,
					filter: `grayscale(${ backgroundImageGrayscale / 100 })`,
					mixBlendMode: backgroundImageBlendMode,
					backgroundSize: backgroundImageContain ? 'contain' : 'cover'
				} }>
				</div> }

			</div>
			<div className="section-content">
				<div className="inner">
					<div className={contentBgClass.join(' ')}  style={ contentStyle }></div>
					<div className="container">
						<InnerBlocks.Content />
					</div>
				</div>
			</div>
		</div>

	);

}
