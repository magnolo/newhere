export function TranslateConfig($translateProvider) {
    'ngInject';

    $translateProvider.useStaticFilesLoader({
        prefix: '/translations/',
        suffix: '.json'
    });

    $translateProvider.preferredLanguage('en');
    $translateProvider.fallbackLanguage('de');
    $translateProvider.useLocalStorage();
}