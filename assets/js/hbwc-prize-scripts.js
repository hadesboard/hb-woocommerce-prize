jQuery(document).ready(function ($) {
  $(".hbwc-get-prize").click(function (e) {
    e.preventDefault();

    var prizeId = $(this).data("prize-id");

    $.ajax({
      url: hbwc_ajax.ajax_url,
      method: "POST",
      data: {
        action: "hbwc_claim_prize",
        prize_id: prizeId,
      },
      success: function (response) {
        if (response.success) {
          alert(response.data);
          window.location.href = "/thank-you";
        } else {
          alert(response.data);
        }
      },
    });
  });
});
