import React, { useState } from 'react';
import { __ } from '@wordpress/i18n';
import { PreviousStepLink, DefaultStep } from '../../components/index';
import ICONS from '../../../icons';
import { useStateValue } from '../../store/store';
import SurveyForm from './survey';
import AdvancedSettings from './advanced-settings';
import './style.scss';

const Survey = () => {
	const [
		{ currentIndex, builder, requiredPlugins },
		dispatch,
	] = useStateValue();

	const thirtPartyPlugins =
		requiredPlugins !== null
			? requiredPlugins.third_party_required_plugins
			: [];
	const isThirtPartyPlugins = thirtPartyPlugins.length > 0;

	const [ skipPlugins, setSkipPlugins ] = useState( isThirtPartyPlugins );

	const [ formDetails, setFormDetails ] = useState( {
		first_name: '',
		email: '',
		wp_user_type: '',
		build_website_for: '',
	} );

	const updateFormDetails = ( field, value ) => {
		setFormDetails( ( prevState ) => ( {
			...prevState,
			[ field ]: value,
		} ) );
	};

	const handleSurveyFormSubmit = ( e ) => {
		e.preventDefault();

		setTimeout( () => {
			dispatch( {
				type: 'set',
				currentIndex: currentIndex + 1,
			} );
		}, 500 );

		if ( astraSitesVars.subscribed === 'yes' ) {
			dispatch( {
				type: 'set',
				user_subscribed: true,
			} );
			return;
		}

		const subscriptionFields = {
			EMAIL: formDetails.email,
			FIRSTNAME: formDetails.first_name,
			PAGE_BUILDER: builder,
			WP_USER_TYPE: formDetails.wp_user_type,
			BUILD_WEBSITE_FOR: formDetails.build_website_for,
		};

		const content = new FormData();
		content.append( 'action', 'astra-sites-update-subscription' );
		content.append( '_ajax_nonce', astraSitesVars._ajax_nonce );
		content.append( 'data', JSON.stringify( subscriptionFields ) );

		fetch( ajaxurl, {
			method: 'post',
			body: content,
		} )
			.then( ( response ) => response.json() )
			.then( () => {
				dispatch( {
					type: 'set',
					user_subscribed: true,
				} );
			} );
	};

	const handlePluginFormSubmit = ( e ) => {
		e.preventDefault();
		setSkipPlugins( false );
	};

	const surveyForm = () => {
		return (
			<form className="survey-form" onSubmit={ handleSurveyFormSubmit }>
				<h1>{ __( 'Okay, just one last step…', 'astra-sites' ) }</h1>
				{ astraSitesVars.subscribed !== 'yes' && (
					<SurveyForm updateFormDetails={ updateFormDetails } />
				) }
				{ <AdvancedSettings /> }
				<button
					type="submit"
					className="submit-survey-btn button-text d-flex-center-align"
				>
					{ __( 'Submit & Build My Website', 'astra-sites' ) }
					{ ICONS.arrowRight }
				</button>
			</form>
		);
	};

	const thirdPartyPluginList = () => {
		return (
			<form
				className="required-plugins-form"
				onSubmit={ handlePluginFormSubmit }
			>
				<h1>{ __( 'Required plugins missing', 'astra-sites' ) }</h1>
				<p>
					{ __(
						"This starter template requires premium plugins. As these are third party premium plugins, you'll need to purchase, install and activate them first.",
						'astra-sites'
					) }
				</p>
				<h5>{ __( 'Required plugins -', 'astra-sites' ) }</h5>
				<ul className="third-party-required-plugins-list">
					{ thirtPartyPlugins.map( ( plugin, index ) => {
						return (
							<li
								data-slug={ plugin.slug }
								data-init={ plugin.init }
								data-name={ plugin.name }
								key={ index }
							>
								<a
									href={ plugin.link }
									target="_blank"
									rel="noreferrer"
								>
									{ plugin.name }
								</a>
							</li>
						);
					} ) }
				</ul>
				<button
					type="submit"
					className="submit-survey-btn button-text d-flex-center-align"
				>
					{ __( 'Skip & Start Importing', 'astra-sites' ) }
					{ ICONS.arrowRight }
				</button>
			</form>
		);
	};

	return (
		<DefaultStep
			content={
				<>
					<div className="survey-container">
						{ skipPlugins && thirdPartyPluginList() }
						{ ! skipPlugins && surveyForm() }
					</div>
				</>
			}
			actions={
				<>
					<PreviousStepLink before>
						{ __( 'Back', 'astra-sites' ) }
					</PreviousStepLink>
				</>
			}
		/>
	);
};

export default Survey;
