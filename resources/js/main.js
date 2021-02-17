$("body").on("click", "[class^='table-data']", function (e) {
    window.location.href = $(this).data("href");
});

window.getTags = (inputTagify = null) => {
    $.ajax({
        url: "/tags",
        success: function (data) {
            setTags(data.tags);

            if (inputTagify) inputTagify();
        },
    });
};

function setTags(tags = []) {
    window.tagsWhiteList = tags;
}

$("body").on("click", ".table-header", function (e) {
    // console.log($(this).data("id"));
});
