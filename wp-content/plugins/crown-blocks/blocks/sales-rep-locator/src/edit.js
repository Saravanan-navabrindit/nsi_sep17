
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
 const { PanelBody, RadioControl, CheckboxControl, ColorPicker, RangeControl, FocalPointPicker, ToggleControl, TextControl, TextareaControl, SelectControl, Button, ButtonGroup, Icon, BaseControl, FormTokenField } = wp.components;
 const { getColorObjectByColorValue } = wp.blockEditor;

 import ServerSideRender from '@wordpress/server-side-render';

 import { withSelect } from '@wordpress/data';
 import { useSelect } from '@wordpress/data';
 import { __ } from '@wordpress/i18n';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */

export default function Edit({ posts, attributes, className, isSelected, setAttributes } ) {

	const {
		selectedType,
	} = attributes;
	
	let blockAtts = {
		className: className,
		...attributes
	};

	let blockClasses = [ className ];

	let blockStyle = {};

	// This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag
	let customProps = {
		className: blockClasses.join(' '),
		style: blockStyle,
		key: 'sales-rep-locator'
	};

	const typeOptions = useSelect((select) => {
		const terms = select('core').getEntityRecords('taxonomy', 'type', { per_page: -1 });
		if (terms && terms.length > 0) {
			return terms.map((term) => ({ label: term.name, value: term.slug }));
		}
		return [];
	}, []);

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Settings', 'crown-blocks')} initialOpen={true}>
					<SelectControl
						label={__('Select Type', 'crown-blocks')}
						value={selectedType}
						options={[{label: __('All Types', 'crown-blocks'), value: ''}, ...typeOptions]}
						onChange={(value) => setAttributes({selectedType: value})}
					/>
				</PanelBody>
			</InspectorControls>
			<div {...useBlockProps(customProps)}>
				<ServerSideRender block="crown-blocks/sales-rep-locator" attributes={blockAtts}/>
			</div>
		</>
	);
}
