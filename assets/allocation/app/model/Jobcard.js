Ext.define('Allocation.model.Jobcard', {
    extend: 'Ext.data.Model',
    fields: ['id', 'name', 'artist', 'album', 'played_date', 'station'],

    proxy: {
        type: 'ajax',
        url: '/web/allocation/data/songs.json',
        reader: {
            type: 'json',
            root: 'results'
        }
    }
});