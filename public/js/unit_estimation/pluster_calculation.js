function calcCap() {

    let cube = {
        'length': (+$('#length').val() / 1000),
        'height': (+$('#height').val() / 1000),
    }

    let area = getArea(cube.length, cube.height);

    let qty = {
        'cement': area * .02,
        'sand': area * .06,
    }

    $('#cement_qty_of_cap').val(qty.cement);
    $('#sand_qty_of_cap').val(qty.sand);
}
