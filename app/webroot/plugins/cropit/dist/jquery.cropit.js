/*! cropit - v0.4.0 <https://github.com/scottcheng/cropit> */
(function webpackUniversalModuleDefinition(root, factory) {
    if (typeof exports === 'object' && typeof module === 'object')
        module.exports = factory(require("jquery"));
    else if (typeof define === 'function' && define.amd)
        define(["jquery"], factory);
    else if (typeof exports === 'object')
        exports["cropit"] = factory(require("jquery"));
    else
        root["cropit"] = factory(root["jQuery"]);
})(this, function (__WEBPACK_EXTERNAL_MODULE_1__) {
    return /******/ (function (modules) { // webpackBootstrap
        /******/ 	// The module cache
        /******/
        var installedModules = {};

        /******/ 	// The require function
        /******/
        function __webpack_require__(moduleId) {

            /******/ 		// Check if module is in cache
            /******/
            if (installedModules[moduleId])
            /******/            return installedModules[moduleId].exports;

            /******/ 		// Create a new module (and put it into the cache)
            /******/
            var module = installedModules[moduleId] = {
                /******/            exports: {},
                /******/            id: moduleId,
                /******/            loaded: false
                /******/
            };

            /******/ 		// Execute the module function
            /******/
            modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

            /******/ 		// Flag the module as loaded
            /******/
            module.loaded = true;

            /******/ 		// Return the exports of the module
            /******/
            return module.exports;
            /******/
        }


        /******/ 	// expose the modules object (__webpack_modules__)
        /******/
        __webpack_require__.m = modules;

        /******/ 	// expose the module cache
        /******/
        __webpack_require__.c = installedModules;

        /******/ 	// __webpack_public_path__
        /******/
        __webpack_require__.p = "";

        /******/ 	// Load entry module and return exports
        /******/
        return __webpack_require__(0);
        /******/
    })
        /************************************************************************/
        /******/([
        /* 0 */
        /***/ function (module, exports, __webpack_require__) {

            function _interopRequireDefault(obj) {
                return obj && obj.__esModule ? obj : {'default': obj};
            }

            var _jquery = __webpack_require__(1);

            var _jquery2 = _interopRequireDefault(_jquery);

            var _cropit = __webpack_require__(2);

            var _cropit2 = _interopRequireDefault(_cropit);

            var _constants = __webpack_require__(4);

            var _utils = __webpack_require__(6);

            var applyOnEach = function applyOnEach($el, callback) {
                return $el.each(function () {
                    var cropit = _jquery2['default'].data(this, _constants.PLUGIN_KEY);

                    if (!cropit) {
                        return;
                    }
                    callback(cropit);
                });
            };

            var callOnFirst = function callOnFirst($el, method, options) {
                var cropit = $el.first().data(_constants.PLUGIN_KEY);

                if (!cropit || !_jquery2['default'].isFunction(cropit[method])) {
                    return null;
                }
                return cropit[method](options);
            };

            var methods = {
                init: function init(options) {
                    return this.each(function () {
                        // Only instantiate once per element
                        if (_jquery2['default'].data(this, _constants.PLUGIN_KEY)) {
                            return;
                        }

                        var cropit = new _cropit2['default'](_jquery2['default'], this, options);
                        _jquery2['default'].data(this, _constants.PLUGIN_KEY, cropit);
                    });
                },

                destroy: function destroy() {
                    return this.each(function () {
                        _jquery2['default'].removeData(this, _constants.PLUGIN_KEY);
                    });
                },

                isZoomable: function isZoomable() {
                    return callOnFirst(this, 'isZoomable');
                },

                'export': function _export(options) {
                    return callOnFirst(this, 'getCroppedImageData', options);
                },

                imageState: function imageState() {
                    return callOnFirst(this, 'getImageState');
                },

                imageSrc: function imageSrc(newImageSrc) {
                    if ((0, _utils.exists)(newImageSrc)) {
                        return applyOnEach(this, function (cropit) {
                            cropit.loadImage(newImageSrc);
                        });
                    } else {
                        return callOnFirst(this, 'getImageSrc');
                    }
                },

                offset: function offset(newOffset) {
                    if (newOffset && (0, _utils.exists)(newOffset.x) && (0, _utils.exists)(newOffset.y)) {
                        return applyOnEach(this, function (cropit) {
                            cropit.setOffset(newOffset);
                        });
                    } else {
                        return callOnFirst(this, 'getOffset');
                    }
                },

                zoom: function zoom(newZoom) {
                    if ((0, _utils.exists)(newZoom)) {
                        return applyOnEach(this, function (cropit) {
                            cropit.setZoom(newZoom);
                        });
                    } else {
                        return callOnFirst(this, 'getZoom');
                    }
                },

                imageSize: function imageSize() {
                    return callOnFirst(this, 'getImageSize');
                },

                previewSize: function previewSize(newSize) {
                    if (newSize) {
                        return applyOnEach(this, function (cropit) {
                            cropit.setPreviewSize(newSize);
                        });
                    } else {
                        return callOnFirst(this, 'getPreviewSize');
                    }
                },

                disable: function disable() {
                    return applyOnEach(this, function (cropit) {
                        cropit.disable();
                    });
                },

                reenable: function reenable() {
                    return applyOnEach(this, function (cropit) {
                        cropit.reenable();
                    });
                }
            };

            _jquery2['default'].fn.cropit = function (method) {
                if (methods[method]) {
                    return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
                } else {
                    return methods.init.apply(this, arguments);
                }
            };

            /***/
        },
        /* 1 */
        /***/ function (module, exports) {

            module.exports = __WEBPACK_EXTERNAL_MODULE_1__;

            /***/
        },
        /* 2 */
        /***/ function (module, exports, __webpack_require__) {

            Object.defineProperty(exports, '__esModule', {
                value: true
            });

            var _createClass = (function () {
                function defineProperties(target, props) {
                    for (var i = 0; i < props.length; i++) {
                        var descriptor = props[i];
                        descriptor.enumerable = descriptor.enumerable || false;
                        descriptor.configurable = true;
                        if ('value' in descriptor) descriptor.writable = true;
                        Object.defineProperty(target, descriptor.key, descriptor);
                    }
                }

                return function (Constructor, protoProps, staticProps) {
                    if (protoProps) defineProperties(Constructor.prototype, protoProps);
                    if (staticProps) defineProperties(Constructor, staticProps);
                    return Constructor;
                };
            })();

            function _interopRequireDefault(obj) {
                return obj && obj.__esModule ? obj : {'default': obj};
            }

            function _classCallCheck(instance, Constructor) {
                if (!(instance instanceof Constructor)) {
                    throw new TypeError('Cannot call a class as a function');
                }
            }

            var _jquery = __webpack_require__(1);

            var _jquery2 = _interopRequireDefault(_jquery);

            var _Zoomer = __webpack_require__(3);

            var _Zoomer2 = _interopRequireDefault(_Zoomer);

            var _constants = __webpack_require__(4);

            var _options = __webpack_require__(5);

            var _utils = __webpack_require__(6);

            var Cropit = (function () {
                function Cropit(jQuery, element, options) {
                    _classCallCheck(this, Cropit);

                    this.$el = (0, _jquery2['default'])(element);

                    var defaults = (0, _options.loadDefaults)(this.$el);
                    this.options = _jquery2['default'].extend({}, defaults, options);

                    this.init();
                }

                _createClass(Cropit, [{
                    key: 'init',
                    value: function init() {
                        var _this = this;

                        this.image = new Image();
                        if (this.options.allowCrossOrigin) {
                            this.image.crossOrigin = 'Anonymous';
                        }
                        this.preImage = new Image();
                        this.image.onload = this.onImageLoaded.bind(this);
                        this.preImage.onload = this.onPreImageLoaded.bind(this);
                        this.image.onerror = this.preImage.onerror = function () {
                            _this.onImageError.call(_this, _constants.ERRORS.IMAGE_FAILED_TO_LOAD);
                        };

                        this.$fileInput = this.options.$fileInput.attr({accept: 'image/*'});
                        this.$preview = this.options.$preview.css({backgroundRepeat: 'no-repeat'});
                        this.$zoomSlider = this.options.$zoomSlider.attr({min: 0, max: 1, step: 0.01});

                        this.previewSize = {
                            w: this.options.width || this.$preview.width(),
                            h: this.options.height || this.$preview.height()
                        };
                        if (this.options.width) {
                            this.$preview.width(this.previewSize.w);
                        }
                        if (this.options.height) {
                            this.$preview.height(this.previewSize.h);
                        }

                        if (this.options.imageBackground) {
                            if (_jquery2['default'].isArray(this.options.imageBackgroundBorderWidth)) {
                                this.imageBgBorderWidthArray = this.options.imageBackgroundBorderWidth;
                            } else {
                                this.imageBgBorderWidthArray = [];
                                [0, 1, 2, 3].forEach(function (i) {
                                    _this.imageBgBorderWidthArray[i] = _this.options.imageBackgroundBorderWidth;
                                });
                            }

                            var $previewContainer = this.options.$previewContainer;
                            this.$imageBg = (0, _jquery2['default'])('<img />').addClass(_constants.CLASS_NAMES.IMAGE_BACKGROUND).attr('alt', '').css('position', 'absolute');
                            this.$imageBgContainer = (0, _jquery2['default'])('<div />').addClass(_constants.CLASS_NAMES.IMAGE_BACKGROUND_CONTAINER).css({
                                position: 'absolute',
                                zIndex: 0,
                                left: -this.imageBgBorderWidthArray[3] + window.parseInt(this.$preview.css('border-left-width') || 0),
                                top: -this.imageBgBorderWidthArray[0] + window.parseInt(this.$preview.css('border-top-width') || 0),
                                width: this.previewSize.w + this.imageBgBorderWidthArray[1] + this.imageBgBorderWidthArray[3],
                                height: this.previewSize.h + this.imageBgBorderWidthArray[0] + this.imageBgBorderWidthArray[2]
                            }).append(this.$imageBg);
                            if (this.imageBgBorderWidthArray[0] > 0) {
                                this.$imageBgContainer.css('overflow', 'hidden');
                            }
                            $previewContainer.css('position', 'relative').prepend(this.$imageBgContainer);
                            this.$preview.css('position', 'relative');

                            this.$preview.hover(function () {
                                _this.$imageBg.addClass(_constants.CLASS_NAMES.PREVIEW_HOVERED);
                            }, function () {
                                _this.$imageBg.removeClass(_constants.CLASS_NAMES.PREVIEW_HOVERED);
                            });
                        }

                        if (this.options.initialZoom === 'min') {
                            this.initialZoom = 0; // Will be fixed when image loads
                        } else if (this.options.initialZoom === 'image') {
                            this.initialZoom = 1;
                        } else {
                            this.initialZoom = 0;
                        }

                        this.imageLoaded = false;

                        this.moveContinue = false;

                        this.zoomer = new _Zoomer2['default']();

                        if (this.options.allowDragNDrop) {
                            _jquery2['default'].event.props.push('dataTransfer');
                        }

                        this.bindListeners();

                        if (this.options.imageState && this.options.imageState.src) {
                            this.loadImage(this.options.imageState.src);
                        }
                    }
                }, {
                    key: 'bindListeners',
                    value: function bindListeners() {
                        this.$fileInput.on('change.cropit', this.onFileChange.bind(this));
                        this.$preview.on(_constants.EVENTS.PREVIEW, this.onPreviewEvent.bind(this));
                        this.$zoomSlider.on(_constants.EVENTS.ZOOM_INPUT, this.onZoomSliderChange.bind(this));

                        if (this.options.allowDragNDrop) {
                            this.$preview.on('dragover.cropit dragleave.cropit', this.onDragOver.bind(this));
                            this.$preview.on('drop.cropit', this.onDrop.bind(this));
                        }
                    }
                }, {
                    key: 'unbindListeners',
                    value: function unbindListeners() {
                        this.$fileInput.off('change.cropit');
                        this.$preview.off(_constants.EVENTS.PREVIEW);
                        this.$preview.off('dragover.cropit dragleave.cropit drop.cropit');
                        this.$zoomSlider.off(_constants.EVENTS.ZOOM_INPUT);
                    }
                }, {
                    key: 'onFileChange',
                    value: function onFileChange() {
                        this.options.onFileChange();

                        if (this.$fileInput.get(0).files) {
                            this.loadFileReader(this.$fileInput.get(0).files[0]);
                        }
                    }
                }, {
                    key: 'loadFileReader',
                    value: function loadFileReader(file) {
                        var fileReader = new FileReader();
                        if (file && file.type.match('image')) {
                            fileReader.readAsDataURL(file);
                            fileReader.onload = this.onFileReaderLoaded.bind(this);
                            fileReader.onerror = this.onFileReaderError.bind(this);
                        } else if (file) {
                            this.onFileReaderError();
                        }
                    }
                }, {
                    key: 'onFileReaderLoaded',
                    value: function onFileReaderLoaded(e) {
                        this.loadImage(e.target.result);
                    }
                }, {
                    key: 'onFileReaderError',
                    value: function onFileReaderError() {
                        this.options.onFileReaderError();
                    }
                }, {
                    key: 'onDragOver',
                    value: function onDragOver(e) {
                        e.preventDefault();
                        e.dataTransfer.dropEffect = 'copy';
                        this.$preview.toggleClass(_constants.CLASS_NAMES.DRAG_HOVERED, e.type === 'dragover');
                    }
                }, {
                    key: 'onDrop',
                    value: function onDrop(e) {
                        var _this2 = this;

                        e.preventDefault();
                        e.stopPropagation();

                        var files = Array.prototype.slice.call(e.dataTransfer.files, 0);
                        files.some(function (file) {
                            if (!file.type.match('image')) {
                                return false;
                            }

                            _this2.loadFileReader(file);
                            return true;
                        });

                        this.$preview.removeClass(_constants.CLASS_NAMES.DRAG_HOVERED);
                    }
                }, {
                    key: 'loadImage',
                    value: function loadImage(imageSrc) {
                        if (!imageSrc) {
                            return;
                        }

                        this.options.onImageLoading();
                        this.setImageLoadingClass();

                        this.preImage.src = imageSrc;
                    }
                }, {
                    key: 'onPreImageLoaded',
                    value: function onPreImageLoaded() {
                        if (this.options.smallImage === 'reject' && (this.preImage.width * this.options.maxZoom < this.previewSize.w * this.options.exportZoom || this.preImage.height * this.options.maxZoom < this.previewSize.h * this.options.exportZoom)) {
                            this.onImageError(_constants.ERRORS.SMALL_IMAGE);
                            return;
                        }

                        this.image.src = this.imageSrc = this.preImage.src;
                    }
                }, {
                    key: 'onImageLoaded',
                    value: function onImageLoaded() {
                        this.imageSize = {
                            w: this.image.width,
                            h: this.image.height
                        };

                        this.setupZoomer(this.options.imageState && this.options.imageState.zoom || this.initialZoom);
                        if (this.options.imageState && this.options.imageState.offset) {
                            this.setOffset(this.options.imageState.offset);
                        } else {
                            this.centerImage();
                        }

                        this.options.imageState = {};

                        this.$preview.css('background-image', 'url(' + this.imageSrc + ')');
                        if (this.options.imageBackground) {
                            this.$imageBg.attr('src', this.imageSrc);
                        }

                        this.setImageLoadedClass();

                        this.imageLoaded = true;

                        this.options.onImageLoaded();
                    }
                }, {
                    key: 'onImageError',
                    value: function onImageError() {
                        this.options.onImageError.apply(this, arguments);
                        this.removeImageLoadingClass();
                    }
                }, {
                    key: 'setImageLoadingClass',
                    value: function setImageLoadingClass() {
                        this.$preview.removeClass(_constants.CLASS_NAMES.IMAGE_LOADED).addClass(_constants.CLASS_NAMES.IMAGE_LOADING);
                    }
                }, {
                    key: 'setImageLoadedClass',
                    value: function setImageLoadedClass() {
                        this.$preview.removeClass(_constants.CLASS_NAMES.IMAGE_LOADING).addClass(_constants.CLASS_NAMES.IMAGE_LOADED);
                    }
                }, {
                    key: 'removeImageLoadingClass',
                    value: function removeImageLoadingClass() {
                        this.$preview.removeClass(_constants.CLASS_NAMES.IMAGE_LOADING);
                    }
                }, {
                    key: 'getEventPosition',
                    value: function getEventPosition(e) {
                        if (e.originalEvent && e.originalEvent.touches && e.originalEvent.touches[0]) {
                            e = e.originalEvent.touches[0];
                        }
                        if (e.clientX && e.clientY) {
                            return {x: e.clientX, y: e.clientY};
                        }
                    }
                }, {
                    key: 'onPreviewEvent',
                    value: function onPreviewEvent(e) {
                        if (!this.imageLoaded) {
                            return;
                        }

                        this.moveContinue = false;
                        this.$preview.off(_constants.EVENTS.PREVIEW_MOVE);

                        if (e.type === 'mousedown' || e.type === 'touchstart') {
                            this.origin = this.getEventPosition(e);
                            this.moveContinue = true;
                            this.$preview.on(_constants.EVENTS.PREVIEW_MOVE, this.onMove.bind(this));
                        } else {
                            (0, _jquery2['default'])(document.body).focus();
                        }

                        e.stopPropagation();
                        return false;
                    }
                }, {
                    key: 'onMove',
                    value: function onMove(e) {
                        var eventPosition = this.getEventPosition(e);

                        if (this.moveContinue && eventPosition) {
                            this.setOffset({
                                x: this.offset.x + eventPosition.x - this.origin.x,
                                y: this.offset.y + eventPosition.y - this.origin.y
                            });
                        }

                        this.origin = eventPosition;

                        e.stopPropagation();
                        return false;
                    }
                }, {
                    key: 'setOffset',
                    value: function setOffset(position) {
                        this.offset = this.fixOffset(position);
                        this.$preview.css('background-position', '' + this.offset.x + 'px ' + this.offset.y + 'px');
                        if (this.options.imageBackground) {
                            this.$imageBg.css({
                                left: this.offset.x + this.imageBgBorderWidthArray[3],
                                top: this.offset.y + this.imageBgBorderWidthArray[0]
                            });
                        }
                    }
                }, {
                    key: 'fixOffset',
                    value: function fixOffset(offset) {
                        if (!this.imageLoaded) {
                            return offset;
                        }

                        var ret = {x: offset.x, y: offset.y};

                        if (!this.options.freeMove) {
                            if (this.imageSize.w * this.zoom >= this.previewSize.w) {
                                ret.x = Math.min(0, Math.max(ret.x, this.previewSize.w - this.imageSize.w * this.zoom));
                            } else {
                                ret.x = Math.max(0, Math.min(ret.x, this.previewSize.w - this.imageSize.w * this.zoom));
                            }

                            if (this.imageSize.h * this.zoom >= this.previewSize.h) {
                                ret.y = Math.min(0, Math.max(ret.y, this.previewSize.h - this.imageSize.h * this.zoom));
                            } else {
                                ret.y = Math.max(0, Math.min(ret.y, this.previewSize.h - this.imageSize.h * this.zoom));
                            }
                        }

                        ret.x = (0, _utils.round)(ret.x);
                        ret.y = (0, _utils.round)(ret.y);

                        return ret;
                    }
                }, {
                    key: 'centerImage',
                    value: function centerImage() {
                        if (!this.imageSize || !this.zoom) {
                            return;
                        }

                        this.setOffset({
                            x: (this.previewSize.w - this.imageSize.w * this.zoom) / 2,
                            y: (this.previewSize.h - this.imageSize.h * this.zoom) / 2
                        });
                    }
                }, {
                    key: 'onZoomSliderChange',
                    value: function onZoomSliderChange() {
                        if (!this.imageLoaded) {
                            return;
                        }

                        this.zoomSliderPos = Number(this.$zoomSlider.val());
                        var newZoom = this.zoomer.getZoom(this.zoomSliderPos);
                        this.setZoom(newZoom);
                    }
                }, {
                    key: 'enableZoomSlider',
                    value: function enableZoomSlider() {
                        this.$zoomSlider.removeAttr('disabled');
                        this.options.onZoomEnabled();
                    }
                }, {
                    key: 'disableZoomSlider',
                    value: function disableZoomSlider() {
                        this.$zoomSlider.attr('disabled', true);
                        this.options.onZoomDisabled();
                    }
                }, {
                    key: 'setupZoomer',
                    value: function setupZoomer(zoom) {
                        this.zoomer.setup({
                            imageSize: this.imageSize,
                            previewSize: this.previewSize,
                            exportZoom: this.options.exportZoom,
                            maxZoom: this.options.maxZoom,
                            minZoom: this.options.minZoom,
                            smallImage: this.options.smallImage
                        });
                        this.setZoom((0, _utils.exists)(zoom) ? zoom : this.zoom);

                        if (this.isZoomable()) {
                            this.enableZoomSlider();
                        } else {
                            this.disableZoomSlider();
                        }
                    }
                }, {
                    key: 'setZoom',
                    value: function setZoom(newZoom) {
                        newZoom = this.fixZoom(newZoom);

                        var updatedWidth = (0, _utils.round)(this.imageSize.w * newZoom);
                        var updatedHeight = (0, _utils.round)(this.imageSize.h * newZoom);

                        if (this.imageLoaded) {
                            var oldZoom = this.zoom;

                            var newX = this.previewSize.w / 2 - (this.previewSize.w / 2 - this.offset.x) * newZoom / oldZoom;
                            var newY = this.previewSize.h / 2 - (this.previewSize.h / 2 - this.offset.y) * newZoom / oldZoom;

                            this.zoom = newZoom;
                            this.setOffset({x: newX, y: newY});
                        } else {
                            this.zoom = newZoom;
                        }

                        this.zoomSliderPos = this.zoomer.getSliderPos(this.zoom);
                        this.$zoomSlider.val(this.zoomSliderPos);

                        this.$preview.css('background-size', '' + updatedWidth + 'px ' + updatedHeight + 'px');
                        if (this.options.imageBackground) {
                            this.$imageBg.css({
                                width: updatedWidth,
                                height: updatedHeight
                            });
                        }
                    }
                }, {
                    key: 'fixZoom',
                    value: function fixZoom(zoom) {
                        return this.zoomer.fixZoom(zoom);
                    }
                }, {
                    key: 'isZoomable',
                    value: function isZoomable() {
                        return this.zoomer.isZoomable();
                    }
                }, {
                    key: 'getCroppedImageData',
                    value: function getCroppedImageData(exportOptions) {
                        if (!this.imageSrc) {
                            return;
                        }

                        var exportDefaults = {
                            type: 'image/png',
                            quality: 1,
                            originalSize: false,
                            fillBg: '#fff'
                        };
                        exportOptions = _jquery2['default'].extend({}, exportDefaults, exportOptions);

                        var croppedSize = {
                            w: this.previewSize.w,
                            h: this.previewSize.h
                        };

                        var exportZoom = exportOptions.originalSize ? 1 / this.zoom : this.options.exportZoom;

                        var canvas = (0, _jquery2['default'])('<canvas />').attr({
                            width: croppedSize.w * exportZoom,
                            height: croppedSize.h * exportZoom
                        }).get(0);
                        var ctx = canvas.getContext("2d");

                        if (exportOptions.type === 'image/jpeg') {
                            ctx.fillStyle = exportOptions.fillBg;
                            ctx.fillRect(0, 0, canvas.width, canvas.height);
                        }

                        var posX = this.offset.x * exportZoom;
                        var posY = this.offset.y * exportZoom;
                        var sizeW = this.zoom * exportZoom * this.imageSize.w;
                        var sizeH = this.zoom * exportZoom * this.imageSize.h;

                        var canvasTmp, contextTmp, canvasWidth, canvasHeight, posXTemp, posYTemp, scaledImage;
                        var tmp = new Image();
                        tmp.src = this.image.src;

                        canvasWidth = tmp.width;
                        canvasHeight = tmp.height;

                        var ratio = 0.5,
                            steps = Math.ceil(Math.log(canvasWidth / sizeW) / Math.log(2));

                        canvasTmp = document.createElement('canvas');
                        contextTmp = canvasTmp.getContext('2d');

                        posXTemp = this.offset.x;
                        posYTemp = this.offset.y;
                        /*canvasTmp.width = canvasWidth;
                         canvasTmp.height = canvasHeight;

                         contextTmp.drawImage(tmp, posXTemp, posYTemp, canvasWidth, canvasHeight);

                         */
                        scaledImage = this.downScaleImage(this.image, ratio, canvas);
                        /*contextTmp.drawImage(scaledImage, posXTemp, posYTemp, canvasWidth, canvasHeight);

                         for (var i = 1; i < steps; i++) {
                         posXTemp *= ratio;
                         posYTemp *= ratio;
                         canvasWidth *= ratio;
                         canvasHeight *= ratio;

                         scaledImage = this.downScaleImage(scaledImage, ratio, canvasTmp);

                         contextTmp.drawImage(scaledImage, posXTemp, posYTemp, canvasWidth, canvasHeight);
                         }*/

                        ctx.webkitImageSmoothingEnabled = false;
                        ctx.mozImageSmoothingEnabled = false;
                        ctx.msImageSmoothingEnabled = false;
                        ctx.oImageSmoothingEnabled = false;
                        ctx.ImageSmoothingEnabled = false;

                        ctx.drawImage(scaledImage, posX, posY, sizeW, sizeH);

                        return canvas.toDataURL(exportOptions.type, exportOptions.quality);
                    }
                }, {
                    key: 'downScaleImage',
                    value: function downScaleImage(img, scale, canvas) {
                        var imgCV = document.createElement('canvas');
                        imgCV.width = img.width;
                        imgCV.height = img.height;
                        var imgCtx = imgCV.getContext('2d');
                        imgCtx.drawImage(img, 0, 0);
                        return this.downScaleCanvas(imgCV, scale, canvas)
                    }
                }, {
                    key: 'downScaleCanvas',
                    value: function downScaleCanvas(img, scale, canvas) {
                        if (!(scale < 1) || !(scale > 0)) throw ('scale must be a positive number <1 ');
                        scale = this.normaliseScale(scale);
                        var sqScale = scale * scale; // square scale =  area of a source pixel within target
                        var sw = canvas.width; // source image width
                        var sh = canvas.height; // source image height
                        var tw = Math.floor(sw * scale); // target image width
                        var th = Math.floor(sh * scale); // target image height
                        var sx = 0,
                            sy = 0,
                            sIndex = 0; // source x,y, index within source array
                        var tx = 0,
                            ty = 0,
                            yIndex = 0,
                            tIndex = 0; // target x,y, x,y index within target array
                        var tX = 0,
                            tY = 0; // rounded tx, ty
                        var w = 0,
                            nw = 0,
                            wx = 0,
                            nwx = 0,
                            wy = 0,
                            nwy = 0; // weight / next weight x / y
                        // weight is weight of current source point within target.
                        // next weight is weight of current source point within next target's point.
                        var crossX = false; // does scaled px cross its current px right border ?
                        var crossY = false; // does scaled px cross its current px bottom border ?
                        var sBuffer = canvas.getContext('2d').
                            getImageData(0, 0, sw, sh).data; // source buffer 8 bit rgba
                        var tBuffer = new Float32Array(3 * tw * th); // target buffer Float32 rgb
                        var sR = 0,
                            sG = 0,
                            sB = 0; // source's current point r,g,b

                        for (sy = 0; sy < sh; sy++) {
                            ty = sy * scale; // y src position within target
                            tY = 0 | ty; // rounded : target pixel's y
                            yIndex = 3 * tY * tw; // line index within target array
                            crossY = (tY !== (0 | (ty + scale)));
                            if (crossY) { // if pixel is crossing bottom target pixel
                                wy = (tY + 1 - ty); // weight of point within target pixel
                                nwy = (ty + scale - tY - 1); // ... within y+1 target pixel
                            }
                            for (sx = 0; sx < sw; sx++, sIndex += 4) {
                                tx = sx * scale; // x src position within target
                                tX = 0 | tx; // rounded : target pixel's x
                                tIndex = yIndex + tX * 3; // target pixel index within target array
                                crossX = (tX !== (0 | (tx + scale)));
                                if (crossX) { // if pixel is crossing target pixel's right
                                    wx = (tX + 1 - tx); // weight of point within target pixel
                                    nwx = (tx + scale - tX - 1); // ... within x+1 target pixel
                                }
                                sR = sBuffer[sIndex]; // retrieving r,g,b for curr src px.
                                sG = sBuffer[sIndex + 1];
                                sB = sBuffer[sIndex + 2];
                                if (!crossX && !crossY) { // pixel does not cross
                                    // just add components weighted by squared scale.
                                    tBuffer[tIndex] += sR * sqScale;
                                    tBuffer[tIndex + 1] += sG * sqScale;
                                    tBuffer[tIndex + 2] += sB * sqScale;
                                } else if (crossX && !crossY) { // cross on X only
                                    w = wx * scale;
                                    // add weighted component for current px
                                    tBuffer[tIndex] += sR * w;
                                    tBuffer[tIndex + 1] += sG * w;
                                    tBuffer[tIndex + 2] += sB * w;
                                    // add weighted component for next (tX+1) px
                                    nw = nwx * scale;
                                    tBuffer[tIndex + 3] += sR * nw;
                                    tBuffer[tIndex + 4] += sG * nw;
                                    tBuffer[tIndex + 5] += sB * nw;
                                } else if (!crossX && crossY) { // cross on Y only
                                    w = wy * scale;
                                    // add weighted component for current px
                                    tBuffer[tIndex] += sR * w;
                                    tBuffer[tIndex + 1] += sG * w;
                                    tBuffer[tIndex + 2] += sB * w;
                                    // add weighted component for next (tY+1) px
                                    nw = nwy * scale;
                                    tBuffer[tIndex + 3 * tw] += sR * nw;
                                    tBuffer[tIndex + 3 * tw + 1] += sG * nw;
                                    tBuffer[tIndex + 3 * tw + 2] += sB * nw;
                                } else { // crosses both x and y : four target points involved
                                    // add weighted component for current px
                                    w = wx * wy;
                                    tBuffer[tIndex] += sR * w;
                                    tBuffer[tIndex + 1] += sG * w;
                                    tBuffer[tIndex + 2] += sB * w;
                                    // for tX + 1; tY px
                                    nw = nwx * wy;
                                    tBuffer[tIndex + 3] += sR * nw;
                                    tBuffer[tIndex + 4] += sG * nw;
                                    tBuffer[tIndex + 5] += sB * nw;
                                    // for tX ; tY + 1 px
                                    nw = wx * nwy;
                                    tBuffer[tIndex + 3 * tw] += sR * nw;
                                    tBuffer[tIndex + 3 * tw + 1] += sG * nw;
                                    tBuffer[tIndex + 3 * tw + 2] += sB * nw;
                                    // for tX + 1 ; tY +1 px
                                    nw = nwx * nwy;
                                    tBuffer[tIndex + 3 * tw + 3] += sR * nw;
                                    tBuffer[tIndex + 3 * tw + 4] += sG * nw;
                                    tBuffer[tIndex + 3 * tw + 5] += sB * nw;
                                }
                            } // end for sx
                        } // end for sy

                        // create result canvas
                        var resCV = document.createElement('canvas');
                        resCV.width = tw;
                        resCV.height = th;
                        var resCtx = resCV.getContext('2d');
                        var imgRes = resCtx.getImageData(0, 0, tw, th);
                        var tByteBuffer = imgRes.data;
                        console.log(imgRes);
                        // http://jsfiddle.net/gamealchemist/r6aVp/
                        // convert float32 array into a UInt8Clamped Array
                        var pxIndex = 0; //
                        for (sIndex = 0, tIndex = 0; pxIndex < tw * th; sIndex += 3, tIndex += 4, pxIndex++) {
                            tByteBuffer[tIndex] = 0 | (tBuffer[sIndex]);
                            tByteBuffer[tIndex + 1] = 0 | (tBuffer[sIndex + 1]);
                            tByteBuffer[tIndex + 2] = 0 | (tBuffer[sIndex + 2]);
                            tByteBuffer[tIndex + 3] = 255;
                        }
                        // writing result to canvas.
                        resCtx.putImageData(imgRes, 0, 0);
                        return resCV;
                    }
                }, {
                    key: 'normaliseScale',
                    value: function normaliseScale(s) {
                        if (s > 1) throw ('s must be <1');
                        s = 0 | (1 / s);
                        var l = this.log2(s);
                        var mask = 1 << l;
                        var accuracy = 4;
                        while (accuracy && l) {
                            l--;
                            mask |= 1 << l;
                            accuracy--;
                        }
                        return 1 / (s & mask);
                    }
                }, {
                    key: 'log2',
                    value: function log2(v) {
                        // taken from http://graphics.stanford.edu/~seander/bithacks.html
                        var b = [0x2, 0xC, 0xF0, 0xFF00, 0xFFFF0000];
                        var S = [1, 2, 4, 8, 16];
                        var r = 0;
                        var i;

                        for (i = 4; i >= 0; i--) {
                            if (v & b[i]) {
                                v >>= S[i];
                                r |= S[i];
                            }
                        }
                        return r;
                    }
                }, {
                    key: 'getImageState',
                    value: function getImageState() {
                        return {
                            src: this.imageSrc,
                            offset: this.offset,
                            zoom: this.zoom
                        };
                    }
                }, {
                    key: 'getImageSrc',
                    value: function getImageSrc() {
                        return this.imageSrc;
                    }
                }, {
                    key: 'getOffset',
                    value: function getOffset() {
                        return this.offset;
                    }
                }, {
                    key: 'getZoom',
                    value: function getZoom() {
                        return this.zoom;
                    }
                }, {
                    key: 'getImageSize',
                    value: function getImageSize() {
                        if (!this.imageSize) {
                            return null;
                        }

                        return {
                            width: this.imageSize.w,
                            height: this.imageSize.h
                        };
                    }
                }, {
                    key: 'getPreviewSize',
                    value: function getPreviewSize() {
                        return {
                            width: this.previewSize.w,
                            height: this.previewSize.h
                        };
                    }
                }, {
                    key: 'setPreviewSize',
                    value: function setPreviewSize(size) {
                        if (!size || size.width <= 0 || size.height <= 0) {
                        }

                        this.previewSize = {
                            w: size.width,
                            h: size.height
                        };
                        this.$preview.css({
                            width: this.previewSize.w,
                            height: this.previewSize.h
                        });

                        if (this.options.imageBackground) {
                            this.$imageBgContainer.css({
                                width: this.previewSize.w + this.imageBgBorderWidthArray[1] + this.imageBgBorderWidthArray[3],
                                height: this.previewSize.h + this.imageBgBorderWidthArray[0] + this.imageBgBorderWidthArray[2]
                            });
                        }

                        if (this.imageLoaded) {
                            this.setupZoomer();
                        }
                    }
                }, {
                    key: 'disable',
                    value: function disable() {
                        this.unbindListeners();
                        this.disableZoomSlider();
                        this.$el.addClass(_constants.CLASS_NAMES.DISABLED);
                    }
                }, {
                    key: 'reenable',
                    value: function reenable() {
                        this.bindListeners();
                        this.enableZoomSlider();
                        this.$el.removeClass(_constants.CLASS_NAMES.DISABLED);
                    }
                }, {
                    key: '$',
                    value: function $(selector) {
                        if (!this.$el) {
                            return null;
                        }
                        return this.$el.find(selector);
                    }
                }]);

                return Cropit;
            })();

            exports['default'] = Cropit;
            module.exports = exports['default'];

            /***/
        },
        /* 3 */
        /***/ function (module, exports) {

            Object.defineProperty(exports, '__esModule', {
                value: true
            });

            var _createClass = (function () {
                function defineProperties(target, props) {
                    for (var i = 0; i < props.length; i++) {
                        var descriptor = props[i];
                        descriptor.enumerable = descriptor.enumerable || false;
                        descriptor.configurable = true;
                        if ('value' in descriptor) descriptor.writable = true;
                        Object.defineProperty(target, descriptor.key, descriptor);
                    }
                }

                return function (Constructor, protoProps, staticProps) {
                    if (protoProps) defineProperties(Constructor.prototype, protoProps);
                    if (staticProps) defineProperties(Constructor, staticProps);
                    return Constructor;
                };
            })();

            function _classCallCheck(instance, Constructor) {
                if (!(instance instanceof Constructor)) {
                    throw new TypeError('Cannot call a class as a function');
                }
            }

            var Zoomer = (function () {
                function Zoomer() {
                    _classCallCheck(this, Zoomer);

                    this.minZoom = this.maxZoom = 1;
                }

                _createClass(Zoomer, [{
                    key: 'setup',
                    value: function setup(_ref) {
                        var imageSize = _ref.imageSize;
                        var previewSize = _ref.previewSize;
                        var exportZoom = _ref.exportZoom;
                        var maxZoom = _ref.maxZoom;
                        var minZoom = _ref.minZoom;
                        var smallImage = _ref.smallImage;

                        var widthRatio = previewSize.w / imageSize.w;
                        var heightRatio = previewSize.h / imageSize.h;

                        if (minZoom === 'fit') {
                            this.minZoom = Math.min(widthRatio, heightRatio);
                        } else {
                            this.minZoom = Math.max(widthRatio, heightRatio);
                        }

                        if (smallImage === 'allow') {
                            this.minZoom = Math.min(this.minZoom, 1);
                        }

                        this.maxZoom = Math.max(this.minZoom, maxZoom / exportZoom);
                    }
                }, {
                    key: 'getZoom',
                    value: function getZoom(sliderPos) {
                        if (!this.minZoom || !this.maxZoom) {
                            return null;
                        }

                        return sliderPos * (this.maxZoom - this.minZoom) + this.minZoom;
                    }
                }, {
                    key: 'getSliderPos',
                    value: function getSliderPos(zoom) {
                        if (!this.minZoom || !this.maxZoom) {
                            return null;
                        }

                        if (this.minZoom === this.maxZoom) {
                            return 0;
                        } else {
                            return (zoom - this.minZoom) / (this.maxZoom - this.minZoom);
                        }
                    }
                }, {
                    key: 'isZoomable',
                    value: function isZoomable() {
                        if (!this.minZoom || !this.maxZoom) {
                            return null;
                        }

                        return this.minZoom !== this.maxZoom;
                    }
                }, {
                    key: 'fixZoom',
                    value: function fixZoom(zoom) {
                        return Math.max(this.minZoom, Math.min(this.maxZoom, zoom));
                    }
                }]);

                return Zoomer;
            })();

            exports['default'] = Zoomer;
            module.exports = exports['default'];

            /***/
        },
        /* 4 */
        /***/ function (module, exports) {

            Object.defineProperty(exports, '__esModule', {
                value: true
            });
            var PLUGIN_KEY = 'cropit';

            exports.PLUGIN_KEY = PLUGIN_KEY;
            var CLASS_NAMES = {
                PREVIEW: 'cropit-image-preview',
                PREVIEW_CONTAINER: 'cropit-image-preview-container',
                FILE_INPUT: 'cropit-image-input',
                ZOOM_SLIDER: 'cropit-image-zoom-input',
                IMAGE_BACKGROUND: 'cropit-image-background',
                IMAGE_BACKGROUND_CONTAINER: 'cropit-image-background-container',
                PREVIEW_HOVERED: 'cropit-preview-hovered',
                DRAG_HOVERED: 'cropit-drag-hovered',
                IMAGE_LOADING: 'cropit-image-loading',
                IMAGE_LOADED: 'cropit-image-loaded',
                DISABLED: 'cropit-disabled'
            };

            exports.CLASS_NAMES = CLASS_NAMES;
            var ERRORS = {
                IMAGE_FAILED_TO_LOAD: {code: 0, message: 'Image failed to load.'},
                SMALL_IMAGE: {code: 1, message: 'Image is too small.'}
            };

            exports.ERRORS = ERRORS;
            var eventName = function eventName(events) {
                return events.map(function (e) {
                    return '' + e + '.cropit';
                }).join(' ');
            };
            var EVENTS = {
                PREVIEW: eventName(['mousedown', 'mouseup', 'mouseleave', 'touchstart', 'touchend', 'touchcancel', 'touchleave']),
                PREVIEW_MOVE: eventName(['mousemove', 'touchmove']),
                ZOOM_INPUT: eventName(['mousemove', 'touchmove', 'change'])
            };
            exports.EVENTS = EVENTS;

            /***/
        },
        /* 5 */
        /***/ function (module, exports, __webpack_require__) {

            Object.defineProperty(exports, '__esModule', {
                value: true
            });

            var _constants = __webpack_require__(4);

            var options = {
                elements: [{
                    name: '$preview',
                    description: 'The HTML element that displays image preview.',
                    defaultSelector: '.' + _constants.CLASS_NAMES.PREVIEW
                }, {
                    name: '$fileInput',
                    description: 'File input element.',
                    defaultSelector: 'input.' + _constants.CLASS_NAMES.FILE_INPUT
                }, {
                    name: '$zoomSlider',
                    description: 'Range input element that controls image zoom.',
                    defaultSelector: 'input.' + _constants.CLASS_NAMES.ZOOM_SLIDER
                }, {
                    name: '$previewContainer',
                    description: 'Preview container. Only needed when `imageBackground` is true.',
                    defaultSelector: '.' + _constants.CLASS_NAMES.PREVIEW_CONTAINER
                }].map(function (o) {
                        o.type = 'jQuery element';
                        o['default'] = '$imageCropper.find(\'' + o.defaultSelector + '\')';
                        return o;
                    }),

                values: [{
                    name: 'width',
                    type: 'number',
                    description: 'Width of image preview in pixels. If set, it will override the CSS property.',
                    'default': null
                }, {
                    name: 'height',
                    type: 'number',
                    description: 'Height of image preview in pixels. If set, it will override the CSS property.',
                    'default': null
                }, {
                    name: 'imageBackground',
                    type: 'boolean',
                    description: 'Whether or not to display the background image beyond the preview area.',
                    'default': false
                }, {
                    name: 'imageBackgroundBorderWidth',
                    type: 'array or number',
                    description: 'Width of background image border in pixels.\n        The four array elements specify the width of background image width on the top, right, bottom, left side respectively.\n        The background image beyond the width will be hidden.\n        If specified as a number, border with uniform width on all sides will be applied.',
                    'default': [0, 0, 0, 0]
                }, {
                    name: 'exportZoom',
                    type: 'number',
                    description: 'The ratio between the desired image size to export and the preview size.\n        For example, if the preview size is `300px * 200px`, and `exportZoom = 2`, then\n        the exported image size will be `600px * 400px`.\n        This also affects the maximum zoom level, since the exported image cannot be zoomed to larger than its original size.',
                    'default': 1
                }, {
                    name: 'allowDragNDrop',
                    type: 'boolean',
                    description: 'When set to true, you can load an image by dragging it from local file browser onto the preview area.',
                    'default': true
                }, {
                    name: 'minZoom',
                    type: 'string',
                    description: 'This options decides the minimal zoom level of the image.\n        If set to `\'fill\'`, the image has to fill the preview area, i.e. both width and height must not go smaller than the preview area.\n        If set to `\'fit\'`, the image can shrink further to fit the preview area, i.e. at least one of its edges must not go smaller than the preview area.',
                    'default': 'fill'
                }, {
                    name: 'maxZoom',
                    type: 'string',
                    description: 'Determines how big the image can be zoomed. E.g. if set to 1.5, the image can be zoomed to 150% of its original size.',
                    'default': 1
                }, {
                    name: 'initialZoom',
                    type: 'string',
                    description: 'Determines the zoom when an image is loaded.\n        When set to `\'min\'`, image is zoomed to the smallest when loaded.\n        When set to `\'image\'`, image is zoomed to 100% when loaded.',
                    'default': 'min'
                }, {
                    name: 'freeMove',
                    type: 'boolean',
                    description: 'When set to true, you can freely move the image instead of being bound to the container borders',
                    'default': false
                }, {
                    name: 'smallImage',
                    type: 'string',
                    description: 'When set to `\'reject\'`, `onImageError` would be called when cropit loads an image that is smaller than the container.\n        When set to `\'allow\'`, images smaller than the container can be zoomed down to its original size, overiding `minZoom` option.\n        When set to `\'stretch\'`, the minimum zoom of small images would follow `minZoom` option.',
                    'default': 'reject'
                }, {
                    name: 'allowCrossOrigin',
                    type: 'boolean',
                    description: 'Set to true if you need to crop image served from other domains.',
                    'default': false
                }],

                callbacks: [{
                    name: 'onFileChange',
                    description: 'Called when user selects a file in the select file input.'
                }, {
                    name: 'onFileReaderError',
                    description: 'Called when `FileReader` encounters an error while loading the image file.'
                }, {
                    name: 'onImageLoading',
                    description: 'Called when image starts to be loaded.'
                }, {
                    name: 'onImageLoaded',
                    description: 'Called when image is loaded.'
                }, {
                    name: 'onImageError',
                    description: 'Called when image cannot be loaded.'
                }, {
                    name: 'onZoomEnabled',
                    description: 'Called when image the zoom slider is enabled.'
                }, {
                    name: 'onZoomDisabled',
                    description: 'Called when image the zoom slider is disabled.'
                }].map(function (o) {
                        o.type = 'function';
                        return o;
                    })
            };

            var loadDefaults = function loadDefaults($el) {
                var defaults = {};
                if ($el) {
                    options.elements.forEach(function (o) {
                        defaults[o.name] = $el.find(o.defaultSelector);
                    });
                }
                options.values.forEach(function (o) {
                    defaults[o.name] = o['default'];
                });
                options.callbacks.forEach(function (o) {
                    defaults[o.name] = function () {
                    };
                });

                return defaults;
            };

            exports.loadDefaults = loadDefaults;
            exports['default'] = options;

            /***/
        },
        /* 6 */
        /***/ function (module, exports) {

            Object.defineProperty(exports, '__esModule', {
                value: true
            });
            var exists = function exists(v) {
                return typeof v !== 'undefined';
            };

            exports.exists = exists;
            var round = function round(x) {
                return +(Math.round(x * 100) + 'e-2');
            };
            exports.round = round;

            /***/
        }
        /******/])
});
