import React from 'react';
import styled from 'styled-components';

const Input = styled.input`
	&&& {
		padding: 5px 10px;
		width: 100%;
		border-color: #e5e5e5;
		border-width: 2px;
		&:focus {
			outline: none;
			box-shadow: none;
		}
	}
`;

const Email = ( { value, placeholder, onChange } ) => {
	const handleChange = ( event ) => {
		if ( typeof onChange === 'function' ) {
			onChange( event, event.target.value );
		}
	};

	return (
		<Input
			type="email"
			placeholder={ placeholder }
			value={ value }
			onChange={ ( e ) => handleChange( e ) }
		/>
	);
};

export default Email;
