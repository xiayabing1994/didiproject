define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'porder/index',
                    add_url: 'porder/add',
                    edit_url: 'porder/edit',
                    del_url: 'porder/del',
                    multi_url: 'porder/multi',
                    table: 'porder',
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
                        {field: 'userid', title: __('Userid')},
                        {field: 'sumarea', title: __('Sumarea'), operate:'BETWEEN'},
                        {field: 'isleader', title: __('Isleader'), searchList: {"0":__('Isleader 0'),"1":__('Isleader 1')}, formatter: Table.api.formatter.normal},
                        {field: 'state', title: __('State'), searchList: {"1":__('State 1'),"2":__('State 2'),"3":__('State 3'),"4":__('State 4')}, formatter: Table.api.formatter.normal},
                        {field: 'pname', title: __('Pname')},
                        {field: 'starttime', title: __('Starttime'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'endtime', title: __('Endtime'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'addtime', title: __('Addtime'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'finishtime', title: __('Finishtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'hasland', title: __('Hasland'), operate:'BETWEEN'},
                        {field: 'price', title: __('Price'), operate:'BETWEEN'},
                        {field: 'groupid', title: __('Groupid')},
                        {
                            field: 'buttons',
                            width: "120px",
                            title: __('拼单操作'),
                            table: table,
                            events: Table.api.events.operate,
                            buttons: [
                                {
                                    name: 'detail',
                                    text: __('分配'),
                                    title: __('分配飞行员'),
                                    classname: 'btn btn-xs btn-primary btn-dialog',
                                    icon: 'fa fa-blind',
                                    url: 'porder/allot/id/{ids}',
                                    callback: function (data) {
                                        Layer.alert("接收到回传数据：" + JSON.stringify(data), {title: "回传数据"});
                                    },
                                    visible: function (row) {
                                        //返回true时按钮显示,返回false隐藏
                                        return true;
                                    }
                                },
                                {
                                    name: 'ajax',
                                    text: __('完单'),
                                    title: __('完单'),
                                    classname: 'btn btn-xs btn-success btn-magic btn-ajax',
                                    icon: 'fa fa-circle-thin',
                                    url: '/api/porder/finish/id/{ids}',
                                    confirm: '确认完单',
                                    success: function (data, ret) {
                                        console.log(data, ret);
                                        alert(data);
                                        // Layer.alert(ret.errcode,{title:'回传数据',icon:6});
                                        //如果需要阻止成功提示，则必须使用return false;
                                        return false;
                                    },
                                    error: function (data, ret) {
                                        console.log(data, ret);
                                        Layer.alert(ret.msg,{title:'回传数据'});
                                        return false;
                                    }
                                },
                            ],
                            formatter: Table.api.formatter.buttons
                        },
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