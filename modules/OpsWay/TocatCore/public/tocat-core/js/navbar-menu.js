$(function () {
  var $win = $(window);
  $win.resize(function () {
      if ($win.width() > 768)
          $(".navbar-nav > .dropdown > a").attr("data-toggle", "");
      else
          $(".navbar-nav > .dropdown > a").attr("data-toggle", "dropdown");
  }).resize();
  $(".dropdown-menu").find("input, button").each(function () {
      $(this).click(function (e) {
          e.stopPropagation();
      });
  });
});
