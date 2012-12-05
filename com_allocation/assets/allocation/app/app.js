
Ext.Loader.setConfig({enabled:true});

Ext.onReady(function(){
    Ext.direct.Manager.addProvider(Ext.app.REMOTING_API);
});

Ext.application({
    name: 'Allocation',
    appFolder : 'components/com_allocation/assets/allocation/app',
    autoCreateViewport: true,

    models: ['Jobcard', 'Vehicle', 'TreeMenu'],
    stores: ['menuTreeStore','vehicleStore'],
    controllers: []
});