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
		blockId,
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

	let buttonClasses = [ 'btn' ];
	let buttonCss = '';

	if(blockId) buttonClasses.push('btn--id--' + blockId);
	let buttonSelector = '#main-content .wp-block-crown-blocks-button .btn--id--' + blockId;

	if(type == 'outline') {
		buttonClasses.push('btn--outline');
		// buttonClasses.push('btn--outline-' + colorSlug);
		buttonCss += buttonSelector + ' { border-color: ' + color + '; color: ' + color + '; }';
		buttonCss += buttonSelector + ':hover { color: ' + color + '; }';
	} else if(type == 'link') {
		buttonClasses.push('btn--link');
		// buttonClasses.push('btn--link-' + colorSlug);
		buttonCss += buttonSelector + '{ color: ' + color + '; }';
	} else if(type == 'cta') {
		buttonClasses.push('btn--cta');
		// buttonClasses.push('btn--cta-' + colorSlug);
		buttonClasses.push('btn--' + angle);
	} else {
		buttonClasses.push('btn--default');
		// buttonClasses.push('btn--' + colorSlug);
		buttonCss += buttonSelector + ' { background-color: ' + color + '; }';
		if(blockId) buttonClasses.push('btn--text-color-' + (CrownBlocks.isDarkColor(color) ? 'light' : 'dark'));
	}
	buttonCss += buttonSelector + ' { border-radius: ' + borderRadius + '; }';
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
			{!! (blockId && buttonCss) && <style type="text/css">{ buttonCss }</style> }
			<a href={ linkUrl } className={ buttonClasses.join(' ') } target={ openNewWindow && '_blank' } rel={ openNewWindow && 'noopener noreferrer' }>
				{ backArrow && <span className="btn__back-arrow"></span> }
				{ iconUrl && <img src={ iconUrl } className="btn__icon" aria-hidden="true" /> }
				<span className="btn-label">{ label }</span>
				{ linkArrow && <span className="btn__arrow"></span> }
			</a>
		</p>

	);
	
}
