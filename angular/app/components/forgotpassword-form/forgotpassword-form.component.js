class ForgotpasswordFormController{
    constructor(UserService, $state){
        'ngInject';

        //
        this.email;
        this.UserService = UserService;
    }
    resetPassword(){
      console.log(this.email);
      this.UserService.forgotpassword(this.email, (response) =>{
        console.log(response);
      });
    }

    $onInit(){
    }
}

export const ForgotpasswordFormComponent = {
    templateUrl: './views/app/components/forgotpassword-form/forgotpassword-form.component.html',
    controller: ForgotpasswordFormController,
    controllerAs: 'vm',
    bindings: {}
}
