import React from "react";
import GlossaryTerm from './GlossaryTerm';
import SharedLoader from './SharedLoader';

const GlossaryTerms = ({ terms, isLoading }) => {
	return (
		<section className="tool-glossary-terms">
			{!isLoading && !terms.length ? (
				<div className="tool-glossary-terms-empty grid-container">
					<div className="grid-x grid-margin-x">
						<div className="cell medium-6 medium-offset-3">
						<h2>No Terms Found</h2>
						</div>
						<div className="cell medium-8 medium-offset-2">
							<p>Please try altering your query to return more results.</p>
						</div>
					</div>
				</div>
			) : (
				terms.map(term => {
					return (
						<GlossaryTerm
							title={term.title}
							content={term.content}
							cta={term.cta}
							key={term.id}
						/>
					);
				})
			)}
			<SharedLoader loaderClass="site-content-loader-glossary-tool"/>
		</section>
	);
};

export default GlossaryTerms;