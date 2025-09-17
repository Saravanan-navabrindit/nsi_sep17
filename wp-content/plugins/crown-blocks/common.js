

const CrownBlocks = {


	getColorLuminosity: (hex = '') => {
		hex = hex.replace(/[^0-9a-f]/i, '');
		if(hex == '' || hex.length < 3) hex = 'fff';
		if(hex.length < 6) hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
		let c = [];
		for(var i = 0; i < 3; i++) c.push(parseInt(hex.substring(i * 2, i * 2 + 2), 16) / 255);
		for(var i = 0; i < 3; i++) {
			if(c[i] <= 0.03928) {
				c[i] = c[i] / 12.92;
			} else {
				c[i] = Math.pow((c[i] + 0.055) / 1.055, 2.4);
			}
		}
		let luminosity = (0.2126 * c[0]) + (0.7152 * c[1]) + (0.0722 * c[2]);
		return luminosity;
	},


	isDarkColor: (hex, threshold = 0.607843137) => {
		let luminosity = CrownBlocks.getColorLuminosity(hex);
		return luminosity <= threshold;
	},


	hexToRgb: (hex) => {
		var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
		return result ? {
			r: parseInt(result[1], 16),
			g: parseInt(result[2], 16),
			b: parseInt(result[3], 16)
		} : null;
	},


	debounce: (func, timeout = 200) => {
		let timer;
		return (...args) => {
			clearTimeout(timer);
			timer = setTimeout(() => { func.apply(this, args); }, timeout);
		};
	}


};


export default CrownBlocks;