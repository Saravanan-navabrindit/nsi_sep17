/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./blocks/two-column/src/edit.js":
/*!***************************************!*\
  !*** ./blocks/two-column/src/edit.js ***!
  \***************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ Edit; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./editor.scss */ "./blocks/two-column/src/editor.scss");


/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
 */

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */


/**
 * Import required components for editing
 */

const {
  InnerBlocks,
  InspectorControls
} = wp.blockEditor;
const {
  PanelBody,
  RadioControl,
  ColorPicker,
  Button,
  ButtonGroup,
  Icon,
  RangeControl,
  FocalPointPicker,
  ToggleControl,
  TextControl,
  TextareaControl,
  SelectControl,
  BaseControl
} = wp.components;
/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */

function Edit({
  attributes,
  className,
  isSelected,
  setAttributes
}) {
  const ALLOWED_BLOCKS = ['crown-blocks/column'];
  const TEMPLATE = [['crown-blocks/column', {}, [['core/paragraph', {
    placeholder: 'Enter column content...'
  }]]], ['crown-blocks/column', {}, [['core/paragraph', {
    placeholder: 'Enter column content...'
  }]]]];
  const {
    responsiveDeviceMode,
    columnBreakpoint,
    columnCount,
    columnLayoutXl,
    columnSpacingXl,
    overrideColumnLayoutLg,
    columnLayoutLg,
    columnSpacingLg,
    overrideColumnLayoutMd,
    columnLayoutMd,
    columnSpacingMd,
    overrideColumnLayoutSm,
    columnLayoutSm,
    columnSpacingSm,
    overrideColumnLayoutXs,
    columnLayoutXs,
    columnSpacingXs,
    middleBorder
  } = attributes;
  let blockClasses = [className];
  let blockStyle = {};
  blockClasses.push('column-breakpoint-' + columnBreakpoint);
  blockClasses.push('column-count-' + columnCount);
  let defaultLayoutBrakpoint = columnBreakpoint;

  if (['xs'].includes(columnBreakpoint) && overrideColumnLayoutXs) {
    defaultLayoutBrakpoint = 'sm';
    blockClasses.push('column-layout-xs-' + columnLayoutXs);
    blockClasses.push('column-spacing-xs-' + columnSpacingXs);
  }

  if (['xs', 'sm'].includes(columnBreakpoint) && overrideColumnLayoutSm) {
    defaultLayoutBrakpoint = 'md';
    blockClasses.push('column-layout-sm-' + columnLayoutSm);
    blockClasses.push('column-spacing-sm-' + columnSpacingSm);
  }

  if (['xs', 'sm', 'md'].includes(columnBreakpoint) && overrideColumnLayoutMd) {
    defaultLayoutBrakpoint = 'lg';
    blockClasses.push('column-layout-md-' + columnLayoutMd);
    blockClasses.push('column-spacing-md-' + columnSpacingMd);
  }

  if (['xs', 'sm', 'md', 'lg'].includes(columnBreakpoint) && overrideColumnLayoutLg) {
    defaultLayoutBrakpoint = 'xl';
    blockClasses.push('column-layout-lg-' + columnLayoutLg);
    blockClasses.push('column-spacing-lg-' + columnSpacingLg);
  }

  blockClasses.push('column-layout-' + defaultLayoutBrakpoint + '-' + columnLayoutXl);
  blockClasses.push('column-spacing-' + defaultLayoutBrakpoint + '-' + columnSpacingXl);

  if (middleBorder) {
    blockClasses.push('middle-border');
  } // This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag


  let customProps = {
    className: blockClasses.join(' '),
    style: blockStyle,
    key: 'two-column'
  };
  return [(0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(InspectorControls, {
    key: "inspector-controls"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: 'Column Layout Breakpoint',
    initialOpen: true
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
    value: columnBreakpoint,
    onChange: value => setAttributes({
      columnBreakpoint: value,
      responsiveDeviceMode: 'xl'
    }),
    options: [{
      label: 'Mobile - Portrait (Base)',
      value: 'xs'
    }, {
      label: 'Mobile - Landscape (576px)',
      value: 'sm'
    }, {
      label: 'Tablet - Portrait (768px)',
      value: 'md'
    }, {
      label: 'Tablet - Landscape (992px)',
      value: 'lg'
    }, {
      label: 'Desktop - Widescreen (1200px)',
      value: 'xl'
    }]
  })), ['xs', 'sm', 'md', 'lg'].includes(columnBreakpoint) && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    class: "crown-blocks-responsive-device-mode-toggles"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ButtonGroup, null, ['xs', 'sm', 'md', 'lg', 'xl'].includes(columnBreakpoint) && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
    isPrimary: responsiveDeviceMode == 'xl',
    onClick: e => setAttributes({
      responsiveDeviceMode: 'xl'
    })
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    class: "inner"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Icon, {
    icon: (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
      class: "bi bi-display",
      width: "1em",
      height: "1em",
      viewBox: "0 0 16 16",
      fill: "currentColor",
      xmlns: "http://www.w3.org/2000/svg"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
      d: "M5.75 13.5c.167-.333.25-.833.25-1.5h4c0 .667.083 1.167.25 1.5H11a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1h.75z"
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
      "fill-rule": "evenodd",
      d: "M13.991 3H2c-.325 0-.502.078-.602.145a.758.758 0 0 0-.254.302A1.46 1.46 0 0 0 1 4.01V10c0 .325.078.502.145.602.07.105.17.188.302.254a1.464 1.464 0 0 0 .538.143L2.01 11H14c.325 0 .502-.078.602-.145a.758.758 0 0 0 .254-.302 1.464 1.464 0 0 0 .143-.538L15 9.99V4c0-.325-.078-.502-.145-.602a.757.757 0 0 0-.302-.254A1.46 1.46 0 0 0 13.99 3zM14 2H2C0 2 0 4 0 4v6c0 2 2 2 2 2h12c2 0 2-2 2-2V4c0-2-2-2-2-2z"
    }))
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    class: "label"
  }, "Desktop ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    class: "sub-label"
  }, "Widescreen"), " ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    class: "sub-label"
  }, "1200px")))), ['xs', 'sm', 'md', 'lg'].includes(columnBreakpoint) && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
    isPrimary: responsiveDeviceMode == 'lg',
    onClick: e => setAttributes({
      responsiveDeviceMode: 'lg'
    })
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    class: "inner"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Icon, {
    icon: (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
      class: "bi bi-tablet-landscape",
      width: "1em",
      height: "1em",
      viewBox: "0 0 16 16",
      fill: "currentColor",
      xmlns: "http://www.w3.org/2000/svg"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
      "fill-rule": "evenodd",
      d: "M1 4v8a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1zm-1 8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v8z"
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
      "fill-rule": "evenodd",
      d: "M14 8a1 1 0 1 0-2 0 1 1 0 0 0 2 0z"
    }))
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    class: "label"
  }, "Tablet ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    class: "sub-label"
  }, "Landscape"), " ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    class: "sub-label"
  }, "992px")))), ['xs', 'sm', 'md'].includes(columnBreakpoint) && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
    isPrimary: responsiveDeviceMode == 'md',
    onClick: e => setAttributes({
      responsiveDeviceMode: 'md'
    })
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    class: "inner"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Icon, {
    icon: (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
      class: "bi bi-tablet",
      width: "1em",
      height: "1em",
      viewBox: "0 0 16 16",
      fill: "currentColor",
      xmlns: "http://www.w3.org/2000/svg"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
      "fill-rule": "evenodd",
      d: "M12 1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
      "fill-rule": "evenodd",
      d: "M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"
    }))
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    class: "label"
  }, "Tablet ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    class: "sub-label"
  }, "Portrait"), " ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    class: "sub-label"
  }, "768px")))), ['xs', 'sm'].includes(columnBreakpoint) && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
    isPrimary: responsiveDeviceMode == 'sm',
    onClick: e => setAttributes({
      responsiveDeviceMode: 'sm'
    })
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    class: "inner"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Icon, {
    icon: (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
      class: "bi bi-phone-landscape",
      width: "1em",
      height: "1em",
      viewBox: "0 0 16 16",
      fill: "currentColor",
      xmlns: "http://www.w3.org/2000/svg"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
      "fill-rule": "evenodd",
      d: "M1 4.5v6a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1zm-1 6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v6z"
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
      "fill-rule": "evenodd",
      d: "M14 7.5a1 1 0 1 0-2 0 1 1 0 0 0 2 0z"
    }))
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    class: "label"
  }, "Mobile ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    class: "sub-label"
  }, "Landscape"), " ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    class: "sub-label"
  }, "576px")))), ['xs'].includes(columnBreakpoint) && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
    isPrimary: responsiveDeviceMode == 'xs',
    onClick: e => setAttributes({
      responsiveDeviceMode: 'xs'
    })
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    class: "inner"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Icon, {
    icon: (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
      class: "bi bi-phone",
      width: "1em",
      height: "1em",
      viewBox: "0 0 16 16",
      fill: "currentColor",
      xmlns: "http://www.w3.org/2000/svg"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
      "fill-rule": "evenodd",
      d: "M11 1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z"
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
      "fill-rule": "evenodd",
      d: "M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"
    }))
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    class: "label"
  }, "Mobile ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    class: "sub-label"
  }, "Portrait"), " ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    class: "sub-label"
  }, "Base")))))), ['xs', 'sm', 'md', 'lg', 'xl'].includes(columnBreakpoint) && responsiveDeviceMode == 'xl' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: 'Layout',
    initialOpen: true
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Column Distribution",
    value: columnLayoutXl,
    onChange: value => setAttributes({
      columnLayoutXl: value
    }),
    min: 1,
    max: 11
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Column Spacing",
    value: columnSpacingXl,
    onChange: value => setAttributes({
      columnSpacingXl: value
    }),
    min: 0,
    max: 120,
    step: 10
  })), ['xs', 'sm', 'md', 'lg'].includes(columnBreakpoint) && responsiveDeviceMode == 'lg' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: 'Layout',
    initialOpen: true
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Override layout',
    checked: overrideColumnLayoutLg,
    onChange: value => {
      setAttributes({
        overrideColumnLayoutLg: value
      });
    }
  }), !!overrideColumnLayoutLg && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Column Distribution",
    value: columnLayoutLg,
    onChange: value => setAttributes({
      columnLayoutLg: value
    }),
    min: 1,
    max: 11
  }), !!overrideColumnLayoutLg && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Column Spacing",
    value: columnSpacingLg,
    onChange: value => setAttributes({
      columnSpacingLg: value
    }),
    min: 0,
    max: 120,
    step: 10
  })), ['xs', 'sm', 'md'].includes(columnBreakpoint) && responsiveDeviceMode == 'md' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: 'Layout',
    initialOpen: true
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Override layout',
    checked: overrideColumnLayoutMd,
    onChange: value => {
      setAttributes({
        overrideColumnLayoutMd: value
      });
    }
  }), !!overrideColumnLayoutMd && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Column Distribution",
    value: columnLayoutMd,
    onChange: value => setAttributes({
      columnLayoutMd: value
    }),
    min: 1,
    max: 11
  }), !!overrideColumnLayoutMd && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Column Spacing",
    value: columnSpacingMd,
    onChange: value => setAttributes({
      columnSpacingMd: value
    }),
    min: 0,
    max: 120,
    step: 10
  })), ['xs', 'sm'].includes(columnBreakpoint) && responsiveDeviceMode == 'sm' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: 'Layout',
    initialOpen: true
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Override layout',
    checked: overrideColumnLayoutSm,
    onChange: value => {
      setAttributes({
        overrideColumnLayoutSm: value
      });
    }
  }), !!overrideColumnLayoutSm && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Column Distribution",
    value: columnLayoutSm,
    onChange: value => setAttributes({
      columnLayoutSm: value
    }),
    min: 1,
    max: 11
  }), !!overrideColumnLayoutSm && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Column Spacing",
    value: columnSpacingSm,
    onChange: value => setAttributes({
      columnSpacingSm: value
    }),
    min: 0,
    max: 120,
    step: 10
  })), ['xs'].includes(columnBreakpoint) && responsiveDeviceMode == 'xs' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: 'Layout',
    initialOpen: true
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Override layout',
    checked: overrideColumnLayoutXs,
    onChange: value => {
      setAttributes({
        overrideColumnLayoutXs: value
      });
    }
  }), !!overrideColumnLayoutXs && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Column Distribution",
    value: columnLayoutXs,
    onChange: value => setAttributes({
      columnLayoutXs: value
    }),
    min: 1,
    max: 11
  }), !!overrideColumnLayoutXs && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Column Spacing",
    value: columnSpacingXs,
    onChange: value => setAttributes({
      columnSpacingXs: value
    }),
    min: 0,
    max: 120,
    step: 10
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: 'Style',
    initialOpen: false
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Enable Middle Border',
    checked: middleBorder,
    onChange: value => {
      setAttributes({
        middleBorder: value
      });
    }
  }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.useBlockProps)(customProps), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "inner"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "columns"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "inner"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(InnerBlocks, {
    allowedBlocks: ALLOWED_BLOCKS,
    template: TEMPLATE,
    orientation: "horizontal",
    templateLock: "insert"
  })))))];
}

/***/ }),

/***/ "./blocks/two-column/src/index.js":
/*!****************************************!*\
  !*** ./blocks/two-column/src/index.js ***!
  \****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./style.scss */ "./blocks/two-column/src/style.scss");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./edit */ "./blocks/two-column/src/edit.js");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./save */ "./blocks/two-column/src/save.js");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../block.json */ "./blocks/two-column/block.json");
/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */


/**
 * Internal dependencies
 */




/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */

(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)(_block_json__WEBPACK_IMPORTED_MODULE_4__.name, {
  attributes: {
    responsiveDeviceMode: {
      type: 'string',
      default: 'xl'
    },
    columnBreakpoint: {
      type: 'string',
      default: 'md'
    },
    columnCount: {
      type: 'number',
      default: 2
    },
    columnLayoutXl: {
      type: 'number',
      default: 6
    },
    columnSpacingXl: {
      type: 'number',
      default: 30
    },
    overrideColumnLayoutLg: {
      type: 'boolean',
      default: false
    },
    columnLayoutLg: {
      type: 'number',
      default: 6
    },
    columnSpacingLg: {
      type: 'number',
      default: 30
    },
    overrideColumnLayoutMd: {
      type: 'boolean',
      default: false
    },
    columnLayoutMd: {
      type: 'number',
      default: 6
    },
    columnSpacingMd: {
      type: 'number',
      default: 30
    },
    overrideColumnLayoutSm: {
      type: 'boolean',
      default: false
    },
    columnLayoutSm: {
      type: 'number',
      default: 6
    },
    columnSpacingSm: {
      type: 'number',
      default: 30
    },
    overrideColumnLayoutXs: {
      type: 'boolean',
      default: false
    },
    columnLayoutXs: {
      type: 'number',
      default: 6
    },
    columnSpacingXs: {
      type: 'number',
      default: 30
    },
    middleBorder: {
      type: 'boolean',
      default: false
    }
  },

  /**
   * @see ./edit.js
   */
  edit: _edit__WEBPACK_IMPORTED_MODULE_2__["default"],

  /**
   * @see ./save.js
   */
  save: _save__WEBPACK_IMPORTED_MODULE_3__["default"]
});

/***/ }),

/***/ "./blocks/two-column/src/save.js":
/*!***************************************!*\
  !*** ./blocks/two-column/src/save.js ***!
  \***************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ save; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__);


/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
 */


/**
 * Import required components for saving
 */

const {
  InnerBlocks
} = wp.blockEditor;
/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#save
 *
 * @return {WPElement} Element to render.
 */

function save({
  attributes,
  className
}) {
  const {
    columnBreakpoint,
    columnCount,
    columnLayoutXl,
    columnSpacingXl,
    overrideColumnLayoutLg,
    columnLayoutLg,
    columnSpacingLg,
    overrideColumnLayoutMd,
    columnLayoutMd,
    columnSpacingMd,
    overrideColumnLayoutSm,
    columnLayoutSm,
    columnSpacingSm,
    overrideColumnLayoutXs,
    columnLayoutXs,
    columnSpacingXs,
    middleBorder
  } = attributes;
  let blockClasses = [className];
  let blockStyle = {};
  blockClasses.push('column-breakpoint-' + columnBreakpoint);
  blockClasses.push('column-count-' + columnCount);
  let defaultLayoutBrakpoint = columnBreakpoint;

  if (['xs'].includes(columnBreakpoint) && overrideColumnLayoutXs) {
    defaultLayoutBrakpoint = 'sm';
    blockClasses.push('column-layout-xs-' + columnLayoutXs);
    blockClasses.push('column-spacing-xs-' + columnSpacingXs);
  }

  if (['xs', 'sm'].includes(columnBreakpoint) && overrideColumnLayoutSm) {
    defaultLayoutBrakpoint = 'md';
    blockClasses.push('column-layout-sm-' + columnLayoutSm);
    blockClasses.push('column-spacing-sm-' + columnSpacingSm);
  }

  if (['xs', 'sm', 'md'].includes(columnBreakpoint) && overrideColumnLayoutMd) {
    defaultLayoutBrakpoint = 'lg';
    blockClasses.push('column-layout-md-' + columnLayoutMd);
    blockClasses.push('column-spacing-md-' + columnSpacingMd);
  }

  if (['xs', 'sm', 'md', 'lg'].includes(columnBreakpoint) && overrideColumnLayoutLg) {
    defaultLayoutBrakpoint = 'xl';
    blockClasses.push('column-layout-lg-' + columnLayoutLg);
    blockClasses.push('column-spacing-lg-' + columnSpacingLg);
  }

  blockClasses.push('column-layout-' + defaultLayoutBrakpoint + '-' + columnLayoutXl);
  blockClasses.push('column-spacing-' + defaultLayoutBrakpoint + '-' + columnSpacingXl);

  if (middleBorder) {
    blockClasses.push('middle-border');
  } // This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag


  let customProps = {
    className: blockClasses.join(' '),
    style: blockStyle,
    key: 'two-column'
  };
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.useBlockProps.save(customProps), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "inner"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "columns"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "inner"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(InnerBlocks.Content, null)))));
}

/***/ }),

/***/ "./blocks/two-column/src/editor.scss":
/*!*******************************************!*\
  !*** ./blocks/two-column/src/editor.scss ***!
  \*******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./blocks/two-column/src/style.scss":
/*!******************************************!*\
  !*** ./blocks/two-column/src/style.scss ***!
  \******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ (function(module) {

module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ (function(module) {

module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ (function(module) {

module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ (function(module) {

module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "./blocks/two-column/block.json":
/*!**************************************!*\
  !*** ./blocks/two-column/block.json ***!
  \**************************************/
/***/ (function(module) {

module.exports = JSON.parse('{"apiVersion":2,"name":"crown-blocks/two-column","version":"0.1.0","title":"Two Column","category":"layout","icon":"columns","description":"Two Column block","supports":{"html":false},"textdomain":"crown-blocks","editorScript":"file:./build/index.js","script":"file:./build/public.js","editorStyle":"file:./build/index.css","style":"file:./build/style-index.css"}');

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	!function() {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = function(result, chunkIds, fn, priority) {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var chunkIds = deferred[i][0];
/******/ 				var fn = deferred[i][1];
/******/ 				var priority = deferred[i][2];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every(function(key) { return __webpack_require__.O[key](chunkIds[j]); })) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	!function() {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"index": 0,
/******/ 			"style-index": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = function(chunkId) { return installedChunks[chunkId] === 0; };
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = function(parentChunkLoadingFunction, data) {
/******/ 			var chunkIds = data[0];
/******/ 			var moreModules = data[1];
/******/ 			var runtime = data[2];
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some(function(id) { return installedChunks[id] !== 0; })) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkIds[i]] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkcrown_blocks"] = self["webpackChunkcrown_blocks"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	}();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["style-index"], function() { return __webpack_require__("./blocks/two-column/src/index.js"); })
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map