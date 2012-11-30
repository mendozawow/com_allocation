Ext.define('Allocation.model.Vehicle', {
    extend: 'Ext.data.Model',
    fields: ['id', 'name'],

    proxy: {
        type: 'ajax',
        url: '/web/allocation/data/stations.json',
        reader: {
            type: 'json',
            root: 'results'
        }
    }
});