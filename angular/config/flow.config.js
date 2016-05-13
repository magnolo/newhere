export function FlowConfig(flowFactoryProvider) {
    'ngInject';

    //
    flowFactoryProvider.defaults = {
        target: '/api/images/upload',
        permanentErrors: [404, 500, 501],
        maxChunkRetries: 1,
        testChunks: false,
        chunkRetryInterval: 5000,
        simultaneousUploads: 4,
        singleFile: true
    };
    flowFactoryProvider.on('catchAll', function(event) {
      //  console.log('catchAll', arguments);
    });
}
