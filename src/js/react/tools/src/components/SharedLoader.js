import React from "react";

const SharedLoader = ({
	loaderClass
}) => {
	return (
		<div className={loaderClass + " site-content-loader hide"}>
			<div className="grid-x">
				<div className="small-12">
					<div className="site-content-loader-icon"></div>
				</div>
			</div>
		</div>
	);
};

export default SharedLoader;