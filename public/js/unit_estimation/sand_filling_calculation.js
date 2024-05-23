function calcSandFillingVolume() {

    let cube = {
        'length': (+$('#length').val() / 1000),
        'width': (+$('#width').val() / 1000),
        'height': (+$('#height').val() / 1000),
    }

    let wallCft = calculateCft(cube);

    $('#sand_qty').val(wallCft);
}
