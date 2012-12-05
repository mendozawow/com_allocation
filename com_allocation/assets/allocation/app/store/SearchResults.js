Ext.define('Allocation.store.SearchResults', {
    extend: 'Ext.data.Store',
    requires: 'Allocation.model.Station',
    model: 'Allocation.model.Station',

    sorters: ['name']
});