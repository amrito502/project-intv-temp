@php
$edit = request()->route()->getName() == 'unitconfiguration.edit';
@endphp

<script>
    // hideAll forms by default

       function hideAll() {

        $('.dynamic-form').html('');

    }

    // toggle unit form
    function toggleUnitForm() {

        let selectedId = $('#units').val();

        axios.get(route('unitConfigCreateFormToggle', selectedId), {params: {
            "unitConfig" : JSON.parse($('#unitConfigFullJson').val()),
        }})
        .then(function (response) {

            html = response.data;

            $('.dynamic-form').html(html);

        })
        .catch(function (error) {
        })
    }

    $(function () {

        @if($edit)
        toggleUnitForm();
        @endif


        $('#units').change(function (e) {
            e.preventDefault();

            hideAll();
            toggleUnitForm();

        });

    });
</script>
