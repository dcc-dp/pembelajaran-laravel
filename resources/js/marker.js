import "ol/ol.css";

import Map from "ol/Map";
import View from "ol/View";
import TileLayer from "ol/layer/Tile";
import OSM from "ol/source/OSM";
import VectorLayer from "ol/layer/Vector";
import VectorSource from "ol/source/Vector";
import Feature from "ol/Feature";
import Point from "ol/geom/Point";
import Overlay from "ol/Overlay";
import { fromLonLat, toLonLat } from "ol/proj";

const map = new Map({
    target: "map",
    layers: [
        new TileLayer({
            source: new OSM(),
        }),
    ],
    view: new View({
        center: fromLonLat([112.7508, -7.2575]),
        zoom: 12,
    }),
});

let selectedCoord = null;

map.on("click", function (evt) {
    const coord = toLonLat(evt.coordinate);

    document.getElementById("lat").value = coord[1];
    document.getElementById("lng").value = coord[0];

    selectedCoord = coord;
});

function loadMarkers() {
    fetch("/complaints")
        .then((res) => res.json())
        .then((data) => {
            const features = data.map((item) => {
                return new Feature({
                    geometry: new Point(
                        fromLonLat([item.longitude, item.latitude])
                    ),
                    title: item.title,
                    description: item.description,
                });
            });

            const vectorLayer = new VectorLayer({
                source: new VectorSource({
                    features: features,
                }),
            });

            map.addLayer(vectorLayer);
        });
}

loadMarkers();

document.getElementById("form").addEventListener("submit", function (e) {
    e.preventDefault();

    fetch("/complaints/marker", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({
            title: document.getElementById("title").value,
            description: document.getElementById("description").value,
            latitude: document.getElementById("lat").value,
            longitude: document.getElementById("lng").value,
        }),
    }).then(() => {
        alert("Saved!");
        location.reload();
    });
});

map.on("click", function (evt) {
    map.forEachFeatureAtPixel(evt.pixel, function (feature) {
        alert(feature.get("title") + "\n" + feature.get("description"));
    });
});