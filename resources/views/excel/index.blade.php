@extends('layouts/contentNavbarLayout')

@section('title', 'Excel List Dashboard -Import Export Excel to Database')


@section('content')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<excel-list></excel-list>
{{--<div class="container">--}}
{{--  <div class="card mt-5">--}}
{{--    <h3 class="card-header p-3"><i class="fa fa-star"></i>Import Export Excel to Database</h3>--}}
{{--    <div class="card-body">--}}

{{--      @session('success')--}}
{{--      <div class="alert alert-success" role="alert">--}}
{{--        {{ $value }}--}}
{{--      </div>--}}
{{--      @endsession--}}

{{--      @if ($errors->any())--}}
{{--        <div class="alert alert-danger">--}}
{{--          <strong>Whoops!</strong> There were some problems with your input.<br><br>--}}
{{--          <ul>--}}
{{--            @foreach ($errors->all() as $error)--}}
{{--              <li>{{ $error }}</li>--}}
{{--            @endforeach--}}
{{--          </ul>--}}
{{--        </div>--}}
{{--      @endif--}}

{{--      <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">--}}
{{--        @csrf--}}

{{--        <input type="file" name="file" class="form-control">--}}

{{--        <br>--}}
{{--        <button class="btn btn-success"><i class="fa fa-file"></i> Import User Data</button>--}}
{{--      </form>--}}

{{--      <table class="table table-bordered mt-3">--}}
{{--        <tr>--}}
{{--          <th colspan="3">--}}
{{--            List Of Something--}}
{{--            <a class="btn btn-warning float-end" href="{{ route('users.export') }}"><i class="fa fa-download"></i> Export something Data</a>--}}
{{--          </th>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--          <th>ID</th>--}}
{{--          <th>Name</th>--}}
{{--        </tr>--}}
{{--        @foreach($users as $user)--}}
{{--          <tr>--}}
{{--            <td>{{ $user->id }}</td>--}}
{{--            <td>{{ $user->name }}</td>--}}
{{--          </tr>--}}
{{--        @endforeach--}}
{{--      </table>--}}

{{--    </div>--}}
{{--  </div>--}}
{{--</div>--}}


@endsection
