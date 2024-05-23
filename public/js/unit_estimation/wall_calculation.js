function calcWall() {

    let cube = {
        'length': +$('#length').val(),
        'width': +$('#width').val(),
        'height': +$('#height').val(),
    }

    let wallCft = getVolume(cube.length, cube.width, cube.height);

    let brick_qty = Math.ceil(wallCft * 11.52);

    $('#brick_qty').val(brick_qty);

}
