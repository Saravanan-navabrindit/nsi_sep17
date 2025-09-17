/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './style.scss';

/**
 * Internal dependencies
 */
import Edit from './edit';
import save from './save';

/**
 * Import block settings from JSON config file. 
 * 
 * Currently only used to load the block name. 
 */
import blockConfig from '../block.json';

import CrownBlocks from '../../../common.js';
const { InnerBlocks, RichText, MediaUpload, BlockControls, AlignmentToolbar, InspectorControls, PanelColorSettings } = wp.blockEditor;
const { PanelBody, RadioControl, CheckboxControl, ColorPicker, RangeControl, FocalPointPicker, ToggleControl, TextControl, TextareaControl, SelectControl, Button, ButtonGroup, Icon, BaseControl } = wp.components;
const { getColorObjectByColorValue } = wp.blockEditor;

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
registerBlockType( blockConfig.name, {
	attributes: {
		backgroundColor: { type: 'string', default: '' },
		backgroundImageId: { type: 'number' },
		backgroundImageData: { type: 'object' },
		backgroundImageFocalPoint: { type: 'object', default: { x: 0.5, y: 0.5 } },
		textColor: { type: 'string', default: 'auto' },
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
				backgroundImageId: { type: 'number' },
				backgroundImageData: { type: 'object' },
				backgroundImageFocalPoint: { type: 'object', default: { x: 0.5, y: 0.5 } },
			},
			save: ({ attributes, className }) => {

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
		}

	]
} );
