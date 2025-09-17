
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
		title,
		linkType,
		linkFileId,
		linkFileData,
		linkUrl,
		linkPost,
		linkOpenInNewWindow,
		isStyleOutline,
		backgroundColor,
		backgroundImageId,
		backgroundImageData,
		backgroundImageFocalPoint,
		backgroundImageOpacity,
		textColor
	} = attributes;

	let blockClasses = [ className ];

	if(textColor == 'auto' && backgroundColor) {
		blockClasses.push('text-color-' + (CrownBlocks.isDarkColor(backgroundColor) ? 'light' : 'dark'));
	} else if(textColor != 'auto') {
		blockClasses.push('text-color-' + textColor);
	}

	let blockStyle = {};
	let bgStyle = {};
	let outlineStyle = {};
	if(isStyleOutline) {
		blockClasses.push('is-style-outline');
		if(backgroundColor) {
			blockStyle.color = backgroundColor;
			outlineStyle.borderColor = backgroundColor;
		}
	}
	if(backgroundColor) {
		bgStyle.backgroundColor = backgroundColor;
	}

	let backgroundImageUrl = null;
	if(backgroundImageId) {
		backgroundImageUrl = backgroundImageData.sizes.fullscreen ? backgroundImageData.sizes.fullscreen.url : backgroundImageData.url;
		blockClasses.push('has-bg-image');
	}

	let blockLink = linkUrl;
	let blockLinkOpenInNewWindow = linkOpenInNewWindow;
	if(linkType == 'file') {
		blockLink = linkFileData ? linkFileData.url : '';
		blockLinkOpenInNewWindow = true;
	}

	// This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag
	let customProps = {
		className: blockClasses.join(' '),
		style: blockStyle,
		key: 'portal-link'
	};
	
	return (
		<div { ...useBlockProps.save( customProps ) }>
			<a class="link" href={ blockLink } target={ blockLinkOpenInNewWindow && '_blank' } rel={ blockLinkOpenInNewWindow && 'noopener noreferrer' }>
				<div className="link-bg" style={ bgStyle }>
					{ backgroundImageUrl && <div className={ 'bg-image' } style={ {
						backgroundImage: 'url(' + backgroundImageUrl + ')',
						opacity: (backgroundImageOpacity / 100),
						backgroundPosition: `${ backgroundImageFocalPoint.x * 100 }% ${ backgroundImageFocalPoint.y * 100 }%`
					} }></div> }
				</div>
				{ isStyleOutline && <div class="link-outline" style={ outlineStyle }></div> }
				<div class="inner">
					<div className="link-contents">

						<header class="link-header">
							{ !! title && <RichText.Content tagName="h3" className="link-title" value={ title } /> }
						</header>

					</div>
				</div>
			</a>
		</div>
	);
	
}
