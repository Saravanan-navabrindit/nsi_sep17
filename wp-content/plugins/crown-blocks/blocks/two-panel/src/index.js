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
		panelBreakpoint: { type: 'string', default: 'md' },
		panelCount: { type: 'number', default: 2 },

		panelLayoutXl: { type: 'number', default: 6 },

		overridePanelLayoutLg: { type: 'boolean', default: false },
		panelLayoutLg: { type: 'number', default: 6 },

		overridePanelLayoutMd: { type: 'boolean', default: false },
		panelLayoutMd: { type: 'number', default: 6 },

		overridePanelLayoutSm: { type: 'boolean', default: false },
		panelLayoutSm: { type: 'number', default: 6 },

		overridePanelLayoutXs: { type: 'boolean', default: false },
		panelLayoutXs: { type: 'number', default: 6 },

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
