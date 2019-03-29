define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'price/index',
                    add_url: 'price/add',
                    edit_url: 'price/edit',
                    del_url: 'price/del',
                    multi_url: 'price/multi',
                    table: 'price',
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
                        {field: 'area', title: __('Area')},
                        {field: 'price', title: __('Price'), operate:'BETWEEN'},
                        {field: 'isdel', title: __('Isdel'), searchList: {"1":__('Isdel 1'),"0":__('Isdel 0')}, formatter: Table.api.formatter.normal},
                        {field: 'sort', title: __('Sort')},
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