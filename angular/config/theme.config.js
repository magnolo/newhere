export function ThemeConfig($mdThemingProvider) {
	'ngInject';
	/* For more info, visit https://material.angularjs.org/#/Theming/01_introduction */
	var newHereBlue = $mdThemingProvider.extendPalette('light-blue', {
    '600': '357DBA'
  });
	$mdThemingProvider.definePalette('newHereBlue', newHereBlue);

	$mdThemingProvider.theme('default')
		.primaryPalette('newHereBlue', {
            default: '600'
    })
		.accentPalette('amber')
		.warnPalette('red');

  $mdThemingProvider.theme('warn');
	$mdThemingProvider.theme('custom')
          .primaryPalette('grey')
          .accentPalette('deep-purple')
          .warnPalette('green')
					.dark();
}
