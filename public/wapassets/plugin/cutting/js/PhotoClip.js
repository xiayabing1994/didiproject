/*!
 * PhotoClip - 涓€娆炬墜鍔块┍鍔ㄧ殑瑁佸浘鎻掍欢
 * @version v3.3.3
 * @author baijunjie
 * @license MIT
 * 
 * git - https://github.com/baijunjie/PhotoClip.git
 */
(function webpackUniversalModuleDefinition(root, factory) {
  if(typeof exports === 'object' && typeof module === 'object')
    module.exports = factory(require("lrz"), require("hammerjs"), require("iscroll/build/iscroll-zoom"));
  else if(typeof define === 'function' && define.amd)
    define(["lrz", "hammerjs", "iscroll"], factory);
  else if(typeof exports === 'object')
    exports["PhotoClip"] = factory(require("lrz"), require("hammerjs"), require("iscroll/build/iscroll-zoom"));
  else
    root["PhotoClip"] = factory(root["lrz"], root["Hammer"], root["IScroll"]);
})(this, function(__WEBPACK_EXTERNAL_MODULE_1__, __WEBPACK_EXTERNAL_MODULE_2__, __WEBPACK_EXTERNAL_MODULE_3__) {
return /******/ (function(modules) { // webpackBootstrap
/******/  // The module cache
/******/  var installedModules = {};
/******/
/******/  // The require function
/******/  function __webpack_require__(moduleId) {
/******/
/******/    // Check if module is in cache
/******/    if(installedModules[moduleId]) {
/******/      return installedModules[moduleId].exports;
/******/    }
/******/    // Create a new module (and put it into the cache)
/******/    var module = installedModules[moduleId] = {
/******/      i: moduleId,
/******/      l: false,
/******/      exports: {}
/******/    };
/******/
/******/    // Execute the module function
/******/    modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/    // Flag the module as loaded
/******/    module.l = true;
/******/
/******/    // Return the exports of the module
/******/    return module.exports;
/******/  }
/******/
/******/
/******/  // expose the modules object (__webpack_modules__)
/******/  __webpack_require__.m = modules;
/******/
/******/  // expose the module cache
/******/  __webpack_require__.c = installedModules;
/******/
/******/  // identity function for calling harmony imports with the correct context
/******/  __webpack_require__.i = function(value) { return value; };
/******/
/******/  // define getter function for harmony exports
/******/  __webpack_require__.d = function(exports, name, getter) {
/******/    if(!__webpack_require__.o(exports, name)) {
/******/      Object.defineProperty(exports, name, {
/******/        configurable: false,
/******/        enumerable: true,
/******/        get: getter
/******/      });
/******/    }
/******/  };
/******/
/******/  // getDefaultExport function for compatibility with non-harmony modules
/******/  __webpack_require__.n = function(module) {
/******/    var getter = module && module.__esModule ?
/******/      function getDefault() { return module['default']; } :
/******/      function getModuleExports() { return module; };
/******/    __webpack_require__.d(getter, 'a', getter);
/******/    return getter;
/******/  };
/******/
/******/  // Object.prototype.hasOwnProperty.call
/******/  __webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/  // __webpack_public_path__
/******/  __webpack_require__.p = "";
/******/
/******/  // Load entry module and return exports
/******/  return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;(function (global, factory) {
    if (true) {
        !(__WEBPACK_AMD_DEFINE_ARRAY__ = [exports], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
        __WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
        (__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
        __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
    } else if (typeof exports !== "undefined") {
        factory(exports);
    } else {
        var mod = {
            exports: {}
        };
        factory(mod.exports);
        global.utils = mod.exports;
    }
})(this, function (exports) {
    'use strict';

    Object.defineProperty(exports, "__esModule", {
        value: true
    });
    exports.getScale = getScale;
    exports.pointRotate = pointRotate;
    exports.angleToRadian = angleToRadian;
    exports.loaclToLoacl = loaclToLoacl;
    exports.globalToLoacl = globalToLoacl;
    exports.extend = extend;
    exports.proxy = proxy;
    exports.hideAction = hideAction;
    exports.isPercent = isPercent;
    exports.isNumber = isNumber;
    exports.isArray = isArray;
    exports.toArray = toArray;
    exports.createElement = createElement;
    exports.removeElement = removeElement;
    exports.$ = $;
    exports.attr = attr;
    exports.css = css;
    exports.support = support;

    var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) {
        return typeof obj;
    } : function (obj) {
        return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
    };

    // 鑾峰彇鏈€澶х缉鏀炬瘮渚�
    function getScale(w1, h1, w2, h2) {
        var sx = w1 / w2;
        var sy = h1 / h2;
        return sx > sy ? sx : sy;
    }

    // 璁＄畻涓€涓偣缁曞師鐐规棆杞悗鐨勬柊鍧愭爣
    function pointRotate(point, angle) {
        var radian = angleToRadian(angle),
            sin = Math.sin(radian),
            cos = Math.cos(radian);
        return {
            x: cos * point.x - sin * point.y,
            y: cos * point.y + sin * point.x
        };
    }

    // 瑙掑害杞姬搴�
    function angleToRadian(angle) {
        return angle / 180 * Math.PI;
    }

    // 璁＄畻layerTwo涓婄殑x銆亂鍧愭爣鍦╨ayerOne涓婄殑鍧愭爣
    function loaclToLoacl(layerOne, layerTwo, x, y) {
        x = x || 0;
        y = y || 0;
        var layerOneRect = void 0,
            layerTwoRect = void 0;
        hideAction([layerOne, layerTwo], function () {
            layerOneRect = layerOne.getBoundingClientRect();
            layerTwoRect = layerTwo.getBoundingClientRect();
        });
        return {
            x: layerTwoRect.left - layerOneRect.left + x,
            y: layerTwoRect.top - layerOneRect.top + y
        };
    }

    // 璁＄畻鐩稿浜庣獥鍙ｇ殑x銆亂鍧愭爣鍦╨ayer涓婄殑鍧愭爣
    function globalToLoacl(layer, x, y) {
        x = x || 0;
        y = y || 0;
        var layerRect = void 0;
        hideAction(layer, function () {
            layerRect = layer.getBoundingClientRect();
        });
        return {
            x: x - layerRect.left,
            y: y - layerRect.top
        };
    }

    function extend() {
        var options = void 0,
            name = void 0,
            src = void 0,
            copy = void 0,
            copyIsArray = void 0,
            target = arguments[0] || {},
            targetType = typeof target === 'undefined' ? 'undefined' : _typeof(target),
            toString = Object.prototype.toString,
            i = 1,
            length = arguments.length,
            deep = false;

        // 澶勭悊娣辨嫹璐�
        if (targetType === 'boolean') {
            deep = target;

            // Skip the boolean and the target
            target = arguments[i] || {};
            targetType = typeof target === 'undefined' ? 'undefined' : _typeof(target);
            i++;
        }

        // Handle case when target is a string or something (possible in deep copy)
        if (targetType !== 'object' && targetType !== 'function') {
            target = {};
        }

        // 濡傛灉娌℃湁鍚堝苟鐨勫璞★紝鍒欒〃绀� target 涓哄悎骞跺璞★紝灏� target 鍚堝苟缁欏綋鍓嶅嚱鏁扮殑鎸佹湁鑰�
        if (i === length) {
            target = this;
            i--;
        }

        for (; i < length; i++) {

            // Only deal with non-null/undefined values
            if ((options = arguments[i]) != null) {

                // Extend the base object
                for (name in options) {
                    src = target[name];
                    copy = options[name];

                    // 闃叉姝诲惊鐜�
                    if (target === copy) {
                        continue;
                    }

                    // 娣辨嫹璐濆璞℃垨鑰呮暟缁�
                    if (deep && copy && ((copyIsArray = toString.call(copy) === '[object Array]') || toString.call(copy) === '[object Object]')) {

                        if (copyIsArray) {
                            copyIsArray = false;
                            src = src && toString.call(src) === '[object Array]' ? src : [];
                        } else {
                            src = src && toString.call(src) === '[object Object]' ? src : {};
                        }

                        target[name] = extend(deep, src, copy);
                    } else if (copy !== undefined) {
                        // 浠呭拷鐣ユ湭瀹氫箟鐨勫€�
                        target[name] = copy;
                    }
                }
            }
        }

        // Return the modified object
        return target;
    }

    // 浠ｇ悊
    var guid = 0;
    function proxy(func, target) {
        if (typeof target === 'string') {
            var tmp = func[target];
            target = func;
            func = tmp;
        }

        if (typeof func !== 'function') {
            return undefined;
        }

        var slice = Array.prototype.slice,
            args = slice.call(arguments, 2),
            proxy = function proxy() {
            return func.apply(target || this, args.concat(slice.call(arguments)));
        };

        proxy.guid = func.guid = func.guid || guid++;

        return proxy;
    }

    /**
     * 璁╅殣钘忓厓绱犳纭墽琛岀▼搴忥紙IE9鍙婁互涓婃祻瑙堝櫒锛�
     * @param  {DOM|Array} elems  DOM鍏冪礌鎴栬€匘OM鍏冪礌缁勬垚鐨勬暟缁�
     * @param  {Function}  func   闇€瑕佹墽琛岀殑绋嬪簭鍑芥暟
     * @param  {Object}    target 鎵ц绋嬪簭鏃跺嚱鏁颁腑 this 鐨勬寚鍚�
     */
    var defaultDisplayMap = {};
    function hideAction(elems, func, target) {
        if ((typeof elems === 'undefined' ? 'undefined' : _typeof(elems)) !== 'object') {
            elems = [];
        }

        if (typeof elems.length === 'undefined') {
            elems = [elems];
        }

        var hideElems = [],
            hideElemsDisplay = [];

        for (var i = 0, elem; elem = elems[i++];) {

            while (elem instanceof HTMLElement) {

                var nodeName = elem.nodeName;

                if (!elem.getClientRects().length) {
                    hideElems.push(elem);
                    hideElemsDisplay.push(elem.style.display);

                    var display = defaultDisplayMap[nodeName];
                    if (!display) {
                        var temp = document.createElement(nodeName);
                        document.body.appendChild(temp);
                        display = window.getComputedStyle(temp).display;
                        temp.parentNode.removeChild(temp);

                        if (display === 'none') display = 'block';
                        defaultDisplayMap[nodeName] = display;
                    }

                    elem.style.display = display;
                }

                if (nodeName === 'BODY') break;
                elem = elem.parentNode;
            }
        }

        if (typeof func === 'function') func.call(target || this);

        var l = hideElems.length;
        while (l--) {
            hideElems.pop().style.display = hideElemsDisplay.pop();
        }
    }

    // 鍒ゆ柇鏄惁涓虹櫨鍒嗘瘮
    function isPercent(value) {
        return (/%$/.test(value + '')
        );
    }

    // 鍒ゆ柇瀵硅薄鏄惁涓烘暟瀛�
    function isNumber(obj) {
        return typeof obj === 'number';
    }

    // 鍒ゆ柇瀵硅薄鏄惁涓烘暟缁�
    function isArray(obj) {
        return Object.prototype.toString.call(obj) === '[object Array]';
    }

    // 绫讳技鏁扮粍瀵硅薄杞暟缁�
    function toArray(obj) {
        return Array.prototype.map.call(obj, function (n) {
            return n;
        });
    }

    // 鍒涘缓鍏冪礌
    function createElement(parentNode, className, id, prop) {
        var elem = document.createElement('DIV');

        if ((typeof className === 'undefined' ? 'undefined' : _typeof(className)) === 'object') {
            prop = className;
            className = null;
        }

        if ((typeof id === 'undefined' ? 'undefined' : _typeof(id)) === 'object') {
            prop = id;
            id = null;
        }

        if ((typeof prop === 'undefined' ? 'undefined' : _typeof(prop)) === 'object') {
            for (var p in prop) {
                elem.style[p] = prop[p];
            }
        }

        if (className) elem.className = className;
        if (id) elem.id = id;

        parentNode.appendChild(elem);

        return elem;
    }

    // 绉婚櫎鍏冪礌
    function removeElement(elem) {
        elem.parentNode && elem.parentNode.removeChild(elem);
    }

    // 鑾峰彇鍏冪礌锛圛E8鍙婁互涓婃祻瑙堝櫒锛�
    function $(selector, context) {
        if (selector instanceof HTMLElement) {
            return [selector];
        } else if ((typeof selector === 'undefined' ? 'undefined' : _typeof(selector)) === 'object' && selector.length) {
            return toArray(selector);
        } else if (!selector || typeof selector !== 'string') {
            return [];
        }

        if (typeof context === 'string') {
            context = document.querySelector(context);
        }

        if (!(context instanceof HTMLElement)) {
            context = document;
        }

        return toArray(context.querySelectorAll(selector));
    }

    // 璁剧疆灞炴€�
    function attr(elem, prop, value) {
        if ((typeof prop === 'undefined' ? 'undefined' : _typeof(prop)) === 'object') {
            for (var p in prop) {
                elem[p] = prop[p];
            }
            return elem;
        }

        if (value === undefined) {
            return elem[prop];
        } else {
            elem[prop] = value;
            return elem;
        }
    }

    // 璁剧疆鏍峰紡
    function css(elem, prop, value) {
        if ((typeof prop === 'undefined' ? 'undefined' : _typeof(prop)) === 'object') {
            for (var p in prop) {
                value = prop[p];
                if (isNumber(value)) value += 'px';
                elem.style[p] = value;
            }
            return elem;
        }

        if (value === undefined) {
            return window.getComputedStyle(elem)[prop];
        } else {
            if (isNumber(value)) value += 'px';
            elem.style[prop] = value;
            return elem;
        }
    }

    function support(prop) {
        var testElem = document.documentElement;
        if (prop in testElem.style) return '';

        var testProp = prop.charAt(0).toUpperCase() + prop.substr(1),
            prefixs = ['Webkit', 'Moz', 'ms', 'O'];

        for (var i = 0, prefix; prefix = prefixs[i++];) {
            if (prefix + testProp in testElem.style) {
                return '-' + prefix.toLowerCase() + '-';
            }
        }
    }
});

/***/ }),
/* 1 */
/***/ (function(module, exports) {

module.exports = __WEBPACK_EXTERNAL_MODULE_1__;

/***/ }),
/* 2 */
/***/ (function(module, exports) {

module.exports = __WEBPACK_EXTERNAL_MODULE_2__;

/***/ }),
/* 3 */
/***/ (function(module, exports) {

module.exports = __WEBPACK_EXTERNAL_MODULE_3__;

/***/ }),
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;(function (global, factory) {
    if (true) {
        !(__WEBPACK_AMD_DEFINE_ARRAY__ = [module, exports, __webpack_require__(2), __webpack_require__(3), __webpack_require__(1), __webpack_require__(0)], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
        __WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
        (__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
        __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
    } else if (typeof exports !== "undefined") {
        factory(module, exports, require('hammerjs'), require('iscroll/build/iscroll-zoom'), require('lrz'), require('./utils'));
    } else {
        var mod = {
            exports: {}
        };
        factory(mod, mod.exports, global.hammerjs, global.iscrollZoom, global.lrz, global.utils);
        global.index = mod.exports;
    }
})(this, function (module, exports, _hammerjs, _iscrollZoom, _lrz, _utils) {
    'use strict';

    Object.defineProperty(exports, "__esModule", {
        value: true
    });

    var _hammerjs2 = _interopRequireDefault(_hammerjs);

    var _iscrollZoom2 = _interopRequireDefault(_iscrollZoom);

    var _lrz2 = _interopRequireDefault(_lrz);

    var utils = _interopRequireWildcard(_utils);

    function _interopRequireWildcard(obj) {
        if (obj && obj.__esModule) {
            return obj;
        } else {
            var newObj = {};

            if (obj != null) {
                for (var key in obj) {
                    if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key];
                }
            }

            newObj.default = obj;
            return newObj;
        }
    }

    function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {
            default: obj
        };
    }

    var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) {
        return typeof obj;
    } : function (obj) {
        return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
    };

    function _classCallCheck(instance, Constructor) {
        if (!(instance instanceof Constructor)) {
            throw new TypeError("Cannot call a class as a function");
        }
    }

    var _createClass = function () {
        function defineProperties(target, props) {
            for (var i = 0; i < props.length; i++) {
                var descriptor = props[i];
                descriptor.enumerable = descriptor.enumerable || false;
                descriptor.configurable = true;
                if ("value" in descriptor) descriptor.writable = true;
                Object.defineProperty(target, descriptor.key, descriptor);
            }
        }

        return function (Constructor, protoProps, staticProps) {
            if (protoProps) defineProperties(Constructor.prototype, protoProps);
            if (staticProps) defineProperties(Constructor, staticProps);
            return Constructor;
        };
    }();

    var is_mobile = !!navigator.userAgent.match(/mobile/i),
        is_android = !!navigator.userAgent.match(/android/i),


    // 娴嬭瘯娴忚鍣ㄦ槸鍚︽敮鎸� Transition 鍔ㄧ敾锛屼互鍙婃敮鎸佺殑鍓嶇紑
    supportTransition = utils.support('transition'),
        prefix = utils.support('transform'),
        noop = function noop() {};

    var defaultOptions = {
        size: [100, 100],
        adaptive: '',
        outputSize: [0, 0],
        outputType: 'jpg',
        outputQuality: .8,
        maxZoom: 1,
        rotateFree: !is_android,
        view: '',
        file: '',
        ok: '',
        img: '',
        loadStart: noop,
        loadComplete: noop,
        loadError: noop,
        done: noop,
        fail: noop,
        lrzOption: {
            width: is_android ? 1000 : undefined,
            height: is_android ? 1000 : undefined,
            quality: .7
        },
        style: {
            maskColor: 'rgba(0,0,0,.5)',
            maskBorder: '2px dashed #ddd',
            jpgFillColor: '#fff'
        },
        errorMsg: {
            noSupport: '鎮ㄧ殑娴忚鍣ㄧ増鏈繃浜庨檲鏃э紝鏃犳硶鏀寔瑁佸浘鍔熻兘锛岃鏇存崲鏂扮殑娴忚鍣紒',
            imgError: '涓嶆敮鎸佽鍥剧墖鏍煎紡锛岃閫夋嫨甯歌鏍煎紡鐨勫浘鐗囨枃浠讹紒',
            imgHandleError: '鍥剧墖澶勭悊澶辫触锛佽鏇存崲鍏跺畠鍥剧墖灏濊瘯銆�',
            imgLoadError: '鍥剧墖璇诲彇澶辫触锛佽鏇存崲鍏跺畠鍥剧墖灏濊瘯銆�',
            noImg: '娌℃湁鍙鍓殑鍥剧墖锛�',
            clipError: '鎴浘澶辫触锛佸綋鍓嶅浘鐗囨簮鏂囦欢鍙兘瀛樺湪璺ㄥ煙闂锛岃纭繚鍥剧墖涓庡簲鐢ㄥ悓婧愩€傚鏋滄偍鏄湪鏈湴鐜涓嬫墽琛屾湰绋嬪簭锛岃鏇存崲鑷虫湇鍔″櫒鐜銆�'
        }
    };

    var _class = function () {
        function _class(container, options) {
            _classCallCheck(this, _class);

            container = utils.$(container); // 鑾峰彇瀹瑰櫒
            if (container && container.length) {
                this._$container = container[0];
            } else {
                return;
            }

            this._options = utils.extend(true, {}, defaultOptions, options);

            if (prefix === undefined) {
                this._options.errorMsg.noSupport && alert(this._options.errorMsg.noSupport);
            }

            this._init();
        }

        _createClass(_class, [{
            key: '_init',
            value: function _init() {
                var self = this,
                    options = this._options;

                // options 棰勮
                if (utils.isNumber(options.size)) {
                    options.size = [options.size, options.size];
                } else if (utils.isArray(options.size)) {
                    if (!utils.isNumber(options.size[0]) || options.size[0] <= 0) options.size[0] = defaultOptions.size[0];
                    if (!utils.isNumber(options.size[1]) || options.size[1] <= 0) options.size[1] = defaultOptions.size[1];
                } else {
                    options.size = utils.extend({}, defaultOptions.size);
                }

                if (utils.isNumber(options.outputSize)) {
                    options.outputSize = [options.outputSize, 0];
                } else if (utils.isArray(options.outputSize)) {
                    if (!utils.isNumber(options.outputSize[0]) || options.outputSize[0] < 0) options.outputSize[0] = defaultOptions.outputSize[0];
                    if (!utils.isNumber(options.outputSize[1]) || options.outputSize[1] < 0) options.outputSize[1] = defaultOptions.outputSize[1];
                } else {
                    options.outputSize = utils.extend({}, defaultOptions.outputSize);
                }

                if (options.outputType === 'jpg') {
                    options.outputType = 'image/jpeg';
                } else {
                    // 濡傛灉涓嶆槸 jpg锛屽垯鍏ㄩ儴鎸� png 鏉ュ寰�
                    options.outputType = 'image/png';
                }

                // 鍙橀噺鍒濆鍖�
                if (utils.isArray(options.adaptive)) {
                    this._widthIsPercent = options.adaptive[0] && utils.isPercent(options.adaptive[0]) ? options.adaptive[0] : false;
                    this._heightIsPercent = options.adaptive[1] && utils.isPercent(options.adaptive[1]) ? options.adaptive[1] : false;
                }

                this._outputWidth = options.outputSize[0];
                this._outputHeight = options.outputSize[1];

                this._canvas = document.createElement('canvas'); // 鍥剧墖瑁佸壀鐢ㄥ埌鐨勭敾甯�
                this._iScroll = null; // 鍥剧墖鐨剆croll瀵硅薄锛屽寘鍚浘鐗囩殑浣嶇疆涓庣缉鏀句俊鎭�
                this._hammerManager = null; // hammer 绠＄悊瀵硅薄

                this._clipWidth = 0;
                this._clipHeight = 0;
                this._clipSizeRatio = 1; // 鎴彇妗嗗楂樻瘮

                this._$img = null; // 鍥剧墖鐨凞OM瀵硅薄
                this._imgLoading = false; // 姝ｅ湪璇诲彇鍥剧墖
                this._imgLoaded = false; // 鍥剧墖鏄惁宸茬粡鍔犺浇瀹屾垚

                this._containerWidth = 0;
                this._containerHeight = 0;

                this._$clipLayer = null; // 瑁佸壀灞傦紝鍖呭惈绉诲姩灞�
                this._$moveLayer = null; // 绉诲姩灞傦紝鍖呭惈鏃嬭浆灞�
                this._$rotationLayer = null; // 鏃嬭浆灞�

                this._viewList = null; // 鏈€缁堟埅鍥惧悗鍛堢幇鐨勮鍥惧鍣ㄧ殑DOM鏁扮粍
                this._fileList = null; // file 鎺т欢鐨凞OM鏁扮粍
                this._okList = null; // 鎴浘鎸夐挳鐨凞OM鏁扮粍

                this._$mask = null;
                this._$mask_left = null;
                this._$mask_right = null;
                this._$mask_right = null;
                this._$mask_bottom = null;
                this._$clip_frame = null;

                this._atRotation = false; // 鏃嬭浆灞傛槸鍚︽鍦ㄦ棆杞腑
                this._rotationLayerWidth = 0; // 鏃嬭浆灞傜殑瀹藉害
                this._rotationLayerHeight = 0; // 鏃嬭浆灞傜殑楂樺害
                this._rotationLayerX = 0; // 鏃嬭浆灞傜殑褰撳墠X鍧愭爣
                this._rotationLayerY = 0; // 鏃嬭浆灞傜殑褰撳墠Y鍧愭爣
                this._rotationLayerOriginX = 0; // 鏃嬭浆灞傜殑鏃嬭浆鍙傝€冪偣X
                this._rotationLayerOriginY = 0; // 鏃嬭浆灞傜殑鏃嬭浆鍙傝€冪偣Y
                this._curAngle = 0; // 鏃嬭浆灞傜殑褰撳墠瑙掑害

                this._initProxy();

                this._initElements();
                this._initScroll();
                this._initRotationEvent();
                this._initFile();

                this._resize();
                window.addEventListener('resize', this._resize);

                if (this._okList = utils.$(options.ok)) {
                    this._okList.forEach(function ($ok) {
                        $ok.addEventListener('click', self._clipImg);
                    });
                }

                if (this._options.img) {
                    this._lrzHandle(this._options.img);
                }
            }
        }, {
            key: '_initElements',
            value: function _initElements() {
                // 鍒濆鍖栧鍣�
                var $container = this._$container,
                    style = $container.style,
                    containerOriginStyle = {};

                containerOriginStyle['user-select'] = style['user-select'];
                containerOriginStyle['overflow'] = style['overflow'];
                containerOriginStyle['position'] = style['position'];
                this._containerOriginStyle = containerOriginStyle;

                utils.css($container, {
                    'user-select': 'none',
                    'overflow': 'hidden'
                });

                if (utils.css($container, 'position') === 'static') {
                    utils.css($container, 'position', 'relative');
                }

                // 鍒涘缓瑁佸壀灞�
                this._$clipLayer = utils.createElement($container, 'photo-clip-layer', {
                    'position': 'absolute',
                    'left': '50%',
                    'top': '50%'
                });

                this._$moveLayer = utils.createElement(this._$clipLayer, 'photo-clip-move-layer');
                this._$rotationLayer = utils.createElement(this._$moveLayer, 'photo-clip-rotation-layer');

                // 鍒涘缓閬僵
                var $mask = this._$mask = utils.createElement($container, 'photo-clip-mask', {
                    'position': 'absolute',
                    'left': 0,
                    'top': 0,
                    'width': '100%',
                    'height': '100%',
                    'pointer-events': 'none'
                });

                var options = this._options,
                    maskColor = options.style.maskColor,
                    maskBorder = options.style.maskBorder;

                this._$mask_left = utils.createElement($mask, 'photo-clip-mask-left', {
                    'position': 'absolute',
                    'left': 0,
                    'right': '50%',
                    'top': '50%',
                    'bottom': '50%',
                    'width': 'auto',
                    'background-color': maskColor
                });
                this._$mask_right = utils.createElement($mask, 'photo-clip-mask-right', {
                    'position': 'absolute',
                    'left': '50%',
                    'right': 0,
                    'top': '50%',
                    'bottom': '50%',
                    'background-color': maskColor
                });
                this._$mask_top = utils.createElement($mask, 'photo-clip-mask-top', {
                    'position': 'absolute',
                    'left': 0,
                    'right': 0,
                    'top': 0,
                    'bottom': '50%',
                    'background-color': maskColor
                });
                this._$mask_bottom = utils.createElement($mask, 'photo-clip-mask-bottom', {
                    'position': 'absolute',
                    'left': 0,
                    'right': 0,
                    'top': '50%',
                    'bottom': 0,
                    'background-color': maskColor
                });

                // 鍒涘缓鎴彇妗�
                this._$clip_frame = utils.createElement($mask, 'photo-clip-area', {
                    'border': maskBorder,
                    'position': 'absolute',
                    'left': '50%',
                    'top': '50%'
                });

                // 鍒濆鍖栬鍥惧鍣�
                this._viewList = utils.$(options.view);
                if (this._viewList) {
                    var viewOriginStyleList = [];
                    this._viewList.forEach(function ($view, i) {
                        var style = $view.style,
                            viewOriginStyle = {};
                        viewOriginStyle['background-repeat'] = style['background-repeat'];
                        viewOriginStyle['background-position'] = style['background-position'];
                        viewOriginStyle['background-size'] = style['background-size'];
                        viewOriginStyleList[i] = viewOriginStyle;

                        utils.css($view, {
                            'background-repeat': 'no-repeat',
                            'background-position': 'center',
                            'background-size': 'contain'
                        });
                    });
                    this._viewOriginStyleList = viewOriginStyleList;
                }
            }
        }, {
            key: '_initScroll',
            value: function _initScroll() {
                this._iScroll = new _iscrollZoom2.default(this._$clipLayer, {
                    zoom: true,
                    scrollX: true,
                    scrollY: true,
                    freeScroll: true,
                    mouseWheel: true,
                    disablePointer: true, // important to disable the pointer events that causes the issues
                    disableTouch: false, // false if you want the slider to be usable with touch devices
                    disableMouse: false, // false if you want the slider to be usable with a mouse (desktop)
                    wheelAction: 'zoom',
                    bounceTime: 300
                });
            }
        }, {
            key: '_refreshScroll',
            value: function _refreshScroll(duration) {
                duration = duration || 0;

                var iScrollOptions = this._iScroll.options,
                    maxZoom = this._options.maxZoom,
                    width = this._rotationLayerWidth,
                    height = this._rotationLayerHeight;

                if (width && height) {
                    iScrollOptions.zoomMin = utils.getScale(this._clipWidth, this._clipHeight, width, height);
                    iScrollOptions.zoomMax = Math.max(maxZoom, iScrollOptions.zoomMin);
                    iScrollOptions.startZoom = Math.min(iScrollOptions.zoomMax, utils.getScale(this._containerWidth, this._containerHeight, width, height));
                } else {
                    iScrollOptions.zoomMin = 1;
                    iScrollOptions.zoomMax = maxZoom;
                    iScrollOptions.startZoom = 1;
                }

                utils.css(this._$moveLayer, {
                    'width': width,
                    'height': height
                });

                // 鍦ㄧЩ鍔ㄨ澶囦笂锛屽挨鍏舵槸Android璁惧锛屽綋涓轰竴涓厓绱犻噸缃簡瀹介珮鏃�
                // 璇ュ厓绱犵殑 offsetWidth/offsetHeight銆乧lientWidth/clientHeight 绛夊睘鎬у苟涓嶄細绔嬪嵆鏇存柊锛屽鑷寸浉鍏崇殑js绋嬪簭鍑虹幇閿欒
                // iscroll 鍦ㄥ埛鏂版柟娉曚腑姝ｆ槸浣跨敤浜� offsetWidth/offsetHeight 鏉ヨ幏鍙杝croller鍏冪礌($moveLayer)鐨勫楂�
                // 鍥犳闇€瑕佹墜鍔ㄥ皢鍏冪礌閲嶆柊娣诲姞杩涙枃妗ｏ紝杩娇娴忚鍣ㄥ己鍒舵洿鏂板厓绱犵殑瀹介珮
                this._$clipLayer.appendChild(this._$moveLayer);

                this._iScroll.refresh(duration);
            }
        }, {
            key: '_resetScroll',
            value: function _resetScroll(width, height) {
                width = width || 0;
                height = height || 0;

                // 閲嶇疆鏃嬭浆灞�
                this._rotationLayerWidth = width;
                this._rotationLayerHeight = height;
                this._rotationLayerX = 0;
                this._rotationLayerY = 0;
                this._curAngle = 0;
                setTransform(this._$rotationLayer, this._rotationLayerX, this._rotationLayerY, this._curAngle);

                utils.css(this._$rotationLayer, {
                    'width': width,
                    'height': height
                });

                this._refreshScroll();

                var iScroll = this._iScroll,
                    scale = iScroll.scale,
                    posX = (this._clipWidth - width * scale) * .5,
                    posY = (this._clipHeight - height * scale) * .5;

                iScroll.scrollTo(posX, posY);
                iScroll.zoom(iScroll.options.startZoom, undefined, undefined, 0);
            }
        }, {
            key: '_initRotationEvent',
            value: function _initRotationEvent() {
                if (is_mobile) {
                    this._hammerManager = new _hammerjs2.default.Manager(this._$moveLayer);
                    this._hammerManager.add(new _hammerjs2.default.Rotate());

                    var startTouch,
                        startAngle,
                        curAngle,
                        self = this,
                        rotateFree = this._options.rotateFree,
                        bounceTime = this._iScroll.options.bounceTime;

                    this._hammerManager.on('rotatestart', function (e) {
                        if (self._atRotation) return;
                        startTouch = true;

                        if (rotateFree) {
                            startAngle = (e.rotation - self._curAngle) % 360;
                            self._rotationLayerRotateReady(e.center);
                        } else {
                            startAngle = e.rotation;
                        }
                    });

                    this._hammerManager.on('rotatemove', function (e) {
                        if (!startTouch) return;
                        curAngle = e.rotation - startAngle;
                        rotateFree && self._rotationLayerRotate(curAngle);
                    });

                    this._hammerManager.on('rotateend rotatecancel', function (e) {
                        if (!startTouch) return;
                        startTouch = false;

                        if (!rotateFree) {
                            curAngle %= 360;
                            if (curAngle > 180) curAngle -= 360;else if (curAngle < -180) curAngle += 360;

                            if (curAngle > 30) {
                                self._rotateBy(90, bounceTime, e.center);
                            } else if (curAngle < -30) {
                                self._rotateBy(-90, bounceTime, e.center);
                            }
                            return;
                        }

                        // 鎺ヨ繎鏁�90搴︽柟鍚戞椂锛岃繘琛屾牎姝�
                        var angle = curAngle % 360;
                        if (angle < 0) angle += 360;

                        if (angle < 10) {
                            curAngle += -angle;
                        } else if (angle > 80 && angle < 100) {
                            curAngle += 90 - angle;
                        } else if (angle > 170 && angle < 190) {
                            curAngle += 180 - angle;
                        } else if (angle > 260 && angle < 280) {
                            curAngle += 270 - angle;
                        } else if (angle > 350) {
                            curAngle += 360 - angle;
                        }

                        self._rotationLayerRotateFinish(curAngle, bounceTime);
                    });
                } else {
                    this._$moveLayer.addEventListener('dblclick', this._rotateCW90);
                }
            }
        }, {
            key: '_rotateCW90',
            value: function _rotateCW90(e) {
                this._rotateBy(90, this._iScroll.options.bounceTime, { x: e.clientX, y: e.clientY });
            }
        }, {
            key: '_rotateBy',
            value: function _rotateBy(angle, duration, center) {
                this._rotateTo(this._curAngle + angle, duration, center);
            }
        }, {
            key: '_rotateTo',
            value: function _rotateTo(angle, duration, center) {
                if (this._atRotation) return;

                this._rotationLayerRotateReady(center);

                // 鏃嬭浆灞傛棆杞粨鏉�
                this._rotationLayerRotateFinish(angle, duration);
            }
        }, {
            key: '_rotationLayerRotateReady',
            value: function _rotationLayerRotateReady(center) {
                var scale = this._iScroll.scale,
                    coord; // 鏃嬭浆鍙傝€冪偣鍦ㄧЩ鍔ㄥ眰涓殑鍧愭爣

                if (!center) {
                    coord = utils.loaclToLoacl(this._$rotationLayer, this._$clipLayer, this._clipWidth * .5, this._clipHeight * .5);
                } else {
                    coord = utils.globalToLoacl(this._$rotationLayer, center.x, center.y);
                }

                // 鐢变簬寰楀埌鐨勫潗鏍囨槸鍦ㄧ缉鏀惧悗鍧愭爣绯讳笂鐨勫潗鏍囷紝鍥犳闇€瑕侀櫎浠ョ缉鏀炬瘮渚�
                coord.x /= scale;
                coord.y /= scale;

                // 鏃嬭浆鍙傝€冪偣鐩稿浜庢棆杞眰闆朵綅锛堟棆杞眰鏃嬭浆鍓嶅乏涓婅锛夌殑鍧愭爣
                var coordBy0 = {
                    x: coord.x - this._rotationLayerX,
                    y: coord.y - this._rotationLayerY
                };

                // 姹傚嚭鏃嬭浆灞傛棆杞墠鐨勬棆杞弬鑰冪偣
                // 杩欎釜鍙傝€冪偣灏辨槸鏃嬭浆涓績鐐规槧灏勫湪鏃嬭浆灞傚浘鐗囦笂鐨勫潗鏍�
                // 杩欎釜浣嶇疆琛ㄧず鏃嬭浆灞傛棆杞墠锛岃鐐规墍瀵瑰簲鐨勫潗鏍�
                var origin = utils.pointRotate(coordBy0, -this._curAngle);
                this._rotationLayerOriginX = origin.x;
                this._rotationLayerOriginY = origin.y;

                // 璁剧疆鍙傝€冪偣锛岀畻鍑烘柊鍙傝€冪偣浣滅敤涓嬬殑鏃嬭浆灞備綅绉伙紝鐒跺悗杩涜琛ュ樊
                var rect = this._$rotationLayer.getBoundingClientRect();
                setOrigin(this._$rotationLayer, this._rotationLayerOriginX, this._rotationLayerOriginY);
                var newRect = this._$rotationLayer.getBoundingClientRect();
                this._rotationLayerX += (rect.left - newRect.left) / scale;
                this._rotationLayerY += (rect.top - newRect.top) / scale;
                setTransform(this._$rotationLayer, this._rotationLayerX, this._rotationLayerY, this._curAngle);
            }
        }, {
            key: '_rotationLayerRotate',
            value: function _rotationLayerRotate(angle) {
                setTransform(this._$rotationLayer, this._rotationLayerX, this._rotationLayerY, angle);
                this._curAngle = angle;
            }
        }, {
            key: '_rotationLayerRotateFinish',
            value: function _rotationLayerRotateFinish(angle, duration) {
                setTransform(this._$rotationLayer, this._rotationLayerX, this._rotationLayerY, angle);

                // 鑾峰彇鏃嬭浆鍚庣殑鐭╁舰
                var rect = this._$rotationLayer.getBoundingClientRect();

                // 褰撳弬鑰冪偣涓洪浂鏃讹紝鑾峰彇浣嶇Щ鍚庣殑鐭╁舰
                setOrigin(this._$rotationLayer, 0, 0);
                var rectByOrigin0 = this._$rotationLayer.getBoundingClientRect();

                // 鑾峰彇鏃嬭浆鍓嶏紙闆跺害锛夌殑鐭╁舰
                setTransform(this._$rotationLayer, this._rotationLayerX, this._rotationLayerY, 0);
                var rectByAngle0 = this._$rotationLayer.getBoundingClientRect(),


                // 鑾峰彇绉诲姩灞傜殑鐭╁舰
                moveLayerRect = this._$moveLayer.getBoundingClientRect(),


                // 姹傚嚭绉诲姩灞備笌鏃嬭浆灞備箣闂寸殑浣嶇疆鍋忕Щ
                // 鐢变簬鐩存帴搴旂敤鍦ㄧЩ鍔ㄥ眰锛屽洜姝や笉闇€瑕佹牴鎹缉鏀炬崲绠�
                // 娉ㄦ剰锛岃繖閲岀殑鍋忕Щ鏈夊彲鑳借繕鍖呭惈缂╂斁杩囬噺鏃跺鍑烘潵鐨勫亸绉�
                offset = {
                    x: rect.left - moveLayerRect.left,
                    y: rect.top - moveLayerRect.top
                },
                    iScroll = this._iScroll,
                    scale = iScroll.scale;

                // 鏇存柊鏃嬭浆灞傚綋鍓嶆墍鍛堢幇鐭╁舰鐨勫楂�
                this._rotationLayerWidth = rect.width / scale;
                this._rotationLayerHeight = rect.height / scale;
                // 褰撳弬鑰冪偣涓洪浂鏃讹紝鏃嬭浆灞傛棆杞悗锛屽湪褰㈡垚鐨勬柊鐭╁舰涓紝鏃嬭浆灞傞浂浣嶏紙鏃嬭浆灞傛棆杞墠宸︿笂瑙掞級鐨勬柊鍧愭爣
                this._rotationLayerX = (rectByAngle0.left - rectByOrigin0.left) / scale;
                this._rotationLayerY = (rectByAngle0.top - rectByOrigin0.top) / scale;

                iScroll.scrollTo(iScroll.x + offset.x, iScroll.y + offset.y);
                this._refreshScroll(iScroll.options.bounceTime);

                // 鐢变簬鍙屾寚鏃嬭浆鏃朵篃浼撮殢鐫€缂╂斁锛屽洜姝よ繖閲屼唬鐮佹墽琛屽畬鍚庯紝灏嗕細鎵ц iscroll 鐨� _zoomEnd
                // 鑰岃鏂规硶浼氬熀浜� touchstart 鏃惰褰曠殑浣嶇疆閲嶆柊璁＄畻 x銆亂锛岃繖灏嗗鑷存墜鎸囩寮€灞忓箷鍚庯紝绉诲姩灞傚張浼氬悜鍥炵Щ鍔ㄤ竴娈佃窛绂�
                // 鎵€浠ヨ繖閲屼篃瑕佸皢 startX銆乻tartY 杩欎袱涓€艰繘琛岃ˉ宸紝鑰岃繖涓樊鍊煎繀椤绘槸鏈€缁堢殑姝ｅ父姣斾緥瀵瑰簲鐨勫€�
                // 鐢变簬 offset 鍙兘杩樺寘鍚缉鏀捐繃閲忔椂澶氬嚭鏉ョ殑鍋忕Щ
                // 鍥犳锛岃繖閲屽垽鏂槸鍚︾缉鏀捐繃閲�
                var lastScale = Math.max(iScroll.options.zoomMin, Math.min(iScroll.options.zoomMax, scale));
                if (lastScale !== scale) {
                    // 褰撶缉鏀捐繃閲忔椂锛屽皢 offset 鎹㈢畻涓烘渶缁堢殑姝ｅ父姣斾緥瀵瑰簲鐨勫€�
                    offset.x = offset.x / scale * lastScale;
                    offset.y = offset.y / scale * lastScale;
                }
                iScroll.startX += offset.x;
                iScroll.startY += offset.y;

                if (angle !== this._curAngle && duration && utils.isNumber(duration) && supportTransition !== undefined) {
                    // 璁＄畻鏃嬭浆灞傚弬鑰冪偣锛岃涓洪浂浣嶅墠鍚庣殑鍋忕Щ閲�
                    offset = {
                        x: (rectByOrigin0.left - rect.left) / scale,
                        y: (rectByOrigin0.top - rect.top) / scale
                    };
                    // 灏嗘棆杞弬鑰冪偣璁惧洖鍓嶅€硷紝鍚屾椂璋冩暣鍋忕Щ閲忥紝淇濊瘉瑙嗗浘浣嶇疆涓嶅彉锛屽噯澶囧紑濮嬪姩鐢�
                    setOrigin(this._$rotationLayer, this._rotationLayerOriginX, this._rotationLayerOriginY);
                    setTransform(this._$rotationLayer, this._rotationLayerX + offset.x, this._rotationLayerY + offset.y, this._curAngle);

                    // 寮€濮嬫棆杞�
                    var self = this;
                    this._atRotation = true;
                    setTransition(this._$rotationLayer, this._rotationLayerX + offset.x, this._rotationLayerY + offset.y, angle, duration, function () {
                        self._atRotation = false;
                        self._rotateFinishUpdataElem(angle);
                    });
                } else {
                    this._rotateFinishUpdataElem(angle);
                }
            }
        }, {
            key: '_rotateFinishUpdataElem',
            value: function _rotateFinishUpdataElem(angle) {
                setOrigin(this._$rotationLayer, this._rotationLayerOriginX = 0, this._rotationLayerOriginY = 0);
                setTransform(this._$rotationLayer, this._rotationLayerX, this._rotationLayerY, this._curAngle = angle % 360);
            }
        }, {
            key: '_initFile',
            value: function _initFile() {
                var self = this,
                    options = this._options,
                    errorMsg = options.errorMsg;

                if (this._fileList = utils.$(options.file)) {
                    this._fileList.forEach(function ($file) {
                        // 绉诲姩绔鏋滆缃� 'accept'锛屼細浣跨浉鍐屾墦寮€缂撴參锛屽洜姝よ繖閲屽彧涓洪潪绉诲姩绔缃�
                        if (!is_mobile) {
                            utils.attr($file, 'accept', 'image/jpeg, image/x-png, image/gif');
                        }

                        $file.addEventListener('change', self._fileOnChangeHandle);
                    });
                }
            }
        }, {
            key: '_fileOnChangeHandle',
            value: function _fileOnChangeHandle(e) {
                var files = e.target.files;

                if (files.length) {
                    this._lrzHandle(files[0]);
                }
            }
        }, {
            key: '_lrzHandle',
            value: function _lrzHandle(src) {
                var self = this,
                    options = this._options,
                    errorMsg = options.errorMsg;

                if ((typeof src === 'undefined' ? 'undefined' : _typeof(src)) === 'object' && src.type && !/image\/\w+/.test(src.type)) {
                    options.loadError.call(this, errorMsg.imgError);
                    return false;
                }

                this._imgLoaded = false;
                this._imgLoading = true;
                options.loadStart.call(this, src);

                try {
                    (0, _lrz2.default)(src, options.lrzOption).then(function (rst) {
                        // 澶勭悊鎴愬姛浼氭墽琛�
                        self._clearImg();
                        self._createImg(rst.base64);
                    }).catch(function (err) {
                        // 澶勭悊澶辫触浼氭墽琛�
                        options.loadError.call(self, errorMsg.imgHandleError, err);
                        self._imgLoading = false;
                    });
                } catch (err) {
                    throw err;
                    options.loadError.call(self, errorMsg.imgHandleError, err);
                    self._imgLoading = false;
                }
            }
        }, {
            key: '_clearImg',
            value: function _clearImg() {
                if (!this._$img) return;

                // 鍒犻櫎鏃х殑鍥剧墖浠ラ噴鏀惧唴瀛橈紝闃叉IOS璁惧鐨� webview 宕╂簝
                this._$img.onload = null;
                this._$img.onerror = null;
                utils.removeElement(this._$img);
                this._$img = null;
            }
        }, {
            key: '_createImg',
            value: function _createImg(src) {
                var self = this,
                    options = this._options,
                    errorMsg = options.errorMsg;

                this._$img = new Image();

                utils.css(this._$img, {
                    'user-select': 'none',
                    'pointer-events': 'none'
                });

                this._$img.onload = function () {
                    self._imgLoaded = true;
                    self._imgLoading = false;
                    options.loadComplete.call(self, this);

                    self._$rotationLayer.appendChild(this);

                    utils.hideAction([this, self._$moveLayer], function () {
                        self._resetScroll(this.naturalWidth, this.naturalHeight);
                    }, this);
                };

                this._$img.onerror = function (e) {
                    options.loadError.call(self, errorMsg.imgLoadError, e);
                    self._imgLoading = false;
                };

                utils.attr(this._$img, 'src', src);
            }
        }, {
            key: '_clipImg',
            value: function _clipImg() {
                var options = this._options,
                    errorMsg = options.errorMsg;

                if (!this._imgLoaded) {
                    options.fail.call(this, errorMsg.noImg);
                    return;
                }

                var local = utils.loaclToLoacl(this._$rotationLayer, this._$clipLayer),
                    scale = this._iScroll.scale,
                    scaleX = 1,
                    scaleY = 1,
                    ctx = this._canvas.getContext('2d');

                if (this._outputWidth || this._outputHeight) {
                    this._canvas.width = this._outputWidth;
                    this._canvas.height = this._outputHeight;
                    scaleX = this._outputWidth / this._clipWidth * scale;
                    scaleY = this._outputHeight / this._clipHeight * scale;
                } else {
                    this._canvas.width = this._clipWidth / scale;
                    this._canvas.height = this._clipHeight / scale;
                }

                ctx.clearRect(0, 0, this._canvas.width, this._canvas.height);
                ctx.fillStyle = options.style.jpgFillColor;
                ctx.fillRect(0, 0, this._canvas.width, this._canvas.height);
                ctx.save();

                ctx.scale(scaleX, scaleY);
                ctx.translate(this._rotationLayerX - local.x / scale, this._rotationLayerY - local.y / scale);
                ctx.rotate(this._curAngle * Math.PI / 180);

                ctx.drawImage(this._$img, 0, 0);
                ctx.restore();

                try {
                    var dataURL = this._canvas.toDataURL(options.outputType, options.outputQuality);
                    if (this._viewList) {
                        this._viewList.forEach(function ($view, i) {
                            utils.css($view, 'background-image', 'url(' + dataURL + ')');
                        });
                    }
                    options.done.call(this, dataURL);
                    return dataURL;
                } catch (e) {
                    options.fail.call(this, errorMsg.clipError, e);
                }
            }
        }, {
            key: '_resize',
            value: function _resize(width, height) {
                utils.hideAction(this._$container, function () {
                    this._containerWidth = this._$container.offsetWidth;
                    this._containerHeight = this._$container.offsetHeight;
                }, this);

                var size = this._options.size,
                    oldClipWidth = this._clipWidth,
                    oldClipHeight = this._clipHeight;

                if (utils.isNumber(width)) size[0] = width;
                if (utils.isNumber(height)) size[1] = height;

                if (this._widthIsPercent || this._heightIsPercent) {
                    var ratio = size[0] / size[1];

                    if (this._widthIsPercent) {
                        this._clipWidth = this._containerWidth / 100 * parseFloat(this._widthIsPercent);
                        if (!this._heightIsPercent) {
                            this._clipHeight = this._clipWidth / ratio;
                        }
                    }

                    if (this._heightIsPercent) {
                        this._clipHeight = this._containerHeight / 100 * parseFloat(this._heightIsPercent);
                        if (!this._widthIsPercent) {
                            this._clipWidth = this._clipHeight * ratio;
                        }
                    }
                } else {
                    this._clipWidth = size[0];
                    this._clipHeight = size[1];
                }

                var clipWidth = this._clipWidth,
                    clipHeight = this._clipHeight;

                this._clipSizeRatio = clipWidth / clipHeight;

                if (this._outputWidth && !this._outputHeight) {
                    this._outputHeight = this._outputWidth / this._clipSizeRatio;
                }

                if (this._outputHeight && !this._outputWidth) {
                    this._outputWidth = this._outputHeight * this._clipSizeRatio;
                }

                utils.css(this._$clipLayer, {
                    'width': clipWidth,
                    'height': clipHeight,
                    'margin-left': -clipWidth / 2,
                    'margin-top': -clipHeight / 2
                });
                utils.css(this._$mask_left, {
                    'margin-right': clipWidth / 2,
                    'margin-top': -clipHeight / 2,
                    'margin-bottom': -clipHeight / 2
                });
                utils.css(this._$mask_right, {
                    'margin-left': clipWidth / 2,
                    'margin-top': -clipHeight / 2,
                    'margin-bottom': -clipHeight / 2
                });
                utils.css(this._$mask_top, {
                    'margin-bottom': clipHeight / 2
                });
                utils.css(this._$mask_bottom, {
                    'margin-top': clipHeight / 2
                });
                utils.css(this._$clip_frame, {
                    'width': clipWidth,
                    'height': clipHeight
                });
                utils.css(this._$clip_frame, prefix + 'transform', 'translate(-50%, -50%)');

                if (clipWidth !== oldClipWidth || clipHeight !== oldClipHeight) {
                    this._refreshScroll();

                    var iScroll = this._iScroll,
                        scale = iScroll.scale,
                        offsetX = (clipWidth - oldClipWidth) * .5 * scale,
                        offsetY = (clipHeight - oldClipHeight) * .5 * scale;
                    iScroll.scrollBy(offsetX, offsetY);

                    var lastScale = Math.max(iScroll.options.zoomMin, Math.min(iScroll.options.zoomMax, scale));
                    if (lastScale !== scale) {
                        iScroll.zoom(lastScale, undefined, undefined, 0);
                    }
                }
            }
        }, {
            key: '_initProxy',
            value: function _initProxy() {
                // 鐢熸垚鍥炶皟浠ｇ悊
                this._fileOnChangeHandle = utils.proxy(this, '_fileOnChangeHandle');
                this._rotateCW90 = utils.proxy(this, '_rotateCW90');
                this._resize = utils.proxy(this, '_resize');
                this._clipImg = utils.proxy(this, '_clipImg');

                // 纭繚瀵瑰鎺ュ彛鍑芥暟锛屾棤璁烘寔鏈夎€呮槸璋侊紝璋冪敤閮戒笉浼氬嚭閿�
                this.size = utils.proxy(this, 'size');
                this.load = utils.proxy(this, 'load');
                this.rotateBy = utils.proxy(this, 'rotateBy');
                this.rotateTo = utils.proxy(this, 'rotateTo');
                this.clip = utils.proxy(this, 'clip');
                this.destroy = utils.proxy(this, 'destroy');
            }
        }, {
            key: 'size',
            value: function size(width, height) {
                this._resize(width, height);
                return this;
            }
        }, {
            key: 'load',
            value: function load(src) {
                this._lrzHandle(src);
                return this;
            }
        }, {
            key: 'clear',
            value: function clear() {
                this._clearImg();
                this._resetScroll();
                if (this._fileList) {
                    this._fileList.forEach(function ($file) {
                        $file.value = '';
                    });
                }
                return this;
            }
        }, {
            key: 'rotate',
            value: function rotate(angle, duration) {
                if (angle === undefined) return this._curAngle;
                this._rotateTo(angle, duration);
                return this;
            }
        }, {
            key: 'scale',
            value: function scale(zoom, duration) {
                if (zoom === undefined) return this._iScroll.scale;
                this._iScroll.zoom(zoom, undefined, undefined, duration);
                return this;
            }
        }, {
            key: 'clip',
            value: function clip() {
                return this._clipImg();
            }
        }, {
            key: 'destroy',
            value: function destroy() {
                var self = this;

                window.removeEventListener('resize', this._resize);

                this._$container.removeChild(this._$clipLayer);
                this._$container.removeChild(this._$mask);

                utils.css(this._$container, this._containerOriginStyle);

                if (this._iScroll) {
                    this._iScroll.destroy();
                }

                if (this._hammerManager) {
                    this._hammerManager.off('rotatemove');
                    this._hammerManager.off('rotateend');
                    this._hammerManager.destroy();
                } else {
                    this._$moveLayer.removeEventListener('dblclick', this._rotateCW90);
                }

                if (this._$img) {
                    this._$img.onload = null;
                    this._$img.onerror = null;
                }

                if (this._viewList) {
                    this._viewList.forEach(function ($view, i) {
                        utils.css($view, self._viewOriginStyleList[i]);
                    });
                }

                if (this._fileList) {
                    this._fileList.forEach(function ($file) {
                        $file.removeEventListener('change', self._fileOnChangeHandle);
                    });
                }

                if (this._okList) {
                    this._okList.forEach(function ($ok) {
                        $ok.removeEventListener('click', self._clipImg);
                    });
                }

                // 娓呴櫎鎵€鏈夊睘鎬�
                for (var p in this) {
                    delete this[p];
                }

                this.__proto__ = Object.prototype;
            }
        }]);

        return _class;
    }();

    exports.default = _class;
    ;

    // 璁剧疆鍙樻崲娉ㄥ唽鐐�
    function setOrigin($obj, originX, originY) {
        originX = (originX || 0).toFixed(2);
        originY = (originY || 0).toFixed(2);
        utils.css($obj, prefix + 'transform-origin', originX + 'px ' + originY + 'px');
    }

    // 璁剧疆鍙樻崲鍧愭爣涓庢棆杞搴�
    function setTransform($obj, x, y, angle) {
        // translate(x, y) 涓潗鏍囩殑灏忔暟鐐逛綅鏁拌繃澶氫細寮曞彂 bug
        // 鍥犳杩欓噷闇€瑕佷繚鐣欎袱浣嶅皬鏁�
        x = x.toFixed(2);
        y = y.toFixed(2);
        angle = angle.toFixed(2);

        utils.css($obj, prefix + 'transform', 'translateZ(0) translate(' + x + 'px,' + y + 'px) rotate(' + angle + 'deg)');
    }

    // 璁剧疆鍙樻崲鍔ㄧ敾
    function setTransition($obj, x, y, angle, dur, fn) {
        // 杩欓噷闇€瑕佸厛璇诲彇涔嬪墠璁剧疆濂界殑transform鏍峰紡锛屽己鍒舵祻瑙堝櫒灏嗚鏍峰紡鍊兼覆鏌撳埌鍏冪礌
        // 鍚﹀垯娴忚鍣ㄥ彲鑳藉嚭浜庢€ц兘鑰冭檻锛屽皢鏆傜紦鏍峰紡娓叉煋锛岀瓑鍒颁箣鍚庢墍鏈夋牱寮忚缃畬鎴愬悗鍐嶇粺涓€娓叉煋
        // 杩欐牱灏变細瀵艰嚧涔嬪墠璁剧疆鐨勪綅绉讳篃琚簲鐢ㄥ埌鍔ㄧ敾涓�
        utils.css($obj, prefix + 'transform');
        // 杩欓噷搴旂敤鐨勭紦鍔ㄤ笌 iScroll 鐨勯粯璁ょ紦鍔ㄧ浉鍚�
        utils.css($obj, prefix + 'transition', prefix + 'transform ' + dur + 'ms cubic-bezier(0.1, 0.57, 0.1, 1)');
        setTransform($obj, x, y, angle);

        setTimeout(function () {
            utils.css($obj, prefix + 'transition', '');
            fn();
        }, dur);
    }
    module.exports = exports['default'];
});

/***/ })
/******/ ]);
});