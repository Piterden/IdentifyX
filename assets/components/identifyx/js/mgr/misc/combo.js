IdentifyX.combo.User = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        name: 'user_id',
        fieldLabel: _('identifyx_subscriber'),
        hiddenName: config.name || 'user_id',
        displayField: 'fullname',
        valueField: 'id',
        anchor: '99%',
        fields: ['username', 'id', 'fullname'],
        pageSize: 20, // Количество результатов на странице
        url: MODx.config.connectors_url, // Используем родной процессор MODX
        editable: true, // Комбо можно редактировать, то есть - искать юзеров
        allowBlank: true, // Можно оставлять пустым
        emptyText: _('identifyx_user_select'), // Текст по умолчанию
        baseParams: { // Данные для отправки процессору
            action: 'security/user/getlist',
            combo: 1
        }, // Шаблон оформления, похоже на Smarty
        tpl: new Ext.XTemplate('' + '<tpl for="."><div class="identifyx-list-item">' + '<span><small>({id})</small> <b>{username}</b> ({fullname})</span>' + '</div></tpl>', {
                compiled: true
            }), // Какой элемент является селекторо. То есть, выбор будет при клике на этот элемент
        itemSelector: 'div.identifyx-list-item'
    });
    IdentifyX.combo.User.superclass.constructor.call(this, config);
};
Ext.extend(IdentifyX.combo.User, MODx.combo.ComboBox);
Ext.reg('identifyx-combo-user', IdentifyX.combo.User);
