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
                        {field: 'order_no', title: __('Order_no')},
                        {field: 'out_no', title: __('Out_no')},
                        {field: 'userid', title: __('Userid')},
                        {field: 'money', title: __('Money'), operate:'BETWEEN'},
                        {field: 'paymoney', title: __('Paymoney'), operate:'BETWEEN'},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'paytype', title: __('Paytype'), searchList: {"weixin":__('Paytype weixin'),"alipay":__('Paytype alipay')}, formatter: Table.api.formatter.normal},
                        {field: 'paystate', title: __('Paystate'), searchList: {"0":__('Paystate 0'),"1":__('Paystate 1'),"4":__('Paystate 4'),"3":__('Paystate 3')}, formatter: Table.api.formatter.normal},
                        {field: 'paytime', title: __('Paytime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'pordernumid', title: __('Pordernumid')},
                        {field: 'describe', title: __('Describe')},
                        {field: 'pay_account',title:__('Pay_account')},
                        {field: 'ordertype', title: __('Ordertype'), searchList: {"sub":__('Ordertype sub'),"final":__('Ordertype final'),"direct":__('Ordertype direct')}, formatter: Table.api.formatter.normal},
                        {field: 'isdeal', title: __('Isdeal'), searchList: {"0":__('Isdeal 0'),"1":__('Isdeal 1')}, formatter: Table.api.formatter.normal},
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