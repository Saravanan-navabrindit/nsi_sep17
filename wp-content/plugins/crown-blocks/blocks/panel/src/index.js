/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
import { registerBlockType } from '@wordpress/blocks';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './style.scss';

import { useBlockProps } from '@wordpress/block-editor';

import CrownBlocks from '../../../common.js';

const { InnerBlocks } = wp.blockEditor;
const { getColorObjectByColorValue } = wp.blockEditor;

/**
 * Internal dependencies
 */
import Edit from './edit';
import save from './save';

import blockConfig from '../block.json';

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
registerBlockType( blockConfig.name, {

	attributes: {

		responsiveDeviceMode: { type: 'string', default: 'xl' },

		overrideVerticalSpacingXl: { type: 'boolean', default: false },
		paddingTopXl: { type: 'number', default: 0 },
		paddingBottomXl: { type: 'number', default: 0 },
		overflowBottomXl: { type: 'number', default: 0 },
		overrideHorizontalSpacingXl: { type: 'boolean', default: false },
		paddingLeftXl: { type: 'number', default: 0 },
		paddingRightXl: { type: 'number', default: 0 },

		overrideVerticalSpacingLg: { type: 'boolean', default: false },
		paddingTopLg: { type: 'number', default: 0 },
		paddingBottomLg: { type: 'number', default: 0 },
		overflowBottomLg: { type: 'number', default: 0 },
		overrideHorizontalSpacingLg: { type: 'boolean', default: false },
		paddingLeftLg: { type: 'number', default: 0 },
		paddingRightLg: { type: 'number', default: 0 },

		overrideVerticalSpacingMd: { type: 'boolean', default: false },
		paddingTopMd: { type: 'number', default: 0 },
		paddingBottomMd: { type: 'number', default: 0 },
		overflowBottomMd: { type: 'number', default: 0 },
		overrideHorizontalSpacingMd: { type: 'boolean', default: false },
		paddingLeftMd: { type: 'number', default: 0 },
		paddingRightMd: { type: 'number', default: 0 },

		overrideVerticalSpacingSM: { type: 'boolean', default: false },
		paddingTopSM: { type: 'number', default: 0 },
		paddingBottomSM: { type: 'number', default: 0 },
		overflowBottomSM: { type: 'number', default: 0 },
		overrideHorizontalSpacingSM: { type: 'boolean', default: false },
		paddingLeftSM: { type: 'number', default: 0 },
		paddingRightSM: { type: 'number', default: 0 },

		overrideVerticalSpacingXs: { type: 'boolean', default: false },
		paddingTopXs: { type: 'number', default: 0 },
		paddingBottomXs: { type: 'number', default: 0 },
		overflowBottomXs: { type: 'number', default: 0 },
		overrideHorizontalSpacingXs: { type: 'boolean', default: false },
		paddingLeftXs: { type: 'number', default: 0 },
		paddingRightXs: { type: 'number', default: 0 },

		verticalAlignment: { type: 'string', default: '' },

		backgroundColor: { type: 'string', default: '' },
		backgroundImageId: { type: 'number' },
		backgroundImageData: { type: 'object' },
		backgroundImageFocalPoint: { type: 'object', default: { x: 0.5, y: 0.5 } },
		backgroundImageOpacity: { type: 'number', default: 100 },
		backgroundImageGrayscale: { type: 'number', default: 0 },
		backgroundImageBlendMode: { type: 'string', default: 'normal' },
		backgroundImageContain: { type: 'boolean', default: false },
		textColor: { type: 'string', default: 'auto' },

		lineStyle: { type: 'string', default: '' },

		enableShadow: { type: 'boolean', default: false },
		panelPadding: { type: 'number', default: 30 }

	},
	
	/**
	 * @see ./edit.js
	 */
	edit: Edit,

	/**
	 * @see ./save.js
	 */
	save,


	deprecated: [

		{
			attributes: {
				responsiveDeviceMode: { type: 'string', default: 'xl' },

				overrideVerticalSpacingXl: { type: 'boolean', default: false },
				paddingTopXl: { type: 'number', default: 0 },
				paddingBottomXl: { type: 'number', default: 0 },
				overflowBottomXl: { type: 'number', default: 0 },
				overrideHorizontalSpacingXl: { type: 'boolean', default: false },
				paddingLeftXl: { type: 'number', default: 0 },
				paddingRightXl: { type: 'number', default: 0 },

				overrideVerticalSpacingLg: { type: 'boolean', default: false },
				paddingTopLg: { type: 'number', default: 0 },
				paddingBottomLg: { type: 'number', default: 0 },
				overflowBottomLg: { type: 'number', default: 0 },
				overrideHorizontalSpacingLg: { type: 'boolean', default: false },
				paddingLeftLg: { type: 'number', default: 0 },
				paddingRightLg: { type: 'number', default: 0 },

				overrideVerticalSpacingMd: { type: 'boolean', default: false },
				paddingTopMd: { type: 'number', default: 0 },
				paddingBottomMd: { type: 'number', default: 0 },
				overflowBottomMd: { type: 'number', default: 0 },
				overrideHorizontalSpacingMd: { type: 'boolean', default: false },
				paddingLeftMd: { type: 'number', default: 0 },
				paddingRightMd: { type: 'number', default: 0 },

				overrideVerticalSpacingSM: { type: 'boolean', default: false },
				paddingTopSM: { type: 'number', default: 0 },
				paddingBottomSM: { type: 'number', default: 0 },
				overflowBottomSM: { type: 'number', default: 0 },
				overrideHorizontalSpacingSM: { type: 'boolean', default: false },
				paddingLeftSM: { type: 'number', default: 0 },
				paddingRightSM: { type: 'number', default: 0 },

				overrideVerticalSpacingXs: { type: 'boolean', default: false },
				paddingTopXs: { type: 'number', default: 0 },
				paddingBottomXs: { type: 'number', default: 0 },
				overflowBottomXs: { type: 'number', default: 0 },
				overrideHorizontalSpacingXs: { type: 'boolean', default: false },
				paddingLeftXs: { type: 'number', default: 0 },
				paddingRightXs: { type: 'number', default: 0 },

				verticalAlignment: { type: 'string', default: '' },

				backgroundColor: { type: 'string', default: '' },
				backgroundImageId: { type: 'number' },
				backgroundImageData: { type: 'object' },
				backgroundImageFocalPoint: { type: 'object', default: { x: 0.5, y: 0.5 } },
				backgroundImageOpacity: { type: 'number', default: 100 },
				backgroundImageGrayscale: { type: 'number', default: 0 },
				backgroundImageBlendMode: { type: 'string', default: 'normal' },
				backgroundImageContain: { type: 'boolean', default: false },
				textColor: { type: 'string', default: 'auto' },

				lineStyle: { type: 'string', default: '' },

				enableShadow: { type: 'boolean', default: false },
				panelPadding: { type: 'number', default: 30 }
			},
			save: ({ attributes, className }) => {
				const {
					responsiveDeviceMode,
			
					overrideVerticalSpacingXl,
					paddingTopXl,
					paddingBottomXl,
					overflowBottomXl,
					overrideHorizontalSpacingXl,
					paddingLeftXl,
					paddingRightXl,
			
					overrideVerticalSpacingLg,
					paddingTopLg,
					paddingBottomLg,
					overflowBottomLg,
					overrideHorizontalSpacingLg,
					paddingLeftLg,
					paddingRightLg,
			
					overrideVerticalSpacingMd,
					paddingTopMd,
					paddingBottomMd,
					overflowBottomMd,
					overrideHorizontalSpacingMd,
					paddingLeftMd,
					paddingRightMd,
			
					overrideVerticalSpacingSm,
					paddingTopSm,
					paddingBottomSm,
					overflowBottomSm,
					overrideHorizontalSpacingSm,
					paddingLeftSm,
					paddingRightSm,
			
					overrideVerticalSpacingXs,
					paddingTopXs,
					paddingBottomXs,
					overflowBottomXs,
					overrideHorizontalSpacingXs,
					paddingLeftXs,
					paddingRightXs,
			
					verticalAlignment,
			
					backgroundColor,
					backgroundImageId,
					backgroundImageData,
					backgroundImageFocalPoint,
					backgroundImageOpacity,
					backgroundImageGrayscale,
					backgroundImageBlendMode,
					backgroundImageContain,
					textColor,
					
					lineStyle,
			
					enableShadow,
					panelPadding
			
				} = attributes;
			
				let blockClasses = [ className, 'panel' ];
			
				let blockStyle = {};
			
				if(textColor == 'auto' && backgroundColor) {
					blockClasses.push('text-color-' + (CrownBlocks.isDarkColor(backgroundColor) ? 'light' : 'dark'));
				} else if(textColor != 'auto') {
					blockClasses.push('text-color-' + textColor);
				}
			
				if(backgroundColor) {
					blockStyle.backgroundColor = backgroundColor;
					let settings = wp.data.select('core/editor').getEditorSettings();
					if(settings.colors) {
						let colorObject = getColorObjectByColorValue(settings.colors, backgroundColor);
						if(colorObject) blockClasses.push('bg-color-' + colorObject.slug);
					}
				}
			
				if(lineStyle) {
					blockClasses.push('line');
					blockClasses.push('line-' + lineStyle);
				}
			
				if(overrideHorizontalSpacingXl) {
					blockClasses.push('contents-pl-xl-' + paddingLeftXl);
					blockClasses.push('contents-pr-xl-' + paddingRightXl);
				}
				if(overrideVerticalSpacingXl) {
					blockClasses.push('contents-pt-xl-' + paddingTopXl);
					blockClasses.push('contents-pb-xl-' + paddingBottomXl);
					if(overflowBottomXl > 0) blockClasses.push('contents-ob-xl-' + overflowBottomXl);
				}
			
				if(overrideHorizontalSpacingLg) {
					blockClasses.push('contents-pl-lg-' + paddingLeftLg);
					blockClasses.push('contents-pr-lg-' + paddingRightLg);
				}
				if(overrideVerticalSpacingLg) {
					blockClasses.push('contents-pt-lg-' + paddingTopLg);
					blockClasses.push('contents-pb-lg-' + paddingBottomLg);
					if(overflowBottomLg > 0) blockClasses.push('contents-ob-lg-' + overflowBottomLg);
				}
			
				if(overrideHorizontalSpacingMd) {
					blockClasses.push('contents-pl-md-' + paddingLeftMd);
					blockClasses.push('contents-pr-md-' + paddingRightMd);
				}
				if(overrideVerticalSpacingMd) {
					blockClasses.push('contents-pt-md-' + paddingTopMd);
					blockClasses.push('contents-pb-md-' + paddingBottomMd);
					if(overflowBottomMd > 0) blockClasses.push('contents-ob-md-' + overflowBottomMd);
				}
			
				if(overrideHorizontalSpacingSm) {
					blockClasses.push('contents-pl-sm-' + paddingLeftSm);
					blockClasses.push('contents-pr-sm-' + paddingRightSm);
				}
				if(overrideVerticalSpacingSm) {
					blockClasses.push('contents-pt-sm-' + paddingTopSm);
					blockClasses.push('contents-pb-sm-' + paddingBottomSm);
					if(overflowBottomSm > 0) blockClasses.push('contents-ob-sm-' + overflowBottomSm);
				}
			
				if(overrideHorizontalSpacingXs) {
					blockClasses.push('contents-pl-' + paddingLeftXs);
					blockClasses.push('contents-pr-' + paddingRightXs);
				}
				if(overrideVerticalSpacingXs) {
					blockClasses.push('contents-pt-' + paddingTopXs);
					blockClasses.push('contents-pb-' + paddingBottomXs);
					if(overflowBottomXs > 0) blockClasses.push('contents-ob-' + overflowBottomXs);
				}
			
				if(verticalAlignment != '') blockClasses.push('vertical-alignment-' + verticalAlignment);
			
				if ( enableShadow ) {
					blockClasses.push('enable-shadow');
				}
			
				let blockInnerStyles = {};
				if ( enableShadow && typeof panelPadding !== 'undefined' ) {
					blockInnerStyles.padding = panelPadding + 'px';
					
					if ( panelPadding > 30 ) {
						blockClasses.push( 'large-padding' );
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
					key: 'panel'
				};
				
				return (
					<div { ...useBlockProps.save( customProps ) }>
						<div className="section-line"></div>
						<div className="section-bg" style={ { backgroundColor: backgroundColor } }>
							{ backgroundImageUrl && <div className={ 'bg-image' } style={ {
								backgroundImage: 'url(' + backgroundImageUrl + ')',
								opacity: (backgroundImageOpacity / 100),
								backgroundPosition: `${ backgroundImageFocalPoint.x * 100 }% ${ backgroundImageFocalPoint.y * 100 }%`,
								filter: `grayscale(${ backgroundImageGrayscale / 100 })`,
								mixBlendMode: backgroundImageBlendMode,
								backgroundSize: backgroundImageContain ? 'contain' : 'cover'
							} }></div> }
						</div>
						<div className="inner" style={ blockInnerStyles }>
			
						<div className="panel-contents">
							<div className="container">
			
								<InnerBlocks.Content />
			
							</div>
						</div>
			
						</div>
					</div>
				);
			}
		}

	]
	
} );
