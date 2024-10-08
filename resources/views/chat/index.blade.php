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
  <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md m-5">
    <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
      <thead class="bg-gray-50">
      <tr>
        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Name</th>
        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Status</th>
        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Username</th>
        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Role</th>
        <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
      </tr>
      </thead>
      <tbody class="divide-y divide-gray-100 border-t border-gray-100">
      @foreach ($users as $user)
      <tr class="hover:bg-gray-50">
        <th class="flex gap-3 px-6 py-4 font-normal text-gray-900">
          <div class="relative h-10 w-10">
            <img
              class="h-full w-full rounded-full object-cover object-center"
              src="{{asset('/images/admin.jpg')}}"
              alt=""
            />
            @if($user->status === 'active')
              <span class="absolute right-0 bottom-0 h-2 w-2 rounded-full bg-green-400 ring ring-white"></span>
            @else
              <span class="absolute right-0 bottom-0 h-2 w-2 rounded-full bg-red-400 ring ring-white"></span>
            @endif
          </div>
          <div class="text-sm">
            <div class="font-medium mt-3 text-gray-700">{{ $user->first_name }} {{ $user->last_name }}</div>
{{--            <div class="text-gray-400">{{ $user->email }}</div>--}}
          </div>
        </th>
        <td class="px-6 py-4">
          @if($user->status === 'active')
            <span
            class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-green-600"
          ><span class="h-1.5 w-1.5 rounded-full bg-green-600"></span>
            Active
          </span>
          @else
            <span
              class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2 py-1 text-xs font-semibold text-red-600"
            >
              <span class="h-1.5 w-1.5 rounded-full bg-red-600"></span>
              Inactive
            </span>
          @endif

        </td>
        <td class="px-6 py-4">{{$user->username}}</td>
        <td class="px-6 py-4">
          @foreach($user->roles as $role)
          @if($role->name === 'Administrator')
            <span
              class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-4 py-2 text-xs font-semibold text-blue-500"
            >
                    {{ $role->name }}
                </span>
          @elseif($role->name === 'Editor')
            <span
              class="inline-flex items-center gap-1 rounded-full bg-indigo-50 px-4 py-2 text-xs font-semibold text-indigo-600"
            >
                  {{$role->name}}
                </span>
          @else
            <span
              class="inline-flex items-center gap-1 rounded-full bg-violet-50 px-4 py-2 text-xs font-semibold text-violet-600"
            >
                    {{$role->name}}
                  </span>
          @endif
          @endforeach
        </td>
        <td class="px-6 py-4">
          <div class="flex justify-end gap-4">
            <a href="{{ route('chat', $user->id) }}" class="bg-gray-100 p-4 rounded-lg shadow-md block hover:bg-green-200">
              Send message
            </a>
          </div>
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>

@endsection
