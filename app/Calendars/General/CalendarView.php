<?php
namespace App\Calendars\General;

use Carbon\Carbon;
use Auth;

class CalendarView{

  private $carbon;
  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  public function render(){
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table m-auto border">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th class="border">月</th>';
    $html[] = '<th class="border">火</th>';
    $html[] = '<th class="border">水</th>';
    $html[] = '<th class="border">木</th>';
    $html[] = '<th class="border">金</th>';
    $html[] = '<th class="border">土</th>';
    $html[] = '<th class="border">日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';

    $weeks = $this->getWeeks();
    $startDay = $this->carbon->copy()->firstOfMonth()->format("Y-m-d");
    $endDay = $this->carbon->copy()->lastOfMonth()->format("Y-m-d");

    foreach($weeks as $week){
        $html[] = '<tr class="'.$week->getClassName().'">';
        $days = $week->getDays();
        foreach($days as $day){
            $date = $day->everyDay();
            $today = Carbon::now()->format("Y-m-d");
            $isPast = $date < $today; // 過去日かどうかをチェック
            $isCurrentMonth = ($date >= $startDay && $date <= $endDay); // 現在の月の日付かどうかをチェック

            $backgroundClass = $isPast && $isCurrentMonth ? 'past-day' : '';
            $statusText = '';

            if ($isCurrentMonth) {
                if (in_array($date, $day->authReserveDay())) {
                    $reservation = $day->authReserveDate($date)->first();
                    $reservePart = $reservation->setting_part;
                    if ($reservePart == 1) {
                        $reservePart = "リモ1部";
                    } elseif ($reservePart == 2) {
                        $reservePart = "リモ2部";
                    } elseif ($reservePart == 3) {
                        $reservePart = "リモ3部";
                    }

                    if ($isPast) {
                        // 過去日で予約している場合
                        $statusText = '<p class="m-auto p-0 w-75" style="font-size:12px">' . $reservePart . '</p>';
                        $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
                    } else {
                        // 未来日で予約している場合
                        $statusText = '<button type="submit" class="btn btn-danger cancel-modal-open p-0 w-75" name="delete_date" style="font-size:12px" part="' . $reservation->setting_reserve . '">' . $reservePart . '</button>';
                          $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';

                    }
                } else {
                    // 予約していない場合
                    if ($isPast) {
                        $statusText = '<p class="m-auto p-0 w-75" style="font-size:12px">受付終了</p>';
                          $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
                    } else {
                        $statusText = $day->selectPart($date);
                    }
                }
            }

            $html[] = '<td class="' . $backgroundClass . ' border ' . $day->getClassName() . '">';
            $html[] = $day->render();
            $html[] = $statusText;
            $html[] = $day->getDate();
            $html[] = '</td>';
        }
        $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">'.csrf_field().'</form>';
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">'.csrf_field().'</form>';

    return implode("", $html);
}



  protected function getWeeks(){
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth();
    $lastDay = $this->carbon->copy()->lastOfMonth();
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    while($tmpDay->lte($lastDay)){
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }




}
