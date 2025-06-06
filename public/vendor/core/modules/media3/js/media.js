! function(e) {
	var t = {};

	function a(i) {
		if (t[i]) return t[i].exports;
		var n = t[i] = {
			i: i,
			l: !1,
			exports: {}
		};
		return e[i].call(n.exports, n, n.exports, a), n.l = !0, n.exports
	}
	a.m = e, a.c = t, a.d = function(e, t, i) {
		a.o(e, t) || Object.defineProperty(e, t, {
			enumerable: !0,
			get: i
		})
	}, a.r = function(e) {
		"undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, {
			value: "Module"
		}), Object.defineProperty(e, "__esModule", {
			value: !0
		})
	}, a.t = function(e, t) {
		if (1 & t && (e = a(e)), 8 & t) return e;
		if (4 & t && "object" == typeof e && e && e.__esModule) return e;
		var i = Object.create(null);
		if (a.r(i), Object.defineProperty(i, "default", {
				enumerable: !0,
				value: e
			}), 2 & t && "string" != typeof e)
			for (var n in e) a.d(i, n, function(t) {
				return e[t]
			}.bind(null, n));
		return i
	}, a.n = function(e) {
		var t = e && e.__esModule ? function() {
			return e.default
		} : function() {
			return e
		};
		return a.d(t, "a", t), t
	}, a.o = function(e, t) {
		return Object.prototype.hasOwnProperty.call(e, t)
	}, a.p = "/", a(a.s = 232)
}({
	1: function(e, t, a) {
		"use strict";
		a.d(t, "a", function() {
			return r
		});
		var i = a(4);

		function n(e, t) {
			for (var a = 0; a < t.length; a++) {
				var i = t[a];
				i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i)
			}
		}
		var r = function() {
			function e() {
				! function(e, t) {
					if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
				}(this, e)
			}
			var t, a, r;
			return t = e, r = [{
				key: "getUrlParam",
				value: function(e) {
					var t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : null;
					t || (t = window.location.search);
					var a = new RegExp("(?:[?&]|&)" + e + "=([^&]+)", "i"),
						i = t.match(a);
					return i && i.length > 1 ? i[1] : null
				}
			}, {
				key: "asset",
				value: function(e) {
					if ("//" === e.substring(0, 2) || "http://" === e.substring(0, 7) || "https://" === e.substring(0, 8)) return e;
					var t = "/" !== RV_MEDIA_URL.base_url.substr(-1, 1) ? RV_MEDIA_URL.base_url + "/" : RV_MEDIA_URL.base_url;
					return "/" === e.substring(0, 1) ? t + e.substring(1) : t + e
				}
			}, {
				key: "showAjaxLoading",
				value: function() {
					var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : $(".rv-media-main");
					e.addClass("on-loading").append($("#rv_media_loading").html())
				}
			}, {
				key: "hideAjaxLoading",
				value: function() {
					var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : $(".rv-media-main");
					e.removeClass("on-loading").find(".loading-wrapper").remove()
				}
			}, {
				key: "isOnAjaxLoading",
				value: function() {
					var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : $(".rv-media-items");
					return e.hasClass("on-loading")
				}
			}, {
				key: "jsonEncode",
				value: function(e) {
					return void 0 === e && (e = null), JSON.stringify(e)
				}
			}, {
				key: "jsonDecode",
				value: function(e, t) {
					if (!e) return t;
					if ("string" == typeof e) {
						var a;
						try {
							a = $.parseJSON(e)
						} catch (e) {
							a = t
						}
						return a
					}
					return e
				}
			}, {
				key: "getRequestParams",
				value: function() {
					return window.rvMedia.options && "modal" === window.rvMedia.options.open_in ? $.extend(!0, i.a.request_params, window.rvMedia.options || {}) : i.a.request_params
				}
			}, {
				key: "setSelectedFile",
				value: function(e) {
					void 0 !== window.rvMedia.options ? window.rvMedia.options.selected_file_id = e : i.a.request_params.selected_file_id = e
				}
			}, {
				key: "getConfigs",
				value: function() {
					return i.a
				}
			}, {
				key: "storeConfig",
				value: function() {
					localStorage.setItem("MediaConfig", e.jsonEncode(i.a))
				}
			}, {
				key: "storeRecentItems",
				value: function() {
					localStorage.setItem("RecentItems", e.jsonEncode(i.b))
				}
			}, {
				key: "addToRecent",
				value: function(e) {
					e instanceof Array ? _.each(e, function(e) {
						i.b.push(e)
					}) : (i.b.push(e), this.storeRecentItems())
				}
			}, {
				key: "getItems",
				value: function() {
					var e = [];
					return $(".js-media-list-title").each(function(t, a) {
						var i = $(a),
							n = i.data() || {};
						n.index_key = i.index(), e.push(n)
					}), e
				}
			}, {
				key: "getSelectedItems",
				value: function() {
					var e = [];
					return $(".js-media-list-title input[type=checkbox]:checked").each(function(t, a) {
						var i = $(a).closest(".js-media-list-title"),
							n = i.data() || {};
						n.index_key = i.index(), e.push(n)
					}), e
				}
			}, {
				key: "getSelectedFiles",
				value: function() {
					var e = [];
					return $(".js-media-list-title[data-context=file] input[type=checkbox]:checked").each(function(t, a) {
						var i = $(a).closest(".js-media-list-title"),
							n = i.data() || {};
						n.index_key = i.index(), e.push(n)
					}), e
				}
			}, {
				key: "getSelectedFolder",
				value: function() {
					var e = [];
					return $(".js-media-list-title[data-context=folder] input[type=checkbox]:checked").each(function(t, a) {
						var i = $(a).closest(".js-media-list-title"),
							n = i.data() || {};
						n.index_key = i.index(), e.push(n)
					}), e
				}
			}, {
				key: "isUseInModal",
				value: function() {
					return "select-files" === e.getUrlParam("media-action") || window.rvMedia && window.rvMedia.options && "modal" === window.rvMedia.options.open_in
				}
			}, {
				key: "resetPagination",
				value: function() {
					RV_MEDIA_CONFIG.pagination = {
						paged: 1,
						posts_per_page: 40,
						in_process_get_media: !1,
						has_more: !0
					}
				}
			}], (a = null) && n(t.prototype, a), r && n(t, r), e
		}()
	},
	125: function(e, t, a) {
		"use strict";
		a.r(t), a.d(t, "EditorService", function() {
			return l
		});
		var i = a(1),
			n = a(4),
			r = a(35);

		function o(e, t) {
			if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
		}

		function s(e, t) {
			for (var a = 0; a < t.length; a++) {
				var i = t[a];
				i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i)
			}
		}
		var l = function() {
				function e() {
					o(this, e)
				}
				var t, a, n;
				return t = e, n = [{
					key: "editorSelectFile",
					value: function(e) {
						var t = i.a.getUrlParam("CKEditor") || i.a.getUrlParam("CKEditorFuncNum");
						if (window.opener && t) {
							var a = _.first(e);
							window.opener.CKEDITOR.tools.callFunction(i.a.getUrlParam("CKEditorFuncNum"), a.full_url), window.opener && window.close()
						}
					}
				}], (a = null) && s(t.prototype, a), n && s(t, n), e
			}(),
			d = function e(t, a) {
				o(this, e), window.rvMedia = window.rvMedia || {};
				var s = $("body");
				a = $.extend(!0, {
					multiple: !0,
					type: "*",
					onSelectFiles: function(e, t) {}
				}, a);
				var l = function(e) {
					e.preventDefault();
					var t = $(e.currentTarget);
					$("#rv_media_modal").modal(), window.rvMedia.options = a, window.rvMedia.options.open_in = "modal", window.rvMedia.$el = t, n.a.request_params.filter = "everything", i.a.storeConfig();
					var o = window.rvMedia.$el.data("rv-media");
					void 0 !== o && o.length > 0 && (o = o[0], window.rvMedia.options = $.extend(!0, window.rvMedia.options, o || {}), void 0 !== o.selected_file_id ? window.rvMedia.options.is_popup = !0 : void 0 !== window.rvMedia.options.is_popup && (window.rvMedia.options.is_popup = void 0)), 0 === $("#rv_media_body .rv-media-container").length ? $("#rv_media_body").load(RV_MEDIA_URL.popup, function(e) {
						e.error && alert(e.message), $("#rv_media_body").removeClass("media-modal-loading").closest(".modal-content").removeClass("bb-loading"), $(document).find(".rv-media-container .js-change-action[data-type=refresh]").trigger("click"), r.a.destroyContext(), r.a.initContext()
					}) : $(document).find(".rv-media-container .js-change-action[data-type=refresh]").trigger("click")
				};
				"string" == typeof t ? s.off("click", t).on("click", t, l) : t.off("click").on("click", l)
			};
		window.RvMediaStandAlone = d, $(".js-insert-to-editor").off("click").on("click", function(e) {
			e.preventDefault();
			var t = i.a.getSelectedFiles();
			_.size(t) > 0 && l.editorSelectFile(t)
		}), $.fn.rvMedia = function(e) {
			var t = $(this);
			n.a.request_params.filter = "everything", $(document).find(".js-insert-to-editor").prop("disabled", "trash" === n.a.request_params.view_in), i.a.storeConfig(), new d(t, e)
		}
	},
	232: function(e, t, a) {
		e.exports = a(308)
	},
	308: function(e, t, a) {
		"use strict";
		a.r(t);
		var i = a(4),
			n = a(1),
			r = a(8),
			o = a(9),
			s = a(35);

		function l(e, t) {
			for (var a = 0; a < t.length; a++) {
				var i = t[a];
				i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i)
			}
		}
		var d = function() {
			function e() {
				! function(e, t) {
					if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
				}(this, e), this.group = {}, this.group.list = $("#rv_media_items_list").html(), this.group.tiles = $("#rv_media_items_tiles").html(), this.item = {}, this.item.list = $("#rv_media_items_list_element").html(), this.item.tiles = $("#rv_media_items_tiles_element").html(), this.$groupContainer = $(".rv-media-items")
			}
			var t, a, i;
			return t = e, (a = [{
				key: "renderData",
				value: function(e) {
					var t = arguments.length > 1 && void 0 !== arguments[1] && arguments[1],
						a = arguments.length > 2 && void 0 !== arguments[2] && arguments[2],
						i = this,
						r = n.a.getConfigs(),
						s = i.group[n.a.getRequestParams().view_type],
						l = n.a.getRequestParams().view_in;
					_.includes(["all_media", "public", "trash", "favorites", "recent"], l) || (l = "all_media"), s = s.replace(/__noItemIcon__/gi, RV_MEDIA_CONFIG.translations.no_item[l].icon || "").replace(/__noItemTitle__/gi, RV_MEDIA_CONFIG.translations.no_item[l].title || "").replace(/__noItemMessage__/gi, RV_MEDIA_CONFIG.translations.no_item[l].message || "");
					var d = $(s),
						c = d.find("ul");
					a && this.$groupContainer.find(".rv-media-grid ul").length > 0 && (c = this.$groupContainer.find(".rv-media-grid ul")), _.size(e.folders) > 0 || _.size(e.files) > 0 || a ? $(".rv-media-items").addClass("has-items") : $(".rv-media-items").removeClass("has-items"), _.forEach(e.folders, function(e) {
						var t = i.item[n.a.getRequestParams().view_type];
						t = t.replace(/__type__/gi, "folder").replace(/__id__/gi, e.id).replace(/__name__/gi, e.name || "").replace(/__size__/gi, "").replace(/__date__/gi, e.created_at || "").replace(/__thumb__/gi, '<i class="fa fa-folder"></i>');
						var a = $(t);
						_.forEach(e, function(e, t) {
							a.data(t, e)
						}), a.data("is_folder", !0), a.data("icon", r.icons.folder), c.append(a)
					}), _.forEach(e.files, function(e) {
						var t = i.item[n.a.getRequestParams().view_type];
						t = t.replace(/__type__/gi, "file").replace(/__id__/gi, e.id).replace(/__name__/gi, e.name || "").replace(/__size__/gi, e.size || "").replace(/__date__/gi, e.created_at || ""), t = "list" === n.a.getRequestParams().view_type ? t.replace(/__thumb__/gi, '<i class="' + e.icon + '"></i>') : t.replace(/__thumb__/gi, e.thumb ? '<img src="' + e.thumb + '" alt="' + e.name + '">' : '<i class="' + e.icon + '"></i>');
						var a = $(t);
						a.data("is_folder", !1), _.forEach(e, function(e, t) {
							a.data(t, e)
						}), c.append(a)
					}), !1 !== t && i.$groupContainer.empty(), a && this.$groupContainer.find(".rv-media-grid ul").length > 0 || i.$groupContainer.append(d), i.$groupContainer.find(".loading-wrapper").remove(), o.a.handleDropdown(), $(".js-media-list-title[data-id=" + e.selected_file_id + "]").trigger("click")
				}
			}]) && l(t.prototype, a), i && l(t, i), e
		}();

		function c(e, t) {
			for (var a = 0; a < t.length; a++) {
				var i = t[a];
				i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i)
			}
		}
		var u = function() {
			function e() {
				! function(e, t) {
					if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
				}(this, e), this.$detailsWrapper = $(".rv-media-main .rv-media-details"), this.descriptionItemTemplate = '<div class="rv-media-name"><p>__title__</p>__url__</div>', this.onlyFields = ["name", "full_url", "size", "mime_type", "created_at", "updated_at", "nothing_selected"]
			}
			var t, a, i;
			return t = e, (a = [{
				key: "renderData",
				value: function(e) {
					var t = this,
						a = this,
						i = "image" === e.type ? '<img src="' + e.full_url + '" alt="' + e.name + '">' : '<i class="' + e.icon + '"></i>',
						r = "",
						o = !1;
					_.forEach(e, function(e, t) {
						_.includes(a.onlyFields, t) && (_.includes(["size", "mime_type"], t) || (r += a.descriptionItemTemplate.replace(/__title__/gi, RV_MEDIA_CONFIG.translations[t]).replace(/__url__/gi, e ? "full_url" === t ? '<div class="input-group"><input id="file_details_url" type="text" value="' + e + '" class="form-control"><span class="input-group-prepend"><button class="btn btn-default js-btn-copy-to-clipboard" type="button" data-clipboard-target="#file_details_url" title="Copied"><img class="clippy" src="' + n.a.asset("/vendor/core/modules/media/images/clippy.svg") + '" width="13" alt="Copy to clipboard"></button></span></div>' : '<span title="' + e + '">' + e + "</span>" : ""), "full_url" === t && (o = !0)))
					}), a.$detailsWrapper.find(".rv-media-thumbnail").html(i), a.$detailsWrapper.find(".rv-media-description").html(r), o && (new Clipboard(".js-btn-copy-to-clipboard"), $(".js-btn-copy-to-clipboard").tooltip().on("mouseenter", function() {
						$(t).tooltip("hide")
					}).on("mouseleave", function() {
						$(t).tooltip("hide")
					}))
				}
			}]) && c(t.prototype, a), i && c(t, i), e
		}();

		function f(e, t) {
			for (var a = 0; a < t.length; a++) {
				var i = t[a];
				i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i)
			}
		}
		var p = function() {
			function e() {
				! function(e, t) {
					if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
				}(this, e), this.MediaList = new d, this.MediaDetails = new u, this.breadcrumbTemplate = $("#rv_media_breadcrumb_item").html()
			}
			var t, a, l;
			return t = e, l = [{
				key: "refreshFilter",
				value: function() {
					var e = $(".rv-media-container"),
						t = n.a.getRequestParams().view_in;
					"all_media" === t || n.a.getRequestParams().folder_id ? ($('.rv-media-actions .btn:not([data-type="refresh"]):not(label)').removeClass("disabled"), e.attr("data-allow-upload", "true")) : ($('.rv-media-actions .btn:not([data-type="refresh"]):not(label)').addClass("disabled"), e.attr("data-allow-upload", "false")), $(".rv-media-actions .btn.js-rv-media-change-filter-group").removeClass("disabled");
					var a = $('.rv-media-actions .btn[data-action="empty_trash"]');
					"trash" === t ? (a.removeClass("hidden").removeClass("disabled"), _.size(n.a.getItems()) || a.addClass("hidden").addClass("disabled")) : a.addClass("hidden"), s.a.destroyContext(), s.a.initContext(), e.attr("data-view-in", t)
				}
			}], (a = [{
				key: "getMedia",
				value: function() {
					var t = arguments.length > 0 && void 0 !== arguments[0] && arguments[0],
						a = arguments.length > 1 && void 0 !== arguments[1] && arguments[1],
						s = arguments.length > 2 && void 0 !== arguments[2] && arguments[2];
					if (void 0 !== RV_MEDIA_CONFIG.pagination) {
						if (RV_MEDIA_CONFIG.pagination.in_process_get_media) return;
						RV_MEDIA_CONFIG.pagination.in_process_get_media = !0
					}
					var l = this;
					l.getFileDetails({
						icon: "far fa-image",
						nothing_selected: ""
					});
					
					
					var d = n.a.getRequestParams();
					
					"recent" === d.view_in && (d.recent_items = i.b), d.is_popup = !0 === a || void 0, d.onSelectFiles = void 0, void 0 !== d.search && "" != d.search && void 0 !== d.selected_file_id && (d.selected_file_id = void 0), d.load_more_file = s, void 0 !== RV_MEDIA_CONFIG.pagination && (d.paged = RV_MEDIA_CONFIG.pagination.paged, d.posts_per_page = RV_MEDIA_CONFIG.pagination.posts_per_page), $.ajax({
						url: RV_MEDIA_URL.get_media,
						type: "GET",
						data: d,
						dataType: "json",
						beforeSend: function() {
							n.a.showAjaxLoading()
						},
						success: function(a) {
							console.log({a});
							l.MediaList.renderData(a.data, t, s), l.renderBreadcrumbs(a.data.breadcrumbs), e.refreshFilter(), o.a.renderActions(), void 0 !== RV_MEDIA_CONFIG.pagination && (void 0 !== RV_MEDIA_CONFIG.pagination.paged && (RV_MEDIA_CONFIG.pagination.paged += 1), void 0 !== RV_MEDIA_CONFIG.pagination.in_process_get_media && (RV_MEDIA_CONFIG.pagination.in_process_get_media = !1), void 0 !== RV_MEDIA_CONFIG.pagination.posts_per_page && a.data.files.length + a.data.folders.length < RV_MEDIA_CONFIG.pagination.posts_per_page && void 0 !== RV_MEDIA_CONFIG.pagination.has_more && (RV_MEDIA_CONFIG.pagination.has_more = !1))
						},
						complete: function() {
							n.a.hideAjaxLoading()
						},
						error: function(e) {
							r.a.handleError(e)
						}
					})
				}
			}, {
				key: "getFileDetails",
				value: function(e) {
					this.MediaDetails.renderData(e)
				}
			}, {
				key: "renderBreadcrumbs",
				value: function(e) {
					var t = this,
						a = $(".rv-media-breadcrumb .breadcrumb");
					a.find("li").remove(), _.each(e, function(e) {
						var i = t.breadcrumbTemplate;
						i = i.replace(/__name__/gi, e.name || "").replace(/__icon__/gi, e.icon ? '<i class="' + e.icon + '"></i>' : "").replace(/__folderId__/gi, e.id || 0), a.append($(i))
					}), $(".rv-media-container").attr("data-breadcrumb-count", _.size(e))
				}
			}]) && f(t.prototype, a), l && f(t, l), e
		}();

		function v(e, t) {
			for (var a = 0; a < t.length; a++) {
				var i = t[a];
				i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i)
			}
		}
		var m = function() {
			function e() {
				! function(e, t) {
					if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
				}(this, e), this.MediaService = new p, $("body").on("shown.bs.modal", "#modal_add_folder", function(e) {
					$(e.currentTarget).find(".form-add-folder input[type=text]").focus()
				})
			}
			var t, a, o;
			return t = e, o = [{
				key: "closeModal",
				value: function() {
					$(document).find("#modal_add_folder").modal("hide")
				}
			}], (a = [{
				key: "create",
				value: function(t) {
					var a = this;
					$.ajax({
						url: RV_MEDIA_URL.create_folder,
						type: "POST",
						data: {
							parent_id: n.a.getRequestParams().folder_id,
							name: t
						},
						dataType: "json",
						beforeSend: function() {
							n.a.showAjaxLoading()
						},
						success: function(t) {
							t.error ? r.a.showMessage("error", t.message, RV_MEDIA_CONFIG.translations.message.error_header) : (r.a.showMessage("success", t.message, RV_MEDIA_CONFIG.translations.message.success_header), n.a.resetPagination(), a.MediaService.getMedia(!0), e.closeModal())
						},
						complete: function() {
							n.a.hideAjaxLoading()
						},
						error: function(e) {
							r.a.handleError(e)
						}
					})
				}
			}, {
				key: "changeFolder",
				value: function(e) {
					i.a.request_params.folder_id = e, n.a.storeConfig(), this.MediaService.getMedia(!0)
				}
			}]) && v(t.prototype, a), o && v(t, o), e
		}();

		function h(e, t) {
			for (var a = 0; a < t.length; a++) {
				var i = t[a];
				i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i)
			}
		}
		var g = function() {
				function e() {
					! function(e, t) {
						if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
					}(this, e), this.$body = $("body"), this.dropZone = null, this.uploadUrl = RV_MEDIA_URL.upload_file, this.uploadProgressBox = $(".rv-upload-progress"), this.uploadProgressContainer = $(".rv-upload-progress .rv-upload-progress-table"), this.uploadProgressTemplate = $("#rv_media_upload_progress_item").html(), this.totalQueued = 1, this.MediaService = new p, this.totalError = 0
				}
				var t, a, i;
				return t = e, i = [{
					key: "formatFileSize",
					value: function(e) {
						var t = arguments.length > 1 && void 0 !== arguments[1] && arguments[1],
							a = t ? 1e3 : 1024;
						if (Math.abs(e) < a) return e + " B";
						var i = ["KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"],
							n = -1;
						do {
							e /= a, ++n
						} while (Math.abs(e) >= a && n < i.length - 1);
						return e.toFixed(1) + " " + i[n]
					}
				}], (a = [{
					key: "init",
					value: function() {
						_.includes(RV_MEDIA_CONFIG.permissions, "files.create") && $(".rv-media-items").length > 0 && this.setupDropZone(), this.handleEvents()
					}
				}, {
					key: "setupDropZone",
					value: function() {
						var e = this;
						e.dropZone = new Dropzone(document.querySelector(".rv-media-items"), {
							url: e.uploadUrl,
							thumbnailWidth: !1,
							thumbnailHeight: !1,
							parallelUploads: 1,
							autoQueue: !0,
							clickable: ".js-dropzone-upload",
							previewTemplate: !1,
							previewsContainer: !1,
							uploadMultiple: !0,
							sending: function(e, t, a) {
								a.append("_token", $('meta[name="csrf-token"]').attr("content")), a.append("folder_id", n.a.getRequestParams().folder_id), a.append("view_in", n.a.getRequestParams().view_in)
							}
						}), e.dropZone.on("addedfile", function(t) {
							t.index = e.totalQueued, e.totalQueued++
						}), e.dropZone.on("sending", function(t) {
							e.initProgress(t.name, t.size)
						}), e.dropZone.on("complete", function(t) {
							e.changeProgressStatus(t)
						}), e.dropZone.on("queuecomplete", function() {
							n.a.resetPagination(), e.MediaService.getMedia(!0), 0 === e.totalError && setTimeout(function() {
								$(".rv-upload-progress .close-pane").trigger("click")
							}, 5e3)
						})
					}
				}, {
					key: "handleEvents",
					value: function() {
						var e = this;
						e.$body.off("click", ".rv-upload-progress .close-pane").on("click", ".rv-upload-progress .close-pane", function(t) {
							t.preventDefault(), $(".rv-upload-progress").addClass("hide-the-pane"), e.totalError = 0, setTimeout(function() {
								$(".rv-upload-progress li").remove(), e.totalQueued = 1
							}, 300)
						})
					}
				}, {
					key: "initProgress",
					value: function(t, a) {
						var i = this.uploadProgressTemplate.replace(/__fileName__/gi, t).replace(/__fileSize__/gi, e.formatFileSize(a)).replace(/__status__/gi, "warning").replace(/__message__/gi, "Uploading");
						this.uploadProgressContainer.append(i), this.uploadProgressBox.removeClass("hide-the-pane"), this.uploadProgressBox.find(".panel-body").animate({
							scrollTop: this.uploadProgressContainer.height()
						}, 150)
					}
				}, {
					key: "changeProgressStatus",
					value: function(e) {
						var t = this.uploadProgressContainer.find("li:nth-child(" + e.index + ")"),
							a = t.find(".label");
						a.removeClass("label-success label-danger label-warning");
						var i = n.a.jsonDecode(e.xhr.responseText || "", {});
						if (this.totalError = this.totalError + (!0 === i.error || "error" === e.status ? 1 : 0), a.addClass(!0 === i.error || "error" === e.status ? "label-danger" : "label-success"), a.html(!0 === i.error || "error" === e.status ? "Error" : "Uploaded"), "error" === e.status)
							if (422 === e.xhr.status) {
								var r = "";
								$.each(i.errors, function(e, t) {
									r += '<span class="text-danger">' + t + "</span><br>"
								}), t.find(".file-error").html(r)
							} else 500 === e.xhr.status && t.find(".file-error").html('<span class="text-danger">' + e.xhr.statusText + "</span>");
						else i.error ? t.find(".file-error").html('<span class="text-danger">' + i.message + "</span>") : (n.a.addToRecent(i.data.id), n.a.setSelectedFile(i.data.id))
					}
				}]) && h(t.prototype, a), i && h(t, i), e
			}(),
			y = a(125);

		function b(e, t) {
			for (var a = 0; a < t.length; a++) {
				var i = t[a];
				i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i)
			}
		}
		var w = function() {
			function e() {
				! function(e, t) {
					if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
				}(this, e), this.MediaService = new p, this.UploadService = new g, this.FolderService = new m, this.$body = $("body")
			}
			var t, a, r;
			return t = e, r = [{
				key: "setupSecurity",
				value: function() {
					$.ajaxSetup({
						headers: {
							"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
						}
					})
				}
			}], (a = [{
				key: "init",
				value: function() {
					n.a.resetPagination(), this.setupLayout(), this.handleMediaList(), this.changeViewType(), this.changeFilter(), this.search(), this.handleActions(), this.UploadService.init(), this.handleModals(), this.scrollGetMore()
				}
			}, {
				key: "setupLayout",
				value: function() {
					var e = $('.js-rv-media-change-filter[data-type="filter"][data-value="' + n.a.getRequestParams().filter + '"]');
					e.closest("li").addClass("active").closest(".dropdown").find(".js-rv-media-filter-current").html("(" + e.html() + ")");
					var t = $('.js-rv-media-change-filter[data-type="view_in"][data-value="' + n.a.getRequestParams().view_in + '"]');
					t.closest("li").addClass("active").closest(".dropdown").find(".js-rv-media-filter-current").html("(" + t.html() + ")"), n.a.isUseInModal() && $(".rv-media-footer").removeClass("hidden"), $('.js-rv-media-change-filter[data-type="sort_by"][data-value="' + n.a.getRequestParams().sort_by + '"]').closest("li").addClass("active");
					var a = $("#media_details_collapse");
					a.prop("checked", i.a.hide_details_pane || !1), setTimeout(function() {
						$(".rv-media-details").removeClass("hidden")
					}, 300), a.on("change", function(e) {
						e.preventDefault(), i.a.hide_details_pane = $(e.currentTarget).is(":checked"), n.a.storeConfig()
					}), $(document).off("click", "button[data-dismiss-modal]").on("click", "button[data-dismiss-modal]", function(e) {
						var t = $(e.currentTarget).data("dismiss-modal");
						$(t).modal("hide")
					})
				}
			}, {
				key: "handleMediaList",
				value: function() {
					var e = this,
						t = !1,
						a = !1,
						i = !1;
					$(document).on("keyup keydown", function(e) {
						t = e.ctrlKey, a = e.metaKey, i = e.shiftKey
					}), e.$body.off("click", ".js-media-list-title").on("click", ".js-media-list-title", function(r) {
						r.preventDefault();
						var s = $(r.currentTarget);
						if (i) {
							var l = _.first(n.a.getSelectedItems());
							if (l) {
								var d = l.index_key,
									c = s.index();
								$(".rv-media-items li").each(function(e, t) {
									e > d && e <= c && $(t).find("input[type=checkbox]").prop("checked", !0)
								})
							}
						} else t || a || s.closest(".rv-media-items").find("input[type=checkbox]").prop("checked", !1);
						s.find("input[type=checkbox]").prop("checked", !0), o.a.handleDropdown(), e.MediaService.getFileDetails(s.data())
					}).on("dblclick", ".js-media-list-title", function(t) {
						t.preventDefault();
						var a = $(t.currentTarget).data();
						if (!0 === a.is_folder) n.a.resetPagination(), e.FolderService.changeFolder(a.id);
						else if (n.a.isUseInModal()) {
							if ("trash" !== n.a.getConfigs().request_params.view_in) {
								var i = n.a.getSelectedFiles();
								_.size(i) > 0 && y.EditorService.editorSelectFile(i)
							}
						} else o.a.handlePreview()
					}).on("dblclick", ".js-up-one-level", function(e) {
						e.preventDefault();
						var t = $(".rv-media-breadcrumb .breadcrumb li").length;
						$(".rv-media-breadcrumb .breadcrumb li:nth-child(" + (t - 1) + ") a").trigger("click")
					}).on("contextmenu", ".js-context-menu", function(e) {
						$(e.currentTarget).find("input[type=checkbox]").is(":checked") || $(e.currentTarget).trigger("click")
					}).on("click contextmenu", ".rv-media-items", function(t) {
						_.size(t.target.closest(".js-context-menu")) || ($('.rv-media-items input[type="checkbox"]').prop("checked", !1), $(".rv-dropdown-actions").addClass("disabled"), e.MediaService.getFileDetails({
							icon: "far fa-image",
							nothing_selected: ""
						}))
					})
				}
			}, {
				key: "changeViewType",
				value: function() {
					var e = this;
					e.$body.off("click", ".js-rv-media-change-view-type .btn").on("click", ".js-rv-media-change-view-type .btn", function(t) {
						t.preventDefault();
						var a = $(t.currentTarget);
						a.hasClass("active") || (a.closest(".js-rv-media-change-view-type").find(".btn").removeClass("active"), a.addClass("active"), i.a.request_params.view_type = a.data("type"), "trash" === a.data("type") ? $(document).find(".js-insert-to-editor").prop("disabled", !0) : $(document).find(".js-insert-to-editor").prop("disabled", !1), n.a.storeConfig(), void 0 !== RV_MEDIA_CONFIG.pagination && void 0 !== RV_MEDIA_CONFIG.pagination.paged && (RV_MEDIA_CONFIG.pagination.paged = 1), e.MediaService.getMedia(!0, !1))
					}), $('.js-rv-media-change-view-type .btn[data-type="' + n.a.getRequestParams().view_type + '"]').trigger("click"), this.bindIntegrateModalEvents()
				}
			}, {
				key: "changeFilter",
				value: function() {
					var e = this;
					e.$body.off("click", ".js-rv-media-change-filter").on("click", ".js-rv-media-change-filter", function(t) {
						if (t.preventDefault(), !n.a.isOnAjaxLoading()) {
							var a = $(t.currentTarget),
								r = a.closest("ul"),
								o = a.data();
							i.a.request_params[o.type] = o.value, "view_in" === o.type && (i.a.request_params.folder_id = 0, "trash" === o.value ? $(document).find(".js-insert-to-editor").prop("disabled", !0) : $(document).find(".js-insert-to-editor").prop("disabled", !1)), a.closest(".dropdown").find(".js-rv-media-filter-current").html("(" + a.html() + ")"), n.a.storeConfig(), p.refreshFilter(), n.a.resetPagination(), e.MediaService.getMedia(!0), r.find("> li").removeClass("active"), a.closest("li").addClass("active")
						}
					})
				}
			}, {
				key: "search",
				value: function() {
					var e = this;
					$('.input-search-wrapper input[type="text"]').val(n.a.getRequestParams().search || ""), e.$body.off("submit", ".input-search-wrapper").on("submit", ".input-search-wrapper", function(t) {
						t.preventDefault(), i.a.request_params.search = $(t.currentTarget).find('input[type="text"]').val(), n.a.storeConfig(), n.a.resetPagination(), e.MediaService.getMedia(!0)
					})
				}
			}, {
				key: "handleActions",
				value: function() {
					var e = this;
					e.$body.off("click", '.rv-media-actions .js-change-action[data-type="refresh"]').on("click", '.rv-media-actions .js-change-action[data-type="refresh"]', function(t) {
						t.preventDefault(), n.a.resetPagination();
						var a = void 0 !== window.rvMedia.$el ? window.rvMedia.$el.data("rv-media") : void 0;
						void 0 !== a && a.length > 0 && void 0 !== a[0].selected_file_id ? e.MediaService.getMedia(!0, !0) : e.MediaService.getMedia(!0, !1)
					}).off("click", ".rv-media-items li.no-items").on("click", ".rv-media-items li.no-items", function(e) {
						e.preventDefault(), $(".rv-media-header .rv-media-top-header .rv-media-actions .js-dropzone-upload").trigger("click")
					}).off("submit", ".form-add-folder").on("submit", ".form-add-folder", function(t) {
						t.preventDefault();
						var a = $(t.currentTarget).find("input[type=text]"),
							i = a.val();
						return e.FolderService.create(i), a.val(""), !1
					}).off("click", ".js-change-folder").on("click", ".js-change-folder", function(t) {
						t.preventDefault();
						var a = $(t.currentTarget).data("folder");
						n.a.resetPagination(), e.FolderService.changeFolder(a)
					}).off("click", ".js-files-action").on("click", ".js-files-action", function(t) {
						t.preventDefault(), o.a.handleGlobalAction($(t.currentTarget).data("action"), function() {
							n.a.resetPagination(), e.MediaService.getMedia(!0)
						})
					})
				}
			}, {
				key: "handleModals",
				value: function() {
					var e = this;
					e.$body.on("show.bs.modal", "#modal_rename_items", function() {
						o.a.renderRenameItems()
					}), e.$body.off("submit", "#modal_rename_items .form-rename").on("submit", "#modal_rename_items .form-rename", function(t) {
						t.preventDefault();
						var a = [],
							i = $(t.currentTarget);
						$("#modal_rename_items .form-control").each(function(e, t) {
							var i = $(t),
								n = i.closest(".form-group").data();
							n.name = i.val(), a.push(n)
						}), o.a.processAction({
							action: i.data("action"),
							selected: a
						}, function(t) {
							t.error ? $("#modal_rename_items .form-group").each(function(e, a) {
								var i = $(a);
								_.includes(t.data, i.data("id")) ? i.addClass("has-error") : i.removeClass("has-error")
							}) : (i.closest(".modal").modal("hide"), e.MediaService.getMedia(!0))
						})
					}), e.$body.off("submit", ".form-delete-items").on("submit", ".form-delete-items", function(t) {
						t.preventDefault();
						var a = [],
							i = $(t.currentTarget);
						_.each(n.a.getSelectedItems(), function(e) {
							a.push({
								id: e.id,
								is_folder: e.is_folder
							})
						}), o.a.processAction({
							action: i.data("action"),
							selected: a
						}, function(t) {
							i.closest(".modal").modal("hide"), t.error || e.MediaService.getMedia(!0)
						})
					}), e.$body.off("submit", "#modal_empty_trash .rv-form").on("submit", "#modal_empty_trash .rv-form", function(t) {
						t.preventDefault();
						var a = $(t.currentTarget);
						o.a.processAction({
							action: a.data("action")
						}, function() {
							a.closest(".modal").modal("hide"), e.MediaService.getMedia(!0)
						})
					}), "trash" === i.a.request_params.view_in ? $(document).find(".js-insert-to-editor").prop("disabled", !0) : $(document).find(".js-insert-to-editor").prop("disabled", !1), this.bindIntegrateModalEvents()
				}
			}, {
				key: "checkFileTypeSelect",
				value: function(e) {
					if (void 0 !== window.rvMedia.$el) {
						var t = _.first(e),
							a = window.rvMedia.$el.data("rv-media");
						if (void 0 !== a && void 0 !== a[0] && void 0 !== a[0].file_type && "undefined" !== t && "undefined" !== t.type) {
							if (!a[0].file_type.match(t.type)) return !1;
							if (void 0 !== a[0].ext_allowed && $.isArray(a[0].ext_allowed) && -1 == $.inArray(t.mime_type, a[0].ext_allowed)) return !1
						}
					}
					return !0
				}
			}, {
				key: "bindIntegrateModalEvents",
				value: function() {
					var e = $("#rv_media_modal"),
						t = this;
					e.off("click", ".js-insert-to-editor").on("click", ".js-insert-to-editor", function(a) {
						a.preventDefault();
						var i = n.a.getSelectedFiles();
						console.log('bindIntegrateModalEvents', i);
						_.size(i) > 0 && (window.rvMedia.options.onSelectFiles(i, window.rvMedia.$el), t.checkFileTypeSelect(i) && e.find(".close").trigger("click"))
					}), e.off("dblclick", ".js-media-list-title").on("dblclick", ".js-media-list-title", function(a) {
						if (a.preventDefault(), "trash" !== n.a.getConfigs().request_params.view_in) {
							var i = n.a.getSelectedFiles();
							_.size(i) > 0 && (window.rvMedia.options.onSelectFiles(i, window.rvMedia.$el), t.checkFileTypeSelect(i) && e.find(".close").trigger("click"))
						} else o.a.handlePreview()
					})
				}
			}, {
				key: "scrollGetMore",
				value: function() {
					var e = this;
					$(".rv-media-main .rv-media-items").bind("DOMMouseScroll mousewheel", function(t) {
						(t.originalEvent.detail > 0 || t.originalEvent.wheelDelta < 0) && (($(t.currentTarget).closest(".media-modal").length > 0 ? $(t.currentTarget).scrollTop() + $(t.currentTarget).innerHeight() / 2 >= $(t.currentTarget)[0].scrollHeight - 450 : $(t.currentTarget).scrollTop() + $(t.currentTarget).innerHeight() >= $(t.currentTarget)[0].scrollHeight - 150) && void 0 !== RV_MEDIA_CONFIG.pagination && RV_MEDIA_CONFIG.pagination.has_more && e.MediaService.getMedia(!1, !1, !0))
					})
				}
			}]) && b(t.prototype, a), r && b(t, r), e
		}();
		$(document).ready(function() {
			window.rvMedia = window.rvMedia || {}, w.setupSecurity(), (new w).init()
		})
	},
	35: function(e, t, a) {
		"use strict";
		a.d(t, "a", function() {
			return o
		});
		var i = a(9),
			n = a(1);

		function r(e, t) {
			for (var a = 0; a < t.length; a++) {
				var i = t[a];
				i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i)
			}
		}
		var o = function() {
			function e() {
				! function(e, t) {
					if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
				}(this, e)
			}
			var t, a, o;
			return t = e, o = [{
				key: "initContext",
				value: function() {
					jQuery().contextMenu && ($.contextMenu({
						selector: '.js-context-menu[data-context="file"]',
						build: function() {
							return {
								items: e._fileContextMenu()
							}
						}
					}), $.contextMenu({
						selector: '.js-context-menu[data-context="folder"]',
						build: function() {
							return {
								items: e._folderContextMenu()
							}
						}
					}))
				}
			}, {
				key: "_fileContextMenu",
				value: function() {
					var e = {
						preview: {
							name: "Preview",
							icon: function(e, t, a, i) {
								return t.html('<i class="fa fa-eye" aria-hidden="true"></i> ' + i.name), "context-menu-icon-updated"
							},
							callback: function() {
								i.a.handlePreview()
							}
						}
					};
					_.each(n.a.getConfigs().actions_list, function(t, a) {
						_.each(t, function(t) {
							e[t.action] = {
								name: t.name,
								icon: function(e, i, n, r) {
									return i.html('<i class="' + t.icon + '" aria-hidden="true"></i> ' + (RV_MEDIA_CONFIG.translations.actions_list[a][t.action] || r.name)), "context-menu-icon-updated"
								},
								callback: function() {
									$('.js-files-action[data-action="' + t.action + '"]').trigger("click")
								}
							}
						})
					});
					var t = [];
					switch (n.a.getRequestParams().view_in) {
						case "all_media":
							t = ["remove_favorite", "delete", "restore"];
							break;
						case "recent":
							t = ["remove_favorite", "delete", "restore", "make_copy"];
							break;
						case "favorites":
							t = ["favorite", "delete", "restore", "make_copy"];
							break;
						case "trash":
							e = {
								preview: e.preview,
								rename: e.rename,
								download: e.download,
								delete: e.delete,
								restore: e.restore
							}
					}
					_.each(t, function(t) {
						e[t] = void 0
					}), n.a.getSelectedFolder().length > 0 && (e.preview = void 0, e.copy_link = void 0, _.includes(RV_MEDIA_CONFIG.permissions, "folders.create") || (e.make_copy = void 0), _.includes(RV_MEDIA_CONFIG.permissions, "folders.edit") || (e.rename = void 0), _.includes(RV_MEDIA_CONFIG.permissions, "folders.trash") || (e.trash = void 0, e.restore = void 0), _.includes(RV_MEDIA_CONFIG.permissions, "folders.destroy") || (e.delete = void 0), _.includes(RV_MEDIA_CONFIG.permissions, "folders.favorite") || (e.favorite = void 0, e.remove_favorite = void 0));
					var a = n.a.getSelectedFiles();
					a.length > 0 && (_.includes(RV_MEDIA_CONFIG.permissions, "files.create") || (e.make_copy = void 0), _.includes(RV_MEDIA_CONFIG.permissions, "files.edit") || (e.rename = void 0), _.includes(RV_MEDIA_CONFIG.permissions, "files.trash") || (e.trash = void 0, e.restore = void 0), _.includes(RV_MEDIA_CONFIG.permissions, "files.destroy") || (e.delete = void 0), _.includes(RV_MEDIA_CONFIG.permissions, "files.favorite") || (e.favorite = void 0, e.remove_favorite = void 0));
					var r = !1;
					return _.each(a, function(e) {
						_.includes(["image", "pdf", "text", "video"], e.type) && (r = !0)
					}), r || (e.preview = void 0), e
				}
			}, {
				key: "_folderContextMenu",
				value: function() {
					var t = e._fileContextMenu();
					return t.preview = void 0, t.copy_link = void 0, t
				}
			}, {
				key: "destroyContext",
				value: function() {
					jQuery().contextMenu && $.contextMenu("destroy")
				}
			}], (a = null) && r(t.prototype, a), o && r(t, o), e
		}()
	},
	4: function(e, t, a) {
		"use strict";
		a.d(t, "a", function() {
			return i
		}), a.d(t, "b", function() {
			return r
		});
		var i = $.parseJSON(localStorage.getItem("MediaConfig")) || {},
			n = {
				app_key: "483a0xyzytz1242c0d520426e8ba366c530c3d9d3xs",
				request_params: {
					view_type: "tiles",
					filter: "everything",
					view_in: "all_media",
					search: "",
					sort_by: "created_at-desc",
					folder_id: 0
				},
				hide_details_pane: !1,
				icons: {
					folder: "fa fa-folder"
				},
				actions_list: {
					basic: [{
						icon: "fa fa-eye",
						name: "Preview",
						action: "preview",
						order: 0,
						class: "rv-action-preview"
					}],
					file: [{
						icon: "fa fa-link",
						name: "Copy link",
						action: "copy_link",
						order: 0,
						class: "rv-action-copy-link"
					}, {
						icon: "far fa-edit",
						name: "Rename",
						action: "rename",
						order: 1,
						class: "rv-action-rename"
					}, {
						icon: "fa fa-copy",
						name: "Make a copy",
						action: "make_copy",
						order: 2,
						class: "rv-action-make-copy"
					}],
					user: [{
						icon: "fa fa-star",
						name: "Favorite",
						action: "favorite",
						order: 2,
						class: "rv-action-favorite"
					}, {
						icon: "fa fa-star",
						name: "Remove favorite",
						action: "remove_favorite",
						order: 3,
						class: "rv-action-favorite"
					}],
					other: [{
						icon: "fa fa-download",
						name: "Download",
						action: "download",
						order: 0,
						class: "rv-action-download"
					}, {
						icon: "fa fa-trash",
						name: "Move to trash",
						action: "trash",
						order: 1,
						class: "rv-action-trash"
					}, {
						icon: "fa fa-eraser",
						name: "Delete permanently",
						action: "delete",
						order: 2,
						class: "rv-action-delete"
					}, {
						icon: "fa fa-undo",
						name: "Restore",
						action: "restore",
						order: 3,
						class: "rv-action-restore"
					}]
				}
			};
		i.app_key && i.app_key === n.app_key || (i = n);
		var r = $.parseJSON(localStorage.getItem("RecentItems")) || []
	},
	8: function(e, t, a) {
		"use strict";

		function i(e, t) {
			for (var a = 0; a < t.length; a++) {
				var i = t[a];
				i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i)
			}
		}
		a.d(t, "a", function() {
			return n
		});
		var n = function() {
			function e() {
				! function(e, t) {
					if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
				}(this, e)
			}
			var t, a, n;
			return t = e, n = [{
				key: "showMessage",
				value: function(e, t) {
					toastr.options = {
						closeButton: !0,
						progressBar: !0,
						positionClass: "toast-bottom-right",
						onclick: null,
						showDuration: 1e3,
						hideDuration: 1e3,
						timeOut: 1e4,
						extendedTimeOut: 1e3,
						showEasing: "swing",
						hideEasing: "linear",
						showMethod: "fadeIn",
						hideMethod: "fadeOut"
					};
					var a = "";
					switch (e) {
						case "error":
							a = RV_MEDIA_CONFIG.translations.message.error_header;
							break;
						case "success":
							a = RV_MEDIA_CONFIG.translations.message.success_header
					}
					toastr[e](t, a)
				}
			}, {
				key: "handleError",
				value: function(t) {
					void 0 === t.responseJSON || _.isArray(t.errors) ? void 0 !== t.responseJSON ? void 0 !== t.responseJSON.errors ? 422 === t.status && e.handleValidationError(t.responseJSON.errors) : void 0 !== t.responseJSON.message ? e.showMessage("error", t.responseJSON.message) : $.each(t.responseJSON, function(t, a) {
						$.each(a, function(t, a) {
							e.showMessage("error", a)
						})
					}) : e.showMessage("error", t.statusText) : e.handleValidationError(t.responseJSON.errors)
				}
			}, {
				key: "handleValidationError",
				value: function(t) {
					var a = "";
					$.each(t, function(e, t) {
						a += t + "<br />", $('*[name="' + e + '"]').addClass("field-has-error"), $('*[name$="[' + e + ']"]').addClass("field-has-error")
					}), e.showMessage("error", a)
				}
			}], (a = null) && i(t.prototype, a), n && i(t, n), e
		}()
	},
	9: function(e, t, a) {
		"use strict";
		a.d(t, "a", function() {
			return s
		});
		var i = a(4),
			n = a(1),
			r = a(8);

		function o(e, t) {
			for (var a = 0; a < t.length; a++) {
				var i = t[a];
				i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i)
			}
		}
		var s = function() {
			function e() {
				! function(e, t) {
					if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
				}(this, e)
			}
			var t, a, s;
			return t = e, s = [{
				key: "handleDropdown",
				value: function() {
					var t = _.size(n.a.getSelectedItems());
					e.renderActions(), t > 0 ? $(".rv-dropdown-actions").removeClass("disabled") : $(".rv-dropdown-actions").addClass("disabled")
				}
			}, {
				key: "handlePreview",
				value: function() {
					var e = [];
					_.each(n.a.getSelectedFiles(), function(t) {
						_.includes(["image", "pdf", "text", "video"], t.type) && (e.push({
							src: t.full_url
						}), i.b.push(t.id))
					}), _.size(e) > 0 ? ($.fancybox.open(e), n.a.storeRecentItems()) : this.handleGlobalAction("download")
				}
			}, {
				key: "handleCopyLink",
				value: function() {
					var e = "";
					_.each(n.a.getSelectedFiles(), function(t) {
						_.isEmpty(e) || (e += "\n"), e += t.full_url
					});
					var t = $(".js-rv-clipboard-temp");
					t.data("clipboard-text", e), new Clipboard(".js-rv-clipboard-temp", {
						text: function() {
							return e
						}
					}), r.a.showMessage("success", RV_MEDIA_CONFIG.translations.clipboard.success, RV_MEDIA_CONFIG.translations.message.success_header), t.trigger("click")
				}
			}, {
				key: "handleGlobalAction",
				value: function(t, a) {
					var i = [];
					switch (_.each(n.a.getSelectedItems(), function(e) {
							i.push({
								is_folder: e.is_folder,
								id: e.id,
								full_url: e.full_url
							})
						}), t) {
						case "rename":
							$("#modal_rename_items").modal("show").find("form.rv-form").data("action", t);
							break;
						case "copy_link":
							e.handleCopyLink();
							break;
						case "preview":
							e.handlePreview();
							break;
						case "trash":
							$("#modal_trash_items").modal("show").find("form.rv-form").data("action", t);
							break;
						case "delete":
							$("#modal_delete_items").modal("show").find("form.rv-form").data("action", t);
							break;
						case "empty_trash":
							$("#modal_empty_trash").modal("show").find("form.rv-form").data("action", t);
							break;
						case "download":
							var o = RV_MEDIA_URL.download,
								s = 0;
							_.each(n.a.getSelectedItems(), function(e) {
								_.includes(n.a.getConfigs().denied_download, e.mime_type) || (o += (0 === s ? "?" : "&") + "selected[" + s + "][is_folder]=" + e.is_folder + "&selected[" + s + "][id]=" + e.id, s++)
							}), o !== RV_MEDIA_URL.download ? window.open(o, "_blank") : r.a.showMessage("error", RV_MEDIA_CONFIG.translations.download.error, RV_MEDIA_CONFIG.translations.message.error_header);
							break;
						default:
							e.processAction({
								selected: i,
								action: t
							}, a)
					}
				}
			}, {
				key: "processAction",
				value: function(e) {
					var t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : null;
					console.log('processAction', e);
					$.ajax({
						url: RV_MEDIA_URL.global_actions,
						type: "POST",
						data: e,
						dataType: "json",
						beforeSend: function() {
							n.a.showAjaxLoading()
						},
						success: function(e) {
							n.a.resetPagination(), e.error ? r.a.showMessage("error", e.message, RV_MEDIA_CONFIG.translations.message.error_header) : r.a.showMessage("success", e.message, RV_MEDIA_CONFIG.translations.message.success_header), t && t(e)
						},
						complete: function() {
							n.a.hideAjaxLoading()
						},
						error: function(e) {
							console.log('processAction error', e);
							r.a.handleError(e)
						}
					})
				}
			}, {
				key: "renderRenameItems",
				value: function() {
					var e = $("#rv_media_rename_item").html(),
						t = $("#modal_rename_items .rename-items").empty();
					_.each(n.a.getSelectedItems(), function(a) {
						var i = e.replace(/__icon__/gi, a.icon || "fa fa-file").replace(/__placeholder__/gi, "Input file name").replace(/__value__/gi, a.name),
							n = $(i);
						n.data("id", a.id), n.data("is_folder", a.is_folder), n.data("name", a.name), t.append(n)
					})
				}
			}, {
				key: "renderActions",
				value: function() {
					var e = n.a.getSelectedFolder().length > 0,
						t = $("#rv_action_item").html(),
						a = 0,
						i = $(".rv-dropdown-actions .dropdown-menu");
					i.empty();
					var r = $.extend({}, !0, n.a.getConfigs().actions_list);
					e && (r.basic = _.reject(r.basic, function(e) {
						return "preview" === e.action
					}), r.file = _.reject(r.file, function(e) {
						return "copy_link" === e.action
					}), _.includes(RV_MEDIA_CONFIG.permissions, "folders.create") || (r.file = _.reject(r.file, function(e) {
						return "make_copy" === e.action
					})), _.includes(RV_MEDIA_CONFIG.permissions, "folders.edit") || (r.file = _.reject(r.file, function(e) {
						return _.includes(["rename"], e.action)
					}), r.user = _.reject(r.user, function(e) {
						return _.includes(["rename"], e.action)
					})), _.includes(RV_MEDIA_CONFIG.permissions, "folders.trash") || (r.other = _.reject(r.other, function(e) {
						return _.includes(["trash", "restore"], e.action)
					})), _.includes(RV_MEDIA_CONFIG.permissions, "folders.destroy") || (r.other = _.reject(r.other, function(e) {
						return _.includes(["delete"], e.action)
					})), _.includes(RV_MEDIA_CONFIG.permissions, "folders.favorite") || (r.other = _.reject(r.other, function(e) {
						return _.includes(["favorite", "remove_favorite"], e.action)
					})));
					var o = n.a.getSelectedFiles(),
						s = !1;
					_.each(o, function(e) {
						_.includes(["image", "pdf", "text", "video"], e.type) && (s = !0)
					}), s || (r.basic = _.reject(r.basic, function(e) {
						return "preview" === e.action
					})), o.length > 0 && (_.includes(RV_MEDIA_CONFIG.permissions, "files.create") || (r.file = _.reject(r.file, function(e) {
						return "make_copy" === e.action
					})), _.includes(RV_MEDIA_CONFIG.permissions, "files.edit") || (r.file = _.reject(r.file, function(e) {
						return _.includes(["rename"], e.action)
					})), _.includes(RV_MEDIA_CONFIG.permissions, "files.trash") || (r.other = _.reject(r.other, function(e) {
						return _.includes(["trash", "restore"], e.action)
					})), _.includes(RV_MEDIA_CONFIG.permissions, "files.destroy") || (r.other = _.reject(r.other, function(e) {
						return _.includes(["delete"], e.action)
					})), _.includes(RV_MEDIA_CONFIG.permissions, "files.favorite") || (r.other = _.reject(r.other, function(e) {
						return _.includes(["favorite", "remove_favorite"], e.action)
					}))), _.each(r, function(e, r) {
						_.each(e, function(e, o) {
							var s = !1;
							switch (n.a.getRequestParams().view_in) {
								case "all_media":
									_.includes(["remove_favorite", "delete", "restore"], e.action) && (s = !0);
									break;
								case "recent":
									_.includes(["remove_favorite", "delete", "restore", "make_copy"], e.action) && (s = !0);
									break;
								case "favorites":
									_.includes(["favorite", "delete", "restore", "make_copy"], e.action) && (s = !0);
									break;
								case "trash":
									_.includes(["preview", "delete", "restore", "rename", "download"], e.action) || (s = !0)
							}
							if (!s) {
								var l = t.replace(/__action__/gi, e.action || "").replace(/__icon__/gi, e.icon || "").replace(/__name__/gi, RV_MEDIA_CONFIG.translations.actions_list[r][e.action] || e.name);
								!o && a && (l = '<li role="separator" class="divider"></li>' + l), i.append(l)
							}
						}), e.length > 0 && a++
					})
				}
			}], (a = null) && o(t.prototype, a), s && o(t, s), e
		}()
	}
});