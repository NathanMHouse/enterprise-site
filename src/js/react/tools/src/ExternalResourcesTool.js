import React, { useState, useEffect, useLayoutEffect } from "react";
import request from 'superagent';
import ExternalResourcesFilter from './components/ExternalResourcesFilter';

const ExternalResourcesTool = () => {
	const [search, updateSearch]                       = useState('');
	const [type, updateType]                           = useState('');
	const [types, updateTypes]                         = useState([]);
	const [hasMore, updateHasMore]                     = useState(true);
	const [isLoading, updateLoading]                   = useState(false);
	const [page, updatePage]                           = useState(1);
	const [maxPages, updateMaxPages]                   = useState();
	const [externalResources, updateExternalResources] = useState([]);

	// Load external resources types
	useLayoutEffect(() => {
		const siteURL = (process.env.NODE_ENV === 'production') ? document.location.origin : 'http://enterprise-site.test' ;

		request
			.get(`${siteURL}/wp-json/wp/v2/external_resource_types`)
			.then(results => {
				const types = results.body.map(type => ({
					name: type.name,
					id: type.id,
					slug: type.slug
				}));
				updateTypes(types);
			})
	}, []);

	// Make initial request for external resources
	useEffect(() => {
		function requestExternalResources() {
			updateLoading(true);
			const type    = document.getElementById('select-external_resource_types').value;
			const keyword = document.getElementById('form-field-search').value;
			const siteURL = (process.env.NODE_ENV === 'production') ? document.location.origin : 'http://enterprise-site.ise-site.test' ;

			request
				.get(`${siteURL}/wp-json/external-resources/v1/post?s=${keyword}&external_resource_types=${type}`)
				.then(results => {
					if (
						results.body.posts.length
					) {
						const externalResources = results.body.posts.map(externalResource => ({
							title: externalResource.title,
							id: externalResource.id,
							content: externalResource.content,
							url: externalResource.acf.url
						}));
						updateExternalResources(externalResources);
						updatePage(2);
						updateLoading(false);
						updateMaxPages(results.body.max_pages);
					} else {
						updateExternalResources([]);
						updateHasMore(false);
						updateLoading(false);
					}
				});
		};
		requestExternalResources();
	}, [type, search]);

	// Show/hide loader
	useEffect(() => {
		const loader = document.querySelector('.site-content-loader');
		if (isLoading) {
			loader.classList.remove('hide');
		} else {
			loader.classList.add('hide');
		}
	}, [isLoading])


	// Append new external resources on scroll (e.g. page 2, 3 etc.)
	useEffect(() => {
		function requestExternalResourcesOnScroll() {
			updateLoading(true);
			const type    = document.getElementById('select-external_resource_types').value;
			const keyword = document.getElementById('form-field-search').value;
			const siteURL = (process.env.NODE_ENV === 'production') ? document.location.origin : 'http://enterprise-site.ise-site.test' ;

			request
				.get(`${siteURL}/wp-json/external-resources/v1/post?page=${page}&s=${keyword}&external_resource_types=${type}`)
				.then(results => {
					if (
						results.body.posts.length
					) {
						const nextExternalResources = results.body.posts.map(externalResource => ({
							title: externalResource.title,
							id: externalResource.id,
							content: externalResource.content,
							url: externalResource.acf.url
						}));
						updateExternalResources([...externalResources, ...nextExternalResources]);
						updatePage(page + 1);
						updateLoading(false);
					} else {
						updateHasMore(false);
						updateLoading(false);
					}
				});
		};

		const offset = (window.innerWidth >= 640) ? .5 : .35;

		window.onscroll = () => {
			if (!hasMore || isLoading || page > maxPages) return;
			if (
				window.innerHeight + document.documentElement.scrollTop >
				document.documentElement.offsetHeight * offset
			) {
				requestExternalResourcesOnScroll();
			}
		};
	});

  return (
  	<div>
    	<ExternalResourcesFilter
    		search={search}
    		updateSearch={updateSearch}
    		type={type}
    		updateType={updateType}
    		types={types}
    		updateTypes={updateTypes}
    		hasMore={hasMore}
    		updateHasMore={updateHasMore}
    		externalResources={externalResources}
    		updateExternalResources={updateExternalResources}
    		updatePage={updatePage}
    		isLoading={isLoading}
  		/>
  	</div>
  )
}

export default ExternalResourcesTool;