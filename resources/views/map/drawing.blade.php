<!DOCTYPE html>
<html>

<head>
    <title>Drawing Tool Demo</title>

    @vite('resources/js/drawing.js')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        #map {
            width: 100%;
            height: 500px;
        }
    </style>
</head>

<body>

    <h2>Drawing Tool Demo</h2>

    <select id="type">
        <option value="Point">Point</option>
        <option value="LineString">Line</option>
        <option value="Polygon">Polygon</option>
    </select>

    <button onclick="saveDrawing()">Save</button>

    <div id="map"></div>

</body>

</html>
