import React from "react"
import GoogleMapReact from 'google-map-react';
import SharedLoader from './SharedLoader';
import LocationsMapMarker from './LocationsMapMarker';
import LocationsMapLocation from './LocationsMapLocation';

const LocationsMap = ({
  googleMapsApiKey,
	locations,
  maps,
  updateMaps,
  isLoading,
  showLocationDetails
}) => {	

  // Set default center (North America)
	const center = {
    lat: 48.3552767,
    lng: -99.9995795
	};

  const zoom = (window.innerWidth < 640) ? 2.75 : 3.75;

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
            "color": "#f6f6f6"
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
    <div
      id="tool-locations-map"
      className="tool-locations-map">
			<GoogleMapReact
        bootstrapURLKeys={{key: googleMapsApiKey}}
				defaultCenter={center}
				zoom={zoom}
				options={options}
        onChildClick={
          (key, childProps) => {
            const el           = document.getElementById(childProps.id);
            const map          = document.getElementById('tool-locations-map');
            const mapHeight    = map.scrollHeight;
            const overlay      = document.getElementsByClassName('site-content-overlay')[0];

            overlay.className += ' active';

            el.className += ' active';

            el.style.height    = mapHeight + "px";

            if ( isNaN(childProps.lat) && isNaN(childProps.lng)) {
              return; // Bail early if we don't have map data
            }

            const newMaps = {};
            newMaps[childProps.id] = {
              lat: childProps.lat ? childProps.lat : 42.303131,
              lng: childProps.lng ? childProps.lng : -83.015341
            }

            updateMaps({...newMaps, ...maps});
          }
        }
			>
        {locations.map(location => (
          <LocationsMapMarker
            key={`marker-${location.id}`}
            id={location.id}
            lat={location.map.lat}
            lng={location.map.lng}
          />
        ))}
			</GoogleMapReact>
      {locations.map(location => (
        <LocationsMapLocation
          key={`location-${location.id}`}
          id={location.id}
          googleMapsApiKey={googleMapsApiKey}
          city={location.city}
          title={location.title}
          map={location.map}
          maps={maps}
          permalink={location.permalink}
          contacts={location.contacts}
          additionalNotes={location.additionalNotes}
          details={location.details}
        />
      ))}
      <SharedLoader loaderClass="site-content-loader-locations-tool" />
    </div>
	);
};

export default LocationsMap;