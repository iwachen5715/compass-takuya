@extends('layouts.sidebar')

@section('content')
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); border-radius:10px;">
    <div class="w-75 m-auto border" style="border-radius:5px;">
      <p class="text-center">{{ $calendar->getTitle() }}</p>
      <div class="">
        {!! $calendar->render() !!}
      </div>
    </div>
    <div class="text-right w-75 m-auto">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>
  </div>
</div>

<!-- キャンセルモーダル -->
<div class="modal js-modal">
  <div class="modal__bg js-modal-close"></div>
  <div class="modal__content">
    <form action="{{ route('deleteParts') }}" method="POST" id="cancelForm">
      <div class="w-100">
        <!-- 予約情報を表示する部分 -->
        <div class="reservation-details w-50 m-auto pt-3 pb-3">
          <p>予約日: <span id="modalDate"></span></p>
          <p>時間: <span id="modalTime"></span></p>
        </div>

        <!-- キャンセル確認メッセージ -->
        <div class="w-50 m-auto pt-3 pb-3">
          <p>上記の予約をキャンセルしてもよろしいですか？</p>
        </div>
        <div class="w-50 m-auto edit-modal-btn d-flex">
          <a class="js-modal-close btn btn-danger d-inline-block"  href="">閉じる</a>
          <input type="hidden" id="reservationId" name="reservation_id" value="">
          <input type="submit" class="btn btn-danger d-block" value="キャンセルする">
        </div>
      </div>
      {{ csrf_field() }}
    </form>
  </div>
</div>

@endsection
