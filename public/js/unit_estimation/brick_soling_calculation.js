function calcSolingBrick() {

    let cube = {
        'length': +$('#length').val(),
        'width': +$('#width').val(),
    }

    let bricks = (cube.length * cube.width) / 0.29;

    let brick_qty = Math.ceil(bricks);

    $('#brick_qty').val(brick_qty);

}
