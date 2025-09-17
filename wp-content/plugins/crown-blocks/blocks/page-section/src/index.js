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
 * Import block settings from JSON config file
 */
import blockConfig from '../block.json';

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
registerBlockType( blockConfig.name, {
	attributes: {
        title: { type: 'string' },
		title_tag: { type: 'string', default: 'h2' },
		textAlign: { type: 'string', default: 'left' },
		contentAlign: { type: 'string', default: 'center' },
		responsiveDeviceMode: { type: 'string', default: 'xl' },
		restrictContentWidth: { type: 'boolean', default: true },
		contentsMaxWidth: { type: 'number', default: 1260 },
		slantedBg: { type: 'boolean', default: false },
		slantedBgTop: { type: 'boolean', default: false },
		slantedBgTopReverse: { type: 'boolean', default: false },
		slantedBgBottom: { type: 'boolean', default: false },
		slantedBgBottomReverse: { type: 'boolean', default: false },
		fullWidth: { type: 'boolean', default: true },

		overrideVerticalSpacingXl: { type: 'boolean', default: false },
		paddingTopXl: { type: 'number', default: 2 },
		paddingBottomXl: { type: 'number', default: 2 },
		overflowTopXl: { type: 'number', default: 0 },
		overflowBottomXl: { type: 'number', default: 0 },
		overrideHorizontalSpacingXl: { type: 'boolean', default: false },
		paddingXXl: { type: 'number', default: 2 },
		overflowXXl: { type: 'number', default: 0 },

		overrideVerticalSpacingLg: { type: 'boolean', default: false },
		paddingTopLg: { type: 'number', default: 2 },
		paddingBottomLg: { type: 'number', default: 2 },
		overflowTopLg: { type: 'number', default: 0 },
		overflowBottomLg: { type: 'number', default: 0 },
		overrideHorizontalSpacingLg: { type: 'boolean', default: false },
		paddingXLg: { type: 'number', default: 2 },
		overflowXLg: { type: 'number', default: 0 },

		overrideVerticalSpacingMd: { type: 'boolean', default: false },
		paddingTopMd: { type: 'number', default: 2 },
		paddingBottomMd: { type: 'number', default: 2 },
		overflowTopMd: { type: 'number', default: 0 },
		overflowBottomMd: { type: 'number', default: 0 },
		overrideHorizontalSpacingMd: { type: 'boolean', default: false },
		paddingXMd: { type: 'number', default: 2 },
		overflowXMd: { type: 'number', default: 0 },

		overrideVerticalSpacingSm: { type: 'boolean', default: false },
		paddingTopSm: { type: 'number', default: 2 },
		paddingBottomSm: { type: 'number', default: 2 },
		overflowTopSm: { type: 'number', default: 0 },
		overflowBottomSm: { type: 'number', default: 0 },
		overrideHorizontalSpacingSm: { type: 'boolean', default: false },
		paddingXSm: { type: 'number', default: 2 },
		overflowXSm: { type: 'number', default: 0 },

		overrideVerticalSpacingXs: { type: 'boolean', default: false },
		paddingTopXs: { type: 'number', default: 2 },
		paddingBottomXs: { type: 'number', default: 2 },
		overflowTopXs: { type: 'number', default: 0 },
		overflowBottomXs: { type: 'number', default: 0 },
		overrideHorizontalSpacingXs: { type: 'boolean', default: false },
		paddingXXs: { type: 'number', default: 2 },
		overflowXXs: { type: 'number', default: 0 },

		backgroundColor: { type: 'string', default: '' },
		backgroundImageId: { type: 'number' },
		backgroundImageData: { type: 'object' },
		backgroundImageFocalPoint: { type: 'object', default: { x: 0.5, y: 0.5 } },
		backgroundImageOpacity: { type: 'number', default: 100 },
		backgroundImageGrayscale: { type: 'number', default: 0 },
		backgroundImageBlendMode: { type: 'string', default: 'normal' },
		backgroundImageContain: { type: 'boolean', default: false },
		textColor: { type: 'string', default: 'auto' },
		lineStyle: { type: 'string', default: '' }
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
