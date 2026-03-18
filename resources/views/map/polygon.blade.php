<!DOCTYPE html>
<html>

<head>
    <title>Draw Polygon</title>

    @vite('resources/js/polygon.js')

    <style>
        #map {
            width: 100%;
            height: 500px;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    <h2>Draw Polygon & Save</h2>

    <button onclick="savePolygon()">Save Polygon</button>

    <div id="map"></div>

</body>

</html>
