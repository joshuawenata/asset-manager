const box = document.getElementById('box');

function handleRadioClick(){
    if(document.getElementById('show').checked){
        box.style.display = 'block';
        // box.style.visibility = 'visible';
    }
    else{
        box.style.display = 'none';
        // box.style.visibility = 'hidden';
    }
}

const radioButtons = document.querySelectorAll('input[name="asset-category"]');
radioButtons.forEach(radio => {
    radio.addEventListener('click', handleRadioClick);
});

const radioButtonslokasi = document.querySelectorAll('input[name="lokasi"]');
radioButtonslokasi.forEach(radio => {
    radio.addEventListener('click', handleRadioClick);
});
