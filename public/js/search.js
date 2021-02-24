/******/ (() => { // webpackBootstrap
/*!********************************!*\
  !*** ./resources/js/search.js ***!
  \********************************/
getTags(inputTagify); //search with tags

function inputTagify() {
  var input = document.querySelector("input[name=tags-select-mode]"),
      tagify = new Tagify(input, {
    mode: "select",
    whitelist: tagsWhiteList,
    blacklist: ["foo", "bar"],
    keepInvalidTags: true
  });
  var search, sort_column, sort_type;
  tagify.on("input", function (e) {
    var input = e.detail.value;
    search = input;
    filterFile({
      search: search
    });
  });
  tagify.on("add", function (e) {
    var input = e.detail.data.value;
    search = input;
    filterFile({
      search: search,
      sort_type: sort_type
    });
  });
  $("body").on("click", ".table-header", function () {
    var column_name = $(this).data("id");
    var order_type = $(this).data("sort_type");
    var reverse_order = "";

    if (order_type == "asc") {
      $(this).data("sort_type", "desc");
      reverse_order = "desc";
    }

    if (order_type == "desc") {
      $(this).data("sort_type", "asc");
      reverse_order = "asc";
    }

    sort_column = column_name;
    sort_type = reverse_order;
    console.log(sort_column);
    console.log(sort_type);
    filterFile({
      search: search,
      sort_column: sort_column,
      sort_type: sort_type
    });
  });

  function filterFile(filterData) {
    $.ajax({
      url: "/file/filter",
      data: filterData,
      success: function success(data) {
        $("#table-content").html(data.table);
      }
    });
  }
}
/******/ })()
;