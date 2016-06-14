export function RoutesRun($rootScope, $state, $auth, $window, $mdSidenav, $translate, ToastService) {
    'ngInject';

    $rootScope.cms = false;
    var deregisterationCallback =  $rootScope.$on("$stateChangeStart", function(event, toState) {
        $rootScope.cms = toState.name.indexOf('cms') > -1 ? true : false;
        $rootScope.$auth = $auth;
        if (toState.data && toState.data.auth) {
            /*Cancel going to the authenticated state and go back to the login page*/
            if (!$auth.isAuthenticated()) {
                event.preventDefault();
                return $state.go('app.login');
            }
            else if(toState.data.roles){
              var roles = $window.localStorage.roles;

              if(toState.data.roles.indexOf(JSON.parse(roles)[0]) == -1){
                event.preventDefault();
                $translate('Sie sind zum Aufruf dieser Seite nicht berechtigt!').then((msg) => {
                    ToastService.error(msg);
                });
              }
            }
        }
        $mdSidenav('filter').close();
        $mdSidenav('main-menu').close();

    });
    $rootScope.$on('$destroy', deregisterationCallback)
}
