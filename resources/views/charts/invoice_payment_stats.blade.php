<div id="invoice_payment_stats"></div>
<script>
    c3.generate({
        bindto: '#invoice_payment_stats',
        data: {
            columns: [
               ['{{trans('invoice.fullPayment')}}', {{$fullPayment}}],
               ['{{trans('invoice.partPayment')}}', {{$partPayment}}],
               ['{{trans('invoice.noPayment')}}', {{$noPayment}}],
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