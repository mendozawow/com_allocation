/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('Allocation.store.menuTreeStore', {
    extend: 'Ext.data.TreeStore',
    alias: 'widget.menuTreeStore',
    model: 'TreeMenu',
    root: {
        expanded: true
    },
    proxy: {
        type: 'ajax',
        url: 'components/com_allocation/assets/allocation/app/model/tree-data.json'
    }
});


/*
 *
 *     store.on('beforeappend',function(treeStore, node, eOpts){
        var canAccess = false;
        var recordGroupIds = node.get('access').split(",");
        for(var j=0; j<recordGroupIds.length; j++)
        {
            for(var k=0; k<groupIds.length; k++)
            {
                if (recordGroupIds[j] == groupIds[k])
                {
                    canAccess = true;
                    break;
                }
            }
            if (canAccess) break;
        }
        if (!canAccess)
            return false;
    });
 */