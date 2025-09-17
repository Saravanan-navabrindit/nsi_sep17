/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./blocks/button/src/edit.js":
/*!***********************************!*\
  !*** ./blocks/button/src/edit.js ***!
  \***********************************/
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
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./editor.scss */ "./blocks/button/src/editor.scss");


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
  RichText,
  BlockControls,
  AlignmentToolbar,
  InspectorControls,
  PanelColorSettings,
  MediaUpload,
  URLInputButton
} = wp.blockEditor;
const {
  PanelBody,
  ToolbarGroup,
  ToggleControl,
  SelectControl,
  Button
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
  setAttributes,
  clientId
}) {
  const {
    blockId,
    label,
    linkUrl,
    linkPost,
    alignment,
    type,
    color,
    colorSlug,
    size,
    angle,
    borderRadius,
    displayAsBlock,
    disabledDisplayAsBlockBreakpoint,
    openNewWindow,
    linkArrow,
    backArrow,
    iconId,
    iconData,
    underline
  } = attributes;
  setAttributes({
    blockId: clientId
  });
  let blockClasses = [className];
  if (typeof alignment != 'undefined') blockClasses.push('text-alignment-' + alignment);
  let buttonClasses = ['btn'];
  let buttonCss = '';
  buttonClasses.push('btn--id--' + clientId);
  let buttonSelector = '.editor-styles-wrapper .btn--id--' + clientId;

  if (type == 'outline') {
    buttonClasses.push('btn--outline'); // buttonClasses.push('btn--outline-' + colorSlug);

    buttonCss += buttonSelector + '{ border-color: ' + color + '; }';
    buttonCss += buttonSelector + '{ color: ' + color + '; }';
  } else if (type == 'link') {
    buttonClasses.push('btn--link'); // buttonClasses.push('btn--link-' + colorSlug);

    buttonCss += buttonSelector + '{ color: ' + color + '; }';
  } else if (type == 'cta') {
    buttonClasses.push('btn--cta'); // buttonClasses.push('btn--cta-' + colorSlug);

    buttonClasses.push('btn--' + angle);
  } else {
    buttonClasses.push('btn--default'); // buttonClasses.push('btn--' + colorSlug);

    buttonCss += buttonSelector + '{ background-color: ' + color + '; }';
    buttonClasses.push('btn--text-color-' + (_common_js__WEBPACK_IMPORTED_MODULE_1__["default"].isDarkColor(color) ? 'light' : 'dark'));
  }

  buttonCss += buttonSelector + ' { border-radius: ' + borderRadius + '; }';
  buttonClasses.push('btn--' + size);

  if (displayAsBlock) {
    if (disabledDisplayAsBlockBreakpoint == 'none') {
      buttonClasses.push('btn--block');
    } else {
      buttonClasses.push('btn--block-to-' + disabledDisplayAsBlockBreakpoint);
    }
  }

  if (backArrow) {
    buttonClasses.push('back-arrow');
  }

  if (linkArrow) {
    buttonClasses.push('link-arrow');
  }

  let iconUrl = null;

  if (iconId) {
    iconUrl = iconData.sizes && iconData.sizes.thumbnail ? iconData.sizes.thumbnail.url : iconData.url;
    buttonClasses.push('btn--has-icon');
  }

  if (underline) {
    buttonClasses.push('btn--underline');
  } // This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag


  let customProps = {
    className: blockClasses.join(' '),
    // style: blockStyle,
    key: 'button'
  };
  return [(0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(InspectorControls, {
    key: "inspector-controls"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelColorSettings, {
    title: 'Color',
    initialOpen: true,
    colorSettings: [{
      label: 'Button Color',
      value: color,
      onChange: value => {
        let settings = wp.data.select('core/block-editor').getSettings();
        let colorSlug = '';

        if (settings.colors) {
          let colorObject = getColorObjectByColorValue(settings.colors, value);
          if (colorObject) colorSlug = colorObject.slug;
        }

        setAttributes({
          color: value,
          colorSlug: colorSlug
        });
      },
      disableCustomColors: false
    }]
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: 'Appearance',
    initialOpen: true
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
    label: "Button Type",
    value: type,
    onChange: value => setAttributes({
      type: value
    }),
    options: [{
      label: 'Default',
      value: 'default'
    }, {
      label: 'Outline',
      value: 'outline'
    }, {
      label: 'Link',
      value: 'link'
    } // { label: 'CTA', value: 'cta' }
    ]
  }), type != 'link' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
    label: "Size",
    value: size,
    onChange: value => setAttributes({
      size: value
    }),
    options: [{
      label: 'Small',
      value: 'sm'
    }, {
      label: 'Medium',
      value: 'md'
    }, {
      label: 'Large',
      value: 'lg'
    }]
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
    label: "Border Radius",
    value: borderRadius,
    onChange: value => setAttributes({
      borderRadius: value
    }),
    default: {
      label: 'None - 0px',
      value: '0px'
    },
    options: [{
      label: 'None - 0px',
      value: '0px'
    }, {
      label: 'Small - 7px',
      value: '7px'
    }, {
      label: 'Medium - 14px',
      value: '14px'
    }, {
      label: 'Large - 21px',
      value: '21px'
    }]
  }), type == 'cta' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
    label: "Button Angle",
    value: angle,
    onChange: value => setAttributes({
      angle: value
    }),
    options: [{
      label: 'Wide Top',
      value: 'wide-top'
    }, {
      label: 'Wide Bottom',
      value: 'wide-bottom'
    }]
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Display as block',
    checked: displayAsBlock,
    onChange: value => {
      setAttributes({
        displayAsBlock: value
      });
    }
  }), !!displayAsBlock && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
    label: "Disable block appearance at specified screensize:",
    value: disabledDisplayAsBlockBreakpoint,
    onChange: value => setAttributes({
      disabledDisplayAsBlockBreakpoint: value
    }),
    options: [{
      label: 'Never',
      value: 'none'
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
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Add Link Arrow',
    checked: linkArrow,
    onChange: value => {
      setAttributes({
        linkArrow: value
      });
    }
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Add Back Arrow',
    checked: backArrow,
    onChange: value => {
      setAttributes({
        backArrow: value
      });
    }
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Text Underline',
    checked: underline,
    onChange: value => {
      setAttributes({
        underline: value
      });
    }
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(MediaUpload, {
    onSelect: media => {
      setAttributes({
        iconId: media.id,
        iconData: media
      });
    },
    type: "image",
    value: iconId,
    label: "Button Icon",
    render: ({
      open
    }) => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: 'crown-blocks-media-upload'
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
      className: 'button',
      onClick: open
    }, "Select Button Icon"), iconId && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
      className: 'button is-link is-destructive',
      onClick: e => {
        setAttributes({
          iconId: null,
          iconData: null
        });
      }
    }, "Remove Icon"))
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: 'Link Settings',
    initialOpen: true
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: 'Open link in new window',
    checked: openNewWindow,
    onChange: value => {
      setAttributes({
        openNewWindow: value
      });
    }
  }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    class: "crown-block-editor-container"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(BlockControls, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToolbarGroup, {
    class: "components-toolbar-group crown-block-button-toolbar"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(URLInputButton, {
    url: linkUrl,
    onChange: (url, post) => setAttributes({
      linkUrl: url,
      linkPost: post
    })
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(AlignmentToolbar, {
    value: alignment,
    onChange: value => {
      setAttributes({
        alignment: value
      });
    }
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.useBlockProps)(customProps), !!buttonCss && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("style", {
    type: "text/css"
  }, buttonCss), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: buttonClasses.join(' ')
  }, backArrow && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "btn__back-arrow"
  }), iconUrl && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("img", {
    src: iconUrl,
    className: "btn__icon",
    "aria-hidden": "true"
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RichText, {
    tagName: "div",
    className: "btn-label",
    onChange: value => setAttributes({
      label: value
    }),
    value: label,
    allowedFormats: []
  }), linkArrow && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "btn__arrow"
  }))))];
}

/***/ }),

/***/ "./blocks/button/src/index.js":
/*!************************************!*\
  !*** ./blocks/button/src/index.js ***!
  \************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./style.scss */ "./blocks/button/src/style.scss");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./edit */ "./blocks/button/src/edit.js");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./save */ "./blocks/button/src/save.js");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../block.json */ "./blocks/button/block.json");


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

(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__.registerBlockType)(_block_json__WEBPACK_IMPORTED_MODULE_6__.name, {
  attributes: {
    blockId: {
      type: 'string',
      default: ''
    },
    label: {
      type: 'string',
      default: 'Learn More',
      selector: '.btn-label',
      source: 'html'
    },
    linkUrl: {
      type: 'string',
      default: ''
    },
    linkPost: {
      type: 'object'
    },
    alignment: {
      type: 'alignment',
      default: 'none'
    },
    type: {
      type: 'string',
      default: 'default'
    },
    color: {
      type: 'string',
      default: '#000000'
    },
    colorSlug: {
      type: 'string',
      default: 'pure-black'
    },
    size: {
      type: 'string',
      default: 'md'
    },
    borderRadius: {
      type: 'string',
      default: 'none'
    },
    angle: {
      type: 'string',
      default: 'wide-top'
    },
    displayAsBlock: {
      type: 'boolean',
      default: false
    },
    disabledDisplayAsBlockBreakpoint: {
      type: 'string',
      default: 'none'
    },
    openNewWindow: {
      type: 'boolean',
      default: false
    },
    linkArrow: {
      type: 'boolean',
      default: false
    },
    backArrow: {
      type: 'boolean',
      default: false
    },
    iconId: {
      type: 'number'
    },
    iconData: {
      type: 'object'
    },
    underline: {
      type: 'boolean',
      default: false
    }
  },

  /**
   * @see ./edit.js
   */
  edit: _edit__WEBPACK_IMPORTED_MODULE_4__["default"],

  /**
   * @see ./save.js
   */
  save: _save__WEBPACK_IMPORTED_MODULE_5__["default"],
  deprecated: [{
    attributes: {
      label: {
        type: 'string',
        default: 'Learn More',
        selector: '.btn-label',
        source: 'html'
      },
      linkUrl: {
        type: 'string',
        default: ''
      },
      linkPost: {
        type: 'object'
      },
      alignment: {
        type: 'alignment',
        default: 'none'
      },
      type: {
        type: 'string',
        default: 'default'
      },
      color: {
        type: 'string',
        default: '#000000'
      },
      colorSlug: {
        type: 'string',
        default: 'pure-black'
      },
      size: {
        type: 'string',
        default: 'md'
      },
      borderRadius: {
        type: 'string',
        default: 'none'
      },
      angle: {
        type: 'string',
        default: 'wide-top'
      },
      displayAsBlock: {
        type: 'boolean',
        default: false
      },
      disabledDisplayAsBlockBreakpoint: {
        type: 'string',
        default: 'none'
      },
      openNewWindow: {
        type: 'boolean',
        default: false
      },
      linkArrow: {
        type: 'boolean',
        default: false
      },
      backArrow: {
        type: 'boolean',
        default: false
      },
      iconId: {
        type: 'number'
      },
      iconData: {
        type: 'object'
      },
      underline: {
        type: 'boolean',
        default: false
      }
    },
    save: ({
      attributes,
      className
    }) => {
      const {
        label,
        linkUrl,
        linkPost,
        alignment,
        type,
        color,
        colorSlug,
        size,
        borderRadius,
        angle,
        displayAsBlock,
        disabledDisplayAsBlockBreakpoint,
        openNewWindow,
        linkArrow,
        backArrow,
        iconId,
        iconData,
        underline
      } = attributes;
      let blockClasses = [className];
      if (typeof alignment != 'undefined') blockClasses.push('text-alignment-' + alignment);
      let buttonClasses = ['btn'];

      if (type == 'outline') {
        buttonClasses.push('btn--outline');
        buttonClasses.push('btn--outline-' + colorSlug);
      } else if (type == 'link') {
        buttonClasses.push('btn--link');
        buttonClasses.push('btn--link-' + colorSlug);
      } else if (type == 'cta') {
        buttonClasses.push('btn--cta');
        buttonClasses.push('btn--cta-' + colorSlug);
        buttonClasses.push('btn--' + angle);
      } else {
        buttonClasses.push('btn--default');
        buttonClasses.push('btn--' + colorSlug);
      }

      buttonClasses.push('btn--' + size);

      if (displayAsBlock) {
        if (disabledDisplayAsBlockBreakpoint == 'none') {
          buttonClasses.push('btn--block');
        } else {
          buttonClasses.push('btn--block-to-' + disabledDisplayAsBlockBreakpoint);
        }
      }

      if (backArrow) {
        buttonClasses.push('back-arrow');
      }

      if (linkArrow) {
        buttonClasses.push('link-arrow');
      }

      let iconUrl = null;

      if (iconId) {
        iconUrl = iconData.sizes && iconData.sizes.thumbnail ? iconData.sizes.thumbnail.url : iconData.url;
        buttonClasses.push('btn--has-icon');
      }

      if (underline) {
        buttonClasses.push('btn--underline');
      } // This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag


      let customProps = {
        className: blockClasses.join(' '),
        // style: blockStyle,
        key: 'button'
      };
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.useBlockProps.save(customProps), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("a", {
        href: linkUrl,
        className: buttonClasses.join(' '),
        target: openNewWindow && '_blank',
        rel: openNewWindow && 'noopener noreferrer'
      }, backArrow && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
        className: "btn__back-arrow"
      }), iconUrl && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("img", {
        src: iconUrl,
        className: "btn__icon",
        "aria-hidden": "true"
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
        className: "btn-label"
      }, label), linkArrow && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
        className: "btn__arrow"
      })));
    }
  }]
});

/***/ }),

/***/ "./blocks/button/src/save.js":
/*!***********************************!*\
  !*** ./blocks/button/src/save.js ***!
  \***********************************/
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
    blockId,
    label,
    linkUrl,
    linkPost,
    alignment,
    type,
    color,
    colorSlug,
    size,
    borderRadius,
    angle,
    displayAsBlock,
    disabledDisplayAsBlockBreakpoint,
    openNewWindow,
    linkArrow,
    backArrow,
    iconId,
    iconData,
    underline
  } = attributes;
  let blockClasses = [className];
  if (typeof alignment != 'undefined') blockClasses.push('text-alignment-' + alignment);
  let buttonClasses = ['btn'];
  let buttonCss = '';
  if (blockId) buttonClasses.push('btn--id--' + blockId);
  let buttonSelector = '#main-content .wp-block-crown-blocks-button .btn--id--' + blockId;

  if (type == 'outline') {
    buttonClasses.push('btn--outline'); // buttonClasses.push('btn--outline-' + colorSlug);

    buttonCss += buttonSelector + ' { border-color: ' + color + '; color: ' + color + '; }';
    buttonCss += buttonSelector + ':hover { color: ' + color + '; }';
  } else if (type == 'link') {
    buttonClasses.push('btn--link'); // buttonClasses.push('btn--link-' + colorSlug);

    buttonCss += buttonSelector + '{ color: ' + color + '; }';
  } else if (type == 'cta') {
    buttonClasses.push('btn--cta'); // buttonClasses.push('btn--cta-' + colorSlug);

    buttonClasses.push('btn--' + angle);
  } else {
    buttonClasses.push('btn--default'); // buttonClasses.push('btn--' + colorSlug);

    buttonCss += buttonSelector + ' { background-color: ' + color + '; }';
    if (blockId) buttonClasses.push('btn--text-color-' + (_common_js__WEBPACK_IMPORTED_MODULE_1__["default"].isDarkColor(color) ? 'light' : 'dark'));
  }

  buttonCss += buttonSelector + ' { border-radius: ' + borderRadius + '; }';
  buttonClasses.push('btn--' + size);

  if (displayAsBlock) {
    if (disabledDisplayAsBlockBreakpoint == 'none') {
      buttonClasses.push('btn--block');
    } else {
      buttonClasses.push('btn--block-to-' + disabledDisplayAsBlockBreakpoint);
    }
  }

  if (backArrow) {
    buttonClasses.push('back-arrow');
  }

  if (linkArrow) {
    buttonClasses.push('link-arrow');
  }

  let iconUrl = null;

  if (iconId) {
    iconUrl = iconData.sizes && iconData.sizes.thumbnail ? iconData.sizes.thumbnail.url : iconData.url;
    buttonClasses.push('btn--has-icon');
  }

  if (underline) {
    buttonClasses.push('btn--underline');
  } // This object gets passed in to the 'useBlockProps' function to add our custom properties to the block tag


  let customProps = {
    className: blockClasses.join(' '),
    // style: blockStyle,
    key: 'button'
  };
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.useBlockProps.save(customProps), !!(blockId && buttonCss) && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("style", {
    type: "text/css"
  }, buttonCss), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("a", {
    href: linkUrl,
    className: buttonClasses.join(' '),
    target: openNewWindow && '_blank',
    rel: openNewWindow && 'noopener noreferrer'
  }, backArrow && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "btn__back-arrow"
  }), iconUrl && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("img", {
    src: iconUrl,
    className: "btn__icon",
    "aria-hidden": "true"
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "btn-label"
  }, label), linkArrow && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "btn__arrow"
  })));
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

/***/ "./blocks/button/src/editor.scss":
/*!***************************************!*\
  !*** ./blocks/button/src/editor.scss ***!
  \***************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./blocks/button/src/style.scss":
/*!**************************************!*\
  !*** ./blocks/button/src/style.scss ***!
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

/***/ "./blocks/button/block.json":
/*!**********************************!*\
  !*** ./blocks/button/block.json ***!
  \**********************************/
/***/ (function(module) {

module.exports = JSON.parse('{"apiVersion":2,"name":"crown-blocks/button","version":"0.1.0","title":"Button","category":"widgets","icon":"button","description":"Button block","supports":{"html":false},"textdomain":"crown-blocks","editorScript":"file:./build/index.js","script":"file:./build/public.js","editorStyle":"file:./build/index.css","style":"file:./build/style-index.css"}');

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
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["style-index"], function() { return __webpack_require__("./blocks/button/src/index.js"); })
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map