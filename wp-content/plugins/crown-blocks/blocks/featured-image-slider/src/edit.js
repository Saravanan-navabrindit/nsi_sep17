
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
const { InnerBlocks, InspectorControls } = wp.blockEditor;
const { PanelBody, RangeControl, ToggleControl } = wp.components;

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit( { attributes, className, isSelected, setAttributes, clientId } ) {

	const ALLOWED_BLOCKS = [ 'crown-blocks/featured-image' ];

	const TEMPLATE = [
		[ 'crown-blocks/featured-image', {}, [
			[ 'core/paragraph', { placeholder: 'Enter featured image content...' } ]
		] ]
	];
	
	const {
		autoRotate,
		rotationSpeed,
	} = attributes;

	let blockClasses = [ className ];

	// This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag
	let customProps = {
		className: blockClasses.join(' '),
		key: 'featured-image-slider'
	};

	return [

		<InspectorControls key="inspector-controls">

			<PanelBody title={ 'Slider Options' } className={ 'crown-blocks-testimonial-slider-options' } initialOpen={ true }>

				<ToggleControl
					label={ 'Slider auto-rotate' }
					checked={ autoRotate }
					onChange={ (value) => { setAttributes({ autoRotate: value }); } }
				/>

				{ !! autoRotate && <RangeControl
					label="Slider Rotation Speed (seconds)"
					value={ rotationSpeed }
					onChange={ (value) => setAttributes({ rotationSpeed: value }) }
					min={ 1 }
					max={ 20 }
				/> }

			</PanelBody>

		</InspectorControls>,

		<div { ...useBlockProps( customProps ) }>
			<div className="inner">

				<div className="featured-image-slider">
					<div className="inner" data-auto-rotate={ autoRotate } data-rotation-speed={ rotationSpeed }>

						<InnerBlocks allowedBlocks={ ALLOWED_BLOCKS } template={ TEMPLATE } />

					</div>
				</div>

			</div>
		</div>

	];
	
}
