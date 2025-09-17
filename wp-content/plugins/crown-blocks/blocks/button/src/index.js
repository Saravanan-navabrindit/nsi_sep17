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

import blockConfig from '../block.json';

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
registerBlockType( blockConfig.name, {

	attributes: {
		blockId: { type: 'string', default: '' },
		label: { type: 'string', default: 'Learn More', selector: '.btn-label', source: 'html' },
		linkUrl: { type: 'string', default: '' },
		linkPost: { type: 'object' },
		alignment: { type: 'alignment', default: 'none' },
		type: { type: 'string', default: 'default' },
		color: { type: 'string', default: '#000000' },
		colorSlug: { type: 'string', default: 'pure-black' },
		size: { type: 'string', default: 'md' },
		borderRadius: { type: 'string', default: 'none' },
		angle: { type: 'string', default: 'wide-top' },
		displayAsBlock: { type: 'boolean', default: false },
		disabledDisplayAsBlockBreakpoint: { type: 'string', default: 'none' },
		openNewWindow: { type: 'boolean', default: false },
		linkArrow: { type: 'boolean', default: false },
		backArrow: { type: 'boolean', default: false },
		iconId: { type: 'number' },
		iconData: { type: 'object' },
		underline: { type: 'boolean', default: false },
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
				label: { type: 'string', default: 'Learn More', selector: '.btn-label', source: 'html' },
				linkUrl: { type: 'string', default: '' },
				linkPost: { type: 'object' },
				alignment: { type: 'alignment', default: 'none' },
				type: { type: 'string', default: 'default' },
				color: { type: 'string', default: '#000000' },
				colorSlug: { type: 'string', default: 'pure-black' },
				size: { type: 'string', default: 'md' },
				borderRadius: { type: 'string', default: 'none' },
				angle: { type: 'string', default: 'wide-top' },
				displayAsBlock: { type: 'boolean', default: false },
				disabledDisplayAsBlockBreakpoint: { type: 'string', default: 'none' },
				openNewWindow: { type: 'boolean', default: false },
				linkArrow: { type: 'boolean', default: false },
				backArrow: { type: 'boolean', default: false },
				iconId: { type: 'number' },
				iconData: { type: 'object' },
				underline: { type: 'boolean', default: false },
			},
			save: ({ attributes, className }) => {

				const {
					label,
					linkUrl,
					linkPost,
					alignment,
					type,
					color,
					colorSlug,
					size,
					borderRadius,
					angle,
					displayAsBlock,
					disabledDisplayAsBlockBreakpoint,
					openNewWindow,
					linkArrow,
					backArrow,
					iconId,
					iconData,
					underline,
				} = attributes;
			
				let blockClasses = [ className ];
				if(typeof alignment != 'undefined') blockClasses.push('text-alignment-' + alignment);
			
				let buttonClasses = [ 'btn' ]
			
				if(type == 'outline') {
					buttonClasses.push('btn--outline');
					buttonClasses.push('btn--outline-' + colorSlug);
				} else if(type == 'link') {
					buttonClasses.push('btn--link');
					buttonClasses.push('btn--link-' + colorSlug);
				} else if(type == 'cta') {
					buttonClasses.push('btn--cta');
					buttonClasses.push('btn--cta-' + colorSlug);
					buttonClasses.push('btn--' + angle);
				} else {
					buttonClasses.push('btn--default');
					buttonClasses.push('btn--' + colorSlug);
				}
			
				buttonClasses.push('btn--' + size);
			
				if(displayAsBlock) {
					if(disabledDisplayAsBlockBreakpoint == 'none') {
						buttonClasses.push('btn--block');
					} else {
						buttonClasses.push('btn--block-to-' + disabledDisplayAsBlockBreakpoint);
					}
				}
			
				if ( backArrow ) {
					buttonClasses.push( 'back-arrow' );
				}
			
				if ( linkArrow ) {
					buttonClasses.push( 'link-arrow' );
				}
			
				let iconUrl = null;
				if(iconId) {
					iconUrl = ( iconData.sizes && iconData.sizes.thumbnail ? iconData.sizes.thumbnail.url : iconData.url );
					buttonClasses.push('btn--has-icon');
				}
			
				if ( underline ) {
					buttonClasses.push( 'btn--underline' );
				}
			
				// This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag
				let customProps = {
					className: blockClasses.join(' '),
					// style: blockStyle,
					key: 'button'
				};
			
				return (
			
					<p { ...useBlockProps.save( customProps ) }>
						<a href={ linkUrl } className={ buttonClasses.join(' ') } target={ openNewWindow && '_blank' } rel={ openNewWindow && 'noopener noreferrer' }>
							{ backArrow && <span className="btn__back-arrow"></span> }
							{ iconUrl && <img src={ iconUrl } className="btn__icon" aria-hidden="true" /> }
							<span className="btn-label">{ label }</span>
							{ linkArrow && <span className="btn__arrow"></span> }
						</a>
					</p>
			
				);

			}
		}

	]
	
} );
