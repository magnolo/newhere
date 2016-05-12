class ImageUploaderController{
    constructor(ToastService){
        'ngInject';

    }
    fileAdded($file, $event, $flow){

    }
    assignImage($file, $message, $flow){
      let image = JSON.parse($message);
      this.item.image = image;
      this.item.image_id = image.id;
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
