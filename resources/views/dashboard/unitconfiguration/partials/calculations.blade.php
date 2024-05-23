<script>
    function totalRatio(ratio){

        let totalRatio = 0;

        for (const property in ratio) {
            totalRatio += ratio[property];
        }

        return totalRatio;
    }

    function calculateCft(pileLength, dia){

        let value = (pileLength * 3.1416 * dia) / 4;
        let m3 = value * 1.54;
        let cft = m3 * 35.32;

        return cft
    }

    function calculateCement(cft, ratio, total_ratio){

        let qty = ((cft * ratio.cement) / total_ratio) / 1.25;

        return parseFloat(qty).toFixed(4);
    }

    function calculateSand(cft, ratio, total_ratio){

        let qty = ((cft * ratio.sand) / total_ratio);

        return parseFloat(qty).toFixed(4);
    }

    function calculateStone(cft, ratio, total_ratio){

        let qty = ((cft * ratio.stone) / total_ratio);

        return parseFloat(qty).toFixed(4);
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
            let cft = calculateCft(pileLength, dia)


            let qty = {
                'cement': calculateCement(cft, ratio, total_ratio),
                'sand': calculateSand(cft, ratio, total_ratio),
                'stone': calculateStone(cft, ratio, total_ratio),
            }

            $('#cement_qty').val(qty.cement);
            $('#sand_qty').val(qty.sand);
            $('#stone_qty').val(qty.stone);
    }
</script>
