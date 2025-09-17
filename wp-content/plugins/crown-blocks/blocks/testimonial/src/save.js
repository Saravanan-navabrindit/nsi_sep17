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
		textAlign,
		sourceName,
		sourceTitle,
		blockId,
		headshotImageId,
		headshotImageData,
		headshotImageFocalPoint
	} = attributes;

	let blockClasses = [
		className
	];

	if ( textAlign ) {
		blockClasses.push('text-align-' + textAlign);
	}

	let headshotImageUrl = null;
	if(headshotImageId) {
		headshotImageUrl = headshotImageData.sizes.large ? headshotImageData.sizes.large.url : headshotImageData.url;
		blockClasses.push('has-headshot-image');
	}

	// This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag
	let customProps = {
		className: blockClasses.join(' '),
		key: 'testimonial'
	};
	
	return (
		<div { ...useBlockProps.save( customProps ) }>
			<div className="inner">

				{ headshotImageUrl && <div className="testimonial__headshot">
					<img src={ headshotImageUrl } style={ { backgroundPosition: `${ headshotImageFocalPoint.x * 100 }% ${ headshotImageFocalPoint.y * 100 }%` } } />
				</div> }

				<div class="testimonial__quote">
					<div className="inner">
						<InnerBlocks.Content />
					</div>
				</div>

				<footer className="testimonial__source">
					<div className="inner">
						<div className="testimonial__source-details">
							{ sourceName && <RichText.Content tagName="p" className="testimonial__source-name" value={ sourceName } /> }
							{ sourceTitle && <RichText.Content tagName="p" className="testimonial__source-title" value={ sourceTitle } /> }
						</div>
						
					</div>
				</footer>

			</div>
		</div>
	);
	
}
