<?php

use Ramsey\Uuid\Uuid;
(string) $user_id = Uuid::uuid4();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<body>
    新規予約
    <form method="POST" action="{{ url('reservation/create/comfirm') }}">
        {{ csrf_field() }}
        <input type="text" name="user_id" value="{{ $user_id }}" hidden>
        <div>
            <input type="date" name="start_date">
            <input type="text" id="time_input" name="start_time" readonly>
        </div>
        <div>
            <input type="date" name="end_date">
            <input type="text" id="time_input" name="end_time" readonly>
        </div>
        <button class="btn btn-success btn-submit">Submit</button>
    </form>

<script>
    flatpickr("#time_input", {
        enableTime: true, // 時刻の選択を有効にする
        noCalendar: true, // カレンダーを非表示にする
        dateFormat: "H:i", // 時間のフォーマットを指定
    });
</script>
</body>
</html>