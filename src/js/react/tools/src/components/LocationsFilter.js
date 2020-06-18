import React from "react";

const LocationsFilter = ({
	updateLocations,
	type,
	updateType,
	types,
	updateTypes,
	search,
	updateSearch,
	country,
	updateCountry,
	countries,
	updateCountries,
	stateProvince,
	updateStateProvince,
	stateProvinces,
	updateStateProvinces,
	city,
	updateCity,
	cities,
	updateCities
}) => {

  return (
  	<div className="tool-locations-filter">
  		<div className="grid-container">
  			<form
  				id="tool-locations-filter-form"
  				action=""
  				method="post"
				>
					<div className="grid-x grid-margin-x">
						<div className="tool-locations-filter-form-intro cell large-3 medium-12">
							<h3>Filter Locations & Contacts</h3>
							<p>Locations can be sorted by country, state/province, city, and type. Additionally, a keyword search is available for more granular filtering (e.g. staff name, service etc.).</p>
						</div>
						<div className="tool-locations-filter-form-content cell large-9">
							<p className="form-field form-field-33">
								<label htmlFor="select-country">Country</label>
								<select
									id="select-country"
									name="select-country"
									value={country}
									onChange={e => {
										updateCountry(e.target.value);
										updateLocations([]);
									}}
								>
									<option value="">All Countries</option>
									{countries.map(country => (
										<option
											key={country.id}
											value={country.slug}
										>
										{country.name}
										</option>
									))}
								</select>
							</p>
							<p className="form-field form-field-33">
								<label htmlFor="select-state_province">State/Province</label>
								<select
									id="select-state_province"
									name="select-state_province"
									value={stateProvince}
									onChange={e => {
										updateStateProvince(e.target.value);
										updateLocations([]);
									}}
								>
									<option value="">All State/Provinces</option>
									{stateProvinces.map(stateProvince => (
										<option
											key={stateProvince.id}
											value={stateProvince.slug}
										>
										{stateProvince.name}
										</option>
									))}
								</select>
							</p>
							<p className="form-field form-field-33">
								<label htmlFor="select-city">City</label>
								<select
									id="select-city"
									name="select-city"
									value={city}
									onChange={e => {
										updateCity(e.target.value);
										updateLocations([]);
									}}
								>
									<option value="">All Cities</option>
									{cities.map(city => (
										<option
											key={city.id}
											value={city.slug}
										>
										{city.name}
										</option>
									))}
								</select>
							</p>
							<p className="form-field form-field-33">
								<label htmlFor="select-location_type">Type</label>
								<select
									id="select-location_type"
									name="select-location_type"
									value={type}
									onChange={e => {
										updateType(e.target.value);
										updateLocations([]);
									}}
								>
									<option value="">All Types</option>
									{types.map(type => (
										<option
											key={type.id}
											value={type.slug}
										>
										{type.name}
										</option>
									))}
								</select>
							</p>
							<p className="form-field form-field-66">
								<label htmlFor="form-field_search">Search</label>
								<input
									type="text"
									name="form_field_search"
									id="form-field_search"
									value={search}
									onChange={e => {
										updateSearch(e.target.value)
										updateLocations([]);
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

export default LocationsFilter;