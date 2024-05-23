function calculateCubeOfPile(a, b) {
    return a * b;
}

function calculateCftOfPile(pileLength, dia) {

    let value = (pileLength * 3.1416 * dia) / 4;
    let m3 = calculateCubeOfPile(value, 1.54);
    let cft = volumeToCft(m3);

    return cft
}

function calculateCement(cft, ratio, total_ratio) {

    let qty = ((cft * ratio.cement) / total_ratio) / 1.25;

    return parseFloat(qty).toFixed(2);
}

function calculateSand(cft, ratio, total_ratio) {

    let qty = ((cft * ratio.sand) / total_ratio);

    return parseFloat(qty).toFixed(2);
}

function calculateStone(cft, ratio, total_ratio) {

    let qty = ((cft * ratio.stone) / total_ratio);

    return parseFloat(qty).toFixed(2);
}

function calculateMaterialsOfPile() {
    let pileLength = $('#pile_length').val();
    let dia = ($('#dia').val() / 1000);
    dia *= dia;

    let ratio = {
        'cement': +$('#cement').val(),
        'sand': +$('#sand').val(),
        'stone': +$('#stone').val(),
    };

    let total_ratio = totalRatio(ratio);
    let cft = calculateCftOfPile(pileLength, dia)


    let qty = {
        'cement': calculateCement(cft, ratio, total_ratio),
        'sand': calculateSand(cft, ratio, total_ratio),
        'stone': calculateStone(cft, ratio, total_ratio),
    }

    $('#cement_qty').val(qty.cement);
    $('#sand_qty').val(qty.sand);
    $('#stone_qty').val(qty.stone);
}
