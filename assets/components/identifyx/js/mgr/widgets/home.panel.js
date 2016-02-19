IdentifyX.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        stateful: true,
        stateId: 'act',
        stateEvents: ['tabchange'],
        getState: function() {
            return {
                activeTab: this.items.indexOf(this.getActiveTab())
            };
        },

        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('identifyx') + '</h2>',
            cls: '',
            style: {
                margin: '15px 0'
            }
        }, {
            xtype: 'modx-tabs',
            defaults: {
                border: false,
                autoHeight: true
            },
            border: true,
            hideMode: 'offsets',
            items: [{
                title: _('identifyx_items'),
                layout: 'anchor',
                items: [{
                    html: _('identifyx_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'identifyx-grid-data',
                    cls: 'main-wrapper',
                }]
            },/* {
                title: _('identifyx_ips'),
                layout: 'anchor',
                items: [{
                    html: _('identifyx_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'identifyx-grid-ips',
                    cls: 'main-wrapper',
                }]
            },*/ {
                title: _('identifyx_likes'),
                layout: 'anchor',
                items: [{
                    html: _('identifyx_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'identifyx-grid-likes',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    IdentifyX.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(IdentifyX.panel.Home, MODx.Panel);
Ext.reg('identifyx-panel-home', IdentifyX.panel.Home);
