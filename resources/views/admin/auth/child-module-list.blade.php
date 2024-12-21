@extends('admin.admin-layouts.master')
@section('page_title','Settings')
@section('settings_select','active')
@section('content')
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div class="d-flex justify-content-between">
            <i class="fa-solid fa-chart-line" style="padding-top: 0.7rem; padding-right: 0.4rem;"></i>
            <h3 class="fw-bold mb-3"> {{ $data }} | Child Module Dashboard </h3>
        </div>
    </div>

    <div class="row">
        @if($childModuleDetails)
            @foreach($childModuleDetails as $template)
                <div class="col-sm-6 col-md-3">
                    <a href="{{ url($template['route']) }}">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-primary bubble-shadow-small" style="background-color: {{ $template['color_code'] }};"><i class="{{ $template['icon'] }}"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">{{ $template['name'] }}</p>
                                            <p>{{ $template['query'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection