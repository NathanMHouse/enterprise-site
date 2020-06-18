import React from "react"
import GoogleMapReact from 'google-map-react';
import LocationsMapMarker from './LocationsMapMarker';

const LocationsMapLocation = ({
	id,
	city,
  title,
  googleMapsApiKey,
	map,
	maps,
	permalink,
	contacts,
  additionalNotes,
  details
}) => {

  // Set default center (North America)
	const center = {
    lat: parseFloat(map.lat),
    lng: parseFloat(map.lng)
	};

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
    <section
    	id={id}
    	className="tool-locations-map-location">

    	<div className="tool-locations-map-location-header">
    		<div className="grid-container">
    			<div className="grid-x">
    				{title ? <h2>{title}</h2> : false}
    				<button
    					className="tool-locations-map-location-close"
              aria-label="Close"
    					onClick={(e) => {
								const el        = document.getElementById(id);
                const overlay   = document.getElementsByClassName('site-content-overlay')[0];

                overlay.className = 'site-content-overlay';

                el.className = 'tool-locations-map-location';

		            el.style.height = "0px";
							}}
						></button>
  				</div>
  			</div>
    	</div>

    	<div className="tool-locations-map-location-body">
    		<div className="grid-container">
    			<div className="grid-x grid-margin-x">

    				<div className="cell large-6">
    					
    					{maps[id]
    						?
    						<div className="tool-locations-map-location-body-map">
			    				<GoogleMapReact
										bootstrapURLKeys={{key: googleMapsApiKey}}
										defaultCenter={center}
										zoom={9}
										options={options}
									>
										<LocationsMapMarker
					            lat={map.lat}
					            lng={map.lng}
					          />
				          </GoogleMapReact>
								</div>
								: false
							}

							<div className="tool-locations-map-location-body-details">
								<ul className="tool-locations-map-location-body-details-details">
                  {details
                    ? <h4 className="tool-locations-map-location-body-details-details-title">Details</h4>
                    : false
                  }
                  {details
                    ?
                    details.map((detail, i) => (  
                      <li key={i}>
                        <h4>{detail.key}</h4>
                        <p dangerouslySetInnerHTML={{__html: detail.value}}></p>
                      </li>
                    ))
                    : false
                  }
                  <a 
                    className="tool-locations-map-location-body-permalink"
                    href={permalink}>Read More</a>
								</ul>
                <ul className="tool-locations-map-location-body-details-additional-notes">
                  {additionalNotes
                    ? <h4 className="tool-locations-map-location-body-details-additional-notes-title">Additional Notes</h4>
                    : false
                  }
                  {additionalNotes
                    ?
                    additionalNotes.map((additionalNote, i) => (
                      <li key={i}>
                        <h4>{additionalNote.key}</h4>
                        <p>{additionalNote.value}</p>
                      </li>
                    ))
                    : false
                  }
                </ul>
							</div>
						</div>

            <div className="cell large-6">
              <div className="tool-locations-map-location-body-contacts">
                <h4 className="tool-locations-map-location-body-contacts-title">Contacts</h4>
                {contacts
                  ?
                  contacts.map((contact, i) => (
                    <ul
                      key={i}
                      className="tool-locations-map-location-body-contact">
                      {(contact.first_name && contact.last_name) ? <li className="tool-locations-map-location-body-contact-first-name">{contact.first_name} {contact.last_name}</li> : false}
                      {(contact.job_title) ? <li className="tool-locations-map-location-body-contact-job-title">{contact.job_title}</li> : false}
                      {(contact.phone) ? <li className="tool-locations-map-location-body-contact-phone">P: <a href={`tel:${contact.phone}`}>{contact.phone}</a></li> : false}
                      {(contact.mobile) ? <li className="tool-locations-map-location-body-contact-mobile">M: <a href={`tel:${contact.mobile}`}>{contact.mobile}</a></li> : false}
                      {(contact.fax) ? <li className="tool-locations-map-location-body-contact-fax">F: <a href={`tel:${contact.fax}`}>{contact.fax}</a></li> : false}
                      {(contact.email) ? <li className="tool-locations-map-location-body-contact-email">E: <a href={`mailto:${contact.email}`}>{contact.email}</a></li> : false}
                    </ul>
                  ))
                  : <p>No contacts currently avalailable.</p>
                }
              </div>
            </div>

    			</div>
    		</div>
    	</div>
    </section>
	);
};

export default LocationsMapLocation;