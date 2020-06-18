import React from "react";
import ExternalResource from './ExternalResource';
import SharedLoader from './SharedLoader';

const ExternalResources = ({ externalResources, isLoading }) => {
	return (
		<section className="tool-external-resources-resources">
			{!isLoading && !externalResources.length ? (
				<div className="tool-external-resources-resources-empty grid-container">
					<div className="grid-x grid-margin-x">
						<div className="cell medium-6 medium-offset-3">
						<h2>No External Resources Found</h2>
						</div>
						<div className="cell medium-8 medium-offset-2">
							<p>Please try altering your query to return more results.</p>
						</div>
					</div>
				</div>
			) : (
				externalResources.map(externalResource => {
					return (
						<ExternalResource
							title={externalResource.title}
							content={externalResource.content}
							url={externalResource.url}
							key={externalResource.id}
						/>
					);
				})
			)}
			<SharedLoader loaderClass="site-content-loader-external-resources-tool" />
		</section>
	);
};

export default ExternalResources;