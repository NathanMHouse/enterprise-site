import React, { useState, useEffect, useLayoutEffect } from "react";
import request from 'superagent';
import LocationsFilter from './components/LocationsFilter';
import LocationsMap from './components/LocationsMap';

const LocationsTool = (props) => {
	const [locations, updateLocations]           = useState([]);
	const [type, updateType]                     = useState('');
	const [types, updateTypes]                   = useState([]);
	const [search, updateSearch]                 = useState('');
	const [country, updateCountry]               = useState('');
	const [countries, updateCountries]           = useState([]);
	const [stateProvince, updateStateProvince]   = useState('');
	const [stateProvinces, updateStateProvinces] = useState([]);
	const [city, updateCity]                     = useState('');
	const [cities, updateCities]                 = useState([]);
	const [maps, updateMaps]                     = useState({});
	const [isLoading, updateLoading]             = useState(false);

	// Load dropdowns
	useLayoutEffect(() => {
		const siteURL = (process.env.NODE_ENV === 'production') ? document.location.origin : 'http://enterprise-site.test' ;

		request
			.get(`${siteURL}/wp-json/places/v1/terms?level=0`)
			.then(results => {
				const countries = results.body.terms.map(country => ({
					name: country.name,
					id: country.id,
					slug: country.slug
				}));
				updateCountries(countries);
			});

		request
			.get(`${siteURL}/wp-json/places/v1/terms?level=1`)
			.then(results => {
				const stateProvinces = results.body.terms.map(stateProvince => ({
					name: stateProvince.name,
					id: stateProvince.id,
					slug: stateProvince.slug
				}));
				updateStateProvinces(stateProvinces);
			});

		request
			.get(`${siteURL}/wp-json/places/v1/terms?level=2`)
			.then(results => {
				const cities = results.body.terms.map(city => ({
					name: city.name,
					id: city.id,
					slug: city.slug
				}));
				updateCities(cities);
			});

		request
			.get(`${siteURL}/wp-json/wp/v2/location_types`)
			.then(results => {
				const types = results.body.map(type => ({
					name: type.name,
					id: type.id,
					slug: type.slug
				}));
				updateTypes(types);
			});
	}, []);

	// Update state/province and city fields when country field set via select
	useEffect(() => {

		const siteURL = (process.env.NODE_ENV === 'production') ? document.location.origin : 'http://enterprise-site.ise-site.test' ;
		const country = document.getElementById('select-country').value;

		request

			// If country has been selected, update state/province w/ associated state/provinces.
			// Else reset to all states/provinces.
			.get(`${siteURL}/wp-json/places/v1/terms?${country ? 'parent' : 'level'}=${country ? country : 1}`)
			.then(results => {
				const stateProvinces = results.body.terms.map(stateProvince => ({
					name: stateProvince.name,
					id: stateProvince.id,
					slug: stateProvince.slug
				})
			);
			updateStateProvinces(stateProvinces);
		});

		request

			// If country has been selected, update city w/ associated cities.
			// Else reset to all cities.
			.get(`${siteURL}/wp-json/places/v1/terms?${country ? 'cities_by_country' : 'level'}=${country ? country : 2}`)
			.then(results => {
				const cities = results.body.terms.map(city => ({
					name: city.name,
					id: city.id,
					slug: city.slug
				}));
				updateCities(cities);
		});

		// Rest city and state/province selected value.
		updateStateProvince('');
		updateCity('');
	}, [country]);

	// Update city field when state/province set via select
	useEffect(() => {

		const siteURL       = (process.env.NODE_ENV === 'production') ? document.location.origin : 'http://enterprise-site.ise-site.test' ;
		const stateProvince = document.getElementById('select-state_province').value;

		request

			// If state/province has been selected, update city w/ associated cities.
			// Else reset to all cities.
			.get(`${siteURL}/wp-json/places/v1/terms?${stateProvince ? 'cities_by_state_province=' : 'level'}=${stateProvince ? stateProvince : 2}`)
			.then(results => {
				const cities = results.body.terms.map(city => ({
					name: city.name,
					id: city.id,
					slug: city.slug
				}));
				updateCities(cities);
		});

		updateCity('');
	}, [stateProvince]);

	// Make initial request for locations
	useEffect(() => {
		function requestLocations() {
			updateLoading(true);
			const country       = document.getElementById('select-country').value;
			const stateProvince = document.getElementById('select-state_province').value;
			const city          = document.getElementById('select-city').value;
			const type          = document.getElementById('select-location_type').value;
			const keyword       = document.getElementById('form-field_search').value;
			const siteURL       = (process.env.NODE_ENV === 'production') ? document.location.origin : 'http://enterprise-site.ise-site.test' ;

			request
				.get(`${siteURL}/wp-json/locations/v1/post?s=${keyword}&country=${country}&state_province=${stateProvince}&city=${city}&location_type=${type}`)
				.then(results => {
					if (
						results.body.posts.length
					) {
						const locations = results.body.posts.map(location => ({
							id: location.id,
							permalink: (location.permalink),
							title: location.title,
							city: location.acf.city,
							contacts: location.acf.contacts,
							map: (location.acf.map) ? location.acf.map : '',
							details: (location.acf.details) ? location.acf.details : '',
							additionalNotes: (location.acf.additional_notes) ? location.acf.additional_notes : ''
						}));
						updateLocations(locations);
						updateLoading(false);
					} else {
						updateLocations([]);
						updateLoading(false);
					}
				});
		};
		requestLocations();
	}, [country, stateProvince, city, type, search]);

	// Show/hide loader
	useEffect(() => {
		const loader = document.querySelector('.site-content-loader');
		if (isLoading) {
			loader.classList.remove('hide');
		} else {
			loader.classList.add('hide');
		}
	}, [isLoading]);

  return (
  	<React.Fragment>
	  	<LocationsFilter
	  		updateLocations={updateLocations}
	  		type={type}
	  		updateType={updateType}
	  		types={types}
	  		updateTypes={updateTypes}
	  		search={search}
	  		updateSearch={updateSearch}
	  		country={country}
	  		updateCountry={updateCountry}
	  		countries={countries}
	  		updateCountries={updateCountries}
	  		stateProvince={stateProvince}
	  		updateStateProvince={updateStateProvince}
	  		stateProvinces={stateProvinces}
	  		updateStateProvinces={updateStateProvinces}
	  		city={city}
	  		updateCity={updateCity}
	  		cities={cities}
	  		updateCities={updateCities}
			/>
			<LocationsMap
				googleMapsApiKey={props.googleMapsApiKey}
				locations={locations}
				maps={maps}
				updateMaps={updateMaps}
				isLoading={isLoading}
			/>
		</React.Fragment>
  )
}

export default LocationsTool;