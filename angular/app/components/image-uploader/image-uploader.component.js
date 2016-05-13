class ImageUploaderController{
    constructor(ToastService){
        'ngInject';

    }
    assignImage($file, $message, $flow){
      if(!this.item) this.item = {};
      let image = JSON.parse($message);
      this.item.image = image;
      this.item.image_id = image.id;
    }
    resetImage($flow){
      $flow.cancel();
      this.item.image = null;
      this.item.image_id = null;
    }
}

export const ImageUploaderComponent = {
    templateUrl: './views/app/components/image-uploader/image-uploader.component.html',
    controller: ImageUploaderController,
    controllerAs: 'vm',
    bindings: {
      item: '=ngModel',
    }
}
