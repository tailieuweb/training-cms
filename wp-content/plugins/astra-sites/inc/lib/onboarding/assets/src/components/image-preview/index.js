import React from 'react';

const ImagePreview = ( { fileName } ) => {
	return (
		<div className="image-preview">
			<img
				alt={ `${ fileName }` }
				src={ `${ starterTemplates.imageDir }${ fileName }` }
			/>
		</div>
	);
};

export default ImagePreview;
