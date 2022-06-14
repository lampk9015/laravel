@push('after-styles')
    <link rel="stylesheet" href="{{ mix('vendor/datetimepicker/css/tempusdominus-bootstrap-4.min.css') }}" />
@endpush

@push('after-scripts')
    <script src="{{ mix('vendor/moment/moment.min.js') }}"></script>
    <script src="{{ mix('vendor/moment/locales.min.js') }}"></script>
    <script src="{{ mix('vendor/datetimepicker/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            let _options = {
                format: 'YYYY-MM-DD HH:mm:ss',
                minDate: '{{ $task->created_at ?? date("Y-m-d H:i:s") }}',
                defaultDate: '{{ old("deadline_at") ?? $task->deadline_at }}',
                icons: {
                    time: "fa fa-clock",
                    date: "fa fa-calendar-alt"
                }
            };

            // let createdAt = '{{ $task->created_at ?? date("Y-m-d H:i:s") }}';

            // if (moment(createdAt, _options.format).isValid()) {
            //     _options.minDate = createdAt;
            // }
            // else if (moment(_options.defaultDate, _options.format).isValid()) {
            //     _options.minDate = _options.defaultDate;
            // }
            // else {
            //     _options.minDate = moment();
            // }

            $('#deadline-at-dt-picker').datetimepicker(_options);
        });
    </script>
@endpush
