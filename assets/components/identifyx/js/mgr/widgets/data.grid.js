IdentifyX.grid.Data = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'identifyx-grid-data';
	}
	Ext.applyIf(config, {
		url: IdentifyX.config.connector_url,
		fields: this.getFields(config),
		columns: this.getColumns(config),
		tbar: this.getTopBar(config),
		sm: new Ext.grid.RowSelectionModel(),
		//save_action: 'mgr/data/updateFromGrid',
		// autoExpandColumn: 'name',
  //       autosave: true,
  //       groupOnSort: true,
  //       remoteGroup: true,
        //groupField: 'fingerprint',
		baseParams: {
			action: 'mgr/data/getlist'
		},
		listeners: {
    		cellcontextmenu: function (grid, row, cell, e) {
    		    this.getMenu(grid, row);
    		},
			//rowDblClick: function (grid, rowIndex, e) {
			//	var row = grid.store.getAt(rowIndex);
			//	this.updateData(grid, e, row);
			//}
		},
		viewConfig: {
			//forceFit: true,
			enableRowBody: true,
			autoFill: true,
			//showPreview: true,
			scrollOffset: 0,
			getRowClass: function (rec, ri, p) {
				return rec.data.blocked
					? 'identifyx-grid-row-disabled'
					: '';
			}
		},
		paging: true,
		//remoteSort: true,
		autoHeight: true,
	});
	IdentifyX.grid.Data.superclass.constructor.call(this, config);

	// Clear selection on grid refresh
	this.store.on('load', function () {
		if (this._getSelectedIds().length) {
			this.getSelectionModel().clearSelections();
		}
	}, this);
};
Ext.extend(IdentifyX.grid.Data, MODx.grid.Grid, {
	windows: {},

	getMenu: function(grid, row) {
        var cs = this._getSelectedIds();
        var m = [];
        if (cs.length > 1) {
        	m.push({
    			text: '<i class="icon icon-minus error"></i>&nbsp;' + _('identifyx_users_disable'),
    			handler: function(){
    				this.blockUser(cs);
    			}
    		});
    		m.push('-');
    		m.push({
    			text: '<i class="icon icon-plus"></i>&nbsp;' + _('identifyx_users_enable'),
    			handler: function(){
    				this.unblockUser(cs);
    			}
    		});
        } else {
    		m.push({
    			text: '<i class="icon icon-minus error"></i>&nbsp;' + _('identifyx_user_disable'),
    			handler: function(){
    				this.blockUser(cs);
    			}
    		});
    		m.push('-');
    		m.push({
    			text: '<i class="icon icon-plus"></i>&nbsp;' + _('identifyx_user_enable'),
    			handler: function(){
    				this.unblockUser(cs);
    			}
    		});
        }
		this.addContextMenuItem(m);
	},

	blockUser: function (ids) {
		if (!ids.length) {
			return false;
		}
		var u_ids = this._getUserIds(ids);

		MODx.Ajax.request({
			url: this.config.url,
			params: {
				action: 'mgr/user/block',
				users: u_ids,
			},
			listeners: {
				success: {
					fn: function () {
						this.refresh();
					}, scope: this
				}
			}
		})
	},

	unblockUser: function (ids) {
		if (!ids.length) {
			return false;
		}
		var u_ids = this._getUserIds(ids);

		MODx.Ajax.request({
			url: this.config.url,
			params: {
				action: 'mgr/user/unblock',
				users: u_ids,
			},
			listeners: {
				success: {
					fn: function () {
						this.refresh();
					}, scope: this
				}
			}
		})
	},

	getFields: function (config) {
		return ['id', 'user_id', 'user_name', 'fingerprint', 'votes', 'actions', 'blocked'];
	},

	getColumns: function (config) {
		return [{
			header: _('identifyx_item_id'),
			dataIndex: 'id',
			sortable: true,
			width: 30
		}, {
			header: _('identifyx_item_user_id'),
			dataIndex: 'user_id',
			sortable: true,
			width: 30,
		}, {
			header: _('identifyx_item_votes'),
			dataIndex: 'votes',
			sortable: true,
			width: 30,
		}, {
			header: _('identifyx_user_name'),
			dataIndex: 'user_name',
			sortable: true,
			width: 100,
		}, {
			header: _('identifyx_item_blocked'),
			dataIndex: 'blocked',
			sortable: false,
			width: 30,
		}, {
			header: _('identifyx_item_fingerprint'),
			dataIndex: 'fingerprint',
			sortable: false,
			width: 250,
		}, {
			header: _('identifyx_grid_actions'),
			dataIndex: 'actions',
			renderer: IdentifyX.utils.renderActions,
			sortable: false,
			width: 50,
			id: 'actions'
		}];
	},

	getTopBar: function (config) {
		return [/*{
			text: '<i class="icon icon-plus"></i>&nbsp;' + _('identifyx_item_create'),
			handler: this.createData,
			scope: this
		}, {
		    text: '<i class="icon icon-trash"></i>&nbsp;' + _('identifyx_item_remove'),
		    handler: this.removeSelected,
		    scope: this
		},*/ '->', {
			xtype: 'textfield',
			name: 'query',
			width: 200,
			id: config.id + '-search-field',
			emptyText: _('identifyx_grid_search'),
			listeners: {
				render: {
					fn: function (tf) {
						tf.getEl().addKeyListener(Ext.EventObject.ENTER, function () {
							this._doSearch(tf);
						}, this);
					}, scope: this
				}
			}
		}, {
			xtype: 'button',
			id: config.id + '-search-clear',
			text: '<i class="icon icon-times"></i>',
			listeners: {
				click: {fn: this._clearSearch, scope: this}
			}
		}];
	},

    getSelectedAsList: function() {
        var sels = this.getSelectionModel().getSelections();
        if (sels.length <= 0) return false;

        var cs = '';
        for (var i=0;i<sels.length;i++) {
            cs += ','+sels[i].data.id;
        }
        cs = cs.substr(1);
        return cs;
    },

	_getSelectedIds: function () {
		var ids = [];
		var selected = this.getSelectionModel().getSelections();

		for (var i in selected) {
			if (!selected.hasOwnProperty(i)) {
				continue;
			}
			ids.push(selected[i]['id']);
		}

		return ids;
	},

	_getUserIds: function (rows) {
		var ids = '';
		var store = this.getStore();

		for (var i in rows) {
			if (!rows.hasOwnProperty(i)) {
				continue;
			}
			var rec = store.getById(rows);
			ids += ','+rec.data.user_id;
		}

		return ids.substr(1);
	},

	_doSearch: function (tf, nv, ov) {
		this.getStore().baseParams.query = tf.getValue();
		this.getBottomToolbar().changePage(1);
		this.refresh();
	},

	_clearSearch: function (btn, e) {
		this.getStore().baseParams.query = '';
		Ext.getCmp(this.config.id + '-search-field').setValue('');
		this.getBottomToolbar().changePage(1);
		this.refresh();
	},


	// createData: function (btn, e) {
	// 	var w = MODx.load({
	// 		xtype: 'identifyx-data-window-create',
	// 		id: Ext.id(),
	// 		listeners: {
	// 			success: {
	// 				fn: function () {
	// 					this.refresh();
	// 				}, scope: this
	// 			}
	// 		}
	// 	});
	// 	w.reset();
	// 	// w.setValues({blocked: false});
	// 	w.show(e.target);
	// },

	// updateData: function (btn, e, row) {
	// 	if (typeof(row) != 'undefined') {
	// 		this.menu.record = row.data;
	// 	}
	// 	else if (!this.menu.record) {
	// 		return false;
	// 	}
	// 	var id = this.menu.record.id;

	// 	MODx.Ajax.request({
	// 		url: this.config.url,
	// 		params: {
	// 			action: 'mgr/data/get',
	// 			id: id
	// 		},
	// 		listeners: {
	// 			success: {
	// 				fn: function (r) {
	// 					var w = MODx.load({
	// 						xtype: 'identifyx-data-window-update',
	// 						id: Ext.id(),
	// 						record: r,
	// 						listeners: {
	// 							success: {
	// 								fn: function () {
	// 									this.refresh();
	// 								}, scope: this
	// 							}
	// 						}
	// 					});
	// 					w.reset();
	// 					w.setValues(r.object);
	// 					w.show(e.target);
	// 				}, scope: this
	// 			}
	// 		}
	// 	});
	// },

	// removeData: function (act, btn, e) {
	// 	var ids = this._getSelectedIds();
	// 	if (!ids.length) {
	// 		return false;
	// 	}
	// 	MODx.msg.confirm({
	// 		title: ids.length > 1
	// 			? _('identifyx_items_remove')
	// 			: _('identifyx_item_remove'),
	// 		text: ids.length > 1
	// 			? _('identifyx_items_remove_confirm')
	// 			: _('identifyx_item_remove_confirm'),
	// 		url: this.config.url,
	// 		params: {
	// 			action: 'mgr/data/remove',
	// 			ids: Ext.util.JSON.encode(ids),
	// 		},
	// 		listeners: {
	// 			success: {
	// 				fn: function (r) {
	// 					this.refresh();
	// 				}, scope: this
	// 			}
	// 		}
	// 	});
	// 	return true;
	// },


	// onClick: function (e) {
	// 	var elem = e.getTarget();
	// 	if (elem.nodeName == 'BUTTON') {
	// 		var row = this.getSelectionModel().getSelected();
	// 		if (typeof(row) != 'undefined') {
	// 			var action = elem.getAttribute('action');
	// 			if (action == 'showMenu') {
	// 				var ri = this.getStore().find('id', row.id);
	// 				return this._showMenu(this, ri, e);
	// 			}
	// 			else if (typeof this[action] === 'function') {
	// 				this.menu.record = row.data;
	// 				return this[action](this, e);
	// 			}
	// 		}
	// 	}
	// 	return this.processEvent('click', e);
	// },

   //  removeSelected: function(act,btn,e) {
   //      var cs = this.getSelectedAsList();
   //      if (cs === false) return false;

   //  	MODx.msg.confirm({
			// title: _('modextra_items_remove')
			// ,text: _('modextra_items_remove_confirm')
			// ,url: this.config.url
			// ,params: {
   //              action: 'mgr/item/multiremove'
   //              ,resources: cs
   //          }
   //          ,listeners: {
   //              'success': {fn:function() {
   //                  this.getSelectionModel().clearSelections(true);
   //                  this.refresh();
   //                     var t = Ext.getCmp('modx-resource-tree');
   //                     if (t) { t.refresh(); }
   //              },scope:this}
   //          }
   //      });
   //      return true;
   //  },
});
Ext.reg('identifyx-grid-data', IdentifyX.grid.Data);
