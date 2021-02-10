var tags = document.querySelector("input[name=tags]");
if (tags) {
    var tagify = new Tagify(tags, {
        whitelist: tagsWhiteList,
        dropdown: {
            position: "input",
            enabled: 0,
        },
    });
    document
        .querySelector(".tags--removeAllBtn")
        .addEventListener("click", tagify.removeAllTags.bind(tagify));
}

$("body").on("click", "[class^='table-data']", function (e) {
    window.location = $(this).data("href");
});

$(document).ready(function () {
    $("#example").DataTable();
});
