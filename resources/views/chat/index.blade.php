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
  <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
    <div class="p-6 text-gray-900">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
{{--        @foreach ($users as $user)--}}
{{--          <a href="{{ route('chat', $user->id) }}" class="bg-gray-100 p-4 rounded-lg shadow-md block hover:bg-gray-200">--}}
{{--            <h3 class="text-lg font-semibold">{{ $user->name }}</h3>--}}
{{--            <p>{{ $user->email }}</p>--}}
{{--          </a>--}}
{{--        @endforeach--}}
      </div>
    </div>
  </div>

@endsection
