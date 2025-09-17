
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

	// const TEMPLATE = [
	// 	[ 'core/heading', { placeholder: 'Page Header Title...', level: 1 } ],
	// ];
	
	const {
		align,
		slider,
		columnLayout,
		currentFeaturedImageIndex,
		featuredImageIds,
		featuredImageData,
		blockHorizontalAlignment,
		blockVerticalAlignment,
	} = attributes;

	let blockClasses = [
		className
	];
	
	if(blockHorizontalAlignment != '') {
		blockClasses.push('block-horizontal-align-' + blockHorizontalAlignment);
	}
	if(blockVerticalAlignment != '') {
		blockClasses.push('block-vertical-align-' + blockVerticalAlignment);
	}

	if ( slider ) {
		blockClasses.push( 'slider' );
	}

	if ( columnLayout ) {
		blockClasses.push( 'column-layout-' + columnLayout );
	}

	let featuredImageUrl = null;
	if(featuredImageIds.length) {
		featuredImageUrl = featuredImageData[currentFeaturedImageIndex].url ? featuredImageData[currentFeaturedImageIndex].url : featuredImageData[currentFeaturedImageIndex].url;
	}

	// This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag
	let customProps = {
		className: blockClasses.join(' '),
		// style: blockStyle,
		key: 'logo-slider'
	};
	
	return [

		<InspectorControls key="inspector-controls">

				<PanelBody title={ 'Featured Image Area' } className={ 'crown-blocks-featured-image' } initialOpen={ true }>

					{ !! featuredImageIds.length && <ol class="crown-blocks-media-images">
						{ featuredImageData.map((media, index) =>
							<li key={ media.id } class={ index == currentFeaturedImageIndex ? 'active' : '' } onClick={ (e) => {
								let nodes = Array.prototype.slice.call(e.target.closest('li').parentNode.children);
								let index = nodes.indexOf(e.target.closest('li'));
								setAttributes({ currentFeaturedImageIndex: index, featuredImageFocalPoint: featuredImageData[index].focalPoint });
							} }>
								<img src={ media.url } />
							</li>
						) }
					</ol> }

					<MediaUpload
						onSelect={ (media) => {
							let featuredImageIds = media.map((n) => { return n.id; });
							let featuredImageData = media.map((n) => { n.focalPoint = { x: 0.5, y: 0.5 }; return n; })
							setAttributes({ featuredImageIds: featuredImageIds, featuredImageData: featuredImageData, currentFeaturedImageIndex: 0 });
						} }
						type="image"
						multiple="true"
						value={ featuredImageIds }
						render={ ({ open }) => (
							<div className={ 'crown-blocks-media-upload' }>
								{/* { featuredImageId && <Button className={ 'image-preview' } onClick={ open }><img src={ featuredImageData.sizes.medium ? featuredImageData.sizes.medium.url : featuredImageData.sizes.thumbnail.url } /></Button> } */}
								<Button className={ 'components-button is-secondary' } onClick={ open }>Select Image(s)</Button>
								{ !! featuredImageIds.length && <Button className={ 'components-button is-destructive' } onClick={ (e) => {
									featuredImageIds.splice(currentFeaturedImageIndex, 1);
									featuredImageData.splice(currentFeaturedImageIndex, 1);
									let imageIndex = currentFeaturedImageIndex < featuredImageIds.length ? currentFeaturedImageIndex : Math.min(0, featuredImageIds.length - 1);
									setAttributes({ featuredImageIds: featuredImageIds, featuredImageData: featuredImageData, currentFeaturedImageIndex: imageIndex });
								} }>Remove Image</Button> }
							</div>
						) }
					/>

				<ToggleControl
					label={ 'Display As Slider' }
					checked={ slider }
					onChange={ (value) => { setAttributes({ slider: value }); } }
				/>

				<RangeControl
					label="Column Distribution"
					value={ columnLayout }
					onChange={ (value) => setAttributes({ columnLayout: value }) }
					min={ 4 }
					max={ 8 }
				/>

				</PanelBody>

				<PanelBody title={ 'Alignment' } initialOpen={ true }>
					
					<BaseControl label="Horizontal Alignment">
						<ButtonGroup>
							<Button isPrimary={ blockHorizontalAlignment == 'left' } isSecondary={ blockHorizontalAlignment != 'left' } onClick={ (e) => setAttributes({ blockHorizontalAlignment: 'left' }) }>Left</Button>
							<Button isPrimary={ blockHorizontalAlignment == 'center' } isSecondary={ blockHorizontalAlignment != 'center' } onClick={ (e) => setAttributes({ blockHorizontalAlignment: 'center' }) }>Center</Button>
							<Button isPrimary={ blockHorizontalAlignment == 'right' } isSecondary={ blockHorizontalAlignment != 'right' } onClick={ (e) => setAttributes({ blockHorizontalAlignment: 'right' }) }>Right</Button>
						</ButtonGroup>
					</BaseControl>
					
					<BaseControl label="Vertical Alignment">
						<ButtonGroup>
							<Button isPrimary={ blockVerticalAlignment == 'top' } isSecondary={ blockVerticalAlignment != 'top' } onClick={ (e) => setAttributes({ blockVerticalAlignment: 'top' }) }>Top</Button>
							<Button isPrimary={ blockVerticalAlignment == 'center' } isSecondary={ blockVerticalAlignment != 'center' } onClick={ (e) => setAttributes({ blockVerticalAlignment: 'center' }) }>Center</Button>
							<Button isPrimary={ blockVerticalAlignment == 'bottom' } isSecondary={ blockVerticalAlignment != 'bottom' } onClick={ (e) => setAttributes({ blockVerticalAlignment: 'bottom' }) }>Bottom</Button>
						</ButtonGroup>
					</BaseControl>

				</PanelBody>

			</InspectorControls>,
		
		<div { ...useBlockProps( customProps ) }>		
			<div className={ 'inner' }>
				{ featuredImageIds.length && <div className="logo-container">
					<div class="inner">
					{ featuredImageData.map((media, index) =>
						<div className={ 'image' }>
							<img src={ media.url } />
						</div>
					) }
					</div>
				</div> }
			</div>
		</div>
		
	];

}
