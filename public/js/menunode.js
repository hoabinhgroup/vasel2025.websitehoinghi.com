var sourceAdd = "";
var values = [];
$.ajaxSetup({
  headers: {
    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
  },
});

/* P */
$(".accordion-2a, .accordion-2b, .accordion-3").on(
  "show.bs.collapse",
  function (n) {
    $(n.target)
      .siblings(".panel-heading")
      .find(".panel-title i")
      .toggleClass("fa-chevron-down fa-chevron-up");
  }
);
$(".accordion-2a, .accordion-2b, .accordion-3").on(
  "hide.bs.collapse",
  function (n) {
    $(n.target)
      .siblings(".panel-heading")
      .find(".panel-title i")
      .toggleClass("fa-chevron-up fa-chevron-down");
  }
);

function uncheckedall(o) {
  var elementChecked = $(o).parent().parent().find(".checkboxnodes");
  elementChecked.each(function (e) {
    if ($(this).prop("checked")) {
      var valueChecked = $(this).val();
      $(this).prop("checked", false);
      var result = values.filter(function (elem) {
        return elem != valueChecked;
      });
      values.splice(values[result], 1);

      //values = [];
      console.log(values);
    }
  });
}

//getChecked();

$("input[class='checkbox_value']:checkbox").on("click", function () {
  const that = $(this);
  $(this).each(function () {
    if (that.prop("checked")) {
      values.push(that.attr("id"));
      arr = values;
    } else {
      jQuery.each(values, function (i, item) {
        if (arr[i] == that.attr("id")) {
          arr.splice(i, 1);
        }
      });
      values = arr;
    }
    console.log(values);
  });
});

/*
      function importMenuNode(table, namespace, lang){
           console.log('data',values );
           console.log('table',table );
           console.log('namespace',namespace );
           console.log('menu_id',id );
           console.log('lang',lang );
           //return false;
        if(values.length == 0){
        alert("Bạn phải chọn tối thiểu 1 menu!");
        } else{

        $.ajax({
        type: "POST",
        url: '/' + backend + "/menunode/import",
        data: {
            data: values,
            table: table,
            namespace: namespace,
            menu_id: id,
            lang: lang
        },
        beforeSend: function (){
            //jQuery('#loading-indicator').show();
        },
        success: function (obj) {
         console.log('importMenuNode',obj);
        //return false;

    var source = $("#script_menu_nodes").html();
        var template = Handlebars.compile(source);
        $("#nestable").children('ol').append(template({html: obj}));

        },
        error: function(error){
            console.log('error',error);
            return false;
        }


    });

        }

        }
*/

var menunodesadd = [];

$("input[name='menu_id']").on("click", function () {
  if ($(this).is(":checked")) {
    console.log($(this));
    var dataReferenceId = $(this).parent().attr("data-reference-id");
    var dataReferenceType = $(this).parent().attr("data-reference-type");
    menunodesadd.push({
      "reference-id": dataReferenceId,
      "reference-type": dataReferenceType,
    });
  }
});

$(".search-control").keyup(function () {
  var textboxVal = $(this).val().toLowerCase();
  $(this)
    .parent()
    .find(".list-item li")
    .each(function () {
      var listVal = $(this).text().toLowerCase();
      if (listVal.indexOf(textboxVal) >= 0) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
});

function importMenuNode(o) {
  // console.log('menunodesadd', menunodesadd);

  if (menunodesadd.length == 0) {
    alert("Bạn phải chọn tối thiểu 1 menu!");
  } else {
    $.ajax({
      type: "POST",
      url: "/" + backend + "/menunode/import",
      data: {
        menunodesadd: menunodesadd,
        menu_id: id,
      },
      beforeSend: function () {
        //jQuery('#loading-indicator').show();
      },
      success: function (obj) {
        console.log("importMenuNode", obj);
        //return false;

        var source = $("#script_menu_nodes").html();
        var template = Handlebars.compile(source);
        $("#nestable")
          .children("ol")
          .append(template({ html: obj }));
      },
      error: function (error) {
        console.log("error", error);
        return false;
      },
    });
  }
}

function addExternalUrl() {
  jQuery.ajax({
    type: "POST",
    url: "/" + backend + "/menunode/add-external-url",
    data: {
      title: $("#node-title").val(),
      url: $("#node-url").val(),
      icon: $("#node-icon").val(),
      css: $("#node-css").val(),
      target: $("#target").val(),
      menu_id: id,
    },
    beforeSend: function () {
      //jQuery('#loading-indicator').show();
    },
    success: function (obj) {
      console.log(obj);

      $("#nestable")
        .children("ol")
        .append(
          "<li id='sort_" +
            obj.id +
            "' class='dd-item dd2-item item-orange' data-id='" +
            obj.id +
            "'><div class='dd-handle dd2-handle'><i class='normal-icon ace-icon fa fa-bars blue bigger-130'></i><i class='drag-icon ace-icon fa fa-arrows bigger-125'></i></div><div class='dd2-content'><span class='msg_" +
            obj.id +
            "'>" +
            obj.title +
            "</span><div class='pull-right action-buttons'>" +
            obj.urlUpdate +
            "&nbsp;&nbsp;" +
            obj.urlDelete +
            "</div></li>"
        );
    },
    error: function (error) {
      console.log("error", error);
    },
  });
}

function deleteMenuNode(o) {
  var node = $(o).closest(".dd-item").attr("data-id");
  var url = $(o).attr("data-url");
  jQuery.ajax({
    type: "POST",
    url: url,
    beforeSend: function () {
      //jQuery('#loading-indicator').show();
    },
    success: function (obj) {
      console.log(obj);
      $("#sort_" + node).fadeOut();
    },
    error: function (error) {
      console.log(error);
    },
  });
}

$(document).ready(function () {
  $("input[type=checkbox]").click(function () {
    // if is checked
    if ($(this).is(":checked")) {
      // $(this).parents('ul').prev().children('input[type=checkbox]').prop('checked', true);
      $(this).parent().find("li input[type=checkbox]").prop("checked", true);
    } else {
      $(this)
        .parents("li")
        .children("input[type=checkbox]")
        .prop("checked", false);
      // uncheck all children
      $(this).parent().find("li input[type=checkbox]").prop("checked", false);
    }
  });
});

var updateOutput = function (e) {
  var list = e.length ? e : $(e.target),
    output = list.data("output");
  if (window.JSON) {
    var data = list.nestable("serialize");
    console.log("updateOutputBefore", data);

    $.ajax({
      url: "/" + backend + "/menunode/updatesort",
      type: "POST",
      data: {
        dataString: data,
        menu_id: id,
      },
      success: function (data) {
        // alert(data);
        console.log("updateOutput", data);
      },
      error: function (error) {
        console.log("error", error);
      },
    });
  } else {
    output.val("JSON browser support required for this demo.");
  }
};

// activate Nestable for list 1
$("#nestable")
  .nestable({
    group: 1,
  })
  .on("change", updateOutput);

// output initial serialised data
updateOutput($("#nestable").data("output", $("#nestable-output")));

$(".dd-handle a").on("mousedown", function (e) {
  e.stopPropagation();
});
