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

		columnCountXl: { type: 'number', default: 4 },
		columnSpacingXl: { type: 'number', default: 8 },

		overrideColumnLayoutLg: { type: 'boolean', default: true },
		columnCountLg: { type: 'number', default: 3 },
		columnSpacingLg: { type: 'number', default: 8 },

		overrideColumnLayoutMd: { type: 'boolean', default: true },
		columnCountMd: { type: 'number', default: 2 },
		columnSpacingMd: { type: 'number', default: 8 },

		overrideColumnLayoutSm: { type: 'boolean', default: true },
		columnCountSm: { type: 'number', default: 2 },
		columnSpacingSm: { type: 'number', default: 8 },

		overrideColumnLayoutXs: { type: 'boolean', default: true },
		columnCountXs: { type: 'number', default: 1 },
		columnSpacingXs: { type: 'number', default: 8 }
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
