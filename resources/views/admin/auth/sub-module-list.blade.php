@extends('admin.admin-layouts.master')
@section('page_title','Dashboard')
@section('dashboard_select','active')
@section('content')
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3"> {{ $header }}  </h3>
        </div>
    </div>
    <!-- Sub Module Dashboard Dsplay -->
    <div class="row">
        @if($details)
            @foreach($details as $template)
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
                                            @foreach($template['query'] as $q) 
                                                <p>{{ $q }}</p>
                                            @endforeach
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

