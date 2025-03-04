$(document).ready(function () {
  $(document).on("click", ".send_mail button", function (e) {
    e.preventDefault();

    // console.log('this', $(this));

    let user_id = $(this).data("user_id");
    let abstract_id = $(this).data("abstract_id");

    // console.log(user_id);

    $.fancybox.open({
      src: `<div class="alert-content">
            <h3>Xác nhận</h3>
            <p>Bạn chắc chắn muốn gửi tài khoản và link chấm bài đến mail người này?</p>
            <div class="buttons">
                <button class="btn btn-primary confirm-send">Đồng ý</button>
                <button class="btn btn-secondary" data-fancybox-close>Hủy</button>
            </div>
        </div>`,
      type: "html",
      opts: {
        animationEffect: "fade",
        animationDuration: 300,
        afterLoad: function () {
          $(".confirm-send").one("click", function () {
            // Call Laravel route to send mail
            $.ajax({
              url: "/cmspanel/abstractscore/send-mail-notify", // Your Laravel route
              method: "POST",
              data: {
                user_id,
                abstract_id,
              },
              success: function (response) {
                // console.log(' $(".reload")', $(".reload"));
                $(".reload").trigger("click");

                $.fancybox.close();
                appAlert.success("Gửi mail thành công", {
                  container: "body",
                  duration: 3000,
                });
              },
              error: function () {
                appAlert.error("Có lỗi xảy ra");
              },
            });
          });
        },
      },
    });
  });
});
