const box = document.getElementById("box");
const box2 = document.getElementById("box2");

function handleRadioClick() {
    if (document.getElementById("show").checked) {
        box.style.display = "block";
        box2.style.display = "block";
        // box.style.visibility = 'visible';
    } else {
        box.style.display = "none";
        box2.style.display = "none";
        // box.style.visibility = 'hidden';
    }
}

const radioButtons = document.querySelectorAll('input[name="asset-Jenis"]');
radioButtons.forEach((radio) => {
    radio.addEventListener("click", handleRadioClick);
});

const radioButtonslokasi = document.querySelectorAll('input[name="lokasi"]');
radioButtonslokasi.forEach((radio) => {
    radio.addEventListener("change", handleRadioClick);
});

handleRadioClick();
