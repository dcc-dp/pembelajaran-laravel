<!DOCTYPE html>
<html>

<head>
    <title>Smart Complaint Map</title>

    @vite('resources/js/marker.js')

    <style>
        #map {
            width: 100%;
            height: 400px;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    <h2>Smart Complaint Map</h2>

    <div id="map"></div>

    <br>

    <form id="form">
        <input type="text" id="title" placeholder="Title"><br>
        <textarea id="description" placeholder="Description"></textarea><br>
        <input type="text" id="lat" placeholder="Latitude" readonly>
        <input type="text" id="lng" placeholder="Longitude" readonly><br>
        <button type="submit">Submit</button>
    </form>

</body>
</html>
