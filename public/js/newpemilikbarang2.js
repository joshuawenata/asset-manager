const box = document.getElementById("box");

function handleRadioClick() {
    if (document.getElementById("show2").checked) {
        box.style.display = "block";
        // box.style.visibility = 'visible';
    } else {
        box.style.display = "none";
        // box.style.visibility = 'hidden';
    }
}

const checkBox = document.querySelectorAll('input[name="pemilik-barang"]');
checkBox.forEach((check) => {
    check.addEventListener("click", handleRadioClick);
});
