<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    未認証
    <ul>
    @foreach ($reservation_list as $reservation)
        <li>
            <div>
                <p>予約ID: {{$reservation->reservation_id}}</p>
                <p>開始時間: {{$reservation->start_date_time}}</p>
                <p>終了時間: {{$reservation->end_date_time}}</p>
            </div>
        </li>
    @endforeach
    </ul>
</body>
</html>