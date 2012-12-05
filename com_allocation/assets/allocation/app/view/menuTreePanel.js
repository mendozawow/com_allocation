/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define('Allocation.view.menuTreePanel', {
    extend: 'Ext.tree.Panel',
    alias: 'widget.menuTreePanel',
    title: 'Menu',
    region:'north',
    split: true,
    height: 360,
    minSize: 150,
    rootVisible: false,
    autoScroll: true,
    initComponent: function(){

        this.store = Ext.create('Allocation.store.menuTreeStore',{id:'treeStore'});

        this.getSelectionModel().on('select', function(selModel, record) {
            if (record.get('leaf')) {
                Ext.getCmp('content-panel').layout.setActiveItem(record.getId() + '-panel');
            }
        });
        this.callParent();
    }

});

/*
 *     // Assign the changeLayout function to be called on tree node click.

 */