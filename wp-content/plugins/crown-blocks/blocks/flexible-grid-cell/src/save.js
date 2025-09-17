
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
 const { InnerBlocks } = wp.blockEditor;
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
		responsiveDeviceMode,
		columnBreakpoint,
		cellHorizontalAlignment,
		cellVerticalAlignment,
		
		columnWidthXl,
		columnSpacingXl,

		overrideColumnLayoutLg,
		columnWidthLg,
		columnSpacingLg,

		overrideColumnLayoutMd,
		columnWidthMd,
		columnSpacingMd,

		overrideColumnLayoutSm,
		columnWidthSm,
		columnSpacingSm,

		overrideColumnLayoutXs,
		columnWidthXs,
		columnSpacingXs,

		backgroundColor,
		backgroundImageId,
		backgroundImageData,
		backgroundImageFocalPoint,
		backgroundImageOpacity,
		backgroundImageGrayscale,
		backgroundImageBlendMode,
		backgroundImageContain,
		textColor,

		enableOverlap
	} = attributes;

	let blockClasses = [ className, 'cell' ];

	let blockStyle = {};

	if(textColor == 'auto' && backgroundColor) {
		blockClasses.push('text-color-' + (CrownBlocks.isDarkColor(backgroundColor) ? 'light' : 'dark'));
	} else if(textColor != 'auto') {
		blockClasses.push('text-color-' + textColor);
	}

	if(enableOverlap) {
		blockClasses.push('overlap');
	}

	if(backgroundColor) {
		blockStyle.backgroundColor = backgroundColor;
		let settings = wp.data.select('core/editor').getEditorSettings();
		if(settings.colors) {
			let colorObject = getColorObjectByColorValue(settings.colors, backgroundColor);
			if(colorObject) blockClasses.push('bg-color-' + colorObject.slug);
		}
	}

	blockClasses.push('column-breakpoint-' + columnBreakpoint);

	let defaultLayoutBrakpoint = columnBreakpoint;
	if([ 'xs' ].includes(columnBreakpoint) && overrideColumnLayoutXs) {
		defaultLayoutBrakpoint = 'sm';
		blockClasses.push('column-width-xs-' + columnWidthXs);
		blockClasses.push('column-spacing-xs-' + columnSpacingXs);
	}
	if([ 'xs', 'sm' ].includes(columnBreakpoint) && overrideColumnLayoutSm) {
		defaultLayoutBrakpoint = 'md';
		blockClasses.push('column-width-sm-' + columnWidthSm);
		blockClasses.push('column-spacing-sm-' + columnSpacingSm);
	}
	if([ 'xs', 'sm', 'md' ].includes(columnBreakpoint) && overrideColumnLayoutMd) {
		defaultLayoutBrakpoint = 'lg';
		blockClasses.push('column-width-md-' + columnWidthMd);
		blockClasses.push('column-spacing-md-' + columnSpacingMd);
	}
	if([ 'xs', 'sm', 'md', 'lg' ].includes(columnBreakpoint) && overrideColumnLayoutLg) {
		defaultLayoutBrakpoint = 'xl';
		blockClasses.push('column-width-lg-' + columnWidthLg);
		blockClasses.push('column-spacing-lg-' + columnSpacingLg);
	}
	blockClasses.push('column-width-' + defaultLayoutBrakpoint + '-' + columnWidthXl);
	blockClasses.push('column-spacing-' + defaultLayoutBrakpoint + '-' + columnSpacingXl);

	if(cellHorizontalAlignment != '') {
		blockClasses.push('cell-horizontal-align-' + cellHorizontalAlignment);
	}
	if(cellVerticalAlignment != '') {
		blockClasses.push('cell-vertical-align-' + cellVerticalAlignment);
	}

	let blockInnerStyles = {};

	let backgroundImageUrl = null;
	if(backgroundImageId) {
		backgroundImageUrl = backgroundImageData.sizes.fullscreen ? backgroundImageData.sizes.fullscreen.url : backgroundImageData.url;
		blockClasses.push('has-bg-image');
	}

	// This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag
	let customProps = {
		className: blockClasses.join(' '),
		style: blockStyle,
		key: 'grid-cell'
	};
	
	return (
		<div { ...useBlockProps.save( customProps ) }>
			<div className="cell-bg" style={ { backgroundColor: backgroundColor } }>
				{ backgroundImageUrl && <div className={ 'bg-image' } style={ {
					backgroundImage: 'url(' + backgroundImageUrl + ')',
					opacity: (backgroundImageOpacity / 100),
					backgroundPosition: `${ backgroundImageFocalPoint.x * 100 }% ${ backgroundImageFocalPoint.y * 100 }%`,
					filter: `grayscale(${ backgroundImageGrayscale / 100 })`,
					mixBlendMode: backgroundImageBlendMode,
					backgroundSize: backgroundImageContain ? 'contain' : 'cover'
				} }></div> }
			</div>
			<div className={ 'inner' }>

				<InnerBlocks.Content />
						
			</div>
		</div>
	);
	
}
