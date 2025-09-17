
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
const { RichText, BlockControls, AlignmentToolbar, InspectorControls, PanelColorSettings, MediaUpload, URLInputButton } = wp.blockEditor;
const { PanelBody, ToolbarGroup, ToggleControl, SelectControl, Button } = wp.components;
const { getColorObjectByColorValue } = wp.blockEditor;

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit( { attributes, className, isSelected, setAttributes, clientId } ) {

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
		angle,
		borderRadius,
		displayAsBlock,
		disabledDisplayAsBlockBreakpoint,
		openNewWindow,
		linkArrow,
		backArrow,
		iconId,
		iconData,
		underline,
	} = attributes;

	setAttributes({ blockId: clientId });

	let blockClasses = [ className ];
	if(typeof alignment != 'undefined') blockClasses.push('text-alignment-' + alignment);

	let buttonClasses = [ 'btn' ];
	let buttonCss = '';

	buttonClasses.push('btn--id--' + clientId);
	let buttonSelector = '.editor-styles-wrapper .btn--id--' + clientId;

	if(type == 'outline') {
		buttonClasses.push('btn--outline');
		// buttonClasses.push('btn--outline-' + colorSlug);
		buttonCss += buttonSelector + '{ border-color: ' + color + '; }';
		buttonCss += buttonSelector + '{ color: ' + color + '; }';
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
		buttonCss += buttonSelector + '{ background-color: ' + color + '; }';
		buttonClasses.push('btn--text-color-' + (CrownBlocks.isDarkColor(color) ? 'light' : 'dark'));
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
	
	return [

		<InspectorControls key="inspector-controls">

			<PanelColorSettings
				title={ 'Color' }
				initialOpen={ true }
				colorSettings={ [
					{
						label: 'Button Color',
						value: color,
						onChange: (value) => {
							let settings = wp.data.select('core/block-editor').getSettings();
							let colorSlug = '';
							if(settings.colors) {
								let colorObject = getColorObjectByColorValue(settings.colors, value);
								if(colorObject) colorSlug = colorObject.slug;
							}
							setAttributes({ color: value, colorSlug: colorSlug });
						},
						disableCustomColors: false
					}
				] }
			/>

			<PanelBody title={ 'Appearance' } initialOpen={ true }>

				<SelectControl
					label="Button Type"
					value={ type }
					onChange={ (value) => setAttributes({ type: value }) }
					options={ [
						{ label: 'Default', value: 'default' },
						{ label: 'Outline', value: 'outline' },
						{ label: 'Link', value: 'link' },
						// { label: 'CTA', value: 'cta' }
					] }
				/>

				{ type != 'link' && <SelectControl
					label="Size"
					value={ size }
					onChange={ (value) => setAttributes({ size: value }) }
					options={ [
						{ label: 'Small', value: 'sm' },
						{ label: 'Medium', value: 'md' },
						{ label: 'Large', value: 'lg' }
					] }
				/> }

				{ <SelectControl
					label="Border Radius"
					value={ borderRadius }
					onChange={ (value) => setAttributes({ borderRadius: value }) }
					default={{ label: 'None - 0px', value: '0px' }}
					options={ [
						{ label: 'None - 0px', value: '0px' },
						{ label: 'Small - 7px', value: '7px' },
						{ label: 'Medium - 14px', value: '14px' },
						{ label: 'Large - 21px', value: '21px' }
					] }
				/> }

				{ type == 'cta' && <SelectControl
					label="Button Angle"
					value={ angle }
					onChange={ (value) => setAttributes({ angle: value }) }
					options={ [
						{ label: 'Wide Top', value: 'wide-top' },
						{ label: 'Wide Bottom', value: 'wide-bottom' }
					] }
				/> }

				<ToggleControl
					label={ 'Display as block' }
					checked={ displayAsBlock }
					onChange={ (value) => { setAttributes({ displayAsBlock: value }); } }
				/>

				{ !! displayAsBlock && <SelectControl
					label="Disable block appearance at specified screensize:"
					value={ disabledDisplayAsBlockBreakpoint }
					onChange={ (value) => setAttributes({ disabledDisplayAsBlockBreakpoint: value }) }
					options={ [
						{ label: 'Never', value: 'none' },
						{ label: 'Mobile - Landscape (576px)', value: 'sm' },
						{ label: 'Tablet - Portrait (768px)', value: 'md' },
						{ label: 'Tablet - Landscape (992px)', value: 'lg' },
						{ label: 'Desktop - Widescreen (1200px)', value: 'xl' }
					] }
				/> }

				<ToggleControl
					label={ 'Add Link Arrow' }
					checked={ linkArrow }
					onChange={ (value) => { setAttributes({ linkArrow: value }); } }
				/>

				<ToggleControl
					label={ 'Add Back Arrow' }
					checked={ backArrow }
					onChange={ (value) => { setAttributes({ backArrow: value }); } }
				/>

				<ToggleControl
					label={ 'Text Underline' }
					checked={ underline }
					onChange={ (value) => { setAttributes({ underline: value }); } }
				/>

				<MediaUpload
					onSelect={ (media) => { setAttributes({ iconId: media.id, iconData: media }); } }
					type="image"
					value={ iconId }
					label="Button Icon"
					render={ ({ open }) => (
						<div className={ 'crown-blocks-media-upload' }>
							<Button className={ 'button' } onClick={ open }>Select Button Icon</Button>
							{ iconId && <Button className={ 'button is-link is-destructive' } onClick={ (e) => { setAttributes({ iconId: null, iconData: null }); } }>Remove Icon</Button> }
						</div>
					) }
				/>

			</PanelBody>

			<PanelBody title={ 'Link Settings' } initialOpen={ true }>

				<ToggleControl
					label={ 'Open link in new window' }
					checked={ openNewWindow }
					onChange={ (value) => { setAttributes({ openNewWindow: value }); } }
				/>

			</PanelBody>

		</InspectorControls>,

		<div class="crown-block-editor-container">

			<BlockControls>
				<ToolbarGroup class="components-toolbar-group crown-block-button-toolbar">
					<URLInputButton
						url={ linkUrl }
						onChange={ ( url, post ) => setAttributes({ linkUrl: url, linkPost: post }) }
					/>
				</ToolbarGroup>
				<AlignmentToolbar
					value={ alignment }
					onChange={ (value) => { setAttributes({ alignment: value }); } }
				/>
			</BlockControls>

			<div { ...useBlockProps( customProps ) }>

				{!! buttonCss && <style type="text/css">{ buttonCss }</style> }
				
				<span className={ buttonClasses.join(' ') }>
					{ backArrow && <span className="btn__back-arrow"></span> }

					{ iconUrl && <img src={ iconUrl } className="btn__icon" aria-hidden="true" /> }

					<RichText
						tagName="div"
						className="btn-label"
						onChange={ (value) => setAttributes({ label: value }) } 
						value={ label }
						allowedFormats={ [] }
					/>

					{ linkArrow && <span className="btn__arrow"></span> }

				</span>

			</div>

		</div>

	];
	
}
