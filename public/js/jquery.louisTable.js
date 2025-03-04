$(document).ready(function () {
  (($) => {
    "use strict";
    const pluginName = "louisTable";
    var dataPlugin = "plugin_" + pluginName;
    var defaults = {
      url: "",
      dom: "",
      buttons: [],
      create_button: "",
      reload_button: false,
      searching: true,
      bulk_action: [],
      pagingType: "simple_numbers",
      tabbar: 0,
      data: [],
      sorting: [[1, "desc"]],
      columns: [],
      rowId: "id",
      limit: 10,
      filterAdvanced: false,
      filterDropdown: [],
      filterDateRange: false,
      maxPages: 7,
      selectors: {
        template: $("#customer"),
        list: $("#customer-list"),
        frmBulkAction: $("#form-bulk-action"),
        ckAll: $("#ck_All"),
      },
      modalHide: true,
      animateScrolltop: true,
      isModal: false,
      ajaxUrl: true,
      destroy: false,
      loading: true,
      sort: {},
      language: {},
      onAjaxSuccess: function () {},
      onInitComplete: function () {},
      onDrawCallback: function () {},
      footerCallback: function () {},
      onImportSuccess: function () {},
      onChosenSuccess: function () {},
      onComplete: function () {},
      onError: function () {},
      loadOnStart: true,
      onLoad: () => {},
    };

    // The actual plugin constructor
    function Plugin(element, options) {
      this.element = element;
      this.settings = $.extend({}, defaults, options);
      this._defaults = defaults;
      this._name = pluginName;
      this.page = 1;
      this.loading = true;
      this.reload = false;
      this.search = "";
      this.currentData = {};
      this.dataString = {};
      this.filterParams = [];
      this.init();
    }

    // Avoid Plugin.prototype conflicts
    $.extend(Plugin.prototype, {
      init() {
        const that = this;

        var url = window.location.href;

        if (that.settings.ajaxUrl) {
          var current = url.substring(url.lastIndexOf("/") + 1);
          if ($.isNumeric(current)) {
            that.page = current;
          }
        }

        that._buildCache();
        that._bindEvents();
      },
      _test() {
        alert(12);
      },
      onForward(callback) {
        this.onForward = callback; // setting the callback after initialization
      },
      _destroy() {
        this.unbindEvents();
        // $(this.element).unbind('.'+this._name);
        // $(this.element).removeData();
        this.$element.unbind("." + this._name);
        this.$element.removeData();
      },
      _buildCache() {
        this.$element = $(this.element);
      },
      _bindEvents() {
        const that = this;

        var btnBulkAction = $(".btn-bulk-action").parent();
        $(btnBulkAction).appendTo($(".custom-toolbar"));

        that.$element.parent().on("click", "a.anchor_tab", (e) => {
          that._anchorTab(e.currentTarget);
        });

        var $instanceWrapper = that.$element.closest(".dataTables_wrapper");
        // $instanceWrapper.prepend("<div class='extra_toolbar row'></div>");

        if (!that.emptyObject(that.settings.buttons["buttons"])) {
          $("<div class='buttons-table'></div>").appendTo($(".wrapper-action"));
          $.each(that.settings.buttons["buttons"], function (index, button) {
            if (typeof button == "string") {
              if (button == "reload") {
                that.settings.reload_button = true;
              }
            }

            if (typeof button == "object") {
              if (index == "create") {
                $(".buttons-table").append(
                  '<a href="' +
                    button["link"] +
                    '" class = "btn btn-danger mr-1 pull-left">' +
                    button["text"] +
                    "</a>"
                );
              } else {
                //console.log("button", button);

                if (button["buttons"] == undefined) {
                  var propertyLink = "";
                  $.each(button, function (key, value) {
                    if (key != "text") {
                      if (key == "link") {
                        key = "href";
                      }
                      propertyLink += ` ${key}="${value}" `;
                    }
                  });
                  // console.log("propertyLink", propertyLink);
                  $(".buttons-table").append(
                    `<a${propertyLink}> ${button["text"]} </a>`
                  );
                } else {
                  $.each(button["buttons"], function (key, value) {
                    var i;
                    var property = Object.getOwnPropertyNames(value);
                    for (i = 0; i <= property.length; i++) {
                      if (value.hasOwnProperty(property[i])) {
                        //var optionsLink += `${key}=` + value

                        $(".buttons-table").append(
                          '<a href="' +
                            value[property[i]]["link"] +
                            '" class = "' +
                            value[property[i]]["class"] +
                            '">' +
                            value[property[i]]["text"] +
                            "</a>"
                        );
                      }
                    }
                  });
                }
              }
            }
          });
        }
        
    
        if (
          that.settings.filterDropdown.length > 0 ||
          that.settings.filterDateRange
        ) {
          if(that.settings.filterAdvanced){
            var filter_button =
            '<a style="color: #fff;padding: 0px;border: 1px solid #BABFC7; height: 40px;" id="btn-show-extra-toolbar" class="btn btn-default btn-show-extra-toolbar ml-1"><img width="38"  src="/images/filter_advanced.png"> </a>';
          
          }
          //$(".custom-toolbar").append(filter_button);
        
          that.$element
            .parent()
            .find(".dataTables_filter")
            .parent()
            .append(filter_button);
            
         if(that.settings.filterAdvanced){   
          $("#btn-show-extra-toolbar").on("click", function () {
            that.showExtraToolbar();
          });
          }
        }

        if (that.settings.reload_button) {
          var reload_button = "";
          reload_button +=
            '<a href="javascript:void(0)" class= "btn btn-light mr-1 reload"> <i class="fa fa-refresh"></i> Reload </a>';

          $(".buttons-table").append(reload_button);

          $instanceWrapper.on("click", "a.reload", (e) => {
            console.log("that.$element", that.$element.prop("id"));
            // window.LaravelDataTables[$('#page-table')].row(that.$element.find('.ace[value="2"]').closest("tr")).remove();
            // that.$element.DataTable().rows().remove().draw();
            //that.$element.DataTable().row(that.$element.find('.ace[value="2"]').closest("tr")).remove().draw();
            that._load(e.currentTarget);
          });
        }


        if ($(that.settings.selectors.ckAll).length) {
          that.settings.selectors.ckAll.on("change", function () {
            var checkAllElement =
              document.getElementsByName("table_checkbox[]");
            var i,
              countAllCheckbox = [];
            if (document.getElementById("ck_All").checked) {
              for (i = 0; i < checkAllElement.length; i++) {
                checkAllElement[i].checked = true;
                if (checkAllElement[i].checked) {
                  countAllCheckbox.push(checkAllElement[i].value);
                }
              }
            } else {
              for (i = 0; i < checkAllElement.length; i++)
                checkAllElement[i].checked = false;
            }
            // $(".countSelected").text(countAllCheckbox.length);
          });
        }

        that.$element
          .closest(".table-responsive")
          .find("button[data-type='search']")
          .on("click", function (e) {
            that._search($(this).parent().children());
          });

        
        if (this.settings.loadOnStart) {
          this.load();
        }

        that.$element.find("tbody").on("click", "[data-action=chosen]", (e) => {
          that._chosenHandler(e.currentTarget);
        });

        that.$element.find("tbody").on("click", "[data-action=import]", (e) => {
          that._importHandler(e.currentTarget);
        });

        that.$element.find("thead").on("click", "[data-action=backup]", (e) => {
          that._backupHandler(e.currentTarget);
        });

        that.$element
          .find("tbody")
          .on("click", "[data-action=download]", (e) => {
            that._downloadHandler(e.currentTarget);
          });

        that.$element.find("tbody").on("click", "[data-action=delete]", (e) => {
          that._deleteHandler(e.currentTarget);
        });

        that.$element
          .find("tbody")
          .on("click", "[data-action=delete-confirmation]", (e) => {
            that._deleteConfirmationHandler(e.currentTarget, e);
          });

        // that.$element.closest("body").on("submit", "form", (e) => {
        //   that._onSubmit(e.currentTarget);
        // });

        // $("#broken_form").on("submit", (e) => {
        //   that._onSubmit(e.currentTarget);
        // });

        //         $(".custom-toolbar").append(
        //           '<div class="modal fade" id="ajaxModal" role="dialog" aria-labelledby="ajaxModal" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-blue-gradient white"><h4 class="modal-title" id="ajaxModalTitle"></h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div><div id="ajaxModalContent"></div><div id="ajaxModalOriginalContent" class="hide"><div class="original-modal-body"><div class="circle-loader"></div></div></div></div></div></div>'
        //         );
        //
        //         $("#broken_form").submit(function () {
        //           alert(123);
        //           event.preventDefault();
        //         });

        $("body").on("click", "[data-action=reload]", (e) => {
          that._load();
        });

        var checkboxes = that.$element.find("input[name='table_checkbox[]']");
      },
      unbindEvents() {
        /*
                Unbind all events in our plugin's namespace that are attached
                to "this.$element".
            */
        this.$element.off("." + this._name);
      },
      _datepicker(picker) {
        const that = this;
        that.filterParams["start_date"] = picker.startDate.format("DD/MM/YYYY");
        that.filterParams["end_date"] = picker.endDate.format("DD/MM/YYYY");
        that._reload();
      },
      _change(e) {
        const that = this;
        that.filterParams[$(e).attr("name")] = $(e).val();
        that._reload();
        // console.log($(e).attr("name"));
      },
      _checkbox(e) {
        const that = this;

        if ($(e).is(":checked")) {
          that.filterParams[$(e).attr("name")] = $(e).val();
        } else {
          that.filterParams[$(e).attr("name")] = 0;
        }

        that.load();
        console.log($(e).attr("name"));
      },
      _onSubmit(e) {
        const that = this;
        event.preventDefault();

        var queryString = $(e).serializeArray();
        $.ajax({
          type: $(e).attr("method"),
          url: $(e).attr("action"),
          data: queryString,
          success: function (result) {
            $("#ajaxModal").modal("toggle");
            console.log("result _onSubmit", result);
            if (result.success || result.error === false) {
              that._load();
              appAlert.success(result.message, {
                container: "body",
                duration: 3000,
              });
            }
          },
          error: function (response) {
            console.log(response);
          },
        });
      },
      _changePage(o) {
        // const that = this;
        if (this.settings.animateScrolltop) {
          $("html, body").animate(
            {
              scrollTop: this.$element.parent().offset().top,
            },
            200
          );
        }
        var $target = $(o);
        console.log("target", $target);
        console.log(this);
        this.page = 1;
        this.filterParams["url"] = $target.attr("data");

        var current = this.filterParams["url"].substring(
          this.filterParams["url"].lastIndexOf("/") + 1
        );
        if ($.isNumeric(current)) {
          this.page = current;
        }
        this.load();
      },
      _reloadTable(e) {
        //location.reload();
        this.load();
      },
      _deleteConfirmationHandler(e, event) {
        var alert = confirm("Bạn muốn xoá?");
        if (alert) {
          this._deleteHandler(e);
        }
        event.stopImmediatePropagation();
      },
      _deleteHandler(e) {
        const that = this;
        var $target = $(e),
          url = $target.attr("data-action-url"),
          id = $target.attr("data-post-id");
        $.ajax({
          url: url,
          type: "POST",
          dataType: "json",
          data: { id: id },
          success: function (result) {
            console.log(result);
            that.loading = false;
            that._load();
          },
          error: function (response) {
            console.log(response);
          },
        });
        return false;
      },
      showExtraToolbar() {
        $(".card_extra_toolbar").slideToggle();
        // $(".extra_toolbar").slideToggle();
        // $(".extra_toolbar").css('display', 'table');
      },
      _backupHandler(e) {
        const that = this;
        var $target = $(e),
          url = $target.attr("data-action-url");

        $.ajax({
          url: url,
          type: "POST",
          dataType: "json",
          data: {},
          success: function (result) {
            console.log("backuplist", result);
            that.loading = false;
            that.load();

            if (result.success) {
              var alertId = appAlert.success(result.message, {
                duration: 3000,
              });
            } else {
              appAlert.error(result.message, { duration: 3000 });
            }
          },
          error: function (response) {
            console.log(response);
          },
        });
        return false;
      },
      _downloadHandler(e) {
        const that = this;
        var $target = $(e),
          url = $target.attr("data-action-url"),
          id = $target.attr("data-post-id");

        $.ajax({
          url: url,
          type: "POST",
          dataType: "json",
          data: { id: id },
          success: function (result) {
            console.log("downloadlist", result);
            that.loading = false;
            that.load();

            if (result.success) {
              var alertId = appAlert.success(result.message, {
                duration: 3000,
              });
            } else {
              appAlert.error(result.message, { duration: 3000 });
            }
          },
          error: function (response) {
            console.log(response);
          },
        });
        return false;
      },
      _updateAward(customerId, adward) {
        $("#customer_" + customerId)
          .children("td")
          .eq(6)
          .text(adward);
      },
      _chosenHandler(e) {
        const that = this;
        console.log(that);

        var $target = $(e),
          url = $target.attr("data-action-url"),
          id = $target.attr("data-post-id"),
          customer_id = $target.attr("data-post-customer_id");

        var alert = confirm(
          "Báº¡n muá»‘n thÃªm dá»‹ch vá»¥ cho khÃ¡ch hÃ ng nÃ y?"
        );
        if (alert) {
          var queryString = { id: id, customer_id: customer_id };
          $.ajax({
            type: "POST",
            url: url,
            data: queryString,
            dataType: "json",
            success: function (result) {
              that.settings.onChosenSuccess(result);
              if (result.success) {
                var alertId = appAlert.success(result.message, {
                  duration: 3000,
                });
              } else {
                appAlert.error(result.message);
              }
            },
            error: function (response) {
              console.log(response);
            },
          });

          return false;
        }
      },
      _importHandler(e) {
        const that = this;

        var $target = $(e),
          url = $target.attr("data-action-url"),
          id = $target.attr("data-post-id");

        var alert = confirm(
          "Báº¡n muá»‘n import dá»¯ liá»‡u upload nÃ y vÃ o báº£ng khÃ¡ch hÃ ng?"
        );
        if (alert) {
          var queryString = { import_id: id };
          $.ajax({
            type: "POST",
            url: url,
            data: queryString,
            dataType: "json",
            success: function (result) {
              console.log("_importHandler", result);

              that.settings.onImportSuccess(result);
              if (result.success) {
                var alertId = appAlert.success(result.message, {
                  duration: 3000,
                });
              } else {
                appAlert.error(result.message, { duration: 3000 });
              }
              // $('.modal').modal('hide');
            },
            error: function (response) {
              console.log(response);
            },
          });
        }
      },
      _search(e) {
        event.preventDefault();
        console.log($(e).serializeArray());
        this.filterParams["keyword"] = $(e).serializeArray()[0]["value"];
        // this.filterParams['field'] = $(e).serializeArray()[1]['value'];
        this.filterParams["page"] = 1;
        this.load();
      },
      _apply(e) {
        event.preventDefault();

        this.filterParams["bulk_action"] = $(e).serializeArray()[0]["value"];
        //countAllCheckbox
        let countAllCheckbox = [];
        $("input[name='table_checkbox[]']:checked").each(function () {
          countAllCheckbox.push($(this).val());
        });

        if (countAllCheckbox.length <= 0) {
          // alert("Xin chọn ít nhất 1 đối tượng!");
          appAlert.error("Xin chọn ít nhất 1 đối tượng!", {
            container: "body",
            duration: 3000,
          });
        } else {
          this.filterParams["countAllCheckbox"] = countAllCheckbox;

          console.log("_apply", this.filterParams);
          if (this.filterParams["bulk_action"] == 0) {
            //alert("Bạn phải chọn 1 thao tác!");
            appAlert.error("Bạn phải chọn 1 thao tác!", {
              container: "body",
              duration: 3000,
            });
          } else if (this.filterParams["bulk_action"] == "delete") {
            var alert = confirm("Bạn muốn xóa?");
            if (alert) {
              this.filterParams["bulk_action"] == "delete";
              this._load();
            } else {
              this.filterParams["bulk_action"] = "";
            }
          } else {
            appAlert.success("Áp dụng thành công!", {
              container: "body",
              duration: 3000,
            });
            this._load();
          }
        }
      },
      _anchorTab(e) {
        const that = this;
        var $target = $(e),
          key = $target.attr("data-action"),
          value = $target.attr("data-post-key");
        that.filterParams[key] = value;
        that._load();
      },
      _bindSelectButtons() {
        const that = this;
        $("." + this.element.id + "BtnSelectAll").click(() => {
          that._selectAll();
        });
        $("." + this.element.id + "BtnSelectNone").click(() => {
          that._selectNone();
        });
      },
      _selectAll() {
        if (this.loading) {
          return;
        }
        $("." + this.element.id + "Checkbox").prop("checked", true);
      },
      _filter(data) {
        this.dataString["url"] = this.settings.ajaxUrl
          ? window.location.href
          : "";
        this.dataString["page"] = this.page;
        this.dataString["limit"] = this.settings.limit;

        for (var key in data) {
          if (data.hasOwnProperty(key)) {
            if (typeof data[key] == "undefined") {
              this.dataString[key] = $("#" + key).val();
            } else {
              this.dataString[key] = data[key];
            }
          }
        }
        return this.dataString;
      },
      _selectNone() {
        if (this.loading) {
          return;
        }
        $("." + this.element.id + "Checkbox").prop("checked", false);
      },
      _loading(show) {
        appLoader.show();
      },
      _beforeSend(e) {
        if (this.settings.loading) {
          // appLoader.show();
          run_waitMe(this.$element.find("tbody"), 1, "bounce");
        }
      },
      getCurrentData() {
        return this.currentData;
      },
      emptyObject(o) {
        for (var key in o) {
          if (o.hasOwnProperty(key)) {
            return false;
          }
        }
        return true;
      },
      _load() {
        //this.$element.DataTable().clear().destroy();
        this.$element.DataTable().clear().draw();
        // this.$element.DataTable().rows().remove().draw();
        // this.load();
      },
      _reload() {
        this.$element.DataTable().rows().clear().destroy();
        this.load();
      },
      load() {
        if (!this.settings.url) {
          return;
        }

        const that = this;
        var html = "";
        //this.loading = true;
        that.filterParams["tabbar"] = that.settings.tabbar;
        that.filterParams["data"] = that.settings.data;

        var datatableOptions = {
          dom: that.settings.dom,
          sorting: that.settings.sorting,
          processing: true,
          serverSide: true,
          smart: true,
          deferRender: true,
          pageLength: 25,
          pagingType: that.settings.pagingType,
          language: that.settings.language,
          ajax: {
            url: that.settings.url,
            data: that._filter(that.filterParams),
          },
          columns: that.settings.columns,
          searching: that.settings.searching,
          rowId: that.settings.rowId,
          fnInitComplete: function (data) {
            that.settings.onInitComplete(data);
            console.log("data.json.actions", data.json);
            if (that.settings.tabbar) {
              render_tabbar(data);
            }
          },
          fnDrawCallback: function () {
            that.settings.onDrawCallback();
          },
          footerCallback: function (row, data, start, end, display) {
            that.settings.footerCallback(row, data, start, end, display);
          },
          error: function (xhr, error, code) {
            console.log(error);
            console.log(code);
          },
        };

        that.$element.DataTable(datatableOptions);

        //$.fn.DataTable.ext.pager.numbers_length = 1;

        if (this.settings.reload) {
          this.load();
        }

        $(
          '<div class="modal fade" id="ajaxModal" role="dialog" aria-labelledby="ajaxModal" aria-hidden="true">' +
            $("#ajaxModal").html() +
            "</div>"
        ).appendTo($(".custom-toolbar").parent());

        that.$element.parent().on("submit", "form", (e) => {
          that._onSubmit(e.currentTarget);
        });

        // Tabbar
        if (that.settings.tabbar) {
          var tabBar = $(".tabbar");
          $(tabBar).appendTo($(".custom-toolbar"));

          //\that.$element.parent().find('a[data-post-key=all]').trigger('click');
        }
        
        if (typeof that.settings.filterDropdown[0] !== "undefined") {
         // $("<div class='filter-toolbar-dropdown'></div>").appendTo($(".filter-dropdown"));
          var radiobuttons = "";
        
          $.each(that.settings.filterDropdown, function (index, dropdown) {
            var optons = "",
              selectedValue = "";
            var string = "-";
            var optionName = "";
            var categorySelected;
        
            if (dropdown.defaultOption) {
              optons +=
                '<option value="0">' + dropdown.defaultOption + "</option>";
            } else {
              optons += '<option value="0">Chọn danh mục</option>';
            }
        
            $.each(dropdown.options, function (index, option) {
              var isSelected = "";
              if (option.isSelected) {
                isSelected = "selected";
                selectedValue = option;
              }
        
              if (option.level > 1) {
                var newString = "";
                for (var i = 1; i <= option.level; i++) {
                  newString += string;
                }
                optionName = newString + option.name;
              } else {
                optionName = option.name;
              }
        
              optons +=
                "<option " +
                isSelected +
                ' value="' +
                option.id +
                '">' +
                optionName +
                "</option>";
            });
        
            //  categorySelected = that.filterParams[dropdown.name];
        
            // console.log('categorySelected', that.filterParams);
        
            if (dropdown.name) {
              that.filterParams[dropdown.name] = selectedValue;
            }
        
            var selectDom =
              '<div class="p-0 pr-1">' +
              '<select class="' +
              dropdown.class +
              '" name="' +
              dropdown.name +
              '">' +
              optons +
              "</select>" +
              "</div>";
        
            // console.log($instanceWrapper);
            // console.log("dropdown.name", dropdown.name);
            console.log("selectDom", selectDom);
            // $instanceWrapper.children(".table-toolbar").append(selectDom);
            // $instanceWrapper.find(".extra_toolbar").append(selectDom);
            $(".filter-toolbar").append(selectDom);
        
            var $dropdown = $(".filter-toolbar").find(
              "[name='" + dropdown.name + "']"
            );
            if (window.Select2 !== undefined) {
              //return;
            }
        
            //$dropdown.find("option[value='"+categorySelected+"']").prop('selected','selected');
        
            $dropdown.select2();
        
            /*	that.$element.closest(".table-responsive").find("select").on("change", (e) => {
          // console.log('aa',e.currentTarget);
           that._change(e.currentTarget);
           });
            */
            $dropdown.change(function (e) {
              var $selector = $(this);
              that._change(e.currentTarget);
            });
          });
        }
        
        
        if (that.settings.filterDateRange) {
          $(".filter-toolbar").append(
            '<div class="p-0 pr-1 date-range-element"><input type="text" name="dateRange" class="form-control"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></div>'
          );
        
          if ($(".filter-toolbar").find('input[name="dateRange"]')) {
            $('input[name="dateRange"]').daterangepicker({
              startDate: moment().subtract(5, "day"),
              endDate: moment(),
              locale: {
                format: "DD/MM/YYYY",
                applyLabel: "Ok",
                cancelLabel: "Huỷ bỏ",
                fromLabel: "Từ ngày",
                toLabel: "đến",
                customRangeLabel: "Ngày tự chọn",
              },
              ranges: {
                "Hôm nay": [moment(), moment()],
                "Hôm qua": [
                  moment().subtract(1, "days"),
                  moment().subtract(1, "days"),
                ],
                "7 ngày qua": [moment().subtract(6, "days"), moment()],
                "30 ngày qua": [moment().subtract(29, "days"), moment()],
                "Tháng này": [
                  moment().startOf("month"),
                  moment().endOf("month"),
                ],
                "Tháng trước": [
                  moment().subtract(1, "month").startOf("month"),
                  moment().subtract(1, "month").endOf("month"),
                ],
              },
            });
          }
        
          $(".filter-toolbar")
            .find('input[name="dateRange"]')
            .on("apply.daterangepicker", function (ev, picker) {
              that._datepicker(picker);
            });
        }


        //$("#form-bulk-action").appendTo(".custom-toolbar");
      

        $(".dataTables_info").css("left", "150px");

        $(".dataTables_filter > label")
          .contents()
          .filter(function () {
            return this.nodeType === Node.TEXT_NODE;
          })
          .remove();

        $(".dataTables_filter > label > input").attr(
          "placeholder",
          that.settings.language.search + "..."
        );

        function render_tabbar(data) {
          //console.log('tab_active',data.json.actions.tab_active);
          that.$element.parent().find("#trash_tab").text(data.json.tabs.trash);
          that.$element.parent().find("#all_tab").text(data.json.tabs.all);
          $("a[class='anchor_tab'").siblings().removeClass("active");
          $("a[data-post-key='" + data.json.tabs.tab_active + "'").addClass(
            "active"
          );
        }

        if (that.settings.destroy) {
          that._destroy();
        }

        return false;
      },
    });
    // Plugin wrapper
    $.fn[pluginName] = function (options) {
      var plugin;
      this.each(function () {
        plugin = $.data(this, "plugin_" + pluginName);
        if (!plugin) {
          plugin = new Plugin(this, options);
          $.data(this, "plugin_" + pluginName, plugin);
        }
      });
      return plugin;
    };
  })(jQuery, window, document);
});
