define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'pilot/index',
                    add_url: 'pilot/add',
                    edit_url: 'pilot/edit',
                    del_url: 'pilot/del',
                    multi_url: 'pilot/multi',
                    table: 'pilot',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'device_no', title: __('Device_no')},
                        {field: 'comment', title: __('Comment')},
                        {field: 'is_effect', title: __('Is_effect'), searchList: {"1":__('Is_effect 1'),"0":__('Is_effect 0')}, formatter: Table.api.formatter.normal},
                        {field: 'allot_orders', title: __('Allot_orders')},
                        {field: 'pilot_name', title: __('Pilot_name')},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});