define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'order/index',
                    add_url: 'order/add',
                    edit_url: 'order/edit',
                    del_url: 'order/del',
                    multi_url: 'order/multi',
                    table: 'order',
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
                        {field: 'ordernum', title: __('Ordernum')},
                        {field: 'userid', title: __('Userid')},
                        {field: 'money', title: __('Money'), operate:'BETWEEN'},
                        {field: 'accountmoney', title: __('Accountmoney'), operate:'BETWEEN'},
                        {field: 'porderid', title: __('Porderid')},
                        {field: 'pordernum', title: __('Pordernum')},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'paytype', title: __('Paytype'), searchList: {"weixin":__('Paytype weixin'),"alipay":__('Paytype alipay')}, formatter: Table.api.formatter.normal},
                        {field: 'orderstate', title: __('Orderstate'), searchList: {"0":__('Orderstate 0'),"1":__('Orderstate 1'),"4":__('Orderstate 4'),"3":__('Orderstate 3')}, formatter: Table.api.formatter.normal},
                        {field: 'paysn', title: __('Paysn')},
                        {field: 'paytime', title: __('Paytime'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'rate', title: __('Rate'), operate:'BETWEEN'},
                        {field: 'landid', title: __('Landid')},
                        {field: 'pordernumid', title: __('Pordernumid')},
                        {field: 'payfrom', title: __('Payfrom')},
                        {field: 'describe', title: __('Describe')},
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