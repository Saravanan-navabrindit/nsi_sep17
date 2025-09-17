
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
		restrictContentWidth,
		contentsMaxWidth,
		slantedBg,
		slantedBgTop,
		slantedBgTopReverse,
		slantedBgBottom,
		slantedBgBottomReverse,
		fullWidth,

		overrideVerticalSpacingXl,
		paddingTopXl,
		paddingBottomXl,
		overflowTopXl,
		overflowBottomXl,
		overrideHorizontalSpacingXl,
		paddingXXl,
		overflowXXl,

		overrideVerticalSpacingLg,
		paddingTopLg,
		paddingBottomLg,
		overflowTopLg,
		overflowBottomLg,
		overrideHorizontalSpacingLg,
		paddingXLg,
		overflowXLg,

		overrideVerticalSpacingMd,
		paddingTopMd,
		paddingBottomMd,
		overflowTopMd,
		overflowBottomMd,
		overrideHorizontalSpacingMd,
		paddingXMd,
		overflowXMd,

		overrideVerticalSpacingSm,
		paddingTopSm,
		paddingBottomSm,
		overflowTopSm,
		overflowBottomSm,
		overrideHorizontalSpacingSm,
		paddingXSm,
		overflowXSm,

		overrideVerticalSpacingXs,
		paddingTopXs,
		paddingBottomXs,
		overflowTopXs,
		overflowBottomXs,
		overrideHorizontalSpacingXs,
		paddingXXs,
		overflowXXs,

		backgroundColor,
		backgroundImageId,
		backgroundImageData,
		backgroundImageFocalPoint,
		backgroundImageOpacity,
		backgroundImageGrayscale,
		backgroundImageBlendMode,
		backgroundImageContain,
		textColor,

		lineStyle
	} = attributes;

	let blockClasses = [ className ];

	if ( fullWidth ) {
		blockClasses.push('full-width');
	}

	if ( restrictContentWidth ) {
		blockClasses.push('restricted-content-width');
	}

	if ( contentAlign ) {
		blockClasses.push('content-align-' + contentAlign);
	}

	if ( textAlign ) {
		blockClasses.push('text-align-' + textAlign);
	}

	if(lineStyle) {
		blockClasses.push('line');
		blockClasses.push('line-' + lineStyle);
	}

	if(textColor == 'auto' && backgroundColor) {
		blockClasses.push('text-color-' + (CrownBlocks.isDarkColor(backgroundColor) ? 'light' : 'dark'));
	} else if(textColor != 'auto') {
		blockClasses.push('text-color-' + textColor);
	}

	let blockStyle = {};
	if(backgroundColor) {
		blockStyle.backgroundColor = backgroundColor;
		let settings = wp.data.select('core/editor').getEditorSettings();
		// if(settings.colors) {
		// 	let colorObject = getColorObjectByColorValue(settings.colors, backgroundColor);
		// 	if(colorObject) blockClasses.push('bg-color-' + colorObject.slug);
		// }
	}

	if ( slantedBg ) {
		if ( slantedBgTop ) {
			blockClasses.push('slanted-bg-top');

			if ( slantedBgTopReverse ) {
				blockClasses.push('slanted-bg-top-reverse')
			}
		}
		if ( slantedBgBottom ) {
			blockClasses.push('slanted-bg-bottom');

			if ( slantedBgBottomReverse ) {
				blockClasses.push('slanted-bg-bottom-reverse')
			}
		}
	}

	if(overrideVerticalSpacingXl) {
		blockClasses.push('contents-pt-xl-' + paddingTopXl);
		blockClasses.push('contents-pb-xl-' + paddingBottomXl);
		if(overflowTopXl > 0) blockClasses.push('contents-ot-xl-' + overflowTopXl);
		if(overflowBottomXl > 0) blockClasses.push('contents-ob-xl-' + overflowBottomXl);
	}
	if(overrideHorizontalSpacingXl) {
		blockClasses.push('contents-px-xl-' + paddingXXl);
		if(overflowXXl > 0) blockClasses.push('contents-ox-xl-' + overflowXXl);
	}

	if(overrideVerticalSpacingLg) {
		blockClasses.push('contents-pt-lg-' + paddingTopLg);
		blockClasses.push('contents-pb-lg-' + paddingBottomLg);
		if(overflowTopLg > 0) blockClasses.push('contents-ot-lg-' + overflowTopLg);
		if(overflowBottomLg > 0) blockClasses.push('contents-ob-lg-' + overflowBottomLg);
	}
	if(overrideHorizontalSpacingLg) {
		blockClasses.push('contents-px-lg-' + paddingXLg);
		if(overflowXLg > 0) blockClasses.push('contents-ox-lg-' + overflowXLg);
	}

	if(overrideVerticalSpacingMd) {
		blockClasses.push('contents-pt-md-' + paddingTopMd);
		blockClasses.push('contents-pb-md-' + paddingBottomMd);
		if(overflowTopMd > 0) blockClasses.push('contents-ot-md-' + overflowTopMd);
		if(overflowBottomMd > 0) blockClasses.push('contents-ob-md-' + overflowBottomMd);
	}
	if(overrideHorizontalSpacingMd) {
		blockClasses.push('contents-px-md-' + paddingXMd);
		if(overflowXMd > 0) blockClasses.push('contents-ox-md-' + overflowXMd);
	}

	if(overrideVerticalSpacingSm) {
		blockClasses.push('contents-pt-sm-' + paddingTopSm);
		blockClasses.push('contents-pb-sm-' + paddingBottomSm);
		if(overflowTopSm > 0) blockClasses.push('contents-ot-sm-' + overflowTopSm);
		if(overflowBottomSm > 0) blockClasses.push('contents-ob-sm-' + overflowBottomSm);
	}
	if(overrideHorizontalSpacingSm) {
		blockClasses.push('contents-px-sm-' + paddingXSm);
		if(overflowXSm > 0) blockClasses.push('contents-ox-sm-' + overflowXSm);
	}

	if(overrideVerticalSpacingXs) {
		blockClasses.push('contents-pt-' + paddingTopXs);
		blockClasses.push('contents-pb-' + paddingBottomXs);
		if(overflowTopXs > 0) blockClasses.push('contents-ot-' + overflowTopXs);
		if(overflowBottomXs > 0) blockClasses.push('contents-ob-' + overflowBottomXs);
	}
	if(overrideHorizontalSpacingXs) {
		blockClasses.push('contents-ps-' + paddingXXs);
		if(overflowXXs > 0) blockClasses.push('contents-ox-' + overflowXXs);
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
				} }></div> }
			</div>
			<div className="inner">
				<div className="container">
					<div className="inner" style={ restrictContentWidth ? { maxWidth: contentsMaxWidth + 'px' } : {} }>

						<InnerBlocks.Content />
						
					</div>
				</div>
			</div>
		</div>

	);

}
