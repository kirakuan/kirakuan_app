<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    新規予約: 確認
    <form method="POST" action="{{ url('reservation/create/comfirmed') }}">

        <div>
            <p>{{ $request->start_date }} {{ $request->start_date_time }}</p>
            <p>{{ $request->end_date }} {{ $request->end_date_time }}</p>
        </div>
        {{ csrf_field() }}
        <input type="text" name="user_id" value="{{ $request->user_id }}" hidden>
        <div>
            <input type="date" name="start_date" value="{{ $request->start_date }}" hidden>
            <input type="text" name="start_time" value="{{ $request->start_time }}" hidden>
        </div>
        <div>
            <input type="date" name="end_date" value="{{ $request->end_date }}" hidden>
            <input type="text" name="end_time" value="{{ $request->end_time }}" hidden>
        </div>
        <button class="btn btn-success btn-submit">Submit</button>
    </form>
</body>
</html>