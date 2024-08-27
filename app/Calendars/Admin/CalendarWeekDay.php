<?php
namespace App\Calendars\Admin;

use Carbon\Carbon;
use App\Models\Calendars\ReserveSettings;
use Illuminate\Support\Facades\Route;

class CalendarWeekDay {
    protected $carbon;

    function __construct($date) {
        $this->carbon = new Carbon($date);
    }

    function getClassName() {
        return "day-" . strtolower($this->carbon->format("D"));
    }

    function render() {
        return '<p class="day">' . $this->carbon->format("j") . '日</p>';
    }

    function everyDay() {
        return $this->carbon->format("Y-m-d");
    }

   function dayPartCounts($ymd) {
    $html = [];
    $html[] = '<div class="text-left">';

    // Fetch reservations for each part
    $one_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first();
    $two_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first();
    $three_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first();

    // Display the number of reservations and link to the details page
    $html[] = '<div class="part-info">';
    if ($one_part) {
        $html[] = '<a href="' . route('reserve.details', ['date' => $ymd, 'part' => '1']) . '" class="text-decoration-none">1部</a> <span>' . $one_part->users->count() . '人</span>';
    } else {
        $html[] = '<a href="' . route('reserve.details', ['date' => $ymd, 'part' => '1']) . '" class="text-decoration-none">1部</a> <span>0人</span>';
    }
    $html[] = '</div>';

    $html[] = '<div class="part-info">';
    if ($two_part) {
        $html[] = '<a href="' . route('reserve.details', ['date' => $ymd, 'part' => '2']) . '" class="text-decoration-none">2部</a> <span>' . $two_part->users->count() . '人</span>';
    } else {
        $html[] = '<a href="' . route('reserve.details', ['date' => $ymd, 'part' => '2']) . '" class="text-decoration-none">2部</a> <span>0人</span>';
    }
    $html[] = '</div>';

    $html[] = '<div class="part-info">';
    if ($three_part) {
        $html[] = '<a href="' . route('reserve.details', ['date' => $ymd, 'part' => '3']) . '" class="text-decoration-none">3部</a> <span>' . $three_part->users->count() . '人</span>';
    } else {
        $html[] = '<a href="' . route('reserve.details', ['date' => $ymd, 'part' => '3']) . '" class="text-decoration-none">3部</a> <span>0人</span>';
    }
    $html[] = '</div>';

    $html[] = '</div>';

    return implode("", $html);
}


    function onePartFrame($day) {
        $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first();
        if ($one_part_frame) {
            return $one_part_frame->limit_users;
        }
        return "20";
    }

    function twoPartFrame($day) {
        $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first();
        if ($two_part_frame) {
            return $two_part_frame->limit_users;
        }
        return "20";
    }

    function threePartFrame($day) {
        $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first();
        if ($three_part_frame) {
            return $three_part_frame->limit_users;
        }
        return "20";
    }

    function dayNumberAdjustment() {
        $html = [];
        $html[] = '<div class="adjust-area">';
        $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;" name="1" type="text" form="reserveSetting"></p>';
        $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;" name="2" type="text" form="reserveSetting"></p>';
        $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="3" type="text" form="reserveSetting"></p>';
        $html[] = '</div>';
        return implode('', $html);
    }
}
