// modules are defined as an array
// [ module function, map of requires ]
//
// map of requires is short require name -> numeric require
//
// anything defined in a previous bundle is accessed via the
// orig method which is the require for previous bundles

(function (modules, entry, mainEntry, parcelRequireName, globalName) {
  /* eslint-disable no-undef */
  var globalObject =
    typeof globalThis !== 'undefined'
      ? globalThis
      : typeof self !== 'undefined'
      ? self
      : typeof window !== 'undefined'
      ? window
      : typeof global !== 'undefined'
      ? global
      : {};
  /* eslint-enable no-undef */

  // Save the require from previous bundle to this closure if any
  var previousRequire =
    typeof globalObject[parcelRequireName] === 'function' &&
    globalObject[parcelRequireName];

  var cache = previousRequire.cache || {};
  // Do not use `require` to prevent Webpack from trying to bundle this call
  var nodeRequire =
    typeof module !== 'undefined' &&
    typeof module.require === 'function' &&
    module.require.bind(module);

  function newRequire(name, jumped) {
    if (!cache[name]) {
      if (!modules[name]) {
        // if we cannot find the module within our internal map or
        // cache jump to the current global require ie. the last bundle
        // that was added to the page.
        var currentRequire =
          typeof globalObject[parcelRequireName] === 'function' &&
          globalObject[parcelRequireName];
        if (!jumped && currentRequire) {
          return currentRequire(name, true);
        }

        // If there are other bundles on this page the require from the
        // previous one is saved to 'previousRequire'. Repeat this as
        // many times as there are bundles until the module is found or
        // we exhaust the require chain.
        if (previousRequire) {
          return previousRequire(name, true);
        }

        // Try the node require function if it exists.
        if (nodeRequire && typeof name === 'string') {
          return nodeRequire(name);
        }

        var err = new Error("Cannot find module '" + name + "'");
        err.code = 'MODULE_NOT_FOUND';
        throw err;
      }

      localRequire.resolve = resolve;
      localRequire.cache = {};

      var module = (cache[name] = new newRequire.Module(name));

      modules[name][0].call(
        module.exports,
        localRequire,
        module,
        module.exports,
        this
      );
    }

    return cache[name].exports;

    function localRequire(x) {
      var res = localRequire.resolve(x);
      return res === false ? {} : newRequire(res);
    }

    function resolve(x) {
      var id = modules[name][1][x];
      return id != null ? id : x;
    }
  }

  function Module(moduleName) {
    this.id = moduleName;
    this.bundle = newRequire;
    this.exports = {};
  }

  newRequire.isParcelRequire = true;
  newRequire.Module = Module;
  newRequire.modules = modules;
  newRequire.cache = cache;
  newRequire.parent = previousRequire;
  newRequire.register = function (id, exports) {
    modules[id] = [
      function (require, module) {
        module.exports = exports;
      },
      {},
    ];
  };

  Object.defineProperty(newRequire, 'root', {
    get: function () {
      return globalObject[parcelRequireName];
    },
  });

  globalObject[parcelRequireName] = newRequire;

  for (var i = 0; i < entry.length; i++) {
    newRequire(entry[i]);
  }

  if (mainEntry) {
    // Expose entry point to Node, AMD or browser globals
    // Based on https://github.com/ForbesLindesay/umd/blob/master/template.js
    var mainExports = newRequire(mainEntry);

    // CommonJS
    if (typeof exports === 'object' && typeof module !== 'undefined') {
      module.exports = mainExports;

      // RequireJS
    } else if (typeof define === 'function' && define.amd) {
      define(function () {
        return mainExports;
      });

      // <script>
    } else if (globalName) {
      this[globalName] = mainExports;
    }
  }
})({"hc0kI":[function(require,module,exports) {
var _userRoles = require("./modules/user-roles");
var _scrollToTop = require("./modules/scroll-to-top");
var _duplicateField = require("./modules/duplicate-field");
var _emailReports = require("./modules/email-reports");
jQuery(function($) {
    (0, _userRoles.UserRoles).setup();
    (0, _scrollToTop.ScrollToTop).setup();
    (0, _duplicateField.FieldDuplicator).setup();
    (0, _emailReports.EmailReports).setup();
});
document.addEventListener("DOMContentLoaded", function() {
    var download_csv = function download_csv(fileName, data) {
        var blob = new Blob([
            data
        ], {
            type: "text/csv"
        });
        var element = window.document.createElement("a");
        element.href = window.URL.createObjectURL(blob);
        element.download = fileName;
        document.body.appendChild(element);
        element.click();
        document.body.removeChild(element);
    };
    document.getElementById("iawp-export-views").addEventListener("click", function(e) {
        var button = e.target;
        button.textContent = IAWP_AJAX.exporting_views_text;
        button.setAttribute("disabled", "disabled");
        var data = {
            "action": "iawp_export_views",
            "iawp_export_views_nonce": IAWP_AJAX.export_views_nonce
        };
        jQuery.post(ajaxurl, data, function(response) {
            download_csv("exported-views.csv", response);
            button.textContent = IAWP_AJAX.export_views_text;
            button.removeAttribute("disabled");
        });
    });
    document.getElementById("iawp-export-referrers").addEventListener("click", function(e) {
        var button = e.target;
        button.textContent = IAWP_AJAX.exporting_referrers_text;
        button.setAttribute("disabled", "disabled");
        var data = {
            "action": "iawp_export_referrers",
            "iawp_export_referrers_nonce": IAWP_AJAX.export_referrers_nonce
        };
        jQuery.post(ajaxurl, data, function(response) {
            download_csv("exported-referrers.csv", response);
            button.textContent = IAWP_AJAX.export_referrers_text;
            button.removeAttribute("disabled");
        });
    });
    document.getElementById("iawp-export-geo").addEventListener("click", function(e) {
        var button = e.target;
        button.textContent = IAWP_AJAX.exporting_geo_text;
        button.setAttribute("disabled", "disabled");
        var data = {
            "action": "iawp_export_geo",
            "iawp_export_geo_nonce": IAWP_AJAX.export_geo_nonce
        };
        jQuery.post(ajaxurl, data, function(response) {
            download_csv("exported-geo.csv", response);
            button.textContent = IAWP_AJAX.export_geo_text;
            button.removeAttribute("disabled");
        });
    });
    var campaignExportButton = document.getElementById("iawp-export-campaigns");
    if (campaignExportButton) campaignExportButton.addEventListener("click", function(e) {
        var button = e.target;
        button.textContent = IAWP_AJAX.exporting_campaigns_text;
        button.setAttribute("disabled", "disabled");
        var data = {
            "action": "iawp_export_campaigns",
            "iawp_export_campaigns_nonce": IAWP_AJAX.export_campaigns_nonce
        };
        jQuery.post(ajaxurl, data, function(response) {
            download_csv("exported-campaigns.csv", response);
            button.textContent = IAWP_AJAX.export_campaigns_text;
            button.removeAttribute("disabled");
        });
    });
});

},{"./modules/user-roles":"9tr1c","./modules/scroll-to-top":"2cmwX","./modules/duplicate-field":"hCmns","./modules/email-reports":"fradw"}],"9tr1c":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
parcelHelpers.export(exports, "UserRoles", function() {
    return UserRoles;
});
var $ = jQuery;
var UserRoles = {
    setup: function setup() {
        var self = this;
        $("#user-role-select").on("change", function() {
            $(".role").removeClass("show");
            $(".role-" + $(this).val()).addClass("show");
        });
        $("#capabilities-form").on("submit", function(e) {
            e.preventDefault();
            self.save();
        });
    },
    save: function save() {
        $("#save-permissions").addClass("saving");
        var capabilities = {};
        $(".role").each(function() {
            var role = $(this).find("select").attr("name");
            var val = $(this).find("select").val();
            capabilities[role] = val;
        });
        capabilities = JSON.stringify(capabilities);
        var whiteLabel = $("#iawp_white_label").prop("checked");
        var data = {
            "action": "iawp_capabilities",
            "capabilities": capabilities,
            "white_label": whiteLabel,
            "iawp_capabilities_nonce": IAWP_AJAX.iawp_capabilities_nonce
        };
        jQuery.post(ajaxurl, data, function(response) {
            $("#save-permissions").removeClass("saving");
        });
    }
};

},{"@parcel/transformer-js/src/esmodule-helpers.js":"jIm8e"}],"jIm8e":[function(require,module,exports) {
exports.interopDefault = function(a) {
    return a && a.__esModule ? a : {
        default: a
    };
};
exports.defineInteropFlag = function(a) {
    Object.defineProperty(a, "__esModule", {
        value: true
    });
};
exports.exportAll = function(source, dest) {
    Object.keys(source).forEach(function(key) {
        if (key === "default" || key === "__esModule" || dest.hasOwnProperty(key)) return;
        Object.defineProperty(dest, key, {
            enumerable: true,
            get: function get() {
                return source[key];
            }
        });
    });
    return dest;
};
exports.export = function(dest, destName, get) {
    Object.defineProperty(dest, destName, {
        enumerable: true,
        get: get
    });
};

},{}],"2cmwX":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
parcelHelpers.export(exports, "ScrollToTop", function() {
    return ScrollToTop;
});
var $ = jQuery;
var ScrollToTop = {
    setup: function setup() {
        $("#scroll-to-top").on("click", function() {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
            $(this).blur();
        });
    }
};

},{"@parcel/transformer-js/src/esmodule-helpers.js":"jIm8e"}],"hCmns":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
parcelHelpers.export(exports, "FieldDuplicator", function() {
    return FieldDuplicator;
});
var $ = jQuery;
var FieldDuplicator = {
    setup: function setup() {
        var self = this;
        var duplicators = $(".duplicator");
        duplicators.each(function(index, duplicator) {
            $(this).find(".duplicate-button").on("click", function(e) {
                e.preventDefault();
                self.createNewEntry($(duplicator));
            });
        });
        var entries = $(".entry");
        entries.each(function() {
            self.attachRemoveEvent($(this));
        });
    },
    createNewEntry: function createNewEntry(duplicator) {
        var entryField = duplicator.find(".new-field");
        if (this.errorChecks(entryField)) return;
        var clone = duplicator.find(".blueprint .entry").clone();
        clone.find("input").val(entryField.val());
        duplicator.next().append(clone);
        if (entryField.hasClass("select")) entryField.find('option[value="' + entryField.val() + '"').remove();
        else entryField.val("");
        this.resetIndex(duplicator.next(".saved"));
        this.attachRemoveEvent(clone);
        duplicator.parents("form").removeClass("empty exists");
        this.hideNoneMessage(duplicator);
    },
    attachRemoveEvent: function attachRemoveEvent(entry) {
        var self = this;
        entry.find(".remove").on("click", function(e) {
            e.preventDefault();
            var saved = $(entry).parent(".saved");
            $(this).parents("form").addClass("unsaved");
            $(this).parent().remove();
            self.resetIndex(saved);
        });
    },
    resetIndex: function resetIndex(saved) {
        var count = 0;
        saved.find("input").each(function() {
            $(this).attr("name", $(this).attr("data-option") + "[" + count + "]");
            $(this).attr("id", $(this).attr("data-option") + "[" + count + "]");
            count++;
        });
        saved.parents("form").addClass("unsaved");
    },
    errorChecks: function(entryField) {
        if (entryField.val() == "") {
            entryField.parents("form").addClass("empty");
            return true;
        }
        var existingValues = [];
        entryField.parent().parent().next(".saved").find(".entry").each(function() {
            existingValues.push($(this).find("input").val());
        });
        if (existingValues.includes(entryField.val())) {
            entryField.parents("form").addClass("exists");
            return true;
        }
        return false;
    },
    hideNoneMessage: function hideNoneMessage(duplicator) {
        duplicator.parent().find(".none").hide();
    }
};

},{"@parcel/transformer-js/src/esmodule-helpers.js":"jIm8e"}],"fradw":[function(require,module,exports) {
var parcelHelpers = require("@parcel/transformer-js/src/esmodule-helpers.js");
parcelHelpers.defineInteropFlag(exports);
parcelHelpers.export(exports, "EmailReports", function() {
    return EmailReports;
});
var $ = jQuery;
var EmailReports = {
    setup: function setup() {
        $(".email-reports input").on("change", function() {
            $("#test-email").attr("disabled", true);
        });
        $("#test-email").on("click", function(e) {
            e.preventDefault();
            var data = {
                "action": "iawp_test_email",
                "iawp_test_email_nonce": IAWP_AJAX.iawp_test_email_nonce
            };
            $("#test-email").addClass("sending");
            jQuery.post(ajaxurl, data, function(response) {
                $("#test-email").removeClass("sending");
                if (response) $("#test-email").addClass("sent");
                else $("#test-email").addClass("failed");
                setTimeout(function() {
                    $("#test-email").removeClass("sent failed");
                }, 1000);
            });
        });
    }
};

},{"@parcel/transformer-js/src/esmodule-helpers.js":"jIm8e"}]},["hc0kI"], "hc0kI", "parcelRequirec571")

//# sourceMappingURL=settings.js.map
