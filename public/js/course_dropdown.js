const selected = document.querySelector(".selected");
const courseContainer = document.querySelector(".course-container");
const searchBox = document.querySelector(".search-box input");

const courses = document.querySelectorAll(".course");

selected.addEventListener("click", () => {
    courseContainer.classList.toggle("active");

    searchBox.value = "";
    filterList("");

    if (courseContainer.classList.contains("active")) {
        searchBox.focus();
    }
});

courses.forEach(o => {
    o.addEventListener("click", () => {
        selected.innerHTML = o.querySelector("label").innerHTML;
        courseContainer.classList.remove("active");
    });
});

searchBox.addEventListener("keyup", function (e) {
    filterList(e.target.value);
});

const filterList = searchTerm => {
    searchTerm = searchTerm.toLowerCase();
    courses.forEach(option => {
        // Xử lí tên khóa học (viết thường, không kí tự '-'','_','/')
        let label = option.firstElementChild.nextElementSibling.innerText.toLowerCase();
        label = label.replace('-','');
        label = label.replace('_', '');
        label = label.replace('/', '');
        label = label.replace('  ', ' ');
        console.log(label);
        if (label.indexOf(searchTerm) != -1) {
            option.style.display = "block";
        } else {
            option.style.display = "none";
        }
    });
};
