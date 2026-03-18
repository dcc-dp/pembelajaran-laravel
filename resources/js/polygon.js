import "ol/ol.css";

import Map from "ol/Map";
import View from "ol/View";

import TileLayer from "ol/layer/Tile";
import VectorLayer from "ol/layer/Vector";
import OSM from "ol/source/OSM";
import VectorSource from "ol/source/Vector";

import Feature from "ol/Feature";
import Polygon from "ol/geom/Polygon";

import Draw from "ol/interaction/Draw";

import { fromLonLat, toLonLat } from "ol/proj";

const source = new VectorSource();

const vectorLayer = new VectorLayer({
    source: source,
});

const map = new Map({
    target: "map",
    layers: [
        new TileLayer({
            source: new OSM(),
        }),
        vectorLayer,
    ],
    view: new View({
        center: fromLonLat([112.7508, -7.2575]),
        zoom: 12,
    }),
});

const draw = new Draw({
    source: source,
    type: "Polygon",
});

map.addInteraction(draw);

let drawnFeature = null;

draw.on("drawend", function (event) {
    drawnFeature = event.feature;
});

window.savePolygon = function () {
    if (!drawnFeature) {
        alert("Draw polygon first!");
        return;
    }

    const coords = drawnFeature.getGeometry().getCoordinates();

    const lonLatCoords = coords[0].map((coord) => toLonLat(coord));

    fetch("/complaints/polygon", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({
            title: "Polygon Area",
            description: "User drawn area",
            polygon: lonLatCoords,
        }),
    })
        .then((res) => {
            if (!res.ok) throw new Error("Failed to save");
            return res.json();
        })
        .then(() => {
            alert("Saved!");
            location.reload();
        })
        .catch((err) => {
            console.error(err);
            alert("Error saving data!");
        });
};

fetch("/complaints")
    .then((res) => res.json())
    .then((data) => {
        data.forEach((item) => {
            if (item.polygon) {
                const coords = JSON.parse(item.polygon);

                const polygon = new Polygon([
                    coords.map((coord) => fromLonLat(coord)),
                ]);

                const feature = new Feature({
                    geometry: polygon,
                });

                

                source.addFeature(feature);
            }
        });
    });
