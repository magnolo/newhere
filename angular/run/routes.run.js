export function RoutesRun($rootScope, $state, $auth, $window, ToastService) {
    'ngInject';


    var deregisterationCallback =  $rootScope.$on("$stateChangeStart", function(event, toState) {

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
                ToastService.error('No permission to go there!')
              }
            }
        }

    });
    $rootScope.$on('$destroy', deregisterationCallback)
}
