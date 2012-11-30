
Ext.Loader.setConfig({enabled:true});

Ext.application({
    name: 'Allocation',
    appFolder : 'components/com_allocation/assets/allocation/app',
    autoCreateViewport: true,

    models: ['Jobcard', 'Vehicle', 'TreeMenu'],
    stores: ['menuTreeStore'],
    controllers: []
});