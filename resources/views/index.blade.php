<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <!-- development version, includes helpful console warnings -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <!-- Resource Vue -->
    <script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.1"></script>
</head>
<body>
    <div id="app">
        <input type="text" v-model="newUser" id="text-input"><input type="button" value="add" v-on:click="add" v-show="!clicked"><input type="button" value="update" v-on:click="update" v-show="clicked">
        <ul class="list-name" v-for="(user,index) in users">
            <li>
                @{{ user.name }} <input type="button" value="edit" v-on:click="edit(user,index)"> || <input type="button" value="delete" v-on:click="del(user,index)">
            </li>
        </ul>
    </div>
    
    <script>
        new Vue({
            el:'#app',
            data:{
                users: [],
                newUser: "",
                clicked: false,
                idx: 0,
                selectedUser: {},
            },
            methods: {
                add() {
                    let name = this.newUser.trim()
                    if(name){
                        this.$http.post('/api/add', {name: name}).then(response => {
                            this.users.unshift({
                                'name': name,
                            })
                        });
                    }
                    this.newUser = ''
                },
                update() {
                    let nameEdit = this.newUser.trim()
                    if(nameEdit){
                        this.$http.post('/api/update/'+this.selectedUser.id, {name: nameEdit}).then(response => {
                            this.users.splice(this.idx,1,{
                                'name': nameEdit,
                            })
                        });
                    }
                    this.newUser = ''
                },
                edit(user,idx) {
                    this.newUser = this.users[idx].name
                    this.selectedUser = user
                    this.idx = idx
                    this.clicked = true
                },
                del(user,idx) {
                    let conf = confirm('Anda yakin?')
                    if(conf) {
                        this.$http.post('/api/delete/'+user.id).then(response => {
                            this.users.splice(idx, 1)
                        });
                    }
                },
            },
            mounted: function() {
                this.$http.get('/api/user').then(response => {
                    let result = response.body.data
                    this.users = result
                });
            }
        });
    </script>
</body>
</html>