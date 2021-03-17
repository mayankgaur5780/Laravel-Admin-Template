@extends('admin.layouts.master')

@section('title') {{ transLang('detail') }} @endsection

@section('content')
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ transLang('dashboard') }}</a></li>
            <li><a href="{{ route('admin.users.index') }}">{{ transLang('all_users') }}</a></li>
            <li class="active">{{ transLang('detail') }}</li>
        </ol>
    </section>

    <section class="content">
        <p>
            <a class="btn btn-success btn-floating" href="{{ route('admin.users.update', $user->id) }}">{{ transLang('update') }}</a>
        </p>
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#basic-info-tab">{{ transLang('basic_info') }}</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="basic-info-tab">
                            <table class="table table-striped table-bordered no-margin">
                                <tbody>
                                    <tr>
                                        <th width="20%">{{ transLang('name') }}</th>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ transLang('mobile') }}</th>
                                        <td>{{ "+{$user->dial_code} {$user->mobile}" }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ transLang('email') }}</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ transLang('status') }}</th>
                                        <td>{{ transLang('action_status')[$user->status] }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ transLang('profile_image') }}</th>
                                        <td>
                                            @if (!empty($user->profile_image))
                                                <img src="{{ imageBasePath($user->profile_image) }}" width="60"/>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
