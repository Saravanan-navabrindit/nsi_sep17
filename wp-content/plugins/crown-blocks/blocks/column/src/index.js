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

		enableShadow: { type: 'boolean', default: false },
		columnPadding: { type: 'number', default: 30 }

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
