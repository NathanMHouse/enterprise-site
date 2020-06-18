import React from "react";
import BordersTableRowDetailsMap from './BordersTableRowDetailsMap';

const BordersTableRowDetails = ({
	googleMapsApiKey,
	index,
	id,
	title,
	description,
	permalink,
	origin,
	originWeather,
	destination,
	destinationWeather,
	maps
}) => {	
	return (
		<tr className={'tool-borders-table-body-row-details tool-borders-table-body-row-details-' + index + ' hidden'}>
			<td colSpan="7">
				<div
					className="tool-borders-table-body-row-details-inner grid-x grid-margin-x"
					id={id}
				>

					<div className="cell medium-6 medium-order-2 small-order-1">
						<div className="tool-borders-table-body-row-details-map">
							{maps[id]
								?
								<BordersTableRowDetailsMap 
									googleMapsApiKey={googleMapsApiKey}
									id={id}
									maps={maps}
								/>
								: false
							}
						</div>
					</div>

					<div className="cell medium-6 medium-order-1 small-order-2">

						<div className="tool-borders-table-body-row-details-title">
							<h3>{title}</h3>
							<p>{description}</p>
							<a 
							className="tool-borders-table-body-row-details-permalink"
							href={permalink}>Read More</a>
						</div>

						{(origin.toggle && (origin.city && origin.address_i) && (origin.email || origin.phone || origin.fax)) // Origin provided and toggle is true
							|| (destination.toggle && (destination.city && destination.address_i) && (destination.email || destination.phone || destination.fax)) // Destination provided and toggle is true
							? (
							<div className="tool-borders-table-body-row-details-contact grid-x">
								{origin.toggle
									&& (origin.city && origin.address_i)
									&& (origin.email || origin.phone || origin.fax)
									? (
									<div className="tool-borders-table-body-row-details-contact-origin cell medium-6">
										<ul >
											<li><h4>Origin Branch Info</h4></li>
											{origin.address_i ? <li>{origin.address_i}</li> : false}
											{origin.address_ii ? <li>{origin.address_ii}</li> : false}
											{origin.postal_zip_code ? <li>{origin.postal_zip_code}</li> : false}
										</ul>
										<ul>
											{origin.email ? <li className="tool-borders-table-body-row-details-contact-origin-email"><a href={`mailto:${origin.email}`}>{origin.email}</a></li> : false}
											{origin.phone ? <li className="tool-borders-table-body-row-details-contact-origin-phone"><a href={`tel:${origin.phone}`}>{origin.phone}</a></li> : false}
											{origin.fax ? <li className="tool-borders-table-body-row-details-contact-origin-fax"><a href={`fax:${origin.fax}`}>{origin.fax}</a></li> : false}
										</ul>
									</div>
									) : false
								}
								{destination.toggle
									&& (destination.city && destination.address_i)
									&& (destination.email || destination.phone || destination.fax)
									? (
									<div className="tool-borders-table-body-row-details-contact-destination cell medium-6">
										<ul>
											<li><h4>Destination Branch Info</h4></li>
											{destination.address_i ? <li>{destination.address_i}</li> : false}
											{destination.address_ii ? <li>{destination.address_ii}</li> : false}
											{destination.postal_zip_code ? <li>{destination.postal_zip_code}</li> : false}
										</ul>
										<ul>
											{destination.email ? <li className="tool-borders-table-body-row-details-contact-destination-email"><a href={`mailto:${destination.email}`}>{destination.email}</a></li> : false}
											{destination.phone ? <li className="tool-borders-table-body-row-details-contact-destination-phone"><a href={`tel:${destination.phone}`}>{destination.phone}</a></li> : false}
											{destination.fax ? <li className="tool-borders-table-body-row-details-contact-destination-fax"><a href={`fax:${destination.fax}`}>{destination.fax}</a></li> : false}
										</ul>
									</div>
									) : false
								}
							</div>
							) : false
						}

						<div className="tool-borders-table-body-row-details-weather grid-x">
							<ul className="tool-borders-table-body-row-details-weather-origin cell medium-6">
								{origin.city ? <li className="tool-borders-table-body-row-details-weather-title"><h4>{origin.city ? `Current Weather in ${origin.city}` : 'Current Weather'}</h4></li> : false}
								{originWeather[id] ? <li className="tool-borders-table-body-row-details-weather-details">{originWeather[id].temp && originWeather[id].description ? `${originWeather[id].temp }${String.fromCharCode(8451)} ${String.fromCharCode(8212)} ${originWeather[id].description}` : 'N/A'}</li> : false}
							</ul>
							<ul className="tool-borders-table-body-row-details-weather-destination cell medium-6">
								{destination.city ? <li className="tool-borders-table-body-row-details-weather-title"><h4>{destination.city ? `Current Weather in ${destination.city}` : 'Current Weather'}</h4></li> : false}
								{destinationWeather[id] ? <li className="tool-borders-table-body-row-details-weather-details">{destinationWeather[id].temp && destinationWeather[id].description ? `${destinationWeather[id].temp }${String.fromCharCode(8451)} ${String.fromCharCode(8212)} ${destinationWeather[id].description}` : 'N/A'}</li> : false}
							</ul>
						</div>
					</div>

				</div>
			</td>
		</tr>
	);
};

export default BordersTableRowDetails;