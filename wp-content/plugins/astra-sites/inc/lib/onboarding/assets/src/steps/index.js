import React, { useEffect, useState } from 'react';
import { useHistory } from 'react-router-dom';
import { __ } from '@wordpress/i18n';
import { Tooltip } from '@brainstormforce/starter-templates';
import { useStateValue } from '../store/store';
import ICONS from '../../icons';
import Logo from '../components/logo';
import { storeCurrentState } from '../utils/functions';
import { STEPS } from './util';

const Steps = () => {
	const [ stateValue, dispatch ] = useStateValue();
	const {
		currentIndex,
		templateResponse,
		designStep,
		importError,
	} = stateValue;
	const [ settingHistory, setSettinghistory ] = useState( true );
	const [ settingIndex, setSettingIndex ] = useState( true );
	const current = STEPS[ currentIndex ];
	const history = useHistory();

	useEffect( () => {
		const previousIndex = parseInt( currentIndex ) - 1;
		const nextIndex = parseInt( currentIndex ) + 1;

		if ( nextIndex > 0 && nextIndex < STEPS.length ) {
			document.body.classList.remove( STEPS[ nextIndex ].class );
		}

		if ( previousIndex > 0 ) {
			document.body.classList.remove( STEPS[ previousIndex ].class );
		}

		document.body.classList.add( STEPS[ currentIndex ].class );
	} );

	useEffect( () => {
		if ( importError ) {
			document.body.classList.add( 'st-error' );
		} else {
			document.body.classList.remove( 'st-error' );
		}
	}, [ importError ] );

	useEffect( () => {
		const currentUrlParams = new URLSearchParams( window.location.search );
		const storedStateValue = JSON.parse(
			localStorage.getItem( 'starter-templates-onboarding' )
		);
		const urlIndex =
			parseInt( currentUrlParams.get( 'currentIndex' ) ) || 0;
		const designIndex =
			parseInt( currentUrlParams.get( 'designStep' ) ) || 0;

		if ( urlIndex !== 0 ) {
			const stateValueUpdates = {};
			for ( const key in storedStateValue ) {
				if ( key === 'currentIndex' ) {
					continue;
				}

				stateValueUpdates[ key ] = storedStateValue[ `${ key }` ];
			}

			dispatch( {
				type: 'set',
				currentIndex: urlIndex,
				designStep: designIndex,
				...stateValueUpdates,
			} );
		} else {
			localStorage.removeItem( 'starter-templates-onboarding' );
		}

		setSettinghistory( false );
	}, [ history ] );

	useEffect( () => {
		const currentUrlParams = new URLSearchParams( window.location.search );
		const urlIndex =
			parseInt( currentUrlParams.get( 'currentIndex' ) ) || 0;

		if ( currentIndex === 0 ) {
			currentUrlParams.delete( 'currentIndex' );
			history.push(
				window.location.pathname + '?' + currentUrlParams.toString()
			);
		}

		if (
			( currentIndex !== 0 && urlIndex !== currentIndex ) ||
			templateResponse !== null
		) {
			storeCurrentState( stateValue );
			currentUrlParams.set( 'currentIndex', currentIndex );
			history.push(
				window.location.pathname + '?' + currentUrlParams.toString()
			);
		}

		// Execute only for the last Customization step.
		if (
			designStep !== 0 &&
			urlIndex === STEPS.length - 1 &&
			templateResponse !== null
		) {
			storeCurrentState( stateValue );
			currentUrlParams.set( 'designStep', designStep );
			history.push(
				window.location.pathname + '?' + currentUrlParams.toString()
			);
		}

		if ( currentIndex === 2 ) {
			dispatch( {
				type: 'set',
				activePalette: {},
				activePaletteSlug: 'default',
				typography: {},
				typographyIndex: 0,
			} );
		}

		setSettingIndex( false );
	}, [ currentIndex, templateResponse, designStep ] );

	const goToShowcase = () => {
		dispatch( {
			type: 'set',
			currentIndex: currentIndex - 2,
			currentCustomizeIndex: 0,
		} );
	};

	return (
		<div className={ `step ${ current.class }` }>
			{ currentIndex !== 3 && (
				<div className="step-header">
					{ current.header ? (
						current.header
					) : (
						<div className="row">
							<div className="col">
								<Logo />
							</div>
							<div className="right-col">
								{ currentIndex === 4 && (
									<div
										className="back-to-main"
										onClick={ goToShowcase }
									>
										<Tooltip
											content={ __(
												'Back to Templates',
												'astra-sites'
											) }
										>
											{ ICONS.cross }
										</Tooltip>
									</div>
								) }
								<div className="col exit-link">
									<a href={ starterTemplates.adminUrl }>
										<Tooltip
											content={ __(
												'Exit to Dashboard',
												'astra-sites'
											) }
										>
											{ ICONS.dashboard }
										</Tooltip>
									</a>
								</div>
							</div>
						</div>
					) }

					<canvas
						id="ist-bashcanvas"
						width={ window.innerWidth }
						height={ window.innerHeight }
					/>
				</div>
			) }
			{ settingHistory === false && settingIndex === false && current
				? current.content
				: null }
		</div>
	);
};

export default Steps;
