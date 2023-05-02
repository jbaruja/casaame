(() => {
    var __webpack_exports__ = {};
    wp.customize.controlConstructor["villar-call-to-action"] = wp.customize.Control.extend({
        ready: function ready() {
            "use strict";
            jQuery(".villar-cta-button").on("click", (function() {
                var target = jQuery(this).data("target");
                if (target) {
                    wp.customize.section(target).focus();
                }
            }));
        }
    });
    wp.customize.controlConstructor["villar-sortable"] = wp.customize.Control.extend({
        ready: function ready() {
            "use strict";
            var control = this;
            control.sortableContainer = control.container.find("ul.sortable").first();
            control.sortableContainer.sortable({
                stop: function stop() {
                    control.updateValue();
                }
            }).disableSelection().find("li").each((function() {
                if (!jQuery(this).data("disabled")) {
                    jQuery(this).find("i.visibility").click((function() {
                        jQuery(this).toggleClass("dashicons-hidden").toggleClass("dashicons-visibility").parents("li:eq(0)").toggleClass("invisible");
                    }));
                }
            })).click((function() {
                control.updateValue();
            }));
        },
        updateValue: function updateValue() {
            "use strict";
            var control = this, newValue = [];
            this.sortableContainer.find("li").each((function() {
                if (!jQuery(this).is(".invisible")) {
                    newValue.push(jQuery(this).data("value"));
                }
            }));
            control.setting.set(newValue);
        }
    });
})();