import React from "react";

const GlossaryTerm = props => {

	const title = (props.title) ? props.title : '';
	const content = (props.content) ? props.content.split('\n').map((paragraph, i) => <p key={i}>{paragraph}</p>) : '';
	const CTALabel = (props.cta && props.cta.label) ? props.cta.label : 'Read More';
	const CTAURL = (props.cta && props.cta.url) ? props.cta.url : '';
	const CTATarget = (props.cta && props.cta.target) ? props.cta.target : '_self';

	return (
		<article className="tool-glossary-terms-term">
			<div className="grid-container">
				<div className="grid-x grid-margin-x">
					<header className="tool-glossary-terms-term-header cell large-3 medium-4">
						<h3>{title}</h3>
					</header>
					<section className="tool-glossary-terms-term-body cell large-9 medium-8">
						{content}
						{CTAURL
							? (
								<a
									href={CTAURL}
									target={CTATarget}
									className="tool-glossary-terms-term-body-cta">{CTALabel}</a>
							)
							: null
						}
					</section>
				</div>
			</div>
		</article>
	);
};

export default GlossaryTerm;