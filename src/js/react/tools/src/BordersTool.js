import React, { useState, useEffect, useLayoutEffect } from "react";
import request from 'superagent';
import BordersFilter from './components/BordersFilter';
import BordersTable from './components/BordersTable';

const BordersTool = (props) => {
	const [search, updateSearch]                         = useState('');
	const [origin, updateOrigin]                         = useState('');
	const [origins, updateOrigins]                       = useState([]);
	const [destination, updateDestination]               = useState('');
	const [destinations, updateDestinations]             = useState([]);
	const [borders, updateBorders]                       = useState([]);
	const [maps, updateMaps]                             = useState({});
	const [originWeather, updateOriginWeather]           = useState({});
	const [destinationWeather, updateDestinationWeather] = useState({});
	const [hasMore, updateHasMore]                       = useState(true);
	const [isLoading, updateLoading]                     = useState(false);
	const [page, updatePage]                             = useState(1);
	const [maxPages, updateMaxPages]                     = useState();
	
	// Define table row slide toggle handler
	const showBorderDetails = (e, id) => {

		// Get a reference to the button label (mobile only).
		const label = e.target.querySelector('.tool-borders-table-body-row-details-trigger-label');

		if (e.target.classList.contains('active')) {
			e.target.classList.remove('active');
			e.target.setAttribute('aria-label', 'Show');

			label.textContent = 'View Details';
		} else {
			e.target.classList.add('active');
			e.target.setAttribute('aria-label', 'Hide');

			label.textContent = 'Hide Details';
		}

		const el           = document.getElementById(id);
		const tr           = el.parentNode.parentNode;
		const scrollHeight = el.scrollHeight; // The actual height of the element
		const clientHeight = el.clientHeight; // The current height of the element
		const isCollapsed  = !clientHeight;

		el.style.height = (isCollapsed ? scrollHeight + 40 : 0)  + "px";

		if (tr.classList.contains('visible')) {
			tr.classList.remove('visible');
			tr.classList.add('hidden');
		} else {
			tr.classList.remove('hidden');
			tr.classList.add('visible');
		}
	}

	// Define the request origin weather function
	function requestOriginWeather(origin, originWeather, id) {
		if (
			(origin.city === '')
			|| (originWeather[id] !== undefined
			&& parseInt(Date.now() / 1000) < originWeather[id].expiry_time) // expiry_time is returned in seconds
		) {
			return; // Bail early if we've already made a call in the last 3 hours
		}

		const siteURL = (process.env.NODE_ENV === 'production') ? document.location.origin : 'http://enterprise-site.test' ;

		request
			.get(`${siteURL}/wp-json/borders/v1/weather?city=${origin.city}`)
			.then(results => {
				const newOriginWeather = {};
				newOriginWeather[id]  = JSON.parse(results.text);
				updateOriginWeather({...newOriginWeather, ...originWeather});
		});
	}

	// Define the request destination weather function
	function requestDestinationWeather(destination, destinationWeather, id) {
		if (
			(destination.city === '')
			|| (destinationWeather[id] !== undefined
			&& parseInt(Date.now() / 1000) < destinationWeather[id].expiry_time) // expiry_time is returned in seconds
		) {
			return; // Bail early if we've already made a call in the last 3 hours
		}

		const siteURL = (process.env.NODE_ENV === 'production') ? document.location.origin : 'http://enterprise-site.ise-site.test' ;

		request
			.get(`${siteURL}/wp-json/borders/v1/weather?city=${destination.city}`)
			.then(results => {
				const newDestinationWeather = {};
				newDestinationWeather[id]   = JSON.parse(results.text);
				updateDestinationWeather({...newDestinationWeather, ...destinationWeather});
		});
	}

	// Load origins and destinations
	useLayoutEffect(() => {

		const siteURL = (process.env.NODE_ENV === 'production') ? document.location.origin : 'http://enterprise-site.ise-site.test' ;

		request
			.get(`${siteURL}/wp-json/wp/v2/origins`)
			.then(results => {
				const origins = results.body.map(origin => ({
					name: origin.name,
					id: origin.id,
					slug: origin.slug
				}));
				updateOrigins(origins);
			});

		request
			.get(`${siteURL}/wp-json/wp/v2/destinations`)
			.then(results => {
				const destinations = results.body.map(destination => ({
					name: destination.name,
					id: destination.id,
					slug: destination.slug
				}));
				updateDestinations(destinations);
			});
	}, []);

	// Make initial request for borders
	useEffect(() => {
		function requestBorders() {
			updateLoading(true);
			const origin      = document.getElementById('select-origin').value;
			const destination = document.getElementById('select-destination').value;
			const keyword     = document.getElementById('form-field-search').value;
			const siteURL     = (process.env.NODE_ENV === 'production') ? document.location.origin : 'http://enterprise-site.ise-site.test' ;

			request
				.get(`${siteURL}/wp-json/borders/v1/post?s=${keyword}&origins=${origin}&destinations=${destination}`)
				.then(results => {
					if (
						results.body.posts.length
					) {
						const borders = results.body.posts.map(border => ({
							id: border.id,
							permalink: (border.permalink),
							details: (border.acf.show_details) ? border.acf.show_details : false,
							title: border.title,
							description: (border.acf.description) ? border.acf.description : '',
							crossing: (border.acf.crossing) ? border.acf.crossing : 'N/A',
							highway: (border.acf.highway) ? border.acf.highway : 'N/A',
							origin: (border.acf.origin) ? border.acf.origin : '',
							destination: (border.acf.destination) ? border.acf.destination : '',
							map: (border.acf.map) ? border.acf.map : ''
						}));
						updateBorders(borders);
						updatePage(2);
						updateLoading(false);
						updateMaxPages(results.body.max_pages);
					} else {
						updateBorders([]);
						updateHasMore(false);
						updateLoading(false);
					}
				});
		};
		requestBorders();
	}, [origin, destination, search]);

	// Show/hide loader
	useEffect(() => {
		const loader = document.querySelector('.site-content-loader');
		if (isLoading) {
			loader.classList.remove('hide');
		} else {
			loader.classList.add('hide');
		}
	}, [isLoading])


	// Append new borders on scroll (e.g. page 2, 3 etc.)
	useEffect(() => {
		function requestBordersOnScroll() {
			updateLoading(true);
			const origin      = document.getElementById('select-origin').value;
			const destination = document.getElementById('select-destination').value;
			const keyword     = document.getElementById('form-field-search').value;
			const siteURL     = (process.env.NODE_ENV === 'production') ? document.location.origin : 'http://enterprise-site.ise-site.test' ;
			request
				.get(`${siteURL}/wp-json/borders/v1/post?page=${page}&s=${keyword}&origin=${origin}&destination=${destination}`)
				.then(results => {
					if (
						results.body.posts.length
					) {
						const nextBorders = results.body.posts.map(border => ({
							id: border.id,
							permalink: (border.permalink),
							details: (border.acf.show_details) ? border.acf.show_details : false,
							title: border.title,
							description: (border.acf.description) ? border.acf.description : '',
							crossing: (border.acf.crossing) ? border.acf.crossing : 'N/A',
							highway: (border.acf.highway) ? border.acf.highway : 'N/A',
							origin: (border.acf.origin) ? border.acf.origin : '',
							destination: (border.acf.destination) ? border.acf.destination : '',
							map: (border.acf.map) ? border.acf.map : ''
						}));
						updateBorders([...borders, ...nextBorders]);
						updatePage(page + 1);
						updateLoading(false);
					} else {
						updateHasMore(false);
						updateLoading(false);
					}
				});
		};

		window.onscroll = () => {
			if (!hasMore || isLoading || page > maxPages) return;
			if (
				window.innerHeight + document.documentElement.scrollTop >
				document.documentElement.offsetHeight * .75
			) {
				requestBordersOnScroll();
			}
		};
	});

  return (
  	<React.Fragment>
	  	<BordersFilter
	  		origin={origin}
	  		origins={origins}
	  		updateOrigin={updateOrigin}
	  		destination={destination}
	  		destinations={destinations}
	  		updateDestination={updateDestination}
	  		search={search}
	  		updateSearch={updateSearch}
	  		updateBorders={updateBorders}
	  		updateHasMore={updateHasMore}
	  		updatePage={updatePage}
			/>
			<BordersTable
				googleMapsApiKey={props.googleMapsApiKey}
				borders={borders}
				originWeather={originWeather}
				updateOriginWeather={updateOriginWeather}
				requestOriginWeather={requestOriginWeather}
				destinationWeather={destinationWeather}
				updateDestinationWeather={updateDestinationWeather}
				requestDestinationWeather={requestDestinationWeather}
				maps={maps}
				updateMaps={updateMaps}
				isLoading={isLoading}
				showBorderDetails={showBorderDetails}
			/>
		</React.Fragment>
  )
}

export default BordersTool;