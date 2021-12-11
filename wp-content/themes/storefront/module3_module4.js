window.addEventListener('DOMContentLoaded', function () {

    try {
        const tagCloudLink = document.querySelectorAll(`#lav-mdl3-mdl4 .lav-tag-search div.tagcloud a.tag-cloud-link`);
        tagCloudLink.forEach(element => {
            element.style.fontSize = "1rem";
            element.style.textDecoration = "none";
            element.style.display = "inline-block";
            element.style.padding = "3px 5px";
            element.style.backgroundColor = "#cbcbcb";
            element.style.borderRadius = "3px";
            element.style.margin = "3px";
        });
    } catch (e) {
        console.log(e.message);
    }
});