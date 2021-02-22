// $("body").on("click", "[class^='table-data']", function (e) {
//     window.location.href = $(this).data("href");
// });

$("body").on("click", ".table-data", function (e) {
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

// $("a.fancybox").fancybox();

// $("a#inline").fancybox({
//     hideOnContentClick: true,
// });

// $("a.fancybox").fancybox({
//     transitionIn: "elastic",
//     transitionOut: "elastic",
//     speedIn: 600,
//     speedOut: 200,
//     overlayShow: false,
// });

// $("body").on("click", ".file-name", function (e) {
//     console.log("clicked");
// });
