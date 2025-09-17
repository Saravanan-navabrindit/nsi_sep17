
/**
 * Import Crown helper functions
 */
import CrownBlocks from '../../../common.js';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
 */
import { useBlockProps } from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * Import required components for editing
 */
const { InnerBlocks, RichText, MediaUpload, BlockControls, AlignmentToolbar, InspectorControls, PanelColorSettings } = wp.blockEditor;
const { PanelBody, RadioControl, CheckboxControl, ColorPicker, RangeControl, FocalPointPicker, ToggleControl, TextControl, TextareaControl, SelectControl, Button, ButtonGroup, Icon, BaseControl } = wp.components;
const { getColorObjectByColorValue } = wp.blockEditor;

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit( { attributes, className, isSelected, setAttributes } ) {

	const TEMPLATE = [
		[ 'core/heading', { placeholder: 'Page Section Title...', level: '2' } ], // defaults to H1 tag for header block
		[ 'core/paragraph', {} ]
	];

	const {
		textAlign,
		contentAlign,
		responsiveDeviceMode,
		restrictContentWidth,
		contentsMaxWidth,
		slantedBg,
		slantedBgTop,
		slantedBgTopReverse,
		slantedBgBottom,
		slantedBgBottomReverse,
		fullWidth,

		overrideVerticalSpacingXl,
		paddingTopXl,
		paddingBottomXl,
		overflowTopXl,
		overflowBottomXl,
		overrideHorizontalSpacingXl,
		paddingXXl,
		overflowXXl,

		overrideVerticalSpacingLg,
		paddingTopLg,
		paddingBottomLg,
		overflowTopLg,
		overflowBottomLg,
		overrideHorizontalSpacingLg,
		paddingXLg,
		overflowXLg,

		overrideVerticalSpacingMd,
		paddingTopMd,
		paddingBottomMd,
		overflowTopMd,
		overflowBottomMd,
		overrideHorizontalSpacingMd,
		paddingXMd,
		overflowXMd,

		overrideVerticalSpacingSm,
		paddingTopSm,
		paddingBottomSm,
		overflowTopSm,
		overflowBottomSm,
		overrideHorizontalSpacingSm,
		paddingXSm,
		overflowXSm,

		overrideVerticalSpacingXs,
		paddingTopXs,
		paddingBottomXs,
		overflowTopXs,
		overflowBottomXs,
		overrideHorizontalSpacingXs,
		paddingXXs,
		overflowXXs,
		
		backgroundColor,
		backgroundImageId,
		backgroundImageData,
		backgroundImageFocalPoint,
		backgroundImageOpacity,
		backgroundImageGrayscale,
		backgroundImageBlendMode,
		backgroundImageContain,
		textColor,

		lineStyle
	} = attributes;

	let blockClasses = [ className ];

	if ( fullWidth ) {
		blockClasses.push('full-width');
	}

	if ( restrictContentWidth ) {
		blockClasses.push('restricted-content-width');
	}

	if ( contentAlign ) {
		blockClasses.push('content-align-' + contentAlign);
	}

	if ( textAlign ) {
		blockClasses.push('text-align-' + textAlign);
	}

	if(textColor == 'auto' && backgroundColor) {
		blockClasses.push('text-color-' + (CrownBlocks.isDarkColor(backgroundColor) ? 'light' : 'dark'));
	} else if(textColor != 'auto') {
		blockClasses.push('text-color-' + textColor);
	}

	if(lineStyle) {
		blockClasses.push('line');
		blockClasses.push('line-' + lineStyle);
	}

	let blockStyle = {};
	if(backgroundColor) {
		blockStyle.backgroundColor = backgroundColor;
		let settings = wp.data.select('core/editor').getEditorSettings();
		// if(settings.colors) {
		// 	let colorObject = getColorObjectByColorValue(settings.colors, backgroundColor);
		// 	if(colorObject) blockClasses.push('bg-color-' + colorObject.slug);
		// }
	}

	if ( slantedBg ) {
		if ( slantedBgTop ) {
			blockClasses.push('slanted-bg-top');

			if ( slantedBgTopReverse ) {
				blockClasses.push('slanted-bg-top-reverse')
			}
		}
		if ( slantedBgBottom ) {
			blockClasses.push('slanted-bg-bottom');

			if ( slantedBgBottomReverse ) {
				blockClasses.push('slanted-bg-bottom-reverse')
			}
		}
	}

	if(overrideVerticalSpacingXl) {
		blockClasses.push('contents-pt-xl-' + paddingTopXl);
		blockClasses.push('contents-pb-xl-' + paddingBottomXl);
		if(overflowTopXl > 0) blockClasses.push('contents-ot-xl-' + overflowTopXl);
		if(overflowBottomXl > 0) blockClasses.push('contents-ob-xl-' + overflowBottomXl);
	}
	if(overrideHorizontalSpacingXl) {
		blockClasses.push('contents-px-xl-' + paddingXXl);
		if(overflowXXl > 0) blockClasses.push('contents-ox-xl-' + overflowXXl);
	}

	if(overrideVerticalSpacingLg) {
		blockClasses.push('contents-pt-lg-' + paddingTopLg);
		blockClasses.push('contents-pb-lg-' + paddingBottomLg);
		if(overflowTopLg > 0) blockClasses.push('contents-ot-lg-' + overflowTopLg);
		if(overflowBottomLg > 0) blockClasses.push('contents-ob-lg-' + overflowBottomLg);
	}
	if(overrideHorizontalSpacingLg) {
		blockClasses.push('contents-px-lg-' + paddingXLg);
		if(overflowXLg > 0) blockClasses.push('contents-ox-lg-' + overflowXLg);
	}

	if(overrideVerticalSpacingMd) {
		blockClasses.push('contents-pt-md-' + paddingTopMd);
		blockClasses.push('contents-pb-md-' + paddingBottomMd);
		if(overflowTopMd > 0) blockClasses.push('contents-ot-md-' + overflowTopMd);
		if(overflowBottomMd > 0) blockClasses.push('contents-ob-md-' + overflowBottomMd);
	}
	if(overrideHorizontalSpacingMd) {
		blockClasses.push('contents-px-md-' + paddingXMd);
		if(overflowXMd > 0) blockClasses.push('contents-ox-md-' + overflowXMd);
	}

	if(overrideVerticalSpacingSm) {
		blockClasses.push('contents-pt-sm-' + paddingTopSm);
		blockClasses.push('contents-pb-sm-' + paddingBottomSm);
		if(overflowTopSm > 0) blockClasses.push('contents-ot-sm-' + overflowTopSm);
		if(overflowBottomSm > 0) blockClasses.push('contents-ob-sm-' + overflowBottomSm);
	}
	if(overrideHorizontalSpacingSm) {
		blockClasses.push('contents-px-sm-' + paddingXSm);
		if(overflowXSm > 0) blockClasses.push('contents-ox-sm-' + overflowXSm);
	}

	if(overrideVerticalSpacingXs) {
		blockClasses.push('contents-pt-' + paddingTopXs);
		blockClasses.push('contents-pb-' + paddingBottomXs);
		if(overflowTopXs > 0) blockClasses.push('contents-ot-' + overflowTopXs);
		if(overflowBottomXs > 0) blockClasses.push('contents-ob-' + overflowBottomXs);
	}
	if(overrideHorizontalSpacingXs) {
		blockClasses.push('contents-ps-' + paddingXXs);
		if(overflowXXs > 0) blockClasses.push('contents-ox-' + overflowXXs);
	}

	let backgroundImageUrl = null;
	if(backgroundImageId) {
		backgroundImageUrl = backgroundImageData.sizes.fullscreen ? backgroundImageData.sizes.fullscreen.url : backgroundImageData.url;
		blockClasses.push('has-bg-image');
	}

	let bgColorSettings = [{
		label: 'Background Color',
		value: backgroundColor,
		onChange: (value) => setAttributes({ backgroundColor: value ? value : '' })
	}];

	// This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag
	let customProps = {
		className: blockClasses.join(' '),
		style: blockStyle,
		key: 'page-section'
	};

	return [

		<InspectorControls key="inspector-controls">

			<div class="crown-blocks-responsive-device-mode-toggles">
				<ButtonGroup>
					<Button isPrimary={ responsiveDeviceMode == 'xl' } onClick={ (e) => setAttributes({ responsiveDeviceMode: 'xl' }) }>
						<span class="inner">
							<Icon icon={
								<svg class="bi bi-display" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
									<path d="M5.75 13.5c.167-.333.25-.833.25-1.5h4c0 .667.083 1.167.25 1.5H11a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1h.75z"/>
									<path fill-rule="evenodd" d="M13.991 3H2c-.325 0-.502.078-.602.145a.758.758 0 0 0-.254.302A1.46 1.46 0 0 0 1 4.01V10c0 .325.078.502.145.602.07.105.17.188.302.254a1.464 1.464 0 0 0 .538.143L2.01 11H14c.325 0 .502-.078.602-.145a.758.758 0 0 0 .254-.302 1.464 1.464 0 0 0 .143-.538L15 9.99V4c0-.325-.078-.502-.145-.602a.757.757 0 0 0-.302-.254A1.46 1.46 0 0 0 13.99 3zM14 2H2C0 2 0 4 0 4v6c0 2 2 2 2 2h12c2 0 2-2 2-2V4c0-2-2-2-2-2z"/>
								</svg>
							} />
							<span class="label">Desktop <span class="sub-label">Widescreen</span> <span class="sub-label">1200px</span></span>
						</span>
					</Button>
					<Button isPrimary={ responsiveDeviceMode == 'lg' } onClick={ (e) => setAttributes({ responsiveDeviceMode: 'lg' }) }>
						<span class="inner">
							<Icon icon={
								<svg class="bi bi-tablet-landscape" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
									<path fill-rule="evenodd" d="M1 4v8a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1zm-1 8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v8z"/>
									<path fill-rule="evenodd" d="M14 8a1 1 0 1 0-2 0 1 1 0 0 0 2 0z"/>
								</svg>
							} />
							<span class="label">Tablet <span class="sub-label">Landscape</span> <span class="sub-label">992px</span></span>
						</span>
					</Button>
					<Button isPrimary={ responsiveDeviceMode == 'md' } onClick={ (e) => setAttributes({ responsiveDeviceMode: 'md' }) }>
						<span class="inner">
							<Icon icon={
								<svg class="bi bi-tablet" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
									<path fill-rule="evenodd" d="M12 1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>
									<path fill-rule="evenodd" d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
								</svg>
							} />
							<span class="label">Tablet <span class="sub-label">Portrait</span> <span class="sub-label">768px</span></span>
						</span>
					</Button>
					<Button isPrimary={ responsiveDeviceMode == 'sm' } onClick={ (e) => setAttributes({ responsiveDeviceMode: 'sm' }) }>
						<span class="inner">
							<Icon icon={
								<svg class="bi bi-phone-landscape" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
									<path fill-rule="evenodd" d="M1 4.5v6a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1zm-1 6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v6z"/>
									<path fill-rule="evenodd" d="M14 7.5a1 1 0 1 0-2 0 1 1 0 0 0 2 0z"/>
								</svg>
							} />
							<span class="label">Mobile <span class="sub-label">Landscape</span> <span class="sub-label">576px</span></span>
						</span>
					</Button>
					<Button isPrimary={ responsiveDeviceMode == 'xs' } onClick={ (e) => setAttributes({ responsiveDeviceMode: 'xs' }) }>
						<span class="inner">
							<Icon icon={
								<svg class="bi bi-phone" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
									<path fill-rule="evenodd" d="M11 1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z"/>
									<path fill-rule="evenodd" d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
								</svg>
							} />
							<span class="label">Mobile <span class="sub-label">Portrait</span> <span class="sub-label">Base</span></span>
						</span>
					</Button>
				</ButtonGroup>
			</div>

			{ responsiveDeviceMode == 'xl' && <PanelBody title={ 'Spacing' } initialOpen={ false }>

				<ToggleControl
					label={ 'Restrict content width' }
					checked={ restrictContentWidth }
					onChange={ (value) => { setAttributes({ restrictContentWidth: value }); } }
				/>

				{ !! restrictContentWidth && <RangeControl
					label="Max Content Width"
					value={ contentsMaxWidth }
					onChange={ (value) => setAttributes({ contentsMaxWidth: value }) }
					min={ 100 }
					max={ 1260 }
					step={ 10 }
				/> }

				{ restrictContentWidth && <BaseControl label="Content Alignment"><ButtonGroup>
					<Button isPrimary={ contentAlign == 'left' } isSecondary={ contentAlign != 'left' } onClick={ (e) => setAttributes({ contentAlign: 'left' }) }>Left</Button>
					<Button isPrimary={ contentAlign == 'center' } isSecondary={ contentAlign != 'center' } onClick={ (e) => setAttributes({ contentAlign: 'center' }) }>Center</Button>
					<Button isPrimary={ contentAlign == 'right' } isSecondary={ contentAlign != 'right' } onClick={ (e) => setAttributes({ contentAlign: 'right' }) }>Right</Button>
				</ButtonGroup></BaseControl> }

				<ToggleControl
					label={ 'Override vertical spacing' }
					checked={ overrideVerticalSpacingXl }
					onChange={ (value) => { setAttributes({ overrideVerticalSpacingXl: value }); } }
				/>

				{ !! overrideVerticalSpacingXl && <RangeControl
					label="Top Padding"
					value={ paddingTopXl }
					onChange={ (value) => setAttributes({ paddingTopXl: value }) }
					min={ 0 }
					max={ 20 }
				/> }

				{ !! overrideVerticalSpacingXl && <RangeControl
					label="Bottom Padding"
					value={ paddingBottomXl }
					onChange={ (value) => setAttributes({ paddingBottomXl: value }) }
					min={ 0 }
					max={ 20 }
				/> }

				{ !! overrideVerticalSpacingXl && <RangeControl
					label="Top Overflow"
					value={ overflowTopXl }
					onChange={ (value) => setAttributes({ overflowTopXl: value }) }
					min={ 0 }
					max={ 20 }
				/> }

				{ !! overrideVerticalSpacingXl && <RangeControl
					label="Bottom Overflow"
					value={ overflowBottomXl }
					onChange={ (value) => setAttributes({ overflowBottomXl: value }) }
					min={ 0 }
					max={ 20 }
				/> }

				<ToggleControl
					label={ 'Override horizontal spacing' }
					checked={ overrideHorizontalSpacingXl }
					onChange={ (value) => { setAttributes({ overrideHorizontalSpacingXl: value }); } }
				/>

				{ !! overrideHorizontalSpacingXl && <RangeControl
					label="Horizontal Padding"
					value={ paddingXXl }
					onChange={ (value) => setAttributes({ paddingXXl: value }) }
					min={ 0 }
					max={ 20 }
				/> }

				{ !! overrideHorizontalSpacingXl && <RangeControl
					label="Horizontal Overflow"
					value={ overflowXXl }
					onChange={ (value) => setAttributes({ overflowXXl: value }) }
					min={ 0 }
					max={ 20 }
				/> }

				<ToggleControl
					label={ 'Enable Slanted Section Background' }
					checked={ slantedBg }
					onChange={ (value) => { setAttributes({ slantedBg: value }); } }
				/>

				{ slantedBg && <ToggleControl
					label={ 'Background Slanted at Top' }
					checked={ slantedBgTop }
					onChange={ (value) => { setAttributes({ slantedBgTop: value }); } }
				/> }

				{ slantedBg && slantedBgTop && <ToggleControl
					label={ 'Reverse Top Slant' }
					checked={ slantedBgTopReverse }
					onChange={ (value) => { setAttributes({ slantedBgTopReverse: value }); } }
				/> }

				{ slantedBg && <ToggleControl
					label={ 'Background Slanted at Bottom' }
					checked={ slantedBgBottom }
					onChange={ (value) => { setAttributes({ slantedBgBottom: value }); } }
				/> }

				{ slantedBg && slantedBgBottom && <ToggleControl
					label={ 'Reverse Bottom Slant' }
					checked={ slantedBgBottomReverse }
					onChange={ (value) => { setAttributes({ slantedBgBottomReverse: value }); } }
				/> }

			</PanelBody> }

			{ responsiveDeviceMode == 'lg' && <PanelBody title={ 'Spacing' } initialOpen={ true }>

				<ToggleControl
					label={ 'Override vertical spacing' }
					checked={ overrideVerticalSpacingLg }
					onChange={ (value) => { setAttributes({ overrideVerticalSpacingLg: value }); } }
				/>

				{ !! overrideVerticalSpacingLg && <RangeControl
					label="Top Padding"
					value={ paddingTopLg }
					onChange={ (value) => setAttributes({ paddingTopLg: value }) }
					min={ 0 }
					max={ 20 }
				/> }

				{ !! overrideVerticalSpacingLg && <RangeControl
					label="Bottom Padding"
					value={ paddingBottomLg }
					onChange={ (value) => setAttributes({ paddingBottomLg: value }) }
					min={ 0 }
					max={ 20 }
				/> }

				{ !! overrideVerticalSpacingLg && <RangeControl
					label="Top Overflow"
					value={ overflowTopLg }
					onChange={ (value) => setAttributes({ overflowTopLg: value }) }
					min={ 0 }
					max={ 20 }
				/> }

				{ !! overrideVerticalSpacingLg && <RangeControl
					label="Bottom Overflow"
					value={ overflowBottomLg }
					onChange={ (value) => setAttributes({ overflowBottomLg: value }) }
					min={ 0 }
					max={ 20 }
				/> }

				<ToggleControl
					label={ 'Override horizontal spacing' }
					checked={ overrideHorizontalSpacingLg }
					onChange={ (value) => { setAttributes({ overrideHorizontalSpacingLg: value }); } }
				/>

				{ !! overrideHorizontalSpacingLg && <RangeControl
					label="Horizontal Padding"
					value={ paddingXLg }
					onChange={ (value) => setAttributes({ paddingXLg: value }) }
					min={ 0 }
					max={ 20 }
				/> }

				{ !! overrideHorizontalSpacingLg && <RangeControl
					label="Horizontal Overflow"
					value={ overflowXLg }
					onChange={ (value) => setAttributes({ overflowXLg: value }) }
					min={ 0 }
					max={ 20 }
				/> }

			</PanelBody> }

			{ responsiveDeviceMode == 'md' && <PanelBody title={ 'Spacing' } initialOpen={ true }>

				<ToggleControl
					label={ 'Override vertical spacing' }
					checked={ overrideVerticalSpacingMd }
					onChange={ (value) => { setAttributes({ overrideVerticalSpacingMd: value }); } }
				/>

				{ !! overrideVerticalSpacingMd && <RangeControl
					label="Top Padding"
					value={ paddingTopMd }
					onChange={ (value) => setAttributes({ paddingTopMd: value }) }
					min={ 0 }
					max={ 20 }
				/> }

				{ !! overrideVerticalSpacingMd && <RangeControl
					label="Bottom Padding"
					value={ paddingBottomMd }
					onChange={ (value) => setAttributes({ paddingBottomMd: value }) }
					min={ 0 }
					max={ 20 }
				/> }

				{ !! overrideVerticalSpacingMd && <RangeControl
					label="Top Overflow"
					value={ overflowTopMd }
					onChange={ (value) => setAttributes({ overflowTopMd: value }) }
					min={ 0 }
					max={ 20 }
				/> }

				{ !! overrideVerticalSpacingMd && <RangeControl
					label="Bottom Overflow"
					value={ overflowBottomMd }
					onChange={ (value) => setAttributes({ overflowBottomMd: value }) }
					min={ 0 }
					max={ 20 }
				/> }

				<ToggleControl
					label={ 'Override horizontal spacing' }
					checked={ overrideHorizontalSpacingMd }
					onChange={ (value) => { setAttributes({ overrideHorizontalSpacingMd: value }); } }
				/>

				{ !! overrideHorizontalSpacingMd && <RangeControl
					label="Horizontal Padding"
					value={ paddingXMd }
					onChange={ (value) => setAttributes({ paddingXMd: value }) }
					min={ 0 }
					max={ 20 }
				/> }

				{ !! overrideHorizontalSpacingMd && <RangeControl
					label="Horizontal Overflow"
					value={ overflowXMd }
					onChange={ (value) => setAttributes({ overflowXMd: value }) }
					min={ 0 }
					max={ 20 }
				/> }

			</PanelBody> }

			{ responsiveDeviceMode == 'sm' && <PanelBody title={ 'Spacing' } initialOpen={ true }>

				<ToggleControl
					label={ 'Override vertical spacing' }
					checked={ overrideVerticalSpacingSm }
					onChange={ (value) => { setAttributes({ overrideVerticalSpacingSm: value }); } }
				/>

				{ !! overrideVerticalSpacingSm && <RangeControl
					label="Top Padding"
					value={ paddingTopSm }
					onChange={ (value) => setAttributes({ paddingTopSm: value }) }
					min={ 0 }
					max={ 20 }
				/> }

				{ !! overrideVerticalSpacingSm && <RangeControl
					label="Bottom Padding"
					value={ paddingBottomSm }
					onChange={ (value) => setAttributes({ paddingBottomSm: value }) }
					min={ 0 }
					max={ 20 }
				/> }

				{ !! overrideVerticalSpacingSm && <RangeControl
					label="Top Overflow"
					value={ overflowTopSm }
					onChange={ (value) => setAttributes({ overflowTopSm: value }) }
					min={ 0 }
					max={ 20 }
				/> }

				{ !! overrideVerticalSpacingSm && <RangeControl
					label="Bottom Overflow"
					value={ overflowBottomSm }
					onChange={ (value) => setAttributes({ overflowBottomSm: value }) }
					min={ 0 }
					max={ 20 }
				/> }

				<ToggleControl
					label={ 'Override horizontal spacing' }
					checked={ overrideHorizontalSpacingSm }
					onChange={ (value) => { setAttributes({ overrideHorizontalSpacingSm: value }); } }
				/>

				{ !! overrideHorizontalSpacingSm && <RangeControl
					label="Horizontal Padding"
					value={ paddingXSm }
					onChange={ (value) => setAttributes({ paddingXSm: value }) }
					min={ 0 }
					max={ 20 }
				/> }

				{ !! overrideHorizontalSpacingSm && <RangeControl
					label="Horizontal Overflow"
					value={ overflowXSm }
					onChange={ (value) => setAttributes({ overflowXSm: value }) }
					min={ 0 }
					max={ 20 }
				/> }

			</PanelBody> }

			{ responsiveDeviceMode == 'xs' && <PanelBody title={ 'Spacing' } initialOpen={ true }>

				<ToggleControl
					label={ 'Override vertical spacing' }
					checked={ overrideVerticalSpacingXs }
					onChange={ (value) => { setAttributes({ overrideVerticalSpacingXs: value }); } }
				/>

				{ !! overrideVerticalSpacingXs && <RangeControl
					label="Top Padding"
					value={ paddingTopXs }
					onChange={ (value) => setAttributes({ paddingTopXs: value }) }
					min={ 0 }
					max={ 20 }
				/> }

				{ !! overrideVerticalSpacingXs && <RangeControl
					label="Bottom Padding"
					value={ paddingBottomXs }
					onChange={ (value) => setAttributes({ paddingBottomXs: value }) }
					min={ 0 }
					max={ 20 }
				/> }

				{ !! overrideVerticalSpacingXs && <RangeControl
					label="Top Overflow"
					value={ overflowTopXs }
					onChange={ (value) => setAttributes({ overflowTopXs: value }) }
					min={ 0 }
					max={ 20 }
				/> }

				{ !! overrideVerticalSpacingXs && <RangeControl
					label="Bottom Overflow"
					value={ overflowBottomXs }
					onChange={ (value) => setAttributes({ overflowBottomXs: value }) }
					min={ 0 }
					max={ 20 }
				/> }

				<ToggleControl
					label={ 'Override horizontal spacing' }
					checked={ overrideHorizontalSpacingXs }
					onChange={ (value) => { setAttributes({ overrideHorizontalSpacingXs: value }); } }
				/>

				{ !! overrideHorizontalSpacingXs && <RangeControl
					label="Horizontal Padding"
					value={ paddingXXs }
					onChange={ (value) => setAttributes({ paddingXXs: value }) }
					min={ 0 }
					max={ 20 }
				/> }

				{ !! overrideHorizontalSpacingXs && <RangeControl
					label="Horizontal Overflow"
					value={ overflowXXs }
					onChange={ (value) => setAttributes({ overflowXXs: value }) }
					min={ 0 }
					max={ 20 }
				/> }

			</PanelBody> }

			{ responsiveDeviceMode == 'xl' && <PanelColorSettings
				title={ 'Background Color' }
				initialOpen={ false }
				colorSettings={ bgColorSettings }
			/> }

			{ responsiveDeviceMode == 'xl' && <PanelBody title={ 'Background Image' } className={ 'crown-blocks-background-image' } initialOpen={ false }>

				{ !! backgroundImageId && <FocalPointPicker 
					label="Focal Point"
					url={ backgroundImageData.sizes.medium ? backgroundImageData.sizes.medium.url : backgroundImageData.sizes.thumbnail.url }
					dimensions={ { width: 400, height: 100 } }
					value={ backgroundImageFocalPoint }
					onChange={ (value) => setAttributes({ backgroundImageFocalPoint: value }) } 
				/> }

				<MediaUpload
					onSelect={ (media) => { setAttributes({ backgroundImageId: media.id, backgroundImageData: media, backgroundImageFocalPoint: { x: 0.5, y: 0.5 } }); } }
					type="image"
					value={ backgroundImageId }
					render={ ({ open }) => (
						<div className={ 'crown-blocks-media-upload' }>
							{/* { backgroundImageId && <Button className={ 'image-preview' } onClick={ open }><img src={ backgroundImageData.sizes.medium ? backgroundImageData.sizes.medium.url : backgroundImageData.sizes.thumbnail.url } /></Button> } */}
							<Button className={ 'button' } onClick={ open }>Select Image</Button>
							{ backgroundImageId && <Button className={ 'button is-link is-destructive' } onClick={ (e) => { setAttributes({ backgroundImageId: null, backgroundImageData: null }); } }>Remove Image</Button> }
						</div>
					) }
				/>

				{ !! backgroundImageId && <RangeControl
					label="Opacity"
					value={ backgroundImageOpacity }
					onChange={ (value) => setAttributes({ backgroundImageOpacity: value }) }
					min={ 0 }
					max={ 100 }
				/> }

				{ !! backgroundImageId && <RangeControl
					label="Grayscale"
					value={ backgroundImageGrayscale }
					onChange={ (value) => setAttributes({ backgroundImageGrayscale: value }) }
					min={ 0 }
					max={ 100 }
				/> }

				{ !! backgroundImageId && <SelectControl
					label="Blend Mode"
					value={ backgroundImageBlendMode }
					onChange={ (value) => setAttributes({ backgroundImageBlendMode: value }) }
					options={ [
						{ label: 'Normal', value: 'normal' },
						{ label: 'Multiply', value: 'multiply' },
						{ label: 'Screen', value: 'screen' },
						{ label: 'Overlay', value: 'overlay' },
						{ label: 'Soft Light', value: 'soft-light' },
						{ label: 'Hard Light', value: 'hard-light' },
						{ label: 'Darken', value: 'darken' },
						{ label: 'Lighten', value: 'lighten' }
					] }
				/> }

				{ !! backgroundImageId && <ToggleControl
					label={ 'Contain background image' }
					checked={ backgroundImageContain }
					onChange={ (value) => { setAttributes({ backgroundImageContain: value }); } }
				/> }

			</PanelBody> }

			<PanelBody title={ 'Text Alignment' } initialOpen={ false }>

				<ButtonGroup>
					<Button isPrimary={ textAlign == 'left' } isSecondary={ textAlign != 'left' } onClick={ (e) => setAttributes({ textAlign: 'left' }) }>Left</Button>
					<Button isPrimary={ textAlign == 'center' } isSecondary={ textAlign != 'center' } onClick={ (e) => setAttributes({ textAlign: 'center' }) }>Center</Button>
					<Button isPrimary={ textAlign == 'right' } isSecondary={ textAlign != 'right' } onClick={ (e) => setAttributes({ textAlign: 'right' }) }>Right</Button>
				</ButtonGroup>

			</PanelBody>

			{ responsiveDeviceMode == 'xl' && <PanelBody title={ 'Text Settings' } initialOpen={ false }>

				<BaseControl label={ 'Text Color' }>
					<ButtonGroup>
						<Button isPrimary={ textColor == 'auto' } isSecondary={ textColor != 'auto' } onClick={ (e) => setAttributes({ textColor: 'auto' }) }>Auto</Button>
						<Button isPrimary={ textColor == 'dark' } isSecondary={ textColor != 'dark' } onClick={ (e) => setAttributes({ textColor: 'dark' }) }>Dark</Button>
						<Button isPrimary={ textColor == 'light' } isSecondary={ textColor != 'light' } onClick={ (e) => setAttributes({ textColor: 'light' }) }>Light</Button>
					</ButtonGroup>
				</BaseControl>

			</PanelBody> }

			<PanelBody title={ 'Style' } initialOpen={ false }>
				<SelectControl
					label="Line Style"
					value={ lineStyle }
					onChange={ (value) => setAttributes({ lineStyle: value }) }
					options={ [
						{ label: 'None', value: '' },
						{ label: 'Both Sides', value: 'both-sides' },
						{ label: 'Left', value: 'left' },
						{ label: 'Middle Bottom', value: 'middle-bottom' },
						{ label: 'Middle', value: 'middle' }
					] }
				/>
			</PanelBody>

		</InspectorControls>,

		<div { ...useBlockProps( customProps ) }>
			<div className="section-bg">
				{ backgroundImageUrl && <div className={ 'bg-image' } style={ {
					backgroundImage: 'url(' + backgroundImageUrl + ')',
					opacity: (backgroundImageOpacity / 100),
					backgroundPosition: `${ backgroundImageFocalPoint.x * 100 }% ${ backgroundImageFocalPoint.y * 100 }%`,
					filter: `grayscale(${ backgroundImageGrayscale / 100 })`,
					mixBlendMode: backgroundImageBlendMode,
					backgroundSize: backgroundImageContain ? 'contain' : 'cover'
				} }></div> }
			</div>
			<div className="inner">
				<div className="container">
					<div className="inner" style={ restrictContentWidth ? { maxWidth: contentsMaxWidth + 'px' } : {} }>

						<InnerBlocks template={ TEMPLATE } />
						
					</div>
				</div>
			</div>
		</div>

	];
	
}

// let styles = [
// 	{ name: 'hero', label: 'Hero' }
// ];
// wp.blocks.registerBlockStyle('crown-blocks/page-section', styles);
