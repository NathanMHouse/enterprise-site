import React from "react";

let BordersTableRowSummary = ({
	id,
	index,
	details,
	highway,
	crossing,
	origin,
	originWeather,
	requestOriginWeather,
	destination,
	destinationWeather,
	requestDestinationWeather,
	map,
	maps,
	updateMaps,
	showBorderDetails
}) => {
	let originPort           = origin.port ? origin.port : String.fromCharCode(8212);
	let originCity           = origin.city ? origin.city : String.fromCharCode(8212);
	let originStateProv      = origin.state_province ? origin.state_province : String.fromCharCode(8212);
	highway                  = highway ? highway : String.fromCharCode(8212);
	crossing                 = crossing ? crossing : String.fromCharCode(8212);
	let destinationPort      = destination.port ? destination.port : String.fromCharCode(8212);
	let destinationCity      = destination.city ? destination.city : String.fromCharCode(8212);
	let destinationStateProv = destination.state_province ? destination.state_province : String.fromCharCode(8212);
	return (
		<tr className={'tool-borders-table-body-row-summary tool-borders-table-body-row-summary-' + index}>
			<td data-label="Port of Origin">{originPort}</td>
			<td data-label="Origin">{originCity}, {originStateProv}</td>
			<td data-label="Highway">{highway}</td>
			<td data-label="Crossing">{crossing}</td>
			<td data-label="Port of Exit">{destinationPort}</td>
			<td data-label="Destination">{destinationCity}, {destinationStateProv}</td>
			<td>{details
				? (
				<button
					className="tool-borders-table-body-row-details-trigger"
					aria-label="Show"
					onClick={(e) => {
						requestOriginWeather(origin, originWeather, id);
						requestDestinationWeather(destination, destinationWeather, id);
						showBorderDetails(e, id);

						if ( isNaN(map.lat) && isNaN(map.lng)) {
							return; // Bail early if we don't have map data
						}

						// Generate new map data
						const newMaps = {};
						newMaps[id] = {
							lat: map.lat ? map.lat : 42.303131,
							lng: map.lng ? map.lng : -83.015341
						}

						updateMaps({...newMaps, ...maps});
					}}
				><span className="tool-borders-table-body-row-details-trigger-label hide-for-medium">View Details</span></button>
				) : 'N/A'
			}</td>
		</tr>
	);
};

export default BordersTableRowSummary;