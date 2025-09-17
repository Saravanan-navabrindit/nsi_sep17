
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
 const { InnerBlocks, RichText, MediaUpload, InspectorControls, PanelColorSettings } = wp.blockEditor;
 const { PanelBody, RadioControl, ColorPicker, Button, ButtonGroup, Icon, RangeControl, FocalPointPicker, ToggleControl, TextControl, TextareaControl, SelectControl, BaseControl } = wp.components;
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

	const {
		title,
		linkType,
		linkFileId,
		linkFileData,
		linkUrl,
		linkPost,
		linkOpenInNewWindow,
		isStyleOutline,
		backgroundColor,
		backgroundImageId,
		backgroundImageData,
		backgroundImageFocalPoint,
		backgroundImageOpacity,
		textColor
	} = attributes;

	let blockClasses = [ className ];

	if(textColor == 'auto' && backgroundColor) {
		blockClasses.push('text-color-' + (CrownBlocks.isDarkColor(backgroundColor) ? 'light' : 'dark'));
	} else if(textColor != 'auto') {
		blockClasses.push('text-color-' + textColor);
	}

	let blockStyle = {};
	let bgStyle = {};
	let outlineStyle = {};
	if(isStyleOutline) {
		blockClasses.push('is-style-outline');
		if(backgroundColor) {
			blockStyle.color = backgroundColor;
			outlineStyle.borderColor = backgroundColor;
		}
	}
	if(backgroundColor) {
		bgStyle.backgroundColor = backgroundColor;
	}

	let backgroundImageUrl = null;
	if(backgroundImageId) {
		backgroundImageUrl = backgroundImageData.sizes.fullscreen ? backgroundImageData.sizes.fullscreen.url : backgroundImageData.url;
		blockClasses.push('has-bg-image');
	}

	let blockLink = linkUrl;
	let blockLinkOpenInNewWindow = linkOpenInNewWindow;
	if(linkType == 'file') {
		blockLink = linkFileData ? linkFileData.url : '';
		blockLinkOpenInNewWindow = true;
	}

	let colorSettings = [];
	colorSettings.push({
		label: 'Background Color',
		value: backgroundColor,
		onChange: (value) => setAttributes({ backgroundColor: value })
	});

	// This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag
	let customProps = {
		className: blockClasses.join(' '),
		style: blockStyle,
		key: 'portal-link'
	};
	
	return [

		<InspectorControls key="inspector-controls">

			<PanelBody title={ 'Call to Action' } initialOpen={ true }>

				<BaseControl label="Link Type">
					<div>
						<ButtonGroup>
							<Button isPrimary={ linkType == 'url' } isSecondary={ linkType != 'url' } onClick={ (e) => setAttributes({ linkType: 'url' }) }>Link URL</Button>
							<Button isPrimary={ linkType == 'file' } isSecondary={ linkType != 'file' } onClick={ (e) => setAttributes({ linkType: 'file' }) }>File Download</Button>
						</ButtonGroup>
					</div>
				</BaseControl>

				{ !! (linkType == 'file') && <MediaUpload
					onSelect={ (media) => { setAttributes({ linkFileId: media.id, linkFileData: media }); } }
					value={ linkFileId }
					render={ ({ open }) => (
						<div className={ 'crown-blocks-media-upload' }>
							{ linkFileId && <div><Button className={ 'image-preview' } onClick={ open }><img src={ linkFileData.sizes && linkFileData.sizes.medium ? linkFileData.sizes.medium.url : (linkFileData.sizes ? linkFileData.sizes.thumbnail.url : linkFileData.icon) } /></Button></div> }
							{ linkFileId && <div class="media-title">{ linkFileData.title }</div> }
							<Button className={ 'components-button is-secondary' } onClick={ open }>Select File</Button>
							{ linkFileId && <Button className={ 'components-button is-link is-destructive' } onClick={ (e) => { setAttributes({ linkFileId: null, linkFileData: null }); } }>Remove File</Button> }
						</div>
					) }
				/> }

				{ !! (linkType == 'url') && <TextControl
					label="Link URL"
					value={ linkUrl }
					placeholder="https://"
					onChange={ (url, post) => setAttributes({ linkUrl: url, linkPost: post }) }
					autoFocus={ false }
				/> }

				{ !! (linkType == 'url') && <ToggleControl
					label={ 'Open link in new window' }
					checked={ linkOpenInNewWindow }
					onChange={ (value) => { setAttributes({ linkOpenInNewWindow: value }); } }
				/> }

			</PanelBody>

			{/* <PanelBody title={ 'Style' } initialOpen={ true }>

				<ToggleControl
					label={ 'Display as outlined block' }
					checked={ isStyleOutline }
					onChange={ (value) => { setAttributes({ isStyleOutline: value }); } }
				/>

			</PanelBody> */}

			<PanelColorSettings
				title={ 'Colors' }
				initialOpen={ true }
				colorSettings={ colorSettings }
			/>

			<PanelBody title={ 'Background Image' } className={ 'crown-blocks-background-image' } initialOpen={ true }>

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

			</PanelBody>

			<PanelBody title={ 'Text Color' } initialOpen={ true }>

				<ButtonGroup>
					<Button isPrimary={ textColor == 'auto' } isSecondary={ textColor != 'auto' } onClick={ (e) => setAttributes({ textColor: 'auto' }) }>Auto</Button>
					<Button isPrimary={ textColor == 'dark' } isSecondary={ textColor != 'dark' } onClick={ (e) => setAttributes({ textColor: 'dark' }) }>Dark</Button>
					<Button isPrimary={ textColor == 'light' } isSecondary={ textColor != 'light' } onClick={ (e) => setAttributes({ textColor: 'light' }) }>Light</Button>
				</ButtonGroup>

			</PanelBody>

		</InspectorControls>,
		
		<div { ...useBlockProps( customProps ) }>
			<div class="link">
				<div className="link-bg" style={ bgStyle }>
					{ backgroundImageUrl && <div className={ 'bg-image' } style={ {
						backgroundImage: 'url(' + backgroundImageUrl + ')',
						opacity: (backgroundImageOpacity / 100),
						backgroundPosition: `${ backgroundImageFocalPoint.x * 100 }% ${ backgroundImageFocalPoint.y * 100 }%`
					} }></div> }
				</div>
				{ isStyleOutline && <div class="link-outline" style={ outlineStyle }></div> }
				<div className="inner">

					<div className="link-contents">

						<header class="link-header">

							<RichText
								tagName="h3"
								className="link-title"
								onChange={ (value) => setAttributes({ title: value }) } 
								value={ title }
								placeholder="Link Title"
								allowedFormats={ [] }
							/>

						</header>

					</div>

				</div>
			</div>
		</div>
	];

}
