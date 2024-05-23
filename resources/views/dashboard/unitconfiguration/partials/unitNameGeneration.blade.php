<script>
    function UpdateUnitName(){

        let unitId = +$('#units').val();

        let unitName =  $('#project option:selected').attr('code') + '_' + $('#units  option:selected').attr('code');

        if(unitId == 8){

            let ratio = {
                'cement': +$('#cement').val(),
                'sand': +$('#sand').val(),
                'stone': +$('#stone').val(),
            };

            let total_ratio = totalRatio(ratio);

            unitName = unitName + '/' + $('#pile_length').val() + '_' + $('#dia').val() + '_' + total_ratio;
        }

        if(unitId == 9){

            let ratio = {
                'cement': +$('#cement_of_cap').val(),
                'sand': +$('#sand_of_cap').val(),
                'stone': +$('#stone_of_cap').val(),
            };

            let total_ratio = totalRatio(ratio);

            unitName = unitName + '/' + $('#length').val() + '_' + $('#width').val() + '_' + $('#height').val() + '_' + total_ratio;
        }

        $('#unit_name').val(unitName);
    }


    $(document).ready(function () {

        $('#project').change(function (e) {
            e.preventDefault();
            UpdateUnitName();
        });

        $('#units').change(function (e) {
            e.preventDefault();
            UpdateUnitName();
        });

    });
</script>
