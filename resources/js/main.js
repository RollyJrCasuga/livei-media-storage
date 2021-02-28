$("body").on("click", ".table-data", function (e) {
    window.location.href = $(this).data("href");
});

$("body").on("click", ".table-file", function (e) {
    $("#lightbox").modal("toggle");
    let file_name = $(this).data("name");
    let file_type = $(this).data("type");
    let file_src = $(this).data("src");
    let file_mime = $(this).data("mime");
    let content = "";
    switch (file_type) {
        case "video":
            content =
                "<video class='video-js medias' controls preload='auto' data-setup='{}'><source src='" +
                file_src +
                "' type='" +
                file_mime +
                "' /></video><p>" +
                file_name +
                "</p>" +
                "<a class='btn btn-primary' href='" +
                file_src +
                "' download><i class='fas fa-download'></i> Download</a>";
            $("#lightbox p").html(content);
            break;
        case "image":
            content =
                "<img class='medias' src='" +
                file_src +
                "'><p>" +
                file_name +
                "</p>" +
                "<a class='btn btn-primary' href='" +
                file_src +
                "' download><i class='fas fa-download'></i> Download</a>";
            $("#lightbox p").html(content);
            break;
        case "audio":
            content =
                "<audio id='audo-file' class='medias' controls><source src='" +
                file_src +
                "' type=''></audio><p>" +
                file_name +
                "</p>";
            $("#lightbox p").html(content);
            break;
        default:
            content = "<h3>Unknown File</h3>";
            $("#lightbox p").html(content);
            break;
    }
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

// auto hide flash messages
window.autoHideAlert = (time = 2000) => {
    setTimeout(() => {
        $(".flash-message #alert").each(function (index) {
            $(this)
                .fadeTo(500, 0)
                .slideUp(500, function () {
                    $(this).remove();
                });
        });
    }, time);
};

$(function () {
    if ($("#lightbox").css("display") == "none") {
        let media = $(".video-js");
        // media.pause();
        console.log("pause");
    } else {
        console.log("show");
    }
});

jQuery(function () {
    if ($("#lightbox").css("display") == "block") {
        let media = $(".video-js");
        // media.pause();
        console.log("pause");
    } else {
        console.log("show");
    }
    s;
});

// $("body").on("click", "#lightbox", function (e) {
//     console.log("lightbox");
//     if ($("#lightbox").css("display") == "block") {
//         let media = $("video");
//         // media.pause();
//         console.log("pause");
//     } else {
//         console.log("show");
//     }
// });
