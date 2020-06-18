import React from "react"
import GoogleMapReact from 'google-map-react';

const BordersTableRowDetailsMap = ({
  googleMapsApiKey,
	id,
	maps
}) => {	
	const center = {
		lat: parseFloat(maps[id].lat),
		lng: parseFloat(maps[id].lng)
	}

	const options = {
		styles: [
	    {
        "featureType": "administrative",
        "elementType": "labels.text.fill",
        "stylers": [
          {
              "color": "#0a0a0a"
          }
        ]
	    },
	    {
        "featureType": "administrative",
        "elementType": "labels.text.stroke",
        "stylers": [
          {
            "visibility": "off"
          }
        ]
	    },
	    {
        "featureType": "landscape",
        "elementType": "all",
        "stylers": [
          {
              "color": "#f6f6f6"
          }
        ]
	    },
	    {
        "featureType": "poi",
        "elementType": "all",
        "stylers": [
          {
            "visibility": "off"
          }
        ]
	    },
	    {
        "featureType": "road",
        "elementType": "all",
        "stylers": [
          {
            "saturation": -100
          },
          {
            "lightness": 45
          }
        ]
	    },
	    {
        "featureType": "road.highway",
        "elementType": "all",
        "stylers": [
          {
            "visibility": "simplified"
          }
        ]
	    },
	    {
        "featureType": "road.arterial",
        "elementType": "labels.icon",
        "stylers": [
          {
            "visibility": "off"
          }
        ]
	    },
	    {
        "featureType": "transit",
        "elementType": "all",
        "stylers": [
          {
            "visibility": "off"
          }
        ]
	    },
	    {
        "featureType": "water",
        "elementType": "all",
        "stylers": [
          {
            "color": "#dcdcdc"
          },
          {
            "visibility": "on"
          }
        ]
	    }
		]
	};
	
	return (
			<GoogleMapReact
				bootstrapURLKeys={{key: googleMapsApiKey}}
				defaultCenter={center}
				zoom={11}
				layerTypes={['TrafficLayer']}
				options={options}
			>
			</GoogleMapReact>
	);
};

export default BordersTableRowDetailsMap;