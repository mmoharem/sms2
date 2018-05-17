<div id="invoice_payment_stats_sum"></div>
<script>
    c3.generate({
        bindto: '#invoice_payment_stats_sum',
        data: {
            columns: [
               ['{{trans('invoice.fullPayment')}}', {{$fullPaymentSum}}],
               ['{{trans('invoice.partPayment')}}', {{$partPaymentSum}}],
               ['{{trans('invoice.noPayment')}}', {{$noPaymentSum}}],
            ],
            type: 'pie',
            labels: true
        },
        pie: {
            label: {
                format: function (value, ratio, id) {
                    return value;
                }
            }
        }
    });
</script>