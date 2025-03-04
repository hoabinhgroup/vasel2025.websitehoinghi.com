var data_services_assign = [];
var price_only_number = 0;

save_list_services_assign();

function numberWithCommas(x) {
  return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
}

function save_list_services_assign() {
  var data_services_assign_final = [];
  var data_services_assign = [];
  var price_only_number = 0;
  $(".data-item-row").each(function () {
    console.log("$(this) index", $(this).index());
    var index = $(this).index() + 1;
    $(this).children(".data-item-id").text(index);
    var id = $(this).children(".data-item-id_service:hidden").text();
    var name = $(this).children(".data-item-name").text();
    var price = $(this).children(".data-item-price").text();
    var sale = $(this).children(".data-item-sale").text();
    var id_author = $(this).children(".data-item-id_author:hidden").text();
    // console.log("id_author", id_author);
    data_services_assign.push({
      id: id,
      name: name,
      price: price,
      id_author: id_author,
    });

    price_only_number += parseInt(price.replace(/\$|,/g, ""));
  });
  console.log("price_only_number", price_only_number);
  $("#table_services_assign")
    .find("tfoot")
    .html(
      '<tr><td>&nbsp;</td><td class="text-right"><strong>Tổng</strong></td><td colspan="3"><strong style="color: #FF7588">' +
        numberWithCommas(price_only_number) +
        "<sup>đ</sup></strong></td></tr>"
    );

  data_services_assign_final.push({
    total: price_only_number,
    list: data_services_assign,
  });
  $("input[name='list_services_assign']").val(
    JSON.stringify(data_services_assign_final)
  );
}

function del(o) {
  //  var index = data_services_assign.indexOf($(o).closest("tr"));
  $(o).parent().parent().remove();
  //var index = $(o).closest("tr").index();
  //console.log("$(o) index", $(o).closest("tr").index());
  save_list_services_assign();
  // console.log("$(o) index", index);
  // $(o).parent().parent().remove();
  // if (index !== -1) {
  //   data_services_assign.splice(index, 1);
  //   console.log("data_services_assign", data_services_assign);
  // }
  // $("input[name='list_services_assign']").val(
  //   JSON.stringify(data_services_assign)
  // );
}

jQuery(function ($) {
  $("#membership-table_wrapper").find(".modal-dialog").addClass("modal-lg");
  $(".select-autocomplete").select2({
    minimumInputLength: 2,
    ajax: {
      url: "/api/membership/ajaxLoadServices",
      quietMillis: 500,
      placeholder: "Xin chọn dịch vụ",
      data: function (params) {
        return {
          q: params.term,
        };
      },
      processResults: function (data) {
        console.log("processResults", data);
        return {
          results: $.map(data, function (item, index) {
            return {
              index: index,
              text: item.name,
              id: item.id,
              sale: item.author,
              price: item.price,
              id_author: item.id_author,
            };
          }),
        };
      },
    },
  });

  $(".select-autocomplete").on("select2:select", function (e) {
    var data = e.params.data;
    var html = "";
    console.log(data);
    html += "<tr class='data-item-row'>";
    html += "<td class='data-item-id'></td>";
    html += "<td class='data-item-name'>" + data.text + "</td>";
    html += "<td class='data-item-price'>" + data.price + "</td>";
    html += "<td class='data-item-sale'>" + data.sale + "</td>";
    html +=
      "<td style='display:none' class='data-item-id_service'>" +
      data.id +
      "</td>";
    html +=
      "<td style='display:none' class='data-item-id_author'>" +
      data.id_author +
      "</td>";
    html +=
      '<td><a style="cursor:pointer" onclick="del(this)"><i class="icon-close font-weight-bold"></i></a></td>';
    html += "</tr>";

    $("#list-services-assign").append(html);

    save_list_services_assign();
    // data_services_assign.push({
    //   id: data.id,
    //   name: data.text,
    //   price: data.price.replace(/\$|,/g, ""),
    //   id_author: data.id_author,
    // });
    // console.log("data_services_assign", data_services_assign);
    // $("input[name='list_services_assign']").val(
    //   JSON.stringify(data_services_assign)
    // );
  });
});
