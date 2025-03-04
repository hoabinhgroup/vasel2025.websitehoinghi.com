$(document).ready(function () {
  $(".bulk-change-item").on("click", function (a) {
    a.preventDefault();

    var n = $(a.currentTarget),
      o = n.closest(".table-responsive").find(".table").prop("id"),
      c = [];

    var i,
      countAllCheckbox = [];
    $("input[name='table_checkbox[]']:checked").each(function () {
      countAllCheckbox.push($(this).val());
    });

    // console.log("countAllCheckbox", countAllCheckbox);
    if (countAllCheckbox.length <= 0) {
      appAlert.error("Xin chọn ít nhất 1 đối tượng", {
        container: "body",
        duration: 5000,
      });
      return false;
    }
    loadBulkChangeData(n);

    $(".confirm-bulk-change-button")
      .data("parent-table", o)
      .data("class-item", n.data("class-item"))
      .data("key", n.data("key"))
      .data("url", n.data("save-url")),
      $(".modal-bulk-change-items").modal("show");
  });

  $(document).on("click", ".confirm-bulk-change-button", function (e) {
    var a = $(e.currentTarget);
    // console.log('a.data("parent-table")', a.data("parent-table"));

    // $("#page-table")._load();
    // _load()
    e.preventDefault();
    var a = $(e.currentTarget),
      n = a.closest(".modal").find(".input-value").val(),
      o = a.data("key"),
      c = $("#" + a.data("parent-table")),
      r = [];

    c.find("input[name='table_checkbox[]']:checked").each(function () {
      r.push($(this).val());
    }),
      // console.log("url", a.data("url")),
      // console.log("r", r),
      // console.log("o", o),
      // console.log("n", n),
      // console.log("class", a.data("class-item")),
      a.addClass("button-loading"),
      $.ajax({
        url: a.data("url"),
        type: "POST",
        data: {
          ids: r,
          key: o,
          value: n,
          class: a.data("class-item"),
        },
        success: function (e) {
          console.log("success e", e);
          e.error
            ? appAlert.error(e.message, { container: "body", duration: 5000 })
            : appAlert.success(e.message, {
                container: "body",
                duration: 3000,
              }),
            c.find(".table-check-all").prop("checked", !1),
            c.DataTable().row($(this).closest("tr")).remove().draw(),
            // $("#" + a.data("parent-table"))
            //  .closest(".table-responsive")
            //  .find(".reload")
            //  .trigger("click"),
            // $.each(r, function (e, t) {
            //
            //   // window.LaravelDataTables[a.data("parent-table")]
            //   //   .row(c.find('.checkboxes[value="' + t + '"]').closest("tr"))
            //   //   .remove()
            //   //   .draw();
            // }),
            a.closest(".modal").modal("hide");
        },
        error: function (e) {
          appAlert.error(e, { container: "body", duration: 5000 });
        },
      });
  });

  $(document).on("click", ".delete-many-entry-trigger", function (e) {
    e.preventDefault();
    var a = $(e.currentTarget),
      n = a.closest(".table-responsive").find(".table").prop("id"),
      o = [];
    $("#" + n)
      .find("input[name='table_checkbox[]']:checked")
      .each(function (e, a) {
        o.push($(a).val());
      });

    if (0 === o.length) {
      return appAlert.error("Xin hãy chọn 1 bản ghi", {
        container: "body",
        duration: 5000,
      });
    } else {
      console.log('a.prop("href")', a.prop("href"));
      $(".delete-many-entry-button")
        .data("href", a.prop("href"))
        .data("parent-table", n)
        .data("class-item", a.data("class-item"));
      $(".delete-many-modal").modal("show");
    }
  });

  $(".delete-many-entry-button").on("click", function (e) {
    e.preventDefault();
    var a = $(e.currentTarget);
    a.addClass("button-loading");
    var n = $("#" + a.data("parent-table")),
      o = [];
    n.find("input[name='table_checkbox[]']:checked").each(function (e, a) {
      o.push($(a).val());
    }),
      $.ajax({
        url: a.data("href"),
        type: "DELETE",
        data: {
          ids: o,
          class: a.data("class-item"),
        },
        success: function (e) {
          // console.log("delete many", e);
          e.error
            ? appAlert.error(e.message, { container: "body", duration: 5000 })
            : appAlert.success(e.message, {
                container: "body",
                duration: 3000,
              }),
            n.find(".table-check-all").prop("checked", false);
          n.DataTable().draw(),
            // $("#" + a.data("parent-table"))
            //   .closest(".table-responsive")
            //   .find(".reload")
            //   .trigger("click"),
            a.closest(".modal").modal("hide"),
            a.removeClass("button-loading");
        },
        error: function (e) {
          appAlert.error(e, { container: "body", duration: 5000 });
          a.removeClass("button-loading");
        },
      });
  });
});

function loadBulkChangeData(e) {
  var a = $(".modal-bulk-change-items");
  // console.log("loadBulkChangeData e", e);
  $.ajax({
    type: "GET",
    url: a.find(".confirm-bulk-change-button").data("load-url"),
    data: {
      class: e.data("class-item"),
      key: e.data("key"),
    },
    success: function (e) {
      console.log("e.data", e.data);
      var n = $.map(e.data, function (e, t) {
        return {
          id: t,
          name: e,
        };
      });
      $(".modal-bulk-change-content").html(e.html);
    },
    error: function (e) {
      console.log("error", e);
    },
  });
}
