<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;

class CalendarsController extends Controller
{
    public function show(){
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    public function reserve(Request $request){
        // dd($request);

        DB::beginTransaction();
        try{
            $getPart = $request->getPart;
            $getDate = $request->getData;
            $reserveDays = array_filter(array_combine($getDate, $getPart));

            foreach($reserveDays as $key => $value){
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                $reserve_settings->decrement('limit_users');
                $reserve_settings->users()->attach(Auth::id());
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

     public function delete(Request $request)

    {
        //  dd($request);
        // バリデーション（予約IDが必要）
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id', // reservationsテーブルに存在するIDか確認
        ]);

        // 予約IDの取得
        $reservationId = $request->input('reservation_id');

        DB::beginTransaction();
        try {
            // 予約を取得
            $reservation = Reservation::findOrFail($reservationId);

            // 予約設定を取得
            $reserve_setting = ReserveSettings::findOrFail($reservation->reserve_setting_id);

            // `limit_users`のインクリメント
            $reserve_setting->increment('limit_users');//incrementメソッドは、指定したカラムの値を1だけ増やします。'limit_users'は、インクリメントするカラム名です。この場合、ReserveSettingsテーブルにあるlimit_usersというカラムの値が1増えます。

            // 予約の削除
            $reservation->delete();

            DB::commit();

            // キャンセル完了メッセージを設定
            return redirect()->back()->with('success', '予約をキャンセルしました。');
        } catch (\Exception $e) {
            DB::rollback();
            // エラーメッセージを設定
            return redirect()->back()->with('error', '予約のキャンセルに失敗しました。');
        }
    }




}
