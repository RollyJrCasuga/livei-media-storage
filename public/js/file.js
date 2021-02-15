/******/ (() => { // webpackBootstrap
/*!******************************!*\
  !*** ./resources/js/file.js ***!
  \******************************/
var tags = document.querySelector("input[name=tags]");

if (tags) {
  var tagify = new Tagify(tags, {
    whitelist: tagsWhiteList,
    dropdown: {
      position: "input",
      enabled: 0
    }
  });
  document.querySelector(".tags--removeAllBtn").addEventListener("click", tagify.removeAllTags.bind(tagify));
}

$("body").on("click", "[class^='table-data']", function (e) {
  window.location = $(this).data("href");
}); //search with names

var search;
$("#search").on("input", function () {
  var input = $("#search").val();
  console.log(input);
  search = input;
  filterFile({
    search: search
  });
});
$("body").on("click", ".table-header", function (e) {
  console.log($(this).data("id")); // window.location = $(this).data("href");
});

function filterFile(filterData) {
  $.ajax({
    url: "/file/filter",
    data: filterData,
    success: function success(data) {
      console.log(data.table);
      $("#table-content").html(data.table);
    }
  });
} //search with tags


var input = document.querySelector("input[name=tags-select-mode]"),
    tagify = new Tagify(input, {
  mode: "select",
  whitelist: tagsWhiteList,
  blacklist: ["foo", "bar"],
  keepInvalidTags: true,
  // do not auto-remove invalid tags
  dropdown: {// closeOnSelect: false
  }
}); // tagify.on("add", onAddTag);
// tagify.DOM.input.addEventListener("focus", onSelectFocus);
/******/ })()
;