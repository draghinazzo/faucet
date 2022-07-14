<!DOCTYPE html>
<html>
   <head>
   </head>
   <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
   <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

   <body>
    <div id="app">
        {{ info }}
    </div>
   </body>
   <script>
   var app = new Vue({
    el: '#app',
    data: {
        info: null
    },
    mounted () {
        /*
        axios
        .get('http://faucetcoin.ezyro.com/post.php')
        .then(response => {
          this.info = response.data
        })
        .catch((e)=>{
            console.log(e)
        })
        */
        let post = {
            cartera: "aaaaa111",
            fechaCreacion: "2022-07-07"
        };
        let data = new FormData();
        data.append('cartera', "libicocco")
        axios
        .post('pay.php', data)
        .then(response => {
          axios
            .get('post.php')
            .then(response => {
            this.info = response.data
            })
            .catch((e)=>{
                console.log(e)
            })
        })
        .catch((e)=>{
            console.log(e)
        })

    }
    })
   </script>
</html>