function calcSoilFillingVolume() {

    let cube = {
        'length': (+$('#length').val() / 1000),
        'width': (+$('#width').val() / 1000),
        'height': (+$('#height').val() / 1000),
    }

    let wallCft = Math.ceil(calculateCft(cube));

    $('#soil_qty').val(wallCft);
}
