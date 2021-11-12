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

        /*sum1*/
        function get_sum1() {
            let sum = 0;
            $('.cost1').each(function () {
                sum += parseFloat($(this).text());  // Or this.innerHTML, this.innerText
            });
            $('.final-sum1').text(sum);
        }
        get_sum1()

        function get_final_total() {
            let final_tot = ($('.final-sum1').text()) - ($('.final-sum').text());
            $('.final_total').text(final_tot);
        }

        $('.custom-select').change(function () {
            get_sum()
            get_sum1()
            get_final_total()
        });
        $('input[type="search"]').keyup(function () {
            get_sum()
            get_sum1()
            get_final_total()
        });
        $('th').click(function () {
            setTimeout(function () {
                get_sum()
                get_sum1()
                get_final_total()
            }, 300)
        });
    }, 300)
</script>
