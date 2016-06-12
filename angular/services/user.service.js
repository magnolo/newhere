export class UserService {
    constructor(API, ToastService, $translate) {
        'ngInject';

        this._promise;
        this._callbacks = new Array();

        this.API = API;
        this.ToastService = ToastService;
        this.$translate;
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
            this.$translate('Erfolgreich gespeichert.').then((msg) => {
                this.ToastService.show(msg);
            });
            success(response);
        });
      }
      else{
        this.API.all('users').post(user).then((response) => {
            this.$translate('Erfolgreich gespeichert.').then((msg) => {
                this.ToastService.show(msg);
            });
          
          this.one(response.data.user.id, (user) =>{
            this.users.push(user);
            console.log(this.users);
          })
          success(response);
        });
      }
    }
    saveNgoUser(user, success){
            this.API.all('ngoUsers').post(user).then((response) => {
                this.$translate('Erfolgreich gespeichert.').then((msg) => {
                    this.ToastService.show(msg);
                });
                success(response);
            });
    }
    toggleNgoUserAdmin(ngoUser) {
        this.API.one('ngoUsers', ngoUser.id).customPUT({
            isNgoAdmin: ngoUser.isNgoAdmin ? 1 : 0
        },'toggleAdmin').then(
            (success) => {
                this.$translate('Benutzer aktualisiert.').then((msg) => {
                   this.ToastService.show(msg);
                });
            },
            (error) => {
                this.$translate('Fehler beim Speichern der Daten.').then((msg) => {
                    this.ToastService.error(msg);
                });
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
          this.$translate('{{count}} Benutzer gelöscht.', {count: response.data.deletedRows}).then((msg) => {
            this.ToastService.show(msg);
          });
         success(response.data.users);
      });
    }
    forgotpassword(email, success){
      this.API.all('password').post({email:email}).then((response) => {
          this.$translate('Klicke auf den Link in der Email, die wir dir soeben gesendet haben!').then((msg) => {
            this.ToastService.show(msg);
          });
        success(response);
      })
    }
    setNewPassword(data, success){
      this.API.all('password/'+data.token).post(data).then((response) => {
          this.$translate('Das Passwort wurde erfolgreich gespeichert.').then((msg) => {
            this.ToastService.show(msg);
          });
        success(response);
      })
    }
}
