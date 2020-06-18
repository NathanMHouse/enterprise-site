import React from "react";
import GlossaryTerms from './GlossaryTerms';

const GlossaryFilter = props => {

  return (
  	<div>
	  	<section className="tool-glossary-filter">
	  		<div className="grid-container">
	  			<form
	  				id="tool-glossary-filter-form"
	  				action=""
	  				method="post"
					>
						<div className="grid-x grid-margin-x">
							<div className="tool-glossary-filter-form-intro cell large-3 medium-12">
								<h3>Find Term</h3>
								<p>Filter by type or perform a keyword search to discover your desired term.</p>
							</div>
							<div className="tool-glossary-filter-form-content cell large-9 medium-12">
								<p className="form-field form-field-50">
									<label htmlFor="select-term_types">Types</label>
									<select
										id="select-term_types"
										name="term_types"
										value={props.type}
										onChange={e => {
											props.updateType(e.target.value);
											props.updateTerms([]);
											props.updateHasMore(true);
											props.updatePage(1);
										}}
									>
										<option value="">All Types</option>
										{props.types.map(type => (
											<option
												key={type.id}
												value={type.slug}
											>
											{type.name}
											</option>
										))}
									</select>
								</p>
								<p className="form-field form-field-50">
									<label htmlFor="form-field-search">Search</label>
									<input
										type="text"
										name="form_field_search"
										id="form-field-search"
										value={props.search}
										onChange={e => {
											props.updateSearch(e.target.value)
											props.updateTerms([]);
											props.updateHasMore(true);
											props.updatePage(1);
										}}
									/>
								</p>
							</div>
						</div>
					</form>
	  		</div>
	  	</section>
  		<GlossaryTerms terms={props.terms} isLoading={props.isLoading} />
  	</div>
	);
};

export default GlossaryFilter;