
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


/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit( { attributes, className, setAttributes } ) {
	
	const ALLOWED_BLOCKS = [ 'crown-blocks/button' ];

	const TEMPLATE = [
		[ 'crown-blocks/button', {}, ]
	];

	const {
		align
	} = attributes;

	let blockClasses = [ className ];

	if ( align ) {
		blockClasses.push('button-align-' + align);
	}
	
	// This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag
	let customProps = {
		className: blockClasses.join(' '),
		key: 'button-group'
	};
	
	return [

		<BlockControls>
			<AlignmentToolbar
				value={ align }
				onChange={(value) => setAttributes({ align: value })}
				alignmentControls={ [{
					icon: 'align-left',
					title: 'Align content left',
					align: 'left'
				  }, {
					icon: 'align-center',
					title: 'Align content center',
					align: 'center'
				}, {
					icon: 'align-right',
					title: 'Align content right',
					align: 'right'
				}] }
			/>
		</BlockControls>,

		<div { ...useBlockProps( customProps ) }>
			<div className={ 'inner' }>
				
				<InnerBlocks allowedBlocks={ ALLOWED_BLOCKS } template={ TEMPLATE } orientation="horizontal" />
				
			</div>
		</div>

	];

}
