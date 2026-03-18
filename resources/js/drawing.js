import "ol/ol.css";

import Map from "ol/Map";
import View from "ol/View";
import TileLayer from "ol/layer/Tile";
import VectorLayer from "ol/layer/Vector";
import OSM from "ol/source/OSM";
import VectorSource from "ol/source/Vector";

import Draw from "ol/interaction/Draw";

import Feature from "ol/Feature";
import Point from "ol/geom/Point";
import LineString from "ol/geom/LineString";
import Polygon from "ol/geom/Polygon";

import Style from "ol/style/Style";
import Stroke from "ol/style/Stroke";
import Fill from "ol/style/Fill";
import CircleStyle from "ol/style/Circle";

import { fromLonLat, toLonLat } from "ol/proj";

function getStyle(type) {
    if (type === "Point") {
        return new Style({
            image: new CircleStyle({
                radius: 6,
                fill: new Fill({ color: "green" }),
                stroke: new Stroke({ color: "white", width: 2 }),
            }),
        });
    }

    if (type === "LineString") {
        return new Style({
            stroke: new Stroke({
                color: "blue",
                width: 3,
            }),
        });
    }

    if (type === "Polygon") {
        return new Style({
            stroke: new Stroke({
                color: "red",
                width: 2,
            }),
            fill: new Fill({
                color: "rgba(255, 0, 0, 0.3)",
            }),
        });
    }
}

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

let draw;

function addInteraction(type) {
    if (draw) map.removeInteraction(draw);

    draw = new Draw({
        source: source,
        type: type,
    });

    map.addInteraction(draw);

    draw.on("drawend", function (e) {
        const feature = e.feature;
        const type = feature.getGeometry().getType();

        feature.setStyle(getStyle(type)); // 🔥 AUTO STYLE

        window.currentFeature = feature;
    });
}

addInteraction("Point");

document.getElementById("type").addEventListener("change", function () {
    addInteraction(this.value);
});

window.saveDrawing = function () {
    if (!window.currentFeature) {
        alert("Draw something first!");
        return;
    }

    const geometry = window.currentFeature.getGeometry();
    const type = geometry.getType();

    let coords;

    if (type === "Point") {
        coords = toLonLat(geometry.getCoordinates());
    } else if (type === "LineString") {
        coords = geometry.getCoordinates().map((c) => toLonLat(c));
    } else if (type === "Polygon") {
        coords = geometry.getCoordinates()[0].map((c) => toLonLat(c));
    }

    fetch("/complaints/drawing", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({
            title: "Drawing",
            description: "User drawing",
            geometry: coords,
            type: type,
        }),
    })
        .then((res) => {
            if (!res.ok) throw new Error("Failed");
            return res.json();
        })
        .then(() => {
            alert("Saved!");
            location.reload();
        })
        .catch((err) => {
            console.error(err);
            alert("Error!");
        });
};

fetch("/complaints")
    .then((res) => res.json())
    .then((data) => {
        data.forEach((item) => {
            if (!item.geometry) return;

            let geom;

            if (item.type === "Point") {
                geom = new Point(fromLonLat(item.geometry));
            } else if (item.type === "LineString") {
                geom = new LineString(item.geometry.map((c) => fromLonLat(c)));
            } else if (item.type === "Polygon") {
                geom = new Polygon([item.geometry.map((c) => fromLonLat(c))]);
            }

            const feature = new Feature({
                geometry: geom,
            });

            feature.setStyle(getStyle(item.type));

            source.addFeature(feature);
        });
    });
