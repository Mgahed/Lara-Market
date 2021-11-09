<script>
    setTimeout(function () {
        /*sum*/
        function get_sum() {
            let sum = 0;
            $('.cost').each(function () {
                sum += parseFloat($(this).text());  // Or this.innerHTML, this.innerText
            });
            $('.final-sum').text(sum);
        }

        get_sum()

        $('.custom-select').change(function () {
            get_sum()
        });
        $('input[type="search"]').keyup(function () {
            get_sum()
        });
        $('th').click(function () {
            setTimeout(function () {
                get_sum()
            }, 100)
        });
    }, 100)
</script>
