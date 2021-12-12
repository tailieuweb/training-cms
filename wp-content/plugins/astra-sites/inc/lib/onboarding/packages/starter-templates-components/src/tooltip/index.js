// External Dependencies.
import React from 'react';

// Internal Dependencies.
import './style.scss';

const Tooltip = ( { children, content } ) => {
	return (
		<div className="stc-tooltip">
			{ children }

			{ content ? (
				<div className="stc-tooltip-content">{ content }</div>
			) : null }
		</div>
	);
};

export default Tooltip;
