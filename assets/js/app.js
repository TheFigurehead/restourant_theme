/******/ (function(modules) { // webpackBootstrap
    /******/ 	// The module cache
    /******/ 	var installedModules = {};
    /******/
    /******/ 	// The require function
    /******/ 	function __webpack_require__(moduleId) {
        /******/
        /******/ 		// Check if module is in cache
        /******/ 		if(installedModules[moduleId]) {
            /******/ 			return installedModules[moduleId].exports;
            /******/ 		}
        /******/ 		// Create a new module (and put it into the cache)
        /******/ 		var module = installedModules[moduleId] = {
            /******/ 			i: moduleId,
            /******/ 			l: false,
            /******/ 			exports: {}
            /******/ 		};
        /******/
        /******/ 		// Execute the module function
        /******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
        /******/
        /******/ 		// Flag the module as loaded
        /******/ 		module.l = true;
        /******/
        /******/ 		// Return the exports of the module
        /******/ 		return module.exports;
        /******/ 	}
    /******/
    /******/
    /******/ 	// expose the modules object (__webpack_modules__)
    /******/ 	__webpack_require__.m = modules;
    /******/
    /******/ 	// expose the module cache
    /******/ 	__webpack_require__.c = installedModules;
    /******/
    /******/ 	// define getter function for harmony exports
    /******/ 	__webpack_require__.d = function(exports, name, getter) {
        /******/ 		if(!__webpack_require__.o(exports, name)) {
            /******/ 			Object.defineProperty(exports, name, {
                /******/ 				configurable: false,
                /******/ 				enumerable: true,
                /******/ 				get: getter
                /******/ 			});
            /******/ 		}
        /******/ 	};
    /******/
    /******/ 	// getDefaultExport function for compatibility with non-harmony modules
    /******/ 	__webpack_require__.n = function(module) {
        /******/ 		var getter = module && module.__esModule ?
            /******/ 			function getDefault() { return module['default']; } :
            /******/ 			function getModuleExports() { return module; };
        /******/ 		__webpack_require__.d(getter, 'a', getter);
        /******/ 		return getter;
        /******/ 	};
    /******/
    /******/ 	// Object.prototype.hasOwnProperty.call
    /******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
    /******/
    /******/ 	// __webpack_public_path__
    /******/ 	__webpack_require__.p = "/";
    /******/
    /******/ 	// Load entry module and return exports
    /******/ 	return __webpack_require__(__webpack_require__.s = 0);
    /******/ })
/************************************************************************/
/******/ ([
    /* 0 */
    /***/ (function(module, exports, __webpack_require__) {

        "use strict";


        __webpack_require__(1);

        var _header = __webpack_require__(2);

        var _header2 = _interopRequireDefault(_header);

        function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

        document.addEventListener('DOMContentLoaded', function () {
            (0, _header2.default)();
        });

        /***/ }),
    /* 1 */
    /***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

        /***/ }),
    /* 2 */
    /***/ (function(module, exports, __webpack_require__) {

        "use strict";


        Object.defineProperty(exports, "__esModule", {
            value: true
        });

        var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

        exports.default = initDropdown;

        function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

        function initDropdown() {
            var menuListItem = document.querySelectorAll('.site-header-nav-list-item');

            for (var i = 0; i < menuListItem.length; i++) {
                new HeaderMenuListItem(menuListItem[i]);
            }

            new Dropdown(document.querySelector('.lang-dropdown'));
        }

        var DROPDOWN_TRANSITION_DURATION = 300;

        var HeaderMenuListItem = function () {
            function HeaderMenuListItem(item) {
                _classCallCheck(this, HeaderMenuListItem);

                this.item = item;
                this.parentDropdown = item.querySelector('.site-header-nav-list-item-dropdown');

                if (this.parentDropdown) {
                    this.dropdownPositioningClass = 'left';

                    this.initParentDropdown();

                    HeaderMenuListItem.recursiveSearchAndInitDropdowns(this.parentDropdown);
                }
            }

            _createClass(HeaderMenuListItem, [{
                key: 'initParentDropdown',
                value: function initParentDropdown() {
                    var size = this.item.getBoundingClientRect();
                    var position = size.left + size.width / 2;

                    if (position > window.innerWidth / 2) {
                        this.dropdownPositioningClass = 'right';
                    }

                    this.parentDropdown.classList.add(this.dropdownPositioningClass);

                    new Dropdown(this.parentDropdown);
                }
            }], [{
                key: 'recursiveSearchAndInitDropdowns',
                value: function recursiveSearchAndInitDropdowns(dropdown) {
                    var listItems = dropdown.children[0].children;

                    for (var i = 0; i < listItems.length; i++) {
                        var childDropdown = listItems[i].querySelector('.site-header-nav-list-item-dropdown');

                        if (childDropdown) {
                            new Dropdown(childDropdown);

                            this.recursiveSearchAndInitDropdowns(childDropdown);
                        }
                    }
                }
            }]);

            return HeaderMenuListItem;
        }();

        var Dropdown = function () {
            function Dropdown(dropdown, triggerItem) {
                _classCallCheck(this, Dropdown);

                this.dropdown = dropdown;
                this.triggerItem = triggerItem || dropdown.parentNode;

                this.height = 0;
                this.dropdownTimeout = null;

                this.sizeCalc();

                this.mouseEnter = this.mouseEnter.bind(this);
                this.mouseLeave = this.mouseLeave.bind(this);

                this.triggerItem.addEventListener('mouseenter', this.mouseEnter);
                this.triggerItem.addEventListener('mouseleave', this.mouseLeave);
            }

            _createClass(Dropdown, [{
                key: 'mouseEnter',
                value: function mouseEnter() {
                    var dropdown = this.dropdown;


                    clearTimeout(this.dropdownTimeout);

                    dropdown.style.height = this.height + 'px';
                    dropdown.style.overflow = 'hidden';

                    this.dropdownTimeout = setTimeout(function () {
                        dropdown.style.overflow = 'visible';
                    }, DROPDOWN_TRANSITION_DURATION);
                }
            }, {
                key: 'mouseLeave',
                value: function mouseLeave() {
                    var dropdown = this.dropdown;


                    clearTimeout(this.dropdownTimeout);

                    dropdown.style.height = 0 + 'px';
                    dropdown.style.overflow = 'hidden';
                }
            }, {
                key: 'sizeCalc',
                value: function sizeCalc() {
                    var dropdown = this.dropdown;


                    this.height = dropdown.querySelector('ul').offsetHeight;
                }
            }]);

            return Dropdown;
        }();

        /***/ })
    /******/ ]);
