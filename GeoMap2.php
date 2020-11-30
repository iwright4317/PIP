<?php
session_start();
?>
<head>

	<!DOCTYPE html>
	<html>
		<head>
			<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
			<meta charset="utf-8">
			<title>VMAR Geocoding service</title>
			<style>
				html, body, #map-canvas {
					height: 300px;
					margin: 0px;
					padding: 0px
				}
				#panel {
					position: absolute;
					top: 5px;
					left: 50%;
					margin-left: -180px;
					z-index: 5;
					background-color: #fff;
					padding: 5px;
					border: 1px solid #999;
				}
			</style>

			<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
			<script>
				/**
				 * @fileoverview Sample showing capturing a KML file click
				 *   and displaying the contents in a side panel instead of
				 *   an InfoWindow
				 */

				var map;
				var src = 'https://developers.google.com/maps/tutorials/kml/westcampus.kml';

				/**
				 * Initializes the map and calls the function that creates polylines.
				 */
				function initialize() {
					map = new google.maps.Map(document.getElementById('map-canvas'), {
						center : new google.maps.LatLng(-19.257753, 146.823688),
						zoom : 2,
						mapTypeId : google.maps.MapTypeId.TERRAIN
					});
					loadKmlLayer(src, map);
				}

				/**
				 * Adds a KMLLayer based on the URL passed. Clicking on a marker
				 * results in the balloon content being loaded into the right-hand div.
				 * @param {string} src A URL for a KML file.
				 */
				function loadKmlLayer(src, map) {
					var kmlLayer = new google.maps.KmlLayer(src, {
						suppressInfoWindows : true,
						preserveViewport : false,
						map : map
					});
					google.maps.event.addListener(kmlLayer, 'click', function(event) {
						var content = event.featureData.infoWindowHtml;
						var testimonial = document.getElementById('capture');
						testimonial.innerHTML = content;
					});
				}


				google.maps.event.addDomListener(window, 'load', initialize);
			</script>

		</head>

		<body>
			<div id="map-canvas"></div>
			<div id="capture"></div>
		</body>
	</html>
