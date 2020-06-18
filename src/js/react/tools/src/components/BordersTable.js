import React from "react";
import BordersTableHeader from './BordersTableHeader';
import BordersTableRowSummary from './BordersTableRowSummary';
import BordersTableRowDetails from './BordersTableRowDetails';
import BordersTableRowNoResults from './BordersTableRowNoResults';
import SharedLoader from './SharedLoader';

const BordersTable = ({
	googleMapsApiKey,
	borders,
	showBorderDetails,
	originWeather,
	requestOriginWeather,
	updateOriginWeather,
	destinationWeather,
	requestDestinationWeather,
	updateDestinationWeather,
	maps,
	updateMaps,
	isLoading
}) => {
	return (
		<div className="tool-borders-table-container">
			<div className="grid-container">
				<div className="grid-x grid-margin-x">
					<table className="tool-borders-table cell medium-12">
						<BordersTableHeader />
						<tbody className="tool-borders-table-body">
							{!isLoading && !borders.length ? (
								<BordersTableRowNoResults />
							) : (
								borders.map((border, i) => {
									return (
										<React.Fragment key={border.id}>
											<BordersTableRowSummary
												id={border.id}
												index={i}
												details={border.details}
												highway={border.highway}
												crossing={border.crossing}
												origin={border.origin}
												originWeather={originWeather}
												requestOriginWeather={requestOriginWeather}
												destination={border.destination}
												destinationWeather={destinationWeather}
												requestDestinationWeather={requestDestinationWeather}
												map={border.map}
												maps={maps}
												updateMaps={updateMaps}
												showBorderDetails={showBorderDetails}
											/>
											<BordersTableRowDetails
												id={border.id}
												index={i}
												googleMapsApiKey={googleMapsApiKey}
												title={border.title}
												description={border.description}
												permalink={border.permalink}
												origin={border.origin}
												originWeather={originWeather}
												destination={border.destination}
												destinationWeather={destinationWeather}
												maps={maps}
											/>
										</React.Fragment>
									);
								})
							)}
						</tbody>
					</table>
				</div>
			</div>
			<SharedLoader loaderClass="site-content-loader-borders-tool"/>
		</div>
	);
};

export default BordersTable;