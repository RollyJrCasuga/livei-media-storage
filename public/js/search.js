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
  var search, column, sort_type;
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
  }); // $(document).on("click", ".sort", function () {
  //     var column_name = $(this).data("column_name");
  //     var order_type = $(this).data("sorting_type");
  //     var reverse_order = "";
  //     if (order_type == "asc") {
  //         $(this).data("sorting_type", "desc");
  //         reverse_order = "desc";
  //     }
  //     if (order_type == "desc") {
  //         $(this).data("sorting_type", "asc");
  //         reverse_order = "asc";
  //     }
  //     order;
  //     filterFile({
  //         search: search,
  //         column: column,
  //         sort_type: sort_type,
  //     });
  // });

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