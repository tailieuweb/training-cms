import { STEPS } from '../steps/util';

let currentIndexKey = 0;
let builderKey = 'gutenberg';

if ( astraSitesVars.default_page_builder ) {
	currentIndexKey = 2;
	builderKey =
		astraSitesVars.default_page_builder === 'brizy'
			? 'gutenberg'
			: astraSitesVars.default_page_builder;
}

export const initialState = {
	currentIndex: currentIndexKey,
	currentCustomizeIndex: 0,
	siteLogo: {
		id: '',
		thumbnail: '',
		url: '',
		width: 120,
	},
	activePaletteSlug: 'default',
	activePalette: {},
	typography: {},
	typographyIndex: 0,
	stepsLength: Object.keys( STEPS ).length,

	builder: builderKey,
	siteType: '',
	siteOrder: 'popular',
	siteCategory: {
		id: '',
		slug: '',
	},
	siteSearchTerm: '',
	userSubscribed: false,
	showSidebar: true,
	tryAgainCount: 0,
	confettiDone: false,

	// Business Information.

	// Template Information.
	templateId: 0,
	templateResponse: null,
	requiredPlugins: null,
	selectedTemplateName: '',
	selectedTemplateType: '',

	// Import statuses.
	reset: true,
	themeStatus: false,
	importStatusLog: '',
	importStatus: '',
	resetCustomizer: false,
	resetSiteOptions: false,
	resetContent: false,
	resetWidgets: false,
	resetDone: false,
	requiredPluginsDone: false,
	notInstalledList: [],
	notActivatedList: [],
	resetData: [],
	importStart: false,
	importEnd: false,
	importPercent: 0,
	importError: false,
	importErrorMessages: {
		primaryText: '',
		secondaryText: '',
		errorCode: '',
		errorText: '',
		solutionText: '',
		tryAgain: false,
	},
	importErrorResponse: [],

	customizerImportFlag: true,
	themeActivateFlag: true,
	widgetImportFlag: true,
	contentImportFlag: true,

	// Filter Favorites.
	onMyFavorite: false,

	// All Sites and Favorites
	favoriteSiteIDs: Object.values( astraSitesVars.favorite_data ) || [],

	// License.
	licenseStatus: astraSitesVars.license_status,
	validateLicenseStatus: false,

	// Search.
	searchTerms: [],
	searchTermsWithCount: [],
};

const reducer = ( state = initialState, { type, ...rest } ) => {
	switch ( type ) {
		case 'set':
			return { ...state, ...rest };
		default:
			return state;
	}
};

export default reducer;
