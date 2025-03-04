$(function () {
  $("#province").on("change", function () {
    provinId = $(this).val();
    console.log("provinId", provinId);
    $.ajax({
      url: "/api/membership/province",
      type: "POST",
      dataType: "json",
      data: { id: provinId },
      success: function (result) {
        console.log(result);
        $("#district").html(result["html"]);
        $("#ward").html("<option id='0'>Chọn Phường / Xã / Thị trấn</option>");
      },
      error: function (response) {
        console.log(response);
      },
    });
  });

  $("#district").on("change", function () {
    districtId = $(this).val();
    $.ajax({
      url: "/api/membership/district",
      type: "POST",
      dataType: "json",
      data: { id: districtId },
      success: function (result) {
        console.log(result);
        $("#ward").html(result["html"]);
      },
      error: function (response) {
        console.log(response);
      },
    });
  });
});
