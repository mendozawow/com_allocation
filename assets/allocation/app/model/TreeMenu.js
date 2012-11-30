/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define('TreeMenu', {
    extend: 'Ext.data.Model',
    fields: [
       {name: 'id'},
       {name: 'text'},
       {name: 'access'},
       {name: 'leaf'}
    ],
    idProperty: 'id'
});