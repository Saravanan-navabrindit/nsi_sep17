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
		// responsiveDeviceMode,
		// columnBreakpoint,
		// cellHorizontalAlignment,
		// cellVerticalAlignment,
		
		// columnCountXl,
		// columnSpacingXl,

		// overrideColumnLayoutLg,
		// columnCountLg,
		// columnSpacingLg,

		// overrideColumnLayoutMd,
		// columnCountMd,
		// columnSpacingMd,

		// overrideColumnLayoutSm,
		// columnCountSm,
		// columnSpacingSm,

		// overrideColumnLayoutXs,
		// columnCountXs,
		// columnSpacingXs

	} = attributes;

	let blockClasses = [
		className,
	];

	let blockStyle = {};

	// blockClasses.push('column-breakpoint-' + columnBreakpoint);

	// let defaultLayoutBrakpoint = columnBreakpoint;
	// if([ 'xs' ].includes(columnBreakpoint) && overrideColumnLayoutXs) {
	// 	defaultLayoutBrakpoint = 'sm';
	// 	blockClasses.push('column-count-xs-' + columnCountXs);
	// 	blockClasses.push('column-spacing-xs-' + columnSpacingXs);
	// }
	// if([ 'xs', 'sm' ].includes(columnBreakpoint) && overrideColumnLayoutSm) {
	// 	defaultLayoutBrakpoint = 'md';
	// 	blockClasses.push('column-count-sm-' + columnCountSm);
	// 	blockClasses.push('column-spacing-sm-' + columnSpacingSm);
	// }
	// if([ 'xs', 'sm', 'md' ].includes(columnBreakpoint) && overrideColumnLayoutMd) {
	// 	defaultLayoutBrakpoint = 'lg';
	// 	blockClasses.push('column-count-md-' + columnCountMd);
	// 	blockClasses.push('column-spacing-md-' + columnSpacingMd);
	// }
	// if([ 'xs', 'sm', 'md', 'lg' ].includes(columnBreakpoint) && overrideColumnLayoutLg) {
	// 	defaultLayoutBrakpoint = 'xl';
	// 	blockClasses.push('column-count-lg-' + columnCountLg);
	// 	blockClasses.push('column-spacing-lg-' + columnSpacingLg);
	// }
	// blockClasses.push('column-count-' + defaultLayoutBrakpoint + '-' + columnCountXl);
	// blockClasses.push('column-spacing-' + defaultLayoutBrakpoint + '-' + columnSpacingXl);

	// if(cellHorizontalAlignment != '') {
	// 	blockClasses.push('cell-horizontal-align-' + cellHorizontalAlignment);
	// }
	// if(cellVerticalAlignment != '') {
	// 	blockClasses.push('cell-vertical-align-' + cellVerticalAlignment);
	// }

	// This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag
	let customProps = {
		className: blockClasses.join(' '),
		style: blockStyle,
		key: 'process-step'
	};
	
	return (
		<div { ...useBlockProps.save( customProps ) }>
		<div className="line-one"></div>
		<div className="line-two"></div>
			<div className="inner">

				<div className="grid-cells">
					<div className="inner">

						<InnerBlocks.Content />

					</div>
				</div>

			</div>
		</div>
	);

}
