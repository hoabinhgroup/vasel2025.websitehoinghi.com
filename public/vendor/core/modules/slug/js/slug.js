(() => {
    function e(e, a) {
        for (var l = 0; l < a.length; l++) {
            var t = a[l];
            (t.enumerable = t.enumerable || !1),
                (t.configurable = !0),
                "value" in t && (t.writable = !0),
                Object.defineProperty(e, t.key, t);
        }
    }
    var a = (function () {
        function a() {
            !(function (e, a) {
                if (!(e instanceof a))
                    throw new TypeError("Cannot call a class as a function");
            })(this, a);
        }
        var l, t;
        return (
            (l = a),
            (t = [
                {
                    key: "init",
                    value: function () {
                        $("#change_slug").on("click", function (e) {
                            $(".default-slug").unwrap();
                            var a = $("#editable-post-name");
                            a.html(
                                '<input type="text" id="new-post-slug" class="form-control" value="' +
                                    a.text() +
                                    '" autocomplete="off">'
                            ),
                                $("#edit-slug-box .cancel").show(),
                                $("#edit-slug-box .save").show(),
                                $(e.currentTarget).hide();
                        }),
                            $("#edit-slug-box .cancel").on(
                                "click",
                                function () {
                                    var e = $("#current-slug").val(),
                                        a = $("#sample-permalink");
                                    a.html(
                                        '<a class="permalink" href="' +
                                            $("#slug_id").data("view") +
                                            e.replace("/", "") +
                                            '">' +
                                            a.html() +
                                            "</a>"
                                    ),
                                        $("#editable-post-name").text(e),
                                        $("#edit-slug-box .cancel").hide(),
                                        $("#edit-slug-box .save").hide(),
                                        $("#change_slug").show();
                                }
                            );
                        var e = function (e, a, l) {
                            $.ajax({
                                url: $("#slug_id").data("url"),
                                type: "POST",
                                data: {
                                    name: e,
                                    slug_id: a,
                                    model: $("input[name=model]").val(),
                                },
                                success: function (e) {
                                    console.log("#slug_id", e);
                                    var a = $("#sample-permalink"),
                                        t = $("#slug_id");

                                    // var previewTest = $(".btn-preview")
                                    //     .prop("href")
                                    //     .split("/");
                                    // console.log("previewTest", previewTest);
                                    // var preview = $(".btn-preview").prop(
                                    //     "href",
                                    //     t.data("view") + e.replace("/", "")
                                    // );
                                    // console.log("preview", preview);
                                    l
                                        ? a
                                              .find(".permalink")
                                              .prop(
                                                  "href",
                                                  t.data("view") +
                                                      e.replace("/", "")
                                              )
                                        : a.html(
                                              '<a class="permalink" target="_blank" href="' +
                                                  t.data("view") +
                                                  e.replace("/", "") +
                                                  '">' +
                                                  a.html() +
                                                  "</a>"
                                          ),
                                        $(".page-url-seo p").text(
                                            t.data("view") + e.replace("/", "")
                                        ),
                                        $("#sample-permalink")
                                            .find(".default-slug")
                                            .html(
                                                t.data("view") +
                                                    '<span id="editable-post-name">' +
                                                    e +
                                                    "</span>"
                                            ),
                                        $("#editable-post-name").text(e),
                                        $("#current-slug").val(e),
                                        $("#edit-slug-box .cancel").hide(),
                                        $("#edit-slug-box .save").hide(),
                                        $("#change_slug").show(),
                                        $("#edit-slug-box").removeClass(
                                            "hidden"
                                        );
                                },
                                error: function (e) {
                                    console.log("error", e);
                                },
                            });
                        };
                        $("#edit-slug-box .save").on("click", function () {
                            var a = $("#new-post-slug"),
                                l = a.val(),
                                t = $("#slug_id").data("id");
                            null == t && (t = 0),
                                null != l && "" !== l
                                    ? e(l, t, !1)
                                    : a
                                          .closest(".form-group")
                                          .addClass("has-error");
                        }),
                            $("#name").blur(function () {
                                if ($("#edit-slug-box").hasClass("hidden")) {
                                    var a = $("#name").val();
                                    null !== a && "" !== a && e(a, 0, !0);
                                }
                            });
                    },
                },
            ]) && e(l.prototype, t),
            a
        );
    })();
    $(document).ready(function () {
        new a().init();
    });
})();
