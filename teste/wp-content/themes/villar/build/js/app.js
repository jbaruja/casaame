(() => {
    var __webpack_modules__ = [ (__unused_webpack_module, __webpack_exports__, __webpack_require__) => {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        var _components_Preloader__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(1);
        var _components_ToTop__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(2);
        var _components_ColorMode__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(3);
        var _components_NavSearch__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(5);
        var _components_Navigation__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(6);
        var _components_Sticky__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(8);
        var _components_FocusRedirect__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(11);
        jQuery((function($) {
            "use strict";
            _components_Preloader__WEBPACK_IMPORTED_MODULE_0__["default"].init($);
            _components_ToTop__WEBPACK_IMPORTED_MODULE_1__["default"].init($);
            _components_ColorMode__WEBPACK_IMPORTED_MODULE_2__["default"].init($);
            _components_NavSearch__WEBPACK_IMPORTED_MODULE_3__["default"].init($);
            _components_Navigation__WEBPACK_IMPORTED_MODULE_4__["default"].init($);
            _components_FocusRedirect__WEBPACK_IMPORTED_MODULE_6__["default"].init($);
            _components_Sticky__WEBPACK_IMPORTED_MODULE_5__["default"].init();
        }));
    }, (__unused_webpack_module, __webpack_exports__, __webpack_require__) => {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        __webpack_require__.d(__webpack_exports__, {
            default: () => __WEBPACK_DEFAULT_EXPORT__
        });
        var $ = window.jQuery;
        var Preloader = {
            init: function init() {
                if ($(".villar-preloader-wrap").length) {
                    $(document).ready(this.hidePreloader);
                    if ($("body").hasClass("elementor-editor-active")) {
                        setTimeout(this.hidePreloader, 300);
                    }
                }
            },
            hidePreloader: function hidePreloader() {
                $(".villar-preloader-wrap > div").fadeOut(600);
                $(".villar-preloader-wrap").fadeOut(1500);
            }
        };
        const __WEBPACK_DEFAULT_EXPORT__ = Preloader;
    }, (__unused_webpack_module, __webpack_exports__, __webpack_require__) => {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        __webpack_require__.d(__webpack_exports__, {
            default: () => __WEBPACK_DEFAULT_EXPORT__
        });
        var $ = window.jQuery;
        var ToTop = {
            init: function init() {
                var $scrollTop = $("#scroll-top");
                $(window).on("scroll", (function() {
                    if ($(this).scrollTop() > 100) {
                        $scrollTop.fadeIn();
                    } else {
                        $scrollTop.fadeOut();
                    }
                }));
                $scrollTop.on("click", (function() {
                    $("html, body").scrollTop(0);
                    return false;
                }));
            }
        };
        const __WEBPACK_DEFAULT_EXPORT__ = ToTop;
    }, (__unused_webpack_module, __webpack_exports__, __webpack_require__) => {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        __webpack_require__.d(__webpack_exports__, {
            default: () => __WEBPACK_DEFAULT_EXPORT__
        });
        var js_cookie__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(4);
        var $ = window.jQuery;
        var ColorMode = {
            init: function init() {
                $(".color-mode-toggle").on("click", this.toggle.bind(this));
            },
            toggle: function toggle() {
                if ($(document.body).hasClass("dark")) {
                    this.setLightMode();
                } else {
                    this.setDarkMode();
                }
            },
            setLightMode: function setLightMode() {
                this.setGlobalTransition();
                document.body.classList.remove("dark");
                js_cookie__WEBPACK_IMPORTED_MODULE_0__["default"].set("villar-color-mode", "light", {
                    expires: 365
                });
            },
            setDarkMode: function setDarkMode() {
                this.setGlobalTransition();
                document.body.classList.add("dark");
                js_cookie__WEBPACK_IMPORTED_MODULE_0__["default"].set("villar-color-mode", "dark", {
                    expires: 365
                });
            },
            setGlobalTransition: function setGlobalTransition() {
                document.body.classList.add("transition-force-none");
                setTimeout((function() {
                    document.body.classList.remove("transition-force-none");
                }), 50);
            }
        };
        const __WEBPACK_DEFAULT_EXPORT__ = ColorMode;
    }, (__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        __webpack_require__.d(__webpack_exports__, {
            default: () => __WEBPACK_DEFAULT_EXPORT__
        });
        /*! js-cookie v3.0.1 | MIT */        function assign(target) {
            for (var i = 1; i < arguments.length; i++) {
                var source = arguments[i];
                for (var key in source) {
                    target[key] = source[key];
                }
            }
            return target;
        }
        var defaultConverter = {
            read: function(value) {
                if (value[0] === '"') {
                    value = value.slice(1, -1);
                }
                return value.replace(/(%[\dA-F]{2})+/gi, decodeURIComponent);
            },
            write: function(value) {
                return encodeURIComponent(value).replace(/%(2[346BF]|3[AC-F]|40|5[BDE]|60|7[BCD])/g, decodeURIComponent);
            }
        };
        function init(converter, defaultAttributes) {
            function set(key, value, attributes) {
                if (typeof document === "undefined") {
                    return;
                }
                attributes = assign({}, defaultAttributes, attributes);
                if (typeof attributes.expires === "number") {
                    attributes.expires = new Date(Date.now() + attributes.expires * 864e5);
                }
                if (attributes.expires) {
                    attributes.expires = attributes.expires.toUTCString();
                }
                key = encodeURIComponent(key).replace(/%(2[346B]|5E|60|7C)/g, decodeURIComponent).replace(/[()]/g, escape);
                var stringifiedAttributes = "";
                for (var attributeName in attributes) {
                    if (!attributes[attributeName]) {
                        continue;
                    }
                    stringifiedAttributes += "; " + attributeName;
                    if (attributes[attributeName] === true) {
                        continue;
                    }
                    stringifiedAttributes += "=" + attributes[attributeName].split(";")[0];
                }
                return document.cookie = key + "=" + converter.write(value, key) + stringifiedAttributes;
            }
            function get(key) {
                if (typeof document === "undefined" || arguments.length && !key) {
                    return;
                }
                var cookies = document.cookie ? document.cookie.split("; ") : [];
                var jar = {};
                for (var i = 0; i < cookies.length; i++) {
                    var parts = cookies[i].split("=");
                    var value = parts.slice(1).join("=");
                    try {
                        var foundKey = decodeURIComponent(parts[0]);
                        jar[foundKey] = converter.read(value, foundKey);
                        if (key === foundKey) {
                            break;
                        }
                    } catch (e) {}
                }
                return key ? jar[key] : jar;
            }
            return Object.create({
                set,
                get,
                remove: function(key, attributes) {
                    set(key, "", assign({}, attributes, {
                        expires: -1
                    }));
                },
                withAttributes: function(attributes) {
                    return init(this.converter, assign({}, this.attributes, attributes));
                },
                withConverter: function(converter) {
                    return init(assign({}, this.converter, converter), this.attributes);
                }
            }, {
                attributes: {
                    value: Object.freeze(defaultAttributes)
                },
                converter: {
                    value: Object.freeze(converter)
                }
            });
        }
        var api = init(defaultConverter, {
            path: "/"
        });
        const __WEBPACK_DEFAULT_EXPORT__ = api;
    }, (__unused_webpack_module, __webpack_exports__, __webpack_require__) => {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        __webpack_require__.d(__webpack_exports__, {
            default: () => __WEBPACK_DEFAULT_EXPORT__
        });
        var NavSearch = {
            init: function init($) {
                var $form = $(".nav-search-form");
                $(".nav-search-toggle").on("click", (function(ev) {
                    ev.preventDefault();
                    $form.toggleClass("hidden");
                    if ($form.hasClass("hidden") === false) {
                        $form.find(":focusable").eq(0).focus();
                    }
                }));
            }
        };
        const __WEBPACK_DEFAULT_EXPORT__ = NavSearch;
    }, (__unused_webpack_module, __webpack_exports__, __webpack_require__) => {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        __webpack_require__.d(__webpack_exports__, {
            default: () => __WEBPACK_DEFAULT_EXPORT__
        });
        var superfish__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(7);
        var superfish__WEBPACK_IMPORTED_MODULE_0___default = __webpack_require__.n(superfish__WEBPACK_IMPORTED_MODULE_0__);
        var $ = window.jQuery;
        var Navigation = {
            init: function init() {
                this.$mobileMenuToggle = $("#mobile-menu-toggle");
                this.$mobileMenuToggleIcon = $("#mobile-menu-toggle-icon");
                this.$primaryMenu = $("#primary-menu");
                this.$mobileMenuToggle.on("click", this.toggleMobileMenu.bind(this));
                $("ul.sf-menu").superfish({
                    animation: {
                        opacity: "show",
                        marginTop: "0"
                    },
                    animationOut: {
                        opacity: "hide",
                        marginTop: "10"
                    },
                    speed: 300,
                    speedOut: 150
                });
            },
            toggleMobileMenu: function toggleMobileMenu() {
                if (this.$primaryMenu.hasClass("hidden")) {
                    this.showMobileMenu();
                } else {
                    this.hideMobileMenu();
                }
            },
            showMobileMenu: function showMobileMenu() {
                this.$primaryMenu.removeClass("hidden");
                this.$mobileMenuToggleIcon.attr("class", "fas fa-times");
            },
            hideMobileMenu: function hideMobileMenu() {
                this.$primaryMenu.addClass("hidden");
                this.$mobileMenuToggleIcon.attr("class", "fas fa-bars");
            }
        };
        const __WEBPACK_DEFAULT_EXPORT__ = Navigation;
    }, () => {
        (function($, w) {
            "use strict";
            var methods = function() {
                var c = {
                    bcClass: "sf-breadcrumb",
                    menuClass: "sf-js-enabled",
                    anchorClass: "sf-with-ul",
                    menuArrowClass: "sf-arrows"
                }, ios = function() {
                    var ios = /^(?![\w\W]*Windows Phone)[\w\W]*(iPhone|iPad|iPod)/i.test(navigator.userAgent);
                    if (ios) {
                        $("html").css("cursor", "pointer").on("click", $.noop);
                    }
                    return ios;
                }(), wp7 = function() {
                    var style = document.documentElement.style;
                    return "behavior" in style && "fill" in style && /iemobile/i.test(navigator.userAgent);
                }(), unprefixedPointerEvents = function() {
                    return !!w.PointerEvent;
                }(), toggleMenuClasses = function($menu, o, add) {
                    var classes = c.menuClass, method;
                    if (o.cssArrows) {
                        classes += " " + c.menuArrowClass;
                    }
                    method = add ? "addClass" : "removeClass";
                    $menu[method](classes);
                }, setPathToCurrent = function($menu, o) {
                    return $menu.find("li." + o.pathClass).slice(0, o.pathLevels).addClass(o.hoverClass + " " + c.bcClass).filter((function() {
                        return $(this).children(o.popUpSelector).hide().show().length;
                    })).removeClass(o.pathClass);
                }, toggleAnchorClass = function($li, add) {
                    var method = add ? "addClass" : "removeClass";
                    $li.children("a")[method](c.anchorClass);
                }, toggleTouchAction = function($menu) {
                    var msTouchAction = $menu.css("ms-touch-action");
                    var touchAction = $menu.css("touch-action");
                    touchAction = touchAction || msTouchAction;
                    touchAction = touchAction === "pan-y" ? "auto" : "pan-y";
                    $menu.css({
                        "ms-touch-action": touchAction,
                        "touch-action": touchAction
                    });
                }, getMenu = function($el) {
                    return $el.closest("." + c.menuClass);
                }, getOptions = function($el) {
                    return getMenu($el).data("sfOptions");
                }, over = function() {
                    var $this = $(this), o = getOptions($this);
                    clearTimeout(o.sfTimer);
                    $this.siblings().superfish("hide").end().superfish("show");
                }, close = function(o) {
                    o.retainPath = $.inArray(this[0], o.$path) > -1;
                    this.superfish("hide");
                    if (!this.parents("." + o.hoverClass).length) {
                        o.onIdle.call(getMenu(this));
                        if (o.$path.length) {
                            $.proxy(over, o.$path)();
                        }
                    }
                }, out = function() {
                    var $this = $(this), o = getOptions($this);
                    if (ios) {
                        $.proxy(close, $this, o)();
                    } else {
                        clearTimeout(o.sfTimer);
                        o.sfTimer = setTimeout($.proxy(close, $this, o), o.delay);
                    }
                }, touchHandler = function(e) {
                    var $this = $(this), o = getOptions($this), $ul = $this.siblings(e.data.popUpSelector);
                    if (o.onHandleTouch.call($ul) === false) {
                        return this;
                    }
                    if ($ul.length > 0 && $ul.is(":hidden")) {
                        $this.one("click.superfish", false);
                        if (e.type === "MSPointerDown" || e.type === "pointerdown") {
                            $this.trigger("focus");
                        } else {
                            $.proxy(over, $this.parent("li"))();
                        }
                    }
                }, applyHandlers = function($menu, o) {
                    var targets = "li:has(" + o.popUpSelector + ")";
                    if ($.fn.hoverIntent && !o.disableHI) {
                        $menu.hoverIntent(over, out, targets);
                    } else {
                        $menu.on("mouseenter.superfish", targets, over).on("mouseleave.superfish", targets, out);
                    }
                    var touchevent = "MSPointerDown.superfish";
                    if (unprefixedPointerEvents) {
                        touchevent = "pointerdown.superfish";
                    }
                    if (!ios) {
                        touchevent += " touchend.superfish";
                    }
                    if (wp7) {
                        touchevent += " mousedown.superfish";
                    }
                    $menu.on("focusin.superfish", "li", over).on("focusout.superfish", "li", out).on(touchevent, "a", o, touchHandler);
                };
                return {
                    hide: function(instant) {
                        if (this.length) {
                            var $this = this, o = getOptions($this);
                            if (!o) {
                                return this;
                            }
                            var not = o.retainPath === true ? o.$path : "", $ul = $this.find("li." + o.hoverClass).add(this).not(not).removeClass(o.hoverClass).children(o.popUpSelector), speed = o.speedOut;
                            if (instant) {
                                $ul.show();
                                speed = 0;
                            }
                            o.retainPath = false;
                            if (o.onBeforeHide.call($ul) === false) {
                                return this;
                            }
                            $ul.stop(true, true).animate(o.animationOut, speed, (function() {
                                var $this = $(this);
                                o.onHide.call($this);
                            }));
                        }
                        return this;
                    },
                    show: function() {
                        var o = getOptions(this);
                        if (!o) {
                            return this;
                        }
                        var $this = this.addClass(o.hoverClass), $ul = $this.children(o.popUpSelector);
                        if (o.onBeforeShow.call($ul) === false) {
                            return this;
                        }
                        $ul.stop(true, true).animate(o.animation, o.speed, (function() {
                            o.onShow.call($ul);
                        }));
                        return this;
                    },
                    destroy: function() {
                        return this.each((function() {
                            var $this = $(this), o = $this.data("sfOptions"), $hasPopUp;
                            if (!o) {
                                return false;
                            }
                            $hasPopUp = $this.find(o.popUpSelector).parent("li");
                            clearTimeout(o.sfTimer);
                            toggleMenuClasses($this, o);
                            toggleAnchorClass($hasPopUp);
                            toggleTouchAction($this);
                            $this.off(".superfish").off(".hoverIntent");
                            $hasPopUp.children(o.popUpSelector).attr("style", (function(i, style) {
                                if (typeof style !== "undefined") {
                                    return style.replace(/display[^;]+;?/g, "");
                                }
                            }));
                            o.$path.removeClass(o.hoverClass + " " + c.bcClass).addClass(o.pathClass);
                            $this.find("." + o.hoverClass).removeClass(o.hoverClass);
                            o.onDestroy.call($this);
                            $this.removeData("sfOptions");
                        }));
                    },
                    init: function(op) {
                        return this.each((function() {
                            var $this = $(this);
                            if ($this.data("sfOptions")) {
                                return false;
                            }
                            var o = $.extend({}, $.fn.superfish.defaults, op), $hasPopUp = $this.find(o.popUpSelector).parent("li");
                            o.$path = setPathToCurrent($this, o);
                            $this.data("sfOptions", o);
                            toggleMenuClasses($this, o, true);
                            toggleAnchorClass($hasPopUp, true);
                            toggleTouchAction($this);
                            applyHandlers($this, o);
                            $hasPopUp.not("." + c.bcClass).superfish("hide", true);
                            o.onInit.call(this);
                        }));
                    }
                };
            }();
            $.fn.superfish = function(method, args) {
                if (methods[method]) {
                    return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
                } else if (typeof method === "object" || !method) {
                    return methods.init.apply(this, arguments);
                } else {
                    return $.error("Method " + method + " does not exist on jQuery.fn.superfish");
                }
            };
            $.fn.superfish.defaults = {
                popUpSelector: "ul,.sf-mega",
                hoverClass: "sfHover",
                pathClass: "overrideThisToUse",
                pathLevels: 1,
                delay: 800,
                animation: {
                    opacity: "show"
                },
                animationOut: {
                    opacity: "hide"
                },
                speed: "normal",
                speedOut: "fast",
                cssArrows: true,
                disableHI: false,
                onInit: $.noop,
                onBeforeShow: $.noop,
                onShow: $.noop,
                onBeforeHide: $.noop,
                onHide: $.noop,
                onIdle: $.noop,
                onDestroy: $.noop,
                onHandleTouch: $.noop
            };
        })(jQuery, window);
    }, (__unused_webpack_module, __webpack_exports__, __webpack_require__) => {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        __webpack_require__.d(__webpack_exports__, {
            default: () => __WEBPACK_DEFAULT_EXPORT__
        });
        var jquery_sticky__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(9);
        var jquery_sticky__WEBPACK_IMPORTED_MODULE_0___default = __webpack_require__.n(jquery_sticky__WEBPACK_IMPORTED_MODULE_0__);
        var $ = window.jQuery;
        var Sticky = {
            init: function init() {
                $("[data-stick]").each((function() {
                    var spacing = Number($(this).data("stick"));
                    $(this).sticky({
                        topSpacing: spacing,
                        zIndex: 30
                    });
                }));
            }
        };
        const __WEBPACK_DEFAULT_EXPORT__ = Sticky;
    }, (module, exports, __webpack_require__) => {
        var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;
        (function(factory) {
            if (true) {
                !(__WEBPACK_AMD_DEFINE_ARRAY__ = [ __webpack_require__(10) ], __WEBPACK_AMD_DEFINE_FACTORY__ = factory, 
                __WEBPACK_AMD_DEFINE_RESULT__ = typeof __WEBPACK_AMD_DEFINE_FACTORY__ === "function" ? __WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__) : __WEBPACK_AMD_DEFINE_FACTORY__, 
                __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
            } else {}
        })((function($) {
            var slice = Array.prototype.slice;
            var splice = Array.prototype.splice;
            var defaults = {
                topSpacing: 0,
                bottomSpacing: 0,
                className: "is-sticky",
                wrapperClassName: "sticky-wrapper",
                center: false,
                getWidthFrom: "",
                widthFromWrapper: true,
                responsiveWidth: false,
                zIndex: "auto"
            }, $window = $(window), $document = $(document), sticked = [], windowHeight = $window.height(), scroller = function() {
                var scrollTop = $window.scrollTop(), documentHeight = $document.height(), dwh = documentHeight - windowHeight, extra = scrollTop > dwh ? dwh - scrollTop : 0;
                for (var i = 0, l = sticked.length; i < l; i++) {
                    var s = sticked[i], elementTop = s.stickyWrapper.offset().top, etse = elementTop - s.topSpacing - extra;
                    s.stickyWrapper.css("height", s.stickyElement.outerHeight());
                    if (scrollTop <= etse) {
                        if (s.currentTop !== null) {
                            s.stickyElement.css({
                                width: "",
                                position: "",
                                top: "",
                                "z-index": ""
                            });
                            s.stickyElement.parent().removeClass(s.className);
                            s.stickyElement.trigger("sticky-end", [ s ]);
                            s.currentTop = null;
                        }
                    } else {
                        var newTop = documentHeight - s.stickyElement.outerHeight() - s.topSpacing - s.bottomSpacing - scrollTop - extra;
                        if (newTop < 0) {
                            newTop = newTop + s.topSpacing;
                        } else {
                            newTop = s.topSpacing;
                        }
                        if (s.currentTop !== newTop) {
                            var newWidth;
                            if (s.getWidthFrom) {
                                newWidth = $(s.getWidthFrom).width() || null;
                            } else if (s.widthFromWrapper) {
                                newWidth = s.stickyWrapper.width();
                            }
                            if (newWidth == null) {
                                newWidth = s.stickyElement.width();
                            }
                            s.stickyElement.css("width", newWidth).css("position", "fixed").css("top", newTop).css("z-index", s.zIndex);
                            s.stickyElement.parent().addClass(s.className);
                            if (s.currentTop === null) {
                                s.stickyElement.trigger("sticky-start", [ s ]);
                            } else {
                                s.stickyElement.trigger("sticky-update", [ s ]);
                            }
                            if (s.currentTop === s.topSpacing && s.currentTop > newTop || s.currentTop === null && newTop < s.topSpacing) {
                                s.stickyElement.trigger("sticky-bottom-reached", [ s ]);
                            } else if (s.currentTop !== null && newTop === s.topSpacing && s.currentTop < newTop) {
                                s.stickyElement.trigger("sticky-bottom-unreached", [ s ]);
                            }
                            s.currentTop = newTop;
                        }
                        var stickyWrapperContainer = s.stickyWrapper.parent();
                        var unstick = s.stickyElement.offset().top + s.stickyElement.outerHeight() >= stickyWrapperContainer.offset().top + stickyWrapperContainer.outerHeight() && s.stickyElement.offset().top <= s.topSpacing;
                        if (unstick) {
                            s.stickyElement.css("position", "absolute").css("top", "").css("bottom", 0).css("z-index", "");
                        } else {
                            s.stickyElement.css("position", "fixed").css("top", newTop).css("bottom", "").css("z-index", s.zIndex);
                        }
                    }
                }
            }, resizer = function() {
                windowHeight = $window.height();
                for (var i = 0, l = sticked.length; i < l; i++) {
                    var s = sticked[i];
                    var newWidth = null;
                    if (s.getWidthFrom) {
                        if (s.responsiveWidth) {
                            newWidth = $(s.getWidthFrom).width();
                        }
                    } else if (s.widthFromWrapper) {
                        newWidth = s.stickyWrapper.width();
                    }
                    if (newWidth != null) {
                        s.stickyElement.css("width", newWidth);
                    }
                }
            }, methods = {
                init: function(options) {
                    var o = $.extend({}, defaults, options);
                    return this.each((function() {
                        var stickyElement = $(this);
                        var stickyId = stickyElement.attr("id");
                        var wrapperId = stickyId ? stickyId + "-" + defaults.wrapperClassName : defaults.wrapperClassName;
                        var wrapper = $("<div></div>").attr("id", wrapperId).addClass(o.wrapperClassName);
                        stickyElement.wrapAll(wrapper);
                        var stickyWrapper = stickyElement.parent();
                        if (o.center) {
                            stickyWrapper.css({
                                width: stickyElement.outerWidth(),
                                marginLeft: "auto",
                                marginRight: "auto"
                            });
                        }
                        if (stickyElement.css("float") === "right") {
                            stickyElement.css({
                                float: "none"
                            }).parent().css({
                                float: "right"
                            });
                        }
                        o.stickyElement = stickyElement;
                        o.stickyWrapper = stickyWrapper;
                        o.currentTop = null;
                        sticked.push(o);
                        methods.setWrapperHeight(this);
                        methods.setupChangeListeners(this);
                    }));
                },
                setWrapperHeight: function(stickyElement) {
                    var element = $(stickyElement);
                    var stickyWrapper = element.parent();
                    if (stickyWrapper) {
                        stickyWrapper.css("height", element.outerHeight());
                    }
                },
                setupChangeListeners: function(stickyElement) {
                    if (window.MutationObserver) {
                        var mutationObserver = new window.MutationObserver((function(mutations) {
                            if (mutations[0].addedNodes.length || mutations[0].removedNodes.length) {
                                methods.setWrapperHeight(stickyElement);
                            }
                        }));
                        mutationObserver.observe(stickyElement, {
                            subtree: true,
                            childList: true
                        });
                    } else {
                        stickyElement.addEventListener("DOMNodeInserted", (function() {
                            methods.setWrapperHeight(stickyElement);
                        }), false);
                        stickyElement.addEventListener("DOMNodeRemoved", (function() {
                            methods.setWrapperHeight(stickyElement);
                        }), false);
                    }
                },
                update: scroller,
                unstick: function(options) {
                    return this.each((function() {
                        var that = this;
                        var unstickyElement = $(that);
                        var removeIdx = -1;
                        var i = sticked.length;
                        while (i-- > 0) {
                            if (sticked[i].stickyElement.get(0) === that) {
                                splice.call(sticked, i, 1);
                                removeIdx = i;
                            }
                        }
                        if (removeIdx !== -1) {
                            unstickyElement.unwrap();
                            unstickyElement.css({
                                width: "",
                                position: "",
                                top: "",
                                float: "",
                                "z-index": ""
                            });
                        }
                    }));
                }
            };
            if (window.addEventListener) {
                window.addEventListener("scroll", scroller, false);
                window.addEventListener("resize", resizer, false);
            } else if (window.attachEvent) {
                window.attachEvent("onscroll", scroller);
                window.attachEvent("onresize", resizer);
            }
            $.fn.sticky = function(method) {
                if (methods[method]) {
                    return methods[method].apply(this, slice.call(arguments, 1));
                } else if (typeof method === "object" || !method) {
                    return methods.init.apply(this, arguments);
                } else {
                    $.error("Method " + method + " does not exist on jQuery.sticky");
                }
            };
            $.fn.unstick = function(method) {
                if (methods[method]) {
                    return methods[method].apply(this, slice.call(arguments, 1));
                } else if (typeof method === "object" || !method) {
                    return methods.unstick.apply(this, arguments);
                } else {
                    $.error("Method " + method + " does not exist on jQuery.sticky");
                }
            };
            $((function() {
                setTimeout(scroller, 0);
            }));
        }));
    }, module => {
        "use strict";
        module.exports = jQuery;
    }, (__unused_webpack_module, __webpack_exports__, __webpack_require__) => {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        __webpack_require__.d(__webpack_exports__, {
            default: () => __WEBPACK_DEFAULT_EXPORT__
        });
        jQuery.extend(jQuery.expr[":"], {
            focusable: function focusable(el) {
                return jQuery(el).is("a, button, :input, [tabindex]");
            }
        });
        var FocusRedirect = {
            init: function init($) {
                $("[data-redirect-focus]").each((function() {
                    var $this = $(this);
                    var $focusable = $this.find(":focusable");
                    var $last = $focusable.last();
                    var $first = $focusable.first();
                    var $target = $($this.data("redirect-focus"));
                    $target.on("keydown", (function(ev) {
                        if ($this.is(":visible")) {
                            if (ev.which === 9 && !ev.shiftKey) {
                                ev.preventDefault();
                                $first.focus();
                            }
                            if (ev.which === 9 && ev.shiftKey) {
                                ev.preventDefault();
                                $last.focus();
                            }
                        }
                    }));
                    $last.on("keydown", (function(ev) {
                        if (ev.which === 9 && !ev.shiftKey && $target.is(":visible")) {
                            if ($target.is(":visible")) {
                                ev.preventDefault();
                                $target.focus();
                            }
                        }
                    }));
                    $first.on("keydown", (function(ev) {
                        if (ev.which === 9 && ev.shiftKey && $target.is(":visible")) {
                            ev.preventDefault();
                            $target.focus();
                        }
                    }));
                }));
            }
        };
        const __WEBPACK_DEFAULT_EXPORT__ = FocusRedirect;
    }, (__unused_webpack_module, __webpack_exports__, __webpack_require__) => {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
    }, (__unused_webpack_module, __webpack_exports__, __webpack_require__) => {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
    }, (__unused_webpack_module, __webpack_exports__, __webpack_require__) => {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
    }, (__unused_webpack_module, __webpack_exports__, __webpack_require__) => {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
    }, (__unused_webpack_module, __webpack_exports__, __webpack_require__) => {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
    }, (__unused_webpack_module, __webpack_exports__, __webpack_require__) => {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
    } ];
    var __webpack_module_cache__ = {};
    function __webpack_require__(moduleId) {
        var cachedModule = __webpack_module_cache__[moduleId];
        if (cachedModule !== undefined) {
            return cachedModule.exports;
        }
        var module = __webpack_module_cache__[moduleId] = {
            exports: {}
        };
        __webpack_modules__[moduleId](module, module.exports, __webpack_require__);
        return module.exports;
    }
    __webpack_require__.m = __webpack_modules__;
    (() => {
        var deferred = [];
        __webpack_require__.O = (result, chunkIds, fn, priority) => {
            if (chunkIds) {
                priority = priority || 0;
                for (var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
                deferred[i] = [ chunkIds, fn, priority ];
                return;
            }
            var notFulfilled = Infinity;
            for (var i = 0; i < deferred.length; i++) {
                var [chunkIds, fn, priority] = deferred[i];
                var fulfilled = true;
                for (var j = 0; j < chunkIds.length; j++) {
                    if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key => __webpack_require__.O[key](chunkIds[j])))) {
                        chunkIds.splice(j--, 1);
                    } else {
                        fulfilled = false;
                        if (priority < notFulfilled) notFulfilled = priority;
                    }
                }
                if (fulfilled) {
                    deferred.splice(i--, 1);
                    var r = fn();
                    if (r !== undefined) result = r;
                }
            }
            return result;
        };
    })();
    (() => {
        __webpack_require__.n = module => {
            var getter = module && module.__esModule ? () => module["default"] : () => module;
            __webpack_require__.d(getter, {
                a: getter
            });
            return getter;
        };
    })();
    (() => {
        __webpack_require__.d = (exports, definition) => {
            for (var key in definition) {
                if (__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
                    Object.defineProperty(exports, key, {
                        enumerable: true,
                        get: definition[key]
                    });
                }
            }
        };
    })();
    (() => {
        __webpack_require__.o = (obj, prop) => Object.prototype.hasOwnProperty.call(obj, prop);
    })();
    (() => {
        __webpack_require__.r = exports => {
            if (typeof Symbol !== "undefined" && Symbol.toStringTag) {
                Object.defineProperty(exports, Symbol.toStringTag, {
                    value: "Module"
                });
            }
            Object.defineProperty(exports, "__esModule", {
                value: true
            });
        };
    })();
    (() => {
        var installedChunks = {
            1: 0,
            7: 0,
            5: 0,
            8: 0,
            9: 0,
            6: 0,
            4: 0
        };
        __webpack_require__.O.j = chunkId => installedChunks[chunkId] === 0;
        var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
            var [chunkIds, moreModules, runtime] = data;
            var moduleId, chunkId, i = 0;
            if (chunkIds.some((id => installedChunks[id] !== 0))) {
                for (moduleId in moreModules) {
                    if (__webpack_require__.o(moreModules, moduleId)) {
                        __webpack_require__.m[moduleId] = moreModules[moduleId];
                    }
                }
                if (runtime) var result = runtime(__webpack_require__);
            }
            if (parentChunkLoadingFunction) parentChunkLoadingFunction(data);
            for (;i < chunkIds.length; i++) {
                chunkId = chunkIds[i];
                if (__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
                    installedChunks[chunkId][0]();
                }
                installedChunks[chunkIds[i]] = 0;
            }
            return __webpack_require__.O(result);
        };
        var chunkLoadingGlobal = self["webpackChunkwp_villar_theme"] = self["webpackChunkwp_villar_theme"] || [];
        chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
        chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
    })();
    __webpack_require__.O(undefined, [ 7, 5, 8, 9, 6, 4 ], (() => __webpack_require__(0)));
    __webpack_require__.O(undefined, [ 7, 5, 8, 9, 6, 4 ], (() => __webpack_require__(12)));
    __webpack_require__.O(undefined, [ 7, 5, 8, 9, 6, 4 ], (() => __webpack_require__(13)));
    __webpack_require__.O(undefined, [ 7, 5, 8, 9, 6, 4 ], (() => __webpack_require__(14)));
    __webpack_require__.O(undefined, [ 7, 5, 8, 9, 6, 4 ], (() => __webpack_require__(15)));
    __webpack_require__.O(undefined, [ 7, 5, 8, 9, 6, 4 ], (() => __webpack_require__(16)));
    var __webpack_exports__ = __webpack_require__.O(undefined, [ 7, 5, 8, 9, 6, 4 ], (() => __webpack_require__(17)));
    __webpack_exports__ = __webpack_require__.O(__webpack_exports__);
})();