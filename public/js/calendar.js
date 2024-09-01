$(function () {
  // キャンセルボタンがクリックされた時の処理
  $('.cancel-modal-open').on('click', function () {
    // モーダルを表示
    $('.js-modal').fadeIn();

    // ボタンの属性から予約情報を取得
    var reservation_date = $(this).attr('data-date');     // 予約日
    var reservation_time = $(this).attr('data-time');     // 予約時間（場所と部数）
    var reservation_id = $(this).attr('data-id');
    // モーダル内の予約情報を表示
    $('#modalDate').text(reservation_date);               // 予約日を表示
    $('#modalTime').text(reservation_time);               // 予約時間を表示
    $('#reservationId').val(reservation_id);


    return false; // デフォルトの動作を抑制
  });

  // モーダルの閉じるボタンの処理
  $('.js-modal-close').on('click', function () {
    $('.js-modal').fadeOut(); // モーダルを非表示にする
    return false; // デフォルトの動作を抑制
  });
});
