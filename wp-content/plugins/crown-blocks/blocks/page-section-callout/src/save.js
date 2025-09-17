
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
	
	return (

		<div { ...useBlockProps.save( customProps ) }>
			<div class="inner">
				{ backgroundImageUrl && <div className={ 'callout-image' }>
					<img src={ backgroundImageUrl } style={ { objectPosition: `${ backgroundImageFocalPoint.x * 100 }% ${ backgroundImageFocalPoint.y * 100 }%` } } />
				</div> }
				<div class="callout-contents" style={ contentsStyle }>
					<div class="inner">
						<InnerBlocks.Content />
					</div>
				</div>
			</div>
		</div>

	);

}
