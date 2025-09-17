

wp.domReady(function() {


	wp.blocks.unregisterBlockType('core/archives');
	wp.blocks.unregisterBlockType('core/button');
	wp.blocks.unregisterBlockType('core/buttons');
	wp.blocks.unregisterBlockType('core/calendar');
	wp.blocks.unregisterBlockType('core/categories');
	wp.blocks.unregisterBlockType('core/cover');
	wp.blocks.unregisterBlockType('core/latest-comments');
	wp.blocks.unregisterBlockType('core/latest-posts');
	wp.blocks.unregisterBlockType('core/rss');
	wp.blocks.unregisterBlockType('core/social-links');
	wp.blocks.unregisterBlockType('core/tag-cloud');

	wp.blocks.unregisterBlockType('core/columns');
	// wp.blocks.unregisterBlockType('core/spacer');

	// wp.blocks.unregisterBlockType('atomic-blocks/ab-button');
	// wp.blocks.unregisterBlockType('atomic-blocks/ab-container');
	// wp.blocks.unregisterBlockType('atomic-blocks/ab-cta');
	// wp.blocks.unregisterBlockType('atomic-blocks/ab-layouts');
	// wp.blocks.unregisterBlockType('atomic-blocks/newsletter');
	// wp.blocks.unregisterBlockType('atomic-blocks/ab-post-grid');
	// wp.blocks.unregisterBlockType('atomic-blocks/ab-pricing');
	// wp.blocks.unregisterBlockType('atomic-blocks/ab-sharing');


	// wp.blocks.registerBlockStyle('core/heading', [ 
	// 	{ name: 'default', label: 'Default', isDefault: true },
	// 	{ name: 'font-weight-normal', label: 'Normal Weight' },
	// 	{ name: 'spaced-uppercase', label: 'Spaced Uppercase' },
	// 	{ name: 'display', label: 'Display' }
	// ]);

	// wp.blocks.registerBlockStyle('core/paragraph', [ 
	// 	{ name: 'sans-serif', label: 'Sans-Serif', isDefault: true },
	// 	{ name: 'serif', label: 'Serif' },
	// ]);

	wp.blocks.unregisterBlockStyle('core/pullquote', 'default');
	wp.blocks.unregisterBlockStyle('core/pullquote', 'solid-color');
	
	wp.blocks.unregisterBlockStyle('core/image', 'solid-rounded');
	wp.blocks.registerBlockStyle('core/image', [ 
		{ name: 'default', label: 'Default', isDefault: true },
		{ name: 'angled-corners', label: 'Angled Corners' }
	]);

	// wp.blocks.registerBlockStyle('core/list', [ 
	// 	{ name: 'default', label: 'Default', isDefault: true },
	// 	{ name: 'unstyled', label: 'Unstyled' },
	// 	{ name: 'dashed', label: 'Dashed' }
	// ]);

	// wp.blocks.registerBlockStyle('core/gallery', [ 
	// 	{ name: 'default', label: 'Default', isDefault: true },
	// 	{ name: 'logos', label: 'Logos' },
	// 	{ name: 'mosaic-8', label: 'Mosaic (8 photos)' }
	// ]);

	wp.blocks.registerBlockStyle('crown-blocks/testimonial', [ 
		{ name: 'default', label: 'Default', isDefault: true },
		{ name: 'large-image', label: 'Large Image' }
	]);

	wp.blocks.registerBlockStyle('crown-blocks/page-section-callout', [ 
		{ name: 'default', label: 'Default', isDefault: true },
		{ name: 'hexagons', label: 'Hexagons' },
		{ name: 'hexagons-light', label: 'Light Hexagons' }
	]);

	wp.blocks.registerBlockStyle('crown-blocks/tabbed-content', [ 
		{ name: 'default', label: 'Default', isDefault: true },
		{ name: 'boxed', label: 'Boxed' }
	]);

	// wp.blocks.registerBlockStyle('crown-blocks/container', [ 
	// 	{ name: 'default', label: 'Default', isDefault: true },
	// 	{ name: 'panel', label: 'Panel' }
	// ]);

	// wp.blocks.registerBlockStyle('crown-blocks/grid', [ 
	// 	{ name: 'default', label: 'Default', isDefault: true },
	// 	{ name: 'dividers', label: 'Dividers' }
	// ]);


	// wp.hooks.addFilter('blocks.getSaveElement', 'crown-theme/block-editor', function(el, type, attr) {
	// 	if(type.name !== 'core/heading') return el;
	// 	if(attr.className.match('is-style-section-heading')) {
	// 		el = wp.element.createElement(
	// 			el.props.tagName,
	// 			{
	// 				className: el.props.className,
	// 				id: el.props.id,
	// 				style: el.props.style
	// 			},
	// 			wp.element.createElement('span', { className: 'label' }, attr.content),
	// 			wp.element.createElement('span', { className: 'line' })
	// 		);
	// 		// el = wp.element.cloneElement(el, {}, wp.element.createElement('span', {}, el.props.value));
	// 		// console.log(wp.element.renderToString(el));
	// 		// console.log(el);
	// 	}
	// 	return el;
	// });
	// wp.hooks.addFilter('blocks.getBlockAttributes', 'crown-theme/block-editor-two', function(blockAttributes, blockType, innerHTML, attributes) {
	// 	console.log(blockAttributes, blockType, innerHTML, attributes);
	// });


});