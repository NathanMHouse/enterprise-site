import React from "react";

const BordersFilter = ({
	origin,
	origins,
	updateOrigin,
	destination,
	destinations,
	updateDestination,
	search,
	updateSearch,
	updateBorders,
	updateHasMore,
	updatePage
}) => {

  return (
  	<div className="tool-borders-filter">
  		<div className="grid-container">
  			<form
  				id="tool-borders-filter-form"
  				action=""
  				method="post"
				>
					<div className="grid-x grid-margin-x">
						<div className="tool-borders-filter-form-intro cell large-3 medium-12">
							<h3>Get Border Info</h3>
							<p>Filter borders by origin or destination to discover your desired crossing.</p>
						</div>
						<div className="tool-borders-filter-form-content cell large-9 medium-12">
							<p className="form-field form-field-33">
								<label htmlFor="select-origin">Origin</label>
								<select
									id="select-origin"
									name="origins"
									value={origin}
									onChange={e => {
										updateOrigin(e.target.value);
										updateBorders([]);
										updateHasMore(true);
										updatePage(1);
									}}
								>
									<option value="">All Origins</option>
									{origins.map(origin => (
										<option
											key={origin.id}
											value={origin.slug}
										>
										{origin.name}
										</option>
									))}
								</select>
							</p>
							<p className="form-field form-field-33">
								<label htmlFor="select-destination">Destination</label>
								<select
									id="select-destination"
									name="destinations"
									value={destination}
									onChange={e => {
										updateDestination(e.target.value);
										updateBorders([]);
										updateHasMore(true);
										updatePage(1);
									}}
								>
									<option value="">All Destinations</option>
									{destinations.map(destination => (
										<option
											key={destination.id}
											value={destination.slug}
										>
										{destination.name}
										</option>
									))}
								</select>
							</p>
							<p className="form-field form-field-33">
								<label htmlFor="form-field-search">Search</label>
								<input
									type="text"
									name="form_field_search"
									id="form-field-search"
									value={search}
									onChange={e => {
										updateSearch(e.target.value)
										updateBorders([]);
										updateHasMore(true);
										updatePage(1);
									}}
								/>
							</p>
						</div>
					</div>
				</form>
  		</div>
  	</div>
	);
};

export default BordersFilter;