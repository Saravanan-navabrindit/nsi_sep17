
document.addEventListener('DOMContentLoaded', function(event) {
    
	// /**
	//  * Update tab state on tab click
	//  */
	// const tabbed_content_tabs = document.querySelectorAll('.wp-block-crown-blocks-anchor-link .tabs .tab');
	// tabbed_content_tabs.forEach( (tab, index) => {
	// 	tab.addEventListener('click', e => {

	// 		if ( tab.classList.contains('active') ) return;
			
	// 		tabbed_content_tabs.forEach(a => a.classList.remove('active'));
	// 		tab.classList.add('active');
			
	// 		let tabbed_content_block = tab.closest('.wp-block-crown-blocks-anchor-link');
	// 		let block_panels = tabbed_content_block.querySelectorAll('.panel');
	// 		block_panels.forEach( panel => {
	// 			panel.style.display = 'none';
	// 		});
	// 		block_panels[index].style.display = 'block';

	// 	}, true);
	// });

	// /**
	//  * Update tab state on select input change 
	//  */
	// const tabbed_content_select_inputs = document.querySelectorAll('.wp-block-crown-blocks-anchor-link .tabs-select');
	// tabbed_content_select_inputs.forEach( (select_input, index) => {
	// 	select_input.addEventListener('change', e => {
			
	// 		let tab_number = parseInt( e.target.value, 10 );
			
	// 		let tabbed_content_block = select_input.closest('.wp-block-crown-blocks-anchor-link');
	// 		let tabbed_content_tabs = tabbed_content_block.querySelectorAll('.tab');
	// 		let block_panels = tabbed_content_block.querySelectorAll('.panel');

	// 		tabbed_content_tabs.forEach(a => a.classList.remove('active'));
	// 		tabbed_content_tabs[tab_number].classList.add('active');
			
	// 		block_panels.forEach( panel => {
	// 			panel.style.display = 'none';
	// 		});
	// 		block_panels[tab_number].style.display = 'block';

	// 	}, true);
	// });
	
});
