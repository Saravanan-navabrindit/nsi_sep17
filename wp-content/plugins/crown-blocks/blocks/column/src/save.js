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
		responsiveDeviceMode,

		overrideVerticalSpacingXl,
		paddingTopXl,
		paddingBottomXl,
		overflowBottomXl,
		overrideHorizontalSpacingXl,
		paddingLeftXl,
		paddingRightXl,

		overrideVerticalSpacingLg,
		paddingTopLg,
		paddingBottomLg,
		overflowBottomLg,
		overrideHorizontalSpacingLg,
		paddingLeftLg,
		paddingRightLg,

		overrideVerticalSpacingMd,
		paddingTopMd,
		paddingBottomMd,
		overflowBottomMd,
		overrideHorizontalSpacingMd,
		paddingLeftMd,
		paddingRightMd,

		overrideVerticalSpacingSm,
		paddingTopSm,
		paddingBottomSm,
		overflowBottomSm,
		overrideHorizontalSpacingSm,
		paddingLeftSm,
		paddingRightSm,

		overrideVerticalSpacingXs,
		paddingTopXs,
		paddingBottomXs,
		overflowBottomXs,
		overrideHorizontalSpacingXs,
		paddingLeftXs,
		paddingRightXs,

		verticalAlignment,

		enableShadow,
		columnPadding

	} = attributes;

	let blockClasses = [ className, 'column' ];

	let blockStyle = {};

	if(overrideHorizontalSpacingXl) {
		blockClasses.push('contents-pl-xl-' + paddingLeftXl);
		blockClasses.push('contents-pr-xl-' + paddingRightXl);
	}
	if(overrideVerticalSpacingXl) {
		blockClasses.push('contents-pt-xl-' + paddingTopXl);
		blockClasses.push('contents-pb-xl-' + paddingBottomXl);
		if(overflowBottomXl > 0) blockClasses.push('contents-ob-xl-' + overflowBottomXl);
	}

	if(overrideHorizontalSpacingLg) {
		blockClasses.push('contents-pl-lg-' + paddingLeftLg);
		blockClasses.push('contents-pr-lg-' + paddingRightLg);
	}
	if(overrideVerticalSpacingLg) {
		blockClasses.push('contents-pt-lg-' + paddingTopLg);
		blockClasses.push('contents-pb-lg-' + paddingBottomLg);
		if(overflowBottomLg > 0) blockClasses.push('contents-ob-lg-' + overflowBottomLg);
	}

	if(overrideHorizontalSpacingMd) {
		blockClasses.push('contents-pl-md-' + paddingLeftMd);
		blockClasses.push('contents-pr-md-' + paddingRightMd);
	}
	if(overrideVerticalSpacingMd) {
		blockClasses.push('contents-pt-md-' + paddingTopMd);
		blockClasses.push('contents-pb-md-' + paddingBottomMd);
		if(overflowBottomMd > 0) blockClasses.push('contents-ob-md-' + overflowBottomMd);
	}

	if(overrideHorizontalSpacingSm) {
		blockClasses.push('contents-pl-sm-' + paddingLeftSm);
		blockClasses.push('contents-pr-sm-' + paddingRightSm);
	}
	if(overrideVerticalSpacingSm) {
		blockClasses.push('contents-pt-sm-' + paddingTopSm);
		blockClasses.push('contents-pb-sm-' + paddingBottomSm);
		if(overflowBottomSm > 0) blockClasses.push('contents-ob-sm-' + overflowBottomSm);
	}

	if(overrideHorizontalSpacingXs) {
		blockClasses.push('contents-pl-' + paddingLeftXs);
		blockClasses.push('contents-pr-' + paddingRightXs);
	}
	if(overrideVerticalSpacingXs) {
		blockClasses.push('contents-pt-' + paddingTopXs);
		blockClasses.push('contents-pb-' + paddingBottomXs);
		if(overflowBottomXs > 0) blockClasses.push('contents-ob-' + overflowBottomXs);
	}

	if(verticalAlignment != '') blockClasses.push('vertical-alignment-' + verticalAlignment);

	if ( enableShadow ) {
		blockClasses.push('enable-shadow');
	}

	let blockInnerStyles = {};
	if ( enableShadow && typeof columnPadding !== 'undefined' ) {
		blockInnerStyles.padding = columnPadding + 'px';
		
		if ( columnPadding > 30 ) {
			blockClasses.push( 'large-padding' );
		}
	}

	// This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag
	let customProps = {
		className: blockClasses.join(' '),
		style: blockStyle,
		key: 'column'
	};
	
	return (
		<div { ...useBlockProps.save( customProps ) }>
			<div className="inner" style={ blockInnerStyles }>

			<div className="column-contents">
				<div className="inner">

					<InnerBlocks.Content />

				</div>
			</div>

			</div>
		</div>
	);
	
}
