Ext.define('Allocation.view.Viewport', {
    extend: 'Ext.container.Viewport',
    layout: 'border',

    requires: [
        'Allocation.view.cardContentPanel',
        'Allocation.view.menuTreePanel',
        'Allocation.view.jobcardAssignmentPanel',
        'Allocation.view.vehicleGridPanel'
    ],

    initComponent: function() {
        this.items = [
          {
            layout: 'border',
            id: 'layout-browser',
            region:'west',
            border: false,
            split:true,
            margins: '2 0 5 5',
            width: 200,
            minSize: 100,
            maxSize: 500,
            items: [{xtype: 'menuTreePanel'}]
        },
            {xtype: 'cardContentPanel',id:'content-panel'}
        ];
        this.renderTo = Ext.getBody();

        this.callParent();
    }
});