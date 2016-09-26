// THIS IS TO BE SET ON SERVER
var arDefaults = {
	menuVisibleItems: 5,
	actionOnBuy: 'animation-n-popup',
	backnavEnabled: false,
	topLinePosition: 'fixed-top',
	quickViewEnabled: false,
	langSwitchEnabled: false,
	currencySwitchEnabled: false,
	categoriesEnabled: true,
	stylingType: 'flat',
	colorTheme: 'red-flat',
	additionalPricesEnabled: false,
	containerWidth: 'container',
	bigSliderWidth: 'full',
	catalogPlacement: 'top',
	filterPlacement: 'side',
	siteBackground: 'color',
	headerVersion: 'v1',
	bigSliderType: 'pro',
	hoverEffect: 'border',
	brandsViewType: 'carousel',
	coolsliderEnabled: true,
	coolsliderNamesEnabled: true,
	sbMode: 'full',
	sbModeDefExpanded: true,
	productInfoMode: 'full',
	productInfoModeDefExpanded: false,
	bigimgDesc: 'disabled',
	photoViewType: 'modal',
	menuHitsEnabled: 'true',
	wowEffect: 'N',
	bs_height: '24.30%',
	footerBG: "url('img/patterns/footer_lodyas.png')",
	limitSliders: false,
	detailTextDefault: 'close',

	isFrontend: true,

	// below are dynamic settings for slider control panel
	bs_curSettingsFor: 'all',
	bs_curBlock: 'media',
	bsMediaHAlign: 'center',
	bsMediaVAlign: 'bottom',
	bsMediaAnim: 'slideRightBig',
	bsMediaLimitsBottom: '0%',
	bsMediaLimitsLeft: '51%',
	bsMediaLimitsRight: '2%',
	bsMediaLimitsTop: '0%',
	bsTextHAlign: 'right',
	bsTextVAlign: 'center',
	bsTextAnim: 'slideLeftBig',
	bsTextLimitsBottom: '0%',
	bsTextLimitsLeft: '2%',
	bsTextLimitsRight: '51%',
	bsTextLimitsTop: '0%',
	bsTextTextAlign: 'left'
};
b2.s = (typeof serverSettings !== 'undefined') ? $.extend(arDefaults, serverSettings) : arDefaults;
b2.temp = $.extend({}, b2.s);

bs.defaults = {
	media: {
		'limits': {
			top: b2.s.bsMediaLimitsTop,
			right: b2.s.bsMediaLimitsRight,
			bottom: b2.s.bsMediaLimitsBottom,
			left: b2.s.bsMediaLimitsLeft
		},
		'v-align': b2.s.bsMediaVAlign,
		'h-align': b2.s.bsMediaHAlign,
		'anim': b2.s.bsMediaAnim,
	},
	text: {
		'limits': {
			top: b2.s.bsTextLimitsTop,
			right: b2.s.bsTextLimitsRight,
			bottom: b2.s.bsTextLimitsBottom,
			left: b2.s.bsTextLimitsLeft
		},
		'v-align': b2.s.bsTextVAlign,
		'h-align': b2.s.bsTextHAlign,
		'text-align': b2.s.bsTextTextAlign,
		'anim': b2.s.bsTextAnim
	},
}

bs.slides = [ // COMES FROM SERVER
	{ // 0
		media: {
			'limits': {top: '0%', right: '0%', bottom: '0%', left: '51%'},
			'v-align': 'bottom',
		},
		text: {
			'limits': {top: '0%', right: '51%', bottom: '0%', left: '0%'},
			'h-align': 'right'
		},
	},
	{ // 1
		media: {
			'limits': {top: '0%', right: '51%', bottom: '0%', left: '0%'},
			'h-align': 'right'
		},
		text: {
			'limits': {top: '0%', right: '0%', bottom: '0%', left: '51%'},
		},
	},
	{ // 2
		media: {
			'limits': {top: '0%', right: '0%', bottom: '0%', left: '51%'},
			'v-align': 'bottom'
		},
		text: {
			'limits': {top: '0%', right: '51%', bottom: '0%', left: '0%'},
			'h-align': 'right'
		},
	},
	{ // 3
		media: {
			'limits': {top: '0%', right: '51%', bottom: '0%', left: '0%'},
			'h-align': 'right'
		},
		text: {
			'limits': {top: '0%', right: '0%', bottom: '0%', left: '51%'},
		},
	},
	{ // 4
		media: {
			'limits': {top: '0%', right: '0%', bottom: '0%', left: '0%'},
			// 'anim': 'whirl',
			'locked': true,
		},
	},
	{ // 5
		media: {
			'limits': {top: '0%', right: '12%', bottom: '0%', left: '51%'},
			'v-align': 'top',
			// 'anim': 'fade',
			'locked': true,
		},
		text: {
			'limits': {top: '0%', right: '51%', bottom: '0%', left: '0%'},
			'h-align': 'right'
		}
	},
	{ // 6
		media: {
			'limits': {top: '0%', right: '0%', bottom: '0%', left: '0%'},
			'v-align': 'center',
			// 'anim': 'whirl',
			'locked': true,
		},
	}
]