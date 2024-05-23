    function calculateCementOfCap(cft, ratio, total_ratio) {

        let qty = ((cft * ratio.cement) / total_ratio) / 1.25;

        return Math.ceil(qty);
    }

    function calculateSandOfCap(cft, ratio, total_ratio) {

        let qty = ((cft * ratio.sand) / total_ratio);

        return Math.ceil(qty);
    }

    function calculateStoneOfCap(cft, ratio, total_ratio) {

        let qty = ((cft * ratio.stone) / total_ratio);

        return Math.ceil(qty);
    }

    function calcCap() {
        let cube = {
            'length': (+$('#length').val() / 1000),
            'width': (+$('#width').val() / 1000),
            'height': (+$('#height').val() / 1000),
        }

        let ratio = {
            'cement': +$('#cement_of_cap').val(),
            'sand': +$('#sand_of_cap').val(),
            'stone': +$('#stone_of_cap').val(),
        };

        let total_ratio = totalRatio(ratio);
        let cft = calculateCft(cube)

        let qty = {
            'cement': +calculateCementOfCap(cft, ratio, total_ratio),
            'sand': +calculateSandOfCap(cft, ratio, total_ratio),
            'stone': +calculateStoneOfCap(cft, ratio, total_ratio),
        }

        $('#cement_qty_of_cap').val(qty.cement);
        $('#sand_qty_of_cap').val(qty.sand);
        $('#stone_qty_of_cap').val(qty.stone);
    }
