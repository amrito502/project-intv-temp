<script>
    function getArea(l, h) {
        return l * h;
    }

    function getVolume(l, w, h) {
        return l * w * h;
    }

    function calculateCft(cube) {
        let m3 = getVolume(cube.length, cube.height, cube.width) * 1.54;
        let cft = volumeToCft(m3);
        return cft
    }

    function volumeToCft(volume){
        return volume * 35.32;
    }

    function cftToVolume(cft){
        return cft / 35.32;
    }

    function VolumeToLabor(vol, rate){
        return vol * rate;
    }

    function totalRatio(ratio){
        let totalRatio = 0;

        for (const property in ratio) {
            totalRatio += ratio[property];
        }

        return totalRatio.toFixed(2);
    }

</script>
