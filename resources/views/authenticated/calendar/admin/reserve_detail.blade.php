@extends('layouts.sidebar')

@section('content')
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-75 h-75">
    <!-- 該当日時を表示 -->
    <p><span>{{ $date }}</span><span class="ml-3">{{ $part }}部</span></p>

    <!-- 白い枠の予約詳細部分 -->
    <div class="border w-100 m-auto p-4" style="border-radius:10px; background:#FFF; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
      <table class="table table-striped">
        <thead>
            <tr class="text-center text-span">
                <th class="w-25 text-cell">ID</th>
                <th class="w-25 text-cell">名前</th>
                <th class="w-25 text-cell">場所</th>
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
