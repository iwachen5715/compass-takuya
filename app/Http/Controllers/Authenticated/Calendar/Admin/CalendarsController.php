<?php

namespace App\Http\Controllers\Authenticated\Calendar\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\Admin\CalendarView;
use App\Calendars\Admin\CalendarSettingView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;

class CalendarsController extends Controller
{
    public function show(){
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.admin.calendar', compact('calendar'));
    }

   public function reserveDetail($date, $part){
    $reservations = ReserveSettings::with('users')
        ->where('setting_reserve', $date)
        ->where('setting_part', $part)
        ->get();

    // データがない場合の処理
    if ($reservations->isEmpty() || $reservations->first()->users()->doesntExist())  {
        // dd($reservations);

        return view('authenticated.calendar.admin.reserve_detail', [
            'date' => $date,
            'part' => $part,
            'message' => '予約がありません'
        ]);

    }
    //  dd($reservations);

    // データがある場合の処理
    return view('authenticated.calendar.admin.reserve_detail', [
        'date' => $date,
        'part' => $part,
        'reservations' => $reservations,
    ]);
}

    public function reserveSettings(){
        $calendar = new CalendarSettingView(time());
        return view('authenticated.calendar.admin.reserve_setting', compact('calendar'));
    }

    public function updateSettings(Request $request){
        $reserveDays = $request->input('reserve_day');
        foreach($reserveDays as $day => $parts){
            foreach($parts as $part => $frame){
                ReserveSettings::updateOrCreate([
                    'setting_reserve' => $day,
                    'setting_part' => $part,
                ],[
                    'setting_reserve' => $day,
                    'setting_part' => $part,
                    'limit_users' => $frame,
                ]);
            }
        }
        return redirect()->route('calendar.admin.setting', ['user_id' => Auth::id()]);


    }
}
