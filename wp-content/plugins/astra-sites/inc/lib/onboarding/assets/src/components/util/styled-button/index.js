import React from 'react';
import Button from '../../button/button';

const StyledButton = ( props ) => {
	const { children, after, before, gray, large, mb1, ml1, onClick } = props;
	return (
		<Button
			type="hero"
			gray={ gray }
			large={ large }
			mb1={ mb1 }
			ml1={ ml1 }
			before={ before }
			after={ after }
			onClick={ () => {
				onClick();
			} }
		>
			{ children }
		</Button>
	);
};

export default StyledButton;
