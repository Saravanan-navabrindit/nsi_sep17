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

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
registerBlockType( blockConfig.name, {
	attributes: {
		textAlign: { type: 'string', default: '' },
		contentAlign: { type: 'string', default: 'left' },
		contentAlignVertical: { type: 'string', default: 'bottom' },
		responsiveDeviceMode: { type: 'string', default: 'xl' },
		restrictContentWidth: { type: 'boolean', default: true },
		contentsMaxWidth: { type: 'number', default: 600 },
		fullWidth: { type: 'boolean', default: true },

		backgroundColor: { type: 'string', default: '' },
		backgroundGradient: { type: 'boolean', default: false },
		backgroundImageId: { type: 'number' },
		backgroundImageData: { type: 'object' },
		backgroundImageFocalPoint: { type: 'object', default: { x: 0.5, y: 0.5 } },
		backgroundImageOpacity: { type: 'number', default: 100 },
		backgroundImageGrayscale: { type: 'number', default: 0 },
		backgroundImageBlendMode: { type: 'string', default: 'normal' },
		backgroundImageContain: { type: 'boolean', default: false },
		enableGradientOverlay: { type: 'boolean', default: false },
		gradientColorStart: { type: 'object', default: {} },
		gradientColorEnd: { type: 'object', default: {} },
		gradientDirection: { type: 'string', default: 'to right' },
		textColor: { type: 'string', default: 'auto' }
    },
	
	/**
	 * @see ./edit.js
	 */
	edit: Edit,

	/**
	 * @see ./save.js
	 */
	save,
} );
