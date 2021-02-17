getTags(inputTagify);

function inputTagify() {
    var tags = document.querySelector("input[name=tags]");
    if (tags) {
        var tagify = new Tagify(tags, {
            whitelist: tagsWhiteList,
            dropdown: {
                position: "input",
                enabled: 0,
                closeOnSelect: false,
            },
        });
        document
            .querySelector(".tags--removeAllBtn")
            .addEventListener("click", tagify.removeAllTags.bind(tagify));
    }
}

const fileUploadBtn = document.getElementById("file-upload-btn");
const fileChosen = document.getElementById("file-chosen");
if (fileUploadBtn) {
    fileUploadBtn.addEventListener("change", function () {
        fileChosen.textContent = this.files[0].name;
    });
}
