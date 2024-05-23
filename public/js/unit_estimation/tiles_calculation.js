function calcTiles() {

    let cube = {
        'length': +$('#length').val(),
        'width': +$('#width').val(),
    }


    let area = getArea(cube.length, cube.width);


    $('#tiles_qty').val(area);
}
