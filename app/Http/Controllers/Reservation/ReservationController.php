<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Log\Logger;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Reservation\ReservationCreateRequest;

class ReservationController extends Controller
{
    use HasUuids;

    public function index()
    {
        # 現在の予約済みの情報を返す。

        # TODO: フロントで、この情報以外については予約可能とする

        $reservation_list = Reservation::where([
            "is_booked" => True,
            "is_deleted" => False
        ])->orderBy('start_date_time', 'ASC')->get();

        return view('welcome2', ["reservation_list" => $reservation_list]);
    }

    public function auth_index()
    {
        return view('welcome3');
    }

    public function show(Reservation $reservation)
    {
    }

    public function edit(Reservation $reservation)
    {

    }

    public function delete(Reservation $reservation)
    {
    }

    #############################################
    # 以降、新規予約の処理を行う
    #############################################
    
    public function create()
    {
        return view('create');
    }

    public function create_comfirm(ReservationCreateRequest $request)
    {   
        
        ############################
        # バリデーション
        ############################

        [$start_date_time_for_new_reservation, $end_date_time_for_new_reservation] = $this->__get_date_pare($request);

        $result = $this->__check_reservation($request, $start_date_time_for_new_reservation, $end_date_time_for_new_reservation);
        if ($result === False) {
            return "予約が埋まってます。";
        }

        return view('create_comfirm', ["request" => $request]);
    }

    public function comfirmed(ReservationCreateRequest $request)
    {
        
        ############################
        # バリデーション
        ############################

        [$start_date_time_for_new_reservation, $end_date_time_for_new_reservation] = $this->__get_date_pare($request);

        $result = $this->__check_reservation($request, $start_date_time_for_new_reservation, $end_date_time_for_new_reservation);
        if ($result === False) {
            return "予約が埋まってます。";
        }

        ############################
        # 予約する
        ############################

        (string) $reservation_id = Uuid::uuid4();

        $model = Reservation::create([
            'reservation_id' => $reservation_id,
            "user_id" => $request->user_id,
            "start_date_time" => $start_date_time_for_new_reservation,
            "end_date_time" => $end_date_time_for_new_reservation,
            "is_booked" => True,
        ]);
  
        return view('create_comfirmed');
    }

    #############################################
    # 以降、新規予約の内部処理を行う
    #############################################

    public function __get_date_pare(ReservationCreateRequest $request)
    {
        $start_date_time_for_new_reservation = null;
        $end_date_time_for_new_reservation = null;

        try {
            $start_date_time_for_new_reservation = Carbon::parse($request->start_date . " " .  $request->start_time);
            $end_date_time_for_new_reservation = Carbon::parse($request->end_date . " " .  $request->end_time);
        } catch (\Exception $e) {
            // エラーメッセージは $e->getMessage() で取得できます
            Log::debug("日時の指定がミス");
            return "";
        }

        ############################
        # バリデーション
        ############################
        
        // 開始時間 >= 終了時間の時はエラー
        if ($start_date_time_for_new_reservation->gte($end_date_time_for_new_reservation)) {
            Log::debug("開始時間 >= 終了時間の時はエラー");
            return "";
        }
        return [$start_date_time_for_new_reservation, $end_date_time_for_new_reservation];
    }
    
    public function __check_reservation(
        ReservationCreateRequest $request,
        $start_date_time_for_new_reservation,
        $end_date_time_for_new_reservation,
    ) {

        ############################
        # 予約済みか確認する
        ############################

        $query = Reservation::where([
            "is_booked" => True,
            "is_deleted" => False
        ])->whereBetween(
            "start_date_time",
            [$start_date_time_for_new_reservation, $end_date_time_for_new_reservation]
        );

        switch ($request->service_master_id) {
            case 0:
                // スタッフがつきっきりのサービス
                echo "手技";
                $query->groupBy(
                    "staff_id"
                );
                break;
            case 1:
                // 客に任せてもいいサービス
                echo "温熱ドーム";
                $query->groupBy(
                    "service_master_id"
                );
                break;
        }

        $reservation_list = $query->get();
        
        if (count($reservation_list) == 0) {

            return True;
        }

        return False;
    }

}
