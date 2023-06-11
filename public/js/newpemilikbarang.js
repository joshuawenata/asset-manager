const box = document.getElementById("box");
const box2 = document.getElementById("box2");
const box3 = document.getElementById("box3");

function handleRadioClick() {
    if (document.getElementById("show").checked) {
        box.style.display = "block";
        box2.style.display = "block";
        box3.style.display = "block";
        // box.style.visibility = 'visible';
    } else {
        box.style.display = "none";
        box2.style.display = "none";
        box3.style.display = "none";
        // box.style.visibility = 'hidden';
    }
}

const radioButtons = document.querySelectorAll('input[name="pemilik-barang"]');
radioButtons.forEach((radio) => {
    radio.addEventListener("click", handleRadioClick);
});
