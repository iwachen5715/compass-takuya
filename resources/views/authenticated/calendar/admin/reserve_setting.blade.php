@extends('layouts.sidebar')

@section('content')
<div class="pt-5" style="background:#ECF1F6; margin-bottom:50px">
  <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF ;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); border-radius:10px; ">
    <div class="w-75 m-auto">
      <!-- カレンダーのタイトル部分（ボーダーなし） -->
      <p class="text-center">{{ $calendar->getTitle() }}</p>
    </div>

    <!-- ボーダーが適用されるカレンダー部分 -->
    <div class="w-75 m-auto border" style="border-radius:5px;">
      <div class="day-setting">
        {!! $calendar->render() !!}
      </div>
    </div>
    <div class="text-right w-75 m-auto">
      <input type="submit" class="btn btn-primary" value="登録" form="reserveSetting"
      onclick="return confirm('登録してよろしいですか？')">
    </div>
  </div>
</div>
@endsection
