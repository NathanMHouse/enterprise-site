import React from "react";

const ExternalResource = props => {

	const title      = (props.title) ? props.title : '';
	const content    = (props.content) ? props.content.split('\n').map( (paragraph, i) => <p key={i}>{paragraph}</p>) : '';
	const URL        = (props.url) ? props.url : '';
	
	return (
		<article className="tool-external-resources-resource">
			<div className="grid-container">
				<div className="grid-x">
					<header className="tool-external-resources-resource-header cell medium-12">
						<h3>
							{URL ? <a href={URL} target="_blank" rel="noopener noreferrer">{title}</a> : title }
						</h3>
					</header>
					<section className="tool-external-resources-resource-body cell medium-12">
						{content}
					</section>
				</div>
			</div>
		</article>
	);
};

export default ExternalResource;