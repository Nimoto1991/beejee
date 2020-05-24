$(document).ready(function () {

    Vue.component("authform", {
        data: function () {
            return {
                errors: [],
                admin: []
            }
        },
        props: [
            "adminJson"
        ],
        created: function () {
            this.admin = this.adminJson;
        },
        methods: {
            auth: function (e) {
                e.stopPropagation();
                var login = $("#login").val();
                var password = $("#password").val();
                var _this = this;

                $.post("/?r=admin&a=login", {login: login, password: password}, function (response) {
                    if (response.errors) {
                        _this.errors = response.errors;
                    } else {
                        window.location.href = "/";
                    }
                }, "JSON");
            }
        },
        template: "<div><form v-if=\"!this.admin.login\" class=\"text-center border border-light\" action=\"/?r=admin&a=login\">\n" +
            "                <div class=\"form-row\">\n" +
            "                    <!-- Login -->\n" +
            "                    <div class=\"col-md-4\">\n" +
            "                        <input type=\"login\" id=\"login\" class=\"form-control mb-1\" placeholder=\"Login\">" +
            "                        <span  v-show=\"this.errors.login\" class=\"badge badge-danger\"> {{ this.errors.login }}</span>\n" +
            "                    </div>\n" +
            "                    <!-- Password -->\n" +
            "                    <div class=\"col-md-4\">\n" +
            "                        <input type=\"password\" id=\"password\" class=\"form-control mb-1\" placeholder=\"Password\">\n" +
            "                        <span  v-show=\"this.errors.password\" class=\"badge badge-danger\"> {{ this.errors.password }}</span>\n" +
            "                    </div>\n" +
            "                    <!-- Sign in button -->\n" +
            "                    <div class=\"col-md-4\">\n" +
            "                        <a href='#'  v-on:click=\"auth\" class=\"btn btn-info btn-block\">Sign in</a>\n" +
            "                    </div>\n" +
            "                </div>\n" +
            "\n" +
            "            </form><div v-if=\"this.admin.login\">Hello, {{this.admin.login}} <a href='/?r=admin&a=logout'>Logout</div></div>"
    });

    Vue.component("task", {
        data: function () {
            return {
                isEdit: false
            }
        },
        props: [
            "task", "admin"
        ],
        methods: {
            markAsCompleted: function () {
                var _this = this;
                $.post("/?r=task&a=complete", {taskId: _this.task.id}, function (response) {
                    if (response.success) {
                        _this.task.status = 1;
                    } else {
                        var errors = "";
                        for (var field in response.errors) {
                            errors += response.errors[field] + "\n";
                        }
                        alert(errors);
                    }
                }, "JSON");
            },
            changeDescription: function (el) {
                this.task.description = $(el).val();
            },
            saveDescription: function () {
                var _this = this;
                $.post("/?r=task&a=update", {
                    taskId: _this.task.id,
                    description: _this.task.description
                }, function (response) {
                    if (response.success) {
                        _this.isEdit = false;
                        _this.task.changed = true;
                    } else {
                        var errors = "";
                        for (var field in response.errors) {
                            errors += response.errors[field] + "\n";
                        }
                        alert(errors);
                    }
                }, "JSON");
            },
            setIsEdit: function () {
                this.isEdit = true;
            }
        },
        template: "<div class=\"card col-md-3 col-sm-6 col-xs-12\">\n" +
            "  <div class=\"card-body\">\n" +
            "    <h5 class=\"card-title\">User Name: {{ task.user_name }}, User Email: {{ task.user_email }}</h5>\n" +
            "    <p class=\"card-text\">Task: {{ task.description }} <a v-on:click='setIsEdit' v-if='this.admin.login'><svg class=\"bi bi-pen\" width=\"1em\" height=\"1em\" viewBox=\"0 0 16 16\" fill=\"currentColor\" xmlns=\"http://www.w3.org/2000/svg\">\n" +
            "  <path fill-rule=\"evenodd\" d=\"M5.707 13.707a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391L10.086 2.5a2 2 0 0 1 2.828 0l.586.586a2 2 0 0 1 0 2.828l-7.793 7.793zM3 11l7.793-7.793a1 1 0 0 1 1.414 0l.586.586a1 1 0 0 1 0 1.414L5 13l-3 1 1-3z\"/>\n" +
            "  <path fill-rule=\"evenodd\" d=\"M9.854 2.56a.5.5 0 0 0-.708 0L5.854 5.855a.5.5 0 0 1-.708-.708L8.44 1.854a1.5 1.5 0 0 1 2.122 0l.293.292a.5.5 0 0 1-.707.708l-.293-.293z\"/>\n" +
            "  <path d=\"M13.293 1.207a1 1 0 0 1 1.414 0l.03.03a1 1 0 0 1 .03 1.383L13.5 4 12 2.5l1.293-1.293z\"/>\n" +
            "</svg></a></p>\n" +
            "    <textarea v-if='this.isEdit' v-on:change='changeDescription(this)' v-model='task.description'></textarea>\n" +
            "    <a v-on:click='saveDescription' class=\"btn btn-success d-block mb-1\" v-if='this.isEdit'>Save</a>\n" +
            "    <span v-if=\"this.task.status\" class=\"d-block\">Completed</span>\n" +
            "    <a v-if=\"!this.task.status && this.admin.login\" v-on:click='markAsCompleted' class=\"btn btn-success d-block\">Complete</a>\n" +
            "    <span v-if=\"!this.task.status && !this.admin.login\"  class=\"d-block\">Uncompleted</span>\n" +
            "    <span v-if=\"this.task.changed\"  class=\"d-block\">Task was changed by admin</span>\n" +
            "  </div>\n" +
            "</div>"
    });

    Vue.component("task-form", {
        inject: ['addTask'],
        data: function () {
            return {
                errors: []
            }
        },
        props: [
            "page"
        ],
        methods: {
            add: function (e) {
                e.stopPropagation();
                var name = $("#name").val();
                var email = $("#email").val();
                var description = $("#description").val();
                var _this = this;

                $.post("/?r=task&a=add", {name: name, email: email, description: description}, function (response) {
                    if (response.success) {
                        _this.errors = [];
                        response.task.description = description;
                        if (_this.page == 1) {
                            _this.addTask(response.task);
                            alert("Task was succesufully added");
                        } else {
                            if (!alert("Task was succesufully added")) {
                                window.location.href = "/";
                            }
                        }
                    } else {
                        _this.errors = response.errors;
                    }
                }, "JSON");
            }
        },
        created: function () {
            if (this.page == 0) {
                this.page = 1;
            }
        },
        template: "<!-- Default form contact -->\n" +
            "<form class=\"text-center border border-light card col-md-3 col-sm-6 col-xs-12\" action=\"#!\">\n" +
            "\n" +
            "    <p class=\"h4 mb-4\">Add a task</p>\n" +
            "\n" +
            "    <!-- Name -->\n" +
            "                        <span  v-show=\"this.errors.name\" class=\"badge badge-danger\"> {{ this.errors.name }}</span>\n" +
            "    <input type=\"text\" id=\"name\" class=\"form-control mb-4\" placeholder=\"Name\">\n" +
            "\n" +
            "    <!-- Email -->\n" +
            "                        <span  v-show=\"this.errors.email\" class=\"badge badge-danger\"> {{ this.errors.email }}</span>\n" +
            "    <input type=\"text\" id=\"email\" class=\"form-control mb-4\" placeholder=\"E-mail\">\n" +
            "    <!-- Message -->\n" +
            "                        <span  v-show=\"this.errors.description\" class=\"badge badge-danger\"> {{ this.errors.description }}</span>\n" +
            "    <div class=\"form-group\">\n" +
            "        <textarea class=\"form-control rounded-0\" id=\"description\" rows=\"3\" placeholder=\"Message\"></textarea>\n" +
            "    </div>\n" +
            "    <!-- Send button -->\n" +
            "    <a href='#'  v-on:click=\"add\" class=\"btn btn-info btn-block\">Add</a>\n" +
            "\n" +
            "</form>\n" +
            "<!-- Default form contact -->"
    });

    Vue.component("pagination", {
        data: function () {
            return {
                pages: [],
                pageCount: 0
            }
        },
        props: [
            "page", "count", "itemsPerPage"
        ],
        created: function () {
            if (this.page == 0) {
                this.page = 1;
            }
            this.pageCount = Math.ceil(this.count / this.itemsPerPage);
            for (var i = 0; i < this.pageCount; i++) {
                var pageNum = i + 1;
                this.pages[i] = {
                    pageNum: pageNum,
                    active: (pageNum == this.page),
                    href: this.getHref(pageNum)
                };
            }
        },
        methods: {
            getHref: function (pageNum) {
                var location = window.location.href;
                location = location.replace(/[&]{0,1}page=([0-9]+)/i, "");
                var request = "page=" + pageNum;
                if (location.indexOf("?") !== -1) {
                    return location + "&" + request;
                }
                return "?" + request;
            }
        },
        template: "<nav class='nav justify-content-center grey lighten-4 py-4'>\n" +
            "  <ul class=\"pagination pg-blue\">\n" +
            "    <li v-for='pageData in this.pages' class=\"page-item\" v-bind:class='{active: pageData.active}'>\n" +
            "      <a :href='pageData.href' class=\"page-link\"> {{ pageData.pageNum }}</a>\n" +
            "    </li>\n" +
            "  </ul>\n" +
            "</nav>"
    });

    Vue.component("sort", {
        props: [
            "orderBy", "orderDir"
        ],
        methods: {
            isActive: function (field, dir) {
                return this.orderBy == field && this.orderDir == dir;
            }
        },
        template: "<ul class=\"nav justify-content-center grey lighten-4 py-4\">\n" +
            "  <li class=\"nav-item\">\n" +
            "    <a class=\"nav-link\" v-bind:class=\"{disabled: isActive('user_name', 'asc')}\" href=\"/?field=user_name&dir=asc\">Sort By Username (A-z)</a>\n" +
            "  </li>\n" +
            "  <li class=\"nav-item\">\n" +
            "    <a class=\"nav-link\" v-bind:class=\"{disabled: isActive('user_name', 'desc')}\" href=\"/?field=user_name&dir=desc\">Sort By Username (Z-a)</a>\n" +
            "  </li>\n" +
            "  <li class=\"nav-item\">\n" +
            "    <a class=\"nav-link\" v-bind:class=\"{disabled: isActive('status', 'asc')}\" href=\"/?field=status&dir=asc\">Sort By Status (asc)</a>\n" +
            "  </li>\n" +
            "  <li class=\"nav-item\">\n" +
            "    <a class=\"nav-link\" v-bind:class=\"{disabled: isActive('status', 'desc')}\" href=\"/?field=status&dir=desc\">Sort By Status (desc)</a>\n" +
            "  </li>\n" +
            "  <li class=\"nav-item\">\n" +
            "    <a class=\"nav-link\" v-bind:class=\"{disabled: isActive('user_email', 'asc')}\" href=\"/?field=user_email&dir=asc\">Sort By Email (A-z)</a>\n" +
            "  </li>\n" +
            "  <li class=\"nav-item\">\n" +
            "    <a class=\"nav-link\" v-bind:class=\"{disabled: isActive('user_email', 'desc')}\" href=\"/?field=user_email&dir=desc\">Sort By Email (z-A)</a>\n" +
            "  </li>\n" +
            "</ul>"
    });

    Vue.component("task-list", {
        data: function () {
            return {
                taskList: []
            }
        },
        props: [
            "taskListJson", "admin", "page"
        ],
        provide: function () {
            return {
                addTask: this.addTask
            }
        },
        created: function () {
            this.taskList = this.taskListJson;
        },
        methods: {
            addTask: function (task) {
                this.taskList[2] = this.taskList[1];
                this.taskList[1] = this.taskList[0];
                this.taskList[0] = task;
                this.$forceUpdate();
            }
        },
        template: "<div class='container'><div class='row'><task-form :page='page'></task-form><task v-for=\"task in this.taskList\" :task='task' :admin='admin'></div></div>"
    });


    new Vue({
        el: "#app"
    });


});