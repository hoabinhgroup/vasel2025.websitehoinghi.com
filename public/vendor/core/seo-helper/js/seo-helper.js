!function(e) {
    var t = {};

    function n(o) {
        if (t[o]) return t[o].exports;
        var r = t[o] = {
            i: o,
            l: !1,
            exports: {}
        };
        return e[o].call(r.exports, r, r.exports, n), r.l = !0, r.exports
    }
    n.m = e, n.c = t, n.d = function(e, t, o) {
        n.o(e, t) || Object.defineProperty(e, t, {
            enumerable: !0,
            get: o
        })
    }, n.r = function(e) {
        "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, {
            value: "Module"
        }), Object.defineProperty(e, "__esModule", {
            value: !0
        })
    }, n.t = function(e, t) {
        if (1 & t && (e = n(e)), 8 & t) return e;
        if (4 & t && "object" == typeof e && e && e.__esModule) return e;
        var o = Object.create(null);
        if (n.r(o), Object.defineProperty(o, "default", {
                enumerable: !0,
                value: e
            }), 2 & t && "string" != typeof e)
            for (var r in e) n.d(o, r, function(t) {
                return e[t]
            }.bind(null, r));
        return o
    }, n.n = function(e) {
        var t = e && e.__esModule ? function() {
            return e.default
        } : function() {
            return e
        };
        return n.d(t, "a", t), t
    }, n.o = function(e, t) {
        return Object.prototype.hasOwnProperty.call(e, t)
    }, n.p = "/", n(n.s = 247)
}({
    247: function(e, t, n) {
        e.exports = n(248)
    },
    248: function(e, t) {
        function n(e, t) {
            for (var n = 0; n < t.length; n++) {
                var o = t[n];
                o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, o.key, o)
            }
        }
        var o = function() {
            function e() {
                ! function(e, t) {
                    if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
                }(this, e), this.$document = $(document)
            }
            var t, o, r;
            return t = e, r = [{
                key: "updateSEOTitle",
                value: function(e) {
                    e ? ($("#seo_title").val() || $(".page-title-seo").text(e), $(".default-seo-description").addClass("hidden"), $(".existed-seo-meta").removeClass("hidden")) : ($(".default-seo-description").removeClass("hidden"), $(".existed-seo-meta").addClass("hidden"))
                }
            }, {
                key: "updateSEODescription",
                value: function(e) {
                    e && ($("#seo_description").val() || $(".page-description-seo").text(e))
                }
            }], (o = [{
                key: "handleMetaBox",
                value: function() {
                   
                     this.$document.on("click", ".btn-trigger-show-seo-detail", function(e) {
                        e.preventDefault(), $(".seo-edit-section").toggleClass("hidden");
                         $(".page-url-seo p").text('http://' + window.location.hostname + '/' + $("input[name=slug]").val());
                    }), this.$document.on("keyup", "input[name=name]", function(t) {
                        e.updateSEOTitle($(t.currentTarget).val())
                    }), this.$document.on("keyup", "input[name=title]", function(t) {
                        e.updateSEOTitle($(t.currentTarget).val())
                    }), this.$document.on("keyup", "textarea[name=description]", function(t) {
                        e.updateSEODescription($(t.currentTarget).val())
                    }), this.$document.on("keyup", "#seo_title", function(e) {
                        if ($(e.currentTarget).val()) $(".page-title-seo").text($(e.currentTarget).val()), $(".default-seo-description").addClass("hidden"), $(".existed-seo-meta").removeClass("hidden");
                        else {
                            var t = $("input[name=name]");
                            t.val() ? $(".page-title-seo").text(t.val()) : $(".page-title-seo").text($("input[name=title]").val())
                        }
                    }), this.$document.on("keyup", "#seo_description", function(e) {
                        $(e.currentTarget).val() ? $(".page-description-seo").text($(e.currentTarget).val()) : $(".page-description-seo").text($("textarea[name=description]").val())
                    })
                }
            }]) && n(t.prototype, o), r && n(t, r), e
        }();
        $(document).ready(function() {
            (new o).handleMetaBox()
        })
    }
});