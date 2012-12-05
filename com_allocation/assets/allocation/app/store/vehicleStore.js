/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define( 'Allocation.store.vehicleStore',{
            extend: 'Ext.data.DirectStore',
            alias: 'widget.vehicleStore',
            remoteSort: true,
            autoLoad: true,
            sorters: [{
                property: 'id',
                direction: 'ASC'
            }],
            model:  'Allocation.model.Vehicle',
            initComponent : function() {
                this.callParent();
            }
        });