/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./blocks/page-section/src/edit.js":
/*!*****************************************!*\
  !*** ./blocks/page-section/src/edit.js ***!
  \*****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ Edit; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _common_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../common.js */ "./common.js");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./editor.scss */ "./blocks/page-section/src/editor.scss");


/**
 * Import Crown helper functions
 */

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
  RichText,
  MediaUpload,
  BlockControls,
  AlignmentToolbar,
  InspectorControls,
  PanelColorSettings
} = wp.blockEditor;
const {
  PanelBody,
  RadioControl,
  CheckboxControl,
  ColorPicker,
  RangeControl,
  FocalPointPicker,
  ToggleControl,
  TextControl,
  TextareaControl,
  SelectControl,
  Button,
  ButtonGroup,
  Icon,
  BaseControl
} = wp.components;
const {
  getColorObjectByColorValue
} = wp.blockEditor;
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
  const TEMPLATE = [['core/heading', {
    placeholder: 'Page Section Title...',
    level: '2'
  }], // defaults to H1 tag for header block
  ['core/paragraph', {}]];
  const {
    textAlign,
    contentAlign,
    responsiveDeviceMode,
    restrictContentWidth,
    contentsMaxWidth,
    slantedBg,
    slantedBgTop,
    slantedBgTopReverse,
    slantedBgBottom,
    slantedBgBottomReverse,
    fullWidth,
    overrideVerticalSpacingXl,
    paddingTopXl,
    paddingBottomXl,
    overflowTopXl,
    overflowBottomXl,
    overrideHorizontalSpacingXl,
    paddingXXl,
    overflowXXl,
    overrideVerticalSpacingLg,
    paddingTopLg,
    paddingBottomLg,
    overflowTopLg,
    overflowBottomLg,
    overrideHorizontalSpacingLg,
    paddingXLg,
    overflowXLg,
    overrideVerticalSpacingMd,
    paddingTopMd,
    paddingBottomMd,
    overflowTopMd,
    overflowBottomMd,
    overrideHorizontalSpacingMd,
    paddingXMd,
    overflowXMd,
    overrideVerticalSpacingSm,
    paddingTopSm,
    paddingBottomSm,
    overflowTopSm,
    overflowBottomSm,
    overrideHorizontalSpacingSm,
    paddingXSm,
    overflowXSm,
    overrideVerticalSpacingXs,
    paddingTopXs,
    paddingBottomXs,
    overflowTopXs,
    overflowBottomXs,
    overrideHorizontalSpacingXs,
    paddingXXs,
    overflowXXs,
    backgroundColor,
    backgroundImageId,
    backgroundImageData,
    backgroundImageFocalPoint,
    backgroundImageOpacity,
    backgroundImageGrayscale,
    backgroundImageBlendMode,
    backgroundImageContain,
    textColor,
    lineStyle
  } = attributes;
  let blockClasses = [className];

  if (fullWidth) {
    blockClasses.push('full-width');
  }

  if (restrictContentWidth) {
    blockClasses.push('restricted-content-width');
  }

  if (contentAlign) {
    blockClasses.push('content-align-' + contentAlign);
  }

  if (textAlign) {
    blockClasses.push('text-align-' + textAlign);
  }

  if (textColor == 'auto' && backgroundColor) {
    blockClasses.push('text-color-' + (_common_js__WEBPACK_IMPORTED_MODULE_1__["default"].isDarkColor(backgroundColor) ? 'light' : 'dark'));
  } else if (textColor != 'auto') {
    blockClasses.push('text-color-' + textColor);
  }

  if (lineStyle) {
    blockClasses.push('line');
    blockClasses.push('line-' + lineStyle);
  }

  let blockStyle = {};

  if (backgroundColor) {
    blockStyle.backgroundColor = backgroundColor;
    let settings = wp.data.select('core/editor').getEditorSettings(); // if(settings.colors) {
    // 	let colorObject = getColorObjectByColorValue(settings.colors, backgroundColor);
    // 	if(colorObject) blockClasses.push('bg-color-' + colorObject.slug);
    // }
  }

  if (slantedBg) {
    if (slantedBgTop) {
      blockClasses.push('slanted-bg-top');

      if (slantedBgTopReverse) {
        blockClasses.push('slanted-bg-top-reverse');
      }
    }

    if (slantedBgBottom) {
      blockClasses.push('slanted-bg-bottom');

      if (slantedBgBottomReverse) {
        blockClasses.push('slanted-bg-bottom-reverse');
      }
    }
  }

  if (overrideVerticalSpacingXl) {
    blockClasses.push('contents-pt-xl-' + paddingTopXl);
    blockClasses.push('contents-pb-xl-' + paddingBottomXl);
    if (overflowTopXl > 0) blockClasses.push('contents-ot-xl-' + overflowTopXl);
    if (overflowBottomXl > 0) blockClasses.push('contents-ob-xl-' + overflowBottomXl);
  }

  if (overrideHorizontalSpacingXl) {
    blockClasses.push('contents-px-xl-' + paddingXXl);
    if (overflowXXl > 0) blockClasses.push('contents-ox-xl-' + overflowXXl);
  }

  if (overrideVerticalSpacingLg) {
    blockClasses.push('contents-pt-lg-' + paddingTopLg);
    blockClasses.push('contents-pb-lg-' + paddingBottomLg);
    if (overflowTopLg > 0) blockClasses.push('contents-ot-lg-' + overflowTopLg);
    if (overflowBottomLg > 0) blockClasses.push('contents-ob-lg-' + overflowBottomLg);
  }

  if (overrideHorizontalSpacingLg) {
    blockClasses.push('contents-px-lg-' + paddingXLg);
    if (overflowXLg > 0) blockClasses.push('contents-ox-lg-' + overflowXLg);
  }

  if (overrideVerticalSpacingMd) {
    blockClasses.push('contents-pt-md-' + paddingTopMd);
    blockClasses.push('contents-pb-md-' + paddingBottomMd);
    if (overflowTopMd > 0) blockClasses.push('contents-ot-md-' + overflowTopMd);
    if (overflowBottomMd > 0) blockClasses.push('contents-ob-md-' + overflowBottomMd);
  }

  if (overrideHorizontalSpacingMd) {
    blockClasses.push('contents-px-md-' + paddingXMd);
    if (overflowXMd > 0) blockClasses.push('contents-ox-md-' + overflowXMd);
  }

  if (overrideVerticalSpacingSm) {
    blockClasses.push('contents-pt-sm-' + paddingTopSm);
    blockClasses.push('contents-pb-sm-' + paddingBottomSm);
    if (overflowTopSm > 0) blockClasses.push('contents-ot-sm-' + overflowTopSm);
    if (overflowBottomSm > 0) blockClasses.push('contents-ob-sm-' + overflowBottomSm);
  }

  if (overrideHorizontalSpacingSm) {
    blockClasses.push('contents-px-sm-' + paddingXSm);
    if (overflowXSm > 0) blockClasses.push('contents-ox-sm-' + overflowXSm);
  }

  if (overrideVerticalSpacingXs) {
    blockClasses.push('contents-pt-' + paddingTopXs);
    blockClasses.push('contents-pb-' + paddingBottomXs);
    if (overflowTopXs > 0) blockClasses.push('contents-ot-' + overflowTopXs);
    if (overflowBottomXs > 0) blockClasses.push('contents-ob-' + overflowBottomXs);
  }

  if (overrideHorizontalSpacingXs) {
    blockClasses.push('contents-ps-' + paddingXXs);
    if (overflowXXs > 0) blockClasses.push('contents-ox-' + overflowXXs);
  }

  let backgroundImageUrl = null;

  if (backgroundImageId) {
    backgroundImageUrl = backgroundImageData.sizes.fullscreen ? backgroundImageData.sizes.fullscreen.url : backgroundImageData.url;
    blockClasses.push('has-bg-image');
  }

  let bgColorSettings = [{
    label: 'Background Color',
    value: backgroundColor,
    onChange: value => setAttributes({
      backgroundColor: value ? value : ''
    })
  }]; // This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag

  let customProps = {
    className: blockClasses.join(' '),
    style: blockStyle,
    key: 'page-section'
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
    initialOpen: false
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Restrict content width',
    checked: restrictContentWidth,
    onChange: value => {
      setAttributes({
        restrictContentWidth: value
      });
    }
  }), !!restrictContentWidth && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Max Content Width",
    value: contentsMaxWidth,
    onChange: value => setAttributes({
      contentsMaxWidth: value
    }),
    min: 100,
    max: 1260,
    step: 10
  }), restrictContentWidth && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(BaseControl, {
    label: "Content Alignment"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ButtonGroup, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
    isPrimary: contentAlign == 'left',
    isSecondary: contentAlign != 'left',
    onClick: e => setAttributes({
      contentAlign: 'left'
    })
  }, "Left"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
    isPrimary: contentAlign == 'center',
    isSecondary: contentAlign != 'center',
    onClick: e => setAttributes({
      contentAlign: 'center'
    })
  }, "Center"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
    isPrimary: contentAlign == 'right',
    isSecondary: contentAlign != 'right',
    onClick: e => setAttributes({
      contentAlign: 'right'
    })
  }, "Right"))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
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
    label: "Top Overflow",
    value: overflowTopXl,
    onChange: value => setAttributes({
      overflowTopXl: value
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
    label: 'Override horizontal spacing',
    checked: overrideHorizontalSpacingXl,
    onChange: value => {
      setAttributes({
        overrideHorizontalSpacingXl: value
      });
    }
  }), !!overrideHorizontalSpacingXl && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Horizontal Padding",
    value: paddingXXl,
    onChange: value => setAttributes({
      paddingXXl: value
    }),
    min: 0,
    max: 20
  }), !!overrideHorizontalSpacingXl && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Horizontal Overflow",
    value: overflowXXl,
    onChange: value => setAttributes({
      overflowXXl: value
    }),
    min: 0,
    max: 20
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Enable Slanted Section Background',
    checked: slantedBg,
    onChange: value => {
      setAttributes({
        slantedBg: value
      });
    }
  }), slantedBg && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Background Slanted at Top',
    checked: slantedBgTop,
    onChange: value => {
      setAttributes({
        slantedBgTop: value
      });
    }
  }), slantedBg && slantedBgTop && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Reverse Top Slant',
    checked: slantedBgTopReverse,
    onChange: value => {
      setAttributes({
        slantedBgTopReverse: value
      });
    }
  }), slantedBg && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Background Slanted at Bottom',
    checked: slantedBgBottom,
    onChange: value => {
      setAttributes({
        slantedBgBottom: value
      });
    }
  }), slantedBg && slantedBgBottom && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Reverse Bottom Slant',
    checked: slantedBgBottomReverse,
    onChange: value => {
      setAttributes({
        slantedBgBottomReverse: value
      });
    }
  })), responsiveDeviceMode == 'lg' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: 'Spacing',
    initialOpen: true
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
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
    label: "Top Overflow",
    value: overflowTopLg,
    onChange: value => setAttributes({
      overflowTopLg: value
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
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Override horizontal spacing',
    checked: overrideHorizontalSpacingLg,
    onChange: value => {
      setAttributes({
        overrideHorizontalSpacingLg: value
      });
    }
  }), !!overrideHorizontalSpacingLg && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Horizontal Padding",
    value: paddingXLg,
    onChange: value => setAttributes({
      paddingXLg: value
    }),
    min: 0,
    max: 20
  }), !!overrideHorizontalSpacingLg && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Horizontal Overflow",
    value: overflowXLg,
    onChange: value => setAttributes({
      overflowXLg: value
    }),
    min: 0,
    max: 20
  })), responsiveDeviceMode == 'md' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: 'Spacing',
    initialOpen: true
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
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
    label: "Top Overflow",
    value: overflowTopMd,
    onChange: value => setAttributes({
      overflowTopMd: value
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
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Override horizontal spacing',
    checked: overrideHorizontalSpacingMd,
    onChange: value => {
      setAttributes({
        overrideHorizontalSpacingMd: value
      });
    }
  }), !!overrideHorizontalSpacingMd && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Horizontal Padding",
    value: paddingXMd,
    onChange: value => setAttributes({
      paddingXMd: value
    }),
    min: 0,
    max: 20
  }), !!overrideHorizontalSpacingMd && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Horizontal Overflow",
    value: overflowXMd,
    onChange: value => setAttributes({
      overflowXMd: value
    }),
    min: 0,
    max: 20
  })), responsiveDeviceMode == 'sm' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: 'Spacing',
    initialOpen: true
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
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
    label: "Top Overflow",
    value: overflowTopSm,
    onChange: value => setAttributes({
      overflowTopSm: value
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
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Override horizontal spacing',
    checked: overrideHorizontalSpacingSm,
    onChange: value => {
      setAttributes({
        overrideHorizontalSpacingSm: value
      });
    }
  }), !!overrideHorizontalSpacingSm && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Horizontal Padding",
    value: paddingXSm,
    onChange: value => setAttributes({
      paddingXSm: value
    }),
    min: 0,
    max: 20
  }), !!overrideHorizontalSpacingSm && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Horizontal Overflow",
    value: overflowXSm,
    onChange: value => setAttributes({
      overflowXSm: value
    }),
    min: 0,
    max: 20
  })), responsiveDeviceMode == 'xs' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: 'Spacing',
    initialOpen: true
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
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
    label: "Top Overflow",
    value: overflowTopXs,
    onChange: value => setAttributes({
      overflowTopXs: value
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
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Override horizontal spacing',
    checked: overrideHorizontalSpacingXs,
    onChange: value => {
      setAttributes({
        overrideHorizontalSpacingXs: value
      });
    }
  }), !!overrideHorizontalSpacingXs && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Horizontal Padding",
    value: paddingXXs,
    onChange: value => setAttributes({
      paddingXXs: value
    }),
    min: 0,
    max: 20
  }), !!overrideHorizontalSpacingXs && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Horizontal Overflow",
    value: overflowXXs,
    onChange: value => setAttributes({
      overflowXXs: value
    }),
    min: 0,
    max: 20
  })), responsiveDeviceMode == 'xl' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelColorSettings, {
    title: 'Background Color',
    initialOpen: false,
    colorSettings: bgColorSettings
  }), responsiveDeviceMode == 'xl' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: 'Background Image',
    className: 'crown-blocks-background-image',
    initialOpen: false
  }, !!backgroundImageId && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(FocalPointPicker, {
    label: "Focal Point",
    url: backgroundImageData.sizes.medium ? backgroundImageData.sizes.medium.url : backgroundImageData.sizes.thumbnail.url,
    dimensions: {
      width: 400,
      height: 100
    },
    value: backgroundImageFocalPoint,
    onChange: value => setAttributes({
      backgroundImageFocalPoint: value
    })
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(MediaUpload, {
    onSelect: media => {
      setAttributes({
        backgroundImageId: media.id,
        backgroundImageData: media,
        backgroundImageFocalPoint: {
          x: 0.5,
          y: 0.5
        }
      });
    },
    type: "image",
    value: backgroundImageId,
    render: ({
      open
    }) => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: 'crown-blocks-media-upload'
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
      className: 'button',
      onClick: open
    }, "Select Image"), backgroundImageId && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
      className: 'button is-link is-destructive',
      onClick: e => {
        setAttributes({
          backgroundImageId: null,
          backgroundImageData: null
        });
      }
    }, "Remove Image"))
  }), !!backgroundImageId && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Opacity",
    value: backgroundImageOpacity,
    onChange: value => setAttributes({
      backgroundImageOpacity: value
    }),
    min: 0,
    max: 100
  }), !!backgroundImageId && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: "Grayscale",
    value: backgroundImageGrayscale,
    onChange: value => setAttributes({
      backgroundImageGrayscale: value
    }),
    min: 0,
    max: 100
  }), !!backgroundImageId && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
    label: "Blend Mode",
    value: backgroundImageBlendMode,
    onChange: value => setAttributes({
      backgroundImageBlendMode: value
    }),
    options: [{
      label: 'Normal',
      value: 'normal'
    }, {
      label: 'Multiply',
      value: 'multiply'
    }, {
      label: 'Screen',
      value: 'screen'
    }, {
      label: 'Overlay',
      value: 'overlay'
    }, {
      label: 'Soft Light',
      value: 'soft-light'
    }, {
      label: 'Hard Light',
      value: 'hard-light'
    }, {
      label: 'Darken',
      value: 'darken'
    }, {
      label: 'Lighten',
      value: 'lighten'
    }]
  }), !!backgroundImageId && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Contain background image',
    checked: backgroundImageContain,
    onChange: value => {
      setAttributes({
        backgroundImageContain: value
      });
    }
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: 'Text Alignment',
    initialOpen: false
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ButtonGroup, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
    isPrimary: textAlign == 'left',
    isSecondary: textAlign != 'left',
    onClick: e => setAttributes({
      textAlign: 'left'
    })
  }, "Left"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
    isPrimary: textAlign == 'center',
    isSecondary: textAlign != 'center',
    onClick: e => setAttributes({
      textAlign: 'center'
    })
  }, "Center"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
    isPrimary: textAlign == 'right',
    isSecondary: textAlign != 'right',
    onClick: e => setAttributes({
      textAlign: 'right'
    })
  }, "Right"))), responsiveDeviceMode == 'xl' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: 'Text Settings',
    initialOpen: false
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(BaseControl, {
    label: 'Text Color'
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ButtonGroup, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
    isPrimary: textColor == 'auto',
    isSecondary: textColor != 'auto',
    onClick: e => setAttributes({
      textColor: 'auto'
    })
  }, "Auto"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
    isPrimary: textColor == 'dark',
    isSecondary: textColor != 'dark',
    onClick: e => setAttributes({
      textColor: 'dark'
    })
  }, "Dark"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
    isPrimary: textColor == 'light',
    isSecondary: textColor != 'light',
    onClick: e => setAttributes({
      textColor: 'light'
    })
  }, "Light")))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: 'Style',
    initialOpen: false
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
    label: "Line Style",
    value: lineStyle,
    onChange: value => setAttributes({
      lineStyle: value
    }),
    options: [{
      label: 'None',
      value: ''
    }, {
      label: 'Both Sides',
      value: 'both-sides'
    }, {
      label: 'Left',
      value: 'left'
    }, {
      label: 'Middle Bottom',
      value: 'middle-bottom'
    }, {
      label: 'Middle',
      value: 'middle'
    }]
  }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.useBlockProps)(customProps), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "section-bg"
  }, backgroundImageUrl && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: 'bg-image',
    style: {
      backgroundImage: 'url(' + backgroundImageUrl + ')',
      opacity: backgroundImageOpacity / 100,
      backgroundPosition: `${backgroundImageFocalPoint.x * 100}% ${backgroundImageFocalPoint.y * 100}%`,
      filter: `grayscale(${backgroundImageGrayscale / 100})`,
      mixBlendMode: backgroundImageBlendMode,
      backgroundSize: backgroundImageContain ? 'contain' : 'cover'
    }
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "inner"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "container"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "inner",
    style: restrictContentWidth ? {
      maxWidth: contentsMaxWidth + 'px'
    } : {}
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(InnerBlocks, {
    template: TEMPLATE
  })))))];
} // let styles = [
// 	{ name: 'hero', label: 'Hero' }
// ];
// wp.blocks.registerBlockStyle('crown-blocks/page-section', styles);

/***/ }),

/***/ "./blocks/page-section/src/index.js":
/*!******************************************!*\
  !*** ./blocks/page-section/src/index.js ***!
  \******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./style.scss */ "./blocks/page-section/src/style.scss");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./edit */ "./blocks/page-section/src/edit.js");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./save */ "./blocks/page-section/src/save.js");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../block.json */ "./blocks/page-section/block.json");
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
 * Import block settings from JSON config file
 */


/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */

(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)(_block_json__WEBPACK_IMPORTED_MODULE_4__.name, {
  attributes: {
    title: {
      type: 'string'
    },
    title_tag: {
      type: 'string',
      default: 'h2'
    },
    textAlign: {
      type: 'string',
      default: 'left'
    },
    contentAlign: {
      type: 'string',
      default: 'center'
    },
    responsiveDeviceMode: {
      type: 'string',
      default: 'xl'
    },
    restrictContentWidth: {
      type: 'boolean',
      default: true
    },
    contentsMaxWidth: {
      type: 'number',
      default: 1260
    },
    slantedBg: {
      type: 'boolean',
      default: false
    },
    slantedBgTop: {
      type: 'boolean',
      default: false
    },
    slantedBgTopReverse: {
      type: 'boolean',
      default: false
    },
    slantedBgBottom: {
      type: 'boolean',
      default: false
    },
    slantedBgBottomReverse: {
      type: 'boolean',
      default: false
    },
    fullWidth: {
      type: 'boolean',
      default: true
    },
    overrideVerticalSpacingXl: {
      type: 'boolean',
      default: false
    },
    paddingTopXl: {
      type: 'number',
      default: 2
    },
    paddingBottomXl: {
      type: 'number',
      default: 2
    },
    overflowTopXl: {
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
    paddingXXl: {
      type: 'number',
      default: 2
    },
    overflowXXl: {
      type: 'number',
      default: 0
    },
    overrideVerticalSpacingLg: {
      type: 'boolean',
      default: false
    },
    paddingTopLg: {
      type: 'number',
      default: 2
    },
    paddingBottomLg: {
      type: 'number',
      default: 2
    },
    overflowTopLg: {
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
    paddingXLg: {
      type: 'number',
      default: 2
    },
    overflowXLg: {
      type: 'number',
      default: 0
    },
    overrideVerticalSpacingMd: {
      type: 'boolean',
      default: false
    },
    paddingTopMd: {
      type: 'number',
      default: 2
    },
    paddingBottomMd: {
      type: 'number',
      default: 2
    },
    overflowTopMd: {
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
    paddingXMd: {
      type: 'number',
      default: 2
    },
    overflowXMd: {
      type: 'number',
      default: 0
    },
    overrideVerticalSpacingSm: {
      type: 'boolean',
      default: false
    },
    paddingTopSm: {
      type: 'number',
      default: 2
    },
    paddingBottomSm: {
      type: 'number',
      default: 2
    },
    overflowTopSm: {
      type: 'number',
      default: 0
    },
    overflowBottomSm: {
      type: 'number',
      default: 0
    },
    overrideHorizontalSpacingSm: {
      type: 'boolean',
      default: false
    },
    paddingXSm: {
      type: 'number',
      default: 2
    },
    overflowXSm: {
      type: 'number',
      default: 0
    },
    overrideVerticalSpacingXs: {
      type: 'boolean',
      default: false
    },
    paddingTopXs: {
      type: 'number',
      default: 2
    },
    paddingBottomXs: {
      type: 'number',
      default: 2
    },
    overflowTopXs: {
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
    paddingXXs: {
      type: 'number',
      default: 2
    },
    overflowXXs: {
      type: 'number',
      default: 0
    },
    backgroundColor: {
      type: 'string',
      default: ''
    },
    backgroundImageId: {
      type: 'number'
    },
    backgroundImageData: {
      type: 'object'
    },
    backgroundImageFocalPoint: {
      type: 'object',
      default: {
        x: 0.5,
        y: 0.5
      }
    },
    backgroundImageOpacity: {
      type: 'number',
      default: 100
    },
    backgroundImageGrayscale: {
      type: 'number',
      default: 0
    },
    backgroundImageBlendMode: {
      type: 'string',
      default: 'normal'
    },
    backgroundImageContain: {
      type: 'boolean',
      default: false
    },
    textColor: {
      type: 'string',
      default: 'auto'
    },
    lineStyle: {
      type: 'string',
      default: ''
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

/***/ "./blocks/page-section/src/save.js":
/*!*****************************************!*\
  !*** ./blocks/page-section/src/save.js ***!
  \*****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ save; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _common_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../common.js */ "./common.js");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__);


/**
 * Import Crown helper functions
 */

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
  InnerBlocks,
  RichText
} = wp.blockEditor;
const {
  getColorObjectByColorValue
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
    textAlign,
    contentAlign,
    restrictContentWidth,
    contentsMaxWidth,
    slantedBg,
    slantedBgTop,
    slantedBgTopReverse,
    slantedBgBottom,
    slantedBgBottomReverse,
    fullWidth,
    overrideVerticalSpacingXl,
    paddingTopXl,
    paddingBottomXl,
    overflowTopXl,
    overflowBottomXl,
    overrideHorizontalSpacingXl,
    paddingXXl,
    overflowXXl,
    overrideVerticalSpacingLg,
    paddingTopLg,
    paddingBottomLg,
    overflowTopLg,
    overflowBottomLg,
    overrideHorizontalSpacingLg,
    paddingXLg,
    overflowXLg,
    overrideVerticalSpacingMd,
    paddingTopMd,
    paddingBottomMd,
    overflowTopMd,
    overflowBottomMd,
    overrideHorizontalSpacingMd,
    paddingXMd,
    overflowXMd,
    overrideVerticalSpacingSm,
    paddingTopSm,
    paddingBottomSm,
    overflowTopSm,
    overflowBottomSm,
    overrideHorizontalSpacingSm,
    paddingXSm,
    overflowXSm,
    overrideVerticalSpacingXs,
    paddingTopXs,
    paddingBottomXs,
    overflowTopXs,
    overflowBottomXs,
    overrideHorizontalSpacingXs,
    paddingXXs,
    overflowXXs,
    backgroundColor,
    backgroundImageId,
    backgroundImageData,
    backgroundImageFocalPoint,
    backgroundImageOpacity,
    backgroundImageGrayscale,
    backgroundImageBlendMode,
    backgroundImageContain,
    textColor,
    lineStyle
  } = attributes;
  let blockClasses = [className];

  if (fullWidth) {
    blockClasses.push('full-width');
  }

  if (restrictContentWidth) {
    blockClasses.push('restricted-content-width');
  }

  if (contentAlign) {
    blockClasses.push('content-align-' + contentAlign);
  }

  if (textAlign) {
    blockClasses.push('text-align-' + textAlign);
  }

  if (lineStyle) {
    blockClasses.push('line');
    blockClasses.push('line-' + lineStyle);
  }

  if (textColor == 'auto' && backgroundColor) {
    blockClasses.push('text-color-' + (_common_js__WEBPACK_IMPORTED_MODULE_1__["default"].isDarkColor(backgroundColor) ? 'light' : 'dark'));
  } else if (textColor != 'auto') {
    blockClasses.push('text-color-' + textColor);
  }

  let blockStyle = {};

  if (backgroundColor) {
    blockStyle.backgroundColor = backgroundColor;
    let settings = wp.data.select('core/editor').getEditorSettings(); // if(settings.colors) {
    // 	let colorObject = getColorObjectByColorValue(settings.colors, backgroundColor);
    // 	if(colorObject) blockClasses.push('bg-color-' + colorObject.slug);
    // }
  }

  if (slantedBg) {
    if (slantedBgTop) {
      blockClasses.push('slanted-bg-top');

      if (slantedBgTopReverse) {
        blockClasses.push('slanted-bg-top-reverse');
      }
    }

    if (slantedBgBottom) {
      blockClasses.push('slanted-bg-bottom');

      if (slantedBgBottomReverse) {
        blockClasses.push('slanted-bg-bottom-reverse');
      }
    }
  }

  if (overrideVerticalSpacingXl) {
    blockClasses.push('contents-pt-xl-' + paddingTopXl);
    blockClasses.push('contents-pb-xl-' + paddingBottomXl);
    if (overflowTopXl > 0) blockClasses.push('contents-ot-xl-' + overflowTopXl);
    if (overflowBottomXl > 0) blockClasses.push('contents-ob-xl-' + overflowBottomXl);
  }

  if (overrideHorizontalSpacingXl) {
    blockClasses.push('contents-px-xl-' + paddingXXl);
    if (overflowXXl > 0) blockClasses.push('contents-ox-xl-' + overflowXXl);
  }

  if (overrideVerticalSpacingLg) {
    blockClasses.push('contents-pt-lg-' + paddingTopLg);
    blockClasses.push('contents-pb-lg-' + paddingBottomLg);
    if (overflowTopLg > 0) blockClasses.push('contents-ot-lg-' + overflowTopLg);
    if (overflowBottomLg > 0) blockClasses.push('contents-ob-lg-' + overflowBottomLg);
  }

  if (overrideHorizontalSpacingLg) {
    blockClasses.push('contents-px-lg-' + paddingXLg);
    if (overflowXLg > 0) blockClasses.push('contents-ox-lg-' + overflowXLg);
  }

  if (overrideVerticalSpacingMd) {
    blockClasses.push('contents-pt-md-' + paddingTopMd);
    blockClasses.push('contents-pb-md-' + paddingBottomMd);
    if (overflowTopMd > 0) blockClasses.push('contents-ot-md-' + overflowTopMd);
    if (overflowBottomMd > 0) blockClasses.push('contents-ob-md-' + overflowBottomMd);
  }

  if (overrideHorizontalSpacingMd) {
    blockClasses.push('contents-px-md-' + paddingXMd);
    if (overflowXMd > 0) blockClasses.push('contents-ox-md-' + overflowXMd);
  }

  if (overrideVerticalSpacingSm) {
    blockClasses.push('contents-pt-sm-' + paddingTopSm);
    blockClasses.push('contents-pb-sm-' + paddingBottomSm);
    if (overflowTopSm > 0) blockClasses.push('contents-ot-sm-' + overflowTopSm);
    if (overflowBottomSm > 0) blockClasses.push('contents-ob-sm-' + overflowBottomSm);
  }

  if (overrideHorizontalSpacingSm) {
    blockClasses.push('contents-px-sm-' + paddingXSm);
    if (overflowXSm > 0) blockClasses.push('contents-ox-sm-' + overflowXSm);
  }

  if (overrideVerticalSpacingXs) {
    blockClasses.push('contents-pt-' + paddingTopXs);
    blockClasses.push('contents-pb-' + paddingBottomXs);
    if (overflowTopXs > 0) blockClasses.push('contents-ot-' + overflowTopXs);
    if (overflowBottomXs > 0) blockClasses.push('contents-ob-' + overflowBottomXs);
  }

  if (overrideHorizontalSpacingXs) {
    blockClasses.push('contents-ps-' + paddingXXs);
    if (overflowXXs > 0) blockClasses.push('contents-ox-' + overflowXXs);
  }

  let backgroundImageUrl = null;

  if (backgroundImageId) {
    backgroundImageUrl = backgroundImageData.sizes.fullscreen ? backgroundImageData.sizes.fullscreen.url : backgroundImageData.url;
    blockClasses.push('has-bg-image');
  } // This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag


  let customProps = {
    className: blockClasses.join(' '),
    style: blockStyle,
    key: 'page-section'
  };
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.useBlockProps.save(customProps), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "section-bg"
  }, backgroundImageUrl && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: 'bg-image',
    style: {
      backgroundImage: 'url(' + backgroundImageUrl + ')',
      opacity: backgroundImageOpacity / 100,
      backgroundPosition: `${backgroundImageFocalPoint.x * 100}% ${backgroundImageFocalPoint.y * 100}%`,
      filter: `grayscale(${backgroundImageGrayscale / 100})`,
      mixBlendMode: backgroundImageBlendMode,
      backgroundSize: backgroundImageContain ? 'contain' : 'cover'
    }
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "inner"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "container"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "inner",
    style: restrictContentWidth ? {
      maxWidth: contentsMaxWidth + 'px'
    } : {}
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(InnerBlocks.Content, null)))));
}

/***/ }),

/***/ "./common.js":
/*!*******************!*\
  !*** ./common.js ***!
  \*******************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
const CrownBlocks = {
  getColorLuminosity: (hex = '') => {
    hex = hex.replace(/[^0-9a-f]/i, '');
    if (hex == '' || hex.length < 3) hex = 'fff';
    if (hex.length < 6) hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
    let c = [];

    for (var i = 0; i < 3; i++) c.push(parseInt(hex.substring(i * 2, i * 2 + 2), 16) / 255);

    for (var i = 0; i < 3; i++) {
      if (c[i] <= 0.03928) {
        c[i] = c[i] / 12.92;
      } else {
        c[i] = Math.pow((c[i] + 0.055) / 1.055, 2.4);
      }
    }

    let luminosity = 0.2126 * c[0] + 0.7152 * c[1] + 0.0722 * c[2];
    return luminosity;
  },
  isDarkColor: (hex, threshold = 0.607843137) => {
    let luminosity = CrownBlocks.getColorLuminosity(hex);
    return luminosity <= threshold;
  },
  hexToRgb: hex => {
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
      timer = setTimeout(() => {
        func.apply(undefined, args);
      }, timeout);
    };
  }
};
/* harmony default export */ __webpack_exports__["default"] = (CrownBlocks);

/***/ }),

/***/ "./blocks/page-section/src/editor.scss":
/*!*********************************************!*\
  !*** ./blocks/page-section/src/editor.scss ***!
  \*********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./blocks/page-section/src/style.scss":
/*!********************************************!*\
  !*** ./blocks/page-section/src/style.scss ***!
  \********************************************/
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

/***/ "./blocks/page-section/block.json":
/*!****************************************!*\
  !*** ./blocks/page-section/block.json ***!
  \****************************************/
/***/ (function(module) {

module.exports = JSON.parse('{"apiVersion":2,"name":"crown-blocks/page-section","version":"0.1.0","title":"Page Section","category":"layout","icon":"cover-image","description":"Page Section block","supports":{"html":false},"textdomain":"crown-blocks","editorScript":"file:./build/index.js","script":"file:./build/public.js","editorStyle":"file:./build/index.css","style":"file:./build/style-index.css"}');

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
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["style-index"], function() { return __webpack_require__("./blocks/page-section/src/index.js"); })
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map