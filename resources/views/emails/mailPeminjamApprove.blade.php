<!DOCTYPE html>
<html>

<head>
    <title>Laravel 9 Send Email Example</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
</head>

<body>

    <h3>INVENTORY MANAGEMENT BINUS @BANDUNG - {{ $subjek }}</h3>
    <p>{!! $pesan !!}</p>

    <b>
        <a href="{{ route('unduh', ['request_id' => $req_id]) }}">Download Form</a>
        <p>No-Reply Email <br> Email Sent By Inventory Management Binus @Bandung System</p>
    </b>

</body>

</html>
