const box2 = document.getElementById("box2");

function handleRadioClick() {
    if (document.getElementById("show2").checked) {
        box2.style.display = "block";
        // box.style.visibility = 'visible';
    } else {
        box2.style.display = "none";
        // box.style.visibility = 'hidden';
    }
}

const checkBox = document.querySelectorAll('input[name="pemilik-barang"]');
checkBox.forEach((check) => {
    check.addEventListener("click", handleRadioClick);
});
