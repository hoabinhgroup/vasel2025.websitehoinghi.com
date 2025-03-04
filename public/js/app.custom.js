$.ajaxSetup({
  headers: {
    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
  },
});
$(document).ready(function () {
  var $instance = $(this);

  // appAlert
  (function (define) {
    define(["jquery"], function ($) {
      return (function () {
        var appAlert = {
          info: info,
          success: success,
          warning: warning,
          error: error,
          options: {
            container: "body", // append alert on the selector
            duration: 0, // don't close automatically,
            showProgressBar: true, // duration must be set
            clearAll: true, //clear all previous alerts
            animate: true, //show animation
            heading: "",
            position: "bottom-right",
            bgColor: false,
            afterHidden: function () {},
            stack: 5,
          },
        };

        return appAlert;

        function info(message, options) {
          this._settings = _prepear_settings(options);
          this._settings.alertType = "info";
          _show(message);
          return "#" + this._settings.alertId;
        }

        function success(message, options) {
          this._settings = _prepear_settings(options);
          this._settings.alertType = "success";
          _show(message);
          return "#" + this._settings.alertId;
        }

        function warning(message, options) {
          this._settings = _prepear_settings(options);
          this._settings.alertType = "warning";
          _show(message);
          return "#" + this._settings.alertId;
        }

        function error(message, options) {
          this._settings = _prepear_settings(options);
          this._settings.alertType = "error";
          _show(message);
          return "#" + this._settings.alertId;
        }

        function showNotification(message, className, heading) {
          if (this._settings.heading) {
            heading = this._settings.heading;
          }

          $.toast({
            text: message, // Text that is to be shown in the toast
            heading: heading, // Optional heading to be shown on the toast
            icon: this._settings.alertType, // Type of toast icon
            showHideTransition: "fade", // fade, slide or plain
            allowToastClose: true, // Boolean value true or false
            hideAfter: this._settings.duration, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
            //bgColor : '#63779C',
            stack: this._settings.stack, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
            position: this._settings.position, // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values

            textAlign: "left",
            loader: true,
            loaderBg: "#9ec600",
            bgColor: this._settings.bgColor,
            beforeShow: function () {},
            afterShown: function () {},
            beforeHide: function () {},
            afterHidden: this._settings.afterHidden,
          });
        }

        function _template(message) {
          var className = "info";
          var heading = "Bạn có 1 thông tin";
          if (this._settings.alertType === "error") {
            className = "error";
            heading = "Có lỗi xảy ra";
          } else if (this._settings.alertType === "success") {
            className = "success";
            heading = "Thao tác thành công";
          } else if (this._settings.alertType === "warning") {
            className = "warning";
            heading = "Bạn có cảnh báo";
          }

          if (this._settings.animate) {
            className += " animate";
          }

          return showNotification(message, className, heading);

          /*  return '<div id="' + this._settings.alertId + '" class="app-alert alert alert-' + className + ' alert-dismissible " role="alert">'
                        + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                        + '<div class="app-alert-message">' + message + '</div>'
                        + '<div class="progress">'
                        + '<div class="progress-bar progress-bar-' + className + ' hide" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%">'
                        + '</div>'
                        + '</div>'
                        + '</div>';
                        */
        }

        function _prepear_settings(options) {
          if (!options) var options = {};
          options.alertId = "app-alert-" + _randomId();
          return (this._settings = $.extend({}, appAlert.options, options));
        }

        function _randomId() {
          var id = "";
          var keys = "abcdefghijklmnopqrstuvwxyz0123456789";
          for (var i = 0; i < 5; i++)
            id += keys.charAt(Math.floor(Math.random() * keys.length));
          return id;
        }

        function _clear() {
          if (this._settings.clearAll) {
            $("[role='alert']").remove();
          }
        }

        function _show(message) {
          // _clear();
          var container = $(this._settings.container);
          // console.log('_show',container.length);
          if (container.length) {
            $(this._settings.container).prepend(_template(message));
          } else {
            console.log("appAlert: container must be an html selector!");
          }
        }
      })();
    });
  })(function (d, f) {
    window["appAlert"] = f(window["jQuery"]);
  });

  (function (define) {
    define(["jquery"], function ($) {
      return (function () {
        var appLoader = {
          show: show,
          hide: hide,
          options: {
            container: "body",
            zIndex: "auto",
            css: "",
          },
        };

        return appLoader;

        function show(options) {
          var $template = $("#app-loader");
          this._settings = _prepear_settings(options);
          if (!$template.length) {
            var $container = $(this._settings.container);

            if ($container.length) {
              // console.log($container);

              $container.append(
                '<div id="app-loader"><div style="color: #79bbb5" class="la-ball-clip-rotate la-2x"><div></div></div></div>'
              );
              //  $container.append('<div id="app-loader" class="app-loader" style="z-index:' + this._settings.zIndex + ';' + this._settings.css + '"><div class="loading"></div></div>');
            } else {
              console.log("appLoader: container must be an html selector!");
            }
          }
        }

        function hide() {
          var $template = $("#app-loader");
          if ($template.length) {
            $template.remove();
          }
        }

        function _prepear_settings(options) {
          if (!options) var options = {};
          return (this._settings = $.extend({}, appLoader.options, options));
        }
      })();
    });
  })(function (d, f) {
    window["appLoader"] = f(window["jQuery"]);
  });

  $("body").on("click", "[data-act=ajax-modal]", function () {
    //alert();
    var data = { ajaxModal: 1 },
      multiCheckbox = $(this).attr("data-multi-checkbox"),
      url = $(this).attr("data-action-url"),
      isLargeModal = $(this).attr("data-modal-lg"),
      title = $(this).attr("data-title");
    if (!url) {
      console.log("Ajax Modal: Set data-action-url!");
      return false;
    }
    var widget = $(this).attr("data-post-element");
    if (widget) {
      var row_index = $(this).closest("row").index();
      var col_index = $(this).closest(".widget-column").index();
      var widget_index = $(this).parent().parent().index();
      var widget_element_id = $(this).parent().parent().attr("id");
      //console.log('widget_element_id',widget_element_id);
      $(this).attr(
        "data-post-element",
        widget.split("_")[0] +
          "_" +
          row_index +
          "_" +
          col_index +
          "_" +
          widget_index
      );
      $(this)
        .parent()
        .parent()
        .attr(
          "id",
          widget_element_id.split("_")[0] +
            "_" +
            widget_element_id.split("_")[1] +
            "_" +
            row_index +
            "_" +
            col_index +
            "_" +
            widget_index
        );
      // console.log('index', $(this).parent().parent().index());
      // console.log('row-index', $(this).closest('row').index());
    }
    if (title) {
      $("#ajaxModalTitle").html(title);
    } else {
      $("#ajaxModalTitle").html($("#ajaxModalTitle").attr("data-title"));
    }

    if (multiCheckbox) {
      var ids = [];
      $("input[name='table_checkbox[]']:checked").each(function () {
        var param = $(this).closest("tr").attr("id").split("_");
        var paramId = param[1];
        ids.push(paramId);
      });
      data.multi = ids;
      //console.log(data);
      if (ids.length == 0) {
        alert("Bạn cần chọn ít nhất 1 đối tượng!");
        return;
      }
    }

    $("#ajaxModalContent").html($("#ajaxModalOriginalContent").html());
    $("#ajaxModalContent")
      .find(".original-modal-body")
      .removeClass("original-modal-body")
      .addClass("modal-body");
    $("#ajaxModal").modal("show");

    $(this).each(function () {
      $.each(this.attributes, function () {
        if (this.specified && this.name.match("^data-post-")) {
          var dataName = this.name.replace("data-post-", "");
          data[dataName] = this.value;
        }
      });
    });
    //console.log("data modal", data);
    ajaxModalXhr = $.ajax({
      url: url,
      data: data,
      cache: false,
      type: "POST",
      success: function (response) {
        // console.log("response", response);
        $("#ajaxModal").find(".modal-dialog").removeClass("mini-modal");
        if (isLargeModal === "1") {
          $("#ajaxModal").find(".modal-dialog").addClass("modal-lg");
        } else if (isLargeModal === "2") {
          $("#ajaxModal").find(".modal-dialog").addClass("modal-slg");
        } else if (isLargeModal === "3") {
          $("#ajaxModal").find(".modal-dialog").addClass("modal-superlg");
        }
        $("#ajaxModalContent").html(response);
      },
      statusCode: {
        404: function () {
          $("#ajaxModalContent").find(".modal-body").html("");
          appAlert.error("404: Page not found.", {
            container: ".modal-body",
            animate: false,
          });
        },
      },
      error: function (response) {
        console.log(response);
        $("#ajaxModalContent").find(".modal-body").html("");
        appAlert.error("500: Internal Server Error.", {
          container: ".modal-body",
          animate: false,
        });
      },
    });
    return false;
  });

  $("body").on("click", "[data-act=ajax-modal-sub]", function () {
    //alert();
    var data = { ajaxModal: 1 },
      url = $(this).attr("data-action-url"),
      isLargeModal = $(this).attr("data-modal-lg"),
      title = $(this).attr("data-title");
    if (!url) {
      console.log("Ajax Modal: Set data-action-url!");
      return false;
    }
    if (title) {
      $("#ajaxModalTitleSub").html(title);
    } else {
      $("#ajaxModalTitleSub").html($("#ajaxModalTitleSub").attr("data-title"));
    }

    $("#ajaxModalContentSub").html($("#ajaxModalOriginalContentSub").html());
    $("#ajaxModalContentSub")
      .find(".original-modal-body")
      .removeClass("original-modal-body")
      .addClass("modal-body");
    $("#ajaxModalSub").modal("show");

    $(this).each(function () {
      $.each(this.attributes, function () {
        if (this.specified && this.name.match("^data-post-")) {
          var dataName = this.name.replace("data-post-", "");
          data[dataName] = this.value;
        }
      });
    });
    ajaxModalXhr = $.ajax({
      url: url,
      data: data,
      cache: false,
      type: "POST",
      success: function (response) {
        //console.log(response);
        $("#ajaxModalSub").find(".modal-dialog").removeClass("mini-modal");
        if (isLargeModal === "1") {
          $("#ajaxModalSub").find(".modal-dialog").addClass("modal-lg");
        }
        $("#ajaxModalContentSub").html(response);
      },
      statusCode: {
        404: function () {
          $("#ajaxModalContentSub").find(".modal-body").html("");
          appAlert.error("404: Page not found.", {
            container: ".modal-body",
            animate: false,
          });
        },
      },
      error: function () {
        $("#ajaxModalContentSub").find(".modal-body").html("");
        appAlert.error("500: Internal Server Error.", {
          container: ".modal-body",
          animate: false,
        });
      },
    });
    return false;
  });

  $(".modal").on("hidden.bs.modal", function () {
    $("#ajaxModal").find(".modal-dialog").removeClass("modal-lg");
  });

  //common ajax request
  $("body").on("click", "[data-act=ajax-request]", function () {
    var data = {},
      $selector = $(this),
      url = $selector.attr("data-action-url"),
      removeOnSuccess = $selector.attr("data-remove-on-success"),
      removeOnClick = $selector.attr("data-remove-on-click"),
      fadeOutOnSuccess = $selector.attr("data-fade-out-on-success"),
      fadeOutOnClick = $selector.attr("data-fade-out-on-click"),
      inlineLoader = $selector.attr("data-inline-loader"),
      reloadOnSuccess = $selector.attr("data-reload-on-success");

    var $target = "";
    if ($selector.attr("data-real-target")) {
      $target = $($selector.attr("data-real-target"));
    } else if ($selector.attr("data-closest-target")) {
      $target = $selector.closest($selector.attr("data-closest-target"));
    }

    if (!url) {
      console.log("Ajax Request: Set data-action-url!");
      return false;
    }

    if (removeOnClick) {
      $(removeOnClick).remove();
    }

    $selector.each(function () {
      $.each(this.attributes, function () {
        if (this.specified && this.name.match("^data-post-")) {
          var dataName = this.name.replace("data-post-", "");
          data[dataName] = this.value;
        }
      });
    });
    if (inlineLoader === "1") {
      $selector.addClass("inline-loader");
    } else {
      appLoader.show();
    }

    ajaxRequestXhr = $.ajax({
      url: url,
      data: data,
      cache: false,
      type: "POST",
      success: function (response) {
        if (reloadOnSuccess) {
          location.reload();
        }
        if (removeOnSuccess) {
          $(removeOnSuccess).remove();
        }

        //remove the target element with fade out effect
        if (fadeOutOnSuccess && $(fadeOutOnSuccess).length) {
          $(fadeOutOnSuccess).fadeOut(function () {
            $(this).remove();
          });
        }

        appLoader.hide();
        if ($target.length) {
          $target.html(response);
        }
      },
      statusCode: {
        404: function () {
          appLoader.hide();
          appAlert.error("404: Page not found.");
        },
      },
      error: function () {
        appLoader.hide();
        appAlert.error("500: Internal Server Error.");
      },
    });
  });

  $("body").on("click", '[data-toggle="ajax-tab"] a', function () {
    var loadurl = $(this).attr("href"),
      target = $(this).attr("data-target");
    // loader.show();
    //appLoader.show();
    $.get(loadurl, function (data) {
      // console.log(data);
      // loader.hide();
      $(target).siblings().removeClass("active");
      $(target).siblings().html("");
      $(target).addClass("active");
      $(target).html(data);

      // appLoader.hide();
    });
    $(this).tab("show");

    return false;
  });
  //auto load first tab
  $('[data-toggle="ajax-tab"] a').first().trigger("click");
});

function pushload(channel, event, eventCallback) {
  // Pusher.logToConsole = true;

  var pusher = new Pusher("1cd666378b59f02de83e", {
    cluster: "ap1",
    forceTLS: true,
  });

  var channel = pusher.subscribe(channel);
  channel.bind(event, eventCallback);
}
