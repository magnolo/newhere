export class UserService {
    constructor(API, ToastService) {
        'ngInject';

        this._promise;
        this._callbacks = new Array();

        this.API = API;
        this.ToastService = ToastService;
        this.users;
        this.user;
        this.me;
    }
    all(success, error, force) {
        if (angular.isDefined(this.users) && !force) {
            success(this.users);
        } else if (angular.isDefined(this._promise)) {
            this._callbacks.push(success);
        } else {
            this._callbacks.push(success);
            this._promise = this.API.all('users').getList().then((list) => {
                this.users = list;
                angular.forEach(this._callbacks, (callback) => {
                    callback(this.users);
                })
                this._promise = null;
            }, error);
        }
    }
    me(success, error, force){
      this.API.one('users', 'me').get().then((item) => {
        this.me = item;
        success(this.me);
      },error);
    }
    one(id, success, error){
      this.API.one('users', id).get().then((item) => {
        this.user = item;
        success(this.user);
      },error);
    }
    save(user, success){
      if(user.id && user.id != 'new'){
        user.save().then((response) => {
          this.ToastService.show('Saved successfully');
          success(response);
        });
      }
      else{
        this.API.all('users').post(user).then((response)=>{
          this.ToastService.show('Saved successfully');
          this.one(response.data.user.id, (user) =>{
            this.users.push(user);
            console.log(this.users);
          })
          success(response);
        });
      }
    }
    saveNgoUser(user, success){
            this.API.all('ngoUsers').post(user).then((response)=>{
                this.ToastService.show('Saved successfully');
                success(response);
            });
    }
    toggleNgoUserAdmin(ngoUser) {
        this.API.one('ngoUsers', ngoUser.id).customPUT({
            isNgoAdmin: ngoUser.isNgoAdmin ? 1 : 0
        },'toggleAdmin').then(
            (success) => {
                this.ToastService.show('User updated.');
            },
            (error) => {
                this.ToastService.show('User update failed. Please try again');
                ngoUser.isNgoAdmin = !ngoUser.isNgoAdmin;
            }
        );
    }
    bulkRemove(list, success, error){
      var ids = [];
      angular.forEach(list, (item) => {
        ids.push(item.id);
      });
      this.API.several('users', ids).remove().then((response) => {
          this.ToastService.show(response.data.deletedRows+' item(s) successfully deleted!');
         success(response.data.users);
      });
    }
    forgotpassword(email, success){
      this.API.all('password').post({email:email}).then((response) => {
        this.ToastService.show('Klicke auf den Link in der Email, die wir soeben versendet haben!');
        success(response);
      })
    }
    setNewPassword(data, success){
      this.API.all('password/'+data.token).post(data).then((response) =>{
        this.ToastService.show('Das Passwort wurde erfolgreich gespeichert!');
        success(response);
      })
    }
}
