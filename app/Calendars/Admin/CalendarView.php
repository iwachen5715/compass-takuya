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

 function render(){
  $html = [];
  $html[] = '<div class="calendar text-center">';
  $html[] = '<table class="table">';
  $html[] = '<thead>';
  $html[] = '<tr>';
  $html[] = '<th>月</th>';
  $html[] = '<th>火</th>';
  $html[] = '<th>水</th>';
  $html[] = '<th>木</th>';
  $html[] = '<th>金</th>';
  $html[] = '<th>土</th>';
  $html[] = '<th>日</th>';
  $html[] = '</tr>';
  $html[] = '</thead>';
  $html[] = '<tbody>';
  $weeks = $this->getWeeks();
  foreach($weeks as $week){
    $html[] = '<tr class="'.$week->getClassName().'">';
    $days = $week->getDays();
    foreach($days as $day){
      $date = $day->everyDay();
      $today = Carbon::now()->format("Y-m-d");
      $past = $date < $today; // 過去日かどうかをチェック

      $backgroundClass = $past ? 'past-day' : '';
      $statusText = $past
        ? ($this->getReservationStatus($date)['isReserved'] ? $this->formatReservationStatus($this->getReservationStatus($date)['parts']) : '<p class="m-0">受付終了</p>')
        : $day->selectPart($date);

      $html[] = '<td class="' . $backgroundClass . ' calendar-td ' . $day->getClassName() . '">';
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

  return implode('', $html);
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
