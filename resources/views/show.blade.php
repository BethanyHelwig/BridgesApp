<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>State Search Results</title>
</head>
<body>
    <div>
        @foreach($cities as $city)
            echo {{ $city }};
            {{-- <p>County: {{ $cities->county_name}}, City: {{ $cities->city_name}}</p> --}}
        @endforeach
    </div>
</body>
</html>