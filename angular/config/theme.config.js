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


    var customPrimary = {
        '50': '#8fbbdf',
        '100': '#7baeda',
        '200': '#68a2d4',
        '300': '#5496ce',
        '400': '#408ac9',
        '500': '#ffffff',
        '600': '#2f70a6',
        '700': '#2a6292',
        '800': '#24557e',
        '900': '#1e486b',
        'A100': '#a3c7e5',
        'A200': '#b7d3ea',
        'A400': '#cbdff0',
        'A700': '#193a57'
    };
    $mdThemingProvider
        .definePalette('customPrimary',
            customPrimary);
    var customBackground = {
        '50': '#ffffff',
        '100': '#ffffff',
        '200': '#ffffff',
        '300': '#ffffff',
        '400': '#ffffff',
        '500': '#ffffff',
        '600': '#f2f2f2',
        '700': '#e6e6e6',
        '800': '#d9d9d9',
        '900': '#cccccc',
        'A100': '#ffffff',
        'A200': '#ffffff',
        'A400': '#ffffff',
        'A700': '#bfbfbf'
    };
    $mdThemingProvider
        .definePalette('customBackground',
            customBackground);
    var customWarn = {
        '50': '#eeebda',
        '100': '#e6e1c9',
        '200': '#ded8b7',
        '300': '#d6cea6',
        '400': '#cec594',
        '500': '#C6BB83',
        '600': '#beb172',
        '700': '#b6a860',
        '800': '#ad9e50',
        '900': '#9b8e47',
        'A100': '#f6f4ec',
        'A200': '#fefefd',
        'A400': '#ffffff',
        'A700': '#8a7e3f',
				'contrastDefaultColor': 'light',
    };
    $mdThemingProvider
        .definePalette('customWarn',
            customWarn);

    var customAccent = {
        '50': '#1a4b1a',
        '100': '#215e20',
        '200': '#277127',
        '300': '#2e842d',
        '400': '#359734',
        '500': '#3baa3a',
        '600': '#54c453',
        '700': '#67cb66',
        '800': '#7ad179',
        '900': '#8dd88c',
        'A100': '#54c453',
        'A200': '#42bd41',
        'A400': '#3baa3a',
        'A700': '#a0de9f'
    };
    $mdThemingProvider
        .definePalette('customAccent',
            customAccent);
    $mdThemingProvider.theme('whitey')
        .primaryPalette('customPrimary')
        .accentPalette('customAccent')
        .warnPalette('customWarn')
        .backgroundPalette('customBackground')
}
