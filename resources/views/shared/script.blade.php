<style type="text/css">
    .wrap {height: 100%; }
    .chat { 
        height: 40vh;
        overflow-y: auto}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.15.3/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.2.1/vue.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/3.7.0/firebase.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script>

<script>

  // Initialize Firebase
    var user = {!! $user !!};
    console.log(user);
    var config = {
        apiKey: "AIzaSyCUp1xkrl0u7yxcJKj8avFvciBtbXRngwU",
        authDomain: "my-firebase-b7a0b.firebaseapp.com",
        databaseURL: "https://my-firebase-b7a0b.firebaseio.com",
        storageBucket: "my-firebase-b7a0b.appspot.com",
        messagingSenderId: "381134740430"
    };
    
    firebase.initializeApp(config);

    var database = firebase.database().ref('chats');//.push();
    
    function writeData(text) {
      database.push({
        text: text,
        timestamp: Date.now(),
        user: user
      });
    };
    
    function toBottom() {
        document.querySelector('.chat').scrollTop = 1000;
    }
    
    new Vue({
        el: '#app',
        data: {
            chatMessages: [],
            txt: ''
        },
        mounted: function() {
            var self = this;
            var now = Date.now();
            database.on('child_added', function(data) {
                console.log(data.key, data.val(), moment(data.timestamp).fromNow());
                console.log(now, data.val().timestamp)
                if (now < data.val().timestamp) {
                    self.chatMessages.push(data.val());
                    // document.querySelector('.chat').scrollTop = 1000;
                    // self.$el.querySelector('.chat').scrollTop = 
                }
              setTimeout(function() {
                toBottom();
              }, 0)
            });
        },
        template: `
            <div class="wrap">
                <div class="row chat">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="media" v-for="chat in chatMessages">
                          <div class="media-left">
                            <a href="#">
                              <img class="media-object" v-bind:src="chat.user.image" alt="...">
                            </a>
                          </div>
                          <div class="media-body">
                            <div>
                                <span class="label label-primary">@{{chat.user.email}}:</span>
                                <span class="label label-info">@{{moment(chat.timestamp).fromNow()}}</span>
                            </div>
                            <h4>@{{chat.text}}</h4>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <form @submit.prevent="send()" >
                            <div class="input-group">
                              <input type="text" class="form-control" placeholder="Type here..." v-model="txt">
                              <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">Send</button>
                              </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        `,
        methods: {
            send: function() {
                console.log('send');
                let txt = this.txt.trim();
                console.log(this.txt.trim());
                if (txt) {
                    // send it
                    writeData(txt);
                    this.txt = '';
                }
            }
        }
    })
</script>
