
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
const { InnerBlocks, InspectorControls } = wp.blockEditor;
const { PanelBody, RadioControl, ColorPicker, Button, ButtonGroup, Icon, RangeControl, FocalPointPicker, ToggleControl, TextControl, TextareaControl, SelectControl, BaseControl } = wp.components;

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit( { attributes, className, isSelected, setAttributes } ) {

	const ALLOWED_BLOCKS = [ 'crown-blocks/process-step-cell' ];
	
	const TEMPLATE = [
		[ 'crown-blocks/process-step-cell', {}, [
			[ 'core/heading', { placeholder: 'Enter cell title...', level: 4 } ],
			['crown-blocks/step-heading', {title: 'Step'}],
			[ 'core/paragraph', { placeholder: 'Enter cell content...' } ]
		] ]
	];

	const {
		
		responsiveDeviceMode,
		columnBreakpoint,
		cellHorizontalAlignment,
		cellVerticalAlignment,
		
		columnCountXl,
		columnSpacingXl,

		overrideColumnLayoutLg,
		columnCountLg,
		columnSpacingLg,

		overrideColumnLayoutMd,
		columnCountMd,
		columnSpacingMd,

		overrideColumnLayoutSm,
		columnCountSm,
		columnSpacingSm,

		overrideColumnLayoutXs,
		columnCountXs,
		columnSpacingXs

	} = attributes;

	let blockClasses = [
		className,
	];

	let blockStyle = {};

	blockClasses.push('column-breakpoint-' + columnBreakpoint);

	let defaultLayoutBrakpoint = columnBreakpoint;
	if([ 'xs' ].includes(columnBreakpoint) && overrideColumnLayoutXs) {
		defaultLayoutBrakpoint = 'sm';
		blockClasses.push('column-count-xs-' + columnCountXs);
		blockClasses.push('column-spacing-xs-' + columnSpacingXs);
	}
	if([ 'xs', 'sm' ].includes(columnBreakpoint) && overrideColumnLayoutSm) {
		defaultLayoutBrakpoint = 'md';
		blockClasses.push('column-count-sm-' + columnCountSm);
		blockClasses.push('column-spacing-sm-' + columnSpacingSm);
	}
	if([ 'xs', 'sm', 'md' ].includes(columnBreakpoint) && overrideColumnLayoutMd) {
		defaultLayoutBrakpoint = 'lg';
		blockClasses.push('column-count-md-' + columnCountMd);
		blockClasses.push('column-spacing-md-' + columnSpacingMd);
	}
	if([ 'xs', 'sm', 'md', 'lg' ].includes(columnBreakpoint) && overrideColumnLayoutLg) {
		defaultLayoutBrakpoint = 'xl';
		blockClasses.push('column-count-lg-' + columnCountLg);
		blockClasses.push('column-spacing-lg-' + columnSpacingLg);
	}
	blockClasses.push('column-count-' + defaultLayoutBrakpoint + '-' + columnCountXl);
	blockClasses.push('column-spacing-' + defaultLayoutBrakpoint + '-' + columnSpacingXl);

	if(cellHorizontalAlignment != '') {
		blockClasses.push('cell-horizontal-align-' + cellHorizontalAlignment);
	}
	if(cellVerticalAlignment != '') {
		blockClasses.push('cell-vertical-align-' + cellVerticalAlignment);
	}

	// This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag
	let customProps = {
		className: blockClasses.join(' '),
		style: blockStyle,
		key: 'process-step'
	};
	
	return [

		// <InspectorControls key="inspector-controls">

		// 	<PanelBody title={ 'Column Layout Breakpoint' } initialOpen={ true }>

		// 		<SelectControl
		// 			value={ columnBreakpoint }
		// 			onChange={ (value) => setAttributes({ columnBreakpoint: value, responsiveDeviceMode: 'xl' }) }
		// 			options={ [
		// 				{ label: 'Mobile - Portrait (Base)', value: 'xs' },
		// 				{ label: 'Mobile - Landscape (576px)', value: 'sm' },
		// 				{ label: 'Tablet - Portrait (768px)', value: 'md' },
		// 				{ label: 'Tablet - Landscape (992px)', value: 'lg' },
		// 				{ label: 'Desktop - Widescreen (1200px)', value: 'xl' }
		// 			] }
		// 		/>

		// 	</PanelBody>

		// 	{ [ 'xs', 'sm', 'md', 'lg' ].includes(columnBreakpoint) && <div class="crown-blocks-responsive-device-mode-toggles">
		// 		<ButtonGroup>
		// 			{ [ 'xs', 'sm', 'md', 'lg', 'xl' ].includes(columnBreakpoint) && <Button isPrimary={ responsiveDeviceMode == 'xl' } onClick={ (e) => setAttributes({ responsiveDeviceMode: 'xl' }) }>
		// 				<span class="inner">
		// 					<Icon icon={
		// 						<svg class="bi bi-display" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
		// 							<path d="M5.75 13.5c.167-.333.25-.833.25-1.5h4c0 .667.083 1.167.25 1.5H11a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1h.75z"/>
		// 							<path fill-rule="evenodd" d="M13.991 3H2c-.325 0-.502.078-.602.145a.758.758 0 0 0-.254.302A1.46 1.46 0 0 0 1 4.01V10c0 .325.078.502.145.602.07.105.17.188.302.254a1.464 1.464 0 0 0 .538.143L2.01 11H14c.325 0 .502-.078.602-.145a.758.758 0 0 0 .254-.302 1.464 1.464 0 0 0 .143-.538L15 9.99V4c0-.325-.078-.502-.145-.602a.757.757 0 0 0-.302-.254A1.46 1.46 0 0 0 13.99 3zM14 2H2C0 2 0 4 0 4v6c0 2 2 2 2 2h12c2 0 2-2 2-2V4c0-2-2-2-2-2z"/>
		// 						</svg>
		// 					} />
		// 					<span class="label">Desktop <span class="sub-label">Widescreen</span> <span class="sub-label">1200px</span></span>
		// 				</span>
		// 			</Button> }
		// 			{ [ 'xs', 'sm', 'md', 'lg' ].includes(columnBreakpoint) && <Button isPrimary={ responsiveDeviceMode == 'lg' } onClick={ (e) => setAttributes({ responsiveDeviceMode: 'lg' }) }>
		// 				<span class="inner">
		// 					<Icon icon={
		// 						<svg class="bi bi-tablet-landscape" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
		// 							<path fill-rule="evenodd" d="M1 4v8a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1zm-1 8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v8z"/>
		// 							<path fill-rule="evenodd" d="M14 8a1 1 0 1 0-2 0 1 1 0 0 0 2 0z"/>
		// 						</svg>
		// 					} />
		// 					<span class="label">Tablet <span class="sub-label">Landscape</span> <span class="sub-label">992px</span></span>
		// 				</span>
		// 			</Button> }
		// 			{ [ 'xs', 'sm', 'md' ].includes(columnBreakpoint) && <Button isPrimary={ responsiveDeviceMode == 'md' } onClick={ (e) => setAttributes({ responsiveDeviceMode: 'md' }) }>
		// 				<span class="inner">
		// 					<Icon icon={
		// 						<svg class="bi bi-tablet" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
		// 							<path fill-rule="evenodd" d="M12 1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>
		// 							<path fill-rule="evenodd" d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
		// 						</svg>
		// 					} />
		// 					<span class="label">Tablet <span class="sub-label">Portrait</span> <span class="sub-label">768px</span></span>
		// 				</span>
		// 			</Button> }
		// 			{ [ 'xs', 'sm' ].includes(columnBreakpoint) && <Button isPrimary={ responsiveDeviceMode == 'sm' } onClick={ (e) => setAttributes({ responsiveDeviceMode: 'sm' }) }>
		// 				<span class="inner">
		// 					<Icon icon={
		// 						<svg class="bi bi-phone-landscape" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
		// 							<path fill-rule="evenodd" d="M1 4.5v6a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1zm-1 6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v6z"/>
		// 							<path fill-rule="evenodd" d="M14 7.5a1 1 0 1 0-2 0 1 1 0 0 0 2 0z"/>
		// 						</svg>
		// 					} />
		// 					<span class="label">Mobile <span class="sub-label">Landscape</span> <span class="sub-label">576px</span></span>
		// 				</span>
		// 			</Button> }
		// 			{ [ 'xs' ].includes(columnBreakpoint) && <Button isPrimary={ responsiveDeviceMode == 'xs' } onClick={ (e) => setAttributes({ responsiveDeviceMode: 'xs' }) }>
		// 				<span class="inner">
		// 					<Icon icon={
		// 						<svg class="bi bi-phone" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
		// 							<path fill-rule="evenodd" d="M11 1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z"/>
		// 							<path fill-rule="evenodd" d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
		// 						</svg>
		// 					} />
		// 					<span class="label">Mobile <span class="sub-label">Portrait</span> <span class="sub-label">Base</span></span>
		// 				</span>
		// 			</Button> }
		// 		</ButtonGroup>
		// 	</div> }

		// 	{ ([ 'xs', 'sm', 'md', 'lg', 'xl' ].includes(columnBreakpoint) && responsiveDeviceMode == 'xl') && <PanelBody title={ 'Layout' } initialOpen={ true }>

		// 		<RangeControl
		// 			label="Column Count"
		// 			value={ columnCountXl }
		// 			onChange={ (value) => setAttributes({ columnCountXl: value }) }
		// 			min={ 1 }
		// 			max={ 6 }
		// 		/>

		// 		<RangeControl
		// 			label="Column Spacing"
		// 			value={ columnSpacingXl }
		// 			onChange={ (value) => setAttributes({ columnSpacingXl: value }) }
		// 			min={ 0 }
		// 			max={ 120 }
		// 			step={ 10 }
		// 		/>

		// 	</PanelBody> }

		// 	{ ([ 'xs', 'sm', 'md', 'lg' ].includes(columnBreakpoint) && responsiveDeviceMode == 'lg') && <PanelBody title={ 'Layout' } initialOpen={ true }>

		// 		<ToggleControl
		// 			label={ 'Override layout' }
		// 			checked={ overrideColumnLayoutLg }
		// 			onChange={ (value) => { setAttributes({ overrideColumnLayoutLg: value }); } }
		// 		/>

		// 		{ !! overrideColumnLayoutLg && <RangeControl
		// 			label="Column Count"
		// 			value={ columnCountLg }
		// 			onChange={ (value) => setAttributes({ columnCountLg: value }) }
		// 			min={ 1 }
		// 			max={ 6 }
		// 		/> }

		// 		{ !! overrideColumnLayoutLg && <RangeControl
		// 			label="Column Spacing"
		// 			value={ columnSpacingLg }
		// 			onChange={ (value) => setAttributes({ columnSpacingLg: value }) }
		// 			min={ 0 }
		// 			max={ 120 }
		// 			step={ 10 }
		// 		/> }

		// 	</PanelBody> }

		// 	{ ([ 'xs', 'sm', 'md' ].includes(columnBreakpoint) && responsiveDeviceMode == 'md') && <PanelBody title={ 'Layout' } initialOpen={ true }>

		// 		<ToggleControl
		// 			label={ 'Override layout' }
		// 			checked={ overrideColumnLayoutMd }
		// 			onChange={ (value) => { setAttributes({ overrideColumnLayoutMd: value }); } }
		// 		/>

		// 		{ !! overrideColumnLayoutMd && <RangeControl
		// 			label="Column Count"
		// 			value={ columnCountMd }
		// 			onChange={ (value) => setAttributes({ columnCountMd: value }) }
		// 			min={ 1 }
		// 			max={ 6 }
		// 		/> }

		// 		{ !! overrideColumnLayoutMd && <RangeControl
		// 			label="Column Spacing"
		// 			value={ columnSpacingMd }
		// 			onChange={ (value) => setAttributes({ columnSpacingMd: value }) }
		// 			min={ 0 }
		// 			max={ 120 }
		// 			step={ 10 }
		// 		/> }

		// 	</PanelBody> }

		// 	{ ([ 'xs', 'sm' ].includes(columnBreakpoint) && responsiveDeviceMode == 'sm') && <PanelBody title={ 'Layout' } initialOpen={ true }>

		// 		<ToggleControl
		// 			label={ 'Override layout' }
		// 			checked={ overrideColumnLayoutSm }
		// 			onChange={ (value) => { setAttributes({ overrideColumnLayoutSm: value }); } }
		// 		/>

		// 		{ !! overrideColumnLayoutSm && <RangeControl
		// 			label="Column Count"
		// 			value={ columnCountSm }
		// 			onChange={ (value) => setAttributes({ columnCountSm: value }) }
		// 			min={ 1 }
		// 			max={ 6 }
		// 		/> }

		// 		{ !! overrideColumnLayoutSm && <RangeControl
		// 			label="Column Spacing"
		// 			value={ columnSpacingSm }
		// 			onChange={ (value) => setAttributes({ columnSpacingSm: value }) }
		// 			min={ 0 }
		// 			max={ 120 }
		// 			step={ 10 }
		// 		/> }

		// 	</PanelBody> }

		// 	{ ([ 'xs' ].includes(columnBreakpoint) && responsiveDeviceMode == 'xs') && <PanelBody title={ 'Layout' } initialOpen={ true }>

		// 		<ToggleControl
		// 			label={ 'Override layout' }
		// 			checked={ overrideColumnLayoutXs }
		// 			onChange={ (value) => { setAttributes({ overrideColumnLayoutXs: value }); } }
		// 		/>

		// 		{ !! overrideColumnLayoutXs && <RangeControl
		// 			label="Column Count"
		// 			value={ columnCountXs }
		// 			onChange={ (value) => setAttributes({ columnCountXs: value }) }
		// 			min={ 1 }
		// 			max={ 6 }
		// 		/> }

		// 		{ !! overrideColumnLayoutXs && <RangeControl
		// 			label="Column Spacing"
		// 			value={ columnSpacingXs }
		// 			onChange={ (value) => setAttributes({ columnSpacingXs: value }) }
		// 			min={ 0 }
		// 			max={ 120 }
		// 			step={ 10 }
		// 		/> }

		// 	</PanelBody> }

		// 	{ responsiveDeviceMode == 'xl' && <PanelBody title={ 'Alignment' } initialOpen={ true }>
				
		// 		<BaseControl label="Horizontal Alignment">
		// 			<ButtonGroup>
		// 				<Button isPrimary={ cellHorizontalAlignment == 'left' } isSecondary={ cellHorizontalAlignment != 'left' } onClick={ (e) => setAttributes({ cellHorizontalAlignment: 'left' }) }>Top</Button>
		// 				<Button isPrimary={ cellHorizontalAlignment == 'center' } isSecondary={ cellHorizontalAlignment != 'center' } onClick={ (e) => setAttributes({ cellHorizontalAlignment: 'center' }) }>Center</Button>
		// 				<Button isPrimary={ cellHorizontalAlignment == 'right' } isSecondary={ cellHorizontalAlignment != 'right' } onClick={ (e) => setAttributes({ cellHorizontalAlignment: 'right' }) }>Bottom</Button>
		// 			</ButtonGroup>
		// 		</BaseControl>
				
		// 		<BaseControl label="Vertical Alignment">
		// 			<ButtonGroup>
		// 				<Button isPrimary={ cellVerticalAlignment == 'top' } isSecondary={ cellVerticalAlignment != 'top' } onClick={ (e) => setAttributes({ cellVerticalAlignment: 'top' }) }>Top</Button>
		// 				<Button isPrimary={ cellVerticalAlignment == 'center' } isSecondary={ cellVerticalAlignment != 'center' } onClick={ (e) => setAttributes({ cellVerticalAlignment: 'center' }) }>Center</Button>
		// 				<Button isPrimary={ cellVerticalAlignment == 'bottom' } isSecondary={ cellVerticalAlignment != 'bottom' } onClick={ (e) => setAttributes({ cellVerticalAlignment: 'bottom' }) }>Bottom</Button>
		// 			</ButtonGroup>
		// 		</BaseControl>

		// 	</PanelBody> }

		// </InspectorControls>,

		<div { ...useBlockProps( customProps ) }>
			<div className="line-one"></div>
			<div className="line-two"></div>
			<div className="inner">

				<div className="grid-cells">
					<div className="inner">

						<InnerBlocks allowedBlocks={ ALLOWED_BLOCKS } template={ TEMPLATE } orientation="horizontal" />

					</div>
				</div>

			</div>
		</div>

	];
	
}
