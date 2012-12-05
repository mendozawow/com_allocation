/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define('Allocation.view.vehicleGridPanel', {
    extend:'Ext.grid.Panel',
    alias: 'widget.vehicleGridPanel',
    height: 350,
    width: 600,
    title: 'Vehiculos',
    initComponent: function(){
        this.store = Ext.create('Allocation.store.vehicleStore',{
            proxy: {
                type : 'direct',
                directFn : VehicleMgr.jGetVehicles,
                extraParams:{
                    vehicleId: '21',
                    vehiclePlate: 'bid 932'
                }
            }
        });
        this.columns = [{
            dataIndex: 'id',
            flex: 1,
            text: 'Id'
        }, {
            dataIndex: 'plate',
            flex: 1,
            text: 'plate'
        },{
            dataIndex: 'owner',
            flex: 1,
            text: 'owner'
        },{
            dataIndex: 'model',
            flex: 1,
            text: 'model'
        },{
            dataIndex: 'status',
            flex: 1,
            text: 'status'
        }];

        this.dockedItems = [{
            xtype: 'toolbar',
            items: [{
                iconCls: 'icon-update',
                text: 'Actualizar',
                scope: this,
                handler: this.onUpdateClick
            }]
        }];

        this.callParent();
    },
    onUpdateClick: function(){
        this.store.load();
    }
});