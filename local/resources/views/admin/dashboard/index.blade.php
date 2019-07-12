@extends('admin.layouts.master') 
@section('title') {{ transLang('dashboard') }}
@endsection
 
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

        <!-- Subscription Graph -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            {{ transLang('subscriptions') }}
                        </h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-primary subscription_date_range"><i class="fa fa-calendar fa-lg"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="description-block border-right">
                                    <h5 class="description-header">{{ config('cms.default_currency') }} <span class="total_subscriptions_amount">00.00</span></h5>
                                    <span class="description-text">{{ transLang('total_subscriptions_amount') }}</span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xs-12">
                                <br>
                                <div class="chart">
                                    <canvas id="subscriptionsChart" height="250" style="height: 250px;"></canvas>
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
            let startDate = moment().add(1, 'days').subtract(7, 'days'), 
                endDate = moment();

            getStats();
            
            setTimeout(function () {
                getSubscriptionGraphData();
            }, 500);

            const subscriptionsChart = new Chart($('#subscriptionsChart').get(0).getContext('2d'), {
                type: 'line',
                data: {
                    labels: [],
                    datasets: []
                },
                options: {
                    responsive: true
                }
            });

            $('.subscription_date_range').daterangepicker({
                opens:'left',
                dateLimit: { days: 30 },
                startDate,
                endDate,
                locale: {
                    format: 'YYYY-MM-DD',
                    applyLabel: '{{ transLang("apply") }}',
                    cancelLabel: '{{ transLang("cancel") }}',
                    customRangeLabel: '{{ transLang("custom") }}',
                },
                ranges: {
                    '{{ transLang("today") }}': [moment(), moment()],
                    '{{ transLang("yesterday") }}': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '{{ transLang("last_7_days") }}': [moment().subtract(6, 'days'), moment()],
                    '{{ transLang("last_15_days") }}': [moment().subtract(15, 'days'), moment()],
                    '{{ transLang("this_month") }}': [moment().startOf('month'), moment().endOf('month')],
                    '{{ transLang("last_month") }}': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                },
            }, (start, end) => {
                startDate = start;
                endDate = end;
                getSubscriptionGraphData();
            });

            function getStats() {
                $.ajax({
                    dataType: 'json',
                    type: 'GET',
                    url: '{{ route("admin.dashboard.stats") }}',
                    error: function (response) {
                        $('.total_users, .total_vehicles, .total_services, .total_products, .total_coupons, .total_vendors, .total_companies, .total_bookings').text('0');
                    },
                    success: function (response) {
                        $.each(response, function (key, val) {
                            $(`.${key}`).text(val);
                        });
                    }
                });
            }

            function getSubscriptionGraphData() {
                $.ajax({
                    dataType: 'json',
                    type: 'GET',
                    url: '{{ route("admin.dashboard.subscriptions.graph") }}',
                    data: {
                        start_date: startDate.lang('en').format('YYYY-MM-DD'),
                        end_date: endDate.lang('en').format('YYYY-MM-DD'),
                    },
                    success: function (response) {
                        subscriptionsChart.data = {
                            labels: response.labels,
                            datasets: [{
                                label: '{{ transLang("no_of_subscriptions") }}',
                                data: response.subscriptions,
                                borderColor: "rgb(255,136,162)",
                                backgroundColor: 'rgb(255,136,162, .4)',
                                borderWidth: 1.5,
                            }]
                        };
                        subscriptionsChart.update();

                        $.each(response.stats, function (key, val) {
                            $(`.${key}`).text(val);
                        });
                    }
                });
            }
        });
    </script>
@endsection