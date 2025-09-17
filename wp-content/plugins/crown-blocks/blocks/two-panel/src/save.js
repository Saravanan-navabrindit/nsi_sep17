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
		panelBreakpoint,
		panelCount,
		
		panelLayoutXl,

		overridePanelLayoutLg,
		panelLayoutLg,

		overridePanelLayoutMd,
		panelLayoutMd,

		overridePanelLayoutSm,
		panelLayoutSm,

		overridePanelLayoutXs,
		panelLayoutXs,

	} = attributes;

	let blockClasses = [
		className
	];

	let blockStyle = {};

	blockClasses.push('panel-breakpoint-' + panelBreakpoint);
	blockClasses.push('panel-count-' + panelCount);

	let defaultLayoutBrakpoint = panelBreakpoint;
	if([ 'xs' ].includes(panelBreakpoint) && overridePanelLayoutXs) {
		defaultLayoutBrakpoint = 'sm';
		blockClasses.push('panel-layout-xs-' + panelLayoutXs);
	}
	if([ 'xs', 'sm' ].includes(panelBreakpoint) && overridePanelLayoutSm) {
		defaultLayoutBrakpoint = 'md';
		blockClasses.push('panel-layout-sm-' + panelLayoutSm);
	}
	if([ 'xs', 'sm', 'md' ].includes(panelBreakpoint) && overridePanelLayoutMd) {
		defaultLayoutBrakpoint = 'lg';
		blockClasses.push('panel-layout-md-' + panelLayoutMd);
	}
	if([ 'xs', 'sm', 'md', 'lg' ].includes(panelBreakpoint) && overridePanelLayoutLg) {
		defaultLayoutBrakpoint = 'xl';
		blockClasses.push('panel-layout-lg-' + panelLayoutLg);
	}
	blockClasses.push('panel-layout-' + defaultLayoutBrakpoint + '-' + panelLayoutXl);
	
	// This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag
	let customProps = {
		className: blockClasses.join(' '),
		style: blockStyle,
		key: 'two-panel'
	};
	
	return (

		<div { ...useBlockProps.save( customProps ) }>
			<div className="inner">

				<div className="panels">
					<div className="inner">

						<InnerBlocks.Content />

					</div>
				</div>

			</div>
		</div>

	);

}
