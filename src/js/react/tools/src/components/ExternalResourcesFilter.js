import React from "react";
import ExternalResources from './ExternalResources';

const ExternalResourcesFilter = props => {

  return (
  	<div>
	  	<section className="tool-external-resources-filter">
	  		<div className="grid-container">
	  			<form
	  				id="tool-external-resources-filter-form"
	  				action=""
	  				method="post"
					>
						<div className="grid-x grid-margin-x">
							<div className="tool-external-resources-filter-form-intro cell large-3 medium-12">
								<h3>Filter External Resources</h3>
								<p>Filter by type or perform a keyword search to discover your desired external resource.</p>
							</div>
							<div className="tool-external-resources-filter-form-content cell large-9 medium-12">
								<p className="form-field form-field-50">
									<label htmlFor="select-external_resource_types">Types</label>
									<select
										id="select-external_resource_types"
										name="external_resource_types"
										value={props.type}
										onChange={e => {
											props.updateType(e.target.value);
											props.updateExternalResources([]);
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
											props.updateExternalResources([]);
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
  		<ExternalResources externalResources={props.externalResources} isLoading={props.isLoading} />
  	</div>
	);
};

export default ExternalResourcesFilter;