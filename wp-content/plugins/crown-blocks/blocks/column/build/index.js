/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./blocks/column/src/edit.js":
/*!***********************************!*\
  !*** ./blocks/column/src/edit.js ***!
  \***********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ Edit; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./editor.scss */ "./blocks/column/src/editor.scss");


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
  ToggleControl,
  TextControl,
  TextareaControl,
  SelectControl
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
  const {
    responsiveDeviceMode,
    overrideVerticalSpacingXl,
    paddingTopXl,
    paddingBottomXl,
    overflowBottomXl,
    overrideHorizontalSpacingXl,
    paddingLeftXl,
    paddingRightXl,
    overrideVerticalSpacingLg,
    paddingTopLg,
    paddingBottomLg,
    overflowBottomLg,
    overrideHorizontalSpacingLg,
    paddingLeftLg,
    paddingRightLg,
    overrideVerticalSpacingMd,
    paddingTopMd,
    paddingBottomMd,
    overflowBottomMd,
    overrideHorizontalSpacingMd,
    paddingLeftMd,
    paddingRightMd,
    overrideVerticalSpacingSm,
    paddingTopSm,
    paddingBottomSm,
    overflowBottomSm,
    overrideHorizontalSpacingSm,
    paddingLeftSm,
    paddingRightSm,
    overrideVerticalSpacingXs,
    paddingTopXs,
    paddingBottomXs,
    overflowBottomXs,
    overrideHorizontalSpacingXs,
    paddingLeftXs,
    paddingRightXs,
    verticalAlignment,
    enableShadow,
    columnPadding
  } = attributes;
  let blockClasses = [className, 'column'];
  let blockStyle = {};

  if (overrideHorizontalSpacingXl) {
    blockClasses.push('contents-pl-xl-' + paddingLeftXl);
    blockClasses.push('contents-pr-xl-' + paddingRightXl);
  }

  if (overrideVerticalSpacingXl) {
    blockClasses.push('contents-pt-xl-' + paddingTopXl);
    blockClasses.push('contents-pb-xl-' + paddingBottomXl);
    if (overflowBottomXl > 0) blockClasses.push('contents-ob-xl-' + overflowBottomXl);
  }

  if (overrideHorizontalSpacingLg) {
    blockClasses.push('contents-pl-lg-' + paddingLeftLg);
    blockClasses.push('contents-pr-lg-' + paddingRightLg);
  }

  if (overrideVerticalSpacingLg) {
    blockClasses.push('contents-pt-lg-' + paddingTopLg);
    blockClasses.push('contents-pb-lg-' + paddingBottomLg);
    if (overflowBottomLg > 0) blockClasses.push('contents-ob-lg-' + overflowBottomLg);
  }

  if (overrideHorizontalSpacingMd) {
    blockClasses.push('contents-pl-md-' + paddingLeftMd);
    blockClasses.push('contents-pr-md-' + paddingRightMd);
  }

  if (overrideVerticalSpacingMd) {
    blockClasses.push('contents-pt-md-' + paddingTopMd);
    blockClasses.push('contents-pb-md-' + paddingBottomMd);
    if (overflowBottomMd > 0) blockClasses.push('contents-ob-md-' + overflowBottomMd);
  }

  if (overrideHorizontalSpacingSm) {
    blockClasses.push('contents-pl-sm-' + paddingLeftSm);
    blockClasses.push('contents-pr-sm-' + paddingRightSm);
  }

  if (overrideVerticalSpacingSm) {
    blockClasses.push('contents-pt-sm-' + paddingTopSm);
    blockClasses.push('contents-pb-sm-' + paddingBottomSm);
    if (overflowBottomSm > 0) blockClasses.push('contents-ob-sm-' + overflowBottomSm);
  }

  if (overrideHorizontalSpacingXs) {
    blockClasses.push('contents-pl-' + paddingLeftXs);
    blockClasses.push('contents-pr-' + paddingRightXs);
  }

  if (overrideVerticalSpacingXs) {
    blockClasses.push('contents-pt-' + paddingTopXs);
    blockClasses.push('contents-pb-' + paddingBottomXs);
    if (overflowBottomXs > 0) blockClasses.push('contents-ob-' + overflowBottomXs);
  }

  if (verticalAlignment != '') blockClasses.push('vertical-alignment-' + verticalAlignment);

  if (enableShadow) {
    blockClasses.push('enable-shadow');
  }

  let blockInnerStyles = {};

  if (enableShadow && typeof columnPadding !== 'undefined') {
    blockInnerStyles.padding = columnPadding + 'px';

    if (columnPadding > 30) {
      blockClasses.push('large-padding');
    }
  } // This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag


  let customProps = {
    className: blockClasses.join(' '),
    style: blockStyle,
    key: 'column'
  };
  return [(0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(InspectorControls, {
    key: "inspector-controls"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    class: "crown-blocks-responsive-device-mode-toggles"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ButtonGroup, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
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
  }, "1200px")))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
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
  }, "992px")))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
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
  }, "768px")))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
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
  }, "576px")))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
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
  }, "Base")))))), responsiveDeviceMode == 'xl' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: 'Spacing',
    initialOpen: true
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Override horizontal spacing',
    checked: overrideHorizontalSpacingXl,
    onChange: value => {
      setAttributes({
        overrideHorizontalSpacingXl: value
      });
    }
  }), !!overrideHorizontalSpacingXl && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Left Padding",
    value: paddingLeftXl,
    onChange: value => setAttributes({
      paddingLeftXl: value
    }),
    min: 0,
    max: 20
  }), !!overrideHorizontalSpacingXl && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Right Padding",
    value: paddingRightXl,
    onChange: value => setAttributes({
      paddingRightXl: value
    }),
    min: 0,
    max: 20
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Override vertical spacing',
    checked: overrideVerticalSpacingXl,
    onChange: value => {
      setAttributes({
        overrideVerticalSpacingXl: value
      });
    }
  }), !!overrideVerticalSpacingXl && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Top Padding",
    value: paddingTopXl,
    onChange: value => setAttributes({
      paddingTopXl: value
    }),
    min: 0,
    max: 20
  }), !!overrideVerticalSpacingXl && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Bottom Padding",
    value: paddingBottomXl,
    onChange: value => setAttributes({
      paddingBottomXl: value
    }),
    min: 0,
    max: 20
  }), !!overrideVerticalSpacingXl && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Bottom Overflow",
    value: overflowBottomXl,
    onChange: value => setAttributes({
      overflowBottomXl: value
    }),
    min: 0,
    max: 20
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Enable column shadow',
    checked: enableShadow,
    onChange: value => {
      setAttributes({
        enableShadow: value
      });
    }
  }), enableShadow && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Column Padding",
    value: columnPadding,
    onChange: value => setAttributes({
      columnPadding: value
    }),
    min: 0,
    max: 120,
    step: 5
  })), responsiveDeviceMode == 'lg' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: 'Spacing',
    initialOpen: true
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Override horizontal spacing',
    checked: overrideHorizontalSpacingLg,
    onChange: value => {
      setAttributes({
        overrideHorizontalSpacingLg: value
      });
    }
  }), !!overrideHorizontalSpacingLg && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Left Padding",
    value: paddingLeftLg,
    onChange: value => setAttributes({
      paddingLeftLg: value
    }),
    min: 0,
    max: 20
  }), !!overrideHorizontalSpacingLg && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Right Padding",
    value: paddingRightLg,
    onChange: value => setAttributes({
      paddingRightLg: value
    }),
    min: 0,
    max: 20
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Override vertical spacing',
    checked: overrideVerticalSpacingLg,
    onChange: value => {
      setAttributes({
        overrideVerticalSpacingLg: value
      });
    }
  }), !!overrideVerticalSpacingLg && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Top Padding",
    value: paddingTopLg,
    onChange: value => setAttributes({
      paddingTopLg: value
    }),
    min: 0,
    max: 20
  }), !!overrideVerticalSpacingLg && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Bottom Padding",
    value: paddingBottomLg,
    onChange: value => setAttributes({
      paddingBottomLg: value
    }),
    min: 0,
    max: 20
  }), !!overrideVerticalSpacingLg && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Bottom Overflow",
    value: overflowBottomLg,
    onChange: value => setAttributes({
      overflowBottomLg: value
    }),
    min: 0,
    max: 20
  })), responsiveDeviceMode == 'md' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: 'Spacing',
    initialOpen: true
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Override horizontal spacing',
    checked: overrideHorizontalSpacingMd,
    onChange: value => {
      setAttributes({
        overrideHorizontalSpacingMd: value
      });
    }
  }), !!overrideHorizontalSpacingMd && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Left Padding",
    value: paddingLeftMd,
    onChange: value => setAttributes({
      paddingLeftMd: value
    }),
    min: 0,
    max: 20
  }), !!overrideHorizontalSpacingMd && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Right Padding",
    value: paddingRightMd,
    onChange: value => setAttributes({
      paddingRightMd: value
    }),
    min: 0,
    max: 20
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Override vertical spacing',
    checked: overrideVerticalSpacingMd,
    onChange: value => {
      setAttributes({
        overrideVerticalSpacingMd: value
      });
    }
  }), !!overrideVerticalSpacingMd && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Top Padding",
    value: paddingTopMd,
    onChange: value => setAttributes({
      paddingTopMd: value
    }),
    min: 0,
    max: 20
  }), !!overrideVerticalSpacingMd && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Bottom Padding",
    value: paddingBottomMd,
    onChange: value => setAttributes({
      paddingBottomMd: value
    }),
    min: 0,
    max: 20
  }), !!overrideVerticalSpacingMd && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Bottom Overflow",
    value: overflowBottomMd,
    onChange: value => setAttributes({
      overflowBottomMd: value
    }),
    min: 0,
    max: 20
  })), responsiveDeviceMode == 'sm' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: 'Spacing',
    initialOpen: true
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Override horizontal spacing',
    checked: overrideHorizontalSpacingSm,
    onChange: value => {
      setAttributes({
        overrideHorizontalSpacingSm: value
      });
    }
  }), !!overrideHorizontalSpacingSm && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Left Padding",
    value: paddingLeftSm,
    onChange: value => setAttributes({
      paddingLeftSm: value
    }),
    min: 0,
    max: 20
  }), !!overrideHorizontalSpacingSm && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Right Padding",
    value: paddingRightSm,
    onChange: value => setAttributes({
      paddingRightSm: value
    }),
    min: 0,
    max: 20
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Override vertical spacing',
    checked: overrideVerticalSpacingSm,
    onChange: value => {
      setAttributes({
        overrideVerticalSpacingSm: value
      });
    }
  }), !!overrideVerticalSpacingSm && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Top Padding",
    value: paddingTopSm,
    onChange: value => setAttributes({
      paddingTopSm: value
    }),
    min: 0,
    max: 20
  }), !!overrideVerticalSpacingSm && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Bottom Padding",
    value: paddingBottomSm,
    onChange: value => setAttributes({
      paddingBottomSm: value
    }),
    min: 0,
    max: 20
  }), !!overrideVerticalSpacingSm && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Bottom Overflow",
    value: overflowBottomSm,
    onChange: value => setAttributes({
      overflowBottomSm: value
    }),
    min: 0,
    max: 20
  })), responsiveDeviceMode == 'xs' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: 'Spacing',
    initialOpen: true
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Override horizontal spacing',
    checked: overrideHorizontalSpacingXs,
    onChange: value => {
      setAttributes({
        overrideHorizontalSpacingXs: value
      });
    }
  }), !!overrideHorizontalSpacingXs && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Left Padding",
    value: paddingLeftXs,
    onChange: value => setAttributes({
      paddingLeftXs: value
    }),
    min: 0,
    max: 20
  }), !!overrideHorizontalSpacingXs && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Right Padding",
    value: paddingRightXs,
    onChange: value => setAttributes({
      paddingRightXs: value
    }),
    min: 0,
    max: 20
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Override vertical spacing',
    checked: overrideVerticalSpacingXs,
    onChange: value => {
      setAttributes({
        overrideVerticalSpacingXs: value
      });
    }
  }), !!overrideVerticalSpacingXs && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Top Padding",
    value: paddingTopXs,
    onChange: value => setAttributes({
      paddingTopXs: value
    }),
    min: 0,
    max: 20
  }), !!overrideVerticalSpacingXs && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Bottom Padding",
    value: paddingBottomXs,
    onChange: value => setAttributes({
      paddingBottomXs: value
    }),
    min: 0,
    max: 20
  }), !!overrideVerticalSpacingXs && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Bottom Overflow",
    value: overflowBottomXs,
    onChange: value => setAttributes({
      overflowBottomXs: value
    }),
    min: 0,
    max: 20
  })), responsiveDeviceMode == 'xl' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: 'Vertical Alignment',
    initialOpen: true
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ButtonGroup, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
    isPrimary: verticalAlignment == 'top',
    isSecondary: verticalAlignment != 'top',
    onClick: e => setAttributes({
      verticalAlignment: 'top'
    })
  }, "Top"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
    isPrimary: verticalAlignment == 'center',
    isSecondary: verticalAlignment != 'center',
    onClick: e => setAttributes({
      verticalAlignment: 'center'
    })
  }, "Center"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
    isPrimary: verticalAlignment == 'bottom',
    isSecondary: verticalAlignment != 'bottom',
    onClick: e => setAttributes({
      verticalAlignment: 'bottom'
    })
  }, "Bottom")))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.useBlockProps)(customProps), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "inner",
    style: blockInnerStyles
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "column-contents"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "inner"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(InnerBlocks, {
    templateLock: false
  })))))];
}

/***/ }),

/***/ "./blocks/column/src/index.js":
/*!************************************!*\
  !*** ./blocks/column/src/index.js ***!
  \************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./style.scss */ "./blocks/column/src/style.scss");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./edit */ "./blocks/column/src/edit.js");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./save */ "./blocks/column/src/save.js");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../block.json */ "./blocks/column/block.json");
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
    overrideVerticalSpacingXl: {
      type: 'boolean',
      default: false
    },
    paddingTopXl: {
      type: 'number',
      default: 0
    },
    paddingBottomXl: {
      type: 'number',
      default: 0
    },
    overflowBottomXl: {
      type: 'number',
      default: 0
    },
    overrideHorizontalSpacingXl: {
      type: 'boolean',
      default: false
    },
    paddingLeftXl: {
      type: 'number',
      default: 0
    },
    paddingRightXl: {
      type: 'number',
      default: 0
    },
    overrideVerticalSpacingLg: {
      type: 'boolean',
      default: false
    },
    paddingTopLg: {
      type: 'number',
      default: 0
    },
    paddingBottomLg: {
      type: 'number',
      default: 0
    },
    overflowBottomLg: {
      type: 'number',
      default: 0
    },
    overrideHorizontalSpacingLg: {
      type: 'boolean',
      default: false
    },
    paddingLeftLg: {
      type: 'number',
      default: 0
    },
    paddingRightLg: {
      type: 'number',
      default: 0
    },
    overrideVerticalSpacingMd: {
      type: 'boolean',
      default: false
    },
    paddingTopMd: {
      type: 'number',
      default: 0
    },
    paddingBottomMd: {
      type: 'number',
      default: 0
    },
    overflowBottomMd: {
      type: 'number',
      default: 0
    },
    overrideHorizontalSpacingMd: {
      type: 'boolean',
      default: false
    },
    paddingLeftMd: {
      type: 'number',
      default: 0
    },
    paddingRightMd: {
      type: 'number',
      default: 0
    },
    overrideVerticalSpacingSM: {
      type: 'boolean',
      default: false
    },
    paddingTopSM: {
      type: 'number',
      default: 0
    },
    paddingBottomSM: {
      type: 'number',
      default: 0
    },
    overflowBottomSM: {
      type: 'number',
      default: 0
    },
    overrideHorizontalSpacingSM: {
      type: 'boolean',
      default: false
    },
    paddingLeftSM: {
      type: 'number',
      default: 0
    },
    paddingRightSM: {
      type: 'number',
      default: 0
    },
    overrideVerticalSpacingXs: {
      type: 'boolean',
      default: false
    },
    paddingTopXs: {
      type: 'number',
      default: 0
    },
    paddingBottomXs: {
      type: 'number',
      default: 0
    },
    overflowBottomXs: {
      type: 'number',
      default: 0
    },
    overrideHorizontalSpacingXs: {
      type: 'boolean',
      default: false
    },
    paddingLeftXs: {
      type: 'number',
      default: 0
    },
    paddingRightXs: {
      type: 'number',
      default: 0
    },
    verticalAlignment: {
      type: 'string',
      default: ''
    },
    enableShadow: {
      type: 'boolean',
      default: false
    },
    columnPadding: {
      type: 'number',
      default: 30
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

/***/ "./blocks/column/src/save.js":
/*!***********************************!*\
  !*** ./blocks/column/src/save.js ***!
  \***********************************/
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
    responsiveDeviceMode,
    overrideVerticalSpacingXl,
    paddingTopXl,
    paddingBottomXl,
    overflowBottomXl,
    overrideHorizontalSpacingXl,
    paddingLeftXl,
    paddingRightXl,
    overrideVerticalSpacingLg,
    paddingTopLg,
    paddingBottomLg,
    overflowBottomLg,
    overrideHorizontalSpacingLg,
    paddingLeftLg,
    paddingRightLg,
    overrideVerticalSpacingMd,
    paddingTopMd,
    paddingBottomMd,
    overflowBottomMd,
    overrideHorizontalSpacingMd,
    paddingLeftMd,
    paddingRightMd,
    overrideVerticalSpacingSm,
    paddingTopSm,
    paddingBottomSm,
    overflowBottomSm,
    overrideHorizontalSpacingSm,
    paddingLeftSm,
    paddingRightSm,
    overrideVerticalSpacingXs,
    paddingTopXs,
    paddingBottomXs,
    overflowBottomXs,
    overrideHorizontalSpacingXs,
    paddingLeftXs,
    paddingRightXs,
    verticalAlignment,
    enableShadow,
    columnPadding
  } = attributes;
  let blockClasses = [className, 'column'];
  let blockStyle = {};

  if (overrideHorizontalSpacingXl) {
    blockClasses.push('contents-pl-xl-' + paddingLeftXl);
    blockClasses.push('contents-pr-xl-' + paddingRightXl);
  }

  if (overrideVerticalSpacingXl) {
    blockClasses.push('contents-pt-xl-' + paddingTopXl);
    blockClasses.push('contents-pb-xl-' + paddingBottomXl);
    if (overflowBottomXl > 0) blockClasses.push('contents-ob-xl-' + overflowBottomXl);
  }

  if (overrideHorizontalSpacingLg) {
    blockClasses.push('contents-pl-lg-' + paddingLeftLg);
    blockClasses.push('contents-pr-lg-' + paddingRightLg);
  }

  if (overrideVerticalSpacingLg) {
    blockClasses.push('contents-pt-lg-' + paddingTopLg);
    blockClasses.push('contents-pb-lg-' + paddingBottomLg);
    if (overflowBottomLg > 0) blockClasses.push('contents-ob-lg-' + overflowBottomLg);
  }

  if (overrideHorizontalSpacingMd) {
    blockClasses.push('contents-pl-md-' + paddingLeftMd);
    blockClasses.push('contents-pr-md-' + paddingRightMd);
  }

  if (overrideVerticalSpacingMd) {
    blockClasses.push('contents-pt-md-' + paddingTopMd);
    blockClasses.push('contents-pb-md-' + paddingBottomMd);
    if (overflowBottomMd > 0) blockClasses.push('contents-ob-md-' + overflowBottomMd);
  }

  if (overrideHorizontalSpacingSm) {
    blockClasses.push('contents-pl-sm-' + paddingLeftSm);
    blockClasses.push('contents-pr-sm-' + paddingRightSm);
  }

  if (overrideVerticalSpacingSm) {
    blockClasses.push('contents-pt-sm-' + paddingTopSm);
    blockClasses.push('contents-pb-sm-' + paddingBottomSm);
    if (overflowBottomSm > 0) blockClasses.push('contents-ob-sm-' + overflowBottomSm);
  }

  if (overrideHorizontalSpacingXs) {
    blockClasses.push('contents-pl-' + paddingLeftXs);
    blockClasses.push('contents-pr-' + paddingRightXs);
  }

  if (overrideVerticalSpacingXs) {
    blockClasses.push('contents-pt-' + paddingTopXs);
    blockClasses.push('contents-pb-' + paddingBottomXs);
    if (overflowBottomXs > 0) blockClasses.push('contents-ob-' + overflowBottomXs);
  }

  if (verticalAlignment != '') blockClasses.push('vertical-alignment-' + verticalAlignment);

  if (enableShadow) {
    blockClasses.push('enable-shadow');
  }

  let blockInnerStyles = {};

  if (enableShadow && typeof columnPadding !== 'undefined') {
    blockInnerStyles.padding = columnPadding + 'px';

    if (columnPadding > 30) {
      blockClasses.push('large-padding');
    }
  } // This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag


  let customProps = {
    className: blockClasses.join(' '),
    style: blockStyle,
    key: 'column'
  };
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.useBlockProps.save(customProps), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "inner",
    style: blockInnerStyles
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "column-contents"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "inner"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(InnerBlocks.Content, null)))));
}

/***/ }),

/***/ "./blocks/column/src/editor.scss":
/*!***************************************!*\
  !*** ./blocks/column/src/editor.scss ***!
  \***************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./blocks/column/src/style.scss":
/*!**************************************!*\
  !*** ./blocks/column/src/style.scss ***!
  \**************************************/
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

/***/ "./blocks/column/block.json":
/*!**********************************!*\
  !*** ./blocks/column/block.json ***!
  \**********************************/
/***/ (function(module) {

module.exports = JSON.parse('{"apiVersion":2,"name":"crown-blocks/column","version":"0.1.0","title":"Column","category":"widgets","icon":"columns","description":"Column block","parent":["crown-blocks/two-column"],"supports":{"html":false},"textdomain":"crown-blocks","editorScript":"file:./build/index.js","script":"file:./build/public.js","editorStyle":"file:./build/index.css","style":"file:./build/style-index.css"}');

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
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["style-index"], function() { return __webpack_require__("./blocks/column/src/index.js"); })
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map