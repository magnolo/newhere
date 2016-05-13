class ResetpasswordFormController{
    constructor($state, UserService){
        'ngInject';

        //

        this.$state = $state;
        this.token = $state.params.token;
        this.UserService = UserService;
    }
    setNewPassword(isValid){
      if(isValid){
        this.UserService.setNewPassword({
          token: this.token,
          password: this.password,
          re_password: this.re_password
        },(response) =>{
          this.$state.go('app.login');
        })
      }
    }

    $onInit(){
    }
}

export const ResetpasswordFormComponent = {
    templateUrl: './views/app/components/resetpassword-form/resetpassword-form.component.html',
    controller: ResetpasswordFormController,
    controllerAs: 'vm',
    bindings: {}
}
