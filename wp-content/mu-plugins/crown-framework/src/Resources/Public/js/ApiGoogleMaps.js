(function($) {

	$(document).ready(function() {

		initGoogleMaps($('.google-map'));

	});

	function initGoogleMaps(maps) {
		$(document).on('googleMapAutoInit', '.google-map', function(e) {
			initGoogleMap($(this));
		});
		maps.trigger('googleMapAutoInit');
	}

	function initGoogleMap(mapEl) {
		var mapId = mapEl.attr('id');
			
		var mapData = {
			id: mapId,
			map: null,
			settings: mapId in window.googleMapSettings ? window.googleMapSettings[mapId] : null,
			markers: [],
			bounds: null
		};

		if(mapData.settings && mapData.settings.autoInit) {

			if(mapData.settings.options.center) {
				mapData.settings.options.center = mapData.settings.options.center instanceof google.maps.LatLng ? mapData.settings.options.center : new google.maps.LatLng(mapData.settings.options.center.lat, mapData.settings.options.center.lng);
			} else {
				mapData.settings.options.center = new google.maps.LatLng(0, 0);
			}

			mapData.map = new google.maps.Map(document.getElementById(mapId), mapData.settings.options);

			if(mapData.settings.autoAddMarkers) {

				mapData.bounds = new google.maps.LatLngBounds();
				for(var i in mapData.settings.points) {
					var point = mapData.settings.points[i];

					var position = new google.maps.LatLng(point.lat, point.lng);
					var markerSettings = {
						markerIndex: parseInt(i),
						position: position,
						map: mapData.map,
						title: point.title
					};
					if(mapData.settings.allowDraggableMarkers) {
						markerSettings.draggable = true;
					}
					var marker = new google.maps.Marker(markerSettings);

					if(mapData.settings.allowDraggableMarkers) {
						marker.addListener('drag', function() {
							$(this.map.getDiv()).trigger('googleMapMarkerDrag', [$(this.map.getDiv()), this]);
						});
					}

					mapData.markers.push(marker);
					mapData.bounds.extend(position);
				}

				if(mapData.settings.points.length) {
					mapData.map.fitBounds(mapData.bounds);
					google.maps.event.addListenerOnce(mapData.map, 'idle', function() { 
						var mapData = $(this.getDiv()).data('map-data');
						if(mapData.map.getZoom() > mapData.settings.options.zoom) {
							mapData.map.setZoom(mapData.settings.options.zoom);
						}
					});
				}

			}

			mapData.initialized = true;
			mapEl.data('map-data', mapData);
			mapEl.addClass('map-initialized');
			mapEl.trigger('mapInitialized');

		}

		mapEl.data('map-data', mapData);
		mapEl.addClass('map-configured');
		mapEl.trigger('mapConfigured');
	}

})(jQuery);