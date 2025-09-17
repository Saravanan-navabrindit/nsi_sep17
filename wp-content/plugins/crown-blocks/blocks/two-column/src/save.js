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
 * Import required components for saving
 */
 const { InnerBlocks } = wp.blockEditor;

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
		columnBreakpoint,
		columnCount,
		
		columnLayoutXl,
		columnSpacingXl,

		overrideColumnLayoutLg,
		columnLayoutLg,
		columnSpacingLg,

		overrideColumnLayoutMd,
		columnLayoutMd,
		columnSpacingMd,

		overrideColumnLayoutSm,
		columnLayoutSm,
		columnSpacingSm,

		overrideColumnLayoutXs,
		columnLayoutXs,
		columnSpacingXs,

		middleBorder

	} = attributes;

	let blockClasses = [
		className
	];

	let blockStyle = {};

	blockClasses.push('column-breakpoint-' + columnBreakpoint);
	blockClasses.push('column-count-' + columnCount);

	let defaultLayoutBrakpoint = columnBreakpoint;
	if([ 'xs' ].includes(columnBreakpoint) && overrideColumnLayoutXs) {
		defaultLayoutBrakpoint = 'sm';
		blockClasses.push('column-layout-xs-' + columnLayoutXs);
		blockClasses.push('column-spacing-xs-' + columnSpacingXs);
	}
	if([ 'xs', 'sm' ].includes(columnBreakpoint) && overrideColumnLayoutSm) {
		defaultLayoutBrakpoint = 'md';
		blockClasses.push('column-layout-sm-' + columnLayoutSm);
		blockClasses.push('column-spacing-sm-' + columnSpacingSm);
	}
	if([ 'xs', 'sm', 'md' ].includes(columnBreakpoint) && overrideColumnLayoutMd) {
		defaultLayoutBrakpoint = 'lg';
		blockClasses.push('column-layout-md-' + columnLayoutMd);
		blockClasses.push('column-spacing-md-' + columnSpacingMd);
	}
	if([ 'xs', 'sm', 'md', 'lg' ].includes(columnBreakpoint) && overrideColumnLayoutLg) {
		defaultLayoutBrakpoint = 'xl';
		blockClasses.push('column-layout-lg-' + columnLayoutLg);
		blockClasses.push('column-spacing-lg-' + columnSpacingLg);
	}
	blockClasses.push('column-layout-' + defaultLayoutBrakpoint + '-' + columnLayoutXl);
	blockClasses.push('column-spacing-' + defaultLayoutBrakpoint + '-' + columnSpacingXl);

	if ( middleBorder ) {
		blockClasses.push('middle-border');
	}
	
	// This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag
	let customProps = {
		className: blockClasses.join(' '),
		style: blockStyle,
		key: 'two-column'
	};
	
	return (

		<div { ...useBlockProps.save( customProps ) }>
			<div className="inner">

				<div className="columns">
					<div className="inner">

						<InnerBlocks.Content />

					</div>
				</div>

			</div>
		</div>

	);

}
