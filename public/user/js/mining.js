function checkPolicy() {
  var checkMining = document.getElementById("check-mining");
  var checkBtn = document.getElementById("check-btn");
  if (checkMining.checked) {
    checkBtn.disabled = false;
  } else {
    checkBtn.disabled = true;
  }
}

$(document).ready(function () {
  var active = "";

  setInterval(function () {
    $(".carousel-indicators li").each(function () {
      if ($(this).hasClass("active")) {
        active = $(this).data("slide-to");
      }
    });
    $(".row .col-lg-4 .border-dark").each(function () {
      if (active == $(this).data("slide-to")) {
        $(".row .col-lg-4 .border-dark").removeClass("slide-col-active");
        $(this).addClass("slide-col-active");
      }
    });
  }, 10);
});
