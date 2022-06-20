(function () {
    var loaderText = document.getElementById("loading-msg");
    loaderText.innerHTML = "กำลังโหลดข้อมูล";
})();

$(function (e) {
    $(".preloader").hide();
    $("body").css("overflow-y", "scroll");
});
