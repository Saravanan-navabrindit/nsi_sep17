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
 const { InnerBlocks, RichText } = wp.blockEditor;
 const { getColorObjectByColorValue } = wp.blockEditor;

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
			align,
			slider,
			columnLayout,
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

	// This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag
	let customProps = {
		className: blockClasses.join(' '),
		// style: blockStyle,
		key: 'logo-slider'
	};

	return (

		<div { ...useBlockProps.save( customProps ) }>
			<div className={ 'inner' }>
				{ featuredImageIds.length && <div className="logo-container">
					<div class="inner">
						{ featuredImageData.map((media, index) =>
							<div className={ 'image' }>
								{ media.description && <a target="_blank" href={media.description}><img src={ media.url } /></a> }
								{ ! media.description && <img src={ media.url } /> }
							</div>
						) }
					</div>
				</div> }
			</div>
		</div>

	);
}
