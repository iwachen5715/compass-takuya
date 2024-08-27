@extends('layouts.sidebar')

@section('content')
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-50 m-auto h-75">
    <!-- 該当日時を表示 -->
    <p><span>{{ $date }}</span><span class="ml-3">{{ $part }}部</span></p>

    <div class="h-75 border">
      <table class="table table-striped">
        <thead>
          <tr class="text-center">
            <th class="w-25">ID</th>
            <th class="w-25">名前</th>
            <th class="w-25">場所</th>
          </tr>
        </thead>
        <tbody>
        @if(isset($reservations))
            @foreach($reservations as $reservation)
                @foreach($reservation->users as $user)
                    <tr>
                       <td style="text-align: center;">{{ $user->id }}</td>
                       <td style="text-align: center;">{{ $user->over_name }}{{ $user->under_name }}</td>
                       <td style="text-align: center;">リモート</td>
                    </tr>
                @endforeach
            @endforeach
        @else
            <tr>
                <td colspan="3">{{$message}}</td>
            </tr>
        @endif
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
