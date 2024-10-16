@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
  @vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
  @vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('page-script')
  @vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')



{{--  <div class="">--}}
{{--    <div class="max-w-7xl mx-auto sm:px-6 lg:px-1">--}}
{{--      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">--}}
{{--        <div class="p-6">--}}
{{--          <chat-component :user="{{ $user }}" :current-user="{{ auth()->user() }}"></chat-component>--}}
          <calls-component/>
{{--        </div>--}}
{{--      </div>--}}
{{--    </div>--}}
{{--  </div>--}}

@endsection
