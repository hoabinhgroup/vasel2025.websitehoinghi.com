! function(e) {
    var n = {};
    

    function t(o) {
        if (n[o]) return n[o].exports;
        var r = n[o] = {
            i: o,
            l: !1,
            exports: {}
        };
        return e[o].call(r.exports, r, r.exports, t), r.l = !0, r.exports
    }
    t.m = e, t.c = n, t.d = function(e, n, o) {
        t.o(e, n) || Object.defineProperty(e, n, {
            enumerable: !0,
            get: o
        })
    }, t.r = function(e) {
        "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, {
            value: "Module"
        }), Object.defineProperty(e, "__esModule", {
            value: !0
        })
    }, t.t = function(e, n) {
        if (1 & n && (e = t(e)), 8 & n) return e;
        if (4 & n && "object" == typeof e && e && e.__esModule) return e;
        var o = Object.create(null);
        if (t.r(o), Object.defineProperty(o, "default", {
                enumerable: !0,
                value: e
            }), 2 & n && "string" != typeof e)
            for (var r in e) t.d(o, r, function(n) {
                return e[n]
            }.bind(null, r));
        return o
    }, t.n = function(e) {
        var n = e && e.__esModule ? function() {
            return e.default
        } : function() {
            return e
        };
        return t.d(n, "a", n), n
    }, t.o = function(e, n) {
        return Object.prototype.hasOwnProperty.call(e, n)
    }, t.p = "/", t(t.s = 131)
}({
    131: function(e, n, t) {
        e.exports = t(132)
    },
    132: function(e, n) {
        function t(e, n) {
            for (var t = 0; t < n.length; t++) {
                var o = n[t];
                o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, o.key, o)
            }
        }
        var o = function() {
            function e() {
                ! function(e, n) {
                    if (!(e instanceof n)) throw new TypeError("Cannot call a class as a function")
                }(this, e)
            }
            var n, o, r;
            return n = e, (o = [{
                key: "init",
                value: function() {
                    $("#plugin-list").on("click", ".btn-trigger-change-status", function(e) {
                        e.preventDefault();
                        var n = $(e.currentTarget);
                        n.addClass("button-loading"), $.ajax({
	                        headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							},
                            url: "appstore/plugins-change-status",
                            data: {
                                name: n.data("plugin")
                            },
                            type: "POST",
                            dataType: 'json',
                            success: function(e) {
	                            console.log(e);
	                                        
                                window.location.reload();
                               
                                n.removeClass("button-loading");
                            },
                            error: function(e) {
                                n.removeClass("button-loading");
                            }
                        })
                    }), $(document).on("click", ".btn-trigger-remove-plugin", function(e) {
                        e.preventDefault(), $("#confirm-remove-plugin-button").data("plugin", $(e.currentTarget).data("plugin")), $("#remove-plugin-modal").modal("show")
                    }), $(document).on("click", "#confirm-remove-plugin-button", function(e) {
                        e.preventDefault();
                        var n = $(e.currentTarget);
                        n.addClass("button-loading"), $.ajax({
	                        headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							},
                            url: "appstore/module-delete/" + n.data("plugin"),
                            type: "DELETE",
                            success: function(e) {
	                            console.log('e delete', e);
                                e.error ? appAlert.error(e.message) : (appAlert.success(e.message, {container: '.modal-body', duration: 3000}), window.location.reload()), n.removeClass("button-loading"), 
                                $("#remove-plugin-modal").modal("hide")
                            },
                            error: function(e) {
                                $("#remove-plugin-modal").modal("hide");
                            }
                        })
                    })
                }
            }]) && t(n.prototype, o), r && t(n, r), e
        }();
        $(document).ready(function() {
            (new o).init()
        })
    }
});