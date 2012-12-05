/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('Allocation.view.cardContentPanel', {
    extend: 'Ext.panel.Panel',
    alias: 'widget.cardContentPanel',
    region: 'center', // this is what makes this panel into a region within the containing layout
    layout: 'card',
    margins: '2 5 5 0',
    activeItem: 0,
    border: false,
    initComponent: function(){
        // Gets all layouts examples
        var layoutExamples = [];
        Ext.Object.each(getBasicLayouts(), function(name, example) {
            layoutExamples.push(example);
        });
        this.items = layoutExamples;

        this.callParent();
    }
});

function getBasicLayouts() {
    var cardNav = function(incr){
        var l = Ext.getCmp('card-wizard-panel').getLayout();
        var i = l.activeItem.id.split('card-')[1];
        var next = parseInt(i, 10) + incr;
        l.setActiveItem(next);
        Ext.getCmp('card-prev').setDisabled(next===0);
        Ext.getCmp('card-next').setDisabled(next===2);
    };
    return {
        /*
         * ================  Start page config  =======================
         */
        // The default start page, also a simple example of a FitLayout.
        start: {
            id: 'start-panel',
            title: 'Gestor de DAF-Directv',
            layout: 'fit',
            bodyStyle: 'padding:25px',
            contentEl: 'start-div'  // pull existing content from the page
        },
        jobcard_assignment :{
            xtype: 'jobcardAssignmentPanel',
            id: 'jobcard_assignment-panel',
            layout: 'border'
        },
        vehicleMgr: {
            id:'vehicleMgr-panel',
            title: 'Gestiona los vehiculos',
            layout: 'border',
            bodyBorder: false,
            defaults: {
                collapsible: true,
                split: true,
                animFloat: false,
                autoHide: false,
                useSplitTips: true,
                bodyStyle: 'padding:15px'
            },
            items: [{
                frame: false,
                id: 'vehicleMgr-main-content',
                collapsible: false,
                autoScroll: true,
                region: 'center',
                margins: '5 0 0 0',
                items: {
                    xtype: 'vehicleGridPanel',
                    id: 'vehicleMgr-vehicleGridPanel',
                    layout: 'border'
                }
            }]
        }
    };
}