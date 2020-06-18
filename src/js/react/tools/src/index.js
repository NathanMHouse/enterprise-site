import React from 'react';
import ReactDOM from 'react-dom';
import Glossary from './Glossary';
import ExternalResourcesTool from './ExternalResourcesTool';
import BordersTool from './BordersTool';
import LocationsTool from './LocationsTool';

var googleMapsApiKey = (process.env.NODE_ENV === 'production') ? window.googleMapsApiKey : process.env.REACT_APP_GOOGLE_MAPS_API_KEY;

if (document.getElementById('tool-glossary')) {
	ReactDOM.render(
		<Glossary />,
		document.getElementById('tool-glossary')
	);	
} else if (document.getElementById('tool-external-resources')) {
	ReactDOM.render(
		<ExternalResourcesTool />,
		document.getElementById('tool-external-resources')
	);	
} else if (document.getElementById('tool-borders')) {
	ReactDOM.render(
		<BordersTool googleMapsApiKey={googleMapsApiKey} />,
		document.getElementById('tool-borders')
	);	
} else if (document.getElementById('tool-locations')) {
	ReactDOM.render(
		<LocationsTool googleMapsApiKey={googleMapsApiKey} />,
		document.getElementById('tool-locations')
	);	
}