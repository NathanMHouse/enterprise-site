import React, { useState, useEffect, useLayoutEffect } from "react";
import request from 'superagent';
import GlossaryFilter from './components/GlossaryFilter';

const Glossary = () => {
	const [search, updateSearch]     = useState('');
	const [type, updateType]         = useState('');
	const [types, updateTypes]       = useState([]);
	const [hasMore, updateHasMore]   = useState(true);
	const [isLoading, updateLoading] = useState(false);
	const [page, updatePage]         = useState(1);
	const [maxPages, updateMaxPages] = useState();
	const [terms, updateTerms]       = useState([]);


	// Load term types
	useLayoutEffect(() => {
		const siteURL = (process.env.NODE_ENV === 'production') ? document.location.origin : 'http://enterprise-site.test' ;

		request
			.get(`${siteURL}/wp-json/wp/v2/term_types`)
			.then(results => {
				const types = results.body.map(type => ({
					name: type.name,
					id: type.id,
					slug: type.slug
				}));
				updateTypes(types);
			})
	}, []);

	// Make initial request for terms
	useEffect(() => {
		function requestTerms() {
			updateLoading(true);
			const termType = document.getElementById('select-term_types').value;
			const keyword  = document.getElementById('form-field-search').value;
			const siteURL  = (process.env.NODE_ENV === 'production') ? document.location.origin : 'http://enterprise-site.ise-site.test' ;

			request
				.get(`${siteURL}/wp-json/terms/v1/post?s=${keyword}&term_types=${termType}`)
				.then(results => {
					if (
						results.body.posts.length
					) {
						const terms = results.body.posts.map(term => ({
							title: term.title,
							id: term.id,
							content: term.content,
							cta: {	
								label: (term.acf) ? term.acf.cta_i.label : 'Read more',
								target: (term.acf) ? term.acf.cta_i.target : '_self',
								url: (term.acf) ? term.acf.cta_i.url : ''
							}
						}));
						updateTerms(terms);
						updatePage(2);
						updateLoading(false);
						updateMaxPages(results.body.max_pages);
					} else {
						updateTerms([]);
						updateHasMore(false);
						updateLoading(false);
					}
				});
		};
		requestTerms();
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


	// Append new terms on scroll (e.g. page 2, 3 etc.)
	useEffect(() => {
		function requestTermsOnScroll() {
			updateLoading(true);
			const termType = document.getElementById('select-term_types').value;
			const keyword  = document.getElementById('form-field-search').value;
			const siteURL  = (process.env.NODE_ENV === 'production') ? document.location.origin : 'http://enterprise-site.ise-site.test' ;

			request
				.get(`${siteURL}/wp-json/terms/v1/post?page=${page}&s=${keyword}&term_types=${termType}`)
				.then(results => {
					if (
						results.body.posts.length
					) {
						const nextTerms = results.body.posts.map(term => ({
							title: term.title,
							id: term.id,
							content: term.content,
							cta: {	
								label: term.acf.cta_i.label,
								target: term.acf.cta_i.target,
								url: term.acf.cta_i.url
							}
						}));
						updateTerms([...terms, ...nextTerms]);
						updatePage(page + 1);
						updateLoading(false);
					} else {
						updateHasMore(false);
						updateLoading(false);
					}
				});
		};
		
		const offset = (window.innerWidth >= 640) ? .75 : .6;

		window.onscroll = () => {
			if (!hasMore || isLoading || page > maxPages) return;
			if (
				window.innerHeight + document.documentElement.scrollTop >
				document.documentElement.offsetHeight * offset
			) {
				requestTermsOnScroll();
			}
		};
	});

  return (
  	<div>
    	<GlossaryFilter
    		search={search}
    		updateSearch={updateSearch}
    		type={type}
    		updateType={updateType}
    		types={types}
    		updateTypes={updateTypes}
    		hasMore={hasMore}
    		updateHasMore={updateHasMore}
    		terms={terms}
    		updateTerms={updateTerms}
    		updatePage={updatePage}
    		isLoading={isLoading}
  		/>
  	</div>
  )
}

export default Glossary;