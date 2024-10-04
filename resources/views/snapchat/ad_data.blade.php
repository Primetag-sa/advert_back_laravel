<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advertisement Data</title>
</head>
<body>
    <h1>بيانات الإعلان</h1>
    @if($adData)
        <ul>
            @foreach($adData['data'] as $ad)
                <li>اسم الإعلان: {{ $ad['name'] }} - عدد الانطباعات: {{ $ad['impressions'] }}</li>
            @endforeach
        </ul>
    @else
        <p>لا توجد بيانات للإعلانات.</p>
    @endif
</body>
</html>
