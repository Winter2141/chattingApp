// (function() {
//   var NYLM, claerResizeScroll, conf, getRandomInt, insertI, lol;

//   conf = {
//     cursorcolor: "#696c75",
//     cursorwidth: "4px",
//     cursorborder: "none"
//   };

//   lol = {
//     cursorcolor: "#cdd2d6",
//     cursorwidth: "4px",
//     cursorborder: "none"
//   };

//   NYLM = ["sample1", "sample2", "sample3", "sample4", "sample5", "sample16", "sample17", "sample18", "sample19", "sample110", "sample111", "sample112", "sample113", "sample114"];

//   getRandomInt = function(min, max) {
//     return Math.floor(Math.random() * (max - min + 1)) + min;
//   };

//   claerResizeScroll = function() {
//     $("#texxt").val("");
//     $(".messages").getNiceScroll(0).resize();
//     return $(".messages").getNiceScroll(0).doScrollTop(999999, 999);
//   };

//   insertI = function() {
//     var innerText, otvet;
//     innerText = $.trim($("#texxt").val());
//     if (innerText !== "") {
//       $(".messages").append("<li class=\"i\"><div class=\"head\"><span class=\"time\">" + (new Date().getHours()) + ":" + (new Date().getMinutes()) + " AM, Today</span><span class=\"name\"> Буль</span></div><div class=\"message\">" + innerText + "</div></li>");
//       claerResizeScroll();
//       return otvet = setInterval(function() {
//         $(".messages").append("<li class=\"friend\"><div class=\"head\"><span class=\"name\">Юния  </span><span class=\"time\">" + (new Date().getHours()) + ":" + (new Date().getMinutes()) + " AM, Today</span></div><div class=\"message\">" + NYLM[getRandomInt(0, NYLM.length - 1)] + "</div></li>");
//         claerResizeScroll();
//         return clearInterval(otvet);
//       }, getRandomInt(2500, 500));
//     }
//   };

//   $(document).ready(function() {
//     $(".list-friends").niceScroll(conf);
//     $(".messages").niceScroll(lol);
//     $("#texxt").keypress(function(e) {
//       if (e.keyCode === 13) {
//         insertI();
//         return false;
//       }
//     });
//     return $(".send").click(function() {
//       return insertI();
//     });
//   });

// }).call(this);