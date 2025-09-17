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

import blockConfig from '../block.json';

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
 registerBlockType( blockConfig.name, {
	attributes: {
		responsiveDeviceMode: { type: 'string', default: 'xl' },
		columnBreakpoint: { type: 'string', default: 'md' },
		cellHorizontalAlignment: { type: 'string', default: '' },
		cellVerticalAlignment: { type: 'string', default: '' },

		columnWidthXl: { type: 'number', default: 2 },
		columnSpacingXl: { type: 'number', default: 30 },

		overrideColumnLayoutLg: { type: 'boolean', default: false },
		columnWidthLg: { type: 'number', default: 2 },
		columnSpacingLg: { type: 'number', default: 30 },

		overrideColumnLayoutMd: { type: 'boolean', default: false },
		columnWidthMd: { type: 'number', default: 2 },
		columnSpacingMd: { type: 'number', default: 30 },

		overrideColumnLayoutSm: { type: 'boolean', default: false },
		columnWidthSm: { type: 'number', default: 1 },
		columnSpacingSm: { type: 'number', default: 30 },

		overrideColumnLayoutXs: { type: 'boolean', default: false },
		columnWidthXs: { type: 'number', default: 1 },
		columnSpacingXs: { type: 'number', default: 30 },

		backgroundColor: { type: 'string', default: '' },
		backgroundImageId: { type: 'number' },
		backgroundImageData: { type: 'object' },
		backgroundImageFocalPoint: { type: 'object', default: { x: 0.5, y: 0.5 } },
		backgroundImageOpacity: { type: 'number', default: 100 },
		backgroundImageGrayscale: { type: 'number', default: 0 },
		backgroundImageBlendMode: { type: 'string', default: 'normal' },
		backgroundImageContain: { type: 'boolean', default: false },
		textColor: { type: 'string', default: 'auto' },

		enableOverlap: { type: 'boolean', default: false },

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
