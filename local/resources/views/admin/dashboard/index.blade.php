@extends('admin.layouts.master') 

@section('title') {{ transLang('dashboard') }} @endsection
 
@section('content')
    <section class="content-header">
        <h1> {{ transLang('dashboard') }}</h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> {{ transLang('dashboard') }}</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3 class="total_users"><i class="fa fa-spin fa-spinner"></i></h3>
                        <p>{{ transLang('total_users') }}</p>
                    </div>
                    <div class="icon"><i class="fa fa-users"></i></div>
                    <a href="{{ route('admin.users.index') }}" class="small-box-footer">{{ transLang('more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <div class="small-box bg-teal">
                    <div class="inner">
                        <h3 class="total_coupons"><i class="fa fa-spin fa-spinner"></i></h3>
                        <p>{{ transLang('total_coupons') }}</p>
                    </div>
                    <div class="icon"><i class="fa fa-tags"></i></div>
                    <a href="{{ route('admin.coupons.index') }}" class="small-box-footer">{{ transLang('more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Users Graph -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            {{ transLang('users_registration') }}
                        </h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-primary users_date_range"><i class="fa fa-calendar fa-lg"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="chart">
                                    <canvas id="usersChart" height="250" style="height: 250px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(function() {
            let chartDates = {
                start: moment().add(1, 'days').subtract(7, 'days'), 
                end: moment()
            },
            datePickerRange = {
                '{{ transLang("today") }}': [moment(), moment()],
                '{{ transLang("yesterday") }}': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '{{ transLang("last_7_days") }}': [moment().subtract(6, 'days'), moment()],
                '{{ transLang("last_15_days") }}': [moment().subtract(15, 'days'), moment()],
                '{{ transLang("this_month") }}': [moment().startOf('month'), moment().endOf('month')],
                '{{ transLang("last_month") }}': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            }, 
            datePickerLocale = {
                format: 'YYYY-MM-DD',
                applyLabel: '{{ transLang("apply") }}',
                cancelLabel: '{{ transLang("cancel") }}',
                customRangeLabel: '{{ transLang("custom") }}',
            };

            getStats();
            setTimeout(getUsersGraphData, 400);

            // Users Chart
            const usersChart = new Chart($('#usersChart').get(0).getContext('2d'), {
                type: 'line',
                data: { labels: [], datasets: [] },
                options: {
                    responsive: true,
                    tooltips: {
                        intersect: false,
                        position: 'nearest',
                        mode: 'index'
                    },
                }
            });

            $('.users_date_range').daterangepicker({
                opens: '{{ getSessionLang() == "ar" ? 'right' : 'left'}}',
                dateLimit: { days: 30 },
                startDate: chartDates.start,
                endDate: chartDates.end,
                locale: datePickerLocale,
                ranges: datePickerRange,
            }, (start, end) => getUsersGraphData(start, end));

            function getStats() {
                $.ajax({
                    dataType: 'json',
                    type: 'GET',
                    url: '{{ route("admin.dashboard.stats") }}',
                    error: () => $('.total_users, .total_coupons').text('0'),
                    success: response => $.each(response, (key, val) => $(`.${key}`).text(val))
                });
            }

            function getUsersGraphData(start = chartDates.start, end = chartDates.end) {
                $.ajax({
                    dataType: 'json',
                    type: 'GET',
                    url: '{{ route("admin.dashboard.users.graph") }}',
                    data: {
                        start_date: start.lang('en').format('YYYY-MM-DD'),
                        end_date: end.lang('en').format('YYYY-MM-DD'),
                    },
                    success: function (response) {
                        usersChart.data = {
                            labels: response.labels,
                            datasets: [{
                                label: '{{ transLang("users") }}',
                                data: response.users,
                                borderColor: "rgb(52, 144, 220)",
                                backgroundColor: 'rgb(52, 144, 220, .4)',
                                borderWidth: 1.5,
                            }]
                        };
                        usersChart.update();
                    }
                });
            }
        });
    </script>
@endsection