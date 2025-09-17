
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
		fullWidth,
		contentAlign,
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

	let bgColorSettings = [{
		label: 'Background Color',
		value: backgroundColor,
		onChange: (value) => setAttributes({ backgroundColor: value ? value : '' })
	}];

	if ( reverseImageSlant ) {
		blockClasses.push('reverse-image-slant');
	}

	if ( align ) {
		blockClasses.push('align-' + align);
	}

	// This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag
	let customProps = {
		className: blockClasses.join(' '),
		style: blockStyle,
		key: 'cta'
	};
	
	return (

		<div { ...useBlockProps.save( customProps ) }>
			<div className="inner">

				{ imageUrl && <div className="cta__background-image" style={ { backgroundImage: 'url(' + imageUrl + ')' } }></div> }

				<div className="cta__content">
					<InnerBlocks.Content />
				</div>

			</div>
		</div>

	);

}
